<template>
  <div>
    <div class="row mb-3">
      <!-- Add Button -->
      <div class="col-md-9 text-start">
        <button v-if="showActionAdd" class="btn btn-success" @click="addRow">
          <i class="fas fa-user-plus"></i> Add
        </button>
      </div>
      <!-- Search Input -->
      <div class="col-md-3 text-end">
        <input
          type="text"
          v-model="searchTerm"
          class="form-control rounded-pill"
          placeholder="Search..."
        />
      </div>
    </div>
       

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th
              v-for="(column, index) in columns"
              :key="column.key"
              @click="sortTable(column.key)"
              class="text-center"
              style="cursor: pointer;"
            >
              {{ column.label }}
              <span v-if="sortColumn === column.key">
                {{ sortOrder === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th v-if="showActionEdit || showActionDelete || showActionShow" class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in paginatedRows" :key="index">
            <!-- Data -->
            <!-- <td v-for="column in columns" :key="column.key" class="text-center">
              {{ row[column.key] }}
            </td> -->
            <td v-for="column in columns" :key="column.key" class="text-center">
              <template v-if="column.key === 'menu_is_active'">
                <span :class="row[column.key] === 1 ? 'badge bg-success rounded-pill' : 'badge bg-danger rounded-pill'">
                  {{ row[column.key] === 1 ? 'Active' : 'Inactive' }}
                </span>
              </template>
              <template v-else>
                {{ row[column.key] }}
              </template>
            </td>
            <!-- Actions -->
            <td class="text-center">
              <div class="btn-group" role="group">
                <a
                  v-if="showActionEdit"
                  class="btn btn-info me-3"
                  @click="editRow(row.id)"
                >
                  <i class="fas fa-user-edit"></i>
                </a>
                <a
                  v-if="showActionShow"
                  class="btn btn-warning me-3"
                  @click="showRow(row.id)"
                >
                  <i class="fas fa-eye"></i>
                </a>
                <a
                  v-if="showActionDelete"
                  class="btn btn-danger me-3"
                  @click="deleteRow(row.id)"
                >
                  <i class="fas fa-user-times"></i>
                </a>
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
          <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">
            «
          </a>
        </li>
        <li
          class="page-item"
          v-for="page in totalPages"
          :key="page"
          :class="{ active: currentPage === page }"
        >
          <a class="page-link" href="#" @click.prevent="changePage(page)">
            {{ page }}
          </a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">
            »
          </a>
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
/* Add table spacing for smaller screens */
.table {
  word-wrap: break-word;
  font-size: 0.9rem; /* Smaller font size for better responsiveness */
}

.table th,
.table td {
  vertical-align: middle; /* Align text in the center vertically */
}

/* Add spacing for pagination on smaller screens */
.pagination {
  font-size: 0.85rem;
}

.pagination .page-item.active .page-link {
  background-color: #198754;
  border-color: #198754;
  color: white;
}
</style>

