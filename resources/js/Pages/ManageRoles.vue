<template>
    <AdminLayout>
      <v-container>
        <!-- Main content of the page -->
        <v-card max-width="1500" elevation="0">
          <v-card-title class="text-center" style="background-color: darkblue; color: white;border-radius: 40px;">
            Roles Management
            <v-spacer></v-spacer>
            <!-- Import Button -->
          </v-card-title>
          <br>

          <v-card-text>
            <v-chip color="red" @click="importRoles" class="mr-4" label elevation="5">
              <v-icon left>mdi-upload</v-icon> Import
            </v-chip>
            <!-- Print Button -->
            <v-chip @click="printRoles" class="mr-4" label elevation="5">
              <v-icon left>mdi-printer</v-icon> Print
            </v-chip>
            <!-- Export Button -->
            <v-chip color="green" @click="exportRoles" class="mr-4" label elevation="5">
              <v-icon left>mdi-download</v-icon> Export
            </v-chip>
            <!-- Add Role Button -->
            <v-chip color="purple" @click="addRole" label elevation="5">
              <v-icon left>mdi-account-plus</v-icon> Add Role
            </v-chip>
          </v-card-text>
          <v-divide></v-divide>

          <!-- Data Table -->
          <v-data-table
            :headers="headers"
            :items="roles"
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
                  <v-card-title>Edit Role</v-card-title>
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
                  <v-card-title>Delete Role</v-card-title>
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
  import AdminLayout from '@/Layouts/AdminLayout.vue';

  const { props } = usePage();
  const roles = ref(props.roles); // Assuming 'roles' prop is passed from backend

  const headers = [
    { title: 'ID', value: 'id' },
    { title: 'Name', value: 'name' },
    { title: 'Guard Name', value: 'guard_name' },
    { title: 'Actions', value: 'actions', sortable: false },
  ];

  // Dialog control
  const dialog = {
    edit: false,
    delete: false,
  };

  // Example function for editing a role
  const saveEdit = (role) => {
    // Implement your edit logic here
    console.log('Saving edit:', role);
    dialog.edit = false; // Close the dialog after saving
  };

  // Example function for deleting a role
  const confirmDelete = (role) => {
    // Implement your delete logic here
    console.log('Deleting role:', role);
    dialog.delete = false; // Close the dialog after deleting
  };

  // Example function for importing roles
  const importRoles = () => {
    // Implement your import logic here
    console.log('Importing roles');
  };

  // Example function for printing roles
  const printRoles = () => {
    // Implement your print logic here
    console.log('Printing roles');
  };

  // Example function for exporting roles
  const exportRoles = () => {
    // Implement your export logic here
    console.log('Exporting roles');
  };

  // Example function for adding a new role
  const addRole = () => {
    // Implement your add role logic here
    console.log('Adding a new role');
  };

  </script>

  <style scoped>
  /* Add scoped styles here */
  </style>
