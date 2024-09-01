<script>
export default {
    data() {
        return {
            menubar: false,
        };
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
    }
};
</script>
<template>
    <v-responsive class="border rounded w-full h-full">
        <v-app>
            <v-app-bar title="Geoglify Starter Kit" elevation="0">

                <template #prepend>
                    <v-app-bar-nav-icon @click.prevent="menubar = !menubar"></v-app-bar-nav-icon>
                </template>

                <template #append>
                    <v-btn class="mr-5">

                        {{ $page.props.auth.user.name }}

                        <v-menu activator="parent">
                            <v-list>
                                <v-list-item link title="Profile" :href="route('profile.edit')" />
                                <v-list-item link title="Logout" @click="logout" />
                            </v-list>
                        </v-menu>
                    </v-btn>

                </template>

            </v-app-bar>

            <v-system-bar>
                <slot name="breadcrumbs" />
                <v-spacer></v-spacer>
            </v-system-bar>

            <v-navigation-drawer v-if="menubar">
                <v-list>
                    <v-list-item title="Users" :href="route()"></v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-main>
                <v-container>
                    <slot />
                </v-container>
            </v-main>
        </v-app>
    </v-responsive>
</template>
