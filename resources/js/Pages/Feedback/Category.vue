<template>
  <Head title="Dashboard" />

  <AdminLayout :categories="categories">
    <v-container fluid>
      <!-- Main content of the page -->
      <v-card max-width="1500" elevation="0">
        <v-card-title class="text-center" style="background-color: orange; color: white; ">
          Feedback List for {{ categoryName.name}}
          <v-spacer></v-spacer>
        </v-card-title>
        <br>
        <v-card-text>

            <v-chip color="black" href="/admin" class="mr-4" label elevation="5">
            <v-icon left>mdi-home</v-icon> Dashboard
          </v-chip>

          <!-- Print Button -->
          <v-chip @click="printFeedback" class="mr-4" label elevation="5">
            <v-icon left color="red">mdi-printer</v-icon> Print
          </v-chip>
          <!-- Export Button -->
          <v-chip color="green" @click="exportFeedback" class="mr-4" label elevation="5">
            <v-icon left>mdi-download</v-icon> Export
          </v-chip>
          <!-- Add Feedback Button -->
          <v-chip color="purple" @click="resetFilters" label elevation="5">
            <v-icon left>mdi-restore</v-icon> Reset
          </v-chip>
        </v-card-text>
        <v-divider></v-divider>

        <!-- Filters and Search -->
        <v-card-text>
          <v-row>
            <v-col cols="12" md="4">
                <v-select
      v-model="selectedSubcategory"
      :items="subcategories"
      item-title="name"
      item-value="id"
      label="Filter by Subcategory"
      dense
      variant="underlined"
    ></v-select>
            </v-col>
            <v-col cols="12" md="8">
              <v-text-field
                v-model="search"
                label="Search Feedback"
                prepend-icon="mdi-magnify"
                dense
                variant="underlined"

              ></v-text-field>
            </v-col>

            <v-col cols="12" md="3">
            <v-text-field
                v-model="dateRange.startDate"
                label="Start Date"
                type="date"
                dense
                variant="underlined"
                prepend-icon="mdi-calendar"
            ></v-text-field>
        </v-col>

        <v-col cols="12" md="3">
            <v-text-field
                v-model="dateRange.endDate"
                label="End Date"
                type="date"
                dense
                variant="underlined"
                prepend-icon="mdi-calendar"
            ></v-text-field>
        </v-col>


        <v-col cols="12" md="3">
    <v-select
        v-model="selectedStatus"
        :items="statusOptions"
        label="Feedback Status"
        dense
        variant="underlined"
    ></v-select>
