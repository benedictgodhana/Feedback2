<template>
    <Head title="Dashboard" />
    <AdminLayout :categories="categories">
        <v-container width="100%" style="max-width: 1600px">
            <v-row>
                <!-- Profile Card Section -->


                <!-- Notification List Section -->
                <v-col cols="12" md="4" class="notification-list">
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
                                            >

                                            <v-col


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
                                                    formatDateTime(
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
                                rounded
                            ></v-pagination>
                        </v-card-text>
                    </v-card>
                </v-col>

               <!-- Notification Details Section -->
<v-col cols="1" md="7" style="margin-top: -10px">
    <v-card v-if="selectedNotification">
        <v-toolbar
    flat
    class="text-white"
    style="background-color: darkblue;"
>

<v-btn
        icon
        @click="selectedNotification = null"
        class="text-black"
    >
        <v-icon color="orange">mdi-arrow-left</v-icon>
    </v-btn>
    <v-toolbar-title class="ml-2">Notification Details</v-toolbar-title>
    <v-spacer></v-spacer>


    <v-btn @click="exportNotificationAsExcel" class="text-black" variant="tonal" color="white" style="text-transform: capitalize;">
                <v-icon color="blue">mdi-export</v-icon> Export
            </v-btn>

            <!-- Print Button -->
            <v-btn @click="printNotification" class="text-black" variant="tonal" color="white" style="text-transform: capitalize;">
                <v-icon color="blue">mdi-printer</v-icon> Print
            </v-btn>

    <v-btn
        v-if="selectedNotification.feedback.email"
        @click="showReplyDialog = true"
        class="text-black"
    variant="tonal"
    color="white"
    style="text-transform: capitalize;"
    >
        <v-icon color="green">mdi-reply</v-icon>Reply
    </v-btn>
</v-toolbar>

        <v-card-text>


<v-alert
                    v-if="showAlert"
                    type="success"
                    dismissible
                    @click:close="showAlert = false"
                    class="mt-4"
                >
                    {{ alertMessage }}
                </v-alert>

            <!-- Existing content -->
            <br />
            <p>
                <strong>Date and Time:</strong>
                {{ formatDateTime(selectedNotification.created_at) }}
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
                            {{ selectedNotification.feedback.subject }}
                        </p>
                    </v-col>
                    <v-col>
                        <p class="mt-3">
                            <strong class="mr-4">Name:</strong>
                            {{ selectedNotification.feedback.name || "N/A" }}
                        </p>
                    </v-col>
                    <v-col>
                        <p class="mt-3 ">
                            <strong class="mr-4">Email:</strong>
                            {{ selectedNotification.feedback.email || "N/A" }}
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

                </v-row>
                <v-row>
                    <v-col>
                        <p class="mt-3">
                            <strong>Feedback:</strong>
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
                <v-btn width="100%" color="orange" style="text-transform:capitalize">Change Status</v-btn>
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
                Please select a notification from the list to view details.
            </p>
        </v-card-text>
    </v-card>

    <!-- Reply Dialog -->
    <v-dialog v-model="showReplyDialog" max-width="600px">
    <v-card>
      <v-toolbar style="background-color: darkblue; color: white">
        <v-card-title>Reply to the feedback</v-card-title>
        <v-spacer></v-spacer>
        <v-btn icon variant="tonal" @click="showReplyDialog = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        <v-alert
          v-if="ErrorAlert"
          type="error"
          dismissible
          @click:close="ErrorAlert = false"
          class="mt-4"
        >
          {{ alertMessage }}
        </v-alert>
        <br>
        <v-text-field
          label="Recipient Email"
          v-model="selectedNotification.feedback.email"
          readonly
          outlined
          dense
          variant="outlined"
        ></v-text-field>
        <v-text-field
          label="Subject"
          v-model="selectedNotification.feedback.subject"
          readonly
          outlined
          dense
          class="mb-2"
          variant="outlined"
        ></v-text-field>
        <v-textarea
          label="Feedback"
          v-model="selectedNotification.feedback.feedback"
          readonly
          outlined
          dense
          rows="4"
          class="mb-2"
          variant="outlined"
          required
        ></v-textarea>
        <v-textarea
          v-model="replyMessage"
          label="Your Reply"
          rows="4"
          auto-grow
          variant="outlined"
        ></v-textarea>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          text
          @click="showReplyDialog = false"
          variant="tonal"
          style="text-transform: capitalize; background-color: red; color: white"
        >
          <v-icon>mdi-close</v-icon> Cancel
        </v-btn>
        <v-btn
          @click="sendReply"
          variant="tonal"
          :loading="isLoading"
          style="text-transform: capitalize; background-color: green; color: white"
        >
          <v-icon>mdi-email-outline</v-icon> Send Reply
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

</v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { ref, computed } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import * as XLSX from 'xlsx';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

const { notifications: initialNotifications } = usePage().props;

const notifications = ref(initialNotifications);
const selectedNotification = ref(null);
const search = ref("");
const selectedFilter = ref(null);
const filters = ["All", "Important", "Updates"];
const currentPage = ref(1);
const itemsPerPage = 4;
const statusOptions = ['Pending', 'In Progress', 'Resolved', 'Closed'];
const showReplyDialog = ref(false);
const replyMessage = ref("");
const showAlert = ref(false);
const alertMessage = ref("");
const isLoading = ref(false); // Loading state
const ErrorAlert = ref(false);
const { props } = usePage();

const categories = ref(props.categories || []);

// Initialize form using Inertia's useForm
const form = useForm({
  email: '',
  subject: '',
  feedback: '',
  message: '',
});

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

const formatDateTime = (dateString) => {
    const date = new Date(dateString);
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    };
    return date.toLocaleDateString("en-US", options);
};



