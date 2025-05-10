<?php
// Database connection
$host = 'localhost';
$dbname = 'runmawi_vod';
$username = 'runmawi_noa';
$password = 'Nanoa123@#$';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch monthly total per video_id from December 15, 2024, onwards
$query = "
    SELECT 
        p.video_id, 
        v.title,                              
        v.CPP_commission_percentage,          
        v.user_id,                            
        mu.username,                          
        mu.mobile_number,                     
        DATE_FORMAT(p.created_at, '%Y-%m') AS month, 
        COUNT(CASE WHEN p.ppv_plan = '1080p' AND p.moderator_id = v.user_id THEN 1 END) AS quantity_1080p, 
        COUNT(CASE WHEN p.ppv_plan = '720p' AND p.moderator_id = v.user_id THEN 1 END) AS quantity_720p,
        COUNT(CASE WHEN p.ppv_plan = '480p' AND p.moderator_id = v.user_id THEN 1 END) AS quantity_480p,
        COUNT(CASE WHEN p.moderator_id = v.user_id THEN 1 END) AS total_quantity,  -- Count only when moderator_id matches user_id
        SUM(CASE WHEN p.moderator_id = v.user_id THEN p.total_amount ELSE 0 END) AS total_received
    FROM ppv_purchases p
    JOIN videos v ON v.id = p.video_id       
    LEFT JOIN moderators_users mu ON mu.id = v.user_id  
    WHERE p.created_at >= '2024-12-15'       
    AND p.status = 'captured'                
    GROUP BY p.video_id, month 
    ORDER BY month DESC, p.video_id;
";


$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organize data by month
$groupedResults = [];
foreach ($results as $row) {
    $groupedResults[$row['month']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Revenue Report</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script> <!-- Include SheetJS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h2, h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 1500px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: white;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-left: 1px solid #ddd;
            border-top: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
            font-weight: 500;
            text-align: center;
            border-top: none;
        }
        td {
            font-size: 14px;
            color: #555;
        }
        tr:hover td {
            background-color: #f9f9f9;
            transition: background-color 0.3s ease;
        }
        tr:last-child td {
            border-bottom: 1px solid #ddd;
        }
        th:first-child, td:first-child {
            border-left: none;
        }
        th:last-child, td:last-child {
            border-right: 1px solid #ddd;
        }
        .summary-table {
            width: 50%;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .summary-table td {
            padding: 10px;
            font-weight: bold;
        }
        .print-button {
            text-align: center;
            margin: 20px;
        }
        .print-button button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .print-button button:hover {
            background-color: #218838;
        }
        @media print {
            .print-button {
                display: none;
            }
            body {
                font-size: 12pt;
            }
            table {
                width: 100%;
                border: 1px solid #ddd;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
            .summary-table {
                width: 50%;
                margin: 20px auto;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Monthly Revenue Report</h2>

    <?php if (!empty($groupedResults)): ?>
        <?php foreach ($groupedResults as $month => $rows): ?>
            <?php
            // Monthly Totals
            $totalReceived = 0;
            $totalGST = 0;
            $totalProducerShare = 0;
            $totalRunmawiShare = 0;
            $totalAmountAfterGST = 0;

            foreach ($rows as $row) {
                $amountAfterGST = $row['total_received'] * 0.82;
                $producerShare = $amountAfterGST * ($row['CPP_commission_percentage'] / 100);
                $runmawiShare = $amountAfterGST - $producerShare;

                $totalReceived += $row['total_received'];
                $totalGST += $row['total_received'] * 0.18;
                $totalProducerShare += $producerShare;
                $totalRunmawiShare += $runmawiShare;
                $totalAmountAfterGST += $amountAfterGST;
            }
            ?>

            <div id="report-<?= $month ?>">

                <h3><?= date('F Y', strtotime($month . '-01')) ?> Report</h3>

                <table id="table-<?= $month ?>">
                    <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Video ID</th>
                            <th>Movie Title</th>
                            <th>Quantity (1080p, 720p, 480p)</th>
                            <th>Total Amount Received</th>
                            <th>Amount after GST (18%)</th>
                            <th>Producer Share %</th>
                            <th>Producer Share (Amount)</th>
                            <th>Runmawi Share (Amount)</th>
                            <th>Producer Name</th>
                            <th>Producer Number</th>
                            <th>Producer ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serialNo = 1; ?>
                        <?php foreach ($rows as $row): ?>
                            <?php
                            $amountAfterGST = $row['total_received'] * 0.82;
                            $producerShare = $amountAfterGST * ($row['CPP_commission_percentage'] / 100);
                            $runmawiShare = $amountAfterGST - $producerShare;
                            ?>
                            <tr>
                                <td><?= $serialNo++ ?></td>
                                <td><?= htmlspecialchars($row['video_id']) ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td>
                                    <?= number_format($row['total_quantity']) ?> ( <?= number_format($row['quantity_1080p']) ?>+<?= number_format($row['quantity_720p']) ?>+<?= number_format($row['quantity_480p']) ?>)
                                </td>
                                <td>Rs <?= number_format($row['total_received'], 2) ?></td>
                                <td>Rs <?= number_format($amountAfterGST, 2) ?></td>
                                <td><?= number_format($row['CPP_commission_percentage'], 2) ?>%</td>
                                <td>Rs <?= number_format($producerShare, 2) ?></td>
                                <td>Rs <?= number_format($runmawiShare, 2) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['mobile_number']) ?></td>
                                <td><?= htmlspecialchars($row['user_id']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <table class="summary-table">
                    <tr><td>Total Amount Received:</td><td>Rs <?= number_format($totalReceived, 2) ?></td></tr>
                    <tr><td>Total GST Deducted:</td><td>Rs <?= number_format($totalGST, 2) ?></td></tr>
                    <tr><td>Total Amount after GST:</td><td>Rs <?= number_format($totalAmountAfterGST, 2) ?></td></tr> 
                    <tr><td>Total Producer Share:</td><td>Rs <?= number_format($totalProducerShare, 2) ?></td></tr>
                    <tr><td>Total Runmawi Share:</td><td>Rs <?= number_format($totalRunmawiShare, 2) ?></td></tr>
                </table>

                <div class="print-button">
                    <button onclick="printReport('report-<?= $month ?>')">Print <?= date('F Y', strtotime($month . '-01')) ?> Report</button>
                    <button onclick="exportToExcel('table-<?= $month ?>', '<?= date('F Y', strtotime($month . '-01')) ?>')">Save to Excel</button>
                </div>

            </div>

        <?php endforeach; ?>
    <?php else: ?>
        <p>No purchases found.</p>
    <?php endif; ?>
</div>

<script>
    function printReport(reportId) {
        var content = document.getElementById(reportId).innerHTML;
        var win = window.open('', '', 'height=600,width=800');
        win.document.write('<html><head><title>Print Report</title>');
        win.document.write('<style>body { font-family: Arial, sans-serif; font-size: 12pt; }</style>');
        win.document.write('</head><body>');
        win.document.write(content);
        win.document.write('</body></html>');
        win.document.close();
        win.print();
    }

    function exportToExcel(tableId, monthName) {
        var table = document.getElementById(tableId);
        var wb = XLSX.utils.table_to_book(table, { sheet: "Report" });
        XLSX.writeFile(wb, monthName + '-Report.xlsx');
    }
</script>

</body>
</html>
