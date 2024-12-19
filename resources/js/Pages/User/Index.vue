<template>
  <MainLayout>
    <div class="card mt-5">
      <div class="container my-4">
        <h5 class="fw-bold mb-3">User</h5>

        <!-- Panggil komponen PaginatedTable dan kirimkan data pengguna -->
        <PaginatedTable 
          :rows="users" 
          :columns="columns"
          :itemsPerPage="3" 
          @edit="handleEditUser" 
          @delete="handleDeleteUser" 
        />
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaginatedTable from "@/Components/PaginatedTable.vue"; // Import komponen PaginatedTable
import axios from 'axios'; // Jika menggunakan axios untuk API

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
        { key: "email", label: "Email" },
        { key: "roles", label: "Roles" },
      ],
    };
  },
  props: {
    users: Array, // Pastikan Anda mendefinisikan `users` sebagai prop
  },
  methods: {
    // Menangani event edit user
    handleEditUser(user) {
      // Arahkan ke halaman edit atau tampilkan modal
      console.log('Edit user:', user);
      // Misalnya, arahkan ke halaman edit
      this.$inertia.visit(`/users/${user.id}/edit`);
    },

    // Menangani event delete user
    handleDeleteUser(userId) {

      console.log(userId);
      if (confirm("Apakah Anda yakin ingin menghapus pengguna ini?")) {
        axios.delete(`/api/users/${userId}`) // Sesuaikan dengan endpoint API Anda
          .then(() => {
            this.fetchUsers(); // Refresh data pengguna setelah penghapusan
            alert('Pengguna berhasil dihapus!');
          })
          .catch((error) => {
            console.error(error);
            alert('Gagal menghapus pengguna.');
          });
      }
    },
  },
  mounted() {
  },
};
</script>
