<script>
export default {
    data() {
        return {
            menubar: false,
            menus: [
                { title: 'Users', icon: 'mdi-account', href: route('users.index') },
            ]
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
    <v-app>
        <v-app-bar title="Geoglify" elevation="0">

            <template #prepend>
                <v-app-bar-nav-icon @click.stop="menubar = !menubar"></v-app-bar-nav-icon>
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

        <v-navigation-drawer v-model="menubar" app :location="$vuetify.display.mobile ? 'bottom' : undefined" temporary>
            <v-list>
                <v-list-item v-for="menu in menus" :key="menu.title" link :href="menu.href" :title="menu.title">
                    <template v-slot:prepend>
                        <v-icon :icon="menu.icon"></v-icon>
                    </template>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <v-container>
                <slot />
            </v-container>
        </v-main>
    </v-app>
</template>
