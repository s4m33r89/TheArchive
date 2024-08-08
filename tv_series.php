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

$sql = "SELECT * FROM tv_series WHERE title LIKE ? ORDER BY title, season, episode LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$search_term = "%$search%";
$stmt->bind_param("sii", $search_term, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$total_result = $conn->query("SELECT COUNT(*) AS total FROM tv_series WHERE title LIKE '$search_term'")->fetch_assoc();
$total_pages = ceil($total_result['total'] / $items_per_page);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV Series - Media Download Site</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            color: #e0e0e0;
            margin: 20px;
            font-size: 2.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #1e1e1e;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #333;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #e0e0e0;
        }
        tr:nth-child(even) {
            background-color: #2a2a2a;
        }
        tr:nth-child(odd) {
            background-color: #1e1e1e;
        }
        .pagination {
            text-align: center;
            margin: 20px 0;
        }
        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #1e1e1e;
            transition: background-color 0.3s, color 0.3s;
        }
        .pagination a:hover {
            background-color: #007bff;
            color: #ffffff;
        }
        .search-container {
            text-align: center;
            margin: 20px 0;
        }
        .search-container input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #1e1e1e;
            color: #e0e0e0;
        }
        .search-container button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>TV Series</h1>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search for TV series" oninput="searchTVSeries()">
    </div>
    <div id="resultContainer">
        <!-- Content will be loaded here -->
    </div>
    <div class="pagination" id="pagination">
        <!-- Pagination controls will be loaded here -->
    </div>
    <script>
        function searchTVSeries(page = 1) {
            const searchQuery = document.getElementById('searchInput').value;
            fetch(`fetch_tv_series.php?page=${page}&search=${encodeURIComponent(searchQuery)}`)
                .then(response => response.text())
                .then(data => {
                    const container = document.getElementById('resultContainer');
                    const pagination = document.getElementById('pagination');
                    const [htmlContent, paginationHtml] = data.split('<!-- pagination -->');
                    container.innerHTML = htmlContent;
                    pagination.innerHTML = paginationHtml;
                })
                .catch(error => console.error('Error:', error));
        }
          // https://t.me/syndic4te
        // Initial load
        searchTVSeries();
    </script>
</body>
</html>