</v-col>
          </v-row>
        </v-card-text>

        <v-alert
                    v-if="alertVisible"
                    :type="alertType"
                    dismissible
                    @click:close="alertVisible = false"
                >
                    {{ alertMessage }}
                </v-alert>
        <!-- Data Table -->
        <v-data-table
          :headers="headers"
          :items="filteredFeedbacks"
          :items-per-page="8"
          class="elevation-0"
        >

          <template v-slot:item.subcategory="{ item }">
            <span>{{ subcategoryNames}}</span> <!-- Display subcategory name -->
          </template>

          <template v-slot:item.status="{ item }">
                        <v-menu
                            offset-y
                            :close-on-content-click="false"
                            max-width="200px"
                            transition="scale-transition"
                        >
                            <template v-slot:activator="{ props }">
                                <v-btn
                                    v-bind="props"
                                    :color="getStatusColor(item.status)"
                                    width="100%"
                                    style="text-transform: capitalize"
                                    rounded
                                >
                                    {{ item.status }}
                                    <v-icon right>mdi-menu-down</v-icon>
                                </v-btn>
                            </template>
                            <v-list>
                                <v-list-item
                                    v-for="(status, index) in statuses"
                                    :key="index"
                                    @click="updateStatus(item, status)"
                                >
                                    <v-list-item-title>{{
                                        status
                                    }}</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </template>
          <template v-slot:item.actions="{ item }">

            <v-chip icon color="white" @click="openDialog('view', item)" elevation="0">
              <v-icon color="primary">mdi-eye</v-icon>
            </v-chip>

          </template>
        </v-data-table>
      </v-card>

      <!-- Add Feedback Dialog -->
      <v-dialog v-model="dialog.add" max-width="800px">
        <v-card>
          <v-toolbar color="purple">
            <v-card-title>Add Feedback</v-card-title>
            <v-spacer></v-spacer>
            <v-btn @click="dialog.add = false" color="white" icon><v-icon>mdi-close</v-icon></v-btn>
          </v-toolbar>
          <v-card-text>
            <!-- Add Feedback Form -->
            <v-form>
              <v-text-field v-model="newFeedback.subject" label="Subject" required></v-text-field>
              <v-text-field v-model="newFeedback.name" label="Name" required></v-text-field>
              <v-text-field v-model="newFeedback.email" label="Email" required></v-text-field>
              <v-textarea v-model="newFeedback.feedback" label="Feedback" required></v-textarea>
              <!-- Add other fields as needed -->
              <v-row>
                <v-col>
                  <v-btn @click="saveFeedback" class="mr-4" width="100%" color="green"> <v-icon>mdi-content-save</v-icon> Save</v-btn>
                </v-col>
                <v-col>
                  <v-btn @click="dialog.add = false" width="100%" color="red"><v-icon>mdi-cancel</v-icon> Cancel</v-btn>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-dialog>

      <!-- Edit Dialog -->
      <v-dialog v-model="dialog.edit" max-width="800px">
        <v-card>
          <v-toolbar color="orange">
            <v-card-title>Edit Feedback</v-card-title>
            <v-spacer></v-spacer>
            <v-btn @click="dialog.edit = false" color="white" icon><v-icon>mdi-close</v-icon></v-btn>
          </v-toolbar>
          <v-card-text>
            <!-- Edit form or content here -->
            <v-form>
              <v-text-field v-model="selectedFeedback.subject" label="Subject" required></v-text-field>
              <v-text-field v-model="selectedFeedback.name" label="Name" required></v-text-field>
              <v-text-field v-model="selectedFeedback.email" label="Email" required></v-text-field>
              <v-textarea v-model="selectedFeedback.feedback" label="Feedback" required></v-textarea>
              <!-- Add other fields as needed -->
              <v-row>
                <v-col>
                  <v-btn @click="saveEdit(selectedFeedback)" class="mr-4" width="100%" color="green"> <v-icon>mdi-content-save</v-icon> Save</v-btn>
                </v-col>
                <v-col>
                  <v-btn @click="dialog.edit = false" width="100%" color="red"><v-icon>mdi-cancel</v-icon> Cancel</v-btn>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-dialog>

      <!-- View Dialog -->
      <v-dialog v-model="dialog.view" max-width="800px">
        <v-card width="800">
          <v-card-title style="background-color:darkblue;color:white" class="text-center">View Feedback {{ categoryName.name}}</v-card-title>
          <v-card-text>
            <v-row>


                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="selectedFeedback.subcategory.name"
                                    label="Feedback Subcategory"
                                    readonly
                                    variant="outlined"
                                ></v-text-field>
                            </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="selectedFeedback.subject"
                  label="Subject"
                  readonly
                  variant="outlined"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="selectedFeedback.name"
                  label="Name"
                  readonly
                  variant="outlined"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="selectedFeedback.email"
                  label="Email"
                  readonly
                  variant="outlined"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  v-model="selectedFeedback.feedback"
                  label="Feedback"
                  readonly
                  variant="outlined"
                ></v-textarea>
              </v-col>

              <v-col cols="12">
                                <v-textarea
                                v-if="selectedFeedback.email"
                                    v-model="replyMessage"
                                    label="Reply to the feedback"
                                    variant="outlined"
                                ></v-textarea>
                            </v-col>

                            <v-row>

                            <v-col  v-if="selectedFeedback.email">
                                <v-btn
                                    @click="sendReply"
                                    variant="tonal"
                                    :loading="loading"
                                    width="100%"
                                    style="
                                        text-transform: capitalize;
                                        background-color: green;
                                        color: white;
                                    "
                                >
                                    <v-icon>mdi-email-outline</v-icon> Send
                                    Reply
                                </v-btn>
                            </v-col>

                            <v-col >
                  <v-btn @click="dialog.view = false" width="100%" color="red"><v-icon>mdi-cancel</v-icon> Cancel</v-btn>
                </v-col>

            </v-row>
              <!-- Add other fields as needed -->
            </v-row>
          </v-card-text>
        </v-card>
      </v-dialog>

      <!-- Delete Dialog -->
      <v-dialog v-model="dialog.delete" max-width="500px">
        <v-card>
          <v-toolbar color="orange">
            <v-toolbar-title>Delete Feedback</v-toolbar-title>
            <v-btn @click="dialog.delete = false" style="text-transform: capitalize;" color="white" icon elevation="0">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-text>
            <div>Are you sure you want to delete this feedback?</div>
            <br>
            <v-row>
              <v-col>
                <v-btn @click="confirmDelete(selectedFeedback)" class="mr-4" style="text-transform: capitalize;" color="green" width="100%" rounded>
                  <v-icon>mdi-check</v-icon> Confirm
                </v-btn>
              </v-col>
              <v-col>
                <v-btn @click="dialog.delete = false" style="text-transform: capitalize;" color="red" width="100%" rounded>
                  <v-icon>mdi-cancel</v-icon> Cancel
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-container>
  </AdminLayout>
