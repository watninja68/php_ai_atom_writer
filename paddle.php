<?php
declare(strict_types=1);
session_start();

use Paddle\SDK\Entities\Price;
use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Interval;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Entities\Shared\TaxCategory;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Shared\UnitPriceOverride;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\ApiError\PriceApiError;
use Paddle\SDK\Exceptions\ApiError\ProductApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Prices;
use Paddle\SDK\Resources\Prices\Operations\List\Includes as PriceIncludes;
use Paddle\SDK\Resources\Products;
use Paddle\SDK\Resources\Products\Operations\List\Includes as ProductIncludes;

require_once 'vendor/autoload.php';

// Specify the Paddle environment and API key.
$environment = Paddle\SDK\Environment::SANDBOX;
$apiKey = '624edce933ef3eefac82e66507f88752f9df479ed030ab5cb7';

if (is_null($apiKey)) {
    echo "You must provide the PADDLE_API_KEY in the environment.\n";
    exit(1);
}

$paddle = new Paddle\SDK\Client($apiKey, options: new Paddle\SDK\Options($environment));

/*
 * OPTIONAL: The following code creates/updates a product and a price using the SDK.
 * You can uncomment these sections if you want to run the create/update operations.
 */

// ┌─────────────
// │ Create Product
// └─────────────
// try {
//     $product = $paddle->products->create(new Products\Operations\CreateProduct(
//         name: 'Kitten Service',
//         taxCategory: TaxCategory::Standard(),
//         description: 'Simply an awesome product',
//         imageUrl: 'http://placekitten.com/200/300',
//         customData: new CustomData(['foo' => 'bar']),
//     ));
//     // echo sprintf("Created product '%s': %s <br>\n", $product->id, $product->description);
// } catch (ProductApiError|ApiError|MalformedResponse $e) {
//     // Handle errors (for debugging, you might want to log these instead)
//     var_dump($e);
//     exit;
// }

// ┌─────────────
// │ Update Product
// └─────────────
// $updateProduct = new Products\Operations\UpdateProduct(
//     name: 'Bear Service',
//     imageUrl: 'https://placebear.com/200/300',
//     customData: new CustomData(['beep' => 'boop']),
// );

// try {
//     $product = $paddle->products->update($product->id, $updateProduct);
//     // echo sprintf("Updated product '%s': %s <br>\n", $product->id, $product->description);
// } catch (ProductApiError|ApiError|MalformedResponse $e) {
//     var_dump($e);
//     exit;
// }

// ┌─────────────
// │ Create Price
// └─────────────
// try {
//     $price = $paddle->prices->create(new Prices\Operations\CreatePrice(
//         description: 'Bear Hug',
//         productId: $product->id,
//         unitPrice: new Money('1000', CurrencyCode::GBP()),
//         unitPriceOverrides: [
//             new UnitPriceOverride(
//                 [CountryCode::CA(), CountryCode::US()],
//                 new Money('5000', CurrencyCode::USD())
//             ),
//         ],
//         trialPeriod: new TimePeriod(Interval::Week(), 1),
//         billingCycle: new TimePeriod(Interval::Year(), 1),
//         quantity: new PriceQuantity(1, 1),
//         customData: new CustomData(['foo' => 'bar']),
//     ));
//     // echo sprintf("Created price '%s': %s <br>\n", $price->id, $price->description);
// } catch (PriceApiError|ApiError|MalformedResponse $e) {
//     var_dump($e);
//     exit;
// }

// ┌─────────────
// │ Update Price
// └─────────────
// $updatePrice = new Prices\Operations\UpdatePrice(
//     description: 'One-off Bear Hug',
//     unitPrice: new Money('500', CurrencyCode::GBP()),
//     customData: new CustomData(['beep' => 'boop']),
// );

// try {
//     // Optional encoding test to ensure object serializes cleanly
//     $testJson = json_encode($updatePrice, JSON_THROW_ON_ERROR);
// } catch (JsonException $e) {
//     $testJson = 'Encoding error';
// }

