<?php
require_once 'db.php';

// Ajouter une compétence
if (isset($_POST['add_skill'])) {
  $newSkill = trim($_POST['skill_name']);
  if ($newSkill !== '') {
    $stmt = $conn->prepare("INSERT INTO skills (name) VALUES (?)");
    $stmt->bind_param("s", $newSkill);
    $stmt->execute();
    $stmt->close();
  }
}

// Supprimer une compétence
if (isset($_GET['delete'])) {
  $idToDelete = intval($_GET['delete']);
  $conn->query("DELETE FROM skills WHERE id = $idToDelete");
}

// Mettre à jour une compétence
if (isset($_POST['update_skill'])) {
  $updatedName = trim($_POST['updated_name']);
  $skillId = intval($_POST['skill_id']);
  if ($updatedName !== '') {
    $stmt = $conn->prepare("UPDATE skills SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $updatedName, $skillId);
    $stmt->execute();
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CV Lucas Charlé</title>

  <link rel="icon" href="https://github.com/lucascharle/portfolio/blob/main/logo%20uimm.png?raw=true" type="image/png" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <!-- DASHBAR -->
  <nav class="navbar">
    <ul>
      <li><a href="#about">À propos</a></li>
      <li><a href="#experience">Expérience</a></li>
      <li><a href="#skills">Compétences</a></li>
    </ul>
  </nav>

  <div class="logo-container">
    <img src="https://github.com/lucascharle/portfolio/blob/main/logo%20uimm.png?raw=true" alt="Logo UIMM" />
  </div>

  <h1>Lucas Charlé</h1>

  <div class="content" id="about">
    <h4>À propos de moi</h4>
    <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" alt="Ordinateur" class="section-img"/>
    <p>Je suis une personne bienveillante et à l’écoute des autres. Passionné par les nouvelles technologies et la cybersécurité. Toujours motivé à apprendre et à évoluer, je me forme chaque jour pour devenir un professionnel qualifié.</p>
  </div>

  <div class="content" id="experience">
    <h4>Expérience</h4>
    <img src="https://cdn-icons-png.flaticon.com/512/2920/2920037.png" alt="Hacker" class="section-img"/>
    <p>Lors de cette expérience, l’objectif était de simuler une attaque par force brute. Une attaque par force brute teste toutes les combinaisons possibles pour deviner un mot de passe. Un script Python a testé des combinaisons jusqu’à trouver "secret123". Cette simulation m’a permis de mieux comprendre la sécurité informatique.</p>
  </div>

  <div class="content" id="skills">
    <h4>Compétences</h4>
    <img src="https://cdn-icons-png.flaticon.com/512/1055/1055644.png" alt="Compétences" class="section-img"/>
    <div class="skills">
      <?php
      $result = $conn->query("SELECT * FROM skills");
      while ($row = $result->fetch_assoc()) {
        echo "<div class='skill-item'>";
        echo "<span class='skill-badge'>" . htmlspecialchars($row['name']) . "</span>";
        echo "<a href='?delete=" . $row['id'] . "' class='delete-btn'>X</a>";

        echo "<form method='POST' class='edit-form'>
                <input type='hidden' name='skill_id' value='" . $row['id'] . "'>
                <input type='text' name='updated_name' placeholder='Modifier' required>
                <input type='submit' name='update_skill' value='Modifier'>
              </form>";
        echo "</div>";
      }
      ?>
    </div>

    <form method="POST">
      <input type="text" name="skill_name" placeholder="Nouvelle compétence" required>
      <input type="submit" name="add_skill" value="Ajouter">
    </form>
  </div>

  <p class="center">
    <a class="link-button" href="https://formation-industries-ca.fr/" target="_blank">Centre de formation UIMM</a>
  </p>

  <div class="contact-info">
    <p>Lucas Charlé © 2025</p>
  </div>

</body>
</html>

<?php $conn->close(); ?>