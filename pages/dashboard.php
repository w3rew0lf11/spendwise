<?php 
require_once('../includes/session_check.php');
include('../includes/header.php');
?>

<div class="container mt-4">
    <h2>Welcome to Your Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

    <p>This is your protected dashboard area.</p>

    <a href="../auth/logout.php" class="btn btn-outline">Logout</a>
</div>

<?php include('../includes/footer.php'); ?>
