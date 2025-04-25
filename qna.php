<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Q&A System</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/accordion.css">
  <link rel="stylesheet" href="css/banner.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .qna-item { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    .qna-controls { margin-top: 10px; }
    textarea { width: 100%; min-height: 80px; }
  </style>
</head>
<body>
<header class="container main-header">
  <div class="logo-holder">
    <a href="index.php"><img src="img/logo.png" height="40"></a>
  </div>
  <nav class="main-nav">
    <ul class="main-menu" id="main-menu container">
      <li><a href="index.php">Domov</a></li>
      <li><a href="portfolio.php">Portfólio</a></li>
      <li><a href="qna.php">Q&A</a></li>
      <li><a href="kontakt.php">Kontakt</a></li>
    </ul>
    <a class="hamburger" id="hamburger">
      <i class="fa fa-bars"></i>
    </a>
  </nav>
</header>

<main>
  <section class="banner">
    <div class="container text-white">
      <h1>Q&A</h1>
    </div>
  </section>

  <section class="container">
    <?php
    session_start();
    require 'db.php';

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_SESSION['user'])) {
      try {
        $stmt = $pdo->prepare("INSERT INTO qna (question, answer, user_id) VALUES (?, ?, ?)");
        $stmt->execute([
                htmlspecialchars($_POST['question']),
                htmlspecialchars($_POST['answer']),
                $_SESSION['user']['id']
        ]);
        header("Location: qna.php");
        exit();
      } catch (PDOException $e) {
        echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
      }
    }

    // Fetch Q&A
    $qna = $pdo->query("SELECT q.*, u.username FROM qna q LEFT JOIN users u ON q.user_id = u.id ORDER BY q.id DESC")->fetchAll();
    ?>

    <div class="row">
      <div class="col-100 text-center">
        <p><strong><em>Elit culpa id mollit irure sit. Ex ut et ea esse culpa officia ea incididunt elit velit veniam qui.</em></strong></p>
      </div>
    </div>

    <h2>QnA List</h2>

    <?php
    require 'db.php';

    // Handle form submission (CREATE)
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_question'])) {
      $stmt = $pdo->prepare("INSERT INTO qna (question, answer) VALUES (?, ?)");
      $stmt->execute([$_POST['question'], $_POST['answer']]);
      header("Location: qna.php");
      exit();
    }

    // Fetch all Q&A entries
    $qna = $pdo->query("SELECT * FROM qna ORDER BY id DESC")->fetchAll();
    ?>

    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <title>Public Q&A System</title>
      <style>
        .qna-item { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        textarea { width: 100%; min-height: 80px; }
        .actions { margin-top: 10px; }
      </style>
    </head>
    <body>

    <h1>Public Q&A Board</h1>

    <!-- Add New Question Form -->
    <form method="post">
      <h3>Add New Question</h3>
      <textarea name="question" placeholder="Your question" required></textarea><br>
      <textarea name="answer" placeholder="The answer" required></textarea><br>
      <button type="submit" name="add_question">Submit Q&A</button>
    </form>

    <hr>

    <!-- Q&A List -->
    <h2>Existing Questions</h2>
    <?php foreach ($qna as $item): ?>
      <div class="qna-item">
        <h3><?= htmlspecialchars($item['question']) ?></h3>
        <p><?= htmlspecialchars($item['answer']) ?></p>

        <div class="actions">
          <!-- Edit Link -->
          <a href="edit_qna.php?id=<?= $item['id'] ?>">Edit</a>

          <!-- Delete Form -->
          <form action="delete_qna.php" method="post" style="display: inline;">
            <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <button type="submit" onclick="return confirm('Delete this?')">Delete</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>

    </body>
    </html>
