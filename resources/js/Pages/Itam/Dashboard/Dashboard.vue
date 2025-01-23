<template>
  <MainLayout>
    <nav aria-label="breadcrumb" class="bg-light p-2 rounded">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
          <a :href="route('itam.dashboard')" class="text-decoration-none"
            >Seat Management</a
          >
        </li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
      </ol>
    </nav>
    <div class="container mt-4">
      <!-- Summary Cards -->
      <div class="row g-4">
        <div
          class="col-12 col-md-6 col-lg-3"
          v-for="(data, key) in summaryCards"
          :key="key"
        >
          <a href="#" @click.prevent="showAllData(data.type)" class="card-link">
            <div class="card shadow border-0 rounded-3">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1 fw-semibold">{{ data.label }}</p>
                  <h4 class="fw-bold">{{ data.count ?? "Loading..." }}</h4>
                  <small class="text-muted">{{ data.created ?? "Loading..." }}</small>
                </div>
                <div :class="`icon-container ${data.colorClass}`">
                  <i :class="data.icon"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>

      <!-- Tab Navigation -->
      <div class="tabs-container d-flex justify-content-start my-4">
        <button
          v-for="(tab, index) in tabs"
          :key="index"
          class="btn btn-sm me-2"
          :class="{
            'btn-primary': activeTab === tab.id,
            'btn-outline-primary': activeTab !== tab.id,
          }"
          @click="setActiveTab(tab.id)"
        >
          {{ tab.label }}
        </button>
      </div>

      <!-- Tab Content -->
      <div v-if="activeTab === 'alerts'" class="card p-3">
        <Alerts />
      </div>
      <div v-if="activeTab === 'allData'" class="card p-3">
        <AllData :type="selectedType" />
      </div>
      <div v-if="activeTab === 'charts'" class="card p-3">
        <Charts />
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import Alerts from "@/Pages/Itam/Dashboard/Alerts.vue";
import AllData from "@/Pages/Itam/Dashboard/AllData.vue";
import Charts from "@/Pages/Itam/Dashboard/Charts/IndexChart.vue";

export default {
  name: "Dashboard",
  components: {
    MainLayout,
    Alerts,
    AllData,
    Charts,
  },
  data() {
    return {
      activeTab: "alerts",
      selectedType: null,
      summaryCards: [
        {
          label: "CUSTOMER",
          count: null,
          created: null,
          icon: "fas fa-user-friends",
          colorClass: "bg-primary",
          type: "customer",
        },
        {
          label: "ASSET",
          count: null,
          created: null,
          icon: "fas fa-shopping-basket",
          colorClass: "bg-danger",
          type: "asset",
        },
        {
          label: "LICENSE",
          count: null,
          created: null,
          icon: "far fa-id-badge",
          colorClass: "bg-success",
          type: "license",
        },
        {
          label: "CONTRACT",
          count: null,
          created: null,
          icon: "fas fa-file-contract",
          colorClass: "bg-warning",
          type: "contract",
        },
      ],
      tabs: [
        { id: "alerts", label: "Alerts" },
        { id: "allData", label: "All Data" },
        { id: "charts", label: "Charts" },
      ],
    };
  },
  methods: {
    async fetchDashboardData() {
      try {
        const response = await axios.get(
          `${import.meta.env.VITE_API_BASE_URL}/api/itam/dashboard/fetch`
        );
        if (response.data.success) {
          const { render } = response.data;
          const cardKeys = ["customer", "asset", "license", "contract_vendor"];
          this.summaryCards.forEach((card, index) => {
            card.count = render[`${cardKeys[index]}_count`] ?? "N/A";
            card.created = render[`${cardKeys[index]}_created`] ?? "Unknown";
          });
        } else {
          console.warn("API responded with success: false");
        }
      } catch (error) {
        console.error("Data fetching error:", error.message);
      }
    },
    showAllData(type) {
      this.selectedType = type;
      this.activeTab = "allData";
    },
    setActiveTab(tabId) {
      this.activeTab = tabId;
    },
  },
  mounted() {
    this.fetchDashboardData();
    this.intervalId = setInterval(this.fetchDashboardData, 300000);
  },
};
</script>

<style scoped>
.container {
  padding: 15px;
}

.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.icon-container {
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.card .icon-container i {
  font-size: 1.5rem;
  color: white;
}

.tabs-container button {
  transition: transform 0.3s ease, background-color 0.3s ease;
}

.tabs-container button:hover {
  transform: scale(1.05);
}

.card-body {
  padding: 15px;
}

@media (max-width: 768px) {
  .card {
    padding: 10px;
    text-align: center;
  }

  .icon-container {
    width: 40px;
    height: 40px;
  }

  .icon-container i {
    font-size: 1.25rem;
  }
}
</style>
