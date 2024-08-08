<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Media Download Archive</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        h1 {
            color: #e0e0e0;
            margin-bottom: 40px;
            font-size: 2.5rem;
        }
        .container {
            background: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            padding: 40px;
            width: 100%;
            max-width: 600px;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            font-size: 18px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .button:active {
            background-color: #004494;
            transform: scale(0.95);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Media Download Archive</h1>
        <a href="movies.php" class="button">Movies</a>
        <a href="tv_series.php" class="button">TV Series</a>
    </div>
</body>
</html>