</template>
<script setup>
import { ref, computed } from 'vue';
import { usePage,useForm  } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import jsPDF from 'jspdf';
import 'jspdf-autotable'; // Import jsPDF's autotable plugin if needed
import * as XLSX from 'xlsx';
import { Inertia } from "@inertiajs/inertia";



const { props } = usePage();

// Define component name and layout
const name = 'Dashboard';
const components = { AdminLayout, Head };
const categories = ref(props.categories || []);
const replyMessage = ref("");
const loading = ref(false);

const alertVisible = ref(false);
const alertMessage = ref("");
const alertType = ref("success");
const selectedStatus = ref(""); // For status filtering

const dateRange = ref({
          startDate: '',
            endDate: '',

        });
// Define reactive state variables
const feedbacks = ref([]);
const selectedFeedback = ref({
  subject: '',
  name: '',
  email: '',
  feedback: '',
  category_name: '',
  subcategory_name: ''
});
const newFeedback = ref({
  subject: '',
  name: '',
  email: '',
  feedback: ''
});
const headers = ref([
  { title: 'Subject', value: 'subject' },
  { title: 'Name', value: 'name' },
  { title: 'Email', value: 'email' },
  { title: 'Subcategory', value: 'subcategory_name' },
  { title: 'Status', value: 'status' },

  { title: 'Actions', value: 'actions', sortable: false }
]);
const dialog = ref({
  add: false,
  edit: false,
  view: false,
  delete: false
});
const categoryName = ref('');
const selectedSubcategory = ref(null);
const search = ref('');
const subcategories = ref([]);

// Fetch initial data
feedbacks.value = props.feedbacks;
categoryName.value = props.category;
subcategories.value = props.subcategories;
const filteredFeedbacks = computed(() => {
  return feedbacks.value
    .filter(feedback => {
      // Ensure feedback is valid and contains the necessary properties
      if (!feedback || !feedback.created_at) return false;

      const feedbackDate = new Date(feedback.created_at); // Ensure created_at is a valid date
      const startDate = dateRange.value.startDate ? new Date(dateRange.value.startDate) : null;
      const endDate = dateRange.value.endDate ? new Date(dateRange.value.endDate) : null;

      // Apply filters
      const isWithinDateRange = (!startDate || feedbackDate >= startDate) && (!endDate || feedbackDate <= endDate);
      const matchesStatus = !selectedStatus.value || feedback.status === selectedStatus.value;
      const matchesSubcategory = !selectedSubcategory.value || feedback.subcategory_id === selectedSubcategory.value;

      // Ensure feedback.email, feedback.subject, feedback.name, and feedback.feedback are valid strings
      const matchesSearch = search.value
        ? (feedback.subject && feedback.subject.toLowerCase().includes(search.value.toLowerCase())) ||
          (feedback.name && feedback.name.toLowerCase().includes(search.value.toLowerCase())) ||
          (feedback.email && feedback.email.toLowerCase().includes(search.value.toLowerCase())) ||
          (feedback.feedback && feedback.feedback.toLowerCase().includes(search.value.toLowerCase()))
        : true;

      return isWithinDateRange && matchesStatus && matchesSubcategory && matchesSearch;
    })
    .map(feedback => ({
      ...feedback,
      subcategory_name: feedback.subcategory ? feedback.subcategory.name : 'No Subcategory'
    }));
});




// Methods
const getSubcategoryName = (subcategoryId) => {
  const subcategory = subcategories.value.find(sub => sub.id === subcategoryId);
  return subcategory ? subcategory.name : '';
};

const openDialog = (type, feedback) => {
  selectedFeedback.value = feedback || {
    subject: '',
    name: '',
    email: '',
    feedback: '',
    category_name: '',
    subcategory_name: ''
  };
  dialog.value[type] = true;
};

