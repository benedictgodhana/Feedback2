<template>
    <Head title="Dashboard" />
    <AdminLayout>
      <v-container width="100%" style="max-width: 1600px;">
        <v-row>
          <!-- Profile Card Section -->
          <v-col cols="12" md="3" class="mb-4 ">
  <v-card class="profile-card" elevation="0" style="border: 1px solid #e0e0e0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <v-card-text class="text-center py-4">
      <v-avatar size="200">
        <img src="/Images/ben.jpg" alt="User Avatar" height="250">


      </v-avatar>
      <v-card-text style="font-weight: 800;font-size: 19px;">
        {{ $page.props.auth.user.name }}
      </v-card-text>
      <v-divider></v-divider>
      <div class="mt-3">
        <v-divider></v-divider>
        <v-list class="mt-10">
          <v-list-item v-for="(item, i) in links" :key="i">
            <NavLink :href="item.routeName" class="v-list-item" style="color: black;">
              <template v-slot:default="{ href, isActive, isExactActive, isLink }">
                <v-list-item-icon v-if="item.icon" class="list-item-icon">
                  <v-icon :icon="item.icon" style="color:darkblue"></v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title :class="{ 'primary--text': isExactActive }" v-text="item.text"></v-list-item-title>
                </v-list-item-content>
              </template>
            </NavLink>
          </v-list-item>
        </v-list>
      </div>
    </v-card-text>
  </v-card>
</v-col>


          <!-- Form Section -->
          <v-col cols="12" md="9">
            <v-card>
    <v-tabs
      v-model="tab"
      style="background-color: darkblue;color:white"
    >
      <v-tab value="one" style="text-transform: capitalize">Personal Information</v-tab>

    </v-tabs>

    <v-card-text>
      <v-tabs-window v-model="tab">
        <v-tabs-window-item value="one">
  <v-card class="pa-6" elevation="0">
    <v-card-title style="background-color: darkblue; color:white">Personal Information</v-card-title>
    <v-card-text class="mt-5">
      Update your account's profile information and email address.
    </v-card-text>
    <v-card-text>
      <v-form>
        <v-row>
          <v-col cols="12" md="4">
            <v-text-field
              label="Name"
              v-model="user.name"
              readonly
              variant="underlined"
              prepend-inner-icon="mdi-account"
            ></v-text-field>
          </v-col>

          <v-col cols="12" md="4">
            <v-text-field
              label="Email"
              type="email"
              v-model="user.email"
              readonly
              variant="underlined"
              prepend-inner-icon="mdi-email"
            ></v-text-field>
          </v-col>

        </v-row>

        <div class="flex items-center gap-4 mt-6">
          <v-btn :loading="user.processing" type="submit" width="100%" style="background-color: orange; color:white; text-transform: capitalize;">
            Save <v-icon size="16" left>mdi-content-save</v-icon>
          </v-btn>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</v-tabs-window-item>


        <v-tabs-window-item value="four">
  <v-card class="pa-6" elevation="0">
    <v-card-title style="background-color: darkblue; color: white">
      Location
    </v-card-title>
    <v-card-text class="mt-5">
      Update your location information.
    </v-card-text>
    <v-card-text>
      <v-form>
        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              label="Current Address"
              v-model="userProfile.currentAddress"
              readonly
              variant="underlined"
              prepend-inner-icon="mdi-map-marker-outline"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Residence"
              v-model="userProfile.residence"
              readonly
              variant="underlined"
              prepend-inner-icon="mdi-home-city-outline"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Postal Address"
              v-model="userProfile.postalAddress"
              readonly
              variant="underlined"
              prepend-inner-icon="mdi-postage-stamp"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Home District"
              v-model="userProfile.homeDistrict"
              readonly
              variant="underlined"
              prepend-inner-icon="mdi-map"
            ></v-text-field>
          </v-col>
        </v-row>
        <div class="flex items-center gap-4 mt-6">
          <v-btn :loading="user.processing" type="submit" width="100%" style="background-color:orange; color:white; text-transform: capitalize;">
            Save <v-icon size="16" left>mdi-content-save</v-icon>
          </v-btn>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</v-tabs-window-item>

      </v-tabs-window>
    </v-card-text>
  </v-card>
          </v-col>
        </v-row>
      </v-container>

      <!-- Other sections of your dashboard -->
      <!-- ... -->

      <!-- View Details Dialog -->
      <v-dialog v-model="dialog" max-width="600px">
        <v-card>
          <v-toolbar style="background-color: darkblue; color: white;">
            <v-toolbar-title>Contribution Details</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-tooltip top>
              <template v-slot:activator="{ on, attrs }">
                <v-btn icon dark v-bind="attrs" v-on="on" @click="dialog = false" style="background-color: white;">
                  <v-icon color="black">mdi-close</v-icon>
                </v-btn>
              </template>
              <span>Close</span>
            </v-tooltip>
          </v-toolbar>
          <v-card-text>
            <p><strong>Date:</strong> {{ formatDate(selectedItem.date) }}</p>
            <hr>
            <p><strong>Description:</strong> {{ selectedItem.description }}</p>
            <hr>
            <p><strong>Amount:</strong> {{ selectedItem.amount }}</p>
            <hr>
            <p><strong>Transaction Code:</strong> {{ selectedItem.code }}</p>
            <v-btn color="primary" class="mt-6" @click="dialog = false">Close</v-btn>
          </v-card-text>
        </v-card>
      </v-dialog>
    </AdminLayout>
  </template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale } from 'chart.js';
