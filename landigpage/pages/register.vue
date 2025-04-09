<template>
   <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 p-2">
    <!-- Image Section -->
    <div class="hidden md:block w-1/2 max-w-lg mr-8">
        <img src="https://via.placeholder.com/600x800" alt="Logo" class="rounded-xl shadow-2xl">
    </div>

    <!-- Registration Form -->
    <div class="bg-gray-800 p-8 rounded-xl shadow-2xl w-full max-w-lg border border-gray-700">
        <h2 class="text-3xl font-bold text-center text-white">7 Days Free Trial</h2>
        <p class="text-center text-gray-400 mb-6">Register for free.</p>

        <!-- Social Login Buttons -->
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

        <!-- Divider -->
        <div class="flex items-center my-6">
            <hr class="flex-grow border-gray-600">
            <span class="mx-2 text-gray-400">Or with email</span>
            <hr class="flex-grow border-gray-600">
        </div>

        <!-- Registration Form -->
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label class="block text-gray-300">Name</label>
                <input v-model="form.name" type="text" placeholder="Enter your name"
                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400">
                <span v-if="errors.name" class="text-red-400 text-sm">{{ errors.name }}</span>
            </div>
            <div>
                <label class="block text-gray-300">Email</label>
                <input v-model="form.email" type="email" placeholder="Enter your email"
                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400">
                <span v-if="errors.email" class="text-red-400 text-sm">{{ errors.email }}</span>
            </div>
            <div>
                <label class="block text-gray-300">Password</label>
                <input v-model="form.password" type="password" placeholder="Enter your password"
                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400">
                <span v-if="errors.password" class="text-red-400 text-sm">{{ errors.password }}</span>
            </div>
            <div>
                <label class="block text-gray-300">Confirm Password</label>
                <input v-model="form.confirmPassword" type="password" placeholder="Confirm your password"
                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400">
                <span v-if="errors.confirmPassword" class="text-red-400 text-sm">{{ errors.confirmPassword }}</span>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition transform hover:scale-105">Create an Account</button>
        </form>

        <!-- Login Link -->
        <p class="text-center text-gray-400 mt-6">Already have an account? <NuxtLink to="/login"
                class="text-blue-400 hover:underline">Login</NuxtLink>
        </p>
    </div>
</div>
</template>
<script setup>
import { ref } from 'vue';
import { useForm, useField } from 'vee-validate';
import * as yup from 'yup';

// Validation schema
const schema = yup.object({
  name: yup.string().required('Name is required'),
  email: yup.string().email('Invalid email').required('Email is required'),
  password: yup.string().min(8, 'Password must be at least 8 characters').required('Password is required'),
  confirmPassword: yup.string().oneOf([yup.ref('password'), null], 'Passwords must match'),
});

// Form setup
const { handleSubmit, errors } = useForm({
  validationSchema: schema,
});

const { value: name } = useField('name');
const { value: email } = useField('email');
const { value: password } = useField('password');
const { value: confirmPassword } = useField('confirmPassword');

const form = ref({
  name,
  email,
  password,
  confirmPassword,
  newsletter: false,
});

// Form submission handler
const submitForm = handleSubmit((values) => {
  console.log('Form submitted:', values);
  alert('Registration successful!');
});
</script>