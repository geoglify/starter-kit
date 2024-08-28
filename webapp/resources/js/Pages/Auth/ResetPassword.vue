<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Reset Password" />

        <form @submit.prevent="submit">

            <v-text-field v-model="form.email" label="Email" required variant="outlined" class="mt-4"
                autocomplete="username" :error-messages="form.errors.email"></v-text-field>

            <v-text-field v-model="form.password" label="Password" required variant="outlined" class="mt-4"
                autocomplete="new-password" type="password" :error-messages="form.errors.password"></v-text-field>

            <v-text-field v-model="form.password_confirmation" label="Confirm Password" outlined required
                variant="outlined" class="mt-4" autocomplete="new-password" type="password"
                :error-messages="form.errors.password_confirmation"></v-text-field>

            <div class="flex items-center justify-end mt-4">

                <v-btn :class="{ 'opacity-25': form.processing }" :readonly="form.processing" @click="submit"
                    color="gray" elevation="0">
                    Register
                </v-btn>

            </div>
        </form>
    </GuestLayout>
</template>
