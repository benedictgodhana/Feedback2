<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { VContainer, VRow, VCol, VTextField, VBtn, VAlert, VCard, VCardTitle, VCardText, VCardActions } from 'vuetify/components';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <v-container class="d-flex justify-center align-center min-vh-100">
        <Head title="Forgot Password" />

        <v-card max-width="500" width="100%" class="elevation-0 login-card">
           <a href="/"> <v-img
                src="/Images/University-Logo-Vertical-01.png"
                contain
                max-width="200"
                class="mx-auto mt-4"
            ></v-img></a>

            <v-card-title class="text-center">Forgot Password</v-card-title>

            <v-card-text>
                <div class="mb-4 text-sm text-gray-600">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset
                    link that will allow you to choose a new one.
                </div>

                <div v-if="status" class="mb-4">
                    <v-alert type="success" dismissible>
                        {{ status }}
                    </v-alert>
                </div>

                <form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Email"
                                v-model="form.email"
                                required
                                variant="underlined"
                                autofocus
                                autocomplete="username"
                                :error-messages="form.errors.email"
                                prepend-inner-icon="mdi-email"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-card-actions class="d-flex justify-end mt-4">
                        <v-btn
                            color="white"
                            :loading="form.processing"
                            @click="submit"
                            width="100%"
                            class="login-button"
                        >
                            Email Password Reset Link <v-icon>mdi-chevron-right</v-icon>
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<style>
.min-vh-100 {
    min-height: 100vh;
}

.login-card {
    border-radius: 5px;
}

.login-button {
    background-color: darkblue;
    color: white;
    font-weight: bold;
    text-transform: capitalize;
}

.v-card-title {
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
}
</style>
