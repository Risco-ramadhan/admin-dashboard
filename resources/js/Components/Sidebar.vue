<template>
  <div :class="['sidebar', collapsed ? 'collapsed' : 'expanded']">
    <ul class="ms-2">
      <li
        @click="$emit('toggle')"
        class="d-flex justify-content-center align-items-center py-3"
      >
        <img
          src="../../../public/assets/images/logo_sisi.webp"
          class="img-fluid"
          alt="Logo"
          style="max-width: 100%; max-height: 50px"
        />
      </li>
      <!-- <li @click="$emit('toggle')">
        <i class="bi bi-list"></i>
        <img src="../../../public/assets/images/logo_sisi.webp" class="img-fluid" alt="Sample image" />
      </li> -->

      <!-- Dashboard Menu with Dropdown -->
      <a :href="route('dashboard')">
        <li class="nav-item">
          <i class="bi bi-house-door me-2"></i>
          <span v-if="!collapsed">Home</span>
        </li>
      </a>
      <a :href="route('itam.dashboard')">
        <li class="nav-item">
          <i class="bi bi-option me-2"></i>
          <span v-if="!collapsed">Seat Management</span>
        </li>
      </a>
      <li class="nav-item">
        <a
          href="#"
          class="d-flex justify-content-between align-items-center"
          @click="toggleDropdown"
          style="cursor: pointer"
        >
          <div>
            <i class="fas fa-users-cog me-2"></i>
            <span v-if="!collapsed">User</span>
          </div>
          <i
            v-if="!collapsed"
            :class="dropdownOpen ? 'bi bi-chevron-up' : 'bi bi-chevron-down'"
          ></i>
        </a>

        <!-- Dropdown Content -->
        <ul class="nav" v-show="dropdownOpen">
          <li class="nav-item">
            <a :href="route('user.index')">
              <i class="fas fa-user-cog"></i>
              <span v-if="!collapsed">User Management</span>
            </a>
          </li>
          <li class="nav-item">
            <a :href="route('role.index')">
              <i class="fas fa-user-shield"></i>
              <span v-if="!collapsed">Role Management</span>
            </a>
          </li>
          <li class="nav-item">
            <a :href="route('menu.index')">
              <i class="fas fa-user-tag"></i>
              <span v-if="!collapsed">Menu Management</span>
            </a>
          </li>
          <li class="nav-item">
            <a :href="route('permission.index')">
              <i class="fas fa-user-lock"></i>
              <span v-if="!collapsed">Permission Menu</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- <a :href="route('itam')">
                <li class="nav-item">
                    <i class="bi bi-app me-2"></i>
                    <span v-if="!collapsed">Itam</span>
                </li>
            </a> -->
    </ul>
  </div>
</template>

<script>
import DropdownLink from "@/Components/DropdownLink.vue";
import Logo from "../../../public/assets/images/logo_sisi.webp";

export default {
  name: "Sidebar",
  components: {
    DropdownLink,
    Logo,
  },
  props: {
    collapsed: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      dropdownOpen: false,
    };
  },
  methods: {
    toggleDropdown() {
      this.dropdownOpen = !this.dropdownOpen;
    },
  },
};
</script>

<style>
.sidebar {
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  background-color: #1a1a2e;
  color: white;
  transition: width 0.3s ease-in-out;
  overflow-x: hidden;
}

.sidebar.collapsed {
  width: 80px;
}

.sidebar.expanded {
  width: 250px;
}

.sidebar ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.sidebar ul li {
  padding: 15px;
  text-align: left;
  cursor: pointer;
}

.sidebar ul li i {
  font-size: 18px;
}

.sidebar ul li span {
  margin-left: 10px;
}

.nav-link {
  text-decoration: none;
  color: white;
}

.nav-link:hover {
  color: #cccccc;
}

.nav .nav-item {
  padding-left: 10px;
}
</style>
