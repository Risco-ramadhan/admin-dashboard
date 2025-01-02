<template>
  <div>
    <Sidebar :collapsed="sidebarCollapsed" @toggle="toggleSidebar" />
    <div :class="['main-content', sidebarCollapsed ? 'collapsed' : '']">
      <Navbar />
      <div class="container mt-4">
        <div class="content">
          <slot />
        </div>
      </div>
    </div>
  </div>
  </template>
  
  <script>
  import Navbar from "@/Components/Navbar.vue";
  import Sidebar from "@/Components/Sidebar.vue";
  import Footer from "@/Components/Footer.vue";
  
  export default {
  components: {
    Sidebar,
    Navbar,
  },
  data() {
    return {
      sidebarCollapsed: false,
    };
  },
  methods: {
    toggleSidebar() {
      this.sidebarCollapsed = !this.sidebarCollapsed;
    },
  },
};
  </script>
  
  <style>
  .main-content {
    margin-left: 250px;
    transition: margin-left 0.3s ease-in-out;
  }
  
  .main-content.collapsed {
    margin-left: 80px;
  }
  </style>