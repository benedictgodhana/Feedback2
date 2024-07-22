<script setup>
import { ref, watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { VTextField, VBtn, VCard, VCardTitle, VCardText, VContainer, VRow, VCol, VSnackbar, VAlert, VForm, VIcon } from 'vuetify/components';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const userProfile = user ? user.userProfile || {} : {};


// Initialize the form with all the required fields
const form = useForm({
    name: user.name || '',
    email: user.email || '',
    password: '',
    password_confirmation: '',
    surname: userProfile.surname || '',
    otherNames: userProfile.otherNames || '',
    dept: userProfile.dept || '',
    employmentType: userProfile.employmentType || '',
    employeeNo: userProfile.employeeNo || '',
    dateOfBirth: userProfile.dateOfBirth || '',
    sex: userProfile.sex || '',
    religion: userProfile.religion || '',
    telR: userProfile.telR || '',
    telCell: userProfile.telCell || '',
    currentAddress: userProfile.currentAddress || '',
    residence: userProfile.residence || '',
    postalAddress: userProfile.postalAddress || '',
    homeDistrict: userProfile.homeDistrict || '',
    fatherName: userProfile.fatherName || '',
    fatherDOB: userProfile.fatherDOB || '',
    fatherOccupation: userProfile.fatherOccupation || '',
    motherName: userProfile.motherName || '',
    motherDOB: userProfile.motherDOB || '',
    motherOccupation: userProfile.motherOccupation || '',
    maritalStatus: userProfile.maritalStatus || '',
    spouseName: userProfile.spouseName || '',
    dateOfMarriage: userProfile.dateOfMarriage || '',
    spouseTel: userProfile.spouseTel || '',
    children: userProfile.children || [{ name: '', dob: '' }],
    siblings: userProfile.siblings || [],
});

const snackbar = ref(false);
const snackbarMessage = ref('');

watch(() => form.recentlySuccessful, (newVal) => {
    if (newVal) {
        snackbarMessage.value = 'Profile updated successfully!';
        snackbar.value = true;
    }
});

watch(() => status, (newVal) => {
    if (newVal === 'verification-link-sent') {
        snackbarMessage.value = 'A new verification link has been sent to your email address.';
        snackbar.value = true;
    }
});
</script>


<template>
    <v-container>
        <v-card class="pa-6" elevation="0">
            <v-card-title style="background-color: darkblue;color:white">Profile Information</v-card-title>
            <v-card-text class="mt-5">
                Update your account's profile information and email address.
            </v-card-text>
            <v-card-text>
                <v-form @submit.prevent="form.patch(route('profile.update'))" class="mt-1">
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Name"
                                v-model="form.name"
                                :error-messages="form.errors.name"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Surname"
                                v-model="form.surname"
                                :error-messages="form.errors.surname"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Other Names"
                                v-model="form.otherNames"
                                :error-messages="form.errors.otherNames"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Email"
                                type="email"
                                v-model="form.email"
                                :error-messages="form.errors.email"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Department"
                                v-model="form.dept"
                                :error-messages="form.errors.dept"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Employment Type"
                                v-model="form.employmentType"
                                :error-messages="form.errors.employmentType"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>

                    </v-row>
                    <v-row>

                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Employee No"
                                v-model="form.employeeNo"
                                :error-messages="form.errors.employeeNo"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Date of Birth"
                                v-model="form.dateOfBirth"
                                :error-messages="form.errors.dateOfBirth"
                                type="date"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Sex"
                                v-model="form.sex"
                                :error-messages="form.errors.sex"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>

                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Religion"
                                v-model="form.religion"
                                :error-messages="form.errors.religion"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Telephone (Residence)"
                                v-model="form.telR"
                                :error-messages="form.errors.telR"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Cell Phone"
                                v-model="form.telCell"
                                :error-messages="form.errors.telCell"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Current Address"
                                v-model="form.currentAddress"
                                :error-messages="form.errors.currentAddress"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Residence"
                                v-model="form.residence"
                                :error-messages="form.errors.residence"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Postal Address"
                                v-model="form.postalAddress"
                                :error-messages="form.errors.postalAddress"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Home District"
                                v-model="form.homeDistrict"
                                :error-messages="form.errors.homeDistrict"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>

                    </v-row>
                    <v-row>

                    </v-row>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Father's Name"
                                v-model="form.fatherName"
                                :error-messages="form.errors.fatherName"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Father's Date of Birth"
                                v-model="form.fatherDOB"
                                :error-messages="form.errors.fatherDOB"
                                type="date"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Father's Occupation"
                                v-model="form.fatherOccupation"
                                :error-messages="form.errors.fatherOccupation"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Mother's Name"
                                v-model="form.motherName"
                                :error-messages="form.errors.motherName"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Mother's Date of Birth"
                                v-model="form.motherDOB"
                                :error-messages="form.errors.motherDOB"
                                type="date"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Mother's Occupation"
                                v-model="form.motherOccupation"
                                :error-messages="form.errors.motherOccupation"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Marital Status"
                                v-model="form.maritalStatus"
                                :error-messages="form.errors.maritalStatus"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Spouse's Name"
                                v-model="form.spouseName"
                                :error-messages="form.errors.spouseName"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Date of Marriage"
                                v-model="form.dateOfMarriage"
                                :error-messages="form.errors.dateOfMarriage"
                                type="date"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                label="Spouse's Telephone"
                                v-model="form.spouseTel"
                                :error-messages="form.errors.spouseTel"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <!-- <v-row v-for="(child, index) in form.children" :key="index">
                        <v-col cols="12" md="6">
                            <v-text-field
                                :label="'Child ' + (index + 1) + ' Name'"
                                v-model="child.name"
                                :error-messages="form.errors['children.' + index + '.name']"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                :label="'Child ' + (index + 1) + ' Date of Birth'"
                                v-model="child.dob"
                                :error-messages="form.errors['children.' + index + '.dob']"
                                type="date"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row v-for="(sibling, index) in form.siblings" :key="index">
                        <v-col cols="12" md="6">
                            <v-text-field
                                :label="'Sibling ' + (index + 1) + ' Name'"
                                v-model="sibling.name"
                                :error-messages="form.errors['siblings.' + index + '.name']"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                :label="'Sibling ' + (index + 1) + ' Date of Birth'"
                                v-model="sibling.dob"
                                :error-messages="form.errors['siblings.' + index + '.dob']"
                                type="date"
                                readonly
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row> -->

                    <v-row v-if="mustVerifyEmail && user.email_verified_at === null" class="mt-2">
                        <v-col cols="12">
                            <v-alert type="warning" dense>Your email address is unverified.</v-alert>
                            <v-btn text @click="form.post(route('verification.send'))">
                                Click here to re-send the verification email.
                            </v-btn>
                        </v-col>
                    </v-row>

                    <div class="flex items-center gap-4 mt-6">
                        <v-btn :loading="form.processing" type="submit" width="100%" style="background-color: darkblue;color:white;text-transform: capitalize;">
                            Save <v-icon size="16" left>mdi-content-save</v-icon>
                        </v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>

        <v-snackbar v-model="snackbar" timeout="3000">
            {{ snackbarMessage }}
            <template v-slot:action="{ attrs }">
                <v-btn color="red" text v-bind="attrs" @click="snackbar = false">Close</v-btn>
            </template>
        </v-snackbar>
    </v-container>
</template>
