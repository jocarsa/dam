<?php
$expiration = time() + (86400 * 30);
setcookie("nombre", "Mi nombre desde PHP", $expiration, "/");

if (isset($_COOKIE['nombre'])) {
    echo "Cookie establecida: " . $_COOKIE['nombre'];
} else {
    echo "Cookie aún no establecida.";
}
?>
