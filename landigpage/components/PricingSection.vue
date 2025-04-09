<template>
    <section class="min-h-screen">
        <div class="max-w-xl w-full mx-auto py-16 text-center">
            <h2 class="md:text-4xl text-2xl font-extrabold text-gray-100">
                Plans that best suit your business requirements
            </h2>
        </div>

        <!-- Toggle Switch -->
        <div class="flex justify-center items-center space-x-6 mb-10">
            <span class=" w-32 text-right"
                :class="{ 'text-blue-400 font-bold': billingCycle === 'monthly', 'text-gray-400': billingCycle !== 'monthly' }">Billed
                Monthly</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" v-model="isYearly" class="sr-only" @change="toggleBilling">
                <!-- Outer Track -->
                <span
                    class="w-14 h-8 bg-gradient-to-r from-gray-700 to-gray-800 rounded-full flex items-center shadow-inner">
                    <!-- Inner Thumb with Glow Effect -->
                    <span
                        class="w-6 h-6 bg-white rounded-full absolute left-1 transition-transform duration-300 shadow-lg"
                        :class="isYearly ? 'translate-x-6' : 'translate-x-0'"
                        :style="isYearly ? 'box-shadow: 0 0 10px 2px rgba(96, 165, 250, 0.8);' : 'box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5);'"></span>
                </span>
            </label>
            <span class=" w-32"
                :class="{ 'text-blue-400 font-bold': billingCycle === 'yearly', 'text-gray-400': billingCycle !== 'yearly' }">Billed
                Yearly</span>
        </div>

        <div id="pricing" class="flex justify-center items-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl w-full p-6">
                <div v-for="(plan, index) in plans" :key="index"
                    class="bg-gray-800 p-10 rounded-xl shadow-xl text-center border-2 border-gray-200 hover:border-blue-500 transition-all duration-300"
                    @mouseenter="animateList(index)">
                    <h3 class="text-base text-gray-200 font-semibold">{{ plan.name }}</h3>
                    <p class="text-3xl text-gray-200 font-bold mt-5">
                        ${{ isYearly ? plan.yearlyPrice : plan.monthlyPrice }}
                        <span class="text-gray-400 text-base">/ {{ isYearly ? 'year' : 'month' }}</span>
                    </p>
                    <button
                        class="bg-indigo-600 text-white py-2 px-4 rounded-lg mt-6 w-full transition-all duration-300 hover:scale-105">
                        Start free trial today
                    </button>
                    <ul :ref="el => listRefs[index] = el" class="mt-4 space-y-5 text-gray-200 text-left">
                        <li v-for="(feature, i) in plan.features" :key="i">
                            <i class="fas fa-check-circle text-green-500"></i> {{ feature }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import gsap from 'gsap';

const isYearly = ref(false);
const billingCycle = ref('monthly');

const toggleBilling = () => {
    billingCycle.value = isYearly.value ? 'yearly' : 'monthly';
};

const plans = ref([
    {
        name: "BRONZE",
        monthlyPrice: 9,
        yearlyPrice: 90,
        features: [
            "10,000 Monthly Word Limit", "10+ Templates", "30+ Languages",
            "Advance Editor Tool", "Regular Technical Support", "Unlimited Logins", "Newest Features"
        ]
    },
    {
        name: "SILVER",
        monthlyPrice: 19,
        yearlyPrice: 190,
        features: [
            "20,000 Monthly Word Limit", "10+ Templates", "50+ Languages",
            "Advance Editor Tool", "Regular Technical Support", "Unlimited Logins", "Newest Features"
        ]
    },
    {
        name: "DIAMOND",
        monthlyPrice: 39,
        yearlyPrice: 390,
        features: [
            "50,000 Monthly Word Limit", "15+ Templates", "70+ Languages",
            "Advance Editor Tool", "Regular Technical Support", "Unlimited Logins", "Newest Features"
        ]
    }
]);

const listRefs = ref([]);

const animateList = (index) => {
    gsap.fromTo(
        listRefs.value[index].children,
        { opacity: 0, x: -10 },
        { opacity: 1, x: 0, stagger: 0.1, duration: 0.5 }
    );
};

onMounted(() => {
    listRefs.value.forEach((list) => {
        gsap.set(list.children, { opacity: 1, x: -5 });
    });
});
</script>
