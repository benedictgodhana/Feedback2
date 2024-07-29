<template>
    <nav class="bg-gray-800 p-6 fixed w-full top-0 left-0 z-10 elevation-1" style="background-color: darkblue;">
      <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <v-img
          src="/Images/logo.png"
          contain
          max-width="160"
          class="logo"
        ></v-img>

        <div class="flex items-center">
          <v-btn :href="route('feedback')" class="ms-4" style="text-transform:none; color:white; background-color:orangered;">
            <v-icon size="19">mdi-email</v-icon> Give feedback
          </v-btn>

          <template v-if="props.canLogin">
            <Link v-if="props.auth.user" :href="route('dashboard')" class="btn ms-4" style="text-transform: capitalize;">
              Dashboard
            </Link>
            <template v-else>
              <!-- <v-btn v-if="props.canRegister" :href="route('register')" class="btn ms-4" style="text-transform: capitalize; color:black; background-color:orangered;">
                <v-icon size="19">mdi-account-plus</v-icon> Register
              </v-btn> -->
              <v-btn :href="route('login')" class="ms-4" style="text-transform: capitalize; color:black;background-color: orange;" variant="outlined">
                <v-icon size="19">mdi-login</v-icon> Log in
              </v-btn>
            </template>
          </template>
        </div>
      </div>
    </nav>
  </template>

  <script setup>
  import { Link, usePage } from '@inertiajs/vue3';
  import { VImg, VBtn, VIcon } from 'vuetify/components';

  const { props } = usePage();
  const { canLogin, canRegister } = props;
  </script>

  <style scoped>
  .btn {
    @apply inline-block px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150;
  }

  .hidden-sm-and-down {
    @apply hidden sm:inline-block;
  }

  .ms-4 {
    margin-left: 1rem;
  }

  .logo {
    max-width: 150px; /* Adjust the size as needed */
    height: auto;
  }
  </style>
