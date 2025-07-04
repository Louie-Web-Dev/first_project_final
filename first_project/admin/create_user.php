<?php
session_start();
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: /TSP-system/first_project/login.php");
    exit();
}

require_once "database.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $usertype = $_POST["usertype"];

    // Check if username already exists
    $check_sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($result)) {
        $error = "Username already exists.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insert_sql = "INSERT INTO users (full_name, username, password, usertype) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($stmt, "ssss", $fullName, $username, $hashedPassword, $usertype);

        if (mysqli_stmt_execute($stmt)) {
            $success = "User created successfully!";
        } else {
            $error = "Something went wrong. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toyota</title>
    <?php include 'nav.php'; ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


</head>

<body>

    <div class="Container">
        <div class="displayadd bg-transparent">
            <h1>Add User</h1>
        </div>
        <div class="add-container">
            <div class="form-section">

                <form action="create_user.php" method="post">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usertype" class="form-label">User Type</label>
                        <select name="usertype" class="form-select" required>
                            <option value="" hidden>Select role</option>
                            <option value="admin">Admin</option>
                            <option value="other users">Other Users</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

            </div>
        </div>

    </div>
    <style>
        body {
            background-color: rgb(221, 221, 221);
        }

        .Container {
            display: flex;
            flex-direction: column;
            background-color: white;
            width: 85.5%;
            height: 91%;
            position: fixed;
            right: 10px;
            margin-top: 83px;
            border: 1px black solid;
            border-radius: 15px;
            padding-bottom: 20px;
        }

        .add-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            gap: 20px;
        }

        .displayadd h1 {
            color: #990000;
            font-family: 'Mulish', sans-serif;
            font-size: 25px;
            font-weight: bold;
            text-align: center;
        }

        .form-section {
            width: 40%;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
        }

        .form-section form {
            display: flex;
            flex-direction: column;
        }

        .form-section label {
            margin-top: 10px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .form-section input,
        .form-section select {
            padding: 8px;
            border: 1px solid #999;
            border-radius: 5px;

        }

        .form-section button {
            margin-top: 15px;
            padding: 10px;
            background-color: #990000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .form-section button:hover {
            background-color: #660000;
        }
    </style>
</body>

</html>