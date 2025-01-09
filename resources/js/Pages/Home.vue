<template>
  <MainLayout>
    <div class="container mt-5">
      <!-- Informasi User -->
      <div class="user-info text-center mb-4">
        <h4>Welcome, John Doe</h4>
        <p>Your account: john.doe@example.com</p>
      </div>

      <!-- Card Navigation -->
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body text-center">
              <h5 class="card-title"><b>ITAM Dashboard</b></h5>
              <p class="card-text mb-2">This page contains content related to topic 1.</p>
              <a :href="route('itam.dashboard')" class="btn btn-primary btn-sm w-100">
                Go
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body text-center">
              <h5 class="card-title"><b>TICKET Dashboard</b></h5>
              <p class="card-text mb-2">
                This page contains detailed information about topic 2.
              </p>
              <a href="#" class="btn btn-primary btn-sm w-100"> Go </a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body text-center">
              <h5 class="card-title"><b>Page 3</b></h5>
              <p class="card-text mb-2">Learn more about topic 3 on this page.</p>
              <a href="#" class="btn btn-primary btn-sm w-100"> Go </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";

export default {
  name: "NavCardTemplate",
  components: {
    MainLayout,
  },
};
</script>

<style scoped>
.container {
  max-width: 900px;
  margin: auto;
}

.card {
  border: 1px solid #dee2e6;
  border-radius: 0.5rem;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-0.5rem);
  box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
}

.card-title {
  font-size: 1.25rem;
  margin-bottom: 0.5rem;
}

.card-text {
  color: #6c757d;
  font-size: 0.9rem;
}
</style>
