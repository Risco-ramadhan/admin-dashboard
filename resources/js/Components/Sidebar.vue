<template>
    <aside class="sidebar">
      <nav>
        <ul>
          <li><a href="/">Dashboard</a></li>
          <li><a href="/settings">Settings</a></li>
        </ul>
      </nav>
    </aside>
  </template>
  
  <script>
  export default {
    name: "Sidebar",
  };
  </script>
  
  <style scoped>
  .sidebar {
    width: 250px;
    background-color: #f4f4f4;
    padding: 20px;
  }
  .sidebar nav ul {
    list-style: none;
    padding: 0;
  }
  .sidebar nav ul li {
    margin: 10px 0;
  }
  </style>
  