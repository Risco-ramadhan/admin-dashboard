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
              <span>User Management</span>
            </DropdownLink>
          </li>
          <li class="nav-item">
            <DropdownLink :href="route('role')">
              <i class="bi bi-bar-chart me-2"></i>
              <span>Role Management</span>
            </DropdownLink>
          </li>
          <li class="nav-item">
            <DropdownLink :href="route('menu')">
              <i class="bi bi-bar-chart me-2"></i>
              <span>Menu Management</span>
            </DropdownLink>
          </li>
          <li class="nav-item">
            <DropdownLink :href="route('permission.menu')">
              <i class="bi bi-book me-2"></i>
              <span>Permission Menu</span>
            </DropdownLink>
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
