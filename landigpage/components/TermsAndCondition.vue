<template>
    <div class="md:max-w-5xl md:w-full text-gray-200 rounded-md border border-gray-500 mx-auto py-6 px-4">
      <h1 class="text-4xl font-extrabold mb-6">Terms and Conditions</h1>
      <p class="mb-6">Welcome to our website. Please read these terms and conditions carefully before using our services.</p>
  
      <!-- Loop through sections -->
      <div v-for="(section, index) in sections" :key="index" class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">{{ section.title }}</h2>
        <p v-for="(paragraph, pIndex) in section.paragraphs" :key="pIndex" class="mb-4">{{ paragraph }}</p>
        <ul v-if="section.list" class="list-disc list-inside mb-4">
          <li v-for="(item, iIndex) in section.list" :key="iIndex">{{ item }}</li>
        </ul>
      </div>
    </div>
  </template>
  
  <script setup>
  // Define the terms and conditions content
  const sections = [
  {
    title: "1. Introduction",
    paragraphs: [
      "These terms and conditions govern your use of our website; by using our website, you accept these terms and conditions in full. If you disagree with any part of these terms and conditions, do not use our website.",
    ],
  },
  {
    title: "2. Intellectual Property Rights",
    paragraphs: [
      "Unless otherwise stated, we or our licensors own the intellectual property rights in the website and material on the website. Subject to the license below, all these intellectual property rights are reserved.",
    ],
  },
  {
    title: "3. License to Use Website",
    paragraphs: [
      "You may view, download for caching purposes only, and print pages from the website for your own personal use, subject to the restrictions set out below and elsewhere in these terms and conditions.",
      "You must not:",
    ],
    list: [
      "Republish material from this website (including republication on another website);",
      "Sell, rent, or sub-license material from the website;",
      "Show any material from the website in public;",
      "Reproduce, duplicate, copy, or otherwise exploit material on our website for a commercial purpose;",
      "Edit or otherwise modify any material on the website;",
      "Redistribute material from this website, except for content specifically and expressly made available for redistribution.",
    ],
  },
  {
    title: "4. Acceptable Use",
    paragraphs: [
      "You must not use our website in any way that causes, or may cause, damage to the website or impairment of the availability or accessibility of the website; or in any way which is unlawful, illegal, fraudulent, or harmful, or in connection with any unlawful, illegal, fraudulent, or harmful purpose or activity.",
      "You must not use our website to copy, store, host, transmit, send, use, publish, or distribute any material which consists of (or is linked to) any spyware, computer virus, Trojan horse, worm, keystroke logger, rootkit, or other malicious computer software.",
      "You must not conduct any systematic or automated data collection activities (including without limitation scraping, data mining, data extraction, and data harvesting) on or in relation to our website without our express written consent.",
    ],
  },
  {
    title: "5. Restricted Access",
    paragraphs: [
      "Access to certain areas of our website is restricted. We reserve the right to restrict access to other areas of our website, or indeed our whole website, at our discretion.",
      "If we provide you with a user ID and password to enable you to access restricted areas of our website or other content or services, you must ensure that the user ID and password are kept confidential.",
    ],
  },
  {
    title: "6. User Content",
    paragraphs: [
      'In these terms and conditions, "your user content" means material (including without limitation text, images, audio material, video material, and audio-visual material) that you submit to our website, for whatever purpose.',
      "You grant to us a worldwide, irrevocable, non-exclusive, royalty-free license to use, reproduce, adapt, publish, translate, and distribute your user content in any existing or future media. You also grant us the right to sub-license these rights and the right to bring an action for infringement of these rights.",
      "Your user content must not be illegal or unlawful, must not infringe any third party's legal rights, and must not be capable of giving rise to legal action whether against you or us or a third party (in each case under any applicable law).",
      "You must not submit any user content to the website that is or has ever been the subject of any threatened or actual legal proceedings or other similar complaints.",
      "We reserve the right to edit or remove any material submitted to our website, or stored on our servers, or hosted or published upon our website.",
    ],
  },
  {
    title: "7. No Warranties",
    paragraphs: [
      'This website is provided "as is" without any representations or warranties, express or implied. We make no representations or warranties in relation to this website or the information and materials provided on this website.',
      "Without prejudice to the generality of the foregoing paragraph, we do not warrant that:",
    ],
    list: [
      "This website will be constantly available, or available at all; or",
      "The information on this website is complete, true, accurate, or non-misleading.",
    ],
  },
  {
    title: "8. Limitations of Liability",
    paragraphs: [
      "We will not be liable to you (whether under the law of contact, the law of torts, or otherwise) in relation to the contents of, or use of, or otherwise in connection with, this website:",
    ],
    list: [
      "To the extent that the website is provided free-of-charge, for any direct loss;",
      "For any indirect, special, or consequential loss; or",
      "For any business losses, loss of revenue, income, profits, or anticipated savings, loss of contracts or business relationships, loss of reputation or goodwill, or loss or corruption of information or data.",
    ],
  },
  {
    title: "9. Exceptions",
    paragraphs: [
      "Nothing in this website disclaimer will exclude or limit any warranty implied by law that it would be unlawful to exclude or limit; and nothing in this website disclaimer will exclude or limit our liability in respect of any:",
    ],
    list: [
      "Death or personal injury caused by our negligence;",
      "Fraud or fraudulent misrepresentation on our part; or",
      "Matter which it would be illegal or unlawful for us to exclude or limit, or to attempt or purport to exclude or limit, its liability.",
    ],
  },
  {
    title: "10. Reasonableness",
    paragraphs: [
      "By using this website, you agree that the exclusions and limitations of liability set out in this website disclaimer are reasonable. If you do not think they are reasonable, you must not use this website.",
    ],
  },
  {
    title: "11. Other Parties",
    paragraphs: [
      "You accept that, as a limited liability entity, we have an interest in limiting the personal liability of our officers and employees. You agree that you will not bring any claim personally against our officers or employees in respect of any losses you suffer in connection with the website.",
      "Without prejudice to the foregoing paragraph, you agree that the limitations of warranties and liability set out in this website disclaimer will protect our officers, employees, agents, subsidiaries, successors, assigns, and sub-contractors as well as us.",
    ],
  },
  {
    title: "12. Unenforceable Provisions",
    paragraphs: [
      "If any provision of this website disclaimer is, or is found to be, unenforceable under applicable law, that will not affect the enforceability of the other provisions of this website disclaimer.",
    ],
  },
  {
    title: "13. Indemnity",
    paragraphs: [
      "You hereby indemnify us and undertake to keep us indemnified against any losses, damages, costs, liabilities, and expenses (including without limitation legal expenses and any amounts paid by us to a third party in settlement of a claim or dispute on the advice of our legal advisers) incurred or suffered by us arising out of any breach by you of any provision of these terms and conditions.",
    ],
  },
  {
    title: "14. Breaches of These Terms and Conditions",
    paragraphs: [
      "Without prejudice to our other rights under these terms and conditions, if you breach these terms and conditions in any way, we may take such action as we deem appropriate to deal with the breach, including suspending your access to the website, prohibiting you from accessing the website, blocking computers using your IP address from accessing the website, contacting your internet service provider to request that they block your access to the website, and/or bringing court proceedings against you.",
    ],
  },
];
  
  // Add SEO meta tags
  useHead({
    title: "Terms and Conditions | App Name",
    meta: [
      {
        name: "description",
        content: "Read the terms and conditions for using AI Future's website and services.",
      },
    ],
  });
  </script>
  
  <style scoped>
  /* Add custom styles if needed */
  </style>