<?php
require_once 'db.php';

$results = null;
$searched = false;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['minPrice']) || isset($_GET['maxPrice']) || isset($_GET['bedrooms']) || isset($_GET['bathrooms']))) {
    $searched = true;
    $minPrice = isset($_GET['minPrice']) && $_GET['minPrice'] !== '' ? intval($_GET['minPrice']) : 0;
    $maxPrice = isset($_GET['maxPrice']) && $_GET['maxPrice'] !== '' ? intval($_GET['maxPrice']) : 999999999;
    $bedrooms = isset($_GET['bedrooms']) && $_GET['bedrooms'] !== '' ? intval($_GET['bedrooms']) : null;
    $bathrooms = isset($_GET['bathrooms']) && $_GET['bathrooms'] !== '' ? intval($_GET['bathrooms']) : null;

    $sql = "SELECT L.mlsNumber, P.address, P.ownerName, P.price, 
                   H.bedrooms, H.bathrooms, H.size, A.name as agentName
            FROM Listings L
            JOIN Property P ON L.address = P.address
            JOIN House H ON P.address = H.address
            JOIN Agent A ON L.agentId = A.agentId
            WHERE P.price BETWEEN ? AND ?";

    $params = [$minPrice, $maxPrice];
    $types = "ii";

    if ($bedrooms !== null) {
        $sql .= " AND H.bedrooms = ?";
        $params[] = $bedrooms;
        $types .= "i";
    }

    if ($bathrooms !== null) {
        $sql .= " AND H.bathrooms = ?";
        $params[] = $bathrooms;
        $types .= "i";
    }

    $sql .= " ORDER BY P.price DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Search Houses</title>
    </head>
    <body>

    <h1>Search Houses</h1>

    <p><a href="index.php">Back to Home</a></p>

    <h2>Search Criteria</h2>
    <form method="GET">
        Min Price: <input type="number" name="minPrice" value="<?php echo isset($_GET['minPrice']) ? $_GET['minPrice'] : ''; ?>"><br><br>
        Max Price: <input type="number" name="maxPrice" value="<?php echo isset($_GET['maxPrice']) ? $_GET['maxPrice'] : ''; ?>"><br><br>
        Bedrooms: <input type="number" name="bedrooms" value="<?php echo isset($_GET['bedrooms']) ? $_GET['bedrooms'] : ''; ?>"><br><br>
        Bathrooms: <input type="number" name="bathrooms" value="<?php echo isset($_GET['bathrooms']) ? $_GET['bathrooms'] : ''; ?>"><br><br>
        <button type="submit">Search</button>
    </form>

    <?php if ($searched): ?>
        <hr>
        <h2>Search Results</h2>
        <?php if ($results && $results->num_rows > 0): ?>
            <table border="1" cellpadding="5">
                <tr>
                    <th>MLS Number</th>
                    <th>Address</th>
                    <th>Owner</th>
                    <th>Price</th>
                    <th>Bedrooms</th>
                    <th>Bathrooms</th>
                    <th>Size (sq ft)</th>
                    <th>Agent</th>
                </tr>
                <?php while($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['mlsNumber']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['ownerName']; ?></td>
                        <td>$<?php echo number_format($row['price']); ?></td>
                        <td><?php echo $row['bedrooms']; ?></td>
                        <td><?php echo $row['bathrooms']; ?></td>
                        <td><?php echo number_format($row['size']); ?></td>
                        <td><?php echo $row['agentName']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No houses found matching your criteria.</p>
        <?php endif; ?>
    <?php endif; ?>

    </body>
    </html>
<?php $conn->close(); ?>