<template>
    <Head title="Dashboard" />
    <AdminLayout>
        <v-container width="100%" style="max-width: 1600px">
            <v-row>
                <!-- Profile Card Section -->
                <v-col cols="8" md="3" style="margin-top: -10px">
                    <v-card
                        class="profile-card"
                        elevation="0"
                        style="
                            border: 1px solid #e0e0e0;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        "
                    >
                        <v-card-text class="text-center py-4">
                            <v-avatar size="200">
                                <img
                                    src="/Images/ben.jpg"
                                    alt="User Avatar"
                                    height="250"
                                />
                            </v-avatar>
                            <v-card-text style="font-weight: 800;font-size: 19px;">
        {{ $page.props.auth.user.name }}
      </v-card-text>
                            <v-divider></v-divider>
                            <div class="mt-3">
                                <v-divider></v-divider>
                                <v-list class="mt-10">
                                    <v-list-item
                                        v-for="(item, i) in links"
                                        :key="i"
                                    >
                                        <NavLink
                                            :href="item.routeName"
                                            class="v-list-item"
                                            style="color: black"
                                        >
                                            <template
                                                v-slot:default="{
                                                    href,
                                                    isActive,
                                                    isExactActive,
                                                    isLink,
                                                }"
                                            >
                                                <v-list-item-icon
                                                    v-if="item.icon"
                                                    class="list-item-icon"
                                                >
                                                    <v-icon
                                                        :icon="item.icon"
                                                        style="color: darkblue"
                                                    ></v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-content>
                                                    <v-list-item-title
                                                        :class="{
                                                            'primary--text':
                                                                isExactActive,
                                                        }"
                                                        v-text="item.text"
                                                    ></v-list-item-title>
                                                </v-list-item-content>
                                            </template>
                                        </NavLink>
                                    </v-list-item>
                                </v-list>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Notification List Section -->
                <v-col cols="12" md="3" class="notification-list">
                    <v-card rounded style="margin-top: -10px">
                        <v-card-title
                            style="background-color: darkblue; color: white"
                            class="text-center"
                        >
                            Notifications
                        </v-card-title>
                        <v-card-text>
                            <!-- Search and Filter -->
                            <v-row>
                                <v-col cols="12" md="6">
                                    <br />
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
                                    <br />
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
                                    v-for="(
                                        notification, index
                                    ) in paginatedNotifications"
                                    :key="index"
                                    @click="selectNotification(notification)"
                                    :class="{
                                        'active-item':
                                            selectedNotification ===
                                            notification,
                                        'bold-item': isRecent(notification),
                                    }"
                                >
                                    <v-list-item-action> </v-list-item-action>
                                    <v-list-item-content>
                                        <v-row
                                            ><v-col class="ms-4">
                                                <v-checkbox
                                                    v-model="notification.read"
                                                    @change="
                                                        markAsRead(notification)
                                                    "
                                                    class="notification-checkbox"
                                                ></v-checkbox>
                                            </v-col>
                                            <v-col
                                                class="mr-4"
                                                style="margin-left: -120px"
                                            >
                                                <v-list-item-title>{{
                                                    notification.feedback
                                                        .subject
                                                }}</v-list-item-title>
                                                <v-list-item-subtitle>{{
                                                    notification.feedback
                                                        .feedback
                                                }}</v-list-item-subtitle>
                                                <v-list-item-subtitle>{{
                                                    formatDate(
                                                        notification.created_at
                                                    )
                                                }}</v-list-item-subtitle>
                                            </v-col>
                                        </v-row>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                            <!-- Pagination Controls -->
                            <v-pagination
                                v-model="currentPage"
                                :length="totalPages"
                                class="mt-4"
                                :total-visible="1"
                                prev-icon="mdi-chevron-left"
                                next-icon="mdi-chevron-right"
                            ></v-pagination>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Notification Details Section -->
                <v-col cols="1" md="6" style="margin-top: -10px">
                    <v-card v-if="selectedNotification">
                        <v-card-title
                            style="background-color: darkblue; color: white"
                        >
                            <v-btn
                                icon
                                @click="selectedNotification = null"
                                style="color: black"
                            >
                                <v-icon color="orange">mdi-arrow-left</v-icon>
                            </v-btn>
                            <span class="ml-2">Notification Details</span>
                        </v-card-title>
                        <v-card-text>
                            <br />
                            <p>
                                <strong>Date:</strong>
                                {{
                                    formatDate(selectedNotification.created_at)
                                }}
                            </p>
                            <br />
                            <hr />
                            <p class="mt-3">
                                <strong>Subject:</strong>
                                {{ selectedNotification.feedback.subject }}
                            </p>
                            <br />
                            <hr />
                            <p class="mt-3 text-center">
                                <strong>Content:</strong>
                            </p>
                            <br />
                            <div v-if="selectedNotification.feedback">
                                <v-row>
                                    <v-col>
                                        <p class="mt-3">
                                            <strong>Feedback Subject:</strong>
                                            {{
                                                selectedNotification.feedback
                                                    .subject
                                            }}
                                        </p>
                                    </v-col>

                                    <v-col>
                                        <p class="mt-3">
                                            <strong>Name:</strong>
                                            {{
                                                selectedNotification.feedback
                                                    .name || "N/A"
                                            }}
                                        </p>
                                    </v-col>

                                    <v-col>
                                        <p class="mt-3">
                                            <p class="mt-3">
                                            <strong>Name:</strong>
                                            {{
                                                selectedNotification.feedback
                                                    .email || "N/A"
                                            }}
                                        </p>
                                        </p>
                                    </v-col>


                                </v-row>
                                <v-row>



                              <v-col>
                                                            <p class="mt-3">
                        <strong>Category:</strong>
                        {{ selectedNotification.feedback.category.name || 'N/A' }}
                        </p>
                                                        </v-col>


                                                        <v-col>

                    <p class="mt-3">
                    <strong>Subcategory:</strong>
                    {{ selectedNotification.feedback.subcategory.name || 'N/A' }}
                    </p>
                    </v-col>


                    <v-col>

                    <p class="mt-3">
                    <strong>Subcategory:</strong>
                    {{ selectedNotification.feedback.feedback || 'N/A' }}
                    </p>
                    </v-col>
                                                    </v-row>

                                                    <br />
                                                    <br>

                                                    <v-select
      v-model="selectedNotification.feedback.status"
      :items="statusOptions"
      label="Feedback Status"
      variant="underlined"
      dense
    ></v-select>
                                                    <v-btn width="100%" color=orange style="text-transform:capitalize">Change Status</v-btn>
                                                </div>
                                            </v-card-text>
                                        </v-card>
                                        <v-card v-else>
                        <v-card-title
                            style="
                                background-color: darkblue;
                                color: white;
                                text-align: center;
                            "
                        >
                            Select a Notification
                        </v-card-title>
                        <v-card-text class="text-center">
                            <p>
                                Please select a notification from the list to
                                view details.
                            </p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import NavLink from "@/Components/NavLink.vue";

