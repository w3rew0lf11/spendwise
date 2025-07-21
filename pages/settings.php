<?php include('../backend/settingslogic.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings - SpendWise</title>
  <link rel="stylesheet" href="/spendwise/css/sidebar.css">
  <link rel="stylesheet" href="/spendwise/css/settings.css">
  <style>
    /* Optional CSS if you want to move styles here */
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
  </style>
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <?php include('../includes/sidebar.php'); ?>
    </div>

    <div class="settings-container">

      <!-- Profile Picture Preview -->
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

      <!-- Display Messages -->
      <?php foreach ($errors as $error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
      <?php endforeach; ?>
      <?php foreach ($success as $msg): ?>
        <p style="color:green;"><?php echo htmlspecialchars($msg); ?></p>
      <?php endforeach; ?>

      <!-- Edit Profile -->
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

      <!-- Change Password -->
      <form action="" method="POST" class="settings-form">
        <input type="hidden" name="form_type" value="change_password">
        <h3>Change Password</h3>
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit">Change Password</button>
      </form>

      <!-- Upload Picture -->
      <form action="" method="POST" enctype="multipart/form-data" class="settings-form">
        <input type="hidden" name="form_type" value="upload_picture">
        <h3>Profile Picture</h3>
        <input type="file" name="profile_picture" accept="image/*" required>
        <button type="submit">Upload Picture</button>
      </form>

      <!-- Delete Account -->
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
