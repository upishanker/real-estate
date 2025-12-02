<?php
require "db.php";

$query = "
    SELECT House.address, House.bedrooms, House.bathrooms, House.size,
           Property.price,
           Listings.mlsNumber, Listings.dateListed,
           Agent.name AS agentName
    FROM House
    JOIN Property ON House.address = Property.address
    JOIN Listings ON Listings.address = Property.address
    JOIN Agent ON Listings.agentId = Agent.agentId
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>House Listings</title>
</head>
<body>
<h1>House Listings</h1>

<table border="1" cellpadding="8">
    <tr>
        <th>Address</th>
        <th>Bedrooms</th>
        <th>Bathrooms</th>
        <th>Size (sq ft)</th>
        <th>Price</th>
        <th>MLS Number</th>
        <th>Date Listed</th>
        <th>Agent</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['address'] ?></td>
            <td><?= $row['bedrooms'] ?></td>
            <td><?= $row['bathrooms'] ?></td>
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
