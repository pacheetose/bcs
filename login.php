<?php
include 'connect.php';
session_start();

if (isset($_SESSION['id'])) {

    header('location:Dashboard.php');
}

if (isset($_POST['log'])) {

    $email = $_POST['email'];
    $Password =  $_POST['Password'];

    $sql = "SELECT * FROM admin where email = '$email' and Password= '$Password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
        }
?>
        <script>
            alert('Welcome <?php echo $_SESSION['Name'] ?>');
        </script>
        <script>
            window.location = 'Dashboard.php';
        </script>
    <?php


    } else {
    ?>
        <script>
            alert('Wrong Input');
        </script>;
<?php

    }
    $conn->close();
}
?>
<!DOCTYPE html>
<form action="login.php" method="POST">
    <html lang="en">

    <head>
        <title> Login - Admin </title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
            * {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
            }

            body {
                background-image: url(loginbg.jpg);
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                background-attachment: fixed;
            }

            .box {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 90vh;
            }

            .container {
                width: 350px;
                display: flex;
                flex-direction: column;
                padding: 0 15px 0 15px;
            }

            header {
                color: #013133;
                font-size: 40px;
                font-weight: bold;
                text-shadow: 2px 2px 3px rgb(255, 255, 255);
                display: flex;
                justify-content: center;
                padding: 10px 0 10px 0;
            }

            .input-field {
                display: flex;
                color: #fff;
                flex-direction: column;
            }

            .input {
                height: 45px;
                width: 87%;
                border: none;
                outline: none;
                border-radius: 30px;
                color: #fff;
                padding: 0 0 0 45px;
                background: rgba(0, 0, 0, 0.363);
            }

            i {
                position: relative;
                top: -33px;
                left: 17px;
                color: #fff;
            }

            ::-webkit-input-placeholder {
                color: #fff;
            }

            .submit {
                border: none;
                border-radius: 30px;
                font-size: 15px;
                height: 45px;
                outline: none;
                width: 100%;
                background: rgb(0, 130, 153);
                ;
                cursor: pointer;
                transition: .3s;
            }

            .submit:hover {
                box-shadow: 1px 5px 7px 1px rgba(0, 0, 0, 0.2);
            }

            .botton {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                font-size: small;
                color: rgb(0, 0, 0);
                margin-top: 10px;
            }

            .left {
                display: flex;
            }

            label a {
                color: rgb(0, 0, 0);
                text-decoration: none;
            }
        </style>
    </head>

    <body>
        <div class="box">
            <div class="container">
                <div class="top-header">
                    <header> Login </header>
                </div>
                <form action="">
                    <div class="input-field">
                        <input type="text" name="email" placeholder="Username" class="input" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" name="Password" placeholder="Password" class="input" required>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-field">
                        <input type="submit" name="log" value="Login" class="submit">
                    </div>
                </form>
                <div class="botton">
                    <div class="left">
                        <input type="checkbox" id="check">
                        <label for="check"> Remember Me</label>
                    </div>
                    <div class="right">
                        <label><a href="#"> Forgot password </a></label>
                    </div>
                </div>

            </div>
        </div>
    </body>

    </html>