<!-- resources/js/Components/AccessControl.vue -->
<template>
    <div v-if="hasAccess">
      <slot></slot>
    </div>
  </template>

  <script setup>
  import { computed } from 'vue';
  import { usePage } from '@inertiajs/vue3';

  const props = defineProps({
    role: String,
    permission: String,
  });

  const page = usePage();
  const user = page.props.auth.user || {};
  const userRoles = user.roles || [];
  const userPermissions = user.permissions || [];

  const hasAccess = computed(() => {
    if (props.role) {
      return userRoles.includes(props.role);
    }
    if (props.permission) {
      return userPermissions.includes(props.permission);
    }
    return false;
  });
  </script>
