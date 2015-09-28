<?php

require('../vendor/autoload.php');

$redis_url = getenv('REDIS_URL');
$bucket = getenv('S3_BUCKET');

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

$aws_client = new Aws\S3\S3Client([
    'credentials' => [
        'key' => $_ENV['AWS_ACCESS_KEY'],
        'secret' => $_ENV['AWS_SECRET_KEY'],
    ],
    'region' => 'us-east-1',
    'version' => '2006-03-01',
]);
