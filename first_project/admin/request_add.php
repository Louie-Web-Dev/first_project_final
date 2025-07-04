<?php
require_once "database.php";

$name = $_POST['full_name'];
$supplier = $_POST['supplier'];
$department = $_POST['department'];
$requested_quantity = (int) $_POST['quantity'];
$date_added = $_POST['date_added'];
$toner_models = $_POST['toner_model'];

foreach ($toner_models as $model) {
    if (!empty($model)) {
        $remaining_qty = $requested_quantity;

        $check_sql = "SELECT id, quantity FROM inventory_in 
                      WHERE supplier = ? AND department = ? AND toner_model = ? 
                      ORDER BY id ASC";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("sss", $supplier, $department, $model);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        $fulfilled = false;

        while ($row = $result->fetch_assoc()) {
            $inventory_id = $row['id'];
            $available_qty = (int)$row['quantity'];

            if ($available_qty <= 0) continue;

            if ($available_qty >= $remaining_qty) {
                $deduct_qty = $remaining_qty;
                $new_qty = $available_qty - $deduct_qty;

                $update_sql = "UPDATE inventory_in SET quantity = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ii", $new_qty, $inventory_id);
                $update_stmt->execute();

                $log_sql = "INSERT INTO inventory_out (supplier, department, toner_model, used_quantity, date_added)
                            VALUES (?, ?, ?, ?, ?)";
                $log_stmt = $conn->prepare($log_sql);
                $log_stmt->bind_param("sssis", $supplier, $department, $model, $deduct_qty, $date_added);
                $log_stmt->execute();


                $fulfilled = true;
                break;
            } else {
                $deduct_qty = $available_qty;
                $remaining_qty -= $deduct_qty;
                $new_qty = 0;

                $update_sql = "UPDATE inventory_in SET quantity = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ii", $new_qty, $inventory_id);
                $update_stmt->execute();

                $log_sql = "INSERT INTO inventory_out (supplier, department, toner_model, used_quantity, date_added)
                            VALUES (?, ?, ?, ?, ?)";
                $log_stmt = $conn->prepare($log_sql);
                $log_stmt->bind_param("sssis", $supplier, $department, $model, $deduct_qty, $date_added);
                $log_stmt->execute();
            }
        }

        if ($fulfilled || $remaining_qty === 0) {

            $insert_sql = "INSERT INTO inventory_request (full_name, supplier, department, toner_model, quantity, date_added)
                           VALUES (?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ssssis", $name, $supplier, $department, $model, $requested_quantity, $date_added);
            $insert_stmt->execute();
        } else {
            $error = urlencode("Not enough total stock for: " . $supplier . " - " . $model);
            header("Location: request.php?error=$error");
            exit();
        }
    }
}

header("Location: request.php");
exit();
