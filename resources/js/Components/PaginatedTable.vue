<template>
    <div>
      <!-- Tabel Data -->
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th v-for="column in columns" :key="column.key">{{ column.label }}</th>
              <th v-if="showActions">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in paginatedRows" :key="index">
              <td v-for="column in columns" :key="column.key">
                {{ row[column.key] }}
              </td>
              <td v-if="showActions">
                <button class="btn btn-info" @click="editRow(row.id)">Edit</button>
                <button class="btn btn-danger" @click="deleteRow(row.id)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Pagination -->
      <nav>
        <ul class="pagination justify-content-end">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <a class="page-link" href="#" @click="changePage(currentPage - 1)">«</a>
          </li>
          <li
            class="page-item"
            v-for="page in totalPages"
            :key="page"
            :class="{ active: currentPage === page }"
          >
            <a class="page-link" href="#" @click="changePage(page)">{{ page }}</a>
          </li>
          <li class="page-item" :class="{ disabled: currentPage === totalPages }">
            <a class="page-link" href="#" @click="changePage(currentPage + 1)">»</a>
          </li>
        </ul>
      </nav>
    </div>
  </template>
  
  <script>
  export default {
    name: "TableWithPagination",
    props: {
      rows: {
        type: Array,
        required: true,
      },
      columns: {
        type: Array,
        required: true,
      },
      showActions: {
        type: Boolean,
        default: true,
      },
      itemsPerPage: {
        type: Number,
        default: 5,
      },
    },
    data() {
      return {
        currentPage: 1,
      };
    },
    computed: {
      totalPages() {
        return Math.ceil(this.rows.length / this.itemsPerPage);
      },
      paginatedRows() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        return this.rows.slice(start, start + this.itemsPerPage);
      },
    },
    methods: {
      changePage(page) {
        if (page > 0 && page <= this.totalPages) {
          this.currentPage = page;
        }
      },
      editRow(row) {
        this.$emit('edit', row);
      },
      deleteRow(row) {
        this.$emit('delete', row);
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add your table styling here */
  </style>
  