<script setup>

import Map from '@/Components/Map.vue';
import WelcomeLayout from '@/Layouts/WelcomeLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>

    <Head title="Welcome" />

    <WelcomeLayout>
        <Map></Map>
    </WelcomeLayout>

</template>
