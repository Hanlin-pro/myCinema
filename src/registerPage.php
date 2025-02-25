<?php
require_once('connection.php');
require_once('./php/component.php');
$database = DBConnection::get_instance();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My cinema | Sign Up</title>
    <link href="./style/main.css" rel="stylesheet">
    <link rel="shortcut icon" href="./assets/images/icon.png" type="image/png">
    <link href="./style/misc-style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #SignUp-Toggle {
            border-bottom: 2px solid gray;
        }
    </style>
    <?php
    //password format check
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['user_name']) && isset($_POST['user_password']) && isset($_POST['email'])) {
            $username = htmlspecialchars($_POST['user_name']);
            $password = htmlspecialchars($_POST['user_password']);
            $repeatPwd = htmlspecialchars($_POST['repeatPwd']);
            $email = htmlspecialchars($_POST['email']);
            $promotion = isset($_POST['promotion']) ? 1 : 0;
            $number = preg_match('@[0-9]@', $password);
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);
            if (strlen($password) < 8 || !$number || !$uppercase || !$specialChars) {
                $login_err = "Password must have at least 8 characters, a number, a capital letter, and a special character";
            } else if ($repeatPwd != $password) {
                $login_err = "Password not matched";
            } else {
                //check fi email or username pre-existing
                $emailNotExist = DBConnection::get_instance()->emailNotExist(encrypt_decrypt($email));
                $usernameNotExist = DBConnection::get_instance()->usernameNotExist($username);
                if (!$emailNotExist) {
                    $login_err = "Email is already registered";
                    goto end;
                }
                if (!$usernameNotExist) {
                    $login_err = "Username is already taken";
                    goto end;
                }
                //connection to DB
                $connection = DBConnection::get_instance()->get_connection();
                //query string
                $sql = "INSERT INTO user_info (`username`, `password`, `email`, `promotion`) VALUES ('" . $username . "','" . encrypt_decrypt($password) . "','" . $email . "', '" . $promotion . "')";
                $result = mysqli_query($connection, $sql);
                if ($result != false) {
                    //erroe handling
                    echo ("<script type='text/javascript'> console.log($msg);</script>");
                    header('Location: static/redirectSignUp.html');
                } else {
                    $login_err = "Invalid Info.";
                }
            }
        }
        end:
    }
    ?>
</head>

<body>

    <div class="main">
        <div class="loginWindow">
            <div class="toggleContainer">
                <a href="./registerPage.php"><button id="SignUp-Toggle" class="toggleButton">Sign Up</button></a>
                <a href="./loginPage.php"> <button id="LogIn-Toggle" class="toggleButton">Log In</button></a>
            </div class="LoginForm">
            <form id="register-form" method="POST" action="">
                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input class="input-form" type="email" name="email" placeholder="Email Address" required>
                </div>
                <br>
                <div class="form-group">
                    <label>Username:</label>
                    <input name="user_name" placeholder="Username" required>
                </div>
                <br>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" class="input-form" name="user_password" placeholder="Password" required>
                </div>
                <br>
                <div class="form-group">
                    <label>Re-enter:</label>
                    <input type="password" class="input-form" placeholder="Password" name="repeatPwd" required>
                </div>
                <br>
                <div class="form-group">
                    <label>Sign up for promotion</label>
                    <input type="checkbox" class="input-form" name="promotion">
                </div>
                <br><?php
                    if (!empty($login_err)) {
                        echo '<div style="text-align:center;" >' . $login_err . '</div>';
                    } else {
                        echo '<br>';
                    }
                    ?>
                <div class='buttonBox'>
                    <button type="submit" class="submittButton">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>