// try {
//     $price = $paddle->prices->update($price->id, $updatePrice);
//     // echo sprintf("Updated price '%s': %s <br>\n", $price->id, $price->description);
// } catch (PriceApiError|ApiError|MalformedResponse $e) {
//     var_dump($e);
//     exit;
// }

/*
 * Now obtain the list of active products (with prices included) from Paddle.
 */
try {
    $products = $paddle->products->list(new Products\Operations\ListProducts(
        includes: [ProductIncludes::Prices()],
        statuses: [Status::Active()]
    ));
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

// Convert the result to an array (if needed) for simple usage in the HTML.
$productsArray = iterator_to_array($products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
    <style>
        *,
        *::after,
        *::before {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Rubik', sans-serif;
            font-size: 18px;
            position: relative;
            min-height: 100vh;
        }
        .title {
            text-align: center;
            margin: 10px auto 50px auto;
            z-index: 1;
        }
        h2 {
            margin-top: 20px;
        }
        h3 {
            margin-top: 40px;
        }
        p {
            margin: 20px 30px;
            font-size: 16px;
        }
        small {
            font-size: 12px;
            color: gray;
        }
        .small-colored {
            color: #47cf73;
        }
        body::before,
        body::after {
            content:"";
            display: block;
            width: 0;
            height: 0;
            position: absolute;
            z-index: -1;
        }
        body::before {
            border-top: 30vw solid #47cf73;
            border-right: 30vw solid transparent;
            top: 0;
            left: 0;
        }
        body::after {
            border-bottom: 30vw solid black;
            border-left: 30vw solid transparent;
            right: 0;
            margin-top: -50px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }
        .offers {
            position: relative;
            text-align: center;
            background: #fff;
            padding: 1%;
            margin: 10px;
            width: 300px;
            border: 1px solid #eaeaea;
            z-index: 1;
            transition: all 0.5s ease-in-out;
        }
        .offers:hover {
            top: -20px;
            box-shadow: 0px 14px 6px 0px #0000004d;
        }
        button {
            font-size: 22px;
            font-weight: 500;
            background: #0ebeff;
            color: #fff;
            margin: 30px auto 20px auto;
            padding: 4% 8%;
            border: 0;
            transition-duration: 0.5s;
        }
        button:hover {
            background: #47cf73;
        }
    </style>
</head>
<body>
    <h1 class="title">Subscription Plans</h1>
    <div class="container">
        <?php foreach ($productsArray as $product): ?>
            <?php
            // Initialize price info in case no prices are found.
            $priceDisplay = 'N/A';
            $billingCycleText = 'Annually';
            if (isset($product->prices)) {
                // Convert iterator to an array for convenience.
                $prices = iterator_to_array($product->prices);
                // For example, pick the first price available.
                if (!empty($prices)) {
                    /** @var Price $firstPrice */
                    $firstPrice = reset($prices);
                    // Assume the unitPrice amount is stored as a string representing an integer (e.g. cents)
                    // Adjust the conversion (divide by 100) depending on how the Money value is defined.
                    $amount = $firstPrice->unitPrice->amount;
                    // Try to detect the currency code (assuming it is available via property or method)
                    $currency = method_exists($firstPrice->unitPrice, 'getCurrency') 
                        ? $firstPrice->unitPrice->getCurrency()
                        : $firstPrice->unitPrice->currency ?? 'GBP';
                    // Display the amount in a friendly formatted way.
                    $priceDisplay = sprintf('%s %.2f', $currency, $amount / 100);
                    // Optionally, adjust billingCycleText if available.
                    if (isset($firstPrice->billingCycle) && isset($firstPrice->billingCycle->interval)) {
                        $billingCycleText = ucfirst((string)$firstPrice->billingCycle->interval);
                    }
                }
            }
            ?>
            <div class="offers">
                <h2><?= htmlspecialchars($product->name) ?></h2>
                <h3 class="price"><?= htmlspecialchars($priceDisplay) ?></h3>
                <small><?= htmlspecialchars($billingCycleText) ?></small>
                <p><?= nl2br(htmlspecialchars($product->description)) ?></p>
                <button>Subscribe</button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
