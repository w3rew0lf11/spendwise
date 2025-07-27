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

  .container {
    margin-left: 250px;
    width: calc(100% - 250px);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px;
    box-sizing: border-box;
  }

  .settings-container {
    background: #1E293B;
    border: 1px solid #334155;
    border-radius: 8px;
    padding: 30px;
    max-width: 600px;
    width: 100%;
  }

  h2, h3 {
    color: #E2E8F0;
    text-align: center;
  }


  .profile-pic-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin: 0 auto 20px;
    border: 3px solid #334155;
    background-color: #0F172A;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .profile-pic-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }

  .settings-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 40px;
    background: #0F172A;
    border: 1px solid #334155;
    padding: 20px;
    border-radius: 6px;
  }

  .settings-form input[type="text"],
  .settings-form input[type="password"],
  .settings-form input[type="file"] {
    padding: 10px 12px;
    background: #1E293B;
    border: 1px solid #334155;
    border-radius: 5px;
    color: #CBD5E1;
    font-size: 15px;
  }

  .settings-form input:focus {
    outline: none;
    border-color: #6366F1;
  }

  .settings-form button {
    background: #6366F1;
    border: none;
    padding: 10px 16px;
    border-radius: 5px;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .settings-form button:hover {
    background: #4F46E5;
  }

  .settings-form.danger button {
    background: #EF4444;
  }

  .settings-form.danger button:hover {
    background: #DC2626;
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

  p {
    margin: 0;
  }

  p[style*="color:red"] {
    color: #F87171;
  }

  p[style*="color:green"] {
    color: #4ADE80;
  }
</style>

    
  </style>
</head>
<body>
   <?php include('../includes/sidebar.php'); ?>
  <div class="container">
     

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
