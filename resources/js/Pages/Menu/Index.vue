<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">User</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Menu</li>
      </ol>
    </nav>

    <div class="card my-3 shadow-lg rounded">
      <div class="container my-4">
        <!-- Panggil komponen PaginatedTable dan kirimkan data pengguna -->
        <PaginatedTable
          :rows="menus"
          :columns="columns"
          :itemsPerPage="10"
          :showActionEdit="true"
          :showActionAdd="true"
          :showActionShow="true"
          :showActionDelete="true"
          @edit="handleEditMenu"
          @show="handleShowMenu"
          @delete="handleDeleteMenu"
          @add="handleAddMenu"
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
        { key: "menu_label", label: "Name" },
        { key: "menu_route", label: "Route" },
        { key: "menu_level", label: "Level" },
        { key: "menu_permission", label: "Permission" },
        { key: "menu_parent", label: "Parent" },
        { key: "menu_is_active", label: "Is Active" },
      ],
    };
  },

  props: {
    menus: Array, // Pastikan Anda mendefinisikan `users` sebagai prop
    success: String, // Pesan sukses
    errors: Object, // Pesan error
  },
  methods: {
    handleEditMenu(id) {
      // Misalnya, arahkan ke halaman edit
      this.$inertia.visit(`/menu/${id}/edit`);
    },
    handleShowMenu(id) {
      // Misalnya, arahkan ke halaman edit
      this.$inertia.visit(`/menu/${id}`);
    },
    // Menangani event delete user
    handleDeleteMenu(id) {
      if (confirm("Apakah Anda yakin ingin menghapus menu ini?")) {
        this.$inertia.delete(`/menu/${id}/destroy`);
      }
    },
    handleAddMenu() {
      this.$inertia.visit(`/menu/create`);
    },
  },
  mounted() {},
};
</script>
