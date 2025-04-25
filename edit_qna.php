<?php
require 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("UPDATE qna SET question = ?, answer = ? WHERE id = ?");
    $stmt->execute([$_POST['question'], $_POST['answer'], $_POST['id']]);
    header("Location: qna.php");
    exit();
}

// Get current Q&A data
$stmt = $pdo->prepare("SELECT * FROM qna WHERE id = ?");
$stmt->execute([$_GET['id']]);
$item = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Q&A</title>
</head>
<body>

<h1>Edit Q&A</h1>

<form method="post">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">

    <textarea name="question" required><?= htmlspecialchars($item['question']) ?></textarea><br>
    <textarea name="answer" required><?= htmlspecialchars($item['answer']) ?></textarea><br>

    <button type="submit">Update</button>
    <a href="qna.php">Cancel</a>
</form>

</body>
</html>