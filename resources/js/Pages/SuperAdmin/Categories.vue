<template>
    <AdminLayout>
        <v-container>
            <!-- Main content of the page -->
            <v-card max-width="1500" elevation="0">
                <v-card-title
                    class="text-center"
                    style="
                        background-color: darkblue;
                        color: white;
                        border-radius: 40px;
                    "
                >
                    Categories Management
                    <v-spacer></v-spacer>
                </v-card-title>
                <br />

                <v-card-text>
                    <v-chip
                        color="red"
                        @click="importCategories"
                        class="mr-4"
                        label
                        elevation="5"
                    >
                        <v-icon left>mdi-upload</v-icon> Import
                    </v-chip>
                    <v-chip
                        @click="printCategories"
                        class="mr-4"
                        label
                        elevation="5"
                    >
                        <v-icon left>mdi-printer</v-icon> Print
                    </v-chip>
                    <v-chip
                        color="green"
                        @click="exportCategories"
                        class="mr-4"
                        label
                        elevation="5"
                    >
                        <v-icon left>mdi-download</v-icon> Export
                    </v-chip>
                    <v-chip
                        color="purple"
                        @click="openAddDialog"
                        label
                        elevation="5"
                    >
                        <v-icon left>mdi-folder-plus</v-icon> Add Category
                    </v-chip>
                </v-card-text>
                <v-divider></v-divider>

                <!-- Data Table -->
                <v-data-table
                    :headers="headers"
                    :items="categories"
                    :items-per-page="10"
                    class="elevation-0"
                >
                    <template v-slot:item.actions="{ item }">
                        <!-- Edit Button with Dialog -->
                        <v-chip @click="openEditDialog(item)" color="white">
                            <v-icon color="green">mdi-pencil</v-icon>
                        </v-chip>

                        <!-- Delete Button with Dialog -->
                        <v-chip @click="openDeleteDialog(item)" color="white">
                            <v-icon color="red">mdi-delete</v-icon>
                        </v-chip>
                    </template>
                </v-data-table>
            </v-card>

            <!-- Add Category Dialog -->
            <v-dialog v-model="dialog.add" max-width="500px">
                <v-card>
                    <v-card-title  style="background-color: darkblue;color:white">Add Category</v-card-title>
                    <v-card-text>
                        <v-form v-model="valid">
                            <v-text-field
                                v-model="newCategory.name"
                                label="Category Name"
                                :rules="[rules.required]"
                                required
                                variant="underlined"

                            ></v-text-field>
                            <v-text-field
                                v-model="newCategory.description"
                                label="Description"
                                :rules="[rules.required]"
                                required
                                variant="underlined"

                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                      <v-row>
                        <v-col>
                          <v-btn @click="addCategory" :disabled="!valid" width="100%"
                                    style="
                                        background-color: green;
                                        color: white;
                                        text-transform: capitalize;
                                    "
                            ><v-icon>mdi-content-save-outline</v-icon>Add</v-btn
                        >
                        </v-col>
                        <v-col>
                          <v-btn @click="closeAddDialog"  width="100%"
                                    style="
                                        background-color: red;
                                        color: white;
                                        text-transform: capitalize;
                                    "><v-icon>mdi-close</v-icon>Cancel</v-btn>

                        </v-col>
                      </v-row>

                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- Edit Category Dialog -->
            <v-dialog v-model="dialog.edit" max-width="500px">
                <v-card>
                    <v-card-title style="background-color: darkblue;color:white">Edit Category</v-card-title>
                    <v-card-text>
                        <v-form v-model="valid">
                            <v-text-field
                                v-model="editedItem.name"
                                label="Category Name"
                                :rules="[rules.required]"
                                required
                                variant="underlined"
                            ></v-text-field>
                            <v-text-field
                                v-model="editedItem.description"
                                label="Description"
                                :rules="[rules.required]"
                                required
                                variant="underlined"

                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-row>
                            <v-col>
                                <v-btn
                                    @click="saveEdit"
                                    width="100%"
                                    style="
                                        background-color: green;
                                        color: white;
                                        text-transform: capitalize;
                                    "
                                    ><v-icon>mdi-content-save-outline</v-icon>Save</v-btn
                                >
                            </v-col>
                            <v-col>
                                <v-btn
                                    @click="closeEditDialog"
                                    width="100%"
                                    style="
                                        background-color: red;
                                        color: white;
                                        text-transform: capitalize;
                                    "
                                    ><v-icon>mdi-close</v-icon>Cancel</v-btn
                                >
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- Delete Category Dialog -->
            <v-dialog v-model="dialog.delete" max-width="500px">
                <v-card>
                    <v-card-title
                        style="background-color: darkblue; color: white"
                        >Delete Category</v-card-title
                    >
                    <v-card-text>
                        <div>
                            Are you sure you want to delete "{{
                                deletedItem.name
                            }}"?
                        </div>
                        <br />
                        <v-row>
                            <v-col>
                                <v-btn
                                    @click="confirmDelete"
                                    width="100%"
                                    color="green"
                                    style="text-transform: capitalize;"
                                    ><v-icon>mdi-check</v-icon>Confirm</v-btn
                                >
                            </v-col>
                            <v-col>
                                <v-btn
                                    @click="closeDeleteDialog"
                                    width="100%"
                                    color="red"
                                    style="text-transform: capitalize;"
                                    ><v-icon>mdi-close</v-icon>Cancel</v-btn
                                >
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';

