<?php

require_once __DIR__ . '../vendor/autoload.php';
// use MongoDB\Client;

if (empty($_POST["name"])) {
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (!preg_match("/[a-z]/i", $_POST["password_confirmation"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["phone"])) {
    die("Password must contain at least one number");
}
if (empty($_POST["dateofbirth"])) {
    die("Date of birth is required");
}
if (empty($_POST["address"])) {
    die("Address is required");
}

$password_hash = password_hash($_POST["password_confirmation"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

// MySQL insertion code
$sql = "INSERT INTO users (name, email, password_hash, phone, dob, address)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "sssiss",
    $_POST["name"],
    $_POST["email"],
    $password_hash,
    $_POST["phone"],
    $_POST["dateofbirth"],
    $_POST["address"]
);

if (!$stmt->execute()) {
    if ($stmt->errno === 1062) {
        $error_message = "Email already taken";
        echo $error_message;
    } else {
        die("Error: " . $stmt->error . " " . $stmt->errno);
    }
}

// MongoDB insertion code
try {
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $mongoDb = $mongoClient->selectDatabase("guvi");
    $profilesCollection = $mongoDb->selectCollection("auth");

    $document = [
        "name" => $_POST["name"],
        "email" => $_POST["email"],
        "phone" => $_POST["phone"],
        "dob" => $_POST["dateofbirth"],
        "address" => $_POST["address"],
    ];

    $profilesCollection->insertOne($document);
} catch (Exception $e) {
    die("MongoDB error: " . $e->getMessage());
}

header("Location: ../login.html");
exit;

?>