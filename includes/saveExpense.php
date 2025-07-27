<?php
require '../config/database.php';
session_start(); 

function convertToUSD($fromCurrency, $amount)
{
    $fromCurrency = strtoupper($fromCurrency);
    $access_key = '6ef44925cae915c552d209d89e9208ba';
    $url = "https://api.exchangerate.host/convert?from={$fromCurrency}&to=USD&amount={$amount}&access_key={$access_key}";

    $response = file_get_contents($url);
    if ($response === false) {
        throw new Exception("Unable to reach exchangerate.host.");
    }

    $data = json_decode($response, true);
    if (isset($data['result'])) {
        return round($data['result'], 2);
    } else {
        throw new Exception("Invalid response from currency API.");
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 🟡 Step 1: Get user_id from session
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../pages/login.php?message=" . urlencode("User not logged in.") . "&type=error");
        exit();
    }
    $user_id = $_SESSION['user_id'];

    $amount = trim($_POST['amount'] ?? '');
    $currency = trim($_POST['currency'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $receipt_path = null;
    echo '<pre>';
print_r($_SESSION);
echo '</pre>';


    // ✅ Input validation
    if (!$amount || !is_numeric($amount) || $amount <= 0) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Invalid or missing amount.") . "&type=error");
        exit();
    }
    if (!$currency) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Currency is required.") . "&type=error");
        exit();
    }
    if (!$category) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Category is required.") . "&type=error");
        exit();
    }
    if (!$date) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Date is required.") . "&type=error");
        exit();
    }

    // ✅ Prevent future dates
    $currentDate = new DateTime();
    $expenseDate = new DateTime($date);
    if ($expenseDate > $currentDate) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Date cannot be in the future.") . "&type=error");
        exit();
    }

    // ✅ Handle file upload
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($_FILES['receipt']['name'], PATHINFO_EXTENSION);
        $receiptName = uniqid('receipt_', true) . '.' . $extension;
        $targetFile = $uploadDir . $receiptName;

        if (move_uploaded_file($_FILES['receipt']['tmp_name'], $targetFile)) {
            $receipt_path = $targetFile;
        }
    }

    // ✅ Convert to USD
    try {
        $amountInUSD = convertToUSD($currency, $amount);
    } catch (Exception $e) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Currency conversion failed: " . $e->getMessage()) . "&type=error");
        exit();
    }

    // ✅ Save to database with user_id
    $db = new DB();
    try {
        $db->create(
            "INSERT INTO expenses (user_id, amount, currency, amountInUSD, category, date, description, receipt_path)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [$user_id, $amount, $currency, $amountInUSD, $category, $date, $description, $receipt_path]
        );

        header("Location: ../pages/addExpense.php?message=" . urlencode("Expense recorded successfully.") . "&type=success");
        exit();
    } catch (Exception $e) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Failed to save expense: " . $e->getMessage()) . "&type=error");
        exit();
    }
} else {
    echo "Invalid request method.";
}