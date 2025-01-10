<template>
  <MainLayout
    ><nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">User</a>
        </li>
        <li class="breadcrumb-item">
          <a href="/menu" class="text-decoration-none">Menu</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Show</li>
      </ol>
    </nav>
    <div class="card my-3 shadow-lg rounded">
      <div class="container" v-if="user">
        <span class="text-start h5 fw-bold mb-5">User Details</span>
        <div class="row pt-3">
          <div class="col-md-8">
            <div class="row mb-3">
              <label for="user_label" class="col-sm-4 col-form-label text-secondary"
                >Username:</label
              >
              <div class="col-sm-8">
                <span id="user_label" class="form-control-plaintext fw-bold">{{
                  user.name
                }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="user_level" class="col-sm-4 col-form-label text-secondary"
                >Level:</label
              >
              <div class="col-sm-8">
                <span id="user_level" class="form-control-plaintext fw-bold">{{
                  user.email
                }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="user_route" class="col-sm-4 col-form-label text-secondary"
                >Role:</label
              >
              <div class="col-sm-8">
                <div v-if="roles && roles.length > 0">
                  <span
                    v-for="(role, index) in roles"
                    :key="index"
                    class="badge bg-primary me-1"
                  >
                    {{ role }}
                  </span>
                </div>
                <div v-else>
                  <span class="text-muted">Tidak ada Role</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <button class="btn btn-secondary me-2" @click="goBack">
            <i class="bi bi-arrow-left"></i> Back
          </button>
          <button class="btn btn-primary" @click="handleEditUser(user.id)">
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
  name: "ViewUser",
  components: {
    MainLayout,
  },
  props: {
    user: {
      type: Object,
      required: true, // Data user harus ada
    },
    roles: Array,
  },
  methods: {
    handleEditUser(id) {
      // Arahkan ke halaman edit atau tampilkan modal
      console.log("Edit user:", id);
      // Misalnya, arahkan ke halaman edit
      this.$inertia.visit(`/user/${id}/edit`);
    },
    goBack() {
      this.$inertia.visit("/user"); // Navigasi kembali ke daftar user
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
