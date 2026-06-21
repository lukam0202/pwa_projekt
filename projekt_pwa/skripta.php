<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/');

$naslov     = isset($_POST['naslov']) ? trim($_POST['naslov']) : '';
$sazetak    = isset($_POST['sazetak']) ? trim($_POST['sazetak']) : '';
$tekst      = isset($_POST['tekst']) ? trim($_POST['tekst']) : '';
$kategorija = isset($_POST['kategorija']) ? $_POST['kategorija'] : '';
$datum      = date('d.m.Y.');

$arhiva = isset($_POST['archive']) ? 1 : 0;

// Autor je prijavljeni korisnik (ime i prezime), ili "Nepoznato" ako nitko nije prijavljen
$autor = (isset($_SESSION['username']) && isset($_SESSION['ime']) && isset($_SESSION['prezime']))
    ? $_SESSION['ime'] . ' ' . $_SESSION['prezime']
    : 'Nepoznato';

$slikaOdabrana = isset($_FILES['slika']) && $_FILES['slika']['name'] != '';

// Backend provjera - obvezna polja ne smiju ostati prazna (osim ako je JS na formi zaobiđen)
if ($naslov == '' || $sazetak == '' || $tekst == '' || $kategorija == '' || !$slikaOdabrana) {
    header('Location: unos.html');
    exit;
}

$slika = $_FILES['slika']['name'];
$target = UPLPATH . $slika;
move_uploaded_file($_FILES['slika']['tmp_name'], $target);

$sql = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, autor, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_stmt_init($dbc);

if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 'sssssssi', $datum, $naslov, $sazetak, $tekst, $slika, $autor, $kategorija, $arhiva);
    mysqli_stmt_execute($stmt);
}

mysqli_close($dbc);

$nazivKategorije = ($kategorija == 'Ucenje') ? 'Učenje' : $kategorija;
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unity Hub - Prikaz vijesti</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <header>
        <h1>Unity Game Engine Letter</h1>
        <p class="date">Vijest je uspješno spremljena</p>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="kategorija.php?kategorija=Igre">Igre</a></li>
                <li><a href="kategorija.php?kategorija=Ucenje">Učenje</a></li>
                <li><a href="administracija.php">Administracija</a></li>
                <li><a href="unos.html">Unos</a></li>
            </ul>
        </nav>
    </header>

    <main>

        <section class="prikaz-clanka" role="main">

            <p class="category"><?php echo $nazivKategorije; ?></p>
            <h1 class="title"><?php echo $naslov; ?></h1>

            <p class="info">AUTOR: <?php echo $autor; ?></p>
            <p class="info">OBJAVLJENO: <?php echo $datum; ?></p>

            <section class="slika">
                <?php
                if ($slika != '') {
                    echo '<img src="' . UPLPATH . $slika . '" alt="' . $naslov . '">';
                } else {
                    echo '<p>Slika nije odabrana.</p>';
                }
                ?>
            </section>

            <section class="about">
                <p><?php echo $sazetak; ?></p>
            </section>

            <section class="sadrzaj">
                <p><?php echo $tekst; ?></p>
            </section>

        </section>

    </main>

    <footer>
        <p>Luka Mikić</p>
        <p>luka.mikic@tvz.hr</p>
        <p>2026</p>
        <hr>
    </footer>
</body>

</html>