<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">User</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Permission</li>
      </ol>
    </nav>

    <div class="card my-3 rounded shadow-lg">
      <div class="container my-4">
        <!-- Panggil komponen PaginatedTable dan kirimkan data pengguna -->
        <PaginatedTable
          :rows="permissions"
          :columns="columns"
          :itemsPerPage="10"
          :showActionEdit="true"
          :showActionAdd="true"
          :showActionShow="false"
          :showActionDelete="true"
          @edit="handleEditPermission"
          @delete="handleDeletePermission"
          @add="handleAddPermission"
        />
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaginatedTable from "@/Components/PaginatedTable.vue"; // Import komponen PaginatedTable
import axios from "axios"; // Jika menggunakan axios untuk API

export default {
  name: "UserIndex",
  components: {
    MainLayout,
    PaginatedTable,
  },
  data() {
    return {
      users: [],
      columns: [
        { key: "name", label: "Name" },
        { key: "guard_name", label: "Guard Name" },
      ],
    };
  },
  props: {
    permissions: Array, // Pastikan Anda mendefinisikan `users` sebagai prop
  },
  methods: {
    handleAddPermission() {
      this.$inertia.visit("/permission/create");
    },
    handleEditPermission(id) {
      this.$inertia.visit(`/permission/${id}/edit`);
    },
    handleDeletePermission(id) {
      if (confirm("Apakah Anda yakin ingin menghapus permission ini?")) {
        this.$inertia.delete(`/permission/${id}`);
      }
    },
  },
  mounted() {},
};
</script>
