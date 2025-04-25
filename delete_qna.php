<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("DELETE FROM qna WHERE id = ?");
    $stmt->execute([$_POST['id']]);
}

header("Location: qna.php");
exit();
?>