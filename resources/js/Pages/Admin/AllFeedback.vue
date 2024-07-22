<template>
    <Head title="Dashboard" />

    <AdminLayout>
      <v-container style="margin-top: -40px;">
        <!-- Main content of the page -->
        <v-card max-width="1500" elevation="0">
          <v-card-title class="text-center" style="background-color:orange; color: white;">
            All Feedback
            <v-spacer></v-spacer>
          </v-card-title>
          <br>
          <v-card-text>

            <v-chip @click="printFeedback" class="mr-4" label elevation="5">
              <v-icon left color="red">mdi-printer</v-icon> Print
            </v-chip>
            <v-chip color="green" @click="exportFeedback" class="mr-4" label elevation="5">
              <v-icon left>mdi-download</v-icon> Export
            </v-chip>
            <v-chip color="purple" @click="resetFilters" class="mr-4" label elevation="5">
              <v-icon left>mdi-restore</v-icon> Reset
            </v-chip>
          </v-card-text>
          <v-divider></v-divider>

          <!-- Filters and Search -->
          <v-card-text>
            <v-row>
                <v-col cols="12" md="3">
  <v-select
    v-model="selectedCategory"
    :items="formattedCategories"
    item-text="name"
    item-value="id"
    label="Filter by Category"
    dense
    variant="underlined"
    @change="updateSubcategories"
  ></v-select>
</v-col>

<v-col cols="12" md="3">
  <v-select
    v-model="selectedSubcategory"
    :items="filteredSubcategories"
    item-text="name"
    item-value="id"
    label="Filter by Subcategory"
    dense
    variant="underlined"
  ></v-select>
