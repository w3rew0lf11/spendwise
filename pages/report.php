<?php
require '../config/database.php';
require_once '../includes/session_check.php';

$db = new DB();
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

$month = $_GET['month'] ?? date('Y-m');

$expenses = $db->select(
    "SELECT * FROM expenses WHERE user_id = ? AND DATE_FORMAT(date, '%Y-%m') = ? ORDER BY date ASC",
    [$user_id, $month]
);

$total = 0;
foreach ($expenses as $e) {
    $total += $e['amountInUSD'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Expense Bill - <?= htmlspecialchars($month) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0F172A;
            color: #CBD5E1;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #1E293B;
            height: 100vh;
            position: fixed;
            padding: 20px;
            box-sizing: border-box;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #6366F1;
            padding: 10px;
        }
.profile-section {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 30px;
  padding: 10px;
  background: #334155;
  border-radius: 5px;
}
.profile-icon {
  width: 40px;
  height: 40px;
  background: #6366f1;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
}
.profile-info {
  font-size: 14px;
}
.profile-info .name {
  font-weight: bold;
}

        .nav-links a {
            display: block;
            color: #CBD5E1;
            padding: 10px;
            margin-bottom: 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: #334155;
        }

        .logout-section {
            position: absolute;
            bottom: 20px;
            width: calc(100% - 40px);
        }

        .logout-btn {
            display: block;
            background: #EF4444;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            width: calc(100% - 250px);
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #ffffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background: #1E293B;
        }

        th, td {
            border: 1px solid #334155;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #6366F1;
            color: white;
        }

        tfoot td {
            font-weight: bold;
        }

        .btn-print {
            margin-top: 20px;
            padding: 10px 20px;
            background: #6366F1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }

        .btn-print:hover {
            opacity: 0.9;
        }
    </style>

    <!-- ✅ Print-only CSS block must be separate -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .main-content, .main-content * {
                visibility: visible;
            }

            .main-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <?php require '../includes/sidebar.php'; ?>

    <div class="main-content">
        <h1>Expense Bill - <?= htmlspecialchars($month) ?></h1>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Amount (USD)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenses as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e['date']) ?></td>
                        <td><?= htmlspecialchars($e['description']) ?></td>
                        <td><?= htmlspecialchars($e['category']) ?></td>
                        <td style="text-align:right;"><?= number_format($e['amountInUSD'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total</td>
                    <td style="text-align:right;"><?= number_format($total, 2) ?></td>
                </tr>
            </tfoot>
        </table>

        <button class="btn-print" onclick="window.print()">Print / Save as PDF</button>
    </div>
</body>
</html>
