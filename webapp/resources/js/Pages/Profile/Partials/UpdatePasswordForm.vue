<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="font-weight-black">Update Password</h2>

            <p class="mt-1 text-sm text-gray-400">
                Ensure your account is using a long, random password to stay secure.
            </p>

        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">

            <v-text-field v-model="form.current_password" ref="currentPasswordInput" label="Current Password" outlined
                dense required autofocus variant="outlined" autocomplete="current-password"
                :error-messages="form.errors.current_password"></v-text-field>

            <v-text-field v-model="form.password" ref="passwordInput" label="New Password" outlined dense required
                variant="outlined" autocomplete="new-password" type="password"
                :error-messages="form.errors.password"></v-text-field>

            <v-text-field v-model="form.password_confirmation" label="Confirm Password" outlined dense required
                variant="outlined" autocomplete="new-password" type="password"
                :error-messages="form.errors.password_confirmation"></v-text-field>

            <v-alert v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</v-alert>

            <v-btn :readonly="form.processing" @click="updatePassword" color="primary" elevation="0"  
                :disabled="form.processing">Save</v-btn>

        </form>
    </section>
</template>
