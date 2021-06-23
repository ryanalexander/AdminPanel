<?php require("./assets/php/auth.inc.php"); ?>

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
    <header>
        <div class="col s12 m7" style="width: 15%">
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="card-title">GLOBAL</span>
                        <p>Players: <i><span id="players-current">?</span> / <span id="players-max">?</span></i></p>
                        <p>Proxies: <i><span id="proxies-current">?</span></i></p>
                        <p>Minecraft: <i><span id="minecraft-current">?</span></i></p>
                        <p>Dedicated: <i><span id="dedicated-current">?</span></i></p>
                    </div>
                    <div class="card-action">
                        <a href="#">View Expanded stats</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m7" style="width: 15%">
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="card-title">HUB</span>
                        <p>Players: <i>1,337 / 2000</i></p>
                        <p>Usage: <i>10%</i></p>
                        <p>Deployments: <i>5</i></p>
                        <br/>
                    </div>
                    <div class="card-action">
                        <a href="#">View Expanded stats</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m7" style="width: 15%">
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="card-title">Creative</span>
                        <p>Players: <i>1,337 / 2000</i></p>
                        <p>Usage: <i>10%</i></p>
                        <p>Deployments: <i>5</i></p>
                        <br/>
                    </div>
                    <div class="card-action">
                        <a href="#">View Expanded stats</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m7" style="width: 15%">
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="card-title">Skyblock</span>
                        <p>Players: <i>1,337 / 2000</i></p>
                        <p>Usage: <i>10%</i></p>
                        <p>Deployments: <i>5</i></p>
                        <br/>
                    </div>
                    <div class="card-action">
                        <a href="#">View Expanded stats</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m7" style="width: 15%">
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="card-title">Minigames</span>
                        <p>Players: <i>1,337 / 2000</i></p>
                        <p>Usage: <i>10%</i></p>
                        <p>Deployments: <i>5</i></p>
                        <br/>
                    </div>
                    <div class="card-action">
                        <a href="#">View Expanded stats</a>
                    </div>
                </div>
            </div>
        </div>

        <hr style="opacity:0.25;"/>
    </header>

    <div class="col s12 m7" style="width: 15%">
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                    <span class="card-title">Region based players</span>
                    <div id="regions_div" style="width: 20em; height: 20em; background:transparent"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m7" style="width: 20%;margin-left: 8em;vertical-align: top;">
        <div class="card horizontal" style="width: 100%;">
            <div class="card-stacked" style="width: 100%;">
                <div class="card-content" style="width: 100%;">
                    <span class="card-title">Recent Players</span>
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Lookup</th>
                        </tr>
                        </thead>

                        <tbody id="recent_players"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m7" style="width: 25%;margin-left: 3em;vertical-align: top;">
        <div class="card horizontal" style="width: 100%;">
            <div class="card-stacked" style="width: 100%;">
                <div class="card-content" style="width: 100%;">
                    <span class="card-title">Recent Punishments</span>
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Player</th>
                            <th>Lookup</th>
                        </tr>
                        </thead>

                        <tbody id="recent_punishments"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="assets/javascript/dashboard.js" type="text/javascript" onload="init('<?php echo $user->getKey(); ?>');"></script>
<script src="assets/javascript/app.js" type="text/javascript"></script>
<script src="assets/javascript/status.js" onload="init('<?php echo $user->getKey(); ?>',false)"></script>
</html>