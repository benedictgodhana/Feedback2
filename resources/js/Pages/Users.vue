<template>
    <AdminLayout>
      <v-container>
        <!-- Main content of the page -->
        <v-card max-width="1500" elevation="0">
          <v-card-title class="text-center" style="background-color: darkblue; color: white; border-radius: 40px;">
            Users' List
            <v-spacer></v-spacer>
          </v-card-title>
          <br>
          <v-card-text>
            <v-chip color="red" @click="importUsers" class="mr-4" label elevation="5">
              <v-icon left>mdi-upload</v-icon> Import
            </v-chip>
            <!-- Print Button -->
            <v-chip @click="printUsers" class="mr-4" label elevation="5">
              <v-icon left>mdi-printer</v-icon> Print
            </v-chip>
            <!-- Export Button -->
            <v-chip color="green" @click="exportUsers" class="mr-4" label elevation="5">
              <v-icon left>mdi-download</v-icon> Export
            </v-chip>
            <!-- Add Member Button -->
            <v-chip color="purple" @click="dialog.add = true" label elevation="5">
              <v-icon left>mdi-account-plus</v-icon> Add a member
            </v-chip>
          </v-card-text>
          <v-alert v-if="alert.visible" :type="alert.type" dismissible @click:close="alert.visible = false">
    {{ alert.message }}
  </v-alert>
          <v-divider></v-divider>
          <!-- Data Table -->
          <v-data-table
            :headers="headers"
            :items="users"
            :items-per-page="10"
            class="elevation-0"
          >
            <template v-slot:item.roles="{ item }">
              <span>{{ item.roles.join(', ') }}</span>
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

        <!-- Edit Dialog -->
        <v-dialog v-model="dialog.edit" max-width="800px">
          <v-card>
            <v-toolbar color="orange">
              <v-card-title>Edit User</v-card-title>
              <v-spacer></v-spacer>
              <v-btn @click="dialog.edit = false" color="white" icon><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
            <v-card-text>
              <v-row>
                <v-col>
                  <v-btn @click="saveEdit(selectedUser)" class="mr-4" width="100%" color="green"> <v-icon>mdi-content-save</v-icon>Save</v-btn>
                </v-col>
                <v-col>
                  <v-btn @click="dialog.edit = false" width="100%" color="red"><v-icon>mdi-cancel</v-icon>Cancel</v-btn>
                </v-col>
              </v-row>
              <!-- Edit form or content here -->
            </v-card-text>
          </v-card>
        </v-dialog>

        <!-- View Dialog -->
        <v-dialog v-model="dialog.view" max-width="800px">
          <v-card width="800">
            <v-card-title style="background-color: orange;" class="text-center">View User</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" md="4">
                  <v-text-field
                    v-model="selectedUser.name"
                    label="Name"
                    readonly
                    variant="outlined"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    v-model="selectedUser.email"
                    label="Email"
                    readonly
                    variant="outlined"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    :value="formattedRoles"
                    label="Roles"
                    readonly
                    variant="outlined"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-dialog>

        <!-- Delete Dialog -->
        <v-dialog v-model="dialog.delete" max-width="500px">
          <v-card>
            <v-toolbar color="orange">
              <v-toolbar-title>Delete User</v-toolbar-title>
              <v-btn @click="dialog.delete = false" style="text-transform: capitalize;" color="white" icon elevation="0">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-toolbar>
            <v-card-text>
              <div>Are you sure you want to delete "{{ selectedUser.name }}"?</div>
              <br>
              <v-row>
                <v-col>
                  <v-btn @click="confirmDelete(selectedUser)" class="mr-4" style="text-transform: capitalize;" color="green" width="100%" rounded>
                    <v-icon>mdi-check</v-icon>Confirm

                    <v-progress-circular
                  v-if="loading"
                  indeterminate
                  color="white"
                  size="24"
                  class="mr-2"
                ></v-progress-circular>
                  </v-btn>
                </v-col>
                <v-col>
                  <v-btn @click="dialog.delete = false" style="text-transform: capitalize;" color="red" width="100%" rounded>
                    <v-icon>mdi-cancel</v-icon>Cancel
                  </v-btn>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-dialog>

        <!-- Add User Dialog -->
        <v-dialog v-model="dialog.add" max-width="800px">
          <v-card>
            <v-toolbar style="background-color: darkblue;color:white">
              <v-card-title >Add New User</v-card-title>
              <v-spacer></v-spacer>
              <v-btn @click="dialog.add = false" color="white" icon><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
            <v-card-text>
              <v-form ref="addUserForm">
                <v-row>
                  <v-col cols="12" md="6">
                    <v-text-field
                      v-model="newUserForm.name"
                      label="Name"
                      required
                      variant="underlined"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      v-model="newUserForm.email"
                      label="Email"
                      required
                      variant="underlined"

                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      v-model="newUserForm.password"
                      label="Password"
                      type="password"
                      required
                      variant="underlined"

                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-select
                    v-model="newUserForm.roles"
                    :items="roles"
                    item-value="name"
                    item-text="name"
                    label="Roles"

                    variant="underlined"
                  ></v-select>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-btn @click="saveUser" class="mr-4" width="100%" color="green" :disabled="loading">
                <v-icon v-if="!loading">mdi-content-save</v-icon>
                <v-progress-circular
                  v-if="loading"
                  indeterminate
                  color="white"
                  size="24"
                  class="mr-2"
                ></v-progress-circular>
                Save
              </v-btn>
                  </v-col>
                  <v-col>
                    <v-btn @click="dialog.add = false" width="100%" color="red">
                      <v-icon>mdi-cancel</v-icon>Cancel
                    </v-btn>
                  </v-col>
                </v-row>
              </v-form>


            </v-card-text>
          </v-card>
        </v-dialog>

      </v-container>
    </AdminLayout>
  </template>
