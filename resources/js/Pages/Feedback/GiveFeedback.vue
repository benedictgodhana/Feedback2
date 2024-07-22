<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { VContainer, VRow, VCol, VTextField, VSelect, VBtn, VAlert, VCard, VCardTitle, VCardText, VCardActions, VToolbar, VImg } from 'vuetify/components';

const categories = ref([
    { text: 'Category 1', value: 1 },
    { text: 'Category 2', value: 2 },
    // Add more categories as needed
]);

const subcategories = ref([
    { text: 'Subcategory 1', value: 1 },
    { text: 'Subcategory 2', value: 2 },
    // Add more subcategories as needed
]);

const form = useForm({
    category_id: null,
    subject: '',
    subcategory_id: null,
    name: '',
    email: '',
    feedback: '',
});

const submitFeedback = () => {
    form.post(route('feedback.store'), {
        onFinish: (event) => {
            const response = event.detail.jetstream.response;
            if (response && response.status === 'success') {
                // Handle successful feedback submission
                console.log('Feedback submitted successfully');
            } else {
                // Handle unsuccessful feedback submission
                console.error('Feedback submission unsuccessful');
            }
        },
    });
};
</script>

<template>
    <v-container class="d-flex justify-center align-center min-vh-100">
        <Head title="Give Feedback" />

        <v-card max-width="900" width="100%" class="elevation-0 feedback-card">
            <!-- Logo -->
            <a href="/"> <v-img
                src="/Images/University-Logo-Vertical-01.png"
                contain
                max-width="200"
                class="mx-auto mt-4"
            ></v-img></a>

            <v-card-text>

                <v-card-title class="text-center" style="background-color: darkblue;color:white">Give Feedback</v-card-title>

                <br>

                <form @submit.prevent="submitFeedback">
                    <v-row>
                        <v-col >
                            <v-select
                                label="Category"
                                v-model="form.category_id"
                                :items="categories"
                                required
                                variant="outlined"
                                :error-messages="form.errors.category_id"
                                prepend-inner-icon="mdi-format-list-bulleted"
                            ></v-select>
                        </v-col>

                        <v-col>
                            <v-select
                                label="Subcategory"
                                v-model="form.subcategory_id"
                                :items="subcategories"
                                required
                                variant="outlined"
                                :error-messages="form.errors.subcategory_id"
                                prepend-inner-icon="mdi-format-list-bulleted"
                            ></v-select>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Subject"
                                v-model="form.subject"
                                required
                                variant="outlined"
                                :error-messages="form.errors.subject"
                                prepend-inner-icon="mdi-subject"
                            ></v-text-field>
                        </v-col>
                    </v-row>



                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Name"
                                v-model="form.name"
                                required
                                variant="outlined"
                                :error-messages="form.errors.name"
                                prepend-inner-icon="mdi-account"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Email"
                                type="email"
                                v-model="form.email"
                                required
                                variant="outlined"
                                :error-messages="form.errors.email"
                                prepend-inner-icon="mdi-email"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Feedback"
                                v-model="form.feedback"
                                required
                                variant="outlined"
                                :error-messages="form.errors.feedback"
                                prepend-inner-icon="mdi-message"
                                multiline
                                rows="5"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-card-actions class="d-flex justify-end mt-4">
                        <v-btn
                            color="white"
                            :loading="form.processing"
                            @click="submitFeedback"
                            width="100%"
                            class="feedback-button"
                        >
                            Submit Feedback <v-icon>mdi-send</v-icon>
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

.feedback-card {
    border-radius: 5px;
}

.feedback-button {
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
