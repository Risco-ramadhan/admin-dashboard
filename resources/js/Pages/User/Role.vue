<template>
  <MainLayout>
    <div class="card mt-5">
      <div class="container my-4">
        <h5 class="fw-bold mb-3">Menu</h5>

        <!-- Panggil komponen PaginatedTable dan kirimkan data pengguna -->
        <PaginatedTable 
          :rows="roles" 
          :columns="columns"
          :itemsPerPage="3"
          :showActionEdit="true" 
          :showActionAdd="true" 
          :showActionShow="true" 
          :showActionDelete="true" 
          @edit="handleEdit" 
          @show="handleShow" 
          @delete="handleDelete"
          @add="handleAddRole" 
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
        { key: "guard_name", label: "guard name" },
        { key: "permissions_count", label: "Menu access" },
      ],
    };
  },
  props: {
    roles: Array, // Pastikan Anda mendefinisikan `users` sebagai prop
  },
  methods: {
    // Menangani event edit user
    handleEdit(id) {
      // Arahkan ke halaman edit atau tampilkan modal
      console.log('Edit user:', id);
      // Misalnya, arahkan ke halaman edit
      this.$inertia.visit(`/role/${id}/edit`);
    },
    handleShow(id) {
      // Arahkan ke halaman edit atau tampilkan modal
      console.log('Show user:', id);
      // Misalnya, arahkan ke halaman edit
      this.$inertia.visit(`/role/${id}`);
    },
    // Menangani event delete user
    handleDelete(userId) {

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
    handleAddRole(){
      alert('Tambah');
    }
  },
  mounted() {
  },
};
</script>
