<?php
include 'connect.php';

$registriranKorisnik = false;
$msg = '';

if (isset($_POST['registracija'])) {

    $ime      = $_POST['ime'];
    $prezime  = $_POST['prezime'];
    $username = $_POST['username'];
    $lozinka  = $_POST['pass'];
    $lozinkaPonovljena = $_POST['passRep'];
    $razina   = 0;

    if ($lozinka !== $lozinkaPonovljena) {

        $msg = 'Unesene lozinke se ne podudaraju!';

    } else {

        $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);

        $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }

        if (mysqli_stmt_num_rows($stmt) > 0) {

            $msg = 'Korisničko ime već postoji!';

        } else {

            $sql = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($dbc);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt);
                $registriranKorisnik = true;
            }
        }
    }
}

mysqli_close($dbc);
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unity Game Engine Letter - Registracija</title>
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

        <div class="naslov">
            <p>Registracija</p>
        </div>

        <?php if ($registriranKorisnik) { ?>

            <div class="poruka-info">
                <p>Korisnik je uspješno registriran! Sada se možete <a href="administracija.php">prijaviti</a>.</p>
            </div>

        <?php } else { ?>

            <section role="main">
                <form action="registracija.php" method="POST">

                    <div class="form-item">
                        <label for="ime">Ime:</label>
                        <div class="form-field">
                            <input type="text" name="ime" id="ime" class="form-field-textual">
                        </div>
                        <span id="porukaIme" class="bojaPoruke"></span>
                    </div>

                    <div class="form-item">
                        <label for="prezime">Prezime:</label>
                        <div class="form-field">
                            <input type="text" name="prezime" id="prezime" class="form-field-textual">
                        </div>
                        <span id="porukaPrezime" class="bojaPoruke"></span>
                    </div>

                    <div class="form-item">
                        <label for="username">Korisničko ime:</label>
                        <div class="form-field">
                            <input type="text" name="username" id="username" class="form-field-textual">
                        </div>
                        <span id="porukaUsername" class="bojaPoruke">
                            <?php echo $msg; ?>
                        </span>
                    </div>

                    <div class="form-item">
                        <label for="pass">Lozinka:</label>
                        <div class="form-field">
                            <input type="password" name="pass" id="pass" class="form-field-textual">
                        </div>
                        <span id="porukaPass" class="bojaPoruke"></span>
                    </div>

                    <div class="form-item">
                        <label for="passRep">Ponovite lozinku:</label>
                        <div class="form-field">
                            <input type="password" name="passRep" id="passRep" class="form-field-textual">
                        </div>
                        <span id="porukaPassRep" class="bojaPoruke"></span>
                    </div>

                    <div class="form-item">
                        <button type="submit" name="registracija" id="slanje">Registracija</button>
                    </div>

                </form>
            </section>

            <script type="text/javascript">
                document.getElementById("slanje").onclick = function (event) {

                    var slanjeForme = true;

                    var poljeIme = document.getElementById("ime");
                    if (poljeIme.value.length == 0) {
                        slanjeForme = false;
                        poljeIme.style.border = "1px dashed red";
                        document.getElementById("porukaIme").innerHTML = "Unesite ime!";
                    } else {
                        poljeIme.style.border = "1px solid green";
                        document.getElementById("porukaIme").innerHTML = "";
                    }

                    var poljePrezime = document.getElementById("prezime");
                    if (poljePrezime.value.length == 0) {
                        slanjeForme = false;
                        poljePrezime.style.border = "1px dashed red";
                        document.getElementById("porukaPrezime").innerHTML = "Unesite prezime!";
                    } else {
                        poljePrezime.style.border = "1px solid green";
                        document.getElementById("porukaPrezime").innerHTML = "";
                    }

                    var poljeUsername = document.getElementById("username");
                    if (poljeUsername.value.length == 0) {
                        slanjeForme = false;
                        poljeUsername.style.border = "1px dashed red";
                        document.getElementById("porukaUsername").innerHTML = "Unesite korisničko ime!";
                    } else {
                        poljeUsername.style.border = "1px solid green";
                    }

                    var poljePass = document.getElementById("pass");
                    var poljePassRep = document.getElementById("passRep");
                    if (poljePass.value.length == 0 || poljePassRep.value.length == 0 || poljePass.value != poljePassRep.value) {
                        slanjeForme = false;
                        poljePass.style.border = "1px dashed red";
                        poljePassRep.style.border = "1px dashed red";
                        document.getElementById("porukaPass").innerHTML = "Lozinke nisu iste!";
                        document.getElementById("porukaPassRep").innerHTML = "Lozinke nisu iste!";
                    } else {
                        poljePass.style.border = "1px solid green";
                        poljePassRep.style.border = "1px solid green";
                        document.getElementById("porukaPass").innerHTML = "";
                        document.getElementById("porukaPassRep").innerHTML = "";
                    }

                    if (slanjeForme != true) {
                        event.preventDefault();
                    }
                };
            </script>

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