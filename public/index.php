<?php
include('../config/db_config.php');
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати мангу</title>
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-semibold mb-4">Додати мангу</h1>
        <form action="add_manga.php" method="POST" enctype="multipart/form-data">
            <label for="title" class="block text-sm font-medium text-gray-700">Назва</label>
            <input type="text" name="title" id="title" class="mt-1 p-2 w-full border border-gray-300 rounded" required>

            <label for="chapters" class="block text-sm font-medium text-gray-700 mt-4">Кількість розділів</label>
            <input type="number" name="chapters" id="chapters" class="mt-1 p-2 w-full border border-gray-300 rounded" required>

            <label for="author" class="block text-sm font-medium text-gray-700 mt-4">Автор</label>
            <input type="text" name="author" id="author" class="mt-1 p-2 w-full border border-gray-300 rounded" required>

            <label for="publication_year" class="block text-sm font-medium text-gray-700 mt-4">Рік публікації</label>
            <input type="number" name="publication_year" id="publication_year" class="mt-1 p-2 w-full border border-gray-300 rounded" required>

            <label for="poster_image" class="block text-sm font-medium text-gray-700 mt-4">Зображення постеру</label>
            <input type="file" name="poster_image" id="poster_image" class="mt-1 p-2 w-full border border-gray-300 rounded" required>

            <button type="submit" class="mt-6 p-2 bg-blue-500 text-white rounded">Додати мангу</button>
        </form>
    </div>
</body>
</html>
