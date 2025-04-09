<template>
    <div class="text-white pt-7 bg-gradient-to-br from-gray-900 to-gray-800 relative">
        <Navbar />
        <PricingSection />
        <Faq :faqs="faqList2" />
        <Footer />
    </div>
</template>
<script setup>
const faqList2 = [
    {
        question: 'How does the free trial work?',
        answer: 'Your 7-day free trial gives you the chance to thoroughly test Creaitor to ensure that it meets your needs. You can cancel your free trial at any time before it ends at no cost. After your free trial ends, the subscription you selected will start.'
    },
    {
        question: 'Can I cancel my subscription any time?',
        answer: 'Yes, you can cancel your subscription at any time. Your subscription and account will remain active until the end of the billing cycle.'
    },
    {
        question: 'Can I add team members to my subscription?',
        answer: 'Yes, our Professional Subscription includes 2 users in the subscription price. You can add up to a total of 5 users to a single Professional Subscription for an extra charge. Please contact our customer support to add more members to your team.'
    }
];
</script>