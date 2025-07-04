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
    <?php if (isset($_GET['error'])): ?>
        <div id="customModal" class="custom-modal">
            <div class="custom-modal-content">
                <div class="custom-modal-header">
                    <h2 class="custom-modal-title">Error</h2>
                    <span class="custom-modal-close" onclick="closeModal()">&times;</span>
                </div>
                <div class="custom-modal-body">
                    <p><?php echo htmlspecialchars($_GET['error']); ?></p>
                </div>
            </div>
        </div>
        <script>
            function closeModal() {
                document.getElementById("customModal").style.display = "none";
            }
            window.onload = function() {
                document.getElementById("customModal").style.display = "block";
            };
        </script>
    <?php endif; ?>


    <div class="Container">
        <div class="displayadd bg-transparent">
            <h1>Toner Request</h1>
        </div>

        <div class="add-container">
            <div class="form-section">
                <form action="request_add.php" method="post">
                    <label for="fn-input">Full Name:</label>
                    <input type="text" placeholder="First Name Last Name" name="full_name">

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

                    <select name="toner_model[]" required>
                        <option value="" disabled selected hidden>Select Toner Model</option>
                        <option value="CF226X">CF226X</option>
                        <option value="CC388X">CC388X</option>

                        <option value="NPG90">NPG90</option>
                        <option value="CEXVM">CEXVM</option>
                        <option value="CEXVC">CEXVC</option>
                        <option value="CEXVBK">CEXVBK</option>
                        <option value="CEXVY">CEXVY</option>
                    </select>

                    <select name="toner_model[]">
                        <option value="" disabled selected hidden>Select Toner Model</option>
                        <option value="CF226X">CF226X</option>
                        <option value="CC388X">CC388X</option>
                        <option value="NPG90">NPG90</option>
                        <option value="CEXVM">CEXVM</option>
                        <option value="CEXVC">CEXVC</option>
                        <option value="CEXVBK">CEXVBK</option>
                        <option value="CEXVY">CEXVY</option>
                    </select>

                    <select name="toner_model[]">
                        <option value="" disabled selected hidden>Select Toner Model</option>
                        <option value="CF226X">CF226X</option>
                        <option value="CC388X">CC388X</option>
                        <option value="NPG90">NPG90</option>
                        <option value="CEXVM">CEXVM</option>
                        <option value="CEXVC">CEXVC</option>
                        <option value="CEXVBK">CEXVBK</option>
                        <option value="CEXVBC">CEXVBC</option>
                    </select>

                    <select name="toner_model[]">
                        <option value="" disabled selected hidden>Select Toner Model</option>
                        <option value="CF226X">CF226X</option>
                        <option value="CC388X">CC388X</option>
                        <option value="NPG90">NPG90</option>
                        <option value="CEXVM">CEXVM</option>
                        <option value="CEXVC">CEXVC</option>
                        <option value="CEXVBK">CEXVBK</option>
                        <option value="CEXVBC">CEXVBC</option>
                    </select>

                    <label for="quantity">quantity:</label>
                    <input type="number" name="quantity" id="quantity" min="1" required>

                    <label for="date_added">Date:</label>
                    <input type="date" name="date_added" id="date_added" required>

                    <button type="submit">Request</button>
                </form>
            </div>

            <div class="table-section">
                <table>
                    <thead>
                        <tr>
                            <th>Full Name</th>
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
                        $sql = "SELECT * FROM inventory_request ORDER BY id DESC LIMIT 12";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0):
                            while ($row = mysqli_fetch_assoc($result)):
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['supplier']); ?></td>
                                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                                    <td><?php echo htmlspecialchars($row['toner_model']); ?></td>
                                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                                    <td>
                                        <form action="request_delete.php" method="post" onsubmit="return confirm('Are you sure you want to undo this request?');">
                                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" style="color: Blue;"><i class="fa-solid fa-rotate-left" style="color: Blue;"></i></button>
                                        </form>
                                    </td>

                                </tr>
                            <?php endwhile;
                        else: ?>
                            <tr>
                                <td colspan="7">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <style>
        .custom-modal {
            display: none;
            /* show via JS */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .custom-modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
        }

        .custom-modal-header {
            padding: 10px 20px;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-modal-title {
            margin: 0;
            font-size: 18px;
        }

        .custom-modal-close {
            font-size: 22px;
            font-weight: bold;
            color: #555;
            cursor: pointer;
        }

        .custom-modal-close:hover {
            color: #000;
        }

        .custom-modal-body {
            padding: 20px;
            font-size: 16px;
        }


        body {
            background-color: rgb(221, 221, 221);
        }

        .Container {
            display: flex;
            flex-direction: column;
            background-color: white;
            width: 85.5%;
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
            overflow-y: auto;
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