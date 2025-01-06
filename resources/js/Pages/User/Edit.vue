<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="/user" class="text-decoration-none">User</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
      </ol>
    </nav>
    <div class="card my-3 shadow-lg rounded">
      <div class="container py-4" v-if="user">
        <h5 class="text-start fw-bold mb-4">Edit User</h5>
        <div class="container">
          <form @submit.prevent="handleSubmit">
            <div class="row">
              <!-- Username Input -->
              <div class="col-md-6 mb-3">
                <label for="user_name" class="form-label text-secondary">Username:</label>
                <input
                  type="text"
                  id="user_name"
                  class="form-control"
                  v-model="user.name"
                  placeholder="Enter username"
                  required
                />
              </div>
              <!-- Email Input -->
              <div class="col-md-6 mb-3">
                <label for="user_email" class="form-label text-secondary">Email:</label>
                <input
                  type="email"
                  id="user_email"
                  class="form-control"
                  v-model="user.email"
                  placeholder="Enter email"
                  required
                />
              </div>
              <!-- Role Selection -->
              <div class="col-md-12 mb-3">
                <label for="user_role" class="form-label text-secondary">Role:</label>
                <select
                  id="user_role"
                  class="form-select"
                  v-model="selectedRoles"
                  required
                >
                  <option value="" disabled>Select role</option>
                  <option v-for="role in allRoles" :key="role.name" :value="role.name">
                    {{ role.name }}
                  </option>
                </select>
              </div>
            </div>
            <!-- Action Buttons -->
            <div class="d-flex justify-content-end mt-4">
              <button class="btn btn-secondary me-2" type="button" @click="goBack">
                <i class="bi bi-arrow-left"></i> Back
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Save Edits
              </button>
            </div>
          </form>
        </div>
      </div>
      <!-- Loading State -->
      <div v-else>
        <div
          class="d-flex justify-content-center align-items-center"
          style="height: 200px"
        >
          <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted">Loading user details...</p>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";

export default {
  name: "EditUser",
  components: {
    MainLayout,
  },
  props: {
    user: {
      type: Object,
      required: true,
    },
    allRoles: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      selectedRoles: [], // Data untuk role yang dipilih
    };
  },
  mounted() {
    console.log("All Roles:", this.allRoles);
    console.log("User Roles:", this.user.roles);

    if (this.user.roles) {
      this.selectedRoles = [...this.user.roles];
    }
  },
  methods: {
    handleSubmit() {
      // Kirim data yang diedit ke backend
      this.$inertia.put(`/user/${this.user.id}`, {
        name: this.user.name,
        email: this.user.email,
        roles: this.selectedRoles,
      });
    },
    goBack() {
      this.$inertia.visit("/user");
    },
  },
};
</script>

<style scoped>
/* Responsif untuk perangkat kecil */
@media (max-width: 768px) {
  .form-label {
    font-size: 0.9rem;
  }
  .btn {
    font-size: 0.9rem;
  }
}
</style>
