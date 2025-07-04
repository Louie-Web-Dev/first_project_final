<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: /TSP-System/first_project/");
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
    <?php include 'nav.php'; ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

</head>

<body>
    <div class="Container">
        <div class="displayadd bg-transparent">
            <h1>Sales (Financing) Toner Stock</h1>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Toner Model</th>
                        <th>Available</th>
                        <th>Used</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    require_once "database.php";

                    $supplier = $_GET['supplier'] ?? '';
                    $toner_model = $_GET['toner_model'] ?? '';

                    $where = [];
                    $where[] = "inventory_in.department = 'Sales (Financing)'";

                    if (!empty($supplier)) {
                        $where[] = "inventory_in.supplier = '" . mysqli_real_escape_string($conn, $supplier) . "'";
                    }

                    if (!empty($toner_model)) {
                        $where[] = "inventory_in.toner_model = '" . mysqli_real_escape_string($conn, $toner_model) . "'";
                    }

                    $whereClause = '';
                    if (!empty($where)) {
                        $whereClause = 'WHERE ' . implode(' AND ', $where);
                    }

                    $sql = "SELECT 
                            i.supplier, 
                            i.toner_model, 
                            SUM(i.quantity) AS total_quantity,
                            COALESCE(u.used_quantity, 0) AS used_quantity
                        FROM inventory_in i
                        LEFT JOIN (
                            SELECT supplier, toner_model, SUM(used_quantity) AS used_quantity
                            FROM inventory_out
                            WHERE department = 'Sales (Financing)'
                            GROUP BY supplier, toner_model
                        ) u
                        ON i.supplier = u.supplier AND i.toner_model = u.toner_model
                        WHERE i.department = 'Sales (Financing)'";

                    if (!empty($supplier)) {
                        $sql .= " AND i.supplier = '" . mysqli_real_escape_string($conn, $supplier) . "'";
                    }

                    if (!empty($toner_model)) {
                        $sql .= " AND i.toner_model = '" . mysqli_real_escape_string($conn, $toner_model) . "'";
                    }

                    $sql .= " GROUP BY i.supplier, i.toner_model
                        ORDER BY i.supplier, i.toner_model";



                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0):
                        while ($row = mysqli_fetch_assoc($result)):
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['supplier']); ?></td>
                                <td><?php echo htmlspecialchars($row['toner_model']); ?></td>
                                <td><?php echo htmlspecialchars($row['total_quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['used_quantity']); ?></td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="4">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>



        <div class="between">
            <h1>OUT</h1>
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
                overflow: auto;
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

            .table-wrapper {
                max-height: 100%;
                display: flex;
                justify-content: center;
            }

            table {
                margin-top: 40px;
                width: 95%;
                height: 90%;
                border-collapse: collapse;
                font-family: Arial, sans-serif;
                border-radius: 15px;

            }

            td {
                font-weight: bold;

                font-size: 20px;

                padding: 60px;
            }

            th,
            td {
                border: 1px solid #ccc;
                text-align: center;
            }

            th {
                background-color: rgb(173, 54, 54);
                color: white;
                padding: 15px;
                font-size: 30px;
            }

            form {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
                justify-content: center;
                align-items: center;
                margin: 20px auto;
                background-color: rgb(255, 255, 255);
                border-radius: 10px;
                width: 100%;
            }

            form select,
            form input[type="number"],
            form input[type="date"] {
                padding: 10px;
                font-size: 14px;
                border-radius: 6px;
                border: 1px solid #aaa;
                min-width: 160px;
            }

            form button {
                padding: 10px 18px;
                font-size: 14px;
                background-color: #990000;
                color: white;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            form button:hover {
                background-color: #b30000;
            }

            form a button {
                background-color: #888;
            }

            form a button:hover {
                background-color: #666;
            }
        </style>


</body>

</html>