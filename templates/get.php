<?php

if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)
    header("Location: http://s.shapetape.xyz/{$_GET['v']}.svg.gz", true, 303);
else
    header("Location: http://s.shapetape.xyz/{$_GET['v']}.svg", true, 303);
