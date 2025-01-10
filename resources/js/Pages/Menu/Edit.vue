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
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
      </ol>
    </nav>

    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="card rounded shadow-lg">
            <div class="card-header bg-primary text-white text-center">
              <h5 class="fw-bold mb-0">Edit Menu</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleUpdateMenu">
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
                    placeholder="Select parent menu"
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
                  <button type="submit" class="btn btn-primary">Update</button>
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
  name: "EditMenu",
  components: {
    MainLayout,
    vSelect,
  },
  props: {
    menu: {
      type: Object,
      required: true,
    },
    parent_menus: {
      type: Array,
      required: true,
    },
    permissions: {
      type: Array,
      required: true,
    },
  },

  setup(props) {
    const form = useForm({ ...props.menu });

    const handleUpdateMenu = () => {
      const postData = {
        ...form,
        menu_permission: form.menu_permission?.id || null,
        menu_parent: form.menu_parent?.id || null,
      };

      form.put(`/menu/${props.menu.id}/update`, {
        data: postData,
        onSuccess: () => form.reset(),
      });
    };

    return {
      form,
      handleUpdateMenu,
    };
  },
  methods: {
    goBack() {
      this.$inertia.visit("/menu");
    },
  },
};
</script>
