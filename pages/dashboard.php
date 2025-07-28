<?php
require '../config/database.php';
require_once '../includes/session_check.php';

$db = new DB();
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}



$total_expense_data = $db->select("SELECT SUM(amount) AS total FROM expenses WHERE user_id = ?", [$user_id]);
$total_expense = $total_expense_data[0]['total'] ?? 0;

$recent_expenses = $db->select(
    "SELECT id, description as title, amount, amountInUSD, category, currency, date FROM expenses WHERE user_id = ? ORDER BY date DESC",
    [$user_id]
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard – SpendWise</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
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
      border-right: 1px solid #334155;
    }
    .logo {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 30px;
      color: #6366F1;
    }
    .nav-links {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .nav-links a {
      color: #CBD5E1;
      text-decoration: none;
      padding: 10px;
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
      background: #EF4444;
      color: white;
      padding: 10px;
      text-align: center;
      border-radius: 5px;
      display: block;
      text-decoration: none;
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

    .main-content {
      margin-left: 250px;
      width: calc(100% - 250px);
      padding: 30px;
      box-sizing: border-box;
    }
    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }
    .card {
      background: #1E293B;
      border: 1px solid #334155;
      border-radius: 8px;
      padding: 20px;
    }
    .table {
      width: 100%;
      border-collapse: collapse;
    }
    .table th, .table td {
      padding: 12px;
      border-bottom: 1px solid #334155;
    }
    .table th {
      background: #1E293B;
      font-weight: 600;
    }
    .chart-container {
      position: relative;
      height: 300px;
      width: 100%;
    }
    .chart-tabs {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }
    .chart-tab {
      padding: 8px 16px;
      background: #334155;
      border-radius: 5px;
      cursor: pointer;
    }
    .chart-tab.active {
      background: #6366F1;
    }
    .btn {
      padding: 5px 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn-primary {
      background-color: #22c55e;
      color: white;
    }
    .btn-danger {
      background-color: #ef4444;
      color: white;
    }
  </style>
</head>
<body>
  
   
    
        <?php require '../includes/sidebar.php'; ?>

  

  <div class="main-content">
    <h1>Dashboard</h1>
    <div class="card-grid">
      <div class="card">
        <h3>Total Expenses</h3>
        <p style="font-size:28px; color:#EF4444;">Rs. <?= number_format($total_expense, 2) ?></p>
      </div>
      <div class="card">
        <h3>Recent Transactions</h3>
        <p style="font-size:28px;"><?= count($recent_expenses) ?></p>
      </div>
    </div>

    <div class="card">
      <h3>Recent Expenses</h3>
      <?php if ($recent_expenses): ?>
      <table class="table">
        <thead>
          <tr><th>Date</th><th>Title</th><th>Category</th><th>Amount</th><th>USD</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($recent_expenses as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td style="color:#EF4444;"> <?= htmlspecialchars($row['currency']) . ' ' . number_format($row['amount'], 2) ?></td>
            <td>$<?= htmlspecialchars($row['amountInUSD']) ?></td>
            <td>
              <a href="editExpense.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit</a>
              <form method="POST" action="deleteExpense.php" style="display:inline;">
  <input type="hidden" name="expense_id" value="<?= $row['id'] ?>">
  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
</form>

            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?><p>No expenses found.</p><?php endif; ?>
    </div>

    <div class="card">
      <h3>Expense Visualization</h3>
      <div class="chart-tabs">
        <div class="chart-tab active" data-type="pie">Pie-chart</div>
        <div class="chart-tab" data-type="bar">Bar_Graph</div>
        <div class="chart-tab" data-type="line">Line_Graph</div>
      </div>
      <div class="chart-container">
        <canvas id="expenseChart"></canvas>
      </div>
    </div>
  </div>

  <script>
    const recentExpenses = <?= json_encode($recent_expenses) ?>;
    const categoriesData = {};
    recentExpenses.forEach(e => {
      categoriesData[e.category] = (categoriesData[e.category] || 0) + parseFloat(e.amount);
    });
    const labels = Object.keys(categoriesData);
    const dataPoints = Object.values(categoriesData);
    const palette = [
      'rgba(255,99,132,0.6)','rgba(54,162,235,0.6)',
      'rgba(255,206,86,0.6)','rgba(75,192,192,0.6)',
      'rgba(153,102,255,0.6)','rgba(255,159,64,0.6)'
    ];

    const ctx = document.getElementById('expenseChart').getContext('2d');
    let chart;

    function drawChart(type) {
      if (chart) chart.destroy();
      chart = new Chart(ctx, {
        type: type,
        data: {
          labels,
          datasets: [{
            label: `Expenses (${type})`,
            data: dataPoints,
            backgroundColor: palette,
            borderColor: '#6366F1',
            borderWidth: 1,
            fill: type === 'line',
            tension: 0.3
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: true, labels: { color: '#CBD5E1' } }
          },
          scales: (type === 'bar' || type === 'line') ? {
            y: { beginAtZero: true, ticks: { color: '#CBD5E1' }, grid: { color: '#334155' } },
            x: { ticks: { color: '#CBD5E1' }, grid: { color: '#334155' } }
          } : {}
        }
      });
    }

    document.addEventListener('DOMContentLoaded', () => {
      drawChart('pie');
      document.querySelectorAll('.chart-tab').forEach(tab => {
        tab.addEventListener('click', () => {
          document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
          tab.classList.add('active');
          drawChart(tab.dataset.type);
        });
      });
    });
  </script>
</body>
</html>
