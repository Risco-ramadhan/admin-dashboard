<template>
    <MainLayout>
      <div class="card mt-5">
        <div class="container my-4">
          <h5 class="fw-bold mb-3">Menu</h5>

          <div>
            <h1>Edit Role: {{ role.name }}</h1>
            <form @submit.prevent="submitForm">
              <h3>Permissions:</h3>
              <div v-for="permission in permissions" :key="permission.id">
                <label>
                  <input
                    type="checkbox"
                    :value="permission.id"
                    v-model="selectedPermissions"
                  />
                  {{ permission.name }}
                </label>
              </div>
              <button class="btn btn-success" type="submit">Update Role</button>
            </form>
          </div>

        </div>
      </div>
    </MainLayout>
  </template>
  
  <script>
  import MainLayout from "@/Layouts/MainLayout.vue";

  export default {
    name: "UserIndex",
    components: {
      MainLayout,
    },
    data() {
      return {
        selectedPermissions: [...this.assigned_permissions],
      };
    },
    props: {
      role: Object,
      permissions: Array,
      assigned_permissions: Array,
    },
    methods: {
      submitForm() {
        this.$inertia.put(route('role.update', this.role.id), {
          permissions: this.selectedPermissions,
        });
      },
    },
    mounted() {
    },
  };
  </script>
  