<template>
  <MainLayout>
    <div class="card shadow-lg rounded my-4">
      <div class="card-header bg-primary text-white">
        <h6 class="mb-0">Edit Menu Details</h6>
      </div>
      <div class="card-body">
        <form @submit.prevent="updateMenu">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="menu_label" class="form-label">Menu Label</label>
              <input
                type="text"
                id="menu_label"
                v-model="form.menu_label"
                class="form-control rounded-pill"
                placeholder="Enter menu label"
              />
              <span v-if="errors.menu_label" class="text-danger">
                {{ errors.menu_label }}
              </span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="menu_route" class="form-label">Menu Route</label>
              <input
                type="text"
                id="menu_route"
                v-model="form.menu_route"
                class="form-control rounded-pill"
                placeholder="Enter menu route"
              />
              <span v-if="errors.menu_route" class="text-danger">
                {{ errors.menu_route }}
              </span>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="menu_level" class="form-label">Menu Level</label>
              <input
                type="number"
                id="menu_level"
                v-model="form.menu_level"
                class="form-control rounded-pill"
                placeholder="Enter menu level"
              />
              <span v-if="errors.menu_level" class="text-danger">
                {{ errors.menu_level }}
              </span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="menu_parent" class="form-label">Menu Parent</label>
              <input
                type="text"
                id="menu_parent"
                v-model="form.menu_parent"
                class="form-control rounded-pill"
                placeholder="Enter menu parent"
                readonly
              />
              <span v-if="errors.menu_parent" class="text-danger">
                {{ errors.menu_parent }}
              </span>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Permissions</label>
            <div class="row">
              <div
                v-for="permission in permissions"
                :key="permission.id"
                class="col-sm-6 col-md-4 col-lg-3"
              >
                <div class="form-check">
                  <input
                    type="checkbox"
                    :value="permission.name"
                    v-model="form.menu_permission"
                    class="form-check-input"
                    :id="'permission-' + permission.id"
                  />
                  <label
                    :for="'permission-' + permission.id"
                    class="form-check-label"
                  >
                    {{ permission.name }}
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="menu_is_active" class="form-label">Is Active</label>
              <select
                id="menu_is_active"
                v-model="form.menu_is_active"
                class="form-select rounded-pill"
              >
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
              <span v-if="errors.menu_is_active" class="text-danger">
                {{ errors.menu_is_active }}
              </span>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-3">
            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
              Back
            </button>
            <button type="submit" class="btn btn-primary">
              Update Menu
            </button>
          </div>
          
        </form>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import { useForm } from "@inertiajs/vue3";

export default {
  name: "EditMenu",
  components: {
    MainLayout,
  },
  props: {
    menu: Object,
    permissions: Array,
    errors: Object,
    success: String,
  },
  data() {
    return {
      form: useForm({
        menu_label: this.menu.menu_label || "",
        menu_route: this.menu.menu_route || "",
        menu_level: this.menu.menu_level || 1,
        menu_parent: this.menu.menu_parent || null,
        menu_permission: this.menu.menu_permission || [],
        menu_is_active: this.menu.menu_is_active ? 1 : 0,
      }),
      errors: {},
    };
  },
  created() {
    // Display success or error toast if necessary
    if (this.success) {
      this.$toast.success(this.success);
    }

    if (this.errors && this.errors.error) {
      this.$toast.error(this.errors.error);
    }
  },
  methods: {
    updateMenu() {
      this.form.put(route("menu.update", this.menu.id), {
        onSuccess: () => {
          alert("Menu updated successfully!");
        },
        onError: (err) => {
          this.errors = err;
        },
      });
    },
  },
};
</script>

<style scoped>
/* Improve checkbox layout for permissions */
.form-check {
  margin-bottom: 10px;
}

/* Adjust responsiveness for form fields */
@media (max-width: 576px) {
  .form-label {
    font-size: 0.9rem;
  }
  .form-control {
    font-size: 0.9rem;
  }
  .btn {
    font-size: 0.9rem;
  }
}
</style>
