<?php require("./assets/php/auth.inc.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monarch | Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <link rel="stylesheet" href="assets/stylesheets/status.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="assets/images/monarch_m_official.webp">
</head>
<body>

<!-- Header Content -->
<?php include_once("./assets/php/header.php"); ?>

<!-- Body Content -->
<div id="container">

    <div style="margin:0;padding:0;width:100%;">
        <h2 id="username" style="display:inline-block; vertical-align: middle;">MineGames Status Page</h2>
    </div>

    <hr/>


    <div>
        <ul class="collapsible" id="status-list">
        </ul>
    </div>

</div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="assets/javascript/app.js" type="text/javascript"></script>
<script src="assets/javascript/reports.js" type="text/javascript" onload="init('<?php echo $user->getKey(); ?>');"></script>
<script src="assets/javascript/status.js" onload="init('<?php echo $user->getKey(); ?>',true)"></script>
</html>