const exportNotificationAsExcel = () => {
  if (!selectedNotification.value) {
    alert('No notification selected.');
    return;
  }

  // Create a worksheet and a workbook
  const ws = XLSX.utils.json_to_sheet([
    {
      'Date and Time': formatDateTime(selectedNotification.value.created_at),
      'Subject': selectedNotification.value.feedback.subject,
      'Name': selectedNotification.value.feedback.name || 'N/A',
      'Email': selectedNotification.value.feedback.email || 'N/A',
      'Category': selectedNotification.value.feedback.category.name || 'N/A',
      'Subcategory': selectedNotification.value.feedback.subcategory.name || 'N/A',
      'Feedback': selectedNotification.value.feedback.feedback || 'N/A',
      'Status': selectedNotification.value.feedback.status || 'N/A',
    }
  ]);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Notification');

  // Save the file
  XLSX.writeFile(wb, 'NotificationDetails.xlsx');
};


const printNotification = () => {
  if (!selectedNotification.value) {
    alert('No notification selected.');
    return;
  }

  // Create a new jsPDF instance
  const doc = new jsPDF();

  // Add title
  doc.setFontSize(18);
  doc.setTextColor(0, 0, 128); // Dark blue
  doc.text('Notification Details', 14, 22);

  // Define the table column headers and data
  const columns = [
    { header: 'Notification Title', dataKey: 'field' },
    { header: 'Notification Details ', dataKey: 'value' }
  ];

  const data = [
    { field: 'Date and Time', value: formatDateTime(selectedNotification.value.created_at) },
    { field: 'Subject', value: selectedNotification.value.feedback.subject },
    { field: 'Name', value: selectedNotification.value.feedback.name || 'N/A' },
    { field: 'Email', value: selectedNotification.value.feedback.email || 'N/A' },
    { field: 'Category', value: selectedNotification.value.feedback.category.name || 'N/A' },
    { field: 'Subcategory', value: selectedNotification.value.feedback.subcategory.name || 'N/A' },
    { field: 'Feedback', value: selectedNotification.value.feedback.feedback || 'N/A' },
    { field: 'Status', value: selectedNotification.value.feedback.status || 'N/A' }
  ];

  // Add table to the PDF
  doc.autoTable(columns, data, {
    startY: 30,
    margin: { top: 10 },
    styles: { fontSize: 10 },
    headStyles: { fillColor: [0, 0, 128], textColor: [255, 255, 255] }, // Dark blue header with white text
    alternateRowStyles: { fillColor: [240, 240, 240] }, // Light grey rows
    columnStyles: { field: { fontStyle: 'bold' } },
  });

  // Save the PDF
  doc.save('notification-details.pdf');
};

const isRecent = (notification) => {
    const notificationDate = new Date(notification.created_at);
    const today = new Date();
    return notificationDate.toDateString() === today.toDateString();
};

const selectNotification = (notification) => {
    selectedNotification.value = notification;
    form.email = notification.feedback.email;
    form.subject = notification.feedback.subject;
    form.feedback = notification.feedback.feedback;
};

const validateForm = () => {
  if (!form.email || !form.subject || !form.feedback || !replyMessage.value) {
    alertMessage.value = "Please fill in all required fields.";
    ErrorAlert.value = true; // Show the alert
    setTimeout(() => {
      ErrorAlert.value = false; // Hide the alert after 4 seconds
    }, 4000);
    return false;
  }
  return true;
};

const sendReply = async () => {
  if (!validateForm()) return; // Validate the form before sending

  isLoading.value = true; // Start loading

  form.message = replyMessage.value; // Ensure message field is populated

  try {
    await form.post('/send-reply', {
      onSuccess: () => {
        showAlert.value = true; // Show the alert
        alertMessage.value = "Reply sent successfully"; // Success message
        form.reset(); // Reset the form after successful submission
        replyMessage.value = ""; // Clear the reply message
        setTimeout(() => {
          showAlert.value = false;
        }, 4000);
        showReplyDialog.value = false; // Close the reply dialog
      },
      onError: (errors) => {
        alertMessage.value = "Failed to send reply. Please try again."; // Error message
        console.error('Failed to send reply', errors);
        setTimeout(() => {
          showAlert.value = false;
        }, 4000);
      },
    });
  } catch (error) {
    alertMessage.value = "An error occurred. Please try again."; // Error message
    console.error('Error sending reply:', error);
    setTimeout(() => {
      showAlert.value = false;
    }, 4000);
  } finally {
    isLoading.value = false; // Stop loading
  }
};

const links = [
    { text: "My Profile", routeName: "profile", icon: "mdi-account" },
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
