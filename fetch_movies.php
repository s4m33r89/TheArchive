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

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 100;
$offset = ($page - 1) * $items_per_page;

$sql = "SELECT * FROM movies WHERE title LIKE ? ORDER BY title LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$search_term = "%$search%";
$stmt->bind_param("sii", $search_term, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$total_result = $conn->query("SELECT COUNT(*) AS total FROM movies WHERE title LIKE '$search_term'")->fetch_assoc();
$total_pages = ceil($total_result['total'] / $items_per_page);

// Generate HTML for the table
$tableHtml = '<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Download</th>
        </tr>
    </thead>
    <tbody>';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tableHtml .= "<tr>
            <td>" . htmlspecialchars($row["title"]) . "</td>
            <td><a href='" . htmlspecialchars($row["url"]) . "' download>Download</a></td>
        </tr>";
    }
} else {
    $tableHtml .= "<tr><td colspan='2'>No movies found</td></tr>";
}

$tableHtml .= '</tbody></table>';
 
 // https://t.me/syndic4te
 
// Generate HTML for pagination
$paginationHtml = '<div class="pagination">';
if ($page > 1) {
    $paginationHtml .= '<a href="javascript:searchMovies(1)">First</a>
                        <a href="javascript:searchMovies(' . ($page - 1) . ')">Previous</a>';
}
if ($page < $total_pages) {
    $paginationHtml .= '<a href="javascript:searchMovies(' . ($page + 1) . ')">Next</a>
                        <a href="javascript:searchMovies(' . $total_pages . ')">Last</a>';
}
$paginationHtml .= '</div><!-- pagination -->';

echo $tableHtml . $paginationHtml;

$conn->close();
?>
