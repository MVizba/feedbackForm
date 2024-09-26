<?php

require 'database.php';

session_start();

$inappropriateWords = [
    'fuck',
    'idiot',
    'sex',
    'drugs',
    'drug',
    'frog',
];

function censorMessage($message, $words)
{
    foreach ($words as $word) {
        $message = str_ireplace($word, '***', $message);
    }

    return $message;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST["message"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address");
    }

    $censoredMessage = censorMessage($message, $inappropriateWords);

    setcookie("name", $name, time() + (86400 * 30), "/");
    setcookie("email", $email, time() + (86400 * 30), "/");
    setcookie("message", $message, time() + (86400 * 30), "/");

    try {
        $sql = "INSERT INTO feedback (name, email, message, created_at) VALUES (:name, :email, :message, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'message' => $censoredMessage
        ]);
        echo "Thank you $name. Your feedback submitted successfully!";
    } catch (PDOException $e) {
        die("Failed to submit feedback: " . $e->getMessage());
    }
} else {
    echo "Please submit the form.";
}
