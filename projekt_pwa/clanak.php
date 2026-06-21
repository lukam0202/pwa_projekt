<?php
include 'connect.php';
define('UPLPATH', 'img/');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sql = "SELECT * FROM vijesti WHERE id = ?";
$stmt = mysqli_stmt_init($dbc);
$row = false;

if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
}

$nazivKategorije = '';
if ($row) {
    $nazivKategorije = ($row['kategorija'] == 'Ucenje') ? 'Učenje' : $row['kategorija'];
}
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unity Game Engine Letter<?php echo $row ? ' - ' . $row['naslov'] : ''; ?></title>
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

        <?php if ($row) { ?>

            <section class="prikaz-clanka" role="main">

                <p class="category"><?php echo $nazivKategorije; ?></p>
                <h1 class="title"><?php echo $row['naslov']; ?></h1>

                <p class="info">AUTOR: <?php echo $row['autor']; ?></p>
                <p class="info">OBJAVLJENO: <?php echo $row['datum']; ?></p>

                <section class="slika">
                    <img src="<?php echo UPLPATH . $row['slika']; ?>" alt="<?php echo $row['naslov']; ?>">
                </section>

                <section class="about">
                    <p><i><?php echo $row['sazetak']; ?></i></p>
                </section>

                <section class="sadrzaj">
                    <p><?php echo $row['tekst']; ?></p>
                </section>

            </section>

        <?php } else { ?>

            <p>Tražena vijest ne postoji.</p>

        <?php } ?>

    </main>

    <footer>
        <p>Luka Mikić</p>
        <p>luka.mikic@tvz.hr</p>
        <p>2026</p>
        <hr>
    </footer>
</body>

</html>
<?php mysqli_close($dbc); ?>