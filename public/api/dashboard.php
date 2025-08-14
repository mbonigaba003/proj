<?php
require_once __DIR__ . '/../../app/bootstrap.php';

$payload = get_demo_data();
$payload['bannerMessage'] = $payload['announcements'][0]['title'] . ': ' . $payload['announcements'][0]['content'];

json_response($payload);