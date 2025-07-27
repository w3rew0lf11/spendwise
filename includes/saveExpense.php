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
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../pages/login.php?message=" . urlencode("User not logged in.") . "&type=error");
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    $db = new DB();

    $expense_id = $_POST['expense_id'] ?? null; // 🟡 For edit
    $amount = trim($_POST['amount'] ?? '');
    $currency = trim($_POST['currency'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $receipt_path = null;

    // ✅ Basic validation
    if (!$amount || !is_numeric($amount) || $amount <= 0 ||
        !$currency || !$category || !$date) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Missing required fields.") . "&type=error");
        exit();
    }

    // ✅ Validate future date
    if (new DateTime($date) > new DateTime()) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Date cannot be in the future.") . "&type=error");
        exit();
    }

    // ✅ Handle file upload
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext = pathinfo($_FILES['receipt']['name'], PATHINFO_EXTENSION);
        $receiptName = uniqid('receipt_', true) . '.' . $ext;
        $targetFile = $uploadDir . $receiptName;

        if (move_uploaded_file($_FILES['receipt']['tmp_name'], $targetFile)) {
            $receipt_path = $targetFile;
        }
    }

    // ✅ Convert amount to USD
    try {
        $amountInUSD = convertToUSD($currency, $amount);
    } catch (Exception $e) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Currency conversion failed.") . "&type=error");
        exit();
    }

    try {
        if ($expense_id) {
            // 🟣 UPDATE existing expense
            $params = [$amount, $currency, $amountInUSD, $category, $date, $description, $user_id, $expense_id];
            $sql = "UPDATE expenses SET amount=?, currency=?, amountInUSD=?, category=?, date=?, description=? WHERE user_id=? AND id=?";
            $db->update($sql, $params);

            if ($receipt_path) {
                $db->update("UPDATE expenses SET receipt_path=? WHERE user_id=? AND id=?", [$receipt_path, $user_id, $expense_id]);
            }

            header("Location: ../pages/dashboard.php?message=" . urlencode("Expense updated.") . "&type=success");
        } else {
            // 🟢 INSERT new expense
            $sql = "INSERT INTO expenses (user_id, amount, currency, amountInUSD, category, date, description, receipt_path)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $db->create($sql, [$user_id, $amount, $currency, $amountInUSD, $category, $date, $description, $receipt_path]);

            header("Location: ../pages/addExpense.php?message=" . urlencode("Expense added.") . "&type=success");
        }

        exit();
    } catch (Exception $e) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("DB Error: " . $e->getMessage()) . "&type=error");
        exit();
    }
} else {
    echo "Invalid request method.";
}
