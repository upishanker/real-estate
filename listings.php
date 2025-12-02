<?php
require "db.php";

// Houses
$houses = $conn->query("
    SELECT Listings.mlsNumber, Property.address, Property.price,
           House.bedrooms, House.bathrooms,
           Agent.name AS agentName
    FROM Listings
    JOIN Property ON Listings.address = Property.address
    LEFT JOIN House ON House.address = Property.address
    JOIN Agent ON Listings.agentId = Agent.agentId
    WHERE House.address IS NOT NULL
");

// Businesses
$businesses = $conn->query("
    SELECT Listings.mlsNumber, Property.address, Property.price,
           BusinessProperty.type, BusinessProperty.size,
           Agent.name AS agentName
    FROM Listings
    JOIN Property ON Listings.address = Property.address
    LEFT JOIN BusinessProperty ON BusinessProperty.address = Property.address
    JOIN Agent ON Listings.agentId = Agent.agentId
    WHERE BusinessProperty.address IS NOT NULL
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Listings</title>
</head>
<body>

<h1>All Listings</h1>

<h2>House Listings</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>MLS Number</th>
        <th>Address</th>
        <th>Bedrooms</th>
        <th>Bathrooms</th>
        <th>Price</th>
        <th>Agent</th>
    </tr>
    <?php while($row = $houses->fetch_assoc()): ?>
        <tr>
            <td><?= $row['mlsNumber'] ?></td>
            <td><?= $row['address'] ?></td>
            <td><?= $row['bedrooms'] ?></td>
            <td><?= $row['bathrooms'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['agentName'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<br><br>

<h2>Business Property Listings</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>MLS Number</th>
        <th>Address</th>
        <th>Type</th>
        <th>Size (sq ft)</th>
        <th>Price</th>
        <th>Agent</th>
    </tr>
    <?php while($row = $businesses->fetch_assoc()): ?>
        <tr>
            <td><?= $row['mlsNumber'] ?></td>
            <td><?= $row['address'] ?></td>
            <td><?= $row['type'] ?></td>
            <td><?= $row['size'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['agentName'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
