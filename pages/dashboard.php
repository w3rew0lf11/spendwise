<?php 
require_once('../includes/session_check.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SpendWise Dashboard</title>
  <link rel="stylesheet" href="/spendwise/css/dashboard.css" />
  <link rel="stylesheet" href="/spendwise/css/sidebar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>
  <div class="container">
    <!-- Sidebar -->
     <div class="sidebar">
     <?php include('../includes/sidebar.php'); ?>
     </div>
      <hr>
      <div class="user">
        <img src="https://via.placeholder.com/40" alt="Avatar" />
        <div>
          <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
          <p>
            <?php 
              echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'No username available';
            ?>
          </p>
        </div>
      </div>

    <!-- Main Content -->
    <main class="dashboard">
      <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>


      <div class="top-row">
        
        <!-- Pie Chart Card -->
        <div class="card spending">
         <p>Total Spending</p>
         <canvas id="pieChart" width="100%" height="100"></canvas>
        </div>
        <!-- <div class="card chart">
          <p>By Category</p>
          <ul class="category-list">
            <li><span class="dot food"></span> Food - $420.50</li>
            <li><span class="dot travel"></span> Travel - $315.75</li>
            <li><span class="dot shopping"></span> Shopping - $280.30</li>
            <li><span class="dot bills"></span> Bills - $150.00</li>
            <li><span class="dot other"></span> Other - $79.12</li>
          </ul>
        </div> -->
        <!-- Line Chart Card -->
        <div class="card chart">
        <p>By Category</p>
        <canvas id="lineChart" width="100%" height="100"></canvas>
</div>
      </div>

      <div class="expenses-section">
        <div class="header">
          <h3>Recent Expenses</h3>
          <a href="#">Monthly Spending Trend</a>
        </div>
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Category</th>
              <th>Description</th>
              <th>Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>May 15, 2023</td>
              <td><span class="badge food">Food</span></td>
              <td>Dinner at Italian Restaurant</td>
              <td>$45.60</td>
              <td><i class="fas fa-edit"></i> <i class="fas fa-trash-alt"></i></td>
            </tr>
            <tr>
              <td>May 14, 2023</td>
              <td><span class="badge travel">Travel</span></td>
              <td>Train tickets</td>
              <td>$32.50</td>
              <td><i class="fas fa-edit"></i> <i class="fas fa-trash-alt"></i></td>
            </tr>
            <tr>
              <td>May 13, 2023</td>
              <td><span class="badge shopping">Shopping</span></td>
              <td>New shoes</td>
              <td>$69.99</td>
              <td><i class="fas fa-edit"></i> <i class="fas fa-trash-alt"></i></td>
            </tr>
            <tr>
              <td>May 12, 2023</td>
              <td><span class="badge bills">Bills</span></td>
              <td>Electricity bill</td>
              <td>$75.00</td>
              <td><i class="fas fa-edit"></i> <i class="fas fa-trash-alt"></i></td>
            </tr>
            <tr>
              <td>May 10, 2023</td>
              <td><span class="badge food">Food</span></td>
              <td>Groceries</td>
              <td>$62.30</td>
              <td><i class="fas fa-edit"></i> <i class="fas fa-trash-alt"></i></td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>

</body>
</html>
<script>
  // Line Chart (Spending by Category over Months)
  const ctxLine = document.getElementById('lineChart').getContext('2d');
  const lineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'], // You can extend this
      datasets: [
        {
          label: 'Food',
          data: [100, 120, 130, 150, 160],
          borderColor: '#FF6384',
          fill: false
        },
        {
          label: 'Travel',
          data: [80, 100, 90, 110, 130],
          borderColor: '#36A2EB',
          fill: false
        },
        {
          label: 'Shopping',
          data: [70, 85, 95, 90, 100],
          borderColor: '#FFCE56',
          fill: false
        },
        {
          label: 'Bills',
          data: [50, 55, 60, 65, 70],
          borderColor: '#4BC0C0',
          fill: false
        },
        {
          label: 'Other',
          data: [30, 40, 35, 30, 45],
          borderColor: '#9966FF',
          fill: false
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });

  // Pie Chart (Total Spending by Category)
  const ctxPie = document.getElementById('pieChart').getContext('2d');
  const pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
      labels: ['Food', 'Travel', 'Shopping', 'Bills', 'Other'],
      datasets: [{
        data: [420.50, 315.75, 280.30, 150.00, 79.12],
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });
</script>

