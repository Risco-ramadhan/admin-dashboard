<template>
  <MainLayout>
      <div class="container mt-4">
        <p class="h2 fw-bold text-decoration-underline">Home</p>
        <div class="row g-4 pt-3">
          <!-- Card 1: Today's Money -->
          <div class="col-md-3">
            <div class="card p-3 shadow-sm border-0 shadow-lg">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1 fw-semibold">CUSTOMER</p>
                  <h4 class="fw-bold">$53,000</h4>
                  <span class="text-success fw-semibold">+55%</span>
                  <small class="text-muted"> since yesterday</small>
                </div>
                <div class="rounded-circle bg-danger p-3">
                  <i class="fas fa-user-friends text-white" style="font-size: 1.5rem;"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 2: Today's Users -->
          <div class="col-md-3">
            <div class="card p-3 shadow-sm border-0 shadow-lg">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1 fw-semibold">ASET</p>
                  <h4 class="fw-bold">2,300</h4>
                  <span class="text-success fw-semibold">+3%</span>
                  <small class="text-muted"> since last week</small>
                </div>
                <div class="rounded-circle bg-danger p-3">
                  <i class="fas fa-shopping-basket text-white" style="font-size: 1.5rem;"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 3: New Clients -->
          <div class="col-md-3">
            <div class="card p-3 shadow-sm border-0 shadow-lg">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1 fw-semibold">LICENSE</p>
                  <h4 class="fw-bold">+3,462</h4>
                  <span class="text-danger fw-semibold">-2%</span>
                  <small class="text-muted"> since last quarter</small>
                </div>
                <div class="rounded-circle bg-success p-3">
                  <i class="far fa-id-badge text-white" style="font-size: 1.5rem;"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 4: Sales -->
          <div class="col-md-3">
            <div class="card p-3 shadow-sm border-0 shadow-lg">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1 fw-semibold">CONTRACT</p>
                  <h4 class="fw-bold">$103,430</h4>
                  <span class="text-success fw-semibold">+5%</span>
                  <small class="text-muted"> than last month</small>
                </div>
                <div class="rounded-circle bg-warning p-3">
                  <i class="fas fa-file-contract text-white" style="font-size: 1.5rem;"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-5">
        <div class="container my-4">
          <h5 class="fw-bold mb-3">Alerts</h5>
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Alert</th>
                  <th>Category</th>
                  <th>Detail</th>
                  <th>Time</th>
                  <th>Duration</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(alert, index) in paginatedData" :key="index" :class="getRowClass(alert.duration)">
                  <td>
                    <div class="d-flex align-items-center">
                      <!-- Ikon Danger Jika Durasi < 90 Hari -->
                      <i
                        v-if="isDurationLessThan90(alert.duration)"
                        class="bi bi-exclamation-triangle-fill text-danger me-2"
                      ></i>
                      <i
                        v-else-if="isDurationGreaterThan90(alert.duration)"
                        class="bi bi-check-circle-fill text-success me-2"
                      ></i>
                    </div>
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

<style scoped>
.card {
  border-radius: 12px;
}

.rounded-circle {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.text-success {
  color: #28a745 !important;
}

.text-danger {
  color: #dc3545 !important;
}

.bg-danger {
  background-color: #f44336 !important;
}

.bg-success {
  background-color: #00d09c !important;
}

.bg-warning {
  background-color: #ff9800 !important;
}

.table th,
.table td {
  vertical-align: middle;
}

.progress {
  height: 6px;
  background-color: #e9ecef;
}

.table-danger {
  background-color: #f8d7da !important;
  color: #721c24 !important;
}

.table-success {
  background-color: #d4edda !important;
  color: #155724 !important;
}

.page-item.active .page-link {
  background-color: #6f42c1;
  border-color: #6f42c1;
  color: #fff;
}

.page-link {
  color: #6f42c1;
}
</style>
