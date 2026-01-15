<?php
// Alle Variablen definieren und leere Werte zuweisen
$name = $personen = $date = $mail = $phone = $anmerkungen = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $personen = test_input($_POST["personen"]);
    $date = test_input($_POST["date"]);
    $mail = test_input($_POST["mail"]);
    $phone = test_input($_POST["phone"]);
    $anmerkungen = test_input($_POST["tipp"]);
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <!-- Local CSS -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reservieren.css">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="favicon_io/site.webmanifest">

    <title>Café für Studierende</title>
</head>

<body class="page-home">
    <header id="header">
        <div class="top-right">
            <a href="reservieren.html" class="feature-link" id="reservieren-link">RESERVIEREN</a>

            <span>
                Öffnungszeiten: <br>
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
                <a href="index.html" id="home-nav" class="nav-item">HOME</a>
                <a href="menu.html" id="menu-nav" class="nav-item">SPEISEKARTE</a>
                <a href="events.html" id="events-nav" class="nav-item">VERANSTALTUNGEN</a>
                <a href="about.html" id="about-nav" class="nav-item">ÜBER UNS</a>
                <a href="contact.html" id="contact-nav" class="nav-item">KONTAKT</a>
                <a href="forum.php" id="guest-nav" class="nav-item">GÄSTEBUCH</a>
            </div>
        </nav>
    </header>

    <main class="reservieren-page">
        <h1>RESERVIEREN</h1>

        <section id="reservieren">
            <h2>Danke, für deine Reservierung im Studierendencafé StudierBar!</h2>

            <?php

            print "<h3>Deine Reservierung:</h3>";
            $name = $_POST['name'];
            $personen = $_POST['personen'];
            $date = $_POST['date'];
            $mail = $_POST['mail'];
            $phone = $_POST['phone'];
            $anmerkungen = $_POST['tipp'];

            $date_formatted = "unbekannt";
            if (!empty($date)) {
                $d = new DateTime($date);
                // Format: Tag.Monat.Jahr um Stunden:Minuten
                $date_formatted = $d->format('d.m.Y \u\m H:i');
            }

            print "<p>Am <strong>$date_formatted Uhr</strong> für <strong>$personen Person(en)</strong> auf den Namen <strong>$name</strong>.</p>";

            if (!empty($anmerkungen)) {
                print "<p>Anmerkungen: $anmerkungen</p>";
            }

            print "<h4>Deine Kontaktdaten:</h4> 
            <p>Emailadresse: <strong>$mail</strong> <br>
           Telefonnummer: <strong>$phone</strong> </p>";

            ?>
            <h3><strong>Wir freuen uns auf deinen Besuch!</strong></h3>
        </section>
    </main>

    <footer>
        <nav class="nav-footer">
            <a href="contact.html" class="feature-link">Kontakt</a>
            <a href="impressum.html" class="feature-link">Impressum</a>
            <a href="datenschutz.html" class="feature-link">Datenschutzerklärung</a>
        </nav>
        <div class="divider"></div>
        <p>Projektarbeit in "Grundlagen der Web-Technologien"</p>
        <p>
            Gruppe 3: Daniil Bavin, Lia Duppel, Sarah Hofmann, Vladislav Slugin
            <br>Wintersemester 2025/2026
        </p>
        <p>Fachbereich: Informatik - Hochschule Trier</p>

        <a href="index.html"><img src="images/logo/logo_mittext.png" class="logo" alt="Logo des Studierendecafé StudierBar"></a>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/formulare.js"></script>
</body>

</html>