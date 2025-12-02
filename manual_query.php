<?php
require 'db.php';


$query = "";
$result = null;
$error = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = trim($_POST['query']);


    if (!empty($query)) {
        $run = $conn->query($query);


        if ($run) {
            $result = $run;
        } else {
            $error = "Query Error: " . $conn->error;
        }
    } else {
        $error = "Please enter a SQL query.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manual SQL Query</title>
</head>
<body>
<h2>Run Manual SQL Query</h2>
<form method="POST">
    <textarea name="query" rows="5" cols="80" placeholder="Enter SQL query here..."><?php echo htmlspecialchars($query); ?></textarea><br>
    <button type="submit">Run Query</button>
</form>


<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>


<?php if ($result): ?>
    <h3>Query Results:</h3>
    <table border="1" cellpadding="5">
        <tr>
            <?php while ($field = $result->fetch_field()): ?>
                <th><?php echo $field->name; ?></th>
            <?php endwhile; ?>
        </tr>


        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <?php foreach ($row as $value): ?>
                    <td><?php echo htmlspecialchars($value); ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>
</body>
</html>