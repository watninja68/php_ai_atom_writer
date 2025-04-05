<?php
declare(strict_types=1);

use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Interval;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Entities\Shared\TaxCategory;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\ApiError\PriceApiError;
use Paddle\SDK\Exceptions\ApiError\ProductApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Prices;
use Paddle\SDK\Resources\Products;

require_once 'vendor/autoload.php';

// Specify the Paddle environment and API key
$environment = Paddle\SDK\Environment::SANDBOX; // Use SANDBOX for testing, PRODUCTION for live
$apiKey = '624edce933ef3eefac82e66507f88752f9df479ed030ab5cb7'; // Replace with your actual API key

if (empty($apiKey) || $apiKey === 'YOUR_PADDLE_API_KEY') {
    echo "Please provide a valid PADDLE_API_KEY.\n";
    exit(1);
}

$paddle = new Paddle\SDK\Client($apiKey, options: new Paddle\SDK\Options($environment));

// Define our pricing tiers
$pricingTiers = [
    'BRONZE' => [
        'name' => 'BRONZE',
        'description' => '10,000 Monthly Word Limit, 10+ Templates, 30+ Languages, Advance Editor Tool, Regular Technical Support, Unlimited Logins, Newest Features',
        'monthlyPrice' => 900, // $9 in cents
        'yearlyPrice' => 9000, // $90 in cents
        'imageUrl' => 'https://example.com/bronze.jpg', // Replace with your actual image URL
    ],
    'SILVER' => [
        'name' => 'SILVER',
        'description' => '20,000 Monthly Word Limit, 10+ Templates, 50+ Languages, Advance Editor Tool, Regular Technical Support, Unlimited Logins, Newest Features',
        'monthlyPrice' => 1900, // $19 in cents
        'yearlyPrice' => 19000, // $190 in cents
        'imageUrl' => 'https://example.com/silver.jpg', // Replace with your actual image URL
    ],
    'DIAMOND' => [
        'name' => 'DIAMOND',
        'description' => '50,000 Monthly Word Limit, 15+ Templates, 70+ Languages, Advance Editor Tool, Regular Technical Support, Unlimited Logins, Newest Features',
        'monthlyPrice' => 3900, // $39 in cents
        'yearlyPrice' => 39000, // $390 in cents
        'imageUrl' => 'https://example.com/diamond.jpg', // Replace with your actual image URL
    ],
];

// Array to store created product and price IDs
$createdProductsAndPrices = [];

// Create products and prices for each tier
foreach ($pricingTiers as $tierKey => $tier) {
    echo "Creating {$tierKey} tier product and prices...\n";
    
    try {
        // 1. Create Product
        $product = $paddle->products->create(new Products\Operations\CreateProduct(
            name: $tier['name'],
            taxCategory: TaxCategory::Standard(),
            description: $tier['description'],
            imageUrl: $tier['imageUrl'],
            customData: new CustomData(['tier' => strtolower($tierKey)]),
        ));
        
        echo "Created product: {$product->id} - {$product->name}\n";
        
        $createdProductsAndPrices[$tierKey] = [
            'product_id' => $product->id,
            'prices' => []
        ];
        
        // 2. Create Monthly Price
        $monthlyPrice = $paddle->prices->create(new Prices\Operations\CreatePrice(
            description: "{$tier['name']} Monthly Plan",
            productId: $product->id,
            unitPrice: new Money((string)$tier['monthlyPrice'], CurrencyCode::USD()),
            billingCycle: new TimePeriod(Interval::Month(), 1),
            quantity: new PriceQuantity(1, 1), // Min and max quantity both set to 1
            customData: new CustomData(['billing' => 'monthly']),
        ));
        
        echo "Created monthly price: {$monthlyPrice->id} - $" . ($tier['monthlyPrice'] / 100) . "/month\n";
        
        $createdProductsAndPrices[$tierKey]['prices']['monthly'] = [
            'id' => $monthlyPrice->id,
            'amount' => $tier['monthlyPrice']/100,
            'cycle' => 'monthly'
        ];
        
        // 3. Create Yearly Price
        $yearlyPrice = $paddle->prices->create(new Prices\Operations\CreatePrice(
            description: "{$tier['name']} Yearly Plan",
            productId: $product->id,
            unitPrice: new Money((string)$tier['yearlyPrice'], CurrencyCode::USD()),
            billingCycle: new TimePeriod(Interval::Year(), 1),
            quantity: new PriceQuantity(1, 1), // Min and max quantity both set to 1
            customData: new CustomData(['billing' => 'yearly']),
        ));
        
        echo "Created yearly price: {$yearlyPrice->id} - $" . ($tier['yearlyPrice'] / 100) . "/year\n";
        
        $createdProductsAndPrices[$tierKey]['prices']['yearly'] = [
            'id' => $yearlyPrice->id,
            'amount' => $tier['yearlyPrice']/100,
            'cycle' => 'yearly'
        ];
        
    } catch (ProductApiError|PriceApiError|ApiError|MalformedResponse $e) {
        echo "Error creating {$tierKey} tier: " . $e->getMessage() . "\n";
        continue; // Continue with next tier even if this one fails
    }
    
    echo "Successfully created {$tierKey} tier with all prices.\n\n";
}

