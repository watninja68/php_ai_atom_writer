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
    var_dump($event);
    if ($event instanceof TransactionUpdated) {
        $transactionId = $event->transaction->id;
        echo "<h1>Transaction ID: $transactionId</h1>";
    }

    // Ensure Paddle gets a valid response

} else {
    echo json_encode(["error" => "Webhook is not verified booo"]);
}
