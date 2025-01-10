<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">User</a>
        </li>
        <li class="breadcrumb-item">
          <a href="/role" class="text-decoration-none">Role</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
      </ol>
    </nav>

    <div class="container my-3">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="card rounded shadow-lg">
            <div class="card-header bg-primary text-white">
              <h5 class="fw-bold mb-0 text-center">Create New Role</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleCreateRole">
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    v-model="form.name"
                    placeholder="Enter role's name"
                    required
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
import { useForm } from "@inertiajs/vue3";

export default {
  name: "CreateRole",
  components: {
    MainLayout,
  },
  setup() {
    const form = useForm({
      name: "",
    });

    const handleCreateRole = () => {
      form.post("/role", {
        onSuccess: () => {
          form.reset(); // Reset form after successful submission
        },
      });
    };

    return {
      form, // Return 'form' to be used in the template
      handleCreateRole,
    };
  },
  methods: {
    goBack() {
      this.$inertia.visit("/role");
    },
  },
};
</script>
