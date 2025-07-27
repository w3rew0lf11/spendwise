<?php
require '../config/database.php';
require_once '../includes/session_check.php';

$db = new DB();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expense_id = $_POST['expense_id'] ?? null;

    if ($expense_id) {
        $db->delete("DELETE FROM expenses WHERE id = ? AND user_id = ?", [$expense_id, $user_id]);
    }
}

header("Location: dashboard.php");
exit;
