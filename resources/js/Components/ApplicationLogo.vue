<template>
    <div class="logo-container">
      <img :src="logoSrc" alt="Logo" class="logo" />
    </div>
  </template>

  <script setup>
  const logoSrc = '/Images/University-Logo-Vertical-01.png'; // Replace with the path to your logo image
  </script>

  <style scoped>
  .logo-container {
    display: flex;
    align-items: center;
  }

  .logo {
    height: 140px; /* Adjust as needed */
    width: auto;
    margin-top: 40px;
  }
  </style>
