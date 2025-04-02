<?php
session_start();

if (!isset($_SESSION['hints_used'])) {
    $_SESSION['hints_used'] = 0;
}

if ($_SESSION['hints_used'] < 2) {
    $_SESSION['hints_used']++;
}

header('Content-Type: application/json');
echo json_encode(['success' => true, 'hints_used' => $_SESSION['hints_used']]);
?>
