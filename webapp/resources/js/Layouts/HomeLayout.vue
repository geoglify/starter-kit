<template>
    <v-responsive class="border rounded w-full h-full">
        <v-app>
            <v-app-bar title="Geoglify Starter Kit" class="px-3">
                <v-spacer></v-spacer>

                <v-btn prepend-icon="mdi-login" text="Login" slim href="/login">
                </v-btn>
            </v-app-bar>

            <v-main>
                <v-container class="w-full h-full pa-0 ma-0 container_main">
                    <slot />
                </v-container>
            </v-main>
        </v-app>
    </v-responsive>
</template>

<style>
.container_main {
    max-width: 100% !important;
}
</style>