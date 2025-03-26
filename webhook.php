<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use GuzzleHttp\Psr7\ServerRequest;
use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Events\TransactionUpdated;
use Paddle\SDK\Notifications\Secret;
use Paddle\SDK\Notifications\Verifier;

// Capture the request
$request = ServerRequest::fromGlobals();

// Secret key from Paddle
$secret = new Secret('pdl_ntfset_01jq9k0z3j5m5tfaz5708xqk4z_sOC+7fruDmFOC3YekE33+hqYNvw8cXUA');

// Verify the request
$isVerified = (new Verifier())->verify($request, $secret);

if ($isVerified) {
    echo json_encode(["message" => "Webhook is verified"]);

    $event = Event::fromRequest($request);
    $id = $event->notificationId;
    $eventId = $event->eventId;
    $eventType = $event->eventType;
    $occurredAt = $event->occurredAt;

    if ($event instanceof TransactionUpdated) {
        $transactionId = $event->transaction->id;
    }

    // Ensure Paddle gets a valid response
    http_response_code(200);
    exit();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Webhook is not verified"]);
    exit();
}
