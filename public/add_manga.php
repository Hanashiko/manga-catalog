<?php
include('../config/db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $chapters = $_POST['chapters'];
    $author = $_POST['author'];
    $publication_year = $_POST['publication_year'];

    if ($_FILES['poster_image']['error'] == UPLOAD_ERR_OK) {
        $poster_image = $_FILES['poster_image']['name'];
        $tmp_name = $_FILES['poster_image']['tmp_name'];

        $target_dir = "../uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); 
        }

        $target_file = $target_dir . basename($poster_image);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($image_file_type, $allowed_extensions)) {
            echo "Тільки зображення формату jpg, jpeg, png або gif дозволено.";
            exit;
        }

        if (move_uploaded_file($tmp_name, $target_file)) {
            echo "Зображення було завантажено успішно.";
        } else {
            echo "Помилка при завантаженні зображення.";
            exit;
        }
    } else {
        echo "Помилка завантаження зображення. Код помилки: " . $_FILES['poster_image']['error'];
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO manga (title, chapters, author, publication_year, poster_image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $chapters, $author, $publication_year, $poster_image);

    if ($stmt->execute()) {
        header("Location: catalog.php");
        exit;
    } else {
        echo "Помилка при додаванні манги в базу даних: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати Мангу</title>
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Додати нову мангу</h1>
        <form action="add_manga.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Назва манги</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="chapters" class="block text-gray-700">Кількість розділів</label>
                <input type="number" name="chapters" id="chapters" class="w-full px-4 py-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="author" class="block text-gray-700">Автор</label>
                <input type="text" name="author" id="author" class="w-full px-4 py-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="publication_year" class="block text-gray-700">Рік публікації</label>
                <input type="number" name="publication_year" id="publication_year" class="w-full px-4 py-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="poster_image" class="block text-gray-700">Зображення постера</label>
                <input type="file" name="poster_image" id="poster_image" class="w-full px-4 py-2 border border-gray-300 rounded" accept="image/*" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg">Додати мангу</button>
        </form>
    </div>
</body>
</html>
