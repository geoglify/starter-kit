<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

</script>

<template>

    <Head title="Create Task" />

    <AuthenticatedLayout>
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Tasks', disabled: false, href: route('tasks.index') },
                { title: 'Create', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6 my-6" title="Create Task" subtitle="Create a new task">
            <v-card-text>
            </v-card-text>
        </v-card>
    </AuthenticatedLayout>

</template>