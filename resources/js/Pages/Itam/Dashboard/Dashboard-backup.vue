<template>
  <MainLayout>
    <div class="container mt-4">
      <div class="row g-4 pt-3">
        <div
          class="col-12 col-sm-6 col-md-3"
          v-for="(data, key) in summaryCards"
          :key="key"
        >
          <div class="card p-3 shadow-sm border-0 shadow-lg">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted mb-1 fw-semibold">
                  {{ data.label }}
                </p>
                <h4 class="fw-bold">{{ data.count ?? "" }}</h4>
                <small class="text-muted">{{ data.created ?? "Loading..." }}</small>
              </div>
              <div :class="`rounded-circle ${data.colorClass} p-3`">
                <i :class="`${data.icon} text-white`" style="font-size: 1.5rem"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Button Nav Links -->
    <div class="d-flex justify-content-start my-4">
      <button
        v-for="(tab, index) in tabs"
        :key="index"
        class="btn me-2"
        :class="{
          'btn-primary': activeTab === tab.id,
          'btn-outline-primary': activeTab !== tab.id,
        }"
        @click="activeTab = tab.id"
      >
        {{ tab.label }}
      </button>
    </div>

    <div class="card mt-2" v-if="activeTab === 'alerts'">
      <div class="container my-4">
        <h5 class="fw-bold mb-3">Detail Monitoring License < 60 Days</h5>
        <hr />

        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Companies</th>
                <th>License Name</th>
                <th>Remaining Days</th>
                <th>Expiration Date</th>
                <th>Categories</th>
                <th>Total License</th>
                <th>Remaining License</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(alert, index) in paginatedData"
                :key="index"
                :class="getRowClass(alert.days_remaining)"
              >
                <td>{{ alert.company_name }}</td>
                <td>{{ alert.license_name }}</td>
                <td>{{ alert.days_remaining }}</td>
                <td>{{ alert.expiration_date }}</td>
                <td>{{ alert.category_name }}</td>
                <td>{{ alert.seats }}</td>
                <td>{{ alert.remaining_seats }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <nav>
          <ul class="pagination justify-content-end">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a
                class="page-link"
                href="javascript:void(0)"
                @click="changePage(currentPage - 1)"
                >«</a
              >
            </li>
            <li
              class="page-item"
              v-for="page in totalPages"
              :key="page"
              :class="{ active: currentPage === page }"
            >
              <a class="page-link" href="javascript:void(0)" @click="changePage(page)">{{
                page
              }}</a>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <a
                class="page-link"
                href="javascript:void(0)"
                @click="changePage(currentPage + 1)"
                >»</a
              >
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="card mt-2" v-if="activeTab === 'allData'">
      <div class="container my-4">
        <h5 class="fw-bold mb-3">All Data</h5>
        <hr />
      </div>
    </div>

    <div class="card mt-2" v-if="activeTab === 'charts'">
      <div class="container my-4">
        <h5 class="fw-bold mb-3">Charts and Maps</h5>
        <hr />
        <div class="row">
          <!-- Map di kiri -->
          <!-- <div class="col-lg-6 col-12 mb-4">
            <div class="chart-container border p-3 shadow-sm">
              <highcharts :options="mapOptions"></highcharts>
            </div>
          </div> -->

          <!-- Pie Chart di kanan -->
          <div class="col-lg-6 col-12 my-3">
            <div class="chart-container border p-3 shadow-sm">
              <highcharts :options="chartOptions"></highcharts>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import axios from "axios";
import "highcharts/modules/accessibility";
import Highcharts from "highcharts";
import HighchartsVue from "highcharts-vue";

export default {
  name: "ItamDashboard",
  components: {
    MainLayout,
    highcharts: HighchartsVue.component,
  },
  data() {
    return {
      currentPage: 1,
      itemsPerPage: 5,
      intervalId: null,
      activeTab: "alerts",
      tabs: [
        { id: "alerts", label: "Alerts" },
        { id: "allData", label: "All Data" },
        { id: "charts", label: "Charts" },
      ],
      summaryCards: [
        {
          label: "CUSTOMER",
          count: null,
          created: null,
          icon: "fas fa-user-friends",
          colorClass: "bg-primary",
        },
        {
          label: "ASET",
          count: null,
          created: null,
          icon: "fas fa-shopping-basket",
          colorClass: "bg-danger",
        },
        {
          label: "LICENSE",
          count: null,
          created: null,
          icon: "far fa-id-badge",
          colorClass: "bg-success",
        },
        {
          label: "CONTRACT",
          count: null,
          created: null,
          icon: "fas fa-file-contract",
          colorClass: "bg-warning",
        },
      ],

      // Opsi untuk chart biasa
      chartOptions: {
        chart: {
          type: "pie",
        },
        title: {
          text: "Sales Distribution by Product",
        },
        plotOptions: {
          pie: {
            innerSize: "50%", // Donut style
            dataLabels: {
              enabled: true,
              format: "{point.name}: {point.percentage:.1f}%",
            },
          },
        },
        colors: ["#FF5733", "#33FF57", "#3357FF"], // Warna untuk setiap segmen
        legend: {
          enabled: true, // Aktifkan legend
          layout: "horizontal", // Menata legend secara horizontal
          align: "center", // Menata legend di tengah
          verticalAlign: "bottom", // Menata legend di bagian bawah
          borderWidth: 0, // Menyembunyikan border legend
          itemStyle: {
            fontSize: "14px", // Ukuran font legend
          },
        },
        series: [
          {
            name: "Sales Distribution",
            data: [
              { name: "Product A", y: 29.9 },
              { name: "Product B", y: 71.5 },
              { name: "Product C", y: 106.4 },
            ],
          },
        ],
      },

      alerts: [],
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
    async fetch() {
      //   const token = localStorage.getItem("token");
      //   if (!token) {
      //     console.error("Token not found");
      //     return;
      //   }

      try {
        const response = await axios.get(
          `${import.meta.env.VITE_API_BASE_URL}/api/itam/dashboard/fetch`
          //   {
          //     headers: { Authorization: `Bearer ${token}` },
          //   }
        );

        if (!response.data.success) {
          throw new Error("API responded with success: false");
        }

        const { render } = response.data;
        const cardKeys = ["customer", "asset", "license", "contract_vendor"];
        this.summaryCards.forEach((card, index) => {
          card.count = render[`${cardKeys[index]}_count`] ?? "N/A";
          card.created = render[`${cardKeys[index]}_created`] ?? "Unknown";
        });
        this.alerts = render.license_table ?? [];
      } catch (error) {
        console.error("Data fetching error:", error.message);
        // Optional: Show error message to the user here
      }
    },

    getRowClass(daysRemaining) {
      if (daysRemaining < 30) return "table-danger";
      if (daysRemaining < 60) return "table-warning";
      return "table-success";
    },
  },
  mounted() {
    this.fetch();
    this.intervalId = setInterval(this.fetch, 300000);
  },
  beforeUnmount() {
    clearInterval(this.intervalId);
  },
};
</script>

<style scoped>
.card {
  border-radius: 12px;
  transition: transform 0.2s ease-in-out;
}

.rounded-circle {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
}

@media (max-width: 768px) {
  .card {
    text-align: center;
    padding: 1rem;
  }

  .rounded-circle {
    margin: 0 auto;
    width: 50px;
    height: 50px;
  }

  .card p,
  .card h4,
  .card small {
    text-align: center;
  }
}

.btn {
  border-radius: 12px;
}

.table-danger {
  background-color: #f8d7da !important;
  color: #721c24 !important;
}

.table-warning {
  background-color: #fff3cd !important;
  color: #856404 !important;
}

.table-success {
  background-color: #d4edda !important;
  color: #155724 !important;
}

.chart-container {
  min-height: 400px; /* Ukuran minimum untuk grafik */
  border-radius: 12px;
  background-color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