const { props } = usePage();
const categories = ref(props.categories); // Assuming 'categories' prop is passed from backend

const dialog = ref({
  add: false,
  edit: false,
  delete: false,
});

const headers = [
  { title: 'Name', value: 'name' },
  { title: 'Description', value: 'description' },
  { title: 'Actions', value: 'actions', sortable: false },
];

const newCategory = ref({
  name: '',
  description: '',
});

const editedItem = ref({});
const deletedItem = ref({});

const rules = {
  required: value => !!value || 'Required.',
};

const valid = ref(false);
const isLoading = ref(false);
const showAlert = ref(false);
const alertMessage = ref('');
const apiUrl = '/api/categories'; // Replace with your API URL

const validateForm = () => {
  // Implement your form validation logic
  return true;
};

const addCategory = async () => {
  if (!validateForm()) return; // Validate the form before sending

  isLoading.value = true; // Start loading

  try {
    const response = await fetch(`${apiUrl}/create`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: JSON.stringify(newCategory.value),
    });

    if (!response.ok) throw new Error('Failed to add category');

    const result = await response.json();
    categories.value.push(result);
    newCategory.value = { name: '', description: '' };
    showAlert.value = true;
    alertMessage.value = "Category added successfully";
    setTimeout(() => {
      showAlert.value = false;
    }, 4000);
    dialog.value.add = false;
  } catch (error) {
    alertMessage.value = "Failed to add category. Please try again.";
    console.error('Error adding category:', error);
    setTimeout(() => {
      showAlert.value = false;
    }, 4000);
  } finally {
    isLoading.value = false; // Stop loading
  }
};

const saveEdit = async () => {
  if (!validateForm()) return; // Validate the form before sending

  isLoading.value = true; // Start loading

  try {
    const response = await fetch(`${apiUrl}/${editedItem.value.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: JSON.stringify(editedItem.value),
    });

    if (!response.ok) throw new Error('Failed to update category');

    const result = await response.json();
    const index = categories.value.findIndex(cat => cat.id === editedItem.value.id);
    if (index !== -1) categories.value[index] = result;

    showAlert.value = true;
    alertMessage.value = "Category updated successfully";
    setTimeout(() => {
      showAlert.value = false;
    }, 4000);
    dialog.value.edit = false;
  } catch (error) {
    alertMessage.value = "Failed to update category. Please try again.";
    console.error('Error editing category:', error);
    setTimeout(() => {
      showAlert.value = false;
    }, 4000);
  } finally {
    isLoading.value = false; // Stop loading
  }
};

const confirmDelete = async () => {
  isLoading.value = true; // Start loading

  try {
    const response = await fetch(`${apiUrl}/${deletedItem.value.id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
    });

    if (!response.ok) throw new Error('Failed to delete category');

    categories.value = categories.value.filter(cat => cat.id !== deletedItem.value.id);

    showAlert.value = true;
    alertMessage.value = "Category deleted successfully";
    setTimeout(() => {
      showAlert.value = false;
    }, 4000);
    dialog.value.delete = false;
  } catch (error) {
    alertMessage.value = "Failed to delete category. Please try again.";
    console.error('Error deleting category:', error);
    setTimeout(() => {
      showAlert.value = false;
    }, 4000);
  } finally {
    isLoading.value = false; // Stop loading
  }
};

const openAddDialog = () => {
  dialog.value.add = true;
};

const openEditDialog = (item) => {
  editedItem.value = { ...item }; // Copy item to avoid mutating original data
  dialog.value.edit = true;
};

const openDeleteDialog = (item) => {
  deletedItem.value = { ...item }; // Copy item to avoid mutating original data
  dialog.value.delete = true;
};

const closeAddDialog = () => {
  dialog.value.add = false;
};

const closeEditDialog = () => {
  dialog.value.edit = false;
};

const closeDeleteDialog = () => {
  dialog.value.delete = false;
};
</script>

