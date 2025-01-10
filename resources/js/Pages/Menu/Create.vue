<template>
  <MainLayout>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard" class="text-decoration-none">User</a>
        </li>
        <li class="breadcrumb-item">
          <a href="/menu" class="text-decoration-none">Menu</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
      </ol>
    </nav>

    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="card rounded shadow-lg">
            <div class="card-header bg-primary text-white text-center">
              <h5 class="fw-bold mb-0">Create New Menu</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleStoreMenu">
                <div class="mb-3">
                  <label for="menu_label" class="form-label">Menu Label</label>
                  <input
                    type="text"
                    class="form-control"
                    id="menu_label"
                    v-model="form.menu_label"
                    placeholder="Enter menu label"
                    required
                  />
                </div>

                <div class="mb-3">
                  <label for="menu_route" class="form-label">Menu Route</label>
                  <input
                    type="text"
                    class="form-control"
                    id="menu_route"
                    v-model="form.menu_route"
                    placeholder="Enter menu route"
                  />
                </div>

                <div class="mb-3">
                  <label for="menu_level" class="form-label">Menu Level</label>
                  <input
                    type="number"
                    class="form-control"
                    id="menu_level"
                    v-model="form.menu_level"
                    placeholder="Enter menu level"
                    required
                  />
                </div>

                <div class="mb-3">
                  <label for="menu_parent" class="form-label">Menu Parent</label>
                  <v-select
                    v-model="form.menu_parent"
                    :options="parent_menus"
                    label="menu_label"
                    :get-option-label="(option) => option.menu_label"
                    placeholder="Search and select parent menu"
                  />
                </div>

                <div class="mb-3">
                  <label for="menu_permission" class="form-label">Menu Permission</label>
                  <v-select
                    v-model="form.menu_permission"
                    :options="permissions"
                    label="name"
                    placeholder="Search and select permission"
                  />
                </div>

                <div class="mb-3">
                  <label class="form-check-label d-block mb-2">Is Active</label>
                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      id="isActiveYes"
                      v-model="form.menu_is_active"
                      :value="true"
                    />
                    <label class="form-check-label" for="isActiveYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      id="isActiveNo"
                      v-model="form.menu_is_active"
                      :value="false"
                    />
                    <label class="form-check-label" for="isActiveNo">No</label>
                  </div>
                </div>

                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" @click="goBack">
                    Cancel
                  </button>
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import { useForm } from "@inertiajs/vue3";
import vSelect from "vue3-select";

export default {
  name: "CreateMenu",
  components: {
    MainLayout,
    vSelect,
  },
  props: {
    permissions: {
      type: Array,
      required: true,
    },
    parent_menus: {
      type: Array,
      required: true,
    },
  },

  setup() {
    // console.log("permissions data", this.permissions);
    const form = useForm({
      menu_label: "",
      menu_route: "",
      menu_level: null,
      menu_parent: null, // Set to null by default
      menu_permission: null,
      menu_is_active: true,
    });

    const handleStoreMenu = () => {
      const postData = {
        ...form,
        menu_permission: form.menu_permission?.id || null, // Send the whole permission object
        menu_parent: form.menu_parent?.id, // Parent menu is fine as it is.
      };

      form.post("/menu/store", {
        data: postData,
        onSuccess: () => form.reset(),
      });
    };

    return {
      form,
      handleStoreMenu,
    };
  },
  methods: {
    goBack() {
      this.$inertia.visit("/menu");
    },
  },
};
</script>

<style>
/* Import default vue-select styles */
@import "vue3-select/dist/vue3-select.css";

/* Custom styling for v-select dropdown */
.v-select {
  width: 100%;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  background-color: #fff;
  font-size: 1rem;
  padding: 0.375rem 0.75rem;
}

.v-select .dropdown-toggle {
  border: none;
  background-color: transparent;
  box-shadow: none;
}

.v-select .dropdown-toggle:hover {
  cursor: pointer;
  background-color: rgba(0, 0, 0, 0.03);
}

.v-select .dropdown-menu {
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  max-height: 300px;
  overflow-y: auto;
  z-index: 1050;
}

.v-select .dropdown-item {
  font-size: 0.9rem;
  padding: 0.5rem 1rem;
  color: #212529;
}

.v-select .dropdown-item:hover {
  background-color: rgba(0, 123, 255, 0.1);
  color: #0056b3;
}

.v-select .dropdown-menu .dropdown-header {
  font-weight: bold;
  font-size: 0.9rem;
  color: #495057;
  background-color: #f8f9fa;
  border-bottom: 1px solid #ced4da;
}

.v-select .dropdown-toggle:focus,
.v-select .dropdown-item:focus {
  outline: none;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>
