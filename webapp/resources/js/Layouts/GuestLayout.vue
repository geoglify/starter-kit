<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-700">
        <div>
            <ApplicationLogo class="w-20 h-20 fill-current text-gray-200" />
        </div>

        <v-card class="w-full sm:max-w-md mt-6 px-6 py-4">
            <v-card-title class="text-lg text-center font-semibold text-gray-900">
                <slot name="title">Geoglify Starter Kit</slot>
            </v-card-title>
            <slot />
        </v-card>
    </div>
</template>
