<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const submit = () => {
    form.patch(route('profile.update'), {
        onFinish: () => form.recentlySuccessful = true,
    });
};

</script>

<template>
    <section>
        <header>
            <h2 class="font-weight-black">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form class="mt-6 space-y-6">

            <v-text-field v-model="form.name" label="Name" required variant="outlined" class="mt-4" autocomplete="name"
                :error-messages="form.errors.name"></v-text-field>

            <v-text-field v-model="form.email" label="Email" required variant="outlined" class="mt-4"
                autocomplete="username" :error-messages="form.errors.email"></v-text-field>

            <v-alert v-if="mustVerifyEmail && user.email_verified_at === null"
                class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                Your email address is unverified.

                <v-btn variant="text" :href="route('verification.send')">
                    Click here to re-send the verification email.
                </v-btn>

                <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-400">
                    A new verification link has been sent to your email address.
                </div>

            </v-alert>

            <v-alert v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</v-alert>

            <v-btn :readonly="form.processing" @click.prevent="submit" color="primary" elevation="0" 
                :disabled="form.processing">Save</v-btn>
        </form>
    </section>
</template>
