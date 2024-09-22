<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    role: Object,
    permissions: Object,
});

const form = useForm({
    title: props.role.title,
    description: props.role.description,
    permissions: props.permissions.map(permission => ({
        id: permission.id,
        description: permission.description,
        selected: props.role.permissions.find(p => p.id === permission.id) !== undefined,
    })),
});

const updateRole = () => {
    // Create a new list containing only the IDs of selected permissions without modifying form.permissions
    const selectedPermissions = form.permissions.filter(permission => permission.selected).map(permission => permission.id);

    // Submit form data, including selected permissions
    form.transform((data) => ({
        ...data,
        permissions: selectedPermissions
    })).put(route('roles.update', props.role.id), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>

    <Head title="Edit Role" />

    <AuthenticatedLayout>
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Roles', disabled: false, href: route('roles.index') },
                { title: 'Edit', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6 my-6" title="Edit Role" subtitle="Edit role details">
            <v-card-text>
                <v-form @submit.prevent="updateRole">
                    <v-text-field v-model="form.title" label="Name" outlined dense required variant="outlined"
                        :error-messages="form.errors.title" class="mb-4" />

                    <v-text-field v-model="form.description" label="Description" outlined dense required
                        variant="outlined" :error-messages="form.errors.description" class="mb-4" />

                    <v-card title="Permissions"
                        :subtitle="form.errors.permissions ? form.errors.permissions : 'Select permissions for the role'"
                        variant="outlined" :color="form.errors.permissions ? 'red' : ''"
                        :style="form.errors.permissions ? '' : 'border: 1px solid #6b728099'">
                        
                        <v-card-text>
                            <v-row dense>
                                <v-col v-for="permission in form.permissions" :key="permission.id" cols="12" md="3">
                                    <v-checkbox v-model="permission.selected" :label="permission.description"
                                        hide-details />
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>

                    <v-btn type="submit" color="black" variant="tonal" class="mt-4">Update</v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </AuthenticatedLayout>
</template>
