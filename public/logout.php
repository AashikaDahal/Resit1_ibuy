<?php 
    session_start();

    $_SESSION['user_role'] = '';
    $_SESSION['user_id'] = '';
    $_SESSION['user_email'] = '';
    // unset($_SESSION);

    // header("Location: ./login.php");
    echo '<script>window.location.href="login.php"</script>';
?>