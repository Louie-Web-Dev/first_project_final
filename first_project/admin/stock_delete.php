<?php
require_once "database.php";

if (isset($_GET['id'], $_GET['supplier'], $_GET['department'], $_GET['toner_model'], $_GET['quantity'])) {
    $id = (int)$_GET['id'];
    $supplier = $_GET['supplier'];
    $department = $_GET['department'];
    $toner_model = $_GET['toner_model'];
    $quantity = (int)$_GET['quantity'];

    $stmt1 = mysqli_prepare($conn, "DELETE FROM inventory_transaction WHERE id = ?");
    mysqli_stmt_bind_param($stmt1, "i", $id);

    $stmt2 = mysqli_prepare(
        $conn,
        "UPDATE inventory_in 
         SET quantity = quantity - ? 
         WHERE supplier = ? AND department = ? AND toner_model = ? 
         ORDER BY id DESC LIMIT 1"
    );
    mysqli_stmt_bind_param($stmt2, "dsss", $quantity, $supplier, $department, $toner_model);

    if (mysqli_stmt_execute($stmt1) && mysqli_stmt_execute($stmt2)) {
        header("Location: add_stocks.php?deleted=1");
        exit();
    } else {
        echo "Error during deletion: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