import AccessControl from '@/Components/AccessControl.vue';
import NavLink from '@/Components/NavLink.vue';





const links = [
    { text: 'My Profile', routeName: 'profile', icon: 'mdi-account' },
    // { text: 'My Contribution', routeName: 'my_contribution', icon: 'mdi-cash' },
    { text: 'Notifications', routeName: 'my_notifications', icon: 'mdi-bell' },
    { text: 'My Settings', routeName: 'my_settings', icon: 'mdi-cog' }
  ];

const search = ref('');
const selectedFilter = ref(null);
const filters = ['All', 'Option 1', 'Option 2'];
const tab =ref(0)
const user = usePage().props.auth.user;
const userProfile = user ? user.userProfile || {} : {};
const contributions = user ? user.contributions || [] : [];

const items = ref(contributions);

const filteredItems = computed(() => {
  return items.value.filter((item) => {
    const matchesFilter = !selectedFilter.value || selectedFilter.value === 'All' || item.description.includes(selectedFilter.value);
    const matchesSearch = !search.value || item.description.toLowerCase().includes(search.value.toLowerCase());
    return matchesFilter && matchesSearch;
  });
});

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return date.toLocaleDateString('en-US', options);
};

const userInitials = computed(() => {
  const nameParts = user.name.split(' ');
  if (nameParts.length >= 2) {
    const firstNameInitial = nameParts[0].charAt(0).toUpperCase();
    const lastNameInitial = nameParts[1].charAt(0).toUpperCase();
    return firstNameInitial + lastNameInitial;
  } else {
    return user.name.charAt(0).toUpperCase() + (user.name.charAt(1) || '').toUpperCase();
  }
});

const downloadCSV = () => {
  const csvContent = 'data:text/csv;charset=utf-8,' + items.value.map(e => Object.values(e).join(',')).join('\n');
  const encodedUri = encodeURI(csvContent);
  const link = document.createElement('a');
  link.setAttribute('href', encodedUri);
  link.setAttribute('download', 'table_data.csv');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const totalAmount = computed(() => {
  return items.value.reduce((sum, item) => sum + parseFloat(item.amount.replace(/[^0-9.-]+/g,"")), 0).toFixed(0);
});

const dialog = ref(false);
const selectedItem = ref({});

const viewDetails = (item) => {
  selectedItem.value = item;
  dialog.value = true;
};
</script>


  <style scoped>
  .profile-card {
    background-color: white;
    padding: 16px;
    border-radius: 8px;
  }

  .total-amount {
    font-size: 24px;
    font-weight: bold;
    color: darkblue;
  }

  .recent-activities-title {
    margin-top: 12px;
    font-size: 16px;
    color: gray;
  }

  .form-card {
    margin-top: 20px;
  }
  </style>
