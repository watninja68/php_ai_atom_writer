<?php
declare(strict_types=1);
session_start();

require_once 'vendor/autoload.php';

// Hardcoded pricing plans with Paddle IDs
$pricingPlans = [
    "BRONZE" => [
        "name" => "BRONZE",
        "monthlyPrice" => 9,
        "yearlyPrice" => 90,
        "features" => [
            "10,000 Monthly Word Limit", "10+ Templates", "30+ Languages",
            "Advance Editor Tool", "Regular Technical Support", "Unlimited Logins", "Newest Features"
        ],
        "paddleId" => "pro_01jr1vpnnxmp2d0q97bfc6by0q",
        "paddlePrices" => [
            [
                'id' => "pri_01jr1vpnzczy6t3xks2zxrv820",
                'amount' => 9,
                'currency' => 'USD',
                'isYearly' => false,
                'description' => 'BRONZE Monthly Plan'
            ],
            [
                'id' => "pri_01jr1vpp8h8werbw57tqp9qjx4",
                'amount' => 90,
                'currency' => 'USD',
                'isYearly' => true,
                'description' => 'BRONZE Yearly Plan'
            ]
        ]
    ],
    "SILVER" => [
        "name" => "SILVER",
        "monthlyPrice" => 19,
        "yearlyPrice" => 190,
        "features" => [
            "20,000 Monthly Word Limit", "10+ Templates", "50+ Languages",
            "Advance Editor Tool", "Regular Technical Support", "Unlimited Logins", "Newest Features"
        ],
        "paddleId" => "pro_01jr1vppj8k5hd81sqtm8dbvks",
        "paddlePrices" => [
            [
                'id' => "pri_01jr1vppv7n5n2ehdhmbdr3gja",
                'amount' => 19,
                'currency' => 'USD',
                'isYearly' => false,
                'description' => 'SILVER Monthly Plan'
            ],
            [
                'id' => "pri_01jr1vpq4a1hpf82a81zvcqk52",
                'amount' => 190,
                'currency' => 'USD',
                'isYearly' => true,
                'description' => 'SILVER Yearly Plan'
            ]
        ]
    ],
    "DIAMOND" => [
        "name" => "DIAMOND",
        "monthlyPrice" => 39,
        "yearlyPrice" => 390,
        "features" => [
            "50,000 Monthly Word Limit", "15+ Templates", "70+ Languages",
            "Advance Editor Tool", "Regular Technical Support", "Unlimited Logins", "Newest Features"
        ],
        "paddleId" => "pro_01jr1vpqdvbn44akr5x9vz5bkh",
        "paddlePrices" => [
            [
                'id' => "pri_01jr1vpqpr3d2dstx5775sgfyp",
                'amount' => 39,
                'currency' => 'USD',
                'isYearly' => false,
                'description' => 'DIAMOND Monthly Plan'
            ],
            [
                'id' => "pri_01jr1vpqzz18q4nt5x4gtc22ab",
                'amount' => 390,
                'currency' => 'USD',
                'isYearly' => true,
                'description' => 'DIAMOND Yearly Plan'
            ]
        ]
    ]
];

// Function to get appropriate price ID for a plan based on billing cycle
function getPaddlePriceId($plan, $isYearly) {
    if (empty($plan['paddlePrices'])) {
        return null;
    }
    
    foreach ($plan['paddlePrices'] as $price) {
        if ($price['isYearly'] == $isYearly) {
            return $price['id'];
        }
    }
    
    // If no matching period found, return the first price
    return $plan['paddlePrices'][0]['id'];
}

