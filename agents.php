<?php
require "db.php";

$query = "
    SELECT Agent.agentId, Agent.name AS agentName, Agent.phone, Agent.dateStarted,
           Firm.name AS firmName, Firm.address AS firmAddress
    FROM Agent
    JOIN Firm ON Agent.firmId = Firm.id
    ORDER BY Agent.name ASC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agents</title>
</head>
<body>
<h1>All Agents</h1>
<table border="1" cellpadding="8">
    <tr>
        <th>Agent ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Date Started</th>
        <th>Firm</th>
        <th>Firm Address</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['agentId'] ?></td>
            <td><?= $row['agentName'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['dateStarted'] ?></td>
            <td><?= $row['firmName'] ?></td>
            <td><?= $row['firmAddress'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
