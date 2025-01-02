<template>
  <MainLayout>
    <div class="card my-5 rounded shadow-lg">
      <div class="container my-4">
        <h5 class="fw-bold mb-3">Role</h5>

        <!-- Panggil komponen PaginatedTable dan kirimkan data pengguna -->
        <PaginatedTable 
          :rows="roles" 
          :columns="columns"
          :itemsPerPage="3"
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
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaginatedTable from "@/Components/PaginatedTable.vue"; // Import komponen PaginatedTable
import axios from 'axios'; // Jika menggunakan axios untuk API

export default {
  name: "RoleIndex",
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
    roles: Array,
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
        axios.delete(`/api/roles/${id}`)
          .then(() => {
            this.fetchRoles(); // Refresh data roles setelah penghapusan
            alert('Role berhasil dihapus!');
          })
          .catch((error) => {
            console.error(error);
            alert('Gagal menghapus role.');
          });
      }
    }
  },

  mounted() {
  },
};
</script>
