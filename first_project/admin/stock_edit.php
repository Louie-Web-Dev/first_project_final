<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $supplier = $_POST['supplier'];
    $department = $_POST['department'];
    $toner_model = $_POST['toner_model'];
    $quantity = (int) $_POST['quantity'];
    $date_added = $_POST['date_added'];

    $sql1 = "UPDATE inventory_transaction 
             SET supplier = ?, department = ?, toner_model = ?, quantity = ?, date_added = ? 
             WHERE id = ?";
    $stmt1 = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt1, "sssisi", $supplier, $department, $toner_model, $quantity, $date_added, $id);

    $sql2 = "UPDATE inventory_in 
             SET supplier = ?, department = ?, toner_model = ?, quantity = ?
             WHERE id = ?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "sssii", $supplier, $department, $toner_model, $quantity, $id);

    if (mysqli_stmt_execute($stmt1) && mysqli_stmt_execute($stmt2)) {
        header("Location: add_stocks.php?edited=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
    mysqli_close($conn);
}
