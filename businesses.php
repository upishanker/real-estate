<?php
require "db.php";

$query = "
    SELECT BusinessProperty.address, BusinessProperty.type, BusinessProperty.size,
           Property.price,
           Listings.mlsNumber, Listings.dateListed,
           Agent.name AS agentName
    FROM BusinessProperty
    JOIN Property ON BusinessProperty.address = Property.address
    JOIN Listings ON Listings.address = Property.address
    JOIN Agent ON Listings.agentId = Agent.agentId
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Business Listings</title>
</head>
<body>
<h1>Business Property Listings</h1>
<table border="1" cellpadding="8">
    <tr>
        <th>Address</th>
        <th>Business Type</th>
        <th>Size (sq ft)</th>
        <th>Price</th>
        <th>MLS Number</th>
        <th>Date Listed</th>
        <th>Agent</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['address'] ?></td>
            <td><?= $row['type'] ?></td>
            <td><?= $row['size'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['mlsNumber'] ?></td>
            <td><?= $row['dateListed'] ?></td>
            <td><?= $row['agentName'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
