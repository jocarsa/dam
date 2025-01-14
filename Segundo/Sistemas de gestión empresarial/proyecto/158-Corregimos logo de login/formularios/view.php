<?php
if (isset($_GET['file'])) {
    $file = 'docs/'.$_GET['folder'].'/' . basename($_GET['file']);
    if (file_exists($file)) {
        echo '<h1>Viewing Content of: ' . htmlspecialchars($_GET['file']) . '</h1>';
        echo '<pre>' . htmlspecialchars(file_get_contents($file)) . '</pre>';
    } else {
        echo '<h1>File not found</h1>';
    }
} else {
    echo '<h1>No file specified</h1>';
}
?>

