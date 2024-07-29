<template>
    <AdminLayout>
      <v-container>
        <!-- Main content of the page -->
        <v-card max-width="1500" elevation="0">
          <v-card-title class="text-center" style="background-color: darkblue; color: white;border-radius: 40px;">
            Subcategories Management
            <v-spacer></v-spacer>
            <!-- Import Button -->
          </v-card-title>
          <br>

          <v-card-text>
            <v-chip color="red" @click="importSubcategories" class="mr-4" label elevation="5">
              <v-icon left>mdi-upload</v-icon> Import
            </v-chip>
            <!-- Print Button -->
            <v-chip @click="printSubcategories" class="mr-4" label elevation="5">
              <v-icon left>mdi-printer</v-icon> Print
            </v-chip>
            <!-- Export Button -->
            <v-chip color="green" @click="exportSubcategories" class="mr-4" label elevation="5">
              <v-icon left>mdi-download</v-icon> Export
            </v-chip>
            <!-- Add Subcategory Button -->
            <v-chip color="purple" @click="addSubcategory" label elevation="5">
              <v-icon left>mdi-folder-plus</v-icon> Add Subcategory
            </v-chip>
          </v-card-text>
          <v-divide></v-divide>

          <!-- Data Table -->
          <v-data-table
            :headers="headers"
            :items="subcategories"
            :items-per-page="10"
            class="elevation-0"
          >
            <template v-slot:item.actions="{ item }">
              <!-- Edit Button with Dialog -->
              <v-dialog v-model="dialog.edit" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-tooltip top>
                    <template v-slot:activator="{ on }">
                      <v-chip icon color="white" v-bind="on">
                        <v-icon color="green">mdi-pencil</v-icon>
                      </v-chip>
                    </template>
                    <span>Edit</span>
                  </v-tooltip>
                </template>
                <v-card>
                  <v-card-title>Edit Subcategory</v-card-title>
                  <v-card-text>
                    <!-- Edit form or content here -->
                    <v-btn @click="saveEdit(item)">Save</v-btn>
                    <v-btn @click="dialog.edit = false">Cancel</v-btn>
                  </v-card-text>
                </v-card>
              </v-dialog>

              <!-- Delete Button with Dialog -->
              <v-dialog v-model="dialog.delete" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-tooltip top>
                    <template v-slot:activator="{ on }">
                      <v-chip icon color="white" v-bind="on">
                        <v-icon color="red">mdi-delete</v-icon>
                      </v-chip>
                    </template>
                    <span>Delete</span>
                  </v-tooltip>
                </template>
                <v-card>
                  <v-card-title>Delete Subcategory</v-card-title>
                  <v-card-text>
                    <!-- Delete confirmation message -->
                    <div>Are you sure you want to delete "{{ item.name }}"?</div>
                    <v-btn @click="confirmDelete(item)">Confirm</v-btn>
                    <v-btn @click="dialog.delete = false">Cancel</v-btn>
                  </v-card-text>
                </v-card>
              </v-dialog>
            </template>
          </v-data-table>
        </v-card>
      </v-container>
    </AdminLayout>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';

  const { props } = usePage();
  const subcategories = ref(props.subcategories); // Assuming 'subcategories' prop is passed from backend

  const headers = [
    { title: 'Name', value: 'name' },
    { title: 'Description', value: 'description' },
    { title: 'Category', value: 'category.name' }, // Assuming subcategories belong to categories
    { title: 'Actions', value: 'actions', sortable: false },
  ];

  // Dialog control
  const dialog = {
    edit: false,
    delete: false,
  };

  // Example function for editing a subcategory
  const saveEdit = (subcategory) => {
    // Implement your edit logic here
    console.log('Saving edit:', subcategory);
    dialog.edit = false; // Close the dialog after saving
  };

  // Example function for deleting a subcategory
  const confirmDelete = (subcategory) => {
    // Implement your delete logic here
    console.log('Deleting subcategory:', subcategory);
    dialog.delete = false; // Close the dialog after deleting
  };

  // Example function for importing subcategories
  const importSubcategories = () => {
    // Implement your import logic here
    console.log('Importing subcategories');
  };

  // Example function for printing subcategories
  const printSubcategories = () => {
    // Implement your print logic here
    console.log('Printing subcategories');
  };

  // Example function for exporting subcategories
  const exportSubcategories = () => {
    // Implement your export logic here
    console.log('Exporting subcategories');
  };

  // Example function for adding a new subcategory
  const addSubcategory = () => {
    // Implement your add subcategory logic here
    console.log('Adding a new subcategory');
  };
  </script>

  <style scoped>
  /* Add scoped styles here */
  </style>
