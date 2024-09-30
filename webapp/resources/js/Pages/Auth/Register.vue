<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <v-alert class="mb-5">
            Already have an account? <a :href="route('login')" class="text-primary">Log in</a>
        </v-alert>

        <form>

            <v-text-field v-model="form.name" label="Name" required variant="outlined" class="mt-4" autocomplete="name"
                :error-messages="form.errors.name"></v-text-field>

            <v-text-field v-model="form.email" label="Email" required variant="outlined" class="mt-4"
                autocomplete="username" :error-messages="form.errors.email"></v-text-field>

            <v-text-field v-model="form.password" label="Password" required variant="outlined" class="mt-4"
                autocomplete="new-password" type="password" :error-messages="form.errors.password"></v-text-field>

            <v-text-field v-model="form.password_confirmation" label="Confirm Password" outlined required
                variant="outlined" class="mt-4" autocomplete="new-password" type="password"
                :error-messages="form.errors.password_confirmation"></v-text-field>

            <div class="flex items-center justify-end mt-4">

                <v-btn :href="route('login')" color="primary" variant="tonal" elevation="0">
                    Back to login
                </v-btn>

                <v-spacer></v-spacer>
                
                <v-btn :class="{ 'opacity-25': form.processing }" :readonly="form.processing" @click.prevent="submit"
                    color="primary" elevation="0" >
                    Register
                </v-btn>

            </div>
        </form>
    </GuestLayout>
</template>
