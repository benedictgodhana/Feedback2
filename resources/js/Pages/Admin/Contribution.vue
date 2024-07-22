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
                <v-card-title style="background-color: darkblue;color:white" class="text-center">My Contribution History</v-card-title>
                <br>
                <v-card-text>
                            <v-row>
                                <v-col cols="12" md="4">
                                    <v-text-field
                                        v-model="search"
                                        prepend-inner-icon="mdi-magnify"
                                        label="Search"
                                        single-line
                                        variant="outlined"
                                        hide-details
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-select
                                        v-model="selectedFilter"
                                        :items="filters"
                                        label="Filter by"
                                        variant="outlined"
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-btn @click="downloadCSV" style="text-transform: capitalize;" color="green" >
                                        <v-icon>mdi-download</v-icon>Download Report
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <v-table>
                                <thead style="background-color: darkblue; color: white;">
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount(Ksh)</th>
                                        <th>Transaction code</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in filteredItems" :key="index">
                                        <td>{{ formatDate(item.date) }}</td>
                                        <td>{{ item.description }}</td>
                                        <td>{{ item.amount }}</td>
                                        <td>{{ item.code }}</td>
                                        <td>
                                            <v-btn class="action-button" icon elevation="0" @click="viewDetails(item)">
                                                <v-icon>mdi-eye</v-icon>
                                            </v-btn>
                                        </td>
                                    </tr>
                                </tbody>
                            </v-table>
                            <div class="text-center mt-6">
                                <v-pagination
                                    v-model="page"
                                    :length="4"
                                    next-icon="mdi-menu-right"
                                    prev-icon="mdi-menu-left"
                                    rounded
                                    elevation="0"
                                ></v-pagination>
                            </div>
                        </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>


      <v-dialog v-model="dialog" max-width="600px">
            <v-card>
                <v-toolbar style="background-color:darkblue;color:white ;">
                    <v-toolbar-title >Contribution Details</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn icon dark v-bind="attrs" v-on="on" @click="dialog = false"  style="background-color:white;">
                                <v-icon color="black">mdi-close</v-icon>
                            </v-btn>
                        </template>
                        <span>Close</span>
                    </v-tooltip>
                </v-toolbar>
                <v-card-text>
                    <p><strong>Date:</strong> {{ formatDate(selectedItem.date) }}</p>
                    <br>
                    <hr>
                    <p class="mt-3"><strong>Description:</strong> {{ selectedItem.description }}</p>
                    <br>
                    <hr>
                    <p class="mt-3"><strong>Amount:</strong> {{ selectedItem.amount }}</p>
                    <br>
                    <hr>
                    <p class="mt-3"><strong>Transaction Code:</strong> {{ selectedItem.code }}</p>
                    <br>
                    <hr class="mt-3">

                    <v-btn style="background-color:darkblue;color:white;text-transform:capitalize;" class="mt-6" width="100%" @click="dialog = false" >Close</v-btn>

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
    { text: 'My Contribution', routeName: 'my_contribution', icon: 'mdi-cash' },
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
