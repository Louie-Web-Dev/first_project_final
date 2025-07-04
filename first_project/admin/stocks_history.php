<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: /TSP-system/first_project/login.php");
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
            <h1>Stock History Added</h1>

            <form method="get" style="margin: 20px 0; display: flex; gap: 10px; flex-wrap: wrap;">

                <select name="supplier">
                    <option value="" disabled hidden <?php if (empty($_GET['supplier'])) echo 'selected'; ?>>Select Supplier</option>
                    <?php
                    $supplier = ["INKRITE", "ERBM", "CANON"];
                    foreach ($supplier as $sup) {
                        $selected = ($_GET['supplier'] ?? '') === $sup ? 'selected' : '';
                        echo "<option value=\"$sup\" $selected>$sup</option>";
                    }
                    ?>
                </select>

                <select name="department">
                    <option value="" disabled hidden <?php if (empty($_GET['department'])) echo 'selected'; ?>>Select Department</option>
                    <?php
                    $departments = [
                        "Admin",
                        "Finance and Accounting",
                        "Parts Counter",
                        "Parts Warehouse",
                        "Sales (Financing)",
                        "Sales (MP)",
                        "Sales Admin",
                        "Sales Training",
                        "Service",
                        "Tool Room",
                        "Tsure"
                    ];
                    foreach ($departments as $dep) {
                        $selected = ($_GET['department'] ?? '') === $dep ? 'selected' : '';
                        echo "<option value=\"$dep\" $selected>$dep</option>";
                    }
                    ?>
                </select>

                <select name="toner_model">
                    <option value="" disabled hidden <?php if (empty($_GET['toner_model'])) echo 'selected'; ?>>Select Toner Model</option>
                    <?php
                    $toner_models = ["CF2266X", "CC388X", "CF226X", "NPG90", "CEXVM", "CEXVC", "CEXVBK", "CEXVBC"];
                    foreach ($toner_models as $model) {
                        $selected = ($_GET['toner_model'] ?? '') === $model ? 'selected' : '';
                        echo "<option value=\"$model\" $selected>$model</option>";
                    }
                    ?>
                </select>

                <input type="number" name="quantity" placeholder="Quantity" value="<?php echo htmlspecialchars($_GET['quantity'] ?? ''); ?>">
                <label for="date_from">From</label>
                <input type="date" id="date_from" name="date_from" value="<?php echo htmlspecialchars($_GET['date_from'] ?? ''); ?>">

                <label for="date_to">To</label>
                <input type="date" id="date_to" name="date_to" value="<?php echo htmlspecialchars($_GET['date_to'] ?? ''); ?>">

                <button type="submit">Filter</button>

                <a href="stocks_history.php" style="text-decoration: none;">
                    <button type="button">Reset</button>
                </a>

                <button type="button" onclick="printTable()">Print</button>
            </form>


        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Department</th>
                        <th>Toner Model</th>
                        <th>Quantity</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    require_once "database.php";

                    $supplier = $_GET['supplier'] ?? '';
                    $department = $_GET['department'] ?? '';
                    $toner_model = $_GET['toner_model'] ?? '';
                    $quantity = $_GET['quantity'] ?? '';
                    $date_from = $_GET['date_from'] ?? '';
                    $date_to = $_GET['date_to'] ?? '';

                    $where = [];

                    if (!empty($supplier)) {
                        $where[] = "supplier = '" . mysqli_real_escape_string($conn, $supplier) . "'";
                    }

                    if (!empty($department)) {
                        $where[] = "department = '" . mysqli_real_escape_string($conn, $department) . "'";
                    }

                    if (!empty($toner_model)) {
                        $where[] = "toner_model = '" . mysqli_real_escape_string($conn, $toner_model) . "'";
                    }

                    if (!empty($quantity)) {
                        $where[] = "quantity = '" . mysqli_real_escape_string($conn, $quantity) . "'";
                    }

                    if (!empty($date_from) && !empty($date_to)) {
                        $from = mysqli_real_escape_string($conn, $date_from);
                        $to = mysqli_real_escape_string($conn, $date_to);
                        $where[] = "DATE(date_added) BETWEEN '$from' AND '$to'";
                    } elseif (!empty($date_from)) {
                        $from = mysqli_real_escape_string($conn, $date_from);
                        $where[] = "DATE(date_added) >= '$from'";
                    } elseif (!empty($date_to)) {
                        $to = mysqli_real_escape_string($conn, $date_to);
                        $where[] = "DATE(date_added) <= '$to'";
                    }

                    $whereClause = '';
                    if (!empty($where)) {
                        $whereClause = 'WHERE ' . implode(' AND ', $where);
                    }

                    $sql = "SELECT * FROM inventory_transaction $whereClause ORDER BY id DESC";

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0):
                        while ($row = mysqli_fetch_assoc($result)):
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['supplier']); ?></td>
                                <td><?php echo htmlspecialchars($row['department']); ?></td>
                                <td><?php echo htmlspecialchars($row['toner_model']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="5">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function printTable() {
            const tableContent = document.querySelector('.table-wrapper').innerHTML;

            const printWindow = window.open('', '', 'width=1000,height=700');
            printWindow.document.write(`
                <html>
                <head>
                    <title>History Report</title>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            font-family: Arial, sans-serif;
                        }
                        th, td {
                            border: 1px solid #ccc;
                            padding: 10px;
                            text-align: left;
                        }
                        th {
                            color: black;
                        }
                        h1 {
                            text-align: center;
                            font-family: 'Mulish', sans-serif;
                            font-size: 20px;
                        }
                    </style>
                </head>
                <body>
                    <h1>Toner Added Report</h1>
                    ${tableContent}
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>

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

        .table-wrapper {
            overflow-y: auto;
            max-height: 90%;
            display: flex;
            justify-content: center;

        }


        table {
            width: 90%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            border-radius: 15px;

        }

        thead th {
            position: sticky;
            top: 0;
            background-color: rgb(173, 54, 54);
            color: white;
            z-index: 2;
        }


        th,
        td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: rgb(173, 54, 54);
            color: white;
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

        /* Reset button inside anchor */
        form a button {
            background-color: #888;
        }

        form a button:hover {
            background-color: #666;
        }
    </style>


</body>

</html>