<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>

    <Head title="Edit Task" />

    <AuthenticatedLayout>
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Tasks', disabled: false, href: route('tasks.index') },
                { title: 'Edit', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6 my-6" title="Edit Task" subtitle="Edit task details">
            <v-card-text>
               
            </v-card-text>
        </v-card>
    </AuthenticatedLayout>
</template>