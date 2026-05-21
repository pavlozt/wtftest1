<?php
header('Content-Type: text/plain; charset=utf-8');
echo "X-Forwarded-For: " . ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? 'none') . "\n";
?>