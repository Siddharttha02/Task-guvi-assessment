<?php
session_start();

$mysqli = require __DIR__ . "/database.php";

$is_updated = false;

if (isset($_SESSION["user_id"])) {
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $address = $_POST["address"];
    
    $update_query = $mysqli->prepare("UPDATE user SET name=?, email=?, phone=?, dob=?, address=? WHERE id=?");
    
    $update_query->bind_param("ssissi", $name, $email, $phone, $dob, $address, $_SESSION["user_id"]);
    
    if ($update_query->execute()) {
        $is_updated = true;
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
    
    $update_query->close();
}
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Details</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/profile.css">
</head>
<body>
    <div class="custom-container container">
        <h1 class="text-center">Update Details</h1>
        
        <?php if (isset($user)): ?>
            <?php if ($is_updated): ?>
                <p class="alert alert-success">Information updated successfully!</p>
            <?php endif; ?>
            
            <div class="flex-container">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="number" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user["phone"]) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="<?= htmlspecialchars($user["dob"]) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user["address"]) ?>" required>
                </div>
                <div class="mb-3 d-flex flex-row justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <p><a href="profile.php" class="btn btn-primary">Go to the profile page</a></p>
                </div>
            </form>
            </div>
            
        <?php else: ?>
            
            <div class="flex-container d-flex justify-content-center flex-row">
                <p><a href="index.php" class="btn btn-primary">Log in</a></p>
                <p> or </p>
                <p><a href="../register.html" class="btn btn-secondary">Sign up</a></p>
            </div>
            
        <?php endif; ?>
    </div>
</body>
</html>