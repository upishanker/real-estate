<?php
require_once 'db.php';

$results = null;
$searched = false;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['minPrice']) || isset($_GET['maxPrice']) || isset($_GET['minSize']) || isset($_GET['maxSize']))) {
    $searched = true;
    $minPrice = isset($_GET['minPrice']) && $_GET['minPrice'] !== '' ? intval($_GET['minPrice']) : 0;
    $maxPrice = isset($_GET['maxPrice']) && $_GET['maxPrice'] !== '' ? intval($_GET['maxPrice']) : 999999999;
    $minSize = isset($_GET['minSize']) && $_GET['minSize'] !== '' ? intval($_GET['minSize']) : 0;
    $maxSize = isset($_GET['maxSize']) && $_GET['maxSize'] !== '' ? intval($_GET['maxSize']) : 999999999;

    $sql = "SELECT L.mlsNumber, P.address, P.ownerName, P.price, 
                   BP.type, BP.size, A.name as agentName
            FROM Listings L
            JOIN Property P ON L.address = P.address
            JOIN BusinessProperty BP ON P.address = BP.address
            JOIN Agent A ON L.agentId = A.agentId
            WHERE P.price BETWEEN ? AND ?
            AND BP.size BETWEEN ? AND ?
            ORDER BY P.price DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $minPrice, $maxPrice, $minSize, $maxSize);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Search Business Properties</title>
    </head>
    <body>

    <h1>Search Business Properties</h1>

    <p><a href="index.php">Back to Home</a></p>

    <h2>Search Criteria</h2>
    <form method="GET">
        Min Price: <input type="number" name="minPrice" value="<?php echo isset($_GET['minPrice']) ? $_GET['minPrice'] : ''; ?>"><br><br>
        Max Price: <input type="number" name="maxPrice" value="<?php echo isset($_GET['maxPrice']) ? $_GET['maxPrice'] : ''; ?>"><br><br>
        Min Size (sq ft): <input type="number" name="minSize" value="<?php echo isset($_GET['minSize']) ? $_GET['minSize'] : ''; ?>"><br><br>
        Max Size (sq ft): <input type="number" name="maxSize" value="<?php echo isset($_GET['maxSize']) ? $_GET['maxSize'] : ''; ?>"><br><br>
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
                    <th>Type</th>
                    <th>Size (sq ft)</th>
                    <th>Agent</th>
                </tr>
                <?php while($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['mlsNumber']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['ownerName']; ?></td>
                        <td>$<?php echo number_format($row['price']); ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo number_format($row['size']); ?></td>
                        <td><?php echo $row['agentName']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No business properties found matching your criteria.</p>
        <?php endif; ?>
    <?php endif; ?>

    </body>
    </html>
<?php $conn->close(); ?>