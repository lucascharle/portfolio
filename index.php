<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio";


$conn = new mysqli($servername, $username, $password);


if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}


$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");


$conn->select_db($dbname);


$conn->query("CREATE TABLE IF NOT EXISTS skills (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
)");


$result = $conn->query("SELECT COUNT(*) AS total FROM skills");
$row = $result->fetch_assoc();
if ($row['total'] == 0) {
  $conn->query("INSERT INTO skills (name) VALUES 
  ('Sérieux'), ('Motivé'), ('À l\'écoute'), ('Déterminé')");
}

if (isset($_POST['add_skill'])) {
  $newSkill = trim($_POST['skill_name']);
  if ($newSkill !== '') {
    $stmt = $conn->prepare("INSERT INTO skills (name) VALUES (?)");
    $stmt->bind_param("s", $newSkill);
    $stmt->execute();
    $stmt->close();
  }
}

if (isset($_GET['delete'])) {
  $idToDelete = intval($_GET['delete']);
  $conn->query("DELETE FROM skills WHERE id = $idToDelete");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CV Lucas Charlé</title>


  <link rel="icon" href="https://github.com/lucascharle/portfolio/blob/main/logo%20uimm.png?raw=true" type="image/png" />

  <style>

    * {
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      color: #333;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #b30000;
      margin-bottom: 20px;
    }

    h4 {
      text-align: center;
      color: #333;
      margin-bottom: 10px;
    }

    .content {
      background: white;
      padding: 20px;
      max-width: 700px;
      margin: 20px auto;
    }

    p {
      margin-bottom: 10px;
    }

    .degueu {
      color: brown;
      font-weight: bold;
    }

    .skills {
      text-align: center;
      margin-bottom: 10px;
    }

    .skill-badge {
      display: inline-block;
      background: #ddd;
      padding: 5px 10px;
      margin: 5px;
    }

    .skill-badge a {
      color: red;
      text-decoration: none;
      margin-left: 5px;
    }

    form {
      text-align: center;
      margin-top: 10px;
    }

    input[type="text"] {
      padding: 5px;
    }

    input[type="submit"] {
      padding: 5px 10px;
    }

    .link-button {
      display: inline-block;
      background: #333;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      margin: 20px auto;
    }

    .link-button:hover {
      background: #000;
    }


    .logo-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo-container img {
      width: 80px;
    }

    .contact-info {
      text-align: center;
      font-size: 0.8em;
      margin-top: 30px;
      color: #555;
    }
  </style>
</head>

<body>

  <div class="logo-container">
    <img src="https://github.com/lucascharle/portfolio/blob/main/logo%20uimm.png?raw=true" alt="Logo UIMM" />
  </div>


  <h1>Lucas Charlé</h1>

  <div class="content">
    <h4>À propos de moi</h4>
    <p>Je suis une personne bienveillante et à l’écoute des autres. Passionné par les nouvelles technologies et la cybersécurité. Toujours motivé à apprendre et à évoluer, je me forme chaque jour pour devenir un professionnel qualifié.</p>
  </div>

  <div class="content">
    <h4>Expérience</h4>
    <p>Lors de cette expérience, l’objectif était de simuler une attaque par force brute. Une attaque par force brute teste toutes les combinaisons possibles pour deviner un mot de passe. Un script Python a testé des combinaisons jusqu’à trouver "secret123". Cette simulation m’a permis de mieux comprendre la sécurité informatique.</p>
  </div>


  <div class="content">
    <h4>Compétences</h4>
    <div class="skills">
      <?php
      $result = $conn->query("SELECT * FROM skills");
      while ($row = $result->fetch_assoc()) {
        echo "<span class='skill-badge'>" . htmlspecialchars($row['name']) .
        " <a href='?delete=" . $row['id'] . "'>X</a></span>";
      }
      ?>
    </div>

    <form method="POST">
      <input type="text" name="skill_name" placeholder="Nouvelle compétence" required>
      <input type="submit" name="add_skill" value="Ajouter">
    </form>
  </div>

  <p style="text-align: center;">
    <a class="link-button" href="https://formation-industries-ca.fr/" target="_blank">Centre de formation UIMM</a>
  </p>

  <div class="contact-info">
    <p>Lucas Charlé © 2025</p>
  </div>

</body>
</html>
<?php $conn->close(); ?>
