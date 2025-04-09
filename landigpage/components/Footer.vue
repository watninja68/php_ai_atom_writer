<template>
    <!-- Footer Section -->
    <footer id="footer" class="text-gray-400 mt-32 px-6 py-12">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Quick Links Column -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-4 text-cyan-400">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/"
                                class="hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">Home</a></li>
                        <li><a href="pricing"
                                class="hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">Pricing</a>
                        </li>
    
                        <li><a href="contact"
                                class="hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Follow Us Column -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-4 text-cyan-400">Follow Us</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="https://twitter.com"
                                class="flex items-center space-x-2 hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">
                                <i class="fab fa-twitter text-lg"></i>
                                <span>Twitter</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://facebook.com"
                                class="flex items-center space-x-2 hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">
                                <i class="fab fa-facebook text-lg"></i>
                                <span>Facebook</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://instagram.com"
                                class="flex items-center space-x-2 hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">
                                <i class="fab fa-instagram text-lg"></i>
                                <span>Instagram</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://linkedin.com"
                                class="flex items-center space-x-2 hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">
                                <i class="fab fa-linkedin text-lg"></i>
                                <span>LinkedIn</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info Column -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-4 text-cyan-400">Contact Info</h3>
                    <ul class="space-y-2">
                        <li>Email: <a href="mailto:info@aifuture.com"
                                class="hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">info@aifuture.com</a>
                        </li>
                        <li>Phone: <a href="tel:+1234567890"
                                class="hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">+1 (234)
                                567-890</a></li>
                        <li>Address: 123 AI Future St, Tech City, World</li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-cyan-400/20 mt-8 pt-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 md:space-x-4 text-sm text-gray-300">
                    <p>© 2025 AI Future. All Rights Reserved.</p>
                    <div class="flex space-x-4">
                        <a href="/terms"
                            class="hover:text-cyan-400 transition-colors duration-300 hover:neon-glow">Terms and
                            Conditions</a>
                        <NuxtLink class="hover:text-cyan-400 transition-colors duration-300 hover:neon-glow"
                            to="/">
                            Privacy Policy
                        </NuxtLink>
                       
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
// Your script setup code here
</script>

<style scoped>
/* Neon Glow Effect on Hover */
.hover\:neon-glow:hover {
    text-shadow: 0 0 5px rgba(59, 130, 246, 0.8), 0 0 10px rgba(59, 130, 246, 0.6), 0 0 20px rgba(59, 130, 246, 0.4);
}
</style>