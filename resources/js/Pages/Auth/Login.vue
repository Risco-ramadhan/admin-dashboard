<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>
    <section class="vh-100">
        <div class="container-fluid d-flex justify-content-center align-items-center h-100 h-custom">
            <div class="row w-100 justify-content-center">
                
                <!-- Card Section -->
                <div class="col-12 col-md-9 col-lg-8 col-xl-7">
                    <div class="card shadow-lg" style="min-height: 60vh;">
                        <div class="row g-0">
                            <!-- Image Section -->
                            <div class="col-md-6 d-flex justify-content-center align-items-center">
                                <img src="../../../../public/assets/images/logo_sisi.webp" class="img-fluid" alt="Sample image" />
                            </div>
                            
                            <!-- Form Section -->
                            <div class="col-md-6">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <p class="h1 text-center">ITAM SISI</p>
                                    
                                    <form @submit.prevent="submit" class="pt-4">
                                        <!-- Email input -->
                                        <div>
                                            <TextInput
                                                 id="email"
                                                 type="email"
                                                 class="block w-full rounded-pill mb-4"
                                                 v-model="form.email"
                                                 required
                                                 autofocus
                                                 autocomplete="username"
                                            />
                                             <InputError class="mt-2" :message="form.errors.email" />
                                         </div>
                    
                                        <!-- Password input -->
                                         <div>
                                            <TextInput
                                                id="password"
                                                type="password"
                                                class="mt-1 block w-full rounded-pill mb-3"
                                                v-model="form.password"
                                                required
                                                autocomplete="current-password"
                                            />
                                            <InputError class="mt-2" :message="form.errors.password" />
                                         </div>
                    
                                        <div class="d-flex justify-content-between align-items-center">
                                            <!-- Remember me -->
                                            <div class="form-check">
                                                <Checkbox name="remember" class="form-check-input me-2" v-model:checked="form.remember" />
                                                <label class="form-check-label" for="form2Example3">
                                                    Remember me
                                                </label>
                                            </div>
                                            <Link
                                                v-if="canResetPassword"
                                                :href="route('password.request')"
                                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >
                                                Forgot your password?
                                            </Link>
                                        </div>
                                      
                                        <div class="text-center text-lg-start mt-4 pt-2">
                                            <PrimaryButton class="ms-4 btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Log in
                                            </PrimaryButton>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Custom Styles */
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    .h-custom {
        background-color: #301b52;
    }

    .card {
        border-radius: 25px !important;
    }

    /* Adjusting the form's padding and margins */
    .card-body {
        padding-top: 40px;
        padding-bottom: 40px;
    }
</style>
