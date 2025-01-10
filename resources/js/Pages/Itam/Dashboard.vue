<template>
  <MainLayout>
    <div class="container mt-4">
      <div class="row g-4 pt-3">
        <!-- Card 1: Today's Money -->
        <div class="col-md-3" v-for="(data, key) in summaryCards" :key="key">
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

    <div class="card mt-5">
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
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import axios from "axios";

export default {
  name: "Home",
  components: {
    MainLayout,
  },
  data() {
    return {
      currentPage: 1,
      itemsPerPage: 5,
      intervalId: null,
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
      try {
        const token = localStorage.getItem("token");
        const response = await axios.get(
          `${import.meta.env.VITE_API_BASE_URL}/api/itam/dashboard/fetch`,
          {
            headers: { Authorization: `Bearer ${token}` },
          }
        );
        if (response.data.success) {
          const render = response.data.render;
          const cardKeys = ["customer", "asset", "license", "contract_vendor"];
          this.summaryCards.forEach((card, index) => {
            card.count = render[`${cardKeys[index]}_count`];
            card.created = render[`${cardKeys[index]}_created`];
          });
          this.alerts = render.license_table;
        } else {
          console.error("Failed to fetch data");
        }
      } catch (error) {
        console.error("Error while fetching data:", error);
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
}

.rounded-circle {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
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
</style>
