<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
      <v-container width="100%" style="max-width: 1600px;">
        <v-row>
          <!-- Profile Card Section -->
          <v-col cols="12" md="3" class="mb-4 ">
  <v-card class="profile-card" elevation="0" style="border: 1px solid #e0e0e0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <v-card-text class="text-center py-4">
      <v-avatar size="200">
        <img src="/Images/ben.jpg" alt="User Avatar" height="250">
      </v-avatar>

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

<v-row>
          <!-- Form Section -->
          <v-col cols="12" md="" class="notification-list mt-4">
          <v-card rounded>
            <v-card-title style="background-color: darkblue; color: white;" class="text-center">
              Notifications
            </v-card-title>
            <v-card-text>
              <!-- Search and Filter -->
              <v-row>
                <v-col cols="12" md="6">
                    <br>
                  <v-text-field
                    v-model="search"
                    prepend-inner-icon="mdi-magnify"
                    label="Search"
                    single-line
                    variant="outlined"
                    hide-details
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <br>
                  <v-select
                    v-model="selectedFilter"
                    :items="filters"
                    label="Filter by"
                    variant="outlined"
                  ></v-select>
                </v-col>
              </v-row>
              <!-- Notification List -->
              <v-list>
                <v-list-item
                  v-for="(notification, index) in filteredNotifications"
                  :key="index"
                  @click="selectNotification(notification)"
                  :class="{ 'active-item': selectedNotification === notification }"
                >
                  <v-list-item-content>
                    <v-list-item-title>{{ notification.title }}</v-list-item-title>
                    <v-list-item-subtitle>{{ formatDate(notification.date) }}</v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>

        <!-- Notification Details Section -->
        <v-col cols="1" md="8"class=mt-4>
          <v-card v-if="selectedNotification">
            <v-card-title style="background-color: darkblue; color: white;">
              <v-btn icon @click="selectedNotification = null" style="color: black;">
                <v-icon color="orange">mdi-arrow-left</v-icon>
              </v-btn>
              <span class="ml-2">Notification Details</span>
            </v-card-title>
            <v-card-text>
                <br>
              <p><strong>Date:</strong> {{ formatDate(selectedNotification.date) }}</p>
              <br>
              <hr>
              <p class="mt-3"><strong>Subject:</strong> {{ selectedNotification.title }}</p>
              <br>
              <hr>
              <p class="mt-3"><strong>Content:</strong> {{ selectedNotification.content }}</p>
            </v-card-text>
          </v-card>
          <v-card v-else>
            <v-card-title style="background-color: darkblue; color: white; text-align: center;">
              Select a Notification
            </v-card-title>
            <v-card-text class="text-center">
              <p>Please select a notification from the list to view details.</p>
            </v-card-text>
          </v-card>
        </v-col>
    </v-row>
        </v-row>
      </v-container>

    </AuthenticatedLayout>
  </template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale } from 'chart.js';
import AccessControl from '@/Components/AccessControl.vue';
import NavLink from '@/Components/NavLink.vue';

import axiosInstance from '../plugins/api';

// Sample notifications
const notifications = ref([
  { date: '2024-07-01', title: 'Important Update', content: 'Your account settings have been updated.', type: 'Important' },
  { date: '2024-07-02', title: 'New Message', content: 'You have received a new message from John Doe.', type: 'Updates' },
  { date: '2024-07-03', title: 'Maintenance Notice', content: 'Scheduled maintenance will occur on July 5th.', type: 'Important' },
  { date: '2024-07-04', title: 'Weekly Digest', content: 'Here is your weekly digest of activities.', type: 'Updates' },
]);

const selectedNotification = ref(null);

const filteredNotifications = computed(() => {
  return notifications.value.filter((notification) => {
    const matchesFilter = !selectedFilter.value || selectedFilter.value === 'All' || notification.type === selectedFilter.value;
    const matchesSearch = !search.value || notification.title.toLowerCase().includes(search.value.toLowerCase());
    return matchesFilter && matchesSearch;
  });
});

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return date.toLocaleDateString('en-US', options);
};

const selectNotification = (notification) => {
  selectedNotification.value = notification;
};



const links = [
    { text: 'My Profile', routeName: 'dashboard', icon: 'mdi-account' },
    { text: 'My Contribution', routeName: 'contribution', icon: 'mdi-cash' },
    { text: 'Notifications', routeName: 'notifications', icon: 'mdi-bell' },
    { text: 'My Settings', routeName: 'settings', icon: 'mdi-cog' }
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
