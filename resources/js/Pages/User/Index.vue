<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">User</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">User</li>
      </ol>
    </nav>
    <div class="card my-3 rounded shadow-lg">
      <div class="container my-4">
        <h5 class="fw-bold mb-3">User</h5>

        <!-- Panggil komponen PaginatedTable dan kirimkan data pengguna -->
        <PaginatedTable
          :rows="users"
          :columns="columns"
          :itemsPerPage="3"
          @add="handleAddUser"
          @show="handleShowUser"
          @edit="handleEditUser"
          @delete="handleDeleteUser"
        />
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaginatedTable from "@/Components/PaginatedTable.vue";
import axios from "axios";

export default {
  name: "UserIndex",
  components: {
    MainLayout,
    PaginatedTable,
  },
  props: {
    users: Array, // Prop untuk menerima data pengguna dari Inertia
  },
  data() {
    return {
      columns: [
        { key: "name", label: "Name" },
        { key: "email", label: "Email" },
        { key: "roles", label: "Roles" },
      ],
    };
  },
  methods: {
    handleAddUser() {
      this.$inertia.visit("/user/create");
    },
    handleEditUser(id) {
      this.$inertia.visit(`/user/${id}/edit`);
    },
    handleShowUser(id) {
      this.$inertia.visit(`/user/${id}`);
    },
    handleDeleteUser(id) {
      this.$inertia.delete(`/user/${id}`);
    },
  },
};
</script>
