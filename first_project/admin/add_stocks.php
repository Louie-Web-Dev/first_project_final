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
            <h1>ADD STOCKS</h1>
        </div>
        <div class="add-container">
            <div class="form-section">
                <form action="add.php" method="post">
                    <label for="supplier">Supplier:</label>
                    <select name="supplier" id="supplier" required>
                        <option value="" disabled selected hidden>Select Supplier</option>
                        <option value="INKRITE">INKRITE</option>
                        <option value="ERBM">ERBM</option>
                        <option value="CANON">CANON</option>
                    </select>

                    <label for="department">Department:</label>
                    <select name="department" id="department" required>
                        <option value="" disabled selected hidden>Select Department</option>
                        <option value="Admin">Admin</option>
                        <option value="Finance and Accounting">Finance and Accounting</option>
                        <option value="Parts Counter">Parts Counter</option>
                        <option value="Parts Warehouse">Parts Warehouse</option>
                        <option value="Sales (Financing)">Sales (Financing)</option>
                        <option value="Sales (MP)">Sales (MP)</option>
                        <option value="Sales Admin">Sales Admin</option>
                        <option value="Sales Training">Sales Training</option>
                        <option value="Service">Service</option>
                        <option value="Tool Room">Tool Room</option>
                        <option value="Tsure">Tsure</option>

                    </select>

                    <label for="toner_model">Toner Model:</label>
                    <select name="toner_model" id="toner_model" required>
                        <option value="" disabled selected hidden>Select Toner Model</option>
                        <option value="CF226X">CF226X</option>
                        <option value="CC388X">CC388X</option>
                        <option value="NPG90">NPG90</option>
                        <option value="CEXVM">CEXVM</option>
                        <option value="CEXVC">CEXVC</option>
                        <option value="CEXVBK">CEXVBK</option>
                        <option value="CEXVBC">CEXVBC</option>
                    </select>

                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" min="1" required>

                    <label for="date_added">Date:</label>
                    <input type="date" name="date_added" id="date_added" required>

                    <button type="submit">Add</button>
                </form>
            </div>

            <div class="table-section">
                <table>
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Department</th>
                            <th>Toner Model</th>
                            <th>Quantity</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once "database.php";
                        $sql = "SELECT * FROM inventory_transaction ORDER BY id DESC LIMIT 10";
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
                                    <td>
                                        <a href="javascript:void(0);"
                                            onclick="openEditModal(
                                                '<?php echo $row['id']; ?>',
                                                '<?php echo htmlspecialchars($row['supplier'], ENT_QUOTES); ?>',
                                                '<?php echo htmlspecialchars($row['department'], ENT_QUOTES); ?>',
                                                '<?php echo htmlspecialchars($row['toner_model'], ENT_QUOTES); ?>',
                                                '<?php echo $row['quantity']; ?>',
                                                '<?php echo $row['date_added']; ?>'
                                            )">
                                            <i class="fa-solid fa-pen-to-square" style="color: blue"></i>
                                        </a>


                                        <a href="stock_delete.php?id=<?php echo $row['id']; ?>&supplier=<?php echo urlencode($row['supplier']); ?>&department=<?php echo urlencode($row['department']); ?>&toner_model=<?php echo urlencode($row['toner_model']); ?>&quantity=<?php echo $row['quantity']; ?>"
                                            onclick="return confirm('Are you sure you want to delete this record?');">
                                            <i class="fa-solid fa-trash" style="color: red"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php endwhile;
                        else: ?>
                            <tr>
                                <td colspan="6">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div id="editModal" class="modal" style="display:none; position:fixed; z-index:1000; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6);">
        <div class="modal-content" style="background:white; padding:20px; margin:5% auto; width:400px; border-radius:8px; position:relative;">
            <span onclick="document.getElementById('editModal').style.display='none'"
                style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:20px;">&times;</span>
            <h3>Edit Stock</h3>
            <form id="editForm" action="stock_edit.php" method="post">
                <input type="hidden" name="id" id="edit-id">

                <label for="edit-supplier">Supplier:</label>
                <select name="supplier" id="edit-supplier" required>
                    <option value="INKRITE">INKRITE</option>
                    <option value="ERBM">ERBM</option>
                    <option value="CANON">CANON</option>
                </select><br>

                <label for="edit-department">Department:</label>
                <select name="department" id="edit-department" required>
                    <option value="Admin">Admin</option>
                    <option value="Finance and Accounting">Finance and Accounting</option>
                    <option value="Parts Counter">Parts Counter</option>
                    <option value="Parts Warehouse">Parts Warehouse</option>
                    <option value="Sales (Financing)">Sales (Financing)</option>
                    <option value="Sales (MP)">Sales (MP)</option>
                    <option value="Sales Admin">Sales Admin</option>
                    <option value="Sales Training">Sales Training</option>
                    <option value="Service">Service</option>
                    <option value="Tool Room">Tool Room</option>
                    <option value="Tsure">Tsure</option>
                </select><br>

                <label for="edit-toner_model">Toner Model:</label>
                <select name="toner_model" id="edit-toner_model" required>
                    <option value="CF226X">CF226X</option>
                    <option value="CC388X">CC388X</option>
                    <option value="NPG90">NPG90</option>
                    <option value="CEXVM">CEXVM</option>
                    <option value="CEXVC">CEXVC</option>
                    <option value="CEXVBK">CEXVBK</option>
                    <option value="CEXVBC">CEXVBC</option>
                </select><br>

                <label for="edit-quantity">Quantity:</label>
                <input type="number" name="quantity" id="edit-quantity" min="1" required><br>

                <label for="edit-date_added">Date:</label>
                <input type="date" name="date_added" id="edit-date_added" required><br><br>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, supplier, department, toner_model, quantity, date_added) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-supplier').value = supplier;
            document.getElementById('edit-department').value = department;
            document.getElementById('edit-toner_model').value = toner_model;
            document.getElementById('edit-quantity').value = quantity;
            document.getElementById('edit-date_added').value = date_added;
            document.getElementById('editModal').style.display = 'block';
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

        .table-section {
            width: 60%;
            overflow-x: auto;
        }

        .table-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-section th,
        .table-section td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .table-section th {
            background-color: #990000;
            color: white;
        }
    </style>


</body>

</html>