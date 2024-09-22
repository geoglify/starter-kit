<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    roles: Array,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    roles: props.user.roles,
});

const updateUser = () => {
    form.put(route('users.update', props.user.id), {
        onSuccess: () => form.reset(),
    });
};

</script>

<template>

    <Head title="Edit User" />

    <AuthenticatedLayout>
        <template #breadcrumbs>
            <v-breadcrumbs :items="[
                { title: 'Home', disabled: false, href: '/' },
                { title: 'Users', disabled: false, href: route('users.index') },
                { title: 'Edit', disabled: true },
            ]" divider="/" />
        </template>

        <v-card class="max-w-7xl mx-auto pa-6 my-6" title="Edit User" subtitle="Edit user details">
            <v-card-text>
                <v-form @submit.prevent="updateUser">
                    
                    <v-text-field v-model="form.name" label="Name" outlined dense required variant="outlined" />
                    
                    <v-text-field v-model="form.email" label="Email" outlined dense required variant="outlined" />
                    
                    <v-text-field v-model="form.password" label="Password" outlined dense variant="outlined" />
                    
                    <v-text-field v-model="form.password_confirmation" label="Confirm Password" outlined dense variant="outlined" />
                    
                    <v-select v-model="form.roles" label="Role" outlined dense required variant="outlined" :items="props.roles" />  

                    <v-btn type="submit" color="black" variant="tonal" class="mt-4">Update</v-btn>

                </v-form>
            </v-card-text>
        </v-card>
    </AuthenticatedLayout>
</template>