<?php
session_start();
require_once "pdo.php";

unset($_SESSION['name']); //To log the user out
unset($_SESSION['user_id']); //To log the user out

if (isset($_POST['cancel'])) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
if (isset($_POST['pass']) && isset($_POST['email'])) {
    $check = hash('md5', $salt . $_POST['pass']);

    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');

    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));


    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {

        $_SESSION['name'] = $row['name'];

        $_SESSION['user_id'] = $row['user_id'];

// Redirect the browser to index.php

        header("Location: index.php");

        return;
    }


// Fall through into the View
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Welcome to Autos Database | France Jules</title>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST" action="login.php">
        User Name <input type="text" name="email"><br/>
        Password <input type="text" name="pass"><br/>
        <input type="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p>
        For a password hint, view source and find a password hint
        in the HTML comments.
    </p>

<script>
function doValidate() {
    console.log('Validating...');
    try {
    addr = document.getElementById('email').value;
    pw = document.getElementById('id_1723').value;
    console.log("Validating addr="+addr+" pw="+pw);
    if (addr == null || addr == "" || pw == null || pw == "") {
        alert("Both fields must be filled out");
        return false;
    } 
    if(addr.indexOf('@') == -1){
        alert("Invalid email address");
        return false;
    }
    return true;
  } catch(e) {
    return false;
  }
  return false;
}
</script>

</div>
</body>
</html>