<?php require("./assets/php/auth.inc.php"); ?>

<?php

if(isset($_POST['new_password'])&&isset($_POST['new_password_confirm'])){
    $new_password = $_POST['new_password'];
    $new_password_confirm = $_POST['new_password_confirm'];

    if($new_password===$new_password_confirm){
        $user->changePassword($new_password);
        ?>
        <div style="top:0;width:100%;text-align:center;color:white;background:#3eca55">Your password has been changed!</div>
        <?php
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monarch | Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="assets/images/monarch_m_official.webp">
</head>
<body>

<!-- Header Content -->
<?php include_once("./assets/php/header.php"); ?>

<!-- Body Content -->
<div id="container">
    <div class="header" style="width:100%;">
        <h2 id="username" style="float:left; vertical-align: middle;">Your Profile</h2>
    </div>
    <hr/>

    <div class="col s12 m7" style="width: 30%">
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                    <span class="card-title">Change Password</span>
                    <form action="profile.php" method="post">
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="new_password" name="new_password" type="password" class="validate">
                                <label for="new_password">New Password</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="new_password_confirm" name="new_password_confirm" type="password" class="validate">
                                <label for="new_password_confirm">Confirm</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Change Password
                            <i class="material-icons right">send</i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="assets/javascript/app.js" type="text/javascript"></script>
<script src="assets/javascript/status.js" onload="init('<?php echo $user->getKey(); ?>',false)"></script>
</html>