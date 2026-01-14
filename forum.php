<?php
session_start();

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$csrf = $_SESSION["csrf_token"] ?? "";
if (empty($csrf)) {
  $csrf = bin2hex(random_bytes(16));
  $_SESSION["csrf_token"] = $csrf;
}

$fehler = "";
$flashAction = "";

if (!empty($_SESSION["flash_action"])) {
  $flashAction = (string)$_SESSION["flash_action"];
  unset($_SESSION["flash_action"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Delete entry request
  if (isset($_POST["delete_index"])) {
    $token = $_POST["csrf_token"] ?? "";
    if (!hash_equals($_SESSION["csrf_token"] ?? "", $token)) {
      $fehler = "Ungültige Anfrage (CSRF).";
    } else {
      $datei = "entries.txt";
      $idx = filter_var($_POST["delete_index"], FILTER_VALIDATE_INT);

      if ($idx === false) {
        $fehler = "Ungültiger Eintrag.";
      } elseif (!file_exists($datei)) {
        $fehler = "Datei nicht gefunden.";
      } else {
        $zeilen = file($datei, FILE_SKIP_EMPTY_LINES);
        if ($idx < 0 || $idx >= count($zeilen)) {
          $fehler = "Eintrag existiert nicht mehr.";
        } else {
          array_splice($zeilen, $idx, 1);
          $ok = file_put_contents($datei, implode("", $zeilen), LOCK_EX);
          if ($ok === false) {
            $fehler = "Datei konnte nicht geschrieben werden.";
          } else {
            $_SESSION["flash_action"] = "deleted";
            header("Location: forum.php");
            exit;
          }
        }
      }
    }
  } else {

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
        $_SESSION["flash_action"] = "added";
        header("Location: forum.php");
        exit;
      }
    }
  }
}


$datei = "entries.txt";
$eintraege = array();
$zeilen = array();

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

    <h1 class="guestbook-title">Gästebuch</h1>

    <div class="guestbook-container">

      <?php if ($flashAction === "added"): ?>

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

      <?php elseif ($flashAction === "deleted"): ?>

        <h2 class="guestbook-subtitle">Eintrag gelöscht</h2>

        <div class="forum-topbar">
          <div><span style='color:#4caf50;'>Der Eintrag wurde erfolgreich gelöscht.</span></div>
          <div><a class="btn" href="forum.php">Zum Gästebuch</a></div>
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

        foreach ($eintraege as $displayIdx => $line) {
          // index in original file (before reverse), used for deletion
          $origIndex = $anzahl - 1 - $displayIdx;

          $t = explode("|", $line, 5);
          $datum = $t[0] ?? "";
          $name  = $t[1] ?? "";
          $email = $t[2] ?? "";
          $kategorie = $t[3] ?? "";
          $text  = $t[4] ?? "";


          print "<div class='post'>\n";
          print "  <div class='posthead'>\n";
          print "    <div class='posthead-left'>\n";
          print "      <span><b>Von:</b> <span class='posthead-font'>$name</span></span>\n";
          print "      <span><b>Am:</b> <span class='posthead-font'>$datum</span></span>\n";
          print "      <span><b>Eintrag:</b> $nr</span>\n";
          print "    </div>\n";
          print "    <div class='posthead-right'>\n";
          print "      <form class='delete-form' method='post' action='forum.php' onsubmit=\"return confirm('Eintrag wirklich löschen?');\">\n";
          print "        <input type='hidden' name='csrf_token' value='" . htmlspecialchars($csrf, ENT_QUOTES) . "'>\n";
          print "        <input type='hidden' name='delete_index' value='" . (int)$origIndex . "'>\n";
          print "        <button type='submit' class='delete-btn' aria-label='Eintrag löschen' title='Eintrag löschen'>\n";
          print "          <svg class='delete-icon' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg' aria-hidden='true' focusable='false'>\n";
          print "            <path d='M18.7069 7.79289C19.0974 8.18342 19.0974 8.81658 18.7069 9.20711L15.914 12L18.7069 14.7929C19.0974 15.1834 19.0974 15.8166 18.7069 16.2071C18.3163 16.5976 17.6832 16.5976 17.2926 16.2071L14.4998 13.4142L11.7069 16.2071C11.3163 16.5976 10.6832 16.5976 10.2926 16.2071C9.90212 15.8166 9.90212 15.1834 10.2926 14.7929L13.0855 12L10.2926 9.20711C9.90212 8.81658 9.90212 8.18342 10.2926 7.79289C10.6832 7.40237 11.3163 7.40237 11.7069 7.79289L14.4998 10.5858L17.2926 7.79289C17.6832 7.40237 18.3163 7.40237 18.7069 7.79289Z' fill='currentColor'/>\n";
          print "            <path fill-rule='evenodd' clip-rule='evenodd' d='M6.30958 3.54424C7.06741 2.56989 8.23263 2 9.46699 2H20.9997C21.8359 2 22.6103 2.37473 23.1614 2.99465C23.709 3.61073 23.9997 4.42358 23.9997 5.25V18.75C23.9997 19.5764 23.709 20.3893 23.1614 21.0054C22.6103 21.6253 21.8359 22 20.9997 22H9.46699C8.23263 22 7.06741 21.4301 6.30958 20.4558L0.687897 13.2279C0.126171 12.5057 0.126169 11.4943 0.687897 10.7721L6.30958 3.54424ZM9.46699 4C8.84981 4 8.2672 4.28495 7.88829 4.77212L2.2666 12L7.88829 19.2279C8.2672 19.7151 8.84981 20 9.46699 20H20.9997C21.2244 20 21.4674 19.9006 21.6665 19.6766C21.8691 19.4488 21.9997 19.1171 21.9997 18.75V5.25C21.9997 4.88294 21.8691 4.5512 21.6665 4.32337C21.4674 4.09938 21.2244 4 20.9997 4H9.46699Z' fill='currentColor'/>\n";
          print "          </svg>\n";
          print "        </button>\n";
          print "      </form>\n";
          print "    </div>\n";
          print "  </div>\n";

          print "  <div class='postbody'>\n";
          if ($email != "") {
            print "    <div class='email'>$email</div>\n";
          }
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

    <a href="index.html"><img src="images/logo/logo_mittext.png" class="logo" alt="Logo des Studierendecafé StudierBar"></a>
  </footer>

  <script src="js/script.js"></script>

</body>

</html>