<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../config/database.php';

$errors = [];
$success = [];

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$db = new DB();
$userId = $_SESSION['user_id']; 


$userData = $db->select("SELECT username, profile_picture FROM auth WHERE id = ?", [$userId]);
$currentUsername = $userData ? $userData[0]['username'] : '';
$currentProfilePic = $userData && !empty($userData[0]['profile_picture']) ? $userData[0]['profile_picture'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type'])) {
    switch ($_POST['form_type']) {
        case 'update_profile':
            $newUsername = trim($_POST['username']);
            if (empty($newUsername)) {
                $errors[] = 'Username cannot be empty.';
            } else {
                $existing = $db->select("SELECT id FROM auth WHERE username = ? AND id != ?", [$newUsername, $userId]);
                if ($existing) {
                    $errors[] = 'Username already taken.';
                } else {
                    $updated = $db->update("UPDATE auth SET username = ? WHERE id = ?", [$newUsername, $userId]);
                    if ($updated) {
                        $_SESSION['username'] = $newUsername;
                        $success[] = 'Username updated successfully.';
                    } else {
                        $errors[] = 'No changes made or update failed.';
                    }
                }
            }
            break;

        case 'change_password':
            $current = $_POST['current_password'];
            $new = $_POST['new_password'];
            $confirm = $_POST['confirm_password'];

            $user = $db->select("SELECT password FROM auth WHERE id = ?", [$userId]);
            if (!$user) {
                $errors[] = 'User not found.';
            } elseif (!password_verify($current, $user[0]['password'])) {
                $errors[] = 'Current password is incorrect.';
            } elseif ($new !== $confirm) {
                $errors[] = 'New passwords do not match.';
            } else {
                $newHash = password_hash($new, PASSWORD_DEFAULT);
                $updated = $db->update("UPDATE auth SET password = ? WHERE id = ?", [$newHash, $userId]);
                if ($updated) {
                    $success[] = 'Password updated successfully.';
                } else {
                    $errors[] = 'Failed to update password.';
                }
            }
            break;

        case 'upload_picture':
            if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'File upload error.';
            } else {
                $file = $_FILES['profile_picture'];
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];

                if (!in_array($file['type'], $allowed)) {
                    $errors[] = 'Invalid file type.';
                } else {
                    $uploadDir = '../uploads/profile_pictures/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = 'profile_' . $userId . '_' . time() . '.' . $ext;
                    $filepath = $uploadDir . $filename;

                    if (move_uploaded_file($file['tmp_name'], $filepath)) {
                        $updated = $db->update("UPDATE auth SET profile_picture = ? WHERE id = ?", [$filename, $userId]);
                        if ($updated) {
                            $success[] = 'Profile picture updated successfully.';
                        } else {
                            $errors[] = 'Failed to save profile picture to database.';
                        }
                    } else {
                        $errors[] = 'Failed to move uploaded file.';
                    }
                }
            }
            break;

        case 'delete_account':
           
            $db->delete("DELETE FROM expenses WHERE user_id = ?", [$userId]);
$deleted = $db->delete("DELETE FROM auth WHERE id = ?", [$userId]);

            if ($deleted) {
                session_destroy();
                header('Location: ../index.php');
                exit;
            } else {
                $errors[] = 'Failed to delete account.';
            }
            break;
    }
}
?>
