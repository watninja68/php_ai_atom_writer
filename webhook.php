i<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use GuzzleHttp\Psr7\ServerRequest;
use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Events\TransactionUpdated;
use Paddle\SDK\Notifications\Secret;
use Paddle\SDK\Notifications\Verifier;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Log function to help debug requests
function logMessage(string $filename, $data)
{
    file_put_contents($filename, print_r($data, true) . "\n", FILE_APPEND);
}

// Capture raw request body
$rawPayload = file_get_contents('php://input');

// Capture request headers
$headers = getallheaders();
logMessage('request_headers.log', $headers);
logMessage('webhook_payload.log', $rawPayload);

// Set the correct content type header for Paddle
header('Content-Type: application/json');

// Convert raw body into a PSR-7 compliant request
$request = ServerRequest::fromGlobals();

// Your Paddle Webhook Secret (Replace this with your actual Paddle Webhook Secret)
$secretKey = 'pdl_ntfset_01jq9k0z3j5m5tfaz5708xqk4z_sOC+7fruDmFOC3YekE33+hqYNvw8cXUA';

try {
    // Verify Paddle Webhook
    $isVerified = (new Verifier())->verify($request, new Secret($secretKey));

    if ($isVerified) {
        logMessage('webhook_debug.log', '✅ Webhook verified successfully');

        // Parse the event from the request
        $event = Event::fromRequest($request);
        $id = $event->notificationId;
        $eventId = $event->eventId;
        $eventType = $event->eventType;
        $occurredAt = $event->occurredAt;

        logMessage('webhook_debug.log', [
            'notification_id' => $id,
            'event_id' => $eventId,
            'event_type' => $eventType,
            'occurred_at' => $occurredAt
        ]);

        // If it's a TransactionUpdated event, process it
        if ($event instanceof TransactionUpdated) {
            $transactionId = $event->transaction->id;
            logMessage('webhook_debug.log', ['transaction_id' => $transactionId]);
        }

        // Respond to Paddle to acknowledge the webhook
        echo json_encode(['status' => 'success', 'message' => 'Webhook verified']);
    } else {
        logMessage('webhook_debug.log', '❌ Webhook verification failed');
        echo json_encode(['status' => 'error', 'message' => 'Webhook verification failed']);
    }
} catch (Exception $e) {
    logMessage('webhook_debug.log', '⚠️ Error: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Internal server error']);
}
