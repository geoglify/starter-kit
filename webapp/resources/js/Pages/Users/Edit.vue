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
    role_id: props.user.roles && props.user.roles[0] ? props.user.roles[0].id : null,
    is_ldap: props.user.is_ldap,
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

        <v-card class="max-w-7xl mx-auto pa-6" title="Edit User" subtitle="Edit user details">
            <v-card-text>
                <v-form @submit.prevent="updateUser">

                    <v-alert v-if="form.is_ldap" color="black" variant="tonal" class="mb-5">
                        This user is imported from LDAP. You can't change the email and password.
                        Only role can be changed.
                    </v-alert>

                    <v-text-field v-model="form.name" label="Name" required variant="outlined"
                        :error-messages="form.errors.name" :disabled="form.is_ldap" />

                    <v-text-field v-model="form.email" label="Email" required variant="outlined"
                        :error-messages="form.errors.email" autocomplete="new-email" :disabled="form.is_ldap" />

                    <v-text-field v-model="form.password" label="Password" variant="outlined"
                        :error-messages="form.errors.password" type="password" autocomplete="new-password"
                        :disabled="form.is_ldap" />

                    <v-text-field v-model="form.password_confirmation" label="Confirm Password" variant="outlined"
                        :error-messages="form.errors.password_confirmation" type="password" autocomplete="new-password"
                        :disabled="form.is_ldap" />

                    <v-select v-model="form.role_id" label="Role" required variant="outlined" :items="props.roles"
                        item-value="id" item-title="title" :error-messages="form.errors.role_id"></v-select>

                    <v-btn :href="route('users.index')" color="red" variant="flat" class="mr-2">Cancel</v-btn>
                    <v-btn type="submit" color="primary" variant="flat">Update</v-btn>

                </v-form>
            </v-card-text>
        </v-card>
    </AuthenticatedLayout>
</template>