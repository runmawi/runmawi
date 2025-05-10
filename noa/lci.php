<?php
// Database connection
$host = 'localhost'; // Change if necessary
$dbname = 'runmawi_vod';
$username = 'runmawi_noa';
$password = 'Nanoa123@#$';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch monthly total per video_id from December 15, 2024, onwards with specific conditions
$query = "
    SELECT 
        p.video_id, 
        v.title,                              
        DATE_FORMAT(p.created_at, '%Y-%m') AS month, 
        COUNT(CASE WHEN p.moderator_id = v.user_id THEN 1 END) AS quantity,  
        SUM(CASE WHEN p.moderator_id = v.user_id THEN p.total_amount ELSE 0 END) AS total_received 
    FROM ppv_purchases p
    JOIN videos v ON v.id = p.video_id       
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
    <title>Monthly Revenue Per Video</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #333;
        }
        h2, h3 {
            text-align: center;
            color: #333;
            padding-top: 20px;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 1200px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
            font-weight: 500;
        }
        td {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        td:nth-child(4) {
            text-align: right;
        }
        tr:hover td {
            background-color: #f1f1f1;
        }
        .total-revenue {
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: 500;
        }
        .no-records {
            text-align: center;
            font-size: 16px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Monthly Revenue Per Video</h2>
    
    <?php if (!empty($groupedResults)): ?>
        <?php foreach ($groupedResults as $month => $rows): ?>
            <h3>Month: <?= htmlspecialchars($month) ?></h3>
            <table>
                <thead>
                    <tr>
                        <th>Video ID</th>
                        <th>Movie Title</th>
                        <th>Quantity (Transactions)</th>
                        <th>Total Amount Received</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['video_id']) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= number_format($row['quantity']) ?></td>
                        <td>Rs <?= number_format($row['total_received'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-records">No purchases found from December 15, 2024, onwards with the specified criteria.</p>
    <?php endif; ?>

</div>

</body>
</html>