const { notifications: initialNotifications } = usePage().props;

const notifications = ref(initialNotifications);
const selectedNotification = ref(null);
const search = ref("");
const selectedFilter = ref(null);
const filters = ["All", "Important", "Updates"];
const currentPage = ref(1);
const itemsPerPage = 4;
const statusOptions = ['Pending', 'In Progress', 'Resolved', 'Closed'];
const filteredNotifications = computed(() => {
    return notifications.value
        .filter((notification) => {
            const matchesFilter =
                !selectedFilter.value ||
                selectedFilter.value === "All" ||
                notification.type === selectedFilter.value;
            const matchesSearch =
                !search.value ||
                notification.feedback.subject
                    .toLowerCase()
                    .includes(search.value.toLowerCase());
            return matchesFilter && matchesSearch;
        })
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at)); // Sort by newest first
});

const paginatedNotifications = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredNotifications.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredNotifications.value.length / itemsPerPage);
});

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { year: "numeric", month: "long", day: "numeric" };
    return date.toLocaleDateString("en-US", options);
};

const selectNotification = (notification) => {
    selectedNotification.value = notification;
};

const markAsRead = (notification) => {
    // Update notification read status
    // Here you might want to make an API call to update the notification status in the backend
    console.log("Marking as read:", notification);
};

const isRecent = (notification) => {
    const notificationDate = new Date(notification.created_at);
    const today = new Date();
    return notificationDate.toDateString() === today.toDateString();
};

const links = [
    { text: "My Profile", routeName: "profile", icon: "mdi-account" },
    // { text: "My Contribution", routeName: "my_contribution", icon: "mdi-cash" },
    { text: "Notifications", routeName: "my_notifications", icon: "mdi-bell" },
    { text: "My Settings", routeName: "my_settings", icon: "mdi-cog" },
];
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

.bold-item {
    font-weight: bold;
}
</style>
