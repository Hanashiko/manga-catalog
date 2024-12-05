<?php
include('../config/db_config.php');

$sort_order = 'ASC'; 
if (isset($_GET['sort'])) {
    $sort_order = ($_GET['sort'] == 'desc') ? 'DESC' : 'ASC';
}

$sql = "SELECT * FROM manga ORDER BY chapters $sort_order";
$result = $conn->query($sql);

if ($result === FALSE) {
    echo "Помилка запиту до бази даних: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог манги</title>
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Каталог манги</h1>

        <div class="mb-6">
            <a href="catalog.php?sort=asc" class="text-blue-500 hover:text-blue-700">Сортувати за зростанням розділів</a> |
            <a href="catalog.php?sort=desc" class="text-blue-500 hover:text-blue-700">Сортувати за спаданням розділів</a>
        </div>

        <div class="mb-6">
            <a href="add_manga.php" class="inline-block bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Додати нову мангу</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $title = htmlspecialchars($row['title']);
                    $chapters = htmlspecialchars($row['chapters']);
                    $author = htmlspecialchars($row['author']);
                    $publication_year = htmlspecialchars($row['publication_year']);
                    $poster_image = $row['poster_image'];
                    $poster_path = "../uploads/" . $poster_image;
                    ?>

                    <div class="bg-white p-4 rounded-lg shadow-lg">
                        <h2 class="text-xl font-bold mb-2"><?php echo $title; ?></h2>
                        <p class="text-gray-600 mb-2"><strong>Автор:</strong> <?php echo $author; ?></p>
                        <p class="text-gray-600 mb-2"><strong>Рік публікації:</strong> <?php echo $publication_year; ?></p>
                        <p class="text-gray-600 mb-2"><strong>Кількість розділів:</strong> <?php echo $chapters; ?></p>

                        <div class="w-full h-64 bg-gray-200 mb-4">
                            <img src="<?php echo $poster_path; ?>" alt="Poster for <?php echo $title; ?>" class="object-cover w-full h-full rounded">
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<p>Немає манги в каталозі.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