</v-col>

              <v-col cols="12" md="6">
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
            :page.sync="page"
          >
            <template v-slot:item.category="{ item }">
              <span>{{ item.category ? item.category.name : 'N/A' }}</span>
            </template>

            <template v-slot:item.subcategory="{ item }">
              <span>{{ getSubcategoryName(item.subcategory_id) }}</span>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-chip icon color="white" @click="openDialog('edit', item)" elevation="0">
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
                    <v-btn @click="saveFeedback" class="mr-4" width="100%" color="green">
                      <v-icon>mdi-content-save</v-icon> Save
                    </v-btn>
                  </v-col>
                  <v-col>
                    <v-btn @click="dialog.add = false" width="100%" color="red">
                      <v-icon>mdi-cancel</v-icon> Cancel
                    </v-btn>
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
                    <v-btn @click="saveEdit(selectedFeedback)" class="mr-4" width="100%" color="green">
                      <v-icon>mdi-content-save</v-icon> Save
                    </v-btn>
                  </v-col>
                  <v-col>
                    <v-btn @click="dialog.edit = false" width="100%" color="red">
                      <v-icon>mdi-cancel</v-icon> Cancel
                    </v-btn>
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
                  <v-text-field v-model="selectedFeedback.subject" label="Subject" readonly variant="outlined"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="selectedFeedback.name" label="Name" readonly variant="outlined"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="selectedFeedback.email" label="Email" readonly variant="outlined"></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-textarea v-model="selectedFeedback.feedback" label="Feedback" readonly variant="outlined"></v-textarea>
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
import { ref, computed, onMounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { usePage, useForm } from '@inertiajs/vue3';
import {  nextTick } from 'vue';
import jsPDF from 'jspdf';
import 'jspdf-autotable'; // Import jsPDF's autotable plugin if needed
import * as XLSX from 'xlsx';


export default {
  components: {
    AdminLayout,
  },
  setup() {
    const { props } = usePage();

    const headers = [
      { title: 'Category', value: 'category' },
      { title: 'Subcategory', value: 'subcategory' },
      { title: 'Name', value: 'name' },
      { title: 'Email', value: 'email' },
      { title: 'Subject', value: 'subject' },
      { title: 'Feedback', value: 'feedback' },
      { title: 'Feedback Status', value: 'status' },
      { title: 'Actions', value: 'actions', sortable: false },
    ];

    const feedbacks = ref(props.feedbacks || []);
    const categories = ref(props.categories || []);

    const selectedCategory = ref(null);
    const selectedSubcategory = ref(null);
    const search = ref('');

    const dialog = ref({
      add: false,
      edit: false,
      view: false,
      delete: false
    });

    const newFeedback = ref({
      subject: '',
      name: '',
      email: '',
      feedback: ''
    });

    const selectedFeedback = ref(null);

    const formattedCategories = computed(() => {
      return categories.value.map(category => ({
        id: category.id,
        name: category.name
      }));
    });

    const filteredSubcategories = computed(() => {
      const category = categories.value.find(cat => cat.id === selectedCategory.value);
      return category ? category.subcategories.map(sub => ({
        id: sub.id,
        name: sub.name
      })) : [];
    });

    const filteredFeedbacks = computed(() => {
      return feedbacks.value
        .filter(feedback =>
          (!selectedCategory.value || feedback.category_id === selectedCategory.value) &&
          (!selectedSubcategory.value || feedback.subcategory_id === selectedSubcategory.value) &&
          (feedback.subject.toLowerCase().includes(search.value.toLowerCase()) ||
           feedback.name.toLowerCase().includes(search.value.toLowerCase()) ||
           feedback.email.toLowerCase().includes(search.value.toLowerCase()) ||
           feedback.feedback.toLowerCase().includes(search.value.toLowerCase()))
        );
    });

    const getSubcategoryName = (id) => {
      const category = categories.value.find(cat => cat.subcategories.some(sub => sub.id === id));
      const subcategory = category ? category.subcategories.find(sub => sub.id === id) : null;
      return subcategory ? subcategory.name : 'N/A';
    };

    const updateSubcategories = () => {
      selectedSubcategory.value = null;
    };

    const resetFilters = () => {
      selectedCategory.value = null;
      selectedSubcategory.value = null;
      search.value = '';
    };
    const printFeedback = () => {
      const doc = new jsPDF();
      const columns = [
        { header: 'Category', dataKey: 'category' },
        { header: 'Subcategory', dataKey: 'subcategory' },
        { header: 'Name', dataKey: 'name' },
        { header: 'Email', dataKey: 'email' },
        { header: 'Subject', dataKey: 'subject' },
        { header: 'Feedback', dataKey: 'feedback' }
      ];

      // Prepare data for the PDF
      const rows = filteredFeedbacks.value.map(feedback => ({
        category: feedback.category ? feedback.category.name : 'N/A',
        subcategory: getSubcategoryName(feedback.subcategory_id),
        name: feedback.name,
        email: feedback.email,
        subject: feedback.subject,
        feedback: feedback.feedback
      }));

      // Add a title
      doc.setFontSize(18);
      doc.text('All Feedback', 14, 22);

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
    };


    const exportFeedback = () => {
    // Prepare data for the Excel sheet
    const rows = filteredFeedbacks.value.map(feedback => ({
        Category: feedback.category ? feedback.category.name : 'N/A',
        Subcategory: getSubcategoryName(feedback.subcategory_id),
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
};

    const saveFeedback = () => {
      // Implementation for saving new feedback
      useForm(newFeedback.value).post('/feedback').then(() => {
        dialog.value.add = false;
        // Optionally, refresh feedback list or show success message
      });
    };

    const openDialog = (type, feedback) => {
      selectedFeedback.value = feedback;
      dialog.value[type] = true;
    };

    const saveEdit = (feedback) => {
      // Implementation for editing feedback
      useForm(feedback).put(`/feedback/${feedback.id}`).then(() => {
        dialog.value.edit = false;
        // Optionally, refresh feedback list or show success message
      });
    };

    const confirmDelete = (feedback) => {
      // Implementation for deleting feedback
      useForm().delete(`/feedback/${feedback.id}`).then(() => {
        dialog.value.delete = false;
        // Optionally, refresh feedback list or show success message
      });
    };

    onMounted(() => {
      // Additional setup if necessary, e.g., fetching data
    });

    return {
      headers,
      feedbacks,
      categories,
      selectedCategory,
      selectedSubcategory,
      search,
      dialog,
      newFeedback,
      selectedFeedback,
      formattedCategories,
      filteredSubcategories,
      filteredFeedbacks,
      getSubcategoryName,
      updateSubcategories,
      resetFilters,
      printFeedback,
      exportFeedback,
      saveFeedback,
      openDialog,
      saveEdit,
      confirmDelete
    };
  }
};


</script>
