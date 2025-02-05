<?php
$scriptDir = __DIR__;

$pythonScript = $scriptDir . '/002-escribe.py';

$output = [];
$returnVar = 0;

exec("python3 " . escapeshellarg($pythonScript), $output, $returnVar);

// Display the output
echo "Lo que devuelve es:\n" . implode("\n", $output) . "\n";
echo "Código de vuelta: $returnVar\n";
?>
