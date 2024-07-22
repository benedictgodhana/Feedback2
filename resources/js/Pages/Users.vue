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
          <v-chip color="purple" @click="addMember" label elevation="5">
            <v-icon left>mdi-account-plus</v-icon> Add a member
          </v-chip>
        </v-card-text>
        <v-divider></v-divider>
        <!-- Data Table -->
        <v-data-table
          :headers="headers"
          :items="users"
          :items-per-page="10"
          class="elevation-0"
        >
          <template v-slot:item.roles="{ item }">
            <span>{{ item.roles.join(', ') }}</span> <!-- Join roles into a comma-separated string -->
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
            <v-card-title >Edit User</v-card-title>
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
      <!-- View Dialog -->
<!-- View Dialog -->
<v-dialog v-model="dialog.view" max-width="800px">
  <v-card width="800">
    <v-card-title style="background-color: orange;" class="text-center">View User</v-card-title>
    <v-card-text>
      <v-row>
        <!-- User Information -->
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

        <!-- Profile Information -->
       
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
            <!-- Delete confirmation message -->
            <div>Are you sure you want to delete "{{ selectedUser.name }}"?</div>
            <br>
            <v-row>
              <v-col>
                <v-btn @click="confirmDelete(selectedUser)" class="mr-4" style="text-transform: capitalize;" color="green" width="100%" rounded>
                  <v-icon>mdi-check</v-icon>Confirm
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
    </v-container>
  </AdminLayout>
</template>

<script>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

export default {
  components: {
    AdminLayout,
  },
  data() {
    return {
      users: [],
      selectedUser: {
      name: '',
      email: '',
      roles: [],
      profile: {
        surname: '' // Add other default fields as needed
      }
    },
      headers: [
        { title: 'ID', value: 'id' },
        { title: 'Name', value: 'name' },
        { title: 'Email', value: 'email' },
        { title: 'Roles', value: 'roles' },
        { title: 'Actions', value: 'actions', sortable: false },
      ],
      dialog: {
        edit: false,
        view: false,
        delete: false,
      },
    };
  },
  created() {
    const { props } = usePage();
    this.users = props.users;
  },
  computed: {
    formattedRoles() {
      return this.selectedUser.roles ? this.selectedUser.roles.join(', ') : '';
    }
  },
  methods: {
    openDialog(type, user) {
    // Default profile structure with all necessary fields
    const defaultProfile = {
      surname: '',
      otherNames: '',
      dept: '',
      employmentType: '',
      employeeNo: '',
      dateOfBirth: '',
      sex: '',
      religion: '',
      telR: '',
      telCell: '',
      currentAddress: '',
      residence: '',
      postalAddress: '',
      homeDistrict: '',
      fatherName: '',
      fatherDOB: '',
      fatherOccupation: '',
      motherName: '',
      motherDOB: '',
      motherOccupation: '',
      maritalStatus: '',
      spouseName: '',
      dateOfMarriage: '',
      spouseTel: '',
      children: '',
      siblings: ''
    };

    // Ensure the selected user has a profile with default values
    this.selectedUser = {
      ...user,
      profile: user.profile ? { ...defaultProfile, ...user.profile } : defaultProfile
    };

    // Open the appropriate dialog based on type
    this.dialog[type] = true;

    // Additional logic for different dialog types
    if (type === 'edit') {
      // Logic for edit dialog, if needed
      console.log('Editing user:', this.selectedUser);
    } else if (type === 'view') {
      // Logic for view dialog, if needed
      console.log('Viewing user:', this.selectedUser);
    } else if (type === 'delete') {
      // Logic for delete dialog, if needed
      console.log('Deleting user:', this.selectedUser);
    }
  },
    saveEdit(user) {
      console.log('Saving edit:', user);
      this.dialog.edit = false;
    },
    confirmDelete(user) {
      console.log('Deleting user:', user);
      this.dialog.delete = false;
    },
    importUsers() {
      console.log('Importing users');
    },
    printUsers() {
      console.log('Printing users');
    },
    exportUsers() {
      console.log('Exporting users');
    },
    addMember() {
      console.log('Adding a member');
    },
  },
};
</script>

<style scoped>
/* Add scoped styles here */
</style>
