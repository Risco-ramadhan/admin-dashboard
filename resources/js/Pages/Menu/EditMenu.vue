<template>
  <MainLayout>
    <div class="card mt-5">
      <div class="container my-4">
        <h5 class="fw-bold mb-3">Menu</h5>
        
        <h1>Edit Menu</h1>
        <form @submit.prevent="updateMenu">
          <!-- Menu Label -->
          <div class="mb-3">
            <label for="menu_label" class="form-label">Menu Label</label>
            <input
              type="text"
              id="menu_label"
              v-model="form.menu_label"
              class="form-control"
            />
            <span v-if="errors.menu_label" class="text-danger">
              {{ errors.menu_label }}
            </span>
          </div>

          <!-- Menu Route -->
          <div class="mb-3">
            <label for="menu_route" class="form-label">Menu Route</label>
            <input
              type="text"
              id="menu_route"
              v-model="form.menu_route"
              class="form-control"
            />
            <span v-if="errors.menu_route" class="text-danger">
              {{ errors.menu_route }}
            </span>
          </div>

          <!-- Menu Level -->
          <div class="mb-3">
            <label for="menu_level" class="form-label">Menu Level</label>
            <input
              type="number"
              id="menu_level"
              v-model="form.menu_level"
              class="form-control"
            />
            <span v-if="errors.menu_level" class="text-danger">
              {{ errors.menu_level }}
            </span>
          </div>

          <!-- Menu Parent -->
          <div class="mb-3">
            <label for="menu_parent" class="form-label">Menu Parent</label>
            <input
              type="text"
              id="menu_parent"
              v-model="form.menu_parent"
              class="form-control"
            />
            <span v-if="errors.menu_parent" class="text-danger">
              {{ errors.menu_parent }}
            </span>
          </div>

          <!-- Menu Permissions (Checkbox) -->
          <div class="mb-3">
            <label class="form-label">Permissions</label>
            <div v-for="permission in permissions" :key="permission.id">
              <div class="form-check">
                <input
                  type="checkbox"
                  :value="permission.name"
                  v-model="form.menu_permission"
                  class="form-check-input"
                  id="permission-{{ permission.id }}"
                />
                <label :for="'permission-' + permission.id" class="form-check-label">
                  {{ permission.name }}
                </label>
              </div>
            </div>
          </div>

          <!-- Menu Is Active -->
          <div class="mb-3">
            <label for="menu_is_active" class="form-label">Is Active</label>
            <select
              id="menu_is_active"
              v-model="form.menu_is_active"
              class="form-select"
            >
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
            <span v-if="errors.menu_is_active" class="text-danger">
              {{ errors.menu_is_active }}
            </span>
          </div>

          <!-- Submit Button -->
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Menu</button>
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
    // Menampilkan toast sukses jika ada pesan sukses
    if (this.success) {
      this.$toast.success(this.success);
    }

    // Menampilkan toast error jika ada pesan error
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
