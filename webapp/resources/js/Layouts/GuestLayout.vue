<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-yellow-400">

        <v-card class="w-full sm:max-w-md mt-6 px-6 py-4">
            <v-card-title class="font-weight-black text-h3 text-center">
                Geoglify
            </v-card-title>
            <slot />
        </v-card>
    </div>
</template>
