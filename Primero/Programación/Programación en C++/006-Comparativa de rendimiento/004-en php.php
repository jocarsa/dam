<?php

$start = microtime(true);

$numero = 1.00000000435;
for ($i = 0; $i < 1000000000; $i++) {
    $numero *= 1.0000000000054;
}

$end = microtime(true);
$duration = $end - $start;

echo $numero . PHP_EOL;
echo "Tiempo transcurrido: " . $duration . " segundos" . PHP_EOL;

