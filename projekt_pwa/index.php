<?php
include 'connect.php';
define('UPLPATH', 'img/');

function ispisiVijesti($dbc, $kategorija, $limit)
{
    $sql = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = ? ORDER BY id DESC LIMIT ?";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'si', $kategorija, $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $brojZapisa = 0;

        while ($row = mysqli_fetch_array($result)) {
            $brojZapisa++;
            echo '<article>';
            echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '">';
            echo '<h4><a href="clanak.php?id=' . $row['id'] . '">' . $row['naslov'] . '</a></h4>';
            echo '<p>' . $row['sazetak'] . '</p>';
            echo '</article>';
        }

        if ($brojZapisa == 0) {
            echo '<p>Trenutno nema unesenih vijesti u ovoj kategoriji.</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unity Game Engine Letter</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <header>
        <h1>Unity Game Engine Letter</h1>
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

        <section id="igre">
            <h2 class="section-title">Igre</h2>
            <div class="articles">
                <?php ispisiVijesti($dbc, 'Igre', 3); ?>
            </div>
        </section>

        <section id="ucenje">
            <h2 class="section-title">Učenje</h2>
            <div class="articles">
                <?php ispisiVijesti($dbc, 'Ucenje', 3); ?>
            </div>
        </section>

    </main>

    <footer>
        <p>Luka Mikić</p>
        <p>luka.mikic14@gmail.com</p>
        <p>2026</p>
        <hr>
    </footer>
</body>

</html>
<?php mysqli_close($dbc); ?>