<script setup>
import Map from '@/Components/Map.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Dashboard', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto" style="height: 830px">
            <Map></Map>
        </v-card>

    </AuthenticatedLayout>
</template>
