<template>
    <MainLayout>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card rounded shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h5 class="fw-bold mb-0 text-center">
                                Update Role
                            </h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="handleUpdateRole">
                                <div class="mb-3">
                                    <label for="name" class="form-label"
                                        >Name</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        v-model="form.name"
                                        placeholder="Enter role's name"
                                        required
                                    />
                                </div>
                                <!-- <div class="mb-3">
                                    <label class="form-label"
                                        >Permissions</label
                                    >
                                    <div
                                        v-for="permission in permissions"
                                        :key="permission.id"
                                    >
                                        <input
                                            type="checkbox"
                                            :id="`permission-${permission.id}`"
                                            :value="permission.id"
                                            v-model="form.permissions"
                                        />
                                        <label
                                            :for="`permission-${permission.id}`"
                                            >{{ permission.name }}</label
                                        >
                                    </div>
                                </div> -->
                                <div class="d-flex justify-content-between">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        @click="goBack"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Update
                                    </button>
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

export default {
    name: "UpdateRole",
    components: {
        MainLayout,
    },

    props: {
        role: Object,
        // permissions: Array,
    },

    setup(props) {
        const form = useForm({
            name: props.role.name,
            // permissions: props.role.permissions.map((p) => p.id),
        });

        const handleUpdateRole = () => {
            form.put(`/role/${props.role.id}`, {
                onSuccess: () => {
                    form.reset(); // Reset form after successful submission
                },
                onError: (errors) => {
                    console.error(errors);
                },
            });
        };

        return {
            form,
            handleUpdateRole,
        };
    },

    methods: {
        goBack() {
            this.$inertia.visit("/role");
        },
    },
};
</script>
