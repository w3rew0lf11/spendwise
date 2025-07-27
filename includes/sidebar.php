<?php
// Fetch user info from DB before output
$user = $db->select("SELECT firstname, lastname, username FROM auth WHERE id = ?", [$user_id]);
if (!$user) {
    die("User not found.");
}

$full_name = htmlspecialchars($user[0]['firstname'] . ' ' . $user[0]['lastname']);
$username = htmlspecialchars($user[0]['username']);
$initial = strtoupper(substr($user[0]['firstname'], 0, 1));
?>

<div class="sidebar">
    <div class="logo">SpendWise</div>

    <div class="profile-section">
      <div class="profile-icon"><?= $initial ?></div>
      <div class="profile-info">
        <div class="name"><?= $full_name ?></div>
        <div class="username">@<?= $username ?></div>
      </div>
    </div>

    <nav class="nav-links">
      <a href="/spendwise/pages/dashboard.php">Dashboard</a>
      <a href="/spendwise/pages/addExpense.php">Add Expense</a>
      <a href="/spendwise/pages/report.php">Reports</a>
      <a href="/spendwise/pages/settings.php">Settings</a>
    </nav>

    <div class="logout-section">
      <a href="/spendwise/auth/logout.php" class="logout-btn">Logout</a>
    </div>
</div>
