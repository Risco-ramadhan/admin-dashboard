<template>
  <div class="container my-4">
    <h5 class="fw-bold mb-3">Detail Monitoring License < 60 Days</h5>

    <!-- Loading spinner -->
    <div v-if="isLoading" class="text-center">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div v-else>
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
              v-for="(data, index) in paginatedData"
              :key="index"
              :class="getRowClass(data.days_remaining)"
            >
              <td>{{ data.company_name }}</td>
              <td>{{ data.license_name }}</td>
              <td>{{ data.days_remaining }}</td>
              <td>{{ data.expiration_date }}</td>
              <td>{{ data.category_name }}</td>
              <td>{{ data.seats }}</td>
              <td>{{ data.remaining_seats }}</td>
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
            <a class="page-link" href="javascript:void(0)" @click="changePage(page)">
              {{ page }}
            </a>
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
</template>

<script>
export default {
  name: "Alerts",
  data() {
    return {
      currentPage: 1,
      perPage: 5,
      data: [], // Holds the fetched data
      isLoading: false, // A loading indicator
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.data.length / this.perPage);
    },
    paginatedData() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.data.slice(start, start + this.perPage);
    },
  },
  methods: {
    changePage(page) {
      if (page > 0 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },

    async fetchData() {
      this.isLoading = true;
      try {
        const response = await axios.get(
          `${import.meta.env.VITE_API_BASE_URL}/api/itam/dashboard/get-lisence`
        );

        if (response.data && response.data.success) {
          this.data = response.data.render.license_table ?? [];
        } else {
          throw new Error("Failed to fetch license details");
        }
      } catch (error) {
        console.error("Error fetching data:", error.message);
        // Optional: Show error message to user here
      } finally {
        this.isLoading = false;
      }
    },

    getRowClass(daysRemaining) {
      if (daysRemaining < 30) return "table-danger";
      if (daysRemaining < 60) return "table-warning";
      return "table-success";
    },
  },
  mounted() {
    this.fetchData();
    this.intervalId = setInterval(this.fetchData, 300000); // Refresh data every 5 minutes
  },
  beforeDestroy() {
    if (this.intervalId) {
      clearInterval(this.intervalId); // Clear the interval when component is destroyed
    }
  },
};
</script>

<style scoped>
.pagination .page-link {
  cursor: pointer;
  transition: background-color 0.3s, border-color 0.3s;
}

.pagination .page-item.disabled .page-link {
  cursor: not-allowed;
}

.pagination .page-item.active .page-link {
  background-color: #007bff;
  border-color: #007bff;
}

.pagination .page-item .page-link:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

.table {
  border: 1px solid #dee2e6;
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

.spinner-border {
  width: 3rem;
  height: 3rem;
}
</style>
