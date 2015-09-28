<?php
require_once('setup.php');

$key = DB::get_next_id();

$cmd = $aws_client->getCommand('PutObject', [
    'Bucket' => $bucket,
    'Key' => "shapes/{$key}.svg",
    'ContentType' => 'image/svg+xml',
    'ACL' => 'public-read'
]);

$request = $aws_client->createPresignedRequest($cmd, '+5 minutes');

header('Content-type:application/json;charset=utf-8');
echo(json_encode([
    'request' => (string)$request->getUri(),
    'url' => "{$key}.svg"
]));
