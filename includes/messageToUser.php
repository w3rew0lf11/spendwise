<?php
if (isset($_GET['message'])) {
    $type = $_GET['type'] ?? 'info';

    $color = match ($type) {
        'success' => 'green',
        'error' => 'red',
        'warning' => 'orange',
        default => 'blue'
    };

    echo "<div id='flash-message' style='
            padding: 10px; 
            background-color: $color; 
            color: white; 
            margin-bottom: 15px; 
            border-radius: 5px;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            max-width: 90%;
            text-align: center;
        '>
            " . htmlspecialchars($_GET['message']) . "
          </div>";
}
?>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
      setTimeout(() => {
        
        flashMessage.style.transition = 'opacity 0.5s ease';
        flashMessage.style.opacity = '0';

        setTimeout(() => {
          flashMessage.remove();
        }, 500);
      }, 5000); // 5000 ms = 5 seconds
    }
  });
</script>
