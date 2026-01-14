<?php
// Alle Variablen definieren und leere Werte zuweisen
$name = $personen = $date = $mail = $phone = $anmerkungen = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["fname"]);
    $mail = test_input($_POST["mail"]);
    $betreff = test_input($_POST["betreff"]);
    $nachricht = test_input($_POST["tipp"]);
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet" />

  <!-- Local CSS -->
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/contact.css" />

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png" />
  <link rel="manifest" href="favicon_io/site.webmanifest" />

  <title>Café für Studierende</title>
</head>

<body class="page-home">
  <header id="header">
    <div class="top-right">
      <a href="reservieren.html" class="feature-link" tabindex="0" id="reservieren-link">RESERVIEREN</a>

      <span>
        Öffnungszeiten: <br/>
        Mo. bis Sa. 10 - 20 Uhr
      </span>
    </div>

    <div class="logo-section">
      <div class="logo-container">
        <div class="logo">
          <a href="index.html"><img src="images/logo/logo_mittext.png" id="logo-img" alt="Logo des Studierendecafé StudierBar"></a>
        </div>
      </div>
    </div>

    <nav id="mainnav">
      <div id="menutoggle">
        <div></div>
      </div>
      <div id="nav">
        <a href="index.html" id="home-nav" class="nav-item" tabindex="0">HOME</a>
        <a href="menu.html" id="menu-nav" class="nav-item" tabindex="0">SPEISEKARTE</a>
        <a href="events.html" id="events-nav" class="nav-item" tabindex="0">VERANSTALTUNGEN</a>
        <a href="about.html" id="about-nav" class="nav-item" tabindex="0">ÜBER UNS</a>
        <a href="contact.html" id="contact-nav" class="nav-item" tabindex="0">KONTAKT</a>
        <a href="forum.php" id="guest-nav" class="nav-item" tabindex="0">GÄSTEBUCH</a>
      </div>
    </nav>
  </header>

  <main>
    <h1>KONTAKT</h1>

    <div class="formulare">
      <section id="kontaktformular">
        <!--Kontaktformular-->

        <h2>Schreib uns!</h2>

        <h2>Danke, für deine Nachricht an das Team des Studierendencafés StudierBar!</h2>

            <?php
            print "<h3>Deine Nachricht:</h3>";
            $name = $_POST['fname'];
            $mail = $_POST['mail'];
            $betreff = $_POST['betreff'];
            $nachricht = $_POST['tipp'];

            print "<p>Von: <strong>$name</strong> (<strong>$mail</strong>)<br>  
            Betreff: <strong>$betreff</strong><br> 
            $nachricht.</p>";
            ?>

            <h4><strong>Wir haben deine Nachricht erhalten und melden uns zeitnah bei dir!</strong></h4>
      </section>
    </div>


    <div class="contact-actions">
      <a href="reservieren.html" class="feature-link" tabindex="0">Reservieren</a>
    </div>


  </main>

  <footer>
    <nav class="nav-footer">
      <a href="contact.html" class="feature-link" tabindex="0">Kontakt</a>
      <a href="impressum.html" class="feature-link" tabindex="0">Impressum</a>
      <a href="datenschutz.html" class="feature-link" tabindex="0">Datenschutzerklärung</a>
    </nav>
    <div class="divider"></div>
    <p>Projektarbeit in "Grundlagen der Web-Technologien"</p>
    <p>
      Gruppe 3: Daniil Bavin, Lia Duppel, Sarah Hofmann, Vladislav Slugin
      <br/>Wintersemester 2025/2026
    </p>
    <p>Fachbereich: Informatik - Hochschule Trier</p>

    <a href="index.html"><img src="images/logo/logo_mittext.png" class="logo" alt="Logo des Studierendecafé StudierBar"></a>
  </footer>

  <script src="js/script.js"></script>
  <script src="js/formulare.js"></script>

</body>

</html>