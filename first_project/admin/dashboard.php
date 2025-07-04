<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: /TSP-System/first_project/");
    exit();
}

require_once "database.php";
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
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div class="dashboardContainer">
        <div class="displayCount bg-transparent">
            <h1>Count of Available Toners</h1>

            <div class="grid-container">

                <!-- ----admin--- -->

                <?php
                $whereClause = "WHERE department = 'admin'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity 
                        FROM inventory_in 
                        $whereClause 
                        GROUP BY supplier, toner_model 
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="admin_list.php" class="item-1 <?php echo $bgClass; ?>">
                    <strong>Admin</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>



                <!-- -----Financing and Accounting----- -->

                <?php
                $whereClause = "WHERE department = 'Finance and Accounting'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity 
                        FROM inventory_in 
                        $whereClause 
                        GROUP BY supplier, toner_model 
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="finance_acc.php" class="item-3 <?php echo $bgClass; ?>">
                    <strong>Finance & Acc</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>


                <!-- Parts Counter -->


                <?php
                $whereClause = "WHERE department = 'Parts Counter'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity 
                        FROM inventory_in 
                        $whereClause 
                        GROUP BY supplier, toner_model 
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="parts_counter.php" class="item-4 <?php echo $bgClass; ?>">
                    <strong>Parts Counter</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>

                <!-- -----parts warehouse----- -->

                <?php
                $whereClause = "WHERE department = 'Parts Warehouse'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity 
                        FROM inventory_in 
                        $whereClause 
                        GROUP BY supplier, toner_model 
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="parts_warehouse.php" class="item-11 <?php echo $bgClass; ?>">
                    <strong>Parts Warehouse</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>




                <!-- --- ----Sales (Financing)--- -->

                <?php
                $whereClause = "WHERE department = 'Sales (Financing)'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity 
                        FROM inventory_in 
                        $whereClause 
                        GROUP BY supplier, toner_model 
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="sales_financing.php" class="item-2 <?php echo $bgClass; ?>">
                    <strong>Sales (Financing)</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>


                <!--sales MP-->

                <?php
                $whereClause = "WHERE department = 'Sales (MP)'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity 
                        FROM inventory_in 
                        $whereClause 
                        GROUP BY supplier, toner_model 
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="sales_mp.php" class="item-5 <?php echo $bgClass; ?>">
                    <strong>Sales (MP)</strong>
                    <div class="toner-list">
                        <?php if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>




                <!-- -----sales admin-----  -->
                <?php
                $whereClause = "WHERE department = 'Sales Admin'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity
                        FROM inventory_in
                        $whereClause
                        GROUP BY supplier, toner_model
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="sales_admin.php" class="item-6 <?php echo $bgClass; ?>">
                    <strong>Sales Admin</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>


                    </div>
                </a>

                <!-- ----sales training--- -->

                <?php
                $whereClause = "WHERE department = 'Sales Training'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity
                        FROM inventory_in
                        $whereClause
                        GROUP BY supplier, toner_model
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="sales_training.php" class="item-7 <?php echo $bgClass; ?>">
                    <strong>Sales Training</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>

                <!-- ----service--- -->

                <?php
                $whereClause = "WHERE department = 'Service'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity
                        FROM inventory_in
                        $whereClause
                        GROUP BY supplier, toner_model
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="service.php" class="item-8 <?php echo $bgClass; ?>">
                    <strong>Service</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>

                <!-- ----tool room-- -->

                <?php
                $whereClause = "WHERE department = 'Tool Room'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity
                        FROM inventory_in
                        $whereClause
                        GROUP BY supplier, toner_model
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="tool_room.php" class="item-9 <?php echo $bgClass; ?>">
                    <strong>Tool Room</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>

                <!-- ----Tsure--- -->

                <?php
                $whereClause = "WHERE department = 'Tsure'";
                $sql = "SELECT supplier, toner_model, SUM(quantity) AS total_quantity
                        FROM inventory_in
                        $whereClause
                        GROUP BY supplier, toner_model
                        ORDER BY supplier, toner_model";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                $minQuantity = PHP_INT_MAX;
                $tonerData = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tonerData[] = $row;
                        if ($row['total_quantity'] < $minQuantity) {
                            $minQuantity = $row['total_quantity'];
                        }
                    }
                } else {
                    $minQuantity = 0;
                }

                $stmt->close();

                $bgClass = "bg-green";
                if ($minQuantity < 3) {
                    $bgClass = "bg-red";
                } elseif ($minQuantity < 6) {
                    $bgClass = "bg-yellow";
                }
                ?>

                <a href="tsure.php" class="item-10 <?php echo $bgClass; ?>">
                    <strong>Tsure</strong>
                    <div class="toner-list">
                        <?php
                        if (!empty($tonerData)) {
                            foreach ($tonerData as $row) {
                                echo htmlspecialchars($row['supplier']) . " - " .
                                    htmlspecialchars($row['toner_model']) . ": " .
                                    htmlspecialchars($row['total_quantity']) . "<br>";
                            }
                        } else {
                            echo "No toner found.";
                        }
                        ?>
                    </div>
                </a>


            </div>

        </div>

        <hr style="margin:30px">

        <!-- linegraph here -->

        <form method="GET" class="filter-form">
            <label for="from_date">From: </label>
            <input type="date" name="from_date" value="<?php echo htmlspecialchars($_GET['from_date'] ?? ''); ?>">

            <label for="to_date">To: </label>
            <input type="date" name="to_date" value="<?php echo htmlspecialchars($_GET['to_date'] ?? ''); ?>">

            <button type="submit" class="btn-filter">Filter</button>

            <a href="dashboard.php" class="btn-reset">Reset</a>

        </form>

        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start;">

            <?php

            $fromDate = $_GET['from_date'] ?? date('Y-m-01');
            $toDate = $_GET['to_date'] ?? date('Y-m-t');


            $result = $conn->query($sql);

            $allMonths = [];
            $monthlyData = [];
            $start = new DateTime($fromDate);
            $end = new DateTime($toDate);
            $end->modify('first day of next month');

            while ($start < $end) {
                $monthKey = $start->format('Y-m');
                $monthlyData[$monthKey] = 0;
                $start->modify('+1 month');
            }


            $sql = "SELECT DATE_FORMAT(date_added, '%Y-%m') AS month, SUM(used_quantity) AS total_quantity 
                FROM inventory_out 
                WHERE date_added BETWEEN '$fromDate' AND '$toDate'
                GROUP BY month 
                ORDER BY month ASC";


            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $monthlyData[$row['month']] = $row['total_quantity'];
            }

            $months = [];
            foreach (array_keys($monthlyData) as $monthKey) {
                $months[] = date("M Y", strtotime($monthKey . "-01"));
            }
            $quantities = array_values($monthlyData);

            ?>


            <div style="width: 50%; box-sizing: border-box;">
                <div style="padding: 20px;">
                    <canvas id="tonerUsageChart" style="width: 100%; height: 400px;"></canvas>
                </div>

                <script>
                    const ctx = document.getElementById('tonerUsageChart').getContext('2d');

                    const tonerChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($months); ?>,
                            datasets: [{
                                label: 'Monthly Toner Usage',
                                data: <?php echo json_encode($quantities); ?>,
                                borderColor: 'rgb(128, 0, 0)',
                                backgroundColor: 'rgba(240, 127, 127, 0.38)',
                                tension: 0.4,
                                fill: true,
                                pointRadius: 5,
                                pointHoverRadius: 7
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Toner Usage Per Month',
                                    font: {
                                        size: 20
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Quantity Used'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Month'
                                    }
                                }
                            }
                        }
                    });
                </script>

                <!--bar graph -->

                <?php
                $barQuery = "SELECT department, SUM(used_quantity) AS total_used 
             FROM inventory_out 
             WHERE date_added BETWEEN '$fromDate' AND '$toDate'
             GROUP BY department 
             ORDER BY department";


                $barResult = $conn->query($barQuery);

                $departments = [];
                $usedQuantities = [];

                while ($row = $barResult->fetch_assoc()) {
                    $departments[] = $row['department'];
                    $usedQuantities[] = $row['total_used'];
                }
                ?>

                <div style="padding: 20px; box-sizing: border-box;">
                    <canvas id="departmentBarChart" style="width: 800px; height: 400px;"></canvas>
                </div>
            </div>

            <script>
                const barCtx = document.getElementById('departmentBarChart').getContext('2d');

                const departmentBarChart = new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($departments); ?>,
                        datasets: [{
                            label: 'Total Used',
                            data: <?php echo json_encode($usedQuantities); ?>,
                            backgroundColor: 'rgba(240, 127, 127, 0.38)',
                            borderColor: 'rgba(240, 127, 127, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Used Toners per Department',
                                font: {
                                    size: 18
                                }
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Used Quantity'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Department'
                                }
                            }
                        }
                    }
                });
            </script>

            <!-- pie chart -->

            <?php

            $sql = "SELECT toner_model, SUM(quantity) AS total_quantity 
        FROM inventory_request 
        WHERE date_added BETWEEN '$fromDate' AND '$toDate'
        GROUP BY toner_model";


            $result = $conn->query($sql);

            $tonerLabels = [];
            $tonerQuantities = [];

            while ($row = $result->fetch_assoc()) {
                $tonerLabels[] = $row['toner_model'];
                $tonerQuantities[] = $row['total_quantity'];
            }
            ?>

            <div style="width: 50%; padding: 20px; box-sizing: border-box;">
                <canvas id="tonerPieChart" style="width: 100%; height: 500px;"></canvas>
            </div>

            <script>
                const pieCtx = document.getElementById('tonerPieChart').getContext('2d');

                const tonerPieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode($tonerLabels); ?>,
                        datasets: [{
                            data: <?php echo json_encode($tonerQuantities); ?>,
                            backgroundColor: [
                                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                '#9966FF', '#FF9F40', '#C9CBCF', '#76C7C0'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Total Toner Requests by Model',
                                font: {
                                    size: 18
                                }
                            },
                            legend: {
                                position: 'right'
                            }
                        }
                    }
                });
            </script>
        </div>

        <hr style="margin:30px">





    </div>

    <style>
        body {
            background-color: rgb(221, 221, 221);

        }


        .grid-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin: 20px;

        }


        .item-1,
        .item-2,
        .item-3,
        .item-4,
        .item-5,
        .item-6,
        .item-7,
        .item-8,
        .item-9,
        .item-10,
        .item-11 {

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            padding: 20px;
            text-align: center;
            border-radius: 10px;
            height: 100%;
            width: 100%;
            font-size: 20px;
            font-family: 'Mulish', sans-serif;

            text-decoration: none;
            color: inherit;
        }



        .item-1:hover,
        .item-2:hover,
        .item-3:hover,
        .item-4:hover,
        .item-5:hover,
        .item-6:hover,
        .item-7:hover,
        .item-8:hover,
        .item-9:hover,
        .item-10:hover,
        .item-11:hover {
            transform: scale(1.02);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .item-1 strong,
        .item-2 strong,
        .item-3 strong,
        .item-4 strong,
        .item-5 strong,
        .item-6 strong,
        .item-7 strong,
        .item-8 strong,
        .item-9 strong,
        .item-10 strong,
        .item-11 strong {
            color: white;
            font-size: 30px;
            font-weight: bold;
        }

        .toner-list {
            text-align: center;
            font-size: 18px;
            line-height: 1.6;
            font-weight: 500;
            color: white;
        }

        .bg-red {
            background-color: rgb(168, 53, 53) !important;
            color: white;
        }

        .bg-yellow {
            background-color: rgb(255, 176, 29) !important;
            color: black;
        }

        .bg-green {
            background-color: #3e8e41 !important;
            color: white;
        }


        .dashboardContainer {
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

            overflow-y: auto;
            overflow-x: hidden;
        }


        .displayCount h1 {
            color: #800000;
            font-family: 'Mulish', sans-serif;
            font-size: 25px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
        }

        @media screen and (max-width: 1555px) and (min-width: 320px) {
            .dashboardContainer {
                width: 98%;
            }
        }

        @media screen and (max-width: 1950px) and (min-width: 1610px) {
            .dashboardContainer {
                min-width: 85.4%;
            }

            .fb-page {
                min-width: 100%;
            }

            .fbPlugins h1 {
                width: 93.7%;
            }
        }

        @media print {
            body {
                text-align: center;
            }

            table {
                text-align: center;
            }
        }

        .filter-form {
            text-align: center;
            margin: 30px auto 50px;
        }

        .filter-form input[type="date"] {
            padding: 8px 12px;
            margin: 0 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .filter-form button,
        .filter-form .btn-reset {
            padding: 8px 16px;
            margin: 0 5px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background-color: #800000;
            color: white;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .filter-form button:hover,
        .filter-form .btn-reset:hover {
            background-color: #a50000;
        }

        .btn-print {
            background-color: #4CAF50;
        }

        .btn-print:hover {
            background-color: #3e8e41;
        }

        .btn-reset {
            background-color: #999;
        }

        .btn-reset:hover {
            background-color: #777;
        }

        @media print {
            .filter-form {
                display: none !important;
            }
        }

        .filter-form input[type="date"] {
            padding: 8px 12px;
            margin: 0 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
    </style>
</body>

</html>