<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_id'])) {
    $request_id = (int) $_POST['request_id'];


    $stmt = $conn->prepare("SELECT * FROM inventory_request WHERE id = ?");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $request = $result->fetch_assoc();

    if (!$request) {
        die("Request not found.");
    }

    $supplier = $request['supplier'];
    $department = $request['department'];
    $toner_model = $request['toner_model'];
    $quantity = (int) $request['quantity'];
    $date_added = $request['date_added'];

    $delete_stmt = $conn->prepare("DELETE FROM inventory_request WHERE id = ?");
    $delete_stmt->bind_param("i", $request_id);
    $delete_stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM inventory_out 
                            WHERE supplier = ? AND department = ? AND toner_model = ? AND date_added = ?
                            ORDER BY id DESC");
    $stmt->bind_param("ssss", $supplier, $department, $toner_model, $date_added);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($out = $result->fetch_assoc()) {
        $used_qty = (int) $out['used_quantity'];

        $in_stmt = $conn->prepare("SELECT id, quantity FROM inventory_in 
                                   WHERE supplier = ? AND department = ? AND toner_model = ? 
                                   ORDER BY id ASC LIMIT 1");
        $in_stmt->bind_param("sss", $supplier, $department, $toner_model);
        $in_stmt->execute();
        $in_result = $in_stmt->get_result();
        $in_row = $in_result->fetch_assoc();

        if ($in_row) {
            $new_qty = $in_row['quantity'] + $used_qty;

            $update_in = $conn->prepare("UPDATE inventory_in SET quantity = ? WHERE id = ?");
            $update_in->bind_param("ii", $new_qty, $in_row['id']);
            $update_in->execute();
        }

        $delete_out = $conn->prepare("DELETE FROM inventory_out WHERE id = ?");
        $delete_out->bind_param("i", $out['id']);
        $delete_out->execute();


        $quantity -= $used_qty;
        if ($quantity <= 0) break;
    }

    header("Location: request.php");
    exit();
} else {
    echo "Invalid request.";
}
