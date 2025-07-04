<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["usertype"])) {
    switch ($_SESSION["usertype"]) {
        case "admin":
            header("Location: /TSP-system/first_project/admin/dashboard.php");
            break;
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toyota</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    <link rel="shortcut icon" type="x-icon" href="images/logo2.png">

</head>

<body>
    <div class="custom-container">
        <div class="cont-2">
            <img src="images/logo1.png" id="logo2" height="100px" width="200px">
            <h1>Toyota Toner<br>Inventory System</h1>

            <form action="login.php" method="post">
                <div class="form-group">
                    <input type="username" placeholder="Enter username:" name="username" class="form-control" required autocomplete="off">
                    <div class="icon">
                        <i class="fa-solid fa-user bg-transparent"></i>
                    </div>
                </div>
                <div class="form-group ">
                    <input type="password" placeholder="Enter Password:" name="password" class="form-control" required autocomplete="off">
                    <div class="icon2">
                        <i class="fa-solid fa-lock bg-transparent"></i>
                    </div>
                </div>

                <?php
                if (isset($_POST["login"])) {
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    require_once "database.php";

                    $sql = "SELECT * FROM users WHERE username = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    if ($user) {

                        if (password_verify($password, $user["password"])) {
                            $_SESSION["user"] = "yes";
                            $_SESSION["username"] = $user["username"];
                            $_SESSION["usertype"] = $user["usertype"];
                            $_SESSION["fullName"] = $user["full_name"];

                            switch ($_SESSION["usertype"]) {
                                case "admin":
                                    header("Location: /TSP-system/first_project/admin/dashboard.php");
                                    exit();
                                case "other users":
                                    header("Location: /TSP-system/first_project/admin/dashboard.php");
                                    exit();
                            }
                        } else {
                            $_SESSION["error_message"] = "Password does not match";
                        }
                    } else {
                        $_SESSION["error_message"] = "username does not match";
                    }

                    header("Location: login.php");
                    exit();
                }

                ?>

                <div class="form-btn">
                    <input type="submit" value="Login" name="login" class="btn btn-primary">
                </div>


            </form>

            <div>
                <p>Don't have an account? <a href="#">Contact Admin</a></p>
            </div>

        </div>
</body>




</html>