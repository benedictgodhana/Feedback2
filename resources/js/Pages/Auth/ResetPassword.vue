<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { VTextField, VBtn, VForm, VContainer, VRow, VCol } from 'vuetify/components';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
        <Head title="Reset Password" />

        <v-container class="d-flex justify-center align-center min-vh-100">


            <v-card max-width="500" width="100%" elevation="0" class="mt-16">
                <v-img
                src="/Images/University-Logo-Vertical-01.png"
                contain
                max-width="200"
                class="mx-auto mt-4"
            ></v-img>
                <v-card-text>
                    <v-form @submit.prevent="submit">
                        <v-text-field
                            v-model="form.email"
                            label="Email"
                            type="email"
                            required
                            autofocus
                            :error-messages="form.errors.email"
                            autocomplete="username"
                            class="mt-1"
                            variant="underlined"
                        ></v-text-field>

                        <v-text-field
                            v-model="form.password"
                            label="Password"
                            type="password"
                            required
                            :error-messages="form.errors.password"
                            autocomplete="new-password"
                            class="mt-4"
                            variant="underlined"

                        ></v-text-field>

                        <v-text-field
                            v-model="form.password_confirmation"
                            label="Confirm Password"
                            type="password"
                            required
                            :error-messages="form.errors.password_confirmation"
                            autocomplete="new-password"
                            class="mt-4"
                            variant="underlined"

                        ></v-text-field>

                        <div class="flex justify-end mt-4">
                            <v-btn :disabled="form.processing" type="submit" style="background-color: darkblue;color:white;text-transform: capitalize;" width="100%">
                                Reset Password
                            </v-btn>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>

        </v-container>
</template>
<style>

.min-vh-100 {
    min-height: 100vh;
}

</style>
