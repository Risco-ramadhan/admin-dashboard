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
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
      </ol>
    </nav>
    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="card rounded shadow-lg">
            <div class="card-header bg-primary text-white">
              <h5 class="fw-bold mb-0 text-center">Edit User</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleUpdateUser">
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
                  <label for="roles" class="form-label">Roles</label>
                  <v-select
                    v-model="form.roles"
                    :options="allRoles"
                    label="name"
                    :get-option-label="(option) => option.name"
                    placeholder="Select roles"
                    multiple
                    track-by="id"
                  />
                </div>
                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" @click="goBack">
                    Cancel
                  </button>
                  <button type="submit" class="btn btn-primary">Update</button>
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
  name: "EditUser",
  components: {
    MainLayout,
    vSelect,
  },
  setup() {
    const { props } = usePage();
    const allRoles = ref(props.roles || []); // All available roles

    // Initialize form with the assigned_roles (which should be an array of selected role IDs)
    const form = useForm({
      name: props.user.name || "",
      email: props.user.email || "",
      roles: props.user.assigned_roles || [], // Initialize with assigned role IDs
    });

    const handleUpdateUser = () => {
      form.put(`/user/${props.user.id}`, {
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
      handleUpdateUser,
      goBack,
      allRoles,
    };
  },
};
</script>