<script>
import { ref, computed } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
  components: {
    AdminLayout,
  },
  setup() {
    const { props } = usePage();

    // Reactive variables
    const users = ref(props.users);
    const roles = ref(props.roles);

    const newUserForm = useForm({
      name: '',
      email: '',
      password: '',
      roles: [],
    });

    const deleteUserForm = useForm({});

    const dialog = ref({
      edit: false,
      view: false,
      delete: false,
      add: false,
    });

    const alert = ref({
      visible: false,
      type: '',
      message: '',
    });

    const loading = ref(false); // Add loading state

    const formattedRoles = computed(() => {
      return newUserForm.data.roles ? newUserForm.data.roles.join(', ') : '';
    });

    const saveUser = () => {
        loading.value = true; // Set loading to true when starting the save process
      newUserForm.post('/users', {
        onSuccess: () => {
          alert.value = {
            visible: true,
            type: 'success',
            message: 'User added successfully!',
          };

          setTimeout(() => {
            alert.value.visible = false;
          }, 5000);

          newUserForm.reset();
          dialog.value.add = false; // Corrected to `dialog.value.add`
          loading.value = false; // Reset loading state
        },
        onError: (errors) => {
          console.log('Validation errors:', errors);
          alert.value = {
            visible: true,
            type: 'error',
            message: 'Failed to add user. Please check the form.',
          };
          loading.value = false; // Reset loading state
        },
      });
    };



    const confirmDelete = (user) => {
      // Set the user ID in the deleteUserForm
      deleteUserForm.data.id = user.id;

      loading.value = true; // Show loading state
      deleteUserForm.delete(`/users/${user.id}`, {
        onSuccess: () => {
          loading.value = false; // Hide loading state
          dialog.value.delete = false; // Close the dialog
          alert.value = {
            visible: true,
            message: 'User deleted successfully!',
            type: 'success',
          };

          setTimeout(() => {
            alert.value.visible = false;
          }, 5000);

          // Refresh the user list or remove the user from the local list
          users.value = users.value.filter(u => u.id !== user.id);
        },
        onError: (errors) => {
          loading.value = false; // Hide loading state
          dialog.value.delete = false; // Close the dialog
          alert.value = {
            visible: true,
            message: 'Failed to delete user!',
            type: 'error',
          };
        },
      });
    };

    return {

        headers: [
        { text: 'Name', value: 'name' },
        { text: 'Email', value: 'email' },
        { text: 'Roles', value: 'roles' },
        { text: 'Actions', value: 'actions' },
      ],
        loading, // Return loading state
      users,
      roles,
      selectedUser: {},
      newUserForm,
      dialog,
      alert,
      confirmDelete,
      deleteUserForm,
      formattedRoles,
      saveUser,
      // Other methods
      importUsers() {
        console.log('Import Users');
        // Implement import logic here
      },
      printUsers() {
        console.log('Print Users');
        // Implement print logic here
      },
      exportUsers() {
        console.log('Export Users');
        // Implement export logic here
      },
      openDialog(action, user) {
      this.selectedUser = { ...user };
      if (action === 'edit') {
        this.dialog.edit = true;
      } else if (action === 'view') {
        this.dialog.view = true;
      } else if (action === 'delete') {
        this.dialog.delete = true;
      }
    },
      saveEdit(user) {
        console.log('Save User Edit', user);
        // Implement save logic here
        dialog.value.edit = false;
      },

    };
  },
};
</script>