// Display summary of all created products and prices
echo "\n=== SUMMARY OF CREATED PRODUCTS AND PRICES ===\n\n";
echo json_encode($createdProductsAndPrices, JSON_PRETTY_PRINT);
echo "\n\n";

// Generate code for pricing page integration
echo "=== CODE FOR PRICING PAGE INTEGRATION ===\n\n";

echo "// Add this to your pricing page to hardcode the Paddle IDs:\n";
echo "// Replace the auto-detection logic with this array\n\n";

echo "\$pricingPlans = [\n";
foreach ($pricingTiers as $tierKey => $tier) {
    if (!isset($createdProductsAndPrices[$tierKey])) {
        continue; // Skip tiers that failed to create
    }
    
    echo "    \"{$tierKey}\" => [\n";
    echo "        \"name\" => \"{$tierKey}\",\n";
    echo "        \"monthlyPrice\" => " . ($tier['monthlyPrice']/100) . ",\n";
    echo "        \"yearlyPrice\" => " . ($tier['yearlyPrice']/100) . ",\n";
    echo "        \"features\" => [\n";
    
    // Extract features from description
    $features = explode(', ', $tier['description']);
    foreach ($features as $feature) {
        echo "            \"{$feature}\",\n";
    }
    
    echo "        ],\n";
    echo "        \"paddleId\" => \"{$createdProductsAndPrices[$tierKey]['product_id']}\",\n";
    echo "        \"paddlePrices\" => [\n";
    echo "            [\n";
    echo "                'id' => \"{$createdProductsAndPrices[$tierKey]['prices']['monthly']['id']}\",\n";
    echo "                'amount' => {$createdProductsAndPrices[$tierKey]['prices']['monthly']['amount']},\n";
    echo "                'currency' => 'USD',\n";
    echo "                'isYearly' => false,\n";
    echo "                'description' => '{$tierKey} Monthly Plan'\n";
    echo "            ],\n";
    echo "            [\n";
    echo "                'id' => \"{$createdProductsAndPrices[$tierKey]['prices']['yearly']['id']}\",\n";
    echo "                'amount' => {$createdProductsAndPrices[$tierKey]['prices']['yearly']['amount']},\n";
    echo "                'currency' => 'USD',\n";
    echo "                'isYearly' => true,\n";
    echo "                'description' => '{$tierKey} Yearly Plan'\n";
    echo "            ]\n";
    echo "        ]\n";
    echo "    ],\n";
}
echo "];\n";

echo "\n=== END OF SCRIPT ===\n";
?>