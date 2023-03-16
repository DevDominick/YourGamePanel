<?php

// Replace with your webhook secret
$secret = 'your_webhook_secret';

// Get the signature header
$header_signature = isset($_SERVER['HTTP_X_SELLIX_SIGNATURE']) ? $_SERVER['HTTP_X_SELLIX_SIGNATURE'] : '';

// Get the payload
$payload = file_get_contents('php://input');

// Verify the signature
$signature = hash_hmac('sha512', $payload, $secret);
if (!hash_equals($signature, $header_signature)) {
    exit('Invalid signature');
}

// Decode the payload
$data = json_decode($payload, true);

// Extract the event and data
$event = isset($data['event']) ? $data['event'] : '';
$data = isset($data['data']) ? $data['data'] : array();

// Extract the data fields
$uqid = isset($data['uniqid']) ? $data['uniqid'] : '';
$status = isset($data['status']) ? $data['status'] : '';

// Handle the event
if ($event == 'order.completed' && $status == 'COMPLETED') {
    // Change data values in your database here
}
