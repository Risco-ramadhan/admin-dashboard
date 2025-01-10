<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">User</a>
        </li>
        <li class="breadcrumb-item">
          <a href="/menu" class="text-decoration-none">Permission</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Show</li>
      </ol>
    </nav>
    <div class="card my-3 shadow-lg rounded">
      <div class="container my-4" v-if="menu">
        <h2 class="text-center mb-4">Menu Details</h2>
        <div class="row g-3">
          <div class="col-md-6">
            <div class="row mb-3">
              <label for="menu_label" class="col-sm-4 col-form-label text-secondary"
                >Menu Name:</label
              >
              <div class="col-sm-8">
                <span id="menu_label" class="form-control-plaintext fw-bold">{{
                  menu.menu_label
                }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="menu_level" class="col-sm-4 col-form-label text-secondary"
                >Level:</label
              >
              <div class="col-sm-8">
                <span id="menu_level" class="form-control-plaintext fw-bold">{{
                  menu.menu_level
                }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="menu_permission" class="col-sm-4 col-form-label text-secondary"
                >Permission:</label
              >
              <div class="col-sm-8">
                <div v-if="menu.menu_permission && menu.menu_permission.length > 0">
                  <span
                    v-for="(permission, index) in menu.menu_permission"
                    :key="index"
                    class="badge bg-primary me-1"
                  >
                    {{ permission }}
                  </span>
                </div>
                <div v-else>
                  <span class="form-control-plaintext fw-bold">No Permission</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="row mb-3">
              <label for="menu_route" class="col-sm-4 col-form-label text-secondary"
                >Route:</label
              >
              <div class="col-sm-8">
                <span id="menu_route" class="form-control-plaintext fw-bold">{{
                  menu.menu_route
                }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="menu_is_active" class="col-sm-4 col-form-label text-secondary"
                >Status:</label
              >
              <div class="col-sm-8">
                <span
                  id="menu_is_active"
                  class="badge rounded-pill"
                  :class="menu.menu_is_active ? 'bg-success' : 'bg-danger'"
                >
                  {{ menu.menu_is_active ? "Active" : "Inactive" }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <button class="btn btn-secondary me-2" @click="goBack">
            <i class="bi bi-arrow-left"></i> Back
          </button>
          <button class="btn btn-primary" @click="handleEdit(menu.id)">
            <i class="bi bi-pencil"></i> Edit
          </button>
        </div>
      </div>

      <div v-else>
        <div
          class="d-flex justify-content-center align-items-center"
          style="height: 200px"
        >
          <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted">Loading menu details...</p>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";

export default {
  name: "ViewMenu",
  components: {
    MainLayout,
  },
  props: {
    menu: {
      type: Object,
      required: true, // Data menu harus ada
    },
  },
  methods: {
    handleEdit(id) {
      // Arahkan ke halaman edit atau tampilkan modal
      console.log("Edit user:", id);
      // Misalnya, arahkan ke halaman edit
      this.$inertia.visit(`/menu/${id}/edit`);
    },
    goBack() {
      this.$inertia.visit("/menu"); // Navigasi kembali ke daftar menu
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 900px;
}

.card {
  padding: 30px;
}

th {
  width: 30%;
}

.form-label {
  font-weight: bold;
}

.btn i {
  margin-right: 5px;
}
</style>
