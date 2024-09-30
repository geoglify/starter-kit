<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>

    <Head title="Profile" />

    <AuthenticatedLayout>

        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Profile', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6">
            <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
        </v-card>

        <v-card class="max-w-7xl mx-auto pa-6 mt-4" border>
            <UpdatePasswordForm />
        </v-card>

        <v-card class="max-w-7xl mx-auto pa-6 mt-4" border>
            <DeleteUserForm />
        </v-card>

    </AuthenticatedLayout>
</template>
