    <template>
        <v-app>
        <!-- Navigation Drawer -->
        <v-navigation-drawer
            app
            v-model="drawer"
            fixed
            :style="{ 'min-width': drawerWidth }"
            elevation="0"
            style="background-color: darkblue; color: white;"
        >
            <!-- Logo and Divider -->
            <v-list-item>
            <v-list-item-avatar>
                <v-img src="/Images/iLab white Logo-01.png" alt="tailus logo"  ></v-img>
            </v-list-item-avatar>
            </v-list-item>
            <v-divider></v-divider>

            <!-- Navigation Links -->
            <v-list >
            <v-list-item v-for="(item, i) in items" :key="i">
                <NavLink :href="item.routeName" class="v-list-item" style="color: white;">
                <template v-slot:default="{ href, isActive, isExactActive, isLink }">
                    <v-list-item-icon v-if="item.icon" class="list-item-icon">
                    <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                    <v-list-item-title :class="{ 'primary--text': isExactActive }" v-text="item.text"></v-list-item-title>
                    </v-list-item-content>
                </template>
                </NavLink>
            </v-list-item>

            <!-- Feedback Categories Accordion -->
            <v-list-group
                v-model="activeGroup"
                prepend-icon="mdi-folder"
                class="mt-2"
            >
                <template v-slot:activator="{ props }">
                <v-list-item v-bind="props" title="My Feedback" prepend-icon="mdi-tag" color="white" active-class="active-button"></v-list-item>
                </template>

                <!-- All Feedback Link -->
                <v-list-item href="/all-feedback" prepend-icon="mdi-email" title="All Feedback" color="white" elevation="0" active-class="active-button"></v-list-item>

                <!-- Feedback Categories -->
                <v-list-item
                v-for="(category, index) in categories"
                :key="index"
                @click="navigateToCategory(category.url)"
                :prepend-icon="category.icon"
                color="white"
                elevation="0"
                >
                <v-list-item-content>
                    <v-list-item-title>{{ category.name }}</v-list-item-title>
                    <!-- Include additional category details if needed -->
                </v-list-item-content>
                </v-list-item>
            </v-list-group>
            </v-list>
        </v-navigation-drawer>

        <!-- App Bar -->
        <v-app-bar app class="border-b" height="90" elevation="2">
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title style="white-space: normal;">
            <span class="mr-2">Welcome</span> {{ $page.props.auth.user.name }} !
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <!-- Search Bar -->
            <!-- <v-text-field
            v-model="search"
            prepend-inner-icon="mdi-magnify"
            label="Search"
            hide-details
            class="hidden md:flex ma-4 mt-6"
            variant="outlined"
            ></v-text-field> -->

            <v-chip label elevation="5" class="mr-4">
            <v-switch
                v-model="isDarkMode"
                :label="isDarkMode ? 'Dark Mode' : 'Light Mode'"
                @change="toggleTheme"
                class="mt-6"
            ></v-switch>
            </v-chip>

            <v-chip label elevation="5" :href="route('profile')" class="mr-4" style="background-color: darkblue; color:white;">
            <v-icon>mdi-account</v-icon> My Profile
            </v-chip>


            <v-btn icon style="font-weight: 500; font-family: 'poppins'; text-transform:capitalize;" text  class="mr-4">
            <v-icon size="28" style="padding:17px;">mdi-bell-outline</v-icon><span v-if="notificationCount > 0"  class="notification-count">20</span>
            </v-btn>



            <v-chip label class="mr-4" elevation="5" style="background-color: red; color: red;" color="red">
            <ResponsiveNavLink :href="route('logout')" method="post" as="button" style="color: white; background-color: red;">
                <v-icon>mdi-logout</v-icon> Log Out
            </ResponsiveNavLink>
            </v-chip>
        </v-app-bar>

        <!-- Main Content Area -->
        <v-main>
            <v-container fluid class="mt-10">
            <slot></slot>
            </v-container>
        </v-main>
        </v-app>
    </template>

    <script setup>
import { ref } from 'vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { useTheme } from 'vuetify';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  categories: {
    type: Array,
    required: true,
  },

});

const theme = useTheme();

function toggleTheme() {
    theme.global.name.value = theme.global.current.value.dark ? 'light':'dark';
}

const drawer = ref(true);
const drawerWidth = '240px'; // Adjust as needed
const search = ref('');
const isDarkMode = ref(false);
const activeGroup = ref(true); // Default to expanded

function navigateTo(url) {
    Inertia.visit(url);
}

function navigateToCategory(url) {
    Inertia.visit(url);
}

const items = [
    { text: 'Dashboard', routeName: 'admin', icon: 'mdi-view-dashboard' },
];
</script>
    <style scoped>
    .v-main {
        overflow-y: auto;
        height: calc(100vh - 90px); /* Subtract the height of the app bar */
    }

    .list-item-icon {
        margin-right: 16px; /* Adjust the space between the icon and the text */
    }

    .center-align {
  justify-content: center;
}
.notification-count {
  position: absolute;
  top: 6px; /* Adjust the vertical position */
  right: 10px; /* Adjust the horizontal position */
  background-color: red;
  color: white;
  border-radius: 50%; /* Make it a circle */
  width: 20px; /* Adjust size as needed */
  height: 20px; /* Adjust size as needed */
  font-size: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}
    </style>
