<?php
require('../vendor/autoload.php');

$redis_url = getenv("REDIS_URL");
if (!isset($redis_url) || !$redis_url)
    $redis_url = "redis://h:@localhost:6379";
$redis = new Predis\Client([
    'host' => parse_url($redis_url, PHP_URL_HOST),
    'port' => parse_url($redis_url, PHP_URL_PORT),
    'password' => parse_url($redis_url, PHP_URL_PASS),
]);

class DB
{
    const id_index = 'shape_tape_id_index';

    static function get_next_id()
    {
        global $redis;
        return intval($redis->incr(DB::id_index));
    }
}

$client = new Aws\S3\S3Client([
    'credentials' => [
        'key' => $_ENV['AWS_ACCESS_KEY'],
        'secret' => $_ENV['AWS_SECRET_KEY'],
    ],
    'region' => 'us-east-1',
    'version' => '2006-03-01',
]);

$bucket = $_ENV['S3_BUCKET'];
$key = DB::get_next_id();

$cmd = $client->getCommand('PutObject', [
    'Bucket' => $bucket,
    'Key' => "shapes/{$key}.svg",
    'ContentType' => 'image/svg+xml',
    'ACL' => 'public-read'
]);

$request = $client->createPresignedRequest($cmd, '+5 minutes');

header('Content-type:application/json;charset=utf-8');
echo(json_encode(['request' => (string)$request->getUri(), 'url' => "{$key}.svg"]));
