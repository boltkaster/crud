<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') exit("No access");

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM qna WHERE id = ?");
$stmt->execute([$id]);
$qna = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("UPDATE qna SET question = ?, answer = ? WHERE id = ?");
    $stmt->execute([$_POST['question'], $_POST['answer'], $id]);
    header("Location: qna.php");
}
?>

<form method="post">
    Question: <textarea name="question"><?= htmlspecialchars($qna['question']) ?></textarea><br>
    Answer: <textarea name="answer"><?= htmlspecialchars($qna['answer']) ?></textarea><br>
    <button type="submit">Save</button>
</form>
