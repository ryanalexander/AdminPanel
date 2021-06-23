<?php
require_once("./assets/php/config.inc.php");

@SESSION_START();

if(isset($_POST['username'])&&isset($_POST['password'])){
    // Connect to database
    $conn = mysqli_connect(Config::$db_host,Config::$db_user,Config::$db_pass,Config::$db_database);

    // Parse username & password to prevent SQL injection
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Build & execute query
    $result = mysqli_query($conn,"SELECT * FROM `staff_accounts` WHERE `username`='$username' AND `password`='$password' LIMIT 1;");

    if($result&&$result->num_rows===1){
        echo "Logging in";
        $reply = mysqli_fetch_assoc($result);
        $_SESSION['id']=$reply['id'];
        $_SESSION['username']=$reply['username'];
        $_SESSION['uuid']=$reply['uuid'];
        $_SESSION['role']=$reply['role'];
        $_SESSION['key']=$reply['api_key'];
        header("Location: index.php");
        return;
    }else {
        echo "Logging in fail";
        print_r(mysqli_error($conn));
    }
}
?>

<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <link rel="shortcut icon" type="image/png" href="assets/images/monarch_m_official.webp">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }

        body {
            background: #fff;
        }

        .input-field input[type=date]:focus + label,
        .input-field input[type=text]:focus + label,
        .input-field input[type=email]:focus + label,
        .input-field input[type=password]:focus + label {
            color: #e91e63;
        }

        .input-field input[type=date]:focus,
        .input-field input[type=text]:focus,
        .input-field input[type=email]:focus,
        .input-field input[type=password]:focus {
            border-bottom: 2px solid #e91e63;
            box-shadow: none;
        }
    </style>
    <title>Monarch | Login</title>
</head>

<body>
<div class="section"></div>
<main>
    <div style="text-align: center;">
        <div class="section">
            <img src="assets/images/monarch_official.webp" style="width:30em;">
        </div>
        <div class="container">
            <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

                <form class="col s12" method="post">
                    <div class='row'>
                        <div class='col s12'>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='input-field col s17'>
                            <input type='text' name='username' id='username' />
                            <label for='username'>Username</label>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='input-field col s12'>
                            <input class='validate' type='password' name='password' id='password' />
                            <label for='password'>Password</label>
                        </div>
                    </div>

                    <br />
                    <center>
                        <div class='row'>
                            <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect orange'>Login</button>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>

    <div class="section"></div>
    <div class="section"></div>
</main>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
</body>

</html>
