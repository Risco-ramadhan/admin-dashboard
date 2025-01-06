<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">Home</a>
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
      // Arahkan ke halaman edit atau tampilkan modal
      console.log("Edit user:", id);
      // Misalnya, arahkan ke halaman edit
      this.$inertia.visit(`/menu/${id}/edit`);
    },
    handleShowMenu(id) {
      // Arahkan ke halaman edit atau tampilkan modal
      console.log("Show user:", id);
      // Misalnya, arahkan ke halaman edit
      this.$inertia.visit(`/menu/${id}`);
    },
    // Menangani event delete user
    handleDeleteMenu(userId) {
      console.log(userId);
      if (confirm("Apakah Anda yakin ingin menghapus pengguna ini?")) {
        axios
          .delete(`/api/users/${userId}`) // Sesuaikan dengan endpoint API Anda
          .then(() => {
            this.fetchUsers(); // Refresh data pengguna setelah penghapusan
            alert("Pengguna berhasil dihapus!");
          })
          .catch((error) => {
            console.error(error);
            alert("Gagal menghapus pengguna.");
          });
      }
    },
    handleAddMenu() {
      this.$inertia.visit(`/menu/create`);
    },
  },
  mounted() {},
};
</script>
