<script setup>
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    permissions: Object
});

// Initialize form with empty title and all permissions set to unselected
const form = useForm({
    title: '',
    description: '',
    permissions: props.permissions.map(permission => ({
        id: permission.id,
        description: permission.description,
        selected: false, // No permissions selected by default
    })),
});

const createRole = () => {

    // Create a new list containing only the IDs of selected permissions without modifying form.permissions
    const selectedPermissions = form.permissions.filter(permission => permission.selected).map(permission => permission.id);

    // Submit form data, including selected permissions
    form.transform((data) => ({
        ...data,
        permissions: selectedPermissions
    })).post(route('roles.store'), {
        onSuccess: () => form.reset(), // Reset form on success
    });
};
</script>

<template>

    <Head title="Create Role" />

    <AuthenticatedLayout>
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Roles', disabled: false, href: route('roles.index') },
                { title: 'Create', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6 my-6" title="Create Role" subtitle="Create a new role">
            <v-card-text>
                <v-form @submit.prevent="createRole">

                    <v-text-field v-model="form.title" label="Name" outlined dense required variant="outlined"
                        :error-messages="form.errors.title" class="mb-4" />

                    <v-text-field v-model="form.description" label="Description" outlined dense required
                        variant="outlined" :error-messages="form.errors.description" class="mb-4" />

                    <v-card title="Permissions" :subtitle="form.errors.permissions ? form.errors.permissions : 'Select permissions for the role'" variant="outlined"
                         :color="form.errors.permissions ? 'red' : ''" :style="form.errors.permissions ? '' : 'border: 1px solid #6b728099'">
                        <v-card-text>
                            <v-row dense>
                                <v-col v-for="permission in form.permissions" :key="permission.id" cols="12" md="3">
                                    <v-checkbox v-model="permission.selected" :label="permission.description"
                                        hide-details />
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>

                    <v-btn type="submit" color="black" variant="tonal" class="mt-4">Create</v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </AuthenticatedLayout>

</template>
