<template>
    <MainLayout>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Permission
                </li>
            </ol>
        </nav>

        <div class="card my-3 rounded shadow-lg">
            <div class="container my-4">
                <div v-if="permissions && permissions.length">
                    <PaginatedTable
                        :rows="permissions"
                        :columns="columns"
                        :itemsPerPage="5"
                        :showActionEdit="true"
                        :showActionAdd="true"
                        :showActionShow="false"
                        :showActionDelete="true"
                        @edit="handleEditPermission"
                        @delete="handleDeletePermission"
                        @add="handleAddPermission"
                    />
                </div>
                <p v-else>No permissions found.</p>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaginatedTable from "@/Components/PaginatedTable.vue"; // Import komponen PaginatedTable
import axios from "axios"; // Jika menggunakan axios untuk API

export default {
    name: "UserIndex",
    components: {
        MainLayout,
        PaginatedTable,
    },
    data() {
        return {
            users: [],
            columns: [
                { key: "name", label: "Name" },
                { key: "guard_name", label: "Guard Name" },
            ],
        };
    },
    props: {
        permissions: Array, // Pastikan Anda mendefinisikan `users` sebagai prop
    },
    methods: {
        handleAddPermission() {
            this.$inertia.visit("/permission/create");
        },
        handleEditPermission(id) {
            this.$inertia.visit(`/permission/${id}/edit`);
        },
        handleDeletePermission(id) {
            if (confirm("Apakah Anda yakin ingin menghapus permission ini?")) {
                this.$inertia.delete(`/permission/${id}`);
            }
        },
    },
    mounted() {},
};
</script>
