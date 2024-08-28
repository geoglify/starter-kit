<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>

        <Head title="Forgot Password" />

        <v-alert class="mb-5">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </v-alert>

        <form @submit.prevent="submit">
            <div>
                <v-text-field v-model="form.email" label="Email" outlined dense required autofocus variant="outlined"
                    autocomplete="username" :error-messages="form.errors.email"></v-text-field>
            </div>

            <div class="flex items-center justify-end mt-4">
                <v-btn :class="{ 'opacity-25': form.processing }" :readonly="form.processing" type="submit"
                    color="gray" elevation="0">
                    Reset
                </v-btn>
            </div>
        </form>
    </GuestLayout>
</template>
