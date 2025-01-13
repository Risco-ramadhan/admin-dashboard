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
                    <div
                        class="card p-3 shadow-lg border-0 rounded-3 transition-all ease-in-out transform hover:shadow-2xl hover:scale-105"
                    >
                        <div
                            class="d-flex justify-content-between align-items-center"
                        >
                            <div>
                                <p class="text-muted mb-1 fw-semibold">
                                    {{ data.label }}
                                </p>
                                <h4 class="fw-bold">
                                    {{ data.count ?? "Loading..." }}
                                </h4>
                                <small class="text-muted">{{
                                    data.created ?? "Loading..."
                                }}</small>
                            </div>
                            <div
                                :class="`rounded-circle ${data.colorClass} p-3`"
                            >
                                <i
                                    :class="`${data.icon} text-white`"
                                    style="font-size: 1.5rem"
                                ></i>
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
            <div class="container my-4">
                <h5 class="fw-bold mb-3">All Data</h5>
                <hr />
                <!-- Add content for all data -->
            </div>
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
import Charts from "@/Pages/Itam/Dashboard/Charts/IndexChart.vue";

export default {
    name: "Dashboard",
    components: {
        MainLayout,
        Alerts,
        Charts,
    },
    data() {
        return {
            activeTab: "alerts",
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
            tabs: [
                { id: "alerts", label: "Alerts" },
                { id: "allData", label: "All Data" },
                { id: "charts", label: "Charts" },
            ],
        };
    },

    methods: {
        async fetch() {
            //   const token = localStorage.getItem("token");
            //   if (!token) {
            //     console.error("Token not found");
            //     return;
            //   }

            try {
                const response = await axios.get(
                    `${
                        import.meta.env.VITE_API_BASE_URL
                    }/api/itam/dashboard/fetch`
                    //   {
                    //     headers: { Authorization: `Bearer ${token}` },
                    //   }
                );

                if (!response.data.success) {
                    throw new Error("API responded with success: false");
                }

                const { render } = response.data;
                const cardKeys = [
                    "customer",
                    "asset",
                    "license",
                    "contract_vendor",
                ];
                this.summaryCards.forEach((card, index) => {
                    card.count = render[`${cardKeys[index]}_count`] ?? "N/A";
                    card.created =
                        render[`${cardKeys[index]}_created`] ?? "Unknown";
                });
            } catch (error) {
                console.error("Data fetching error:", error.message);
            }
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
