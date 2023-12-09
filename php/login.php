<?php
require _DIR_ . "/vendor/autoload.php"; // Include Composer autoloader

use Predis\Client;

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require _DIR_ . "/database.php";

    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
      
            session_start();
            
                session_regenerate_id();
                
                $_SESSION["user_id"] = $user["id"];
                
                echo json_encode(["redirect" => "profile.html"]);
                exit;
            //Redis setup
            $redis = new Client();
            $sessionKey = 'user_session:' . session_id();

            // Store user data in Redis
            $redis->set($sessionKey, json_encode(["user_id" => $user["id"]]));

            // Set session expiration time (adjust as needed)
            $redis->expire($sessionKey, 3600);

            session_start();

            // Use session_regenerate_id after starting the session
            session_regenerate_id();

            // Store user ID in the session
            $_SESSION["user_id"] = $user["id"];

            echo json_encode(["redirect" => "profile.html"]);
            exit;
        }
    }

    $is_invalid = true;

    echo json_encode(["is_invalid" => $is_invalid]);
}
?>
?>