// Default to monthly billing
$isYearly = isset($_GET['yearly']) && $_GET['yearly'] == '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pricing Plans</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- Paddle JS -->
  <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
  <script type="text/javascript">
    // Initialize Paddle with your vendor ID (replace with your actual vendor ID)
    Paddle.Setup({ vendor: 12345 });
  </script>
  <style>
    .plan-card {
      opacity: 1;
      transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .plan-card:hover {
      transform: translateY(-10px);
      border-color: #3B82F6;
    }
    .feature-item {
      opacity: 1;
      transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }
    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }
    .toggle-slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #2B3548;
      transition: .4s;
      border-radius: 34px;
    }
    .toggle-slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }
    input:checked + .toggle-slider:before {
      transform: translateX(26px);
    }
  </style>
</head>
<body class="bg-gray-900 text-white">

  <section class="min-h-screen py-12 px-4">
    <div class="max-w-xl w-full mx-auto py-16 text-center">
      <h2 class="md:text-4xl text-2xl font-extrabold text-gray-100">
        Plans that best suit your business requirements
      </h2>
    </div>

    <!-- Toggle Switch -->
    <div class="flex justify-center items-center space-x-6 mb-10">
      <span id="monthlyLabel" class="<?php echo !$isYearly ? 'text-blue-400 font-bold' : 'text-gray-400'; ?>">Billed Monthly</span>
      <label class="toggle-switch">
        <input id="billingToggle" type="checkbox" <?php echo $isYearly ? 'checked' : ''; ?>>
        <span class="toggle-slider"></span>
      </label>
      <span id="yearlyLabel" class="<?php echo $isYearly ? 'text-blue-400 font-bold' : 'text-gray-400'; ?>">Billed Yearly</span>
    </div>

    <div id="pricing" class="flex justify-center items-center">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl w-full p-6">
        <?php foreach ($pricingPlans as $planKey => $plan): ?>
            <?php
            $price = $isYearly ? $plan['yearlyPrice'] : $plan['monthlyPrice'];
            $cycle = $isYearly ? 'year' : 'month';
            $priceId = getPaddlePriceId($plan, $isYearly);
            ?>
            <div class="plan-card bg-gray-800 p-10 rounded-xl shadow-xl text-center border-2 border-gray-700">
                <h3 class="text-base text-gray-200 font-semibold"><?php echo $plan['name']; ?></h3>
                <p class="text-3xl text-gray-200 font-bold mt-5">
                    $<?php echo $price; ?> <span class="text-gray-400 text-base">/ <?php echo $cycle; ?></span>
                </p>
                <button class="paddle-checkout-button bg-indigo-600 text-white py-2 px-4 rounded-lg mt-6 w-full hover:bg-indigo-700 transition-colors" 
                        <?php echo $priceId ? 'data-price-id="'.$priceId.'"' : ''; ?>>
                    Start free trial today
                </button>
                <ul class="mt-6 space-y-4 text-gray-200 text-left">
                    <?php foreach ($plan['features'] as $feature): ?>
                        <li class="feature-item"><i class="fas fa-check-circle text-green-500 mr-2"></i> <?php echo $feature; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const billingToggle = document.getElementById('billingToggle');
      const monthlyLabel = document.getElementById('monthlyLabel');
      const yearlyLabel = document.getElementById('yearlyLabel');
      
      // Show all features with animation
      const featureItems = document.querySelectorAll('.feature-item');
      featureItems.forEach((item, index) => {
        setTimeout(() => {
          item.style.opacity = "1";
          item.style.transform = "translateX(0)";
        }, index * 100);
      });

      // Add event listener for billing toggle
      billingToggle.addEventListener('change', function() {
        // Redirect to the same page with the yearly parameter
        window.location.href = window.location.pathname + 
          (this.checked ? '?yearly=1' : '?yearly=0');
      });

      // Initialize Paddle checkout buttons
      document.querySelectorAll('.paddle-checkout-button').forEach(button => {
        button.addEventListener('click', function() {
          const priceId = this.getAttribute('data-price-id');
          if (priceId) {
            Paddle.Checkout.open({
              priceId: priceId
            });
          } else {
            alert('This plan is not yet available for purchase. Please check back later.');
          }
        });
      });
    });
  </script>

</body>
</html>