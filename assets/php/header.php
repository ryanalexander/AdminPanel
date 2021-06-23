<nav>
    <div class="nav-wrapper orange lighten-1 ">
        <a href="#" class="brand-logo" style="margin-left:.5em;">Monarch</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li id="critical_offline" style="display:none;"><a href="./status.php" class="btn-floating tooltipped btn red pulse" data-position="middle" data-tooltip="Critical service offline.<br/><br/>Click for status page!"><span class="material-icons">warning</span></a></li>
            <li><a href="./index.php"><i class="material-icons left">home</i> Home</a></li>
            <li><a class="dropdown-trigger" href="#!" data-target="staff-dropdown">Staff Tools <i class="material-icons right">arrow_drop_down</i></a></li>
            <?php
            if($user->getRole() === "Manager" || $user->getRole() === "Owner"){
            ?>
            <li><a class="dropdown-trigger" href="#!" data-target="management-dropdown">Management Tools <i class="material-icons right">arrow_drop_down</i></a></li>
            <?php
            }
            ?>
            <li><a href="./status.php"><i class="material-icons left">signal_cellular_connected_no_internet_4_bar</i> Status</a></li>
            <li><a class="dropdown-trigger" href="#!" data-target="user-dropdown"><?php echo $user->getUsername(); ?> <i class="material-icons right">arrow_drop_down</i></a></li>
        </ul>
    </div>
</nav>
<!-- Header User card -->
<ul id="user-dropdown" class="dropdown-content">
    <li><a href="profile.php" class="orange-text">Profile</a></li>
    <li class="divider" class="orange-text"></li>
    <li><a href="logout.html" class="orange-text">Logout</a></li>
</ul>
<!-- Staff tab -->
<ul id="staff-dropdown" class="dropdown-content">
    <li><a href="./lookup.php" class="orange-text"><i class="material-icons left">search</i> Player Lookup</a></li>
    <li><a href="./reports.php" class="orange-text"><i class="material-icons left">flag</i> Player Reports</a></li>
    <li><a href="./logs.php" class="orange-text"><i class="material-icons left">receipt_long</i> Chat Logs</a></li>
</ul>
<!-- Management tab -->
<?php
if($user->getRole() === "Manager" || $user->getRole() === "Owner"){
?>
<ul id="management-dropdown" class="dropdown-content">
    <li><a href="manage.php" class="orange-text">User Management</a></li>
    <li><a href="" class="orange-text"><i class="material-icons left">code</i> Server Console</a></li>
    <li><a href="./audit_log.php" class="orange-text"><i class="material-icons left">history_edu</i> Audit Log</a></li>
</ul>
<?php
}
?>

<ul class="sidenav">
    <li><div class="user-view">
            <div class="background">
                <img src="images/office.jpg">
            </div>
            <a href="#user"><img class="circle" src="images/yuna.jpg"></a>
            <a href="#name"><span class="white-text name">John Doe</span></a>
            <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a>
        </div></li>
    <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
    <li><a href="#!">Second Link</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Subheader</a></li>
    <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
</ul>

