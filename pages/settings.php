<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../includes/session_check.php';
$user_id = $_SESSION['user_id'];

include('../includes/settingslogic.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings - SpendWise</title>
  <link rel="stylesheet" href="/spendwise/css/sidebar.css">
  <link rel="stylesheet" href="/spendwise/css/settings.css">
  <style>
    .profile-pic-preview img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #ccc;
      display: inline-block;
    }
    .profile-pic-preview {
      text-align: center;
      margin-bottom: 20px;
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
.settings-container {
      width: 100%;
      padding: 10px 12px;
      background: #0F172A;
      border: 1px solid #334155;
      border-radius: 5px;
      color: #CBD5E1;
      font-size: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
      <?php include('../includes/sidebar.php'); ?>

    <div class="settings-container">

      <div class="profile-pic-preview">
        <img 
          src="<?php 
            echo $currentProfilePic ? 
              '/spendwise/uploads/profile_pictures/' . htmlspecialchars($currentProfilePic) : 
              '/spendwise/images/default-profile.png'; 
          ?>" 
          alt="Profile Picture"
        >
      </div>

      <h2>Account Settings</h2>

      <?php foreach ($errors as $error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
      <?php endforeach; ?>
      <?php foreach ($success as $msg): ?>
        <p style="color:green;"><?php echo htmlspecialchars($msg); ?></p>
      <?php endforeach; ?>

      <form action="" method="POST" class="settings-form">
        <input type="hidden" name="form_type" value="update_profile">
        <h3>Edit Profile</h3>
        <input 
          type="text" 
          name="username" 
          placeholder="Username" 
          required 
          value="<?php echo htmlspecialchars($currentUsername); ?>"
        >
        <button type="submit">Change Username</button>
      </form>

      <form action="" method="POST" class="settings-form">
        <input type="hidden" name="form_type" value="change_password">
        <h3>Change Password</h3>
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit">Change Password</button>
      </form>

      <form action="" method="POST" enctype="multipart/form-data" class="settings-form">
        <input type="hidden" name="form_type" value="upload_picture">
        <h3>Profile Picture</h3>
        <input type="file" name="profile_picture" accept="image/*" required>
        <button type="submit">Upload Picture</button>
      </form>

      <form action="" method="POST" class="settings-form danger">
        <input type="hidden" name="form_type" value="delete_account">
        <h3>Delete Account</h3>
        <p>This action is irreversible.</p>
        <button type="submit" onclick="return confirm('Are you sure you want to delete your account?');">Delete My Account</button>
      </form>
    </div>
  </div>
</body>
</html>
