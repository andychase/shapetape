<?php
require_once('setup.php');

$result = $aws_client->doesObjectExist(
    $bucket,
    "shapes/{$_GET['v']}.svg"
);

header("Location: http://s.shapetape.xyz/{$_GET['v']}.svg", true, 303);
