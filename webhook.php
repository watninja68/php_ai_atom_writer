<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use GuzzleHttp\Psr7\ServerRequest;
use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Events\TransactionUpdated;
use Paddle\SDK\Notifications\Events\TransactionCompleted;
use Paddle\SDK\Notifications\Events\SubscriptionCreated;
use Paddle\SDK\Notifications\Secret;
use Paddle\SDK\Notifications\Verifier;

// Load database connection
require_once 'db_init.php';

// Capture the request
$request = ServerRequest::fromGlobals();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Secret key from Paddle
$secret = new Secret($_ENV['PADDLE_SECRET']);

// Verify the request
$isVerified = (new Verifier())->verify($request, $secret);
if ($isVerified) {
    echo json_encode(["message" => "Webhook is verified let's gooooo"]);

    $event = Event::fromRequest($request);
    $id = $event->notificationId;
    $eventId = $event->eventId;
    $eventType = $event->eventType;
    $occurredAt = $event->occurredAt;
    
    // Log the event for debugging
    file_put_contents('webhook_log.txt', date('Y-m-d H:i:s') . ' - Event: ' . $eventType . PHP_EOL, FILE_APPEND);
    
    // Process transaction updates
    if ($event instanceof TransactionUpdated || $event instanceof TransactionCompleted) {
        $transactionId = $event->transaction->id;
        $customerId = $event->transaction->customerId ?? null;
        $amount = $event->transaction->totals->total ?? 0;
        $status = $event->transaction->status;
        $paymentMethod = $event->transaction->paymentMethod->type ?? 'paddle';
        
        // Get user ID from customer ID (you may need to modify this based on your user-customer mapping)
        $userId = getUserIdFromCustomerId($pdo, $customerId);
        
        // Insert or update transaction record
        if ($userId) {
            $stmt = $pdo->prepare("INSERT INTO transcations (trx_id, user_id, payment_method, amount, status, created_at, updated_at) 
                                  VALUES (:trx_id, :user_id, :payment_method, :amount, :status, NOW(), NOW())
                                  ON DUPLICATE KEY UPDATE status = :status, updated_at = NOW()");
            
            $stmt->execute([
                'trx_id' => $transactionId,
                'user_id' => $userId,
                'payment_method' => $paymentMethod,
                'amount' => $amount,
                'status' => $status
            ]);
            
            echo "<h1>Transaction recorded: $transactionId</h1>";
        } else {
            file_put_contents('webhook_log.txt', date('Y-m-d H:i:s') . ' - User not found for customer: ' . $customerId . PHP_EOL, FILE_APPEND);
        }
    }
    
    // Process subscription events
    if ($event instanceof SubscriptionCreated) {
        $subscriptionId = $event->subscription->id;
        $customerId = $event->subscription->customerId ?? null;
        $planId = $event->subscription->items[0]->priceId ?? null; // Assuming first item is the subscription plan
        $status = $event->subscription->status;
        
        // Get user ID from customer ID
        $userId = getUserIdFromCustomerId($pdo, $customerId);
        
        if ($userId) {
            // Update user's plan
            $stmt = $pdo->prepare("UPDATE users SET plan_id = :plan_id, will_expire = :expire_date, updated_at = NOW() 
                                  WHERE id = :user_id");
            
            // Calculate expiration date based on billing cycle
            $expireDate = calculateExpiryDate($event->subscription->billingPeriod ?? 'monthly');
            
            $stmt->execute([
                'plan_id' => getPlanIdFromPaddlePlan($pdo, $planId),
                'expire_date' => $expireDate,
                'user_id' => $userId
            ]);
            
            echo "<h1>Subscription created: $subscriptionId</h1>";
        } else {
            file_put_contents('webhook_log.txt', date('Y-m-d H:i:s') . ' - User not found for subscription customer: ' . $customerId . PHP_EOL, FILE_APPEND);
        }
    }

} else {
    echo json_encode(["error" => "Webhook is not verified booo"]);
}

// Helper function to get user ID from customer ID
function getUserIdFromCustomerId($pdo, $customerId) {
    if (!$customerId) return null;
    
    // Look up user by customer ID in user metadata
    $stmt = $pdo->prepare("SELECT user_id FROM usermetas WHERE `key` = 'paddle_customer_id' AND `value` = :customer_id LIMIT 1");
    $stmt->execute(['customer_id' => $customerId]);
    $result = $stmt->fetch();
    
    if ($result) {
        return $result['user_id'];
    }
    
    // If not found in metadata, try direct lookup (modify as needed based on your schema)
    $stmt = $pdo->prepare("SELECT id FROM users WHERE data LIKE :customer_data LIMIT 1");
    $stmt->execute(['customer_data' => '%"customer_id":"' . $customerId . '"%']);
    $result = $stmt->fetch();
    
    return $result ? $result['id'] : null;
}

// Helper function to calculate expiry date
function calculateExpiryDate($billingPeriod) {
    switch ($billingPeriod) {
        case 'weekly':
            return date('Y-m-d H:i:s', strtotime('+1 week'));
        case 'monthly':
            return date('Y-m-d H:i:s', strtotime('+1 month'));
        case 'quarterly':
            return date('Y-m-d H:i:s', strtotime('+3 months'));
        case 'annually':
            return date('Y-m-d H:i:s', strtotime('+1 year'));
        default:
            return date('Y-m-d H:i:s', strtotime('+1 month'));
    }
}

// Helper function to map Paddle plan ID to local plan ID
function getPlanIdFromPaddlePlan($pdo, $paddlePlanId) {
    if (!$paddlePlanId) return null;
    
    // Look up plan by Paddle plan ID in options or plan metadata
    $stmt = $pdo->prepare("SELECT id FROM plans WHERE data LIKE :paddle_data LIMIT 1");
    $stmt->execute(['paddle_data' => '%"paddle_plan_id":"' . $paddlePlanId . '"%']);
    $result = $stmt->fetch();
    
    return $result ? $result['id'] : null;
}
