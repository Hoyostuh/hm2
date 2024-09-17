<?php
$file = 'data.txt';
function displayMessages($file) {
    if (file_exists($file)) {
        $messages = array_reverse(file($file));
        foreach ($messages as $message) {
            echo nl2br(htmlspecialchars($message)) . "<hr>";
        }
    } else {
        echo "Сообщений пока нет.";
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    if ($name && $email && $message) {
        $date = date('Y-m-d H:i:s');
        $newMessage = "Имя: $name\nEmail: $email\nДата: $date\nСообщение: $message\n---\n";
        file_put_contents($file, $newMessage, FILE_APPEND);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гостевая книга</title>
</head>
<body>
    <h1>Гостевая книга</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Имя" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="message" placeholder="Сообщение" required></textarea>
        <button type="submit">Отправить</button>
    </form>
    <h2>Сообщения:</h2>
    <?php displayMessages($file); ?>
</body>
</html>
