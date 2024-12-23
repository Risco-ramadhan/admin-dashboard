<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-3 py-2 shadow-sm">
    <div class="container-fluid">
      <!-- Logo -->
      <a class="navbar-brand fw-bold" href="#">
        {{ currentMenu }}
      </a>
      <!-- <p class="h2 fw-bold text-decoration-underline">Home</p> -->
      <!-- <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button> -->

      <!-- User Profile Dropdown -->
      <div class="dropdown">
        <!-- Dropdown Toggle -->
        <a
          class="d-flex align-items-center text-decoration-none dropdown-toggle"
          href="#"
          id="dropdownProfile"
          role="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          <img
            src="https://via.placeholder.com/40"
            alt="User Profile"
            class="rounded-circle me-2"
            style="width: 40px; height: 40px;"
          />
          <span class="d-none d-md-inline-block">Fauzi</span>
        </a>

        <!-- Dropdown Menu -->
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownProfile">
          <!-- Profile Info -->
          <li class="dropdown-item d-flex align-items-center">
            <!-- Profile Image -->
            <div class="me-3">
              <img
                src="https://via.placeholder.com/40"
                alt="User Profile"
                class="rounded-circle"
                style="width: 40px; height: 40px;"
              />
            </div>
            <!-- Profile Text -->
            <div class="d-flex flex-column align-items-start">
              <span class="fw-bold text-dark" style="line-height: 1.2;">Fauzi</span>
              <small class="text-muted" style="line-height: 1.2;">Admin</small>
            </div>
          </li>
          <li><hr class="dropdown-divider" /></li>

          <!-- Dropdown Links -->
          <li>
            <a href="#" class="dropdown-item d-flex align-items-center">
              <i class="bi bi-person me-2"></i>
              Profile
            </a>
          </li>
          <li>
            <a href="#" class="dropdown-item d-flex align-items-center">
              <i class="bi bi-gear me-2"></i>
              Settings
            </a>
          </li>
          <li><hr class="dropdown-divider" /></li>
          <li>
            <DropdownLink :href="route('logout')" method="post" as="button">
              <i class="bi bi-box-arrow-left me-2"></i>
              Log Out
            </DropdownLink>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
  import DropdownLink from '@/Components/DropdownLink.vue';
  export default {
    name: "Navbar",
    components: {
      DropdownLink
    },
    props: {
      // Pass the current menu name dynamically from the parent component
      currentMenu: {
        type: String,
        default: "Home", // Default value if no menu name is passed
      },
    },
  };
</script>