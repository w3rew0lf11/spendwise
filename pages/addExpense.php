<?php 
require '../includes/messageToUser.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SpendWise - Add Expense</title>
  <link rel="stylesheet" href="/spendwise/css/style2.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
  <canvas id="animated-bg"></canvas>


  <div class="container">
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
