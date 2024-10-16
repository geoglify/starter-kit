<script setup>
import Map from '@/Components/Map.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <DashboardLayout>
        
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Dashboard', disabled: true },
            ]" divider="/" />
        </template>

        <Map></Map>

    </DashboardLayout>
</template>
