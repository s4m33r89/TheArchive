<?php
$servername = "localhost";
$username = "user";
$password = "password";
$dbname = "databasename";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';
$sql = "SELECT * FROM tv_series WHERE title LIKE '%$query%' ORDER BY title, season, episode";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Season</th>
                    <th>Episode</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["title"]) . "</td>
                <td>" . htmlspecialchars($row["season"]) . "</td>
                <td>" . htmlspecialchars($row["episode"]) . "</td>
                <td><a href='" . htmlspecialchars($row["url"]) . "' download>Download</a></td>
              </tr>";
    }
    echo "  </tbody>
          </table>";
} else {
    echo "<table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Season</th>
                    <th>Episode</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan='4'>No data available</td></tr>
            </tbody>
          </table>";
}

$conn->close();
?>
