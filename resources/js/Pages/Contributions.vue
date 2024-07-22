<template>
    <AdminLayout>
      <v-container>
        <v-card max-width="1500" elevation="0">
          <v-card-title class="text-center" style="background-color: darkblue; color: white; border-radius: 40px;">
            Contributions List
            <v-spacer></v-spacer>
          </v-card-title>
          <br>
          <v-card-text>
            <v-chip color="red" @click="importContributions" class="mr-4" label elevation="5">
              <v-icon left>mdi-upload</v-icon> Import
            </v-chip>
            <v-chip @click="printContributions" class="mr-4" label elevation="5">
              <v-icon left>mdi-printer</v-icon> Print
            </v-chip>
            <v-chip color="green" @click="exportContributions" class="mr-4" label elevation="5">
              <v-icon left>mdi-download</v-icon> Export
            </v-chip>
            <v-chip color="purple" @click="addContribution" label elevation="5">
              <v-icon left>mdi-currency-usd</v-icon> Add Contribution
            </v-chip>
          </v-card-text>
          <br>
          <v-data-table
            :headers="headers"
            :items="contributions"
            :items-per-page="10"
            class="elevation-0"
          >
            <template v-slot:item.user="{ item }">
              <span>{{ item.user.name }}</span>
            </template>
            <template v-slot:item.actions="{ item }">
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
                  <v-card-title>Edit Contribution</v-card-title>
                  <v-card-text>
                    <v-btn @click="saveEdit(item)">Save</v-btn>
                    <v-btn @click="dialog.edit = false">Cancel</v-btn>
                  </v-card-text>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialog.view" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-tooltip top>
                    <template v-slot:activator="{ on }">
                      <v-chip icon color="white" v-bind="on">
                        <v-icon color="primary">mdi-eye</v-icon>
                      </v-chip>
                    </template>
                    <span>View</span>
                  </v-tooltip>
                </template>
                <v-card>
                  <v-card-title>View Contribution</v-card-title>
                  <v-card-text>
                    <div>ID: {{ item.id }}</div>
                    <div>Date: {{ item.date }}</div>
                    <div>Description: {{ item.description }}</div>
                    <div>Amount: {{ item.amount }}</div>
                  </v-card-text>
                </v-card>
              </v-dialog>
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
                  <v-card-title>Delete Contribution</v-card-title>
                  <v-card-text>
                    <div>Are you sure you want to delete this contribution?</div>
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
  const contributions = ref(props.contributions);

  const headers = [
    { title: 'ID', value: 'id' },
    { title: 'Date', value: 'date' },
    { title: 'Member Name', value: 'user.name' },
    { title: 'Description', value: 'description' },
    { title: 'Amount', value: 'amount' },
    { title: 'Actions', value: 'actions', sortable: false },
  ];

  const dialog = {
    edit: false,
    view: false,
    delete: false,
  };

  const saveEdit = (contribution) => {
    console.log('Saving edit:', contribution);
    dialog.edit = false;
  };

  const viewContribution = (contribution) => {
    console.log('Viewing contribution:', contribution);
    dialog.view = true;
  };

  const confirmDelete = (contribution) => {
    console.log('Deleting contribution:', contribution);
    dialog.delete = false;
  };

  const importContributions = () => {
    console.log('Importing contributions');
  };

  const printContributions = () => {
    console.log('Printing contributions');
  };

  const exportContributions = () => {
    console.log('Exporting contributions');
  };

  const addContribution = () => {
    console.log('Adding a new contribution');
  };
  </script>

  <style scoped>
  /* Add scoped styles here */
  </style>
