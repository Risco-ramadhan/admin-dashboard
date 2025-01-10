<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">User</a>
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
                    v-model="form.name"
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
                    v-model="form.email"
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
                    v-model="form.password"
                    placeholder="Enter a secure password"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="roles" class="form-label">Roles</label>
                  <v-select
                    v-model="form.roles"
                    :options="roles"
                    label="name"
                    :get-option-label="(option) => option.name"
                    placeholder="Select roles"
                    multiple
                  />
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
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import vSelect from "vue3-select";

export default {
  name: "CreateUser",
  components: {
    MainLayout,
    vSelect,
  },
  setup() {
    const form = useForm({
      name: "",
      email: "",
      password: "",
      roles: [],
    });

    const { props } = usePage();
    const roles = ref(props.roles || []);

    const handleCreateUser = () => {
      form.post("/user", {
        onSuccess: () => {
          form.reset();
        },
      });
    };

    const goBack = () => {
      window.history.back();
    };

    return {
      form,
      handleCreateUser,
      goBack,
      roles,
    };
  },
};
</script>

<style scoped>
@import "vue3-select/dist/vue3-select.css";

/* Custom styling for v-select dropdown */
.v-select {
  width: 100%;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  background-color: #fff;
  font-size: 1rem;
  padding: 0.375rem 0.75rem;
}

.v-select .dropdown-toggle {
  border: none;
  background-color: transparent;
  box-shadow: none;
}

.v-select .dropdown-toggle:hover {
  cursor: pointer;
  background-color: rgba(0, 0, 0, 0.03);
}

.v-select .dropdown-menu {
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  max-height: 300px;
  overflow-y: auto;
  z-index: 1050;
}

.v-select .dropdown-item {
  font-size: 0.9rem;
  padding: 0.5rem 1rem;
  color: #212529;
}

.v-select .dropdown-item:hover {
  background-color: rgba(0, 123, 255, 0.1);
  color: #0056b3;
}

.v-select .dropdown-menu .dropdown-header {
  font-weight: bold;
  font-size: 0.9rem;
  color: #495057;
  background-color: #f8f9fa;
  border-bottom: 1px solid #ced4da;
}

.v-select .dropdown-toggle:focus,
.v-select .dropdown-item:focus {
  outline: none;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

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
