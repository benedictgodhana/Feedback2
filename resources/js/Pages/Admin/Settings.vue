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
      <v-tab value="security" style="text-transform: capitalize">Security Settings</v-tab>
      <v-tab value="notifications" style="text-transform: capitalize">Notification Settings</v-tab>
      <v-tab value="privacy" style="text-transform: capitalize">Privacy Settings</v-tab>
      <v-tab value="account" style="text-transform: capitalize">Account Settings</v-tab>
      <v-tab value="preferences" style="text-transform: capitalize">Preferences</v-tab>
    </v-tabs>

    <v-card-text>
      <v-tabs-window v-model="tab">
        <v-tabs-window-item value="security">

            <v-card rounded>
                <v-card-title style="background-color: darkblue; color: white;" class="text-center">
                  Security Settings
                </v-card-title>
                <v-card-text>
                    <br>
                  <v-form>
                    <v-row>
                      <v-col cols="12" md="6">
                        <v-text-field label="Current Password" type="password" variant="underlined" prepend-inner-icon="mdi-lock"></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-text-field label="New Password" type="password" variant="underlined" prepend-inner-icon="mdi-lock"></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col cols="12" md="6">
                        <v-text-field label="Confirm New Password" type="password" variant="underlined" prepend-inner-icon="mdi-lock"></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-switch label="Enable Two-Factor Authentication" v-model="twoFactorAuth"></v-switch>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col cols="12" class="text-right">
                        <v-btn color="orange" @click="saveSecuritySettings" width="100%" style="text-transform: capitalize">Save</v-btn>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-card-text>
              </v-card>
        </v-tabs-window-item>


    <v-tabs-window-item value="notifications">
    <v-card rounded>
                <v-card-title style="background-color: darkblue; color: white;" class="text-center">
                  Notification Settings
                </v-card-title>
                <v-card-text>
                  <v-form>
                    <v-row>
                      <v-col cols="12">
                        <v-switch label="Email Notifications" v-model="emailNotifications"></v-switch>
                        <v-switch label="SMS Notifications" v-model="smsNotifications"></v-switch>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col cols="12" class="text-right">
                        <v-btn color="orange" @click="saveNotificationSettings" width=100% style="text-transform: capitalize">Save</v-btn>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-card-text>
                 </v-card>
     </v-tabs-window-item>

                <v-tabs-window-item value="privacy">
                    <v-card rounded>
                <v-card-title style="background-color: darkblue; color: white;" class="text-center">
                  Privacy Settings
                </v-card-title>
                <v-card-text>
                  <v-form>
                    <v-row>
                      <v-col cols="12">
                        <v-switch label="Profile Visibility" v-model="profileVisibility"></v-switch>
                        <v-switch label="Data Sharing" v-model="dataSharing"></v-switch>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col cols="12" class="text-right">
                        <v-btn color="orange" @click="savePrivacySettings" width="100%" style="text-transform: capitalize">Save</v-btn>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-card-text>
              </v-card>

        </v-tabs-window-item>

        <v-tabs-window-item value="account">
            <v-card rounded>
    <v-card-title style="background-color: darkblue; color: white;" class="text-center">
      Account Settings
    </v-card-title>
    <v-card-text>
      <v-form>
        <v-row>
          <v-col cols="12">
            <br>
            <v-btn color="error" @click="deactivateAccount" class="mr-4" style="text-transform: capitalize;">
              <v-icon left>mdi-account-off</v-icon>
              Deactivate Account
            </v-btn>
            <v-btn color="error" @click="deleteAccount" style="text-transform: capitalize;">
              <v-icon left>mdi-account-remove</v-icon>
              Delete Account
            </v-btn>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" class="text-right">
            <v-btn  @click="saveAccountSettings" style="text-transform: capitalize;background-color: orange;" width="100%"><v-icon>mdi-save</v-icon>Save</v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
            </v-tabs-window-item>


            <v-tabs-window-item value="preferences">
                <v-card rounded>
    <v-card-title style="background-color: darkblue; color: white;" class="text-center">
      Preferences
    </v-card-title>
    <v-card-text>
      <br>
      <v-form>
        <v-row>
          <v-col cols="12" md="6">
            <v-switch
            v-model="isDarkMode"
            :label="isDarkMode ? 'Dark Mode' : 'Light Mode'"
            @change="toggleTheme"
          ></v-switch>
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              :items="languages"
              label="Preferred Language"
              v-model="selectedLanguage"
              variant="underlined"
              prepend-icon="mdi-translate"
            ></v-select>
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              :items="timezones"
              label="Timezone"
              v-model="selectedTimezone"
              variant="underlined"
              prepend-icon="mdi-clock-outline"
            ></v-select>
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              :items="currencies"
              label="Currency"
              v-model="selectedCurrency"
              variant="underlined"
              prepend-icon="mdi-currency-usd"
            ></v-select>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" class="text-right">
            <v-btn color="orange" @click="savePreferences" width="100%" style="text-transform: capitalize;">Save</v-btn>
          </v-col>
        </v-row>
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
import { useTheme } from 'vuetify'
const vuetify = useTheme();

const twoFactorAuth = ref(false);
const emailNotifications = ref(false);
const smsNotifications = ref(false);
const profileVisibility = ref(false);
const dataSharing = ref(false);
const selectedLanguage = ref('');
const selectedTimezone = ref('');
const selectedCurrency = ref('');

const languages = ['English', 'French', 'Spanish'];
const timezones = ['UTC', 'GMT', 'EST', 'PST'];
const currencies = ['USD', 'EUR', 'GBP'];


const theme = useTheme()

function toggleTheme () {
  theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
}


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


const savePersonalInfo = () => {
  console.log('Personal information saved');
};

const saveSecuritySettings = () => {
  console.log('Security settings saved', { twoFactorAuth: twoFactorAuth.value });
};

const saveNotificationSettings = () => {
  console.log('Notification settings saved', {
    emailNotifications: emailNotifications.value,
    smsNotifications: smsNotifications.value
  });
};

const savePrivacySettings = () => {
  console.log('Privacy settings saved', {
    profileVisibility: profileVisibility.value,
    dataSharing: dataSharing.value
  });
};

const saveAccountSettings = () => {
  console.log('Account settings saved');
};

const savePreferences = () => {
  console.log('Preferences saved', {
    selectedTheme: selectedTheme.value,
    selectedLanguage: selectedLanguage.value,
    selectedTimezone: selectedTimezone.value,
    selectedCurrency: selectedCurrency.value
  });
};

const deactivateAccount = () => {
  console.log('Account deactivated');
};

const deleteAccount = () => {
  console.log('Account deleted');
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
