<template>
  <MainLayout>
    <div class="container mt-4">
      <div class="row g-4 pt-3">
        <!-- Summary Cards -->
        <div
          class="col-12 col-sm-6 col-md-3"
          v-for="(data, key) in summaryCards"
          :key="key"
        >
          <!-- Wrap the card with <a> or add @click -->
          <a
            href="#"
            @click.prevent="showAllData(data.type)"
            class="card-link text-decoration-none"
          >
            <div
              class="card p-3 shadow-lg border-0 rounded-3 transition-all ease-in-out transform hover:shadow-2xl hover:scale-105"
            >
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1 fw-semibold">
                    {{ data.label }}
                  </p>
                  <h4 class="fw-bold">
                    {{ data.count ?? "Loading..." }}
                  </h4>
                  <small class="text-muted">{{ data.created ?? "Loading..." }}</small>
                </div>
                <div :class="`rounded-circle ${data.colorClass} p-3`">
                  <i :class="`${data.icon} text-white`" style="font-size: 1.5rem"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>

    <!-- Button Nav Links -->
    <div class="d-flex justify-content-start my-4">
      <button
        v-for="(tab, index) in tabs"
        :key="index"
        class="btn btn-sm me-2"
        :class="{
          'btn-primary': activeTab === tab.id,
          'btn-outline-primary': activeTab !== tab.id,
        }"
        @click="activeTab = tab.id"
      >
        {{ tab.label }}
      </button>
    </div>

    <!-- Alerts Tab -->
    <div v-if="activeTab === 'alerts'" class="card mt-2">
      <Alerts />
    </div>

    <!-- All Data Tab -->
    <div v-if="activeTab === 'allData'" class="card mt-2">
      <AllData :type="selectedType" />
    </div>

    <!-- Charts Tab -->
    <div v-if="activeTab === 'charts'" class="card mt-2">
      <Charts />
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
      selectedType: null, // Untuk melacak tipe yang dipilih
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
          label: "ASET",
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
    async fetch() {
      try {
        const response = await axios.get(
          `${import.meta.env.VITE_API_BASE_URL}/api/itam/dashboard/fetch`
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
      } catch (error) {
        console.error("Data fetching error:", error.message);
      }
    },

    showAllData(type) {
      this.selectedType = type; // Set the selected type
      this.activeTab = "allData"; // Switch to the "All Data" tab
    },
  },

  mounted() {
    this.fetch();
    this.intervalId = setInterval(this.fetch, 300000);
  },
};
</script>

<style>
/* Add this custom CSS if you're not using a framework like Tailwind */

.card {
  border-radius: 10px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
}

.card:hover {
  box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15), 0 2px 5px rgba(0, 0, 0, 0.12);
  transform: translateY(-5px);
}

.card-body {
  padding: 1.25rem;
}

.card-link {
  color: inherit;
  text-decoration: none;
}
.card-link:hover .card {
  transform: scale(1.05);
  box-shadow: 0 12px 15px rgba(0, 0, 0, 0.2), 0 5px 10px rgba(0, 0, 0, 0.1);
}

.fw-bold {
  font-weight: 700;
}

.fw-semibold {
  font-weight: 600;
}

.text-muted {
  color: #6c757d;
}

button {
  transition: background-color 0.3s, transform 0.2s;
}

button:hover {
  transform: scale(1.05);
  background-color: #0d6efd !important;
}

button:focus {
  outline: none;
  box-shadow: none;
}

.card .rounded-circle {
  width: 60px; /* Make sure width and height are the same */
  height: 60px; /* Ensure the container is square */
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%; /* This ensures the container is circular */
  overflow: hidden; /* Prevents the icon from overflowing */
}

.card .rounded-circle i {
  font-size: 1.5rem; /* Adjust icon size */
  color: white; /* Ensure icon has color for visibility */
}
</style>
