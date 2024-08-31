<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Confirm Password" />

        <v-alert class="mb-4">
            This is a secure area of the application. Please confirm your password before continuing.
        </v-alert>

        <form @submit.prevent="submit">
            <div>

                <v-text-field id="password" type="password" v-model="form.password" required
                    autocomplete="current-password" autofocus label="Password"></v-text-field>
            </div>

            <div class="flex justify-end mt-4">
                <v-button class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm
                </v-button>
            </div>
        </form>
    </GuestLayout>
</template>
