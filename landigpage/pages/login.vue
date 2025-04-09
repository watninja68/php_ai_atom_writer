<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-gray-900 to-gray-800">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <NuxtLink to="/">
                <img src="https://via.placeholder.com/50" alt="Logo" class="w-14 h-14 hover:opacity-80 transition">
            </NuxtLink>
        </div>
        <div class="bg-gray-800 p-8 rounded-xl shadow-2xl w-full max-w-md text-center border border-gray-700">

            <h2 class="text-4xl font-bold mb-4 text-white">Login</h2>
            <p class="text-center text-gray-400 mb-7">New Here? <NuxtLink to="/register"
                    class="text-blue-400 hover:underline">Create an account</NuxtLink>
            </p>

            <form @submit.prevent="submitForm" class="space-y-4">
                <div class="mb-4 text-left">
                    <label class="block text-gray-300 font-medium mb-1">Email</label>
                    <input type="email" v-model="form.email" placeholder="Enter Email"
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400">
                    <span v-if="errors.email" class="text-red-400 text-sm">{{ errors.email }}</span>
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-300 font-medium mb-1">Password</label>
                    <div class="relative">
                        <input type="password" v-model="form.password" placeholder="Enter Password"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400">
                        <span class="absolute right-3 top-3 cursor-pointer text-gray-400"></span>
                        <span v-if="errors.password" class="text-red-400 text-sm">{{ errors.password }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-4 text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span class="text-gray-300">Remember Me</span>
                    </label>
                    <a href="#" class="text-blue-400 hover:underline">Forgot Password?</a>
                </div>

                <button
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition transform hover:scale-105">Login</button>
            </form>

            <div class="text-center my-6 text-gray-400 text-sm">or login with</div>

            <div class="flex justify-center">
                <div class="flex items-center gap-3">
                    <button
                        class="flex items-center justify-center border border-gray-600 p-2 rounded-lg text-gray-300 hover:bg-gray-700 transition transform hover:scale-105">
                        <img src="https://img.icons8.com/color/20/000000/google-logo.png">
                    </button>
                    <button
                        class="flex items-center justify-center border border-gray-600 p-2 rounded-lg text-gray-300 hover:bg-gray-700 transition transform hover:scale-105">
                        <img src="https://img.icons8.com/fluency/20/000000/facebook-new.png">
                    </button>
                    <button
                        class="flex items-center justify-center border border-gray-600 p-2 rounded-lg text-gray-300 hover:bg-gray-700 transition transform hover:scale-105">
                        <img src="https://img.icons8.com/fluency/20/000000/linkedin.png">
                    </button>
                    <button
                        class="flex items-center justify-center border border-gray-600 p-2 rounded-lg text-gray-300 hover:bg-gray-700 transition transform hover:scale-105">
                        <img src="https://img.icons8.com/color/20/000000/twitter.png">
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { useForm, useField } from 'vee-validate';
import * as yup from 'yup';

// Validation schema
const schema = yup.object({
    email: yup.string().email('Invalid email').required('Email is required'),
    password: yup.string().min(8, 'Password must be at least 8 characters').required('Password is required'),
});

// Form setup
const { handleSubmit, errors } = useForm({
    validationSchema: schema,
});

const { value: email } = useField('email');
const { value: password } = useField('password');

const form = ref({
    email,
    password,
});

// Form submission handler
const submitForm = handleSubmit((values) => {
    console.log('Form submitted:', values);
    alert('Login successful!');
});
</script>