<script setup>
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="font-weight-black">Delete Account</h2>

            <p class="mt-1 text-sm text-gray-400">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
                your account, please download any data or information that you wish to retain.
            </p>

        </header>

        <v-btn @click="confirmUserDeletion" color="red" elevation="0">Delete Account</v-btn>

        <v-dialog v-model="confirmingUserDeletion" width="500">
            <v-card>
                <v-card-title class="pt-4">
                    <span class="headline px-3">Are you sure you want to delete your account?</span>
                </v-card-title>

                <v-card-text>
                    <v-alert class="mb-4">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Please
                        enter your password to confirm you would like to permanently delete your account.
                    </v-alert>

                    <v-text-field v-model="form.password" label="Password" outlined dense required variant="outlined"
                        autocomplete="current-password" type="password"
                        :error-messages="form.errors.password"></v-text-field>
                </v-card-text>

                <v-card-actions>
                    <v-btn @click="closeModal" color="grey">Cancel</v-btn>
                    <v-btn @click="deleteUser" color="red">Delete Account</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </section>
</template>
