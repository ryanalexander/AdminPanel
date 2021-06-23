<?php
require_once("config.inc.php");
@SESSION_START();
$user = null;

if(isset($_SESSION['id'])&&$_SESSION['id']!==""){
    // Login data exists
    $user=new User($_SESSION['username'],$_SESSION['uuid'],$_SESSION['role'],$_SESSION['key']);
}else {
    // User is not logged in
    header("Location: ./login.php");
}

class User {
    private static $username = "";
    private static $uuid = "";
    private static $role = "";
    private static $key = "";

    function __construct($user, $uuid, $role, $key) {
        self::$username = $user;
        self::$uuid = $uuid;
        self::$role = $role;
        self::$key = $key;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return self::$username;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return self::$role;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return self::$uuid;
    }

    /**
     * @return string
     */
    public static function getKey()
    {
        return self::$key;
    }

    public static function changePassword($password) {
        // Connect to database
        $conn = mysqli_connect(Config::$db_host,Config::$db_user,Config::$db_pass,Config::$db_database);

        // Parse username & password to prevent SQL injection
        $password = $conn->real_escape_string($password);

        // Build & execute query
        mysqli_query($conn,"UPDATE `staff_accounts` SET `password`='".$password."' WHERE `uuid`='".self::$uuid."' LIMIT 1;");
    }
}

?>