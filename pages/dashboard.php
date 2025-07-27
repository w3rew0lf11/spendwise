<?php
require '../config/database.php';
require_once '../includes/session_check.php';

$db = new DB();
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Fetch user info
$user = $db->select("SELECT firstname, lastname, username FROM auth WHERE id = ?", [$user_id]);
if (!$user) die("User not found.");

$full_name = htmlspecialchars($user[0]['firstname'] . ' ' . $user[0]['lastname']);
$username = htmlspecialchars($user[0]['username']);

// Total expenses
$total_expense_data = $db->select("SELECT SUM(amount) AS total FROM expenses WHERE user_id = ?", [$user_id]);
$total_expense = $total_expense_data[0]['total'] ?? 0;

// Recent expenses (latest 5)
$recent_expenses = $db->select(
    "SELECT description as title, amount, amountInUSD, category, date FROM expenses WHERE user_id = ? ORDER BY date DESC ",
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
      margin:0; 
      font-family:'Segoe UI',sans-serif; 
      background:#0F172A; 
      color:#CBD5E1;
      display: flex;
    }
    
    /* Sidebar styles */
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
      padding: 10px;
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
      display: block;
      background: #EF4444;
      color: white;
      padding: 10px;
      text-align: center;
      border-radius: 5px;
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
      background: #6366F1;
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
    
    /* Main content styles */
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
      background:#1E293B;
      border:1px solid #334155;
      border-radius:8px;
      padding:20px;
    }
    
    .table {
      width:100%;
      border-collapse:collapse;
    }
    
    .table th, .table td {
      padding:12px;
      border-bottom:1px solid #334155;
    }
    
    .table th {
      background:#1E293B;
      font-weight:600;
    }
    
    .chart-container {
      position:relative;
      height:300px;
      width:100%;
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
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">SpendWise</div>
    
    <div class="profile-section">
      <div class="profile-icon"><?= strtoupper(substr($user[0]['firstname'], 0, 1)) ?></div>
      <div class="profile-info">
        <div class="name"><?= $full_name ?></div>
        <div class="username">@<?= $username ?></div>
      </div>
    </div>
    
    <nav class="nav-links">
      <a href="/spendwise/pages/dashboard.php">Dashboard</a>
      <a href="/spendwise/pages/addExpense.php">Add Expense</a>
      <a href="reports.php">Reports</a>
      <a href="/spendwise/pages/settings.php">Settings</a>
    </nav>
    
    <div class="logout-section">
      <a href="/spendwise/auth/logout.php" class="logout-btn">Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h1>Dashboard</h1>
    
    <!-- Summary Cards -->
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
    
    <!-- Recent Expenses Table -->
    <div class="card">
      <h3>Recent Expenses</h3>
      <?php if ($recent_expenses): ?>
      <table class="table">
        <thead>
          <tr><th>Date</th><th>Title</th><th>Category</th><th>Amount</th><th>Amount IN USD</th></tr>
        </thead>
        <tbody>

          <?php foreach ($recent_expenses as $row): ?>
          
          <tr>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td style="color:#EF4444;">Rs. <?= number_format($row['amount'], 2) ?></td>
            <td><?= htmlspecialchars($row['amountInUSD'])?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?>
        <p>No expenses added yet.</p>
      <?php endif; ?>
    </div>
    
    <!-- Chart Section -->
    <div class="card">
      <h3>Expense Visualization</h3>
      
      <div class="chart-tabs">
        <div class="chart-tab active" data-type="pie">By Category</div>
        <div class="chart-tab" data-type="bar">Monthly</div>
        <div class="chart-tab" data-type="line">Yearly</div>
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
    // Initialize with pie chart
    drawChart('pie');
    
    // Tab switching
    const tabs = document.querySelectorAll('.chart-tab');
    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        drawChart(tab.dataset.type);
      });
    });
  });
</script>
</body>
</html>