<template>
    <nav class="bg-gray-800 p-6 fixed w-full top-0 left-0 z-10 elevation-0" style="background-color: darkblue;">
      <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <v-img
          src="/Images/iLab white Logo-01.png"
          class="logo"
        ></v-img>

        <div class="flex items-center">
          <Link :href="route('feedback')" class="ms-4 nav-link" style="text-decoration: none;font-weight: 900;text-transform:none;color:white">
             Give feedback
          </Link>

          <template v-if="props.canLogin">
            <Link v-if="props.auth.user" :href="route('dashboard')" class="ms-4" style="text-decoration: none;font-weight: 900;text-transform: uppercase;">
              Dashboard
            </Link>
            <template v-else>
              <!-- <v-btn v-if="props.canRegister" :href="route('register')" class="btn ms-4" style="text-transform: capitalize; color:black; background-color:orangered;">
                <v-icon size="19">mdi-account-plus</v-icon> Register
              </v-btn> -->
              <Link :href="route('login')" class="ms-4 nav-link" style="text-decoration: none;font-weight: 900;text-transform:none;color:white">
                 Log in
              </Link>
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
    max-width: 10px;
    height: auto;
  }


  .nav-link {
    color: white;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    transition: color 0.3s;
  }

  .nav-link:hover {
    color: #ffb74d; /* Light orange color */
  }

  </style>
