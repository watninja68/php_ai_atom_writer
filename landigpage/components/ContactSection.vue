<template>
    <div class="min-h-screen bg-gray-900 text-white md:px-6 px-4 py-12 flex justify-center items-center">
        <div class="max-w-5xl w-full bg-gray-800 md:p-10 p-5 rounded-3xl shadow-lg">
            <!-- Header -->
            <h2 class="text-center text-4xl font-bold mb-6">Contact Us</h2>
            <p class="text-center text-gray-400 mb-8">
                We love getting feedback, questions, and hearing what you have to say!
            </p>

            <div class="grid md:grid-cols-2 md:items-center gap-8">
                <!-- Contact Info -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-2xl font-semibold mb-3">Let's talk</h3>
                        <p class="text-gray-400">
                            We are always available to hear from you. Reach out through the form or our contact details.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-medium mb-2">Contact</h4>
                        <p class="text-gray-400">📞 (+642) 342 762 44</p>
                    </div>

                    <div>
                        <h4 class="font-medium mb-2">Email</h4>
                        <p class="text-gray-400">📧 support@copygen.com</p>
                    </div>

                    <div>
                        <h4 class="font-medium mb-2">Office</h4>
                        <p class="text-gray-400">📍 442 Belle Terre St Floor 7, San Francisco, AV 4206</p>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-gray-700 p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Please feel free to contact us</h3>
                    <form @submit.prevent="sendMessage" class="space-y-4">
                        <input v-model="form.name" type="text" placeholder="Your Name"
                            class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required />

                        <input v-model="form.email" type="email" placeholder="Your Email Address"
                            class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required />

                        <input v-model="form.subject" type="text" placeholder="Subject"
                            class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required />

                        <textarea v-model="form.message" placeholder="Enter your message" rows="4"
                            class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required></textarea>

                        <button :disabled="loading" type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold p-3 rounded-lg shadow-md transition disabled:bg-gray-600">
                            {{ loading ? "Sending..." : "Send Message" }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Custom Notification Component -->
        <CustomNotification ref="notificationRef" />
    </div>
</template>
<script setup lang="ts">
import { ref } from "vue";
import emailjs from "@emailjs/browser";
import CustomNotification from "./CustomNotification.vue";



const notificationRef = ref<InstanceType<typeof CustomNotification> | null>(null);
const loading = ref(false);
const form = ref({
    name: "",
    email: "",
    subject: "",
    message: "",
});
notificationRef.value?.showNotification("Message sent successfully!", "success");
const sendMessage = async () => {
    loading.value = true;
    try {
        await emailjs.send(
            import.meta.env.VITE_EMAILJS_SERVICE_ID,
            import.meta.env.VITE_EMAILJS_TEMPLATE_ID,
            form.value,
            import.meta.env.VITE_EMAILJS_PUBLIC_KEY
        );
        // Show success notification
        notificationRef.value?.showNotification("Message sent successfully!", "success");

        // Reset form
        form.value = { name: "", email: "", subject: "", message: "" };
    } catch (error) {
        console.error("Error sending message:", error);
        notificationRef.value?.showNotification("Failed to send message. Try again!", "error");
    } finally {
        loading.value = false;
    }
};
</script>
<style scoped></style>
