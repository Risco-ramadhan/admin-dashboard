<template>
  <div class="container mt-4">
    <h3 class="fw-bold mb-3 text-capitalize">{{ type }} Details</h3>

    <!-- Loading Spinner -->
    <div v-if="isLoading" class="text-center">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <!-- Table displaying the data -->
    <div v-else>
      <table class="table table-bordered table-hover mt-3">
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
          <!-- <tr v-for="(row, index) in data" :key="index">
            <td>{{ row.company_name }}</td>
            <td>{{ row.license_name }}</td>
            <td>{{ row.days_remaining }}</td>
            <td>{{ row.expiration_date }}</td>
            <td>{{ row.category_name }}</td>
            <td>{{ row.seats }}</td>
            <td>{{ row.remaining_seats }}</td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AllData",

  props: {
    type: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      isLoading: false, // Loading state
      data: [], // Holds the fetched data
    };
  },

  watch: {
    type(newType) {
      console.log("New Type in AllData Component: ", newType);
      this.loadData(newType); // Call method to load data based on the new type
    },
  },

  methods: {
    async loadData(type) {
      this.isLoading = true; // Set loading to true
      try {
        const response = await axios.get(
          `${
            import.meta.env.VITE_API_BASE_URL
          }/api/itam/dashboard/detail-summary-cards/${type}`
        );

        if (response.data && response.data.success) {
          // Assuming response.data.render is the array containing the required data
          this.data = response.data.render ?? [];
        } else {
          throw new Error("Failed to load data");
        }
      } catch (error) {
        console.error("Error loading data:", error.message);
      } finally {
        this.isLoading = false; // Set loading to false after the data is fetched
      }
    },
  },

  mounted() {
    this.loadData(this.type); // Load data when component is mounted
  },
};
</script>

<style>
/* Add your styles here for detail pages */
</style>
