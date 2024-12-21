<template>
    <MainLayout>
      <div class="card mt-5">
        <div class="container my-4">
          <h5 class="fw-bold mb-3">Menu</h5>

          <div>
            <h1>Role Detail</h1>
            <h2>{{ role.name }}</h2>
            <h3>Permissions:</h3>
            <ul>
              <li v-for="permission in permissions" :key="permission.id">
                {{ permission.name }}
              </li>
            </ul>
          </div>

        </div>
      </div>
    </MainLayout>
  </template>
  
  <script>
  import MainLayout from "@/Layouts/MainLayout.vue";

  export default {
    name: "UserIndex",
    components: {
      MainLayout,
    },
    data() {
      return {
        users: [],
      };
    },
    props: {
        role: Object, // Pastikan Anda mendefinisikan `users` sebagai prop
        permissions: Array, // Pastikan Anda mendefinisikan `users` sebagai prop
    },
    methods: {
    },
    mounted() {
    },
  };
  </script>
  