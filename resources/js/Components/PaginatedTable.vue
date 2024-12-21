<template>
  <div>
    <!-- Search Input -->
    <div class="mb-3">
      <input
        type="text"
        v-model="searchTerm"
        class="form-control"
        placeholder="Search..."
      />
    </div>

    <!-- Tabel Data -->
    <td v-if="showActionAdd">
      <button class="btn btn-success" @click="addRow">Tambah</button>
    </td>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th
              v-for="(column, index) in columns"
              :key="column.key"
              @click="sortTable(column.key)"
              style="cursor: pointer;"
            >
              {{ column.label }}
              <span v-if="sortColumn === column.key">
                {{ sortOrder === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th v-if="showActionEdit || showActionDelete || showActionShow">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in paginatedRows" :key="index">
            <!-- Data -->
            <td v-for="column in columns" :key="column.key">
              {{ row[column.key] }}
            </td>
            <!-- Action -->
            <td>
              <div>
                <button v-if="showActionEdit" class="btn btn-info" @click="editRow(row.id)">Edit</button>
                <button v-if="showActionShow" class="btn btn-warning" @click="showRow(row.id)">Show</button>
                <button v-if="showActionDelete" class="btn btn-danger" @click="deleteRow(row.id)">Delete</button>
              </div>
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
    showActionAdd: {
      type: Boolean,
      default: true,
    },
    showActionEdit: {
      type: Boolean,
      default: true,
    },
    showActionShow: {
      type: Boolean,
      default: true,
    },
    showActionDelete: {
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
      searchTerm: "",
      sortColumn: null, // Column to be sorted
      sortOrder: 'asc', // Default sorting order
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.filteredRows.length / this.itemsPerPage);
    },
    filteredRows() {
      // Filter the rows based on the search term
      return this.rows.filter(row => {
        return this.columns.some(column => {
          return String(row[column.key]).toLowerCase().includes(this.searchTerm.toLowerCase());
        });
      });
    },
    sortedRows() {
      if (!this.sortColumn) return this.filteredRows;
      return this.filteredRows.slice().sort((a, b) => {
        const valueA = String(a[this.sortColumn]).toLowerCase();
        const valueB = String(b[this.sortColumn]).toLowerCase();
        
        if (this.sortOrder === 'asc') {
          return valueA.localeCompare(valueB);
        } else {
          return valueB.localeCompare(valueA);
        }
      });
    },
    paginatedRows() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      return this.sortedRows.slice(start, start + this.itemsPerPage);
    },
  },
  methods: {
    changePage(page) {
      if (page > 0 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    addRow() {
      this.$emit('add');
    },
    editRow(row) {
      this.$emit('edit', row);
    },
    showRow(row) {
      this.$emit('show', row);
    },
    deleteRow(row) {
      this.$emit('delete', row);
    },
    sortTable(columnKey) {
      // Toggle sort order if the same column is clicked
      if (this.sortColumn === columnKey) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortColumn = columnKey;
        this.sortOrder = 'asc';
      }
    },
  },
};
</script>

<style scoped>
/* Add your table styling here */
</style>
