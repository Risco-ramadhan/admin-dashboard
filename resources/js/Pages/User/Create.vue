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
    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="card rounded shadow-lg">
            <div class="card-header bg-primary text-white">
              <h5 class="fw-bold mb-0 text-center">Create New User</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleCreateUser">
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    v-model="user.name"
                    placeholder="Enter user's name"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    v-model="user.email"
                    placeholder="Enter user's email"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    v-model="user.password"
                    placeholder="Enter a secure password"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="roles" class="form-label">Roles</label>
                  <select class="form-select" id="roles" v-model="user.roles" required>
                    <option disabled value="">Select role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
                </div>
                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" @click="goBack">
                    Cancel
                  </button>
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import { useForm } from "@inertiajs/vue3";

export default {
  name: "CreateUser",
  components: {
    MainLayout,
  },
  setup() {
    const user = useForm({
      name: "",
      email: "",
      password: "",
      roles: "",
    });

    const handleCreateUser = () => {
      user.post("/users", {
        onSuccess: () => {
          user.reset(); // Reset form after successful submission
        },
      });
    };

    return {
      user,
      handleCreateUser,
    };
  },
  methods: {
    goBack() {
      this.$inertia.visit("/user");
    },
  },
};
</script>

<style scoped>
/* Styling for a polished look */
.card {
  border: none;
  padding: 15px;
}

.card-header {
  font-size: 1.25rem;
}

.form-label {
  font-weight: 600;
}

button {
  min-width: 100px;
}
</style>
