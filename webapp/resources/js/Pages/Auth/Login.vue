<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <form>

            <div class="mt-4">

                <v-text-field v-model="form.email" label="Email" outlined dense required autofocus variant="outlined"
                    autocomplete="username" :error-messages="form.errors.email"></v-text-field>

            </div>

            <div class="mt-4">

                <v-text-field v-model="form.password" label="Password" outlined dense required variant="outlined"
                    autocomplete="current-password" type="password"
                    :error-messages="form.errors.password"></v-text-field>

            </div>

            <div class="flex items-center justify-end mt-4">

                <v-btn color="primary" variant="tonal" :href="route('register')">
                    Register
                </v-btn>

                <v-spacer></v-spacer>
                
                <v-btn :class="{ 'opacity-25': form.processing }" :readonly="form.processing" @click.prevent="submit" color="primary" elevation="0">
                    Log in
                </v-btn>

            </div>

            <div class="flex items-center mt-4">
                <v-btn variant="text" :href="route('password.request')" block color="primary" class="text-body-2">
                    Forgot your password?
                </v-btn>
            </div>
        </form>
    </GuestLayout>
</template>
