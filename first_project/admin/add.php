

<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $supplier = $_POST["supplier"];
    $department = $_POST["department"];
    $toner_model = $_POST["toner_model"];
    $quantity = $_POST["quantity"];
    $date_added = $_POST["date_added"];

    $sql1 = "INSERT INTO inventory_transaction (supplier, department, toner_model, quantity, date_added) 
             VALUES (?, ?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt1, "sssds", $supplier, $department, $toner_model, $quantity, $date_added);

    $sql2 = "INSERT INTO inventory_in (supplier, department, toner_model, quantity) 
             VALUES (?, ?, ?, ?)";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "sssd", $supplier, $department, $toner_model, $quantity);

    if (mysqli_stmt_execute($stmt1) && mysqli_stmt_execute($stmt2)) {
        header("Location: add_stocks.php?success=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
    mysqli_close($conn);
}
