<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
});

const headers = [
    { title: 'ID', key: 'id', align: 'start' },
    { title: 'Name', key: 'name', align: 'start' },
    { title: 'Email', key: 'email', align: 'start' },
    { title: '', key: 'actions', sortable: false, align: 'end' },
];
</script>

<template>

    <Head title="Users" />

    <AuthenticatedLayout>

        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Users', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6 my-6" title="Users" subtitle="List of users">

            <template v-slot:append>
                <v-btn color="black" variant="tonal" :href="route('users.create')" class="ml-2">Create</v-btn>
                <v-btn color="black" variant="tonal" :href="route('users.import')" class="ml-2">Import</v-btn>
            </template>

            <v-card-text>

                <v-data-table :headers="headers" :items="users" item-key="id">
                    <template v-slot:item.actions="{ item }">
                        <v-btn color="black" class="mr-2" variant="text" icon="mdi-pencil" :href="route('users.edit', item.id)"></v-btn>
                        <v-btn color="red" class="mr-2" variant="text" icon="mdi-delete" :href="route('users.destroy', item.id)"></v-btn>
                    </template>
                </v-data-table>

            </v-card-text>

        </v-card>

    </AuthenticatedLayout>
</template>