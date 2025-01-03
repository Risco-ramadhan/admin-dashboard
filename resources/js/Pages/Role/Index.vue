<template>
    <MainLayout>
        <div class="card my-5 rounded shadow-lg">
            <div class="container my-4">
                <h5 class="fw-bold mb-3">Role</h5>

                <div v-if="roles && roles.length">
                    <PaginatedTable
                        :rows="roles"
                        :columns="columns"
                        :itemsPerPage="3"
                        :showActionEdit="true"
                        :showActionAdd="true"
                        :showActionShow="true"
                        :showActionDelete="true"
                        @edit="handleEditRole"
                        @show="handleShowRole"
                        @delete="handleDeleteRole"
                        @add="handleAddRole"
                    />
                </div>
                <p v-else>No roles found.</p>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaginatedTable from "@/Components/PaginatedTable.vue";
import axios from "axios";

export default {
    name: "RoleIndex",
    components: {
        MainLayout,
        PaginatedTable,
    },
    props: {
        roles: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            columns: [
                { key: "name", label: "Name" },
                { key: "guard_name", label: "guard name" },
                { key: "permissions_count", label: "Menu access" },
            ],
        };
    },
    methods: {
        handleAddRole() {
            this.$inertia.visit("/role/create");
        },
        handleShowRole(id) {
            this.$inertia.visit(`/role/${id}`);
        },
        handleEditRole(id) {
            this.$inertia.visit(`/role/${id}/edit`);
        },
        handleDeleteRole(id) {
            if (confirm("Apakah Anda yakin ingin menghapus role ini?")) {
                this.$inertia.delete(`/role/${id}/destroy`);
            }
        },
    },
};
</script>