const resetFilters = () => {
  selectedSubcategory.value = null;
  search.value = "";
  dateRange.value.startDate = '';
  dateRange.value.endDate = '';
  selectedStatus.value = '';
};
const saveFeedback = () => {
  console.log('Saving new feedback:', newFeedback.value);
  dialog.value.add = false;
};

const saveEdit = (feedback) => {
  console.log('Saving edit for feedback:', feedback);
  dialog.value.edit = false;
};

const confirmDelete = (feedback) => {
  console.log('Deleting feedback:', feedback);
  dialog.value.delete = false;
};

const exportFeedback = () => {
  const rows = filteredFeedbacks.value.map(feedback => ({
    Subcategory: getSubcategoryName(feedback.subcategory_id),
    Name: feedback.name,
    Email: feedback.email,
    Subject: feedback.subject,
    Feedback: feedback.feedback,
    Status: feedback.Status

  }));
  const ws = XLSX.utils.json_to_sheet(rows);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Feedback');
  const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });
  const blob = new Blob([wbout], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'feedbacks.xlsx';
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  window.URL.revokeObjectURL(url);
};

const statusOptions = ref([
        "Pending", "In Progress", "Resolved", "Closed"
        ]);

        const statuses = ["Pending", "In Progress", "Resolved", "Closed"];


const getStatusColor = (status) => {
            switch (status) {
                case "Pending":
                    return "blue";
                case "In Progress":
                    return "orange";
                case "Resolved":
                    return "green";
                case "Closed":
                    return "red";
                default:
                    return "default";
            }
        };

const printFeedback = () => {
  const doc = new jsPDF();
  const columns = [
    { header: 'Subcategory', dataKey: 'subcategory' },
    { header: 'Name', dataKey: 'name' },
    { header: 'Email', dataKey: 'email' },
    { header: 'Subject', dataKey: 'subject' },
    { header: 'Feedback', dataKey: 'feedback' },
    { header: 'Status', dataKey: 'status' }

  ];
  const rows = filteredFeedbacks.value.map(feedback => ({
    subcategory: getSubcategoryName(feedback.subcategory_id),
    name: feedback.name,
    email: feedback.email,
    subject: feedback.subject,
    feedback: feedback.feedback,
    status: feedback.status

  }));
  doc.setFontSize(18);
  doc.text(`All Feedback for ${categoryName.value.name}`, 14, 22);
  doc.autoTable({
    columns: columns,
    body: rows,
    margin: { top: 30 },
    styles: { overflow: 'linebreak' }
  });
  doc.autoPrint();
  window.open(doc.output('bloburl'), '_blank');
};

const updateStatus = (feedback, status) => {
            const updatedStatus = status;
            feedback.status = updatedStatus;

            Inertia.put(`/feedback/${feedback.id}`, { status: updatedStatus })
                .then(() => {
                    alertMessage.value = "Status updated successfully!";
                    alertType.value = "success";
                })
                .catch((error) => {
                    alertMessage.value =
                        "Failed to update status. Please try again.";
                    alertType.value = "error";
                    console.error("Error updating status:", error);
                })
                .finally(() => {
                    alertVisible.value = true;
                });
        };



        const sendReply = async () => {
            if (!replyMessage.value) {
                alert("Please enter a reply message.");
                return;
            }

            loading.value = true; // Set loading to true before starting the request

            try {
                await useForm({
                    email: selectedFeedback.value.email,
                    message: replyMessage.value,
                }).post("/send-reply");
                alertMessage.value = "Reply sent successfully.";
                alertType.value = "success";
                alertVisible.value = true;
                replyMessage.value = "";
                dialog.value.view = false;

                // Hide the alert after 5 seconds
                setTimeout(() => {
                    alertVisible.value = false;
                }, 5000);
            } catch (error) {
                alertMessage.value = "Failed to send reply. Please try again.";
                alertType.value = "error";
                alertVisible.value = true;

                // Hide the alert after 5 seconds
                setTimeout(() => {
                    alertVisible.value = false;
                }, 5000);

                console.error("Error sending reply:", error);
            } finally {
                loading.value = false; // Set loading to false when the request is complete
            }
        };



const addFeedback = () => {
  openDialog('add');
};
</script>


<style scoped>
/* Add scoped styles here */
</style>
