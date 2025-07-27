<?php 
require '../includes/messageToUser.php';
require '../includes/session_check.php';
require '../config/database.php';

$db = new DB();
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Fetch user info for sidebar
$user = $db->select("SELECT firstname, lastname, username FROM auth WHERE id = ?", [$user_id]);
if (!$user) die("User not found.");

$full_name = htmlspecialchars($user[0]['firstname'] . ' ' . $user[0]['lastname']);
$username = htmlspecialchars($user[0]['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SpendWise - Add Expense</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
    
    .expense-form-wrapper {
      background: #1E293B;
      border: 1px solid #334155;
      border-radius: 8px;
      padding: 30px;
      max-width: 800px;
      margin: 0 auto;
    }
    
    .section-title {
      color: #CBD5E1;
      margin-bottom: 25px;
      font-size: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 20px;
    }
    
    .full-width {
      grid-column: span 2;
    }
    
    .form-group {
      margin-bottom: 15px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #CBD5E1;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
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
    
    .file-upload {
      border: 2px dashed #334155;
      border-radius: 5px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: border-color 0.3s;
    }
    
    .file-upload:hover {
      border-color: #6366F1;
    }
    
    .file-upload p {
      margin: 10px 0 0;
      color: #94A3B8;
    }
    
    .form-buttons {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }
    
    .btn {
      padding: 10px 20px;
      border-radius: 5px;
      border: none;
      font-weight: 500;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: opacity 0.3s;
    }
    
    .btn:hover {
      opacity: 0.9;
    }
    
    .btn-primary {
      background: #6366F1;
      color: white;
    }
    
    .btn-secondary {
      background: #334155;
      color: #CBD5E1;
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
    <div class="expense-form-wrapper">
      <h2 class="section-title"><i class="fas fa-wallet"></i> Add New Expense</h2>
      <form class="form expense-form" method="POST" action="../includes/saveExpense.php" enctype="multipart/form-data">

        <div class="form-grid">
          <!-- Amount -->
          <div class="form-group">
            <label><i class="fas fa-money-bill-wave"></i> Amount</label>
            <input type="number" name="amount" placeholder="Enter amount" required />
          </div>

          <!-- Currency -->
          <div class="form-group">
            <label><i class="fas fa-coins"></i> Currency</label>
            <select id="currency-dropdown" name="currency" required></select>
          </div>

          <!-- Category -->
          <div class="form-group full-width">
            <label><i class="fas fa-list"></i> Category</label>
            <select id="category" name="category" required>
              <option disabled selected>Select category</option>
            </select>
          </div>

          <!-- Date -->
          <div class="form-group">
            <label><i class="fas fa-calendar-alt"></i> Date</label>
            <input type="date" name="date" required />
          </div>

          <!-- Description -->
          <div class="form-group">
            <label><i class="fas fa-align-left"></i> Description</label>
            <input type="text" name="description" placeholder="E.g., Office lunch or taxi ride" />
          </div>

          <!-- File Upload -->
          <div class="form-group full-width">
            <label><i class="fas fa-file-upload"></i> Upload Receipt (Optional)</label>
            <div class="file-upload">
              <label for="receipt-upload">
                <img src="https://cdn-icons-png.flaticon.com/512/3585/3585207.png" width="40" />
                <p>Choose file or drag here</p>
                <input type="file" id="receipt-upload" name="receipt" hidden />
              </label>
            </div>
          </div>
        </div>

        <!-- Buttons -->
        <div class="form-buttons">
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
          <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <script src="../js/script2.js"></script>
</body>
</html>