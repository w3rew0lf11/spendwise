<?php
require '../config/database.php';

function convertToUSD($fromCurrency, $amount)
{
    $fromCurrency = strtoupper($fromCurrency);
    // https://exchangerate.host/dashboard
$access_key = '9b8efb036da88ff318b9a4d505a7c1db';
$url = "https://api.exchangerate.host/convert?from={$fromCurrency}&to=USD&amount={$amount}&access_key={$access_key}";

    $response = file_get_contents($url);
    //  echo "<pre>";
    // print_r($url);
    //  echo "<pre>";
    //  exit();

    if ($response === false) {
        throw new Exception("Unable to reach exchangerate.host.");
    }

    $data = json_decode($response, true);

    //  echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    

    if (isset($data['result'])) {
        return round($data['result'], 2);
    } else {
        throw new Exception("Invalid response from currency API.");
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = trim($_POST['amount'] ?? '');
    $currency = trim($_POST['currency'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $receipt_path = null;

    // Validate required inputs
    if (!$amount || !is_numeric($amount) || $amount <= 0) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Invalid or missing amount."). "&type=error");
        exit();
    }
    if (!$currency) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Currency is required."). "&type=error");
        exit();
    }
    if (!$category) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Category is required."). "&type=error");
        exit();
    }
   if (!$date) {
    header("Location: ../pages/addExpense.php?message=" . urlencode("Date is required."). "&type=error");
    exit();
}

// Check if date is in the future
$currentDate = new DateTime();                // today's date
$expenseDate = new DateTime($date);           // user input date

if ($expenseDate > $currentDate) {
    header("Location: ../pages/addExpense.php?message=" . urlencode("Date cannot be of future."). "&type=error");
    exit();
}


    // Handle receipt file upload if provided
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

    // Convert amount to USD
    try {
        $amountInUSD = convertToUSD($currency, $amount);
    } catch (Exception $e) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Currency conversion failed: " . $e->getMessage()). "&type=error");
        exit();
    }

    // Insert into database
    $db = new DB();
    try {
        $db->create(
            "INSERT INTO expenses (amount, currency, amountInUSD, category, date, description, receipt_path)
             VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$amount, $currency, $amountInUSD, $category, $date, $description, $receipt_path]
        );

header("Location: ../pages/addExpense.php?message=" . urlencode("Expense recorded successfully.") . "&type=success");
        exit();
    } catch (Exception $e) {
        header("Location: ../pages/addExpense.php?message=" . urlencode("Failed to save expense: " . $e->getMessage()). "&type=error");
        exit();
    }
} else {
    echo "Invalid request method.";
}
