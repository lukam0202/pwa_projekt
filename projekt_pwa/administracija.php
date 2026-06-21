<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/');

$uspjesnaPrijava = null;
$admin = false;
$imeKorisnika = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (isset($_POST['prijava'])) {

    $prijavaImeKorisnika = $_POST['username'];
    $prijavaLozinkaKorisnika = $_POST['lozinka'];

    $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $imeKorisnikaBaza, $lozinkaKorisnika, $levelKorisnika);
        mysqli_stmt_fetch($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($prijavaLozinkaKorisnika, $lozinkaKorisnika)) {
            $uspjesnaPrijava = true;
            $admin = ($levelKorisnika == 1);
            $imeKorisnika = $imeKorisnikaBaza;

            $_SESSION['username'] = $imeKorisnikaBaza;
            $_SESSION['level'] = $levelKorisnika;
        } else {
            $uspjesnaPrijava = false;
        }
    }
}

if (isset($_GET['odjava'])) {
    session_unset();
    session_destroy();
    header('Location: administracija.php');
    exit;
}

$prijavljen = isset($_SESSION['username']);
$jeAdmin = $prijavljen && $_SESSION['level'] == 1;

if (isset($_POST['delete']) && $jeAdmin) {
    $id = (int) $_POST['id'];

    $sql = "DELETE FROM vijesti WHERE id = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
    }
}

if (isset($_POST['update']) && $jeAdmin) {

    $id         = (int) $_POST['id'];
    $naslov     = $_POST['naslov'];
    $sazetak    = $_POST['sazetak'];
    $tekst      = $_POST['tekst'];
    $kategorija = $_POST['kategorija'];
    $arhiva     = isset($_POST['archive']) ? 1 : 0;

    if (isset($_FILES['slika']) && $_FILES['slika']['name'] != '') {
        $slika = $_FILES['slika']['name'];
        move_uploaded_file($_FILES['slika']['tmp_name'], UPLPATH . $slika);

        $sql = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sssssii', $naslov, $sazetak, $tekst, $slika, $kategorija, $arhiva, $id);
            mysqli_stmt_execute($stmt);
        }
    } else {
        $sql = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, kategorija=?, arhiva=? WHERE id=?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssii', $naslov, $sazetak, $tekst, $kategorija, $arhiva, $id);
            mysqli_stmt_execute($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unity Game Engine Letter - Administracija</title>
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

        <?php if ($jeAdmin) { ?>

            <div class="poruka-info">
                <p>Prijavljeni ste kao <strong><?php echo $imeKorisnika; ?></strong> (administrator).</p>
                <a class="odjava" href="administracija.php?odjava=1">Odjava</a>
            </div>

            <div class="naslov">
                <p>Upravljanje vijestima</p>
            </div>

            <?php
            $sql = "SELECT * FROM vijesti ORDER BY id DESC";
            $result = mysqli_query($dbc, $sql);

            while ($row = mysqli_fetch_array($result)) {
                echo '<div class="admin-zapis">';
                echo '<form enctype="multipart/form-data" action="administracija.php" method="POST">';

                echo '<div class="form-item">';
                echo '<label for="naslov">Naslov vijesti:</label>';
                echo '<div class="form-field">';
                echo '<input type="text" name="naslov" class="form-field-textual" value="' . $row['naslov'] . '">';
                echo '</div></div>';

                echo '<div class="form-item">';
                echo '<label for="sazetak">Kratki sadržaj vijesti (do 50 znakova):</label>';
                echo '<div class="form-field">';
                echo '<textarea name="sazetak" cols="30" rows="4" class="form-field-textual">' . $row['sazetak'] . '</textarea>';
                echo '</div></div>';

                echo '<div class="form-item">';
                echo '<label for="tekst">Sadržaj vijesti:</label>';
                echo '<div class="form-field">';
                echo '<textarea name="tekst" cols="30" rows="8" class="form-field-textual">' . $row['tekst'] . '</textarea>';
                echo '</div></div>';

                echo '<div class="form-item">';
                echo '<label for="slika">Slika:</label>';
                echo '<div class="form-field">';
                echo '<input type="file" class="input-text" name="slika">';
                echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '">';
                echo '</div></div>';

                echo '<div class="form-item">';
                echo '<label for="kategorija">Kategorija vijesti:</label>';
                echo '<div class="form-field">';
                echo '<select name="kategorija" class="form-field-textual">';
                echo '<option value="Igre"' . ($row['kategorija'] == 'Igre' ? ' selected' : '') . '>Igre</option>';
                echo '<option value="Ucenje"' . ($row['kategorija'] == 'Ucenje' ? ' selected' : '') . '>Učenje</option>';
                echo '</select>';
                echo '</div></div>';

                echo '<div class="form-item">';
                echo '<label>Sakrij vijest (arhiva):';
                echo '<div class="form-field">';
                if ($row['arhiva'] == 0) {
                    echo '<input type="checkbox" name="archive">';
                } else {
                    echo '<input type="checkbox" name="archive" checked>';
                }
                echo '</div></label></div>';

                echo '<div class="form-item">';
                echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                echo '<button type="reset">Poništi</button>';
                echo '<button type="submit" name="update">Izmijeni</button>';
                echo '<button type="submit" name="delete">Izbriši</button>';
                echo '</div>';

                echo '</form>';
                echo '<hr>';
                echo '</div>';
            }
            ?>

        <?php } elseif ($prijavljen && !$jeAdmin) { ?>

            <div class="poruka-info">
                <p>Bok <?php echo $imeKorisnika; ?>! Uspješno ste prijavljeni, ali nemate prava pristupa
                    administratorskom dijelu stranice.</p>
                <a class="odjava" href="administracija.php?odjava=1">Odjava</a>
            </div>

        <?php } else { ?>

            <div class="naslov">
                <p>Prijava</p>
            </div>

            <?php if ($uspjesnaPrijava === false) { ?>
                <div class="poruka-info">
                    <p class="bojaPoruke">Pogrešno korisničko ime i/ili lozinka. Morate se prvo
                        <a href="registracija.php">registrirati</a>.</p>
                </div>
            <?php } ?>

            <form action="administracija.php" method="POST">
                <div class="form-item">
                    <label for="username">Korisničko ime</label>
                    <div class="form-field">
                        <input type="text" name="username" id="username" class="form-field-textual">
                    </div>
                </div>
                <div class="form-item">
                    <label for="lozinka">Lozinka</label>
                    <div class="form-field">
                        <input type="password" name="lozinka" id="lozinka" class="form-field-textual">
                    </div>
                </div>
                <div class="form-item">
                    <button type="submit" name="prijava">Prijava</button>
                </div>
                <p>Nemate korisnički račun? <a href="registracija.php">Registrirajte se</a>.</p>
            </form>

        <?php } ?>

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