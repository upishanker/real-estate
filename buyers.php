<?php
require "db.php";

$query = "
    SELECT Buyer.id, Buyer.name, Buyer.phone, Buyer.propertyType,
           Buyer.bedrooms, Buyer.bathrooms,
           Buyer.businessPropertyType,
           Buyer.minimumPreferredPrice, Buyer.maximumPreferredPrice,
           Agent.name AS agentName
    FROM Buyer
    LEFT JOIN Works_With ON Buyer.id = Works_With.buyerId
    LEFT JOIN Agent ON Works_With.agentID = Agent.agentId
    ORDER BY Buyer.name ASC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buyers</title>
</head>
<body>
<h1>All Buyers</h1>
<table border="1" cellpadding="8">
    <tr>
        <th>Buyer ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Property Type</th>
        <th>Bedrooms</th>
        <th>Bathrooms</th>
        <th>Business Type</th>
        <th>Min Price</th>
        <th>Max Price</th>
        <th>Working With Agent</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['propertyType'] ?></td>
            <td><?= $row['bedrooms'] ?></td>
            <td><?= $row['bathrooms'] ?></td>
            <td><?= $row['businessPropertyType'] ?></td>
            <td><?= $row['minimumPreferredPrice'] ?></td>
            <td><?= $row['maximumPreferredPrice'] ?></td>
            <td><?= $row['agentName'] ? $row['agentName'] : "None" ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
