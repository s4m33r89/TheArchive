<?php
$servername = "localhost";
$username = "user";
$password = "password";
$dbname = "databasename";


// https://t.me/syndic4te

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$limit = 100; // Number of items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

$searchQuery = $conn->real_escape_string($searchQuery);

$sql = "SELECT * FROM movies WHERE title LIKE '%$searchQuery%' ORDER BY title LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Download</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row["title"]) . "</td>
                    <td><a href='" . htmlspecialchars($row["url"]) . "' download>Download</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No data available</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php $conn->close(); ?>
