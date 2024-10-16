<script>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
  watch: {
  },
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
                { title: 'Email', key: 'email', align: 'start', sortable: false },
                { title: '', key: 'tag', align: 'start', sortable: false },
                { title: '', key: 'actions', align: 'end', sortable: false },
            ],

            deleteModalOpen: false,
            deleteId: null

        };
    },
    methods:
    {
        // Method to load items
        loadItems({ page, itemsPerPage, search }) {

            // Set loading to true
            this.loading = true;

            // Fetch items from the server
            fetch(route('users.list'), {
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
                this.loading = false;
            }).catch(() => {
                // Failed to fetch data from the server
                this.loading = false;
                this.serverItems = [];
                this.totalItems = 0;
            });
        },

        // Method to delete a user
        openDeleteModal(id) {
            this.deleteId = id;
            this.deleteModalOpen = true;
        },

        // Method to close the modal
        closeModal() {
            this.deleteId = null;
            this.deleteModalOpen = false;
        },

        // Method to delete the user
        async deleteUser() {
            // Close the modal
            this.deleteModalOpen = false;

            // Delete the user
            await fetch(route('users.destroy', this.deleteId), {
                method: "DELETE",
            }).then(() => {
                // Reload the items
                this.loadItems({ page: this.page, itemsPerPage: this.itemsPerPage, search: this.search });
            });
        }
    }
};
</script>

<template>

    <Head title="Users" />

    <AuthenticatedLayout>
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Users', disabled: true }
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6" title="Users" subtitle="List of users">

            <template v-slot:append>
                <v-btn color="primary" variant="flat" :href="route('users.create')" class="ml-2">Create</v-btn>
                <v-btn color="black" variant="flat" :href="route('ldap.index')" class="ml-2">Import</v-btn>
            </template>


            <v-card-text>

                <v-text-field v-model="search" label="Search" prepend-inner-icon="mdi-magnify" variant="outlined"
                    hide-details single-line></v-text-field>

                <v-data-table-server v-model:items-per-page="itemsPerPage" :headers="headers" :items="serverItems"
                    :items-length="totalItems" :loading="loading" :search="search" @update:options="loadItems">

                    <template v-slot:item.tag="{ item }">
                        <v-chip v-if="item.is_ldap" color="black" size="small" label style="width: 60px">LDAP</v-chip>
                        <v-chip v-else color="primary" size="small" label style="width: 60px">LOCAL</v-chip>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <v-btn color="black" class="ml-2" variant="text" density="comfortable" icon
                            :href="route('users.edit', item.id)">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn color="red" class="ml-2" variant="text" density="comfortable" icon
                            @click="openDeleteModal(item.id)">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </template>

                </v-data-table-server>

            </v-card-text>
        </v-card>

        <v-dialog v-model="deleteModalOpen" width="500">
            <v-card>
                <v-card-title class="pt-4">
                    <span class="headline px-3">Are you sure you want to delete this account?</span>
                </v-card-title>

                <v-card-text>
                    <v-alert class="mb-4">
                        Once this account is deleted, all of its resources and data will be permanently deleted.
                    </v-alert>

                </v-card-text>

                <v-card-actions>
                    <v-btn @click="closeModal" color="grey">Cancel</v-btn>
                    <v-btn @click="deleteUser" color="red" class="mr-2">Delete</v-btn>
                </v-card-actions>

            </v-card>
        </v-dialog>

    </AuthenticatedLayout>

</template>