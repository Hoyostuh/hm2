<?php
$file = 'data.txt';

function displayMessages($file) {
    if (file_exists($file)) {
        $fileContent = file_get_contents($file);
        $messages = explode("---END---", $fileContent);
        $messages = array_reverse($messages);

        foreach ($messages as $message) {
            $formattedMessage = trim($message);
            if (!empty($formattedMessage)) {
                echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; background-color: #f9f9f9;">';
                echo nl2br(htmlspecialchars($formattedMessage, ENT_QUOTES));
                echo '</div>';
            }
        }
    } else {
        echo "<p>Сообщений пока нет.</p>";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if ($name && $email && $message) {
        $date = date('Y-m-d H:i:s');
        $name = htmlspecialchars($name, ENT_QUOTES);
        $email = htmlspecialchars($email, ENT_QUOTES);
        $message = htmlspecialchars($message, ENT_QUOTES);
        $newMessage = "Имя: $name\nEmail: $email\nДата: $date\nСообщение:\n$message\n---END---\n";
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