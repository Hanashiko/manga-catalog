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
