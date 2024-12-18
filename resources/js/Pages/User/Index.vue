<template>
  <MainLayout>
      <div class="card mt-5">
        <div class="container my-4">
          <h5 class="fw-bold mb-3">User</h5>
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Roles</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(alert, index) in paginatedData" :key="index" :class="getRowClass(alert.duration)">
                  <td>
                    {{ index + 1 }}
                  </td>
                  <td>{{ alert.category }}</td>
                  <td>{{ alert.detail }}</td>
                  <td>{{ alert.time }}</td>
                  <td>{{ alert.duration }}</td>
                </tr>
              </tbody>
            </table>
          </div>
  
          <!-- Pagination -->
          <nav>
            <ul class="pagination justify-content-end">
              <li class="page-item" :class="{ disabled: currentPage === 1 }">
                <a class="page-link" href="#" @click="changePage(currentPage - 1)">«</a>
              </li>
              <li
                class="page-item"
                v-for="page in totalPages"
                :key="page"
                :class="{ active: currentPage === page }"
              >
                <a class="page-link" href="#" @click="changePage(page)">{{ page }}</a>
              </li>
              <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                <a class="page-link" href="#" @click="changePage(currentPage + 1)">»</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";

export default {
  name: "Home",
  components: {
    MainLayout,
  },
  data() {
    return {
      currentPage: 1,
      itemsPerPage: 3,
      alerts: [
        {
          category: "Asset",
          detail: "Akhir masa laptop PTPN sewa akan berakhir <90 hari",
          time: "2025-12-25 08:02:30",
          duration: "1 years 13 minutes",
        },
        {
          category: "License",
          detail: "Lisensi Bitdefender akan berakhir dalam <30 hari",
          time: "2024-10-23 18:03:14",
          duration: "7 days 3 hour 1 minutes",
        },
        {
          category: "License",
          detail: "SSL sinergiland.com akan berakhir <60 hari",
          time: "2024-10-23 09:15:17",
          duration: "7 days 15 hour 6 minutes",
        },
        {
          category: "Contract",
          detail: "[SIG] Sewa Laptop HP Elitebook 830 akan berakhir dalam <60 hari",
          time: "2024-10-22 18:11:14",
          duration: "8 days 3 hour 1 minutes",
        },
      ],
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.alerts.length / this.itemsPerPage);
    },
    paginatedData() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      return this.alerts.slice(start, start + this.itemsPerPage);
    },
  },
  methods: {
    changePage(page) {
      if (page > 0 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },

    // Cek apakah durasi < 90 hari
    isDurationLessThan90(duration) {
      const match = duration.match(/(\d+)\s*days?/);
      if (match) {
        const days = parseInt(match[1]);
        return days < 90;
      }
      return false;
    },
    
     // Cek apakah durasi > 90 hari
     isDurationGreaterThan90(duration) {
      const match = duration.match(/(\d+)\s*days?/);
      if (match) {
        const days = parseInt(match[1]);
        return days > 90;
      }
      return false;
    },

    // Logika untuk menentukan kelas baris tabel
    getRowClass(duration) {
      if (this.isDurationLessThan90(duration)) return "table-danger";
      if (this.isDurationGreaterThan90(duration)) return "table-success";
      return "";
    },
  },
};
</script>

