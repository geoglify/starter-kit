<script setup>
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const createUser = () => {
    form.post(route('users.store'), {
        onSuccess: () => form.reset(),
    });
};

</script>

<template>

    <Head title="Create User" />

    <AuthenticatedLayout>
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Users', disabled: false, href: route('users.index') },
                { title: 'Create', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6 my-6" title="Create User" subtitle="Create a new user">
            <v-card-text>
                <v-form @submit.prevent="createUser">
                    <v-text-field v-model="form.name" label="Name" outlined dense required variant="outlined" />
                    <v-text-field v-model="form.email" label="Email" outlined dense required variant="outlined" />
                    <v-text-field v-model="form.password" label="Password" outlined dense required variant="outlined" />
                    <v-text-field v-model="form.password_confirmation" label="Confirm Password" outlined dense required variant="outlined" />
                    <v-btn type="submit" color="black" variant="tonal" class="mt-4">Create</v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </AuthenticatedLayout>

</template>