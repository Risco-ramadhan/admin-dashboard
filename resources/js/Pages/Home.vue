<template>
    <MainLayout>
      <template #default>
        <h1>Home Page</h1>
        <p>Welcome to the home page of the application!</p>
      </template>
    </MainLayout>
  </template>
  
  <script>
  import MainLayout from "@/Layouts/MainLayout.vue";
  
  export default {
    name: "Home",
    components: {
      MainLayout,
    },
  };
  </script>
  