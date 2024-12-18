<template>
  <div class="sidebar bg-white border-end shadow-sm" style="width: 230px; min-height: 100vh;">
    <!-- Sidebar Header -->
    <div class="mt-4 ps-3 text-muted small fw-bold">Dashboard</div>

    <!-- Sidebar Menu -->
    <ul class="nav flex-column">
      <!-- Home Menu -->
      <li class="nav-item">
        <DropdownLink :href="route('dashboard')">
          <i class="bi bi-house-door me-2"></i>
          <span>Home</span>
        </DropdownLink>
      </li>

      <!-- Dashboard with Dropdown -->
      <li class="nav-item">
        <a
          href="#"
          class="nav-link d-flex justify-content-between align-items-center"
          @click="toggleDropdown"
          style="cursor: pointer;"
        >
          <div>
            <i class="bi bi-columns me-2"></i>
            <span>Dashboard</span>
          </div>
          <i :class="dropdownOpen ? 'bi bi-chevron-up' : 'bi bi-chevron-down'"></i>
        </a>

        <!-- Dropdown Content -->
        <ul class="nav flex-column ps-4" v-show="dropdownOpen">
          <li class="nav-item">
            <DropdownLink :href="route('user')">
              <i class="bi bi-bar-chart me-2"></i>
              <span>Site Management</span>
            </DropdownLink>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link d-flex align-items-center" @click.prevent="navigateTo('/crm')">
              <i class="bi bi-people me-2"></i>
              <span>CRM</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link d-flex align-items-center" @click.prevent="navigateTo('/ecommerce')">
              <i class="bi bi-cart me-2"></i>
              <span>ECommerce</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link d-flex align-items-center" @click.prevent="navigateTo('/academy')">
              <i class="bi bi-book me-2"></i>
              <span>Academy</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link d-flex align-items-center" @click.prevent="navigateTo('/logistics')">
              <i class="bi bi-truck me-2"></i>
              <span>Logistics</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script>
import DropdownLink from '@/Components/DropdownLink.vue';

export default {
  name: "Sidebar",
  data() {
    return {
      dropdownOpen: false, // Awalnya dropdown dalam keadaan tertutup
    };
  },
  components : {
    DropdownLink
  },
  methods: {
    toggleDropdown() {
      this.dropdownOpen = !this.dropdownOpen;
    },
    navigateTo(route) {
      console.log('Mantap');
      Inertia.get(route);
    },
  },
};
</script>

<style scoped>
.sidebar {
  font-size: 0.9rem;
  background-color: #fff;
}

.nav-link {
  color: #6c757d;
  transition: all 0.3s ease;
}

.nav-link:hover {
  color: #6f42c1;
  background-color: #f3f2f7;
  border-radius: 5px;
}

.bi {
  font-size: 1rem;
}

.nav-item {
  margin-bottom: 5px;
}

.nav-link span {
  font-size: 0.9rem;
}

.nav {
  margin-top: 10px;
}
</style>
