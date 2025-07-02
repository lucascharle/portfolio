<?php
require_once 'db.php';

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
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      color: #333;
      padding: 20px;
      line-height: 1.6;
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
      background-color: #ffffff;
      padding: 20px;
      max-width: 700px;
      margin: 20px auto;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    p {
      margin-bottom: 10px;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo-container img {
      width: 80px;
      height: auto;
    }

    .skills {
      text-align: center;
      margin-bottom: 20px;
    }

    .skill-badge {
      display: inline-block;
      background-color: #ddd;
      padding: 5px 10px;
      margin: 5px;
      border-radius: 3px;
      font-size: 0.9em;
    }

    .skill-badge a {
      color: #b30000;
      text-decoration: none;
      margin-left: 8px;
      font-weight: bold;
    }

    .skill-badge a:hover {
      text-decoration: underline;
    }

    form {
      text-align: center;
      margin-top: 15px;
    }

    input[type="text"] {
      padding: 8px 10px;
      width: 200px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-right: 10px;
    }

    input[type="submit"] {
      padding: 8px 15px;
      border: none;
      background-color: #b30000;
      color: #fff;
      border-radius: 3px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #800000;
    }

    .link-button {
      display: inline-block;
      background-color: #333;
      color: #fff;
      padding: 10px 20px;
      text-decoration: none;
      margin: 20px auto;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }

    .link-button:hover {
      background-color: #000;
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