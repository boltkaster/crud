<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') exit("No access");

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM qna WHERE id = ?");
$stmt->execute([$id]);
header("Location: qna.php");
