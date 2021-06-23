<?php require("./assets/php/auth.inc.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monarch | Player Lookup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script type="text/javascript" src="https://www.gstatic.codm/charts/loader.js"></script>
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
        <h2 id="username" style="float:left; vertical-align: middle;">Type a username to start -></h2>
        <h2 style="float:right;vertical-align: middle;width: 30%;text-align: right;">
            <input style="display:inline-block;vertical-align: middle;width: 60%;" placeholder="Search UUID or Username" id="search" type="text">
            <i style="vertical-align: middle;display:inline-block;cursor:pointer;" class="material-icons" id="search_icon">search</i>
        </h2>
    </div>
    <hr>

    <div class="col s12 m7" style="width: 25%; vertical-align: top;">
        <div class="card horizontal large" style="width: 100%">
            <div class="card-content" style="width: 100%">
                <span class="card-title">Player Information</span>
                <div class="row" style="width:100%">
                    <div class="input-field col s12">
                        <input disabled value="?" id="uuid" type="text" class="validate" style="width:100%;">
                        <label class="active" for="uuid">UUID</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="?" id="nickname" type="text" class="validate" style="width:100%;">
                        <label class="active" for="nickname">Nickname</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="rank-select" multiple>
                            <option value="OWNER">OWNER</option>
                            <option value="MANAGER">MANAGER</option>
                            <option value="MODERATOR">MODERATOR</option>
                            <option value="HELPER">HELPER</option>
                            <option value="IMPERIAL">IMPERIAL</option>
                            <option value="ULTRA">ULTRA</option>
                            <option value="MEGA">MEGA</option>
                            <option value="SUPER">SUPER</option>
                            <option value="MEMBER">MEMBER</option>
                        </select>
                        <label>Roles</label>
                    </div>
                    <p><b>Status: </b><span id="online-status">??</span></p>
                    <p><b>Last seen: </b><span id="last-seen">??</span></p>
                    <p><b>Joined: </b><span id="first-seen">??</span></p>
                    <p><b>Last IP: </b><span id="last-ip">??</span></p>
                </div>

                <!-- Punishment Options -->
                <div id="punish-actions">
                    <a class="btn-floating btn-large waves-effect waves-light modal-trigger" data-target="ban_modal"><i class="material-icons circle red">gavel</i></a>
                    <a class="btn-floating btn-large waves-effect waves-light modal-trigger" data-target="mute_modal"><i class="material-icons circle indigo">subtitles_off</i></a>
                    <a class="btn-floating btn-large waves-effect waves-light modal-trigger" data-target="warn_modal"><i class="material-icons circle orange">note</i></a>
                    <a class="btn-floating btn-large waves-effect waves-light modal-trigger" data-target="kick_modal"><i class="material-icons circle blue">meeting_room</i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m7" style="width: 20%">
        <div class="card horizontal large" style="width: 100%;">
            <div class="card-content" style="width:100%;">
                <span class="card-title">Punishment History <a href="#!" class="secondary-content">see all</a></span>
                <ul class="collection" id="punishment-history">
                </ul>
            </div>
        </div>
    </div>
    <div class="col s12 m7" style="width: 20%; vertical-align: top;">
        <div class="card horizontal large" style="width: 100%;">
            <div class="card-content" style="width:100%;">
                <span class="card-title">Staff History <a href="#!" class="secondary-content">see all</a></span>
                <ul class="collection">
                    <li class="collection-item avatar">
                        <i class="material-icons circle red">gavel</i>
                        <span class="title">AspyTheAussie</span>
                        <p>Test ban</p>
                        <a href="#!" class="secondary-content"><i class="fa fa-info-circle"></i></a>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle indigo">subtitles_off</i>
                        <span class="title">AspyTheAussie</span>
                        <p>Test mute</p>
                        <a href="#!" class="secondary-content"><i class="fa fa-info-circle"></i></a>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle orange">note</i>
                        <span class="title">AspyTheAussie</span>
                        <p>Test warn</p>
                        <a href="#!" class="secondary-content"><i class="fa fa-info-circle"></i></a>
                    </li>
                    <li class="collection-item avatar">
                        <i class="material-icons circle blue">meeting_room</i>
                        <span class="title">AspyTheAussie</span>
                        <p>Test kick</p>
                        <a href="#!" class="secondary-content"><i class="fa fa-info-circle"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col s12 m7" style="width: 20%; vertical-align: top;">
        <div class="card horizontal large" style="width: 100%;">
            <div class="card-content" style="width:100%;">
                <span class="card-title">Player Reports <a href="#!" class="secondary-content">see all</a></span>
                <ul class="collection" id="report-history">
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->

<!-- Ban Hammer -->
<div id="ban_modal" class="modal">
    <div class="modal-content">
        <h4>The Ban Hammer</h4>
        <div class="row">
            <form class="col s12">
                <div class="input-field col s12">
                    <textarea id="ban_reason" class="materialize-textarea"></textarea>
                    <label for="ban_reason">Ban reason</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="ban_notes" class="materialize-textarea"></textarea>
                    <label for="ban_notes">Ban notes</label>
                    <span class="helper-text" data-error="wrong" data-success="right">Not shown to players</span>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-gray btn-flat">Cancel</a>
        <a class="modal-close waves-effect waves-red btn-flat red-text" id="ban_submit">Ban</a>
    </div>
</div>

<!-- The Boot -->
<div id="kick_modal" class="modal">
    <div class="modal-content">
        <h4>The Boot</h4>
        <div class="row">
            <form class="col s12">
                <div class="input-field col s12">
                    <textarea id="kick_reason" class="materialize-textarea"></textarea>
                    <label for="kick_reason">Kick reason</label>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-gray btn-flat">Cancel</a>
        <a class="modal-close waves-effect waves-light-blue btn-flat light-blue-text" id="kick_submit">Kick</a>
    </div>
</div>
<!-- Punishment Viewer -->
<div id="punishment_modal" class="modal">
    <div class="modal-content">
        <h4>Punishment Viewer</h4>
        <div class="row">
            <form class="col s12">
                <div class="input-field col s12">
                    <select id="punishment_type" disabled>
                        <option value="WARN">WARN</option>
                        <option value="MUTE">MUTE</option>
                        <option value="KICK">KICK</option>
                        <option value="BAN">BAN</option>
                    </select>
                    <label>Type</label>
                </div>
                <div class="input-field col s12">
                    <input id="punishment_admin" class="validate" disabled />
                    <label class="active" for="punishment_admin">Staff</label>
                </div>
                <div class="input-field col s12">
                    <input id="punishment_time" class="validate" disabled />
                    <label class="active" for="punishment_time">Time</label>
                </div>
                <div class="input-field col s12">
                    <input id="punishment_duration" class="validate"/>
                    <label class="active" for="punishment_duration">Duration</label>
                </div>
                <div class="input-field col s12">
                    <input id="punishment_reason" class="validate"/>
                    <label class="active" for="punishment_reason">Reason</label>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-gray btn-flat">Cancel</a>
        <a class="modal-close waves-effect waves-red btn-flat red-text" id="delete_punishment">Delete</a>
        <a class="modal-close waves-effect waves-blue btn-flat blue-text" id="update_punishment">Apply</a>
    </div>
</div>
<!-- Silence is key -->
<div id="mute_modal" class="modal">
    <div class="modal-content">
        <h4>Silence is key</h4>
        <div class="row">
            <form class="col s12">
                <div class="input-field col s12">
                    <textarea id="mute_reason" class="materialize-textarea"></textarea>
                    <label for="mute_reason">Mute reason</label>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-gray btn-flat">Cancel</a>
        <a class="modal-close waves-effect waves-blue btn-flat blue-text" id="mute_submit">Mute</a>
    </div>
</div>
<!-- Warn that naughty boy -->
<div id="warn_modal" class="modal">
    <div class="modal-content">
        <h4>Slap on the wrist</h4>
        <div class="row">
            <form class="col s12">
                <div class="input-field col s12">
                    <textarea id="warn_reason" class="materialize-textarea"></textarea>
                    <label for="warn_reason">Warn reason</label>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-gray btn-flat">Cancel</a>
        <a class="modal-close waves-effect waves-orange btn-flat orange-text" id="warn_submit">Warn</a>
    </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="assets/javascript/app.js" type="text/javascript"></script>
<script src="assets/javascript/status.js" onload="init('<?php echo $user->getKey(); ?>',false)"></script>
<script src="assets/javascript/lookup.js" type="text/javascript" onload="init('<?php echo $user->getKey(); ?>');"></script>
</html>