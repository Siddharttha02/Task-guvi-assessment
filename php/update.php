<?php
session_start();

$mysqli = require __DIR__ . "/database.php";

$is_updated = false;
$user = [];

if (isset($_SESSION["user_id"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $dob = $_POST["dob"];
        $address = $_POST["address"];

        $update_query = $mysqli->prepare("UPDATE users SET name=?, email=?, phone=?, dob=?, address=? WHERE id=?");

        $update_query->bind_param("ssissi", $name, $email, $phone, $dob, $address, $_SESSION["user_id"]);
        if ($update_query->execute()) {
            $is_updated = true;
        } else {
            echo "Error updating record: " . $mysqli->error;
        }

        $update_query->close();
    }

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
    
    echo json_encode(["user" => $user, "is_updated" => $is_updated]);
}
?>
