<?php
require '../config/database.php';
require_once '../includes/session_check.php';

$db = new DB();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

$expense_id = $_GET['id'] ?? null;

if (!$expense_id) {
    die("Expense ID not provided.");
}

$expense = $db->select("SELECT * FROM expenses WHERE id = ? AND user_id = ?", [$expense_id, $user_id]);

if (!$expense) {
    die("Expense not found.");
}

$expense = $expense[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Expense</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #0F172A;
      color: #CBD5E1;
    }

    .main-content {
      max-width: 700px;
      margin: 80px auto;
      padding: 30px;
      background: #1E293B;
      border: 1px solid #334155;
      border-radius: 8px;
    }

    h2 {
      text-align: center;
      color: #ffffff;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      color: #CBD5E1;
      margin-bottom: 8px;
      font-weight: 500;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 12px;
      background: #0F172A;
      border: 1px solid #334155;
      border-radius: 5px;
      color: #CBD5E1;
      font-size: 15px;
    }

    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: #6366F1;
    }

    .form-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 25px;
    }

    .btn {
      padding: 10px 20px;
      border-radius: 5px;
      border: none;
      font-weight: 500;
      text-decoration: none;
      cursor: pointer;
      transition: opacity 0.3s;
      display: inline-block;
    }

    .btn-primary {
      background: #6366F1;
      color: white;
    }

    .btn-secondary {
      background: #334155;
      color: #CBD5E1;
    }

    .btn:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <div class="main-content">
    <h2>Edit Expense</h2>
    <form method="POST" action="../includes/saveExpense.php" enctype="multipart/form-data">
      <input type="hidden" name="expense_id" value="<?= htmlspecialchars($expense['id']) ?>">

      <div class="form-group">
        <label>Description:</label>
        <input type="text" name="description" value="<?= htmlspecialchars($expense['description']) ?>" required>
      </div>

      <div class="form-group">
        <label>Amount:</label>
        <input type="number" step="0.01" name="amount" value="<?= $expense['amount'] ?>" required>
      </div>

      <div class="form-group">
        <label>Currency:</label>
        <input type="text" name="currency" value="<?= $expense['currency'] ?>" required>
      </div>

      <div class="form-group">
        <label>Category:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($expense['category']) ?>" required>
      </div>

      <div class="form-group">
        <label>Date:</label>
        <input type="date" name="date" value="<?= $expense['date'] ?>" required>
      </div>

      <div class="form-buttons">
        <button type="submit" class="btn btn-primary">Update Expense</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
