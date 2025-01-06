<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Role</li>
      </ol>
    </nav>

    <div class="card my-3 rounded shadow-lg">
      <div class="container my-4">
        <div v-if="roles && roles.length">
          <PaginatedTable
            :rows="roles"
            :columns="columns"
            :itemsPerPage="5"
            :showActionEdit="true"
            :showActionAdd="true"
            :showActionShow="true"
            :showActionDelete="true"
            @edit="handleEditRole"
            @show="handleShowRole"
            @delete="handleDeleteRole"
            @add="handleAddRole"
          />
        </div>
        <p v-else>No roles found.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaginatedTable from "@/Components/PaginatedTable.vue";
import axios from "axios";

export default {
  name: "RoleIndex",
  components: {
    MainLayout,
    PaginatedTable,
  },
  props: {
    roles: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      columns: [
        { key: "name", label: "Name" },
        { key: "guard_name", label: "guard name" },
        { key: "permissions_count", label: "Menu access" },
      ],
    };
  },
  methods: {
    handleAddRole() {
      this.$inertia.visit("/role/create");
    },
    handleShowRole(id) {
      this.$inertia.visit(`/role/${id}`);
    },
    handleEditRole(id) {
      this.$inertia.visit(`/role/${id}/edit`);
    },
    handleDeleteRole(id) {
      if (confirm("Apakah Anda yakin ingin menghapus role ini?")) {
        this.$inertia.delete(`/role/${id}`);
      }
    },
  },
};
</script>
