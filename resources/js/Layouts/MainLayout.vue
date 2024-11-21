<template>
    <div class="layout">
      <!-- Navbar -->
      <Navbar />
  
      <div class="main-content">
        <!-- Sidebar -->
        <Sidebar />
  
        <!-- Slot for page content -->
        <div class="content">
          <slot />
        </div>
      </div>
  
      <!-- Footer -->
      <Footer />
    </div>
  </template>
  
  <script>
  import Navbar from "@/Components/Navbar.vue";
  import Sidebar from "@/Components/Sidebar.vue";
  import Footer from "@/Components/Footer.vue";
  
  export default {
    name: "MainLayout",
    components: {
      Navbar,
      Sidebar,
      Footer,
    },
  };
  </script>
  
  <style scoped>
  .layout {
    display: flex;
    flex-direction: column;
    height: 100vh;
  }
  
  .main-content {
    display: flex;
    flex: 1;
    overflow: hidden;
  }
  
  .content {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
  }
  
  @media (max-width: 768px) {
    .main-content {
      flex-direction: column;
    }
  }
  </style>
  