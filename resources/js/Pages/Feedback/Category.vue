<template>
  <Head title="Dashboard" />

  <AdminLayout>
    <v-container>
      <!-- Main content of the page -->
      <v-card max-width="1500" elevation="0">
        <v-card-title class="text-center" style="background-color: darkblue; color: white; border-radius: 40px;">
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
      item-text="name"
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
          </v-row>
        </v-card-text>

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
          <template v-slot:item.actions="{ item }">
            <v-chip icon color="white" @click="openDialog('edit', item)" elevation=0>
              <v-icon color="green">mdi-pencil</v-icon>
            </v-chip>
            <v-chip icon color="white" @click="openDialog('view', item)" elevation="0">
              <v-icon color="primary">mdi-eye</v-icon>
            </v-chip>
            <v-chip icon color="white" @click="openDialog('delete', item)">
              <v-icon color="red">mdi-delete</v-icon>
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
          <v-card-title style="background-color: orange;" class="text-center">View Feedback</v-card-title>
          <v-card-text>
            <v-row>
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

<script>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import jsPDF from 'jspdf';
import 'jspdf-autotable'; // Import jsPDF's autotable plugin if needed
import * as XLSX from 'xlsx';

export default {
  name: 'Dashboard',
  components: {
    AdminLayout,
    Head,
  },
  data() {
    return {
      feedbacks: [], // Array to hold feedback data
      selectedFeedback: {
        subject: '',
        name: '',
        email: '',
        feedback: '',
        category_name: '', // Ensure category_name and subcategory_name are available
        subcategory_name: ''
      },
      newFeedback: { // Data structure for adding new feedback
        subject: '',
        name: '',
        email: '',
        feedback: '',
      },
      headers: [
        { title: 'Subject', value: 'subject' },
        { title: 'Name', value: 'name'},
        { title: 'Email', value: 'email' },
        { title: 'Subcategory', value: 'subcategory_name' },
        { title: 'Actions', value: 'actions', sortable: false },
      ],
      dialog: {
        add: false,
        edit: false,
        view: false,
        delete: false,
      },
      categoryName: '', // Placeholder for category name
      selectedSubcategory: null, // Filter by subcategory
      search: '', // Search term
      subcategories: [] // Array to hold subcategories
    };
  },
  created() {
    const { props } = usePage();
    this.feedbacks = props.feedbacks;
    this.categoryName = props.category;
    this.subcategories = props.subcategories;
    this.subcategoryNames = this.subcategories.map(subcategory => subcategory.name);

    // Ensure subcategories have the correct format
    console.log('subcategories', this.subcategories);
  },
  computed: {
  filteredFeedbacks() {
    return this.feedbacks
      .filter(feedback =>
        (this.selectedSubcategory ? feedback.subcategory_id === this.selectedSubcategory : true) &&
        (this.search ? feedback.subject.toLowerCase().includes(this.search.toLowerCase()) ||
                      feedback.name.toLowerCase().includes(this.search.toLowerCase()) ||
                      feedback.email.toLowerCase().includes(this.search.toLowerCase()) ||
                      feedback.feedback.toLowerCase().includes(this.search.toLowerCase())
                      : true)
      )
      .map(feedback => ({
        ...feedback,
        subcategory_name: feedback.subcategory ? feedback.subcategory.name : 'No Subcategory'
      }));
  }
},

  methods: {

    getSubcategoryName(subcategoryId) {
      const subcategory = this.subcategories.find(sub => sub.id === subcategoryId);
      return subcategory ? subcategory.name : '';
    },
    openDialog(type, feedback) {
      // Ensure the selected feedback has default values
      this.selectedFeedback = feedback || {
        subject: '',
        name: '',
        email: '',
        feedback: '',
        category_name: '',
        subcategory_name: ''
      };

      // Open the appropriate dialog based on type
      this.dialog[type] = true;
    },


    resetFilters() {
    this.selectedSubcategory = null;
    this.search = '';
  },
    saveFeedback() {
      // Add logic to save the new feedback
      console.log('Saving new feedback:', this.newFeedback);
      this.dialog.add = false;
    },
    saveEdit(feedback) {
      // Add logic to save the edited feedback
      console.log('Saving edit for feedback:', feedback);
      this.dialog.edit = false;
    },
    confirmDelete(feedback) {
      // Add logic to delete the feedback
      console.log('Deleting feedback:', feedback);
      this.dialog.delete = false;
    },
    exportFeedback() {

  // Prepare data for the Excel sheet
  const rows = this.filteredFeedbacks.map(feedback => ({
    Subcategory: this.getSubcategoryName(feedback.subcategory_id),
    Name: feedback.name,
    Email: feedback.email,
    Subject: feedback.subject,
    Feedback: feedback.feedback
  }));

  // Create a new workbook and worksheet
  const ws = XLSX.utils.json_to_sheet(rows);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Feedback');

  // Generate Excel file
  const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });

  // Create a Blob from the workbook
  const blob = new Blob([wbout], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

  // Create a link element to trigger the download
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'feedbacks.xlsx';
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  window.URL.revokeObjectURL(url);
},
printFeedback() {
  const doc = new jsPDF();
  const columns = [
    { header: 'Subcategory', dataKey: 'subcategory' },
    { header: 'Name', dataKey: 'name' },
    { header: 'Email', dataKey: 'email' },
    { header: 'Subject', dataKey: 'subject' },
    { header: 'Feedback', dataKey: 'feedback' }
  ];

  // Prepare data for the PDF
  const rows = this.filteredFeedbacks.map(feedback => ({
    subcategory: this.getSubcategoryName(feedback.subcategory_id),
    name: feedback.name,
    email: feedback.email,
    subject: feedback.subject,
    feedback: feedback.feedback
  }));

  // Add a title with the category name
  doc.setFontSize(18);
  doc.text(`All Feedback for ${this.categoryName.name}`, 14, 22);

  // Generate the table
  doc.autoTable({
    columns: columns,
    body: rows,
    margin: { top: 30 },
    styles: { overflow: 'linebreak' }
  });

  // Print the PDF
  doc.autoPrint();
  window.open(doc.output('bloburl'), '_blank');
},



  resetFilters() {
    this.selectedSubcategory = null;
    this.search = '';
  },
    addFeedback() {
      this.openDialog('add');
    },
  },
};
</script>

<style scoped>
/* Add scoped styles here */
</style>
