<template>
    <MainLayout>
        <div class="card my-5 shadow-lg rounded">
            <div class="container" v-if="role">
                <h5 class="text-start fw-bold mb-5">Role Details</h5>

                <div class="row pt-3">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <label
                                class="col-sm-4 col-form-label text-secondary"
                            >
                                Role:
                            </label>
                            <div class="col-sm-8">
                                <span class="form-control-plaintext fw-bold">
                                    {{ role.name }}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label
                                class="col-sm-4 col-form-label text-secondary"
                            >
                                Permissions:
                            </label>
                            <div class="col-sm-8">
                                <div
                                    v-if="
                                        role.permissions &&
                                        role.permissions.length > 0
                                    "
                                >
                                    <span
                                        v-for="permission in role.permissions"
                                        :key="permission.id"
                                        class="badge bg-primary me-1"
                                    >
                                        {{ permission.name }}
                                    </span>
                                </div>
                                <div v-else>
                                    <p class="text-muted">
                                        No permissions assigned.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-secondary me-2" @click="goBack">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    <button
                        class="btn btn-primary"
                        @click="handleEditRole(role.id)"
                    >
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
            </div>

            <div v-else>
                <div
                    class="d-flex justify-content-center align-items-center"
                    style="height: 200px"
                >
                    <div class="text-center">
                        <div
                            class="spinner-border text-primary mb-3"
                            role="status"
                        >
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted">Loading role details...</p>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";

export default {
    name: "ViewRole",
    components: {
        MainLayout,
    },
    props: {
        role: {
            type: Object,
            required: true,
        },
    },
    methods: {
        handleEditRole(id) {
            this.$inertia.visit(`/role/${id}/edit`);
        },
        goBack() {
            this.$inertia.visit("/role");
        },
    },
};
</script>

<style scoped>
.container {
    max-width: 900px;
}

.card {
    padding: 30px;
}

th {
    width: 30%;
}

.form-label {
    font-weight: bold;
}

.btn i {
    margin-right: 5px;
}
</style>
