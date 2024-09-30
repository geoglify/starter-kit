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
                { title: 'Title', key: 'title', align: 'start', sortable: false },
                { title: 'Description', key: 'description', align: 'start', sortable: false },
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
            fetch(route('roles.list'), {
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

        // Method to delete a role
        openDeleteModal(id) {
            this.deleteId = id;
            this.deleteModalOpen = true;
        },

        // Method to close the modal
        closeModal() {
            this.deleteId = null;
            this.deleteModalOpen = false;
        },

        // Method to delete the role
        async deleteRole() {
            // Close the modal
            this.deleteModalOpen = false;

            // Delete the role
            await fetch(route('roles.destroy', this.deleteId), {
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

    <Head title="Roles" />

    <AuthenticatedLayout>
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Roles', disabled: true }
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6 my-6" title="Roles" subtitle="List of roles">

            <template v-slot:append>
                <v-btn color="primary" variant="flat" :href="route('roles.create')" class="ml-2">Create</v-btn>
            </template>


            <v-card-text>

                <v-text-field v-model="search" label="Search" prepend-inner-icon="mdi-magnify" variant="outlined"
                    hide-details single-line></v-text-field>

                <v-data-table-server v-model:items-per-page="itemsPerPage" :headers="headers" :items="serverItems"
                    :items-length="totalItems" :loading="loading" :search="search" @update:options="loadItems">

                    <template v-slot:item.tag="{ item }">
                        <v-chip v-if="item.is_ldap" color="blue" size="small">LDAP</v-chip>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <v-btn color="black" class="ml-2" variant="text" density="comfortable" icon
                            :href="route('roles.edit', item.id)" v-if="!item.is_ldap">
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
                    <span class="headline px-3">Are you sure you want to delete this role?</span>
                </v-card-title>

                <v-card-text>
                    <v-alert class="mb-4">
                        Once this role is deleted, all of its resources and data will be permanently deleted.
                    </v-alert>

                </v-card-text>

                <v-card-actions>
                    <v-btn @click="closeModal" color="grey">Cancel</v-btn>
                    <v-btn @click="deleteRole" color="red" class="mr-2">Delete</v-btn>
                </v-card-actions>

            </v-card>
        </v-dialog>

    </AuthenticatedLayout>

</template>