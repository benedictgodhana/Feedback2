<template>
    <!-- Navigation Drawer for Small Screens -->
    <v-navigation-drawer
      v-model="drawer"
      app
      temporary
      right
      disable-resize-watcher
      color="orange"
    >
      <v-list nav>
        <v-list-item>
            <v-img src="/Images/iLab white Logo-01.png" height="180"  ></v-img>

        </v-list-item>
<hr>

        <v-divider></v-divider>
        <v-list-item  prepend-icon="mdi-email" :href="route('feedback')">
          <v-list-item-title>Give Feedback</v-list-item-title>
        </v-list-item>
        <v-list-item  prepend-icon="mdi-login" :href="route('login')">
          <v-list-item-title>Login</v-list-item-title>
        </v-list-item>

      </v-list>
    </v-navigation-drawer>

    <!-- App Bar -->
    <v-app-bar app  dark flat style="background-color: darkblue" elevation="0">

      <v-container>
        <v-row>

          <!-- Left Section -->
         <v-spacer></v-spacer>

          <!-- Right Section -->
          <v-col cols="12" sm="6" class="d-flex justify-end">
            <v-btn text color="white" class="hidden-md-and-up" @click="drawer = !drawer">
              <v-icon>mdi-menu</v-icon>
            </v-btn>


            <v-btn icon class="hidden-sm-and-down">
              <v-icon color="white">mdi-help-circle-outline</v-icon>
            </v-btn>
            <v-btn icon class="hidden-sm-and-down">
              <v-icon  color="white">mdi-magnify</v-icon>
            </v-btn>
            <v-btn icon class="hidden-sm-and-down" href="https://ilabafrica.strathmore.edu/">
              <v-icon  color="white">mdi-web</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-app-bar>

    <!-- Additional Navigation Bar -->
    <v-app-bar app color="orange" flat dense class="hidden-sm-and-down" height="90" elevation="5">
      <v-container>
        <v-row>
            <v-img src="/Images/LOGO_2.png" height="120"  ></v-img>

          <v-spacer></v-spacer>
          <v-col class="mt-6">
            <v-btn text :href="route('feedback')" style="text-transform: capitalize;font-weight: 800;background-color: darkblue;color:white" class="mr-4">Give feedback</v-btn>
            <v-btn text :href="route('login')" style="text-transform: capitalize;font-size: 800;background-color: darkblue;color:white" >Login</v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-app-bar>
  </template>
<script setup>
import { ref } from 'vue';
import {
  VAppBar,
  VBtn,
  VIcon,
  VContainer,
  VRow,
  VCol,
  VImg,
  VNavigationDrawer,
  VList,
  VListItem,
  VListItemTitle,
  VDivider
} from 'vuetify/components';

const drawer = ref(false);
</script>
<style scoped>
.logo {
  max-width: 250px;
}

.v-app-bar {
  box-shadow: none;
}

.hidden-sm-and-down {
  display: none;
}

@media (min-width: 600px) {
  .hidden-sm-and-down {
    display: inline-flex;
  }
}

.hidden-md-and-up {
  display: inline-flex;
}

@media (min-width: 960px) {
  .hidden-md-and-up {
    display: none;
  }
}
</style>
