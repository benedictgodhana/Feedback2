<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { VTextField, VBtn, VAlert } from 'vuetify/components';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <v-container>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Password</h2>
            <p class="mt-1 text-sm text-gray-600">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <v-text-field
                    v-model="form.current_password"
                    label="Current Password"
                    type="password"
                    :error-messages="form.errors.current_password"
                    ref="currentPasswordInput"
                    autocomplete="current-password"
                    variant="outlined"
                ></v-text-field>
            </div>

            <div>
                <v-text-field
                    v-model="form.password"
                    label="New Password"
                    type="password"
                    :error-messages="form.errors.password"
                    ref="passwordInput"
                    autocomplete="new-password"
                    variant="outlined"

                ></v-text-field>
            </div>

            <div>
                <v-text-field
                    v-model="form.password_confirmation"
                    label="Confirm Password"
                    type="password"
                    :error-messages="form.errors.password_confirmation"
                    autocomplete="new-password"
                    variant="outlined"

                ></v-text-field>
            </div>

            <div class="flex items-center gap-4">
                <v-btn
                    :loading="form.processing"
                    type="submit"
                    class="mr-4"
                    style="background-color: darkblue;color:white;text-transform: capitalize;"
                    width="100%"
                >
                    Save
                </v-btn>

                <transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <v-alert
                        v-if="form.recentlySuccessful"
                        type="success"
                        class="text-sm"
                        border="left"
                    >
                        Saved.
                    </v-alert>
                </transition>
            </div>
        </form>
    </section>
</v-container>
</template>

<style scoped>
.flex {
    display: flex;
    align-items: center;
    gap: 1rem;
}
</style>
