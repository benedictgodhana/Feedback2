<template>
    <v-container>
      <h1>Users</h1>

      <!-- Display user information -->
      <v-card>
        <v-card-title>User Information</v-card-title>
        <v-card-text>
          <p>Name: {{ auth.user.name }}</p>
          <p>Email: {{ auth.user.email }}</p>
          <p>Roles: {{ auth.user.roles.join(', ') }}</p>
          <p>Permissions: {{ auth.user.permissions.join(', ') }}</p>
        </v-card-text>
      </v-card>

      <!-- Example of handling errors -->
      <v-alert v-if="errors.length" type="error">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </v-alert>
    </v-container>
  </template>

  <script setup>
  import { ref } from 'vue';

  // Props received from Inertia
  const { errors, auth } = $props;
  </script>
