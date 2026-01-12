<?php
session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$fehler = "";
$erfolg = false;

if (!empty($_SESSION["flash_erfolg"])) {
    $erfolg = true;
    unset($_SESSION["flash_erfolg"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = "";
    $email = "";
    $kategorie = "";
    $inhalt = "";

    if (!isset($_POST["name"]) || empty($_POST["name"])) {
        $fehler .= "Name ist ein Pflichtfeld.<br>";
    } else {
        $name = test_input($_POST["name"]);
    }

    if (isset($_POST["email"]) && !empty($_POST["email"])) {
      $email = test_input($_POST["email"]);

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $fehler .= "Ungültiges E-Mail-Format.<br>";
      }
    }

    if (!isset($_POST["kategorie"]) || empty($_POST["kategorie"])) {
        $fehler .= "Kategorie ist ein Pflichtfeld.<br>";
    } else {
        $kategorie = test_input($_POST["kategorie"]);
    }

    if (!isset($_POST["inhalt"]) || empty($_POST["inhalt"])) {
        $fehler .= "Inhalt ist ein Pflichtfeld.<br>";
    } else {
        $inhalt_raw = trim($_POST["inhalt"]);
        $inhalt_raw = htmlspecialchars($inhalt_raw);
        $inhalt = str_replace(array("\r\n", "\n", "\r"), "<br>", $inhalt_raw);
    }

    if (empty($fehler)) {
        $name      = str_replace("|", " ", $name);
        $email     = str_replace("|", " ", $email);
        $kategorie = str_replace("|", " ", $kategorie);
        $inhalt    = str_replace("|", " ", $inhalt);

        $datum = date("d.m.Y") . " um " . date("H:i:s");

        $eintrag = $datum . "|" . $name . "|" . $email . "|" . $kategorie . "|" . $inhalt . "\n";

        $ergebnis = file_put_contents("entries.txt", $eintrag, FILE_APPEND | LOCK_EX);

        if ($ergebnis === false) {
            $fehler = "Datei konnte nicht geschrieben werden.";
        } else {
            $_SESSION["flash_erfolg"] = true;
            header("Location: forum.php");
            exit;
        }
    }
}


$datei = "entries.txt";
$eintraege = array();

if (file_exists($datei)) {
    $zeilen = file($datei, FILE_SKIP_EMPTY_LINES);
    $eintraege = $zeilen;
}

$anzahl = count($eintraege);
$eintraege = array_reverse($eintraege);
?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Schriftart -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet" />

  <!-- Styles -->
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/forum.css?v=1" />

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
      <a href="reservieren.html" class="feature-link" id="reservieren-link" tabindex="0">RESERVIEREN</a>

      <span>
        Öffnungszeiten: <br />
        Mo. bis Sa. 10 - 20 Uhr
      </span>
    </div>

    <div class="logo-section">
      <div class="logo-container">
        <div class="logo">
          <img src="images/logo/logo_mittext.png" id="logo-img" alt="Logo des Studierendecafé Studierbar" />
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
        <a href="guest.html" id="guest-nav" class="nav-item" tabindex="0">GÄSTEBUCH</a>
      </div>
    </nav>
  </header>

  
  <main>

    <h1 class="guestbook-title">Gästebuch</h1>

    <div class="guestbook-container">

      <?php if ($erfolg): ?>

        <h2 class="guestbook-subtitle">Eintrag hinzugefügt</h2>
        
        <div class="forum-topbar">
          <div><span style='color:#4caf50;'>Ihr Eintrag wurde erfolgreich gespeichert!</span></div>
          <div><a class="btn" href="forum.php">Zum Gästebuch</a></div>
        </div>

        <div class='post'>
          <div class='posthead'>
            <span><b>Status:</b> <span class='hallo'>Erfolgreich</span></span>
          </div>
          <div class='postbody'>
            <div class='msg'>Vielen Dank für Ihren Eintrag!</div>
          </div>
        </div>

      <?php elseif (!empty($fehler)): ?>

        <h1 class="guestbook-title">Fehler beim Hinzufügen</h1>

        <div class="forum-topbar">
          <div><span style='color:red;'><?php print $fehler; ?></span></div>
          <div><a class="btn" href="guest.html">Zurück zum Formular</a></div>
        </div>

      <?php else: ?>

        <div class="forum-topbar">
          <div>Das Gästebuch hat <?= $anzahl ?>
            <?php if ($anzahl === 1): ?>
              Beitrag
            <?php else: ?>
              Beiträge
            <?php endif; ?>
          </div>
          <div><a class="btn" href="guest.html">Neuer Eintrag</a></div>
        </div>

      <?php
      $nr = $anzahl;

      foreach ($eintraege as $line) {
        $t = explode("|", $line, 5);
        $datum = $t[0] ?? "";
        $name  = $t[1] ?? "";
        $email = $t[2] ?? "";
        $kategorie = $t[3] ?? "";
        $text  = $t[4] ?? "";


        print "<div class='post'>\n";
        print "  <div class='posthead'>\n";
        print "    <span><b>Von:</b> <span class='posthead-font'>$name</span></span>\n";
        print "    <span><b>Am:</b> <span class='posthead-font'>$datum</span></span>\n";
        print "    <span><b>Eintrag:</b> $nr</span>\n";
        print "  </div>\n";

        print "  <div class='postbody'>\n";
        if ($email != "") { print "    <div class='email'>$email</div>\n"; }
        print "    <div><b>Kategorie:</b> <span class='kategorie-font'>$kategorie</span></div>\n";
        print "    <div class='msg'>$text</div>\n";
        print "  </div>\n";
        print "</div>\n";

        $nr--;
      }
      ?>
      <?php endif; ?>

    </div>
  </main>

  <!--FOOTER-->
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
      <br />Wintersemester 2025/2026
    </p>
    <p>Fachbereich: Informatik - Hochschule Trier</p>

    <img src="images/logo/logo_mittext.png" class="logo" alt="" />
  </footer>

  <script src="js/script.js"></script>

</body>
</html>
