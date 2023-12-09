<?php
session_start();

$response = [];

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        $response = [
            "user" => $user,
            "isLoggedIn" => true
        ];
    }
}

echo json_encode($response);
?>
