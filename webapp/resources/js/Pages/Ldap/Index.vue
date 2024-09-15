<script>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
    components: {
        AuthenticatedLayout,
        Head
    },
    data() {
        return {
            search: '',
            page: 1,
            itemsPerPage: 10,
            totalItems: 0,
            loading: false,
            serverItems: [],

            // Headers for the data table
            headers: [
                { title: 'Name', key: 'name', align: 'start', sortable: false },
                { title: 'Username', key: 'username', align: 'start', sortable: false },
                { title: 'Email', key: 'email', align: 'start', sortable: false },
                { title: 'Telephone', key: 'telephonenumber', align: 'start', sortable: false },
                { title: '', key: 'actions', align: 'end', sortable: false },
            ]
        };
    },
    methods:
    {
        // Method to load items
        loadItems({ page, itemsPerPage, search }) {

            // Set loading to true
            this.loading = true;

            // Fetch items from the server
            fetch(route('ldap.list'), {
                method: "post",
                body: JSON.stringify({
                    page: page,
                    itemsPerPage: itemsPerPage,
                    search: search
                })
            }).then((response) => {
                return response.json()
            }).then((data) => {
                this.serverItems = data.items;
                this.totalItems = data.total;
                this.page = data.currentPage;
                this.loading = false;
            }).catch(() => {
                // Failed to fetch data from the server
                this.loading = false;
                this.serverItems = [];
                this.totalItems = 0;
                this.page = 1;
            });
        },

        // Method to add user from LDAP
        addUserFromLdap(item) {
            // Import user from LDAP
            fetch(route('ldap.add'), {
                method: "post",
                body: JSON.stringify({
                    name: item.name,
                    email: item.email,
                })
            }).then((response) => {
                return response.json()
            }).then(() => {
                // User imported successfully and reload the items
                this.loadItems({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                    search: this.search
                });
            }).catch(() => {
                // Failed to import user
                this.loadItems({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                    search: this.search
                });
            });
        },

        // Method remove user from local
        removeUserFromLocal(item) {
            // Remove user from local
            fetch(route('ldap.remove'), {
                method: "post",
                body: JSON.stringify({
                    email: item.email,
                })
            }).then((response) => {
                return response.json()
            }).then(() => {
                // User imported successfully and reload the items
                this.loadItems({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                    search: this.search
                });
            }).catch(() => {
                // Failed to import user
                this.loadItems({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                    search: this.search
                });
            });
        }
    }
};
</script>

<template>

    <Head title="Import Users" />

    <AuthenticatedLayout>
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Users', disabled: false, href: route('users.index') },
                { title: 'Import', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6 my-6" title="Import Users"
            subtitle="Select the users LDAP you want to import">
            <v-card-text>

                <v-text-field v-model="search" label="Search" prepend-inner-icon="mdi-magnify" variant="outlined"
                    hide-details single-line></v-text-field>

                <v-data-table-server v-model:items-per-page="itemsPerPage" :headers="headers" :items="serverItems"
                    :items-length="totalItems" :loading="loading" :search="search" @update:options="loadItems">

                    <template v-slot:item.actions="{ item }">

                        <v-btn color="success" class="mr-2" variant="text" v-if="item.is_imported" icon="mdi-check"
                            density="comfortable" @click="removeUserFromLocal(item)"></v-btn>

                        <v-btn color="black" class="mr-2" variant="text" icon="mdi-account-plus" density="comfortable"
                            @click="addUserFromLdap(item)" v-if="!item.is_imported"></v-btn>

                    </template>

                </v-data-table-server>

            </v-card-text>
        </v-card>
    </AuthenticatedLayout>

</template>