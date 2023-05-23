<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>PRI add form</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <main>
        <nav class="container">
            <header class="d-flex justify-content-center py-3">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="index.php"><img src="animated.svg" alt="Your SVG Image" class="nav-link active" aria-current="page"></img></a></li>
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="addForm.php" class="nav-link">add Formular</a></li>
                    <li class="nav-item"><a href="addXML.php" class="nav-link">add XML</a></li>
                    <li class="nav-item"><a href="mariaDB.php" class="nav-link">MariaDB</a></li>
                </ul>
            </header>
        </nav>
        <section>
            <h1>Input Form</h1>
        </section>
        <section>
            <?php
            include("functions.php");
            $kek = 0;
            if (isset($_POST['submit'])) {

                // create new SimpleXMLElement object
                $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><fakulta></fakulta>');
                $xml->addAttribute("děkan", $_POST["dekan"]);

                for ($katedra = 0; $katedra < $_GET["katedra"]; $katedra++) {
                    // create katedra element
                    $katedraElement = $xml->addChild('katedra');
                    $katedraElement->addAttribute("zkratka_katedry", $_POST["katedra" . $katedra]);
                    $katedraElement->addAttribute("webové_stránky", $_POST["url" . $katedra]);

                    // create vedoucí element
                    $vedouciElement = $katedraElement->addChild('vedoucí');
                    $vedouciElement->addChild('jméno', $_POST["vedouci" . $katedra]);
                    $vedouciElement->addChild('telefon', $_POST["vedoucicislo" . $katedra]);

                    // create zaměstnanci element
                    $zamestnanciElement = $katedraElement->addChild('zaměstnanci');
                    for ($i = 0; $i < $_GET["zamestnanci"]; $i++) {
                        $zamestnanecElement = $zamestnanciElement->addChild('zaměstnanec');
                        $zamestnanecElement->addChild('jméno', $_POST["jmeno" . $katedra . $i]);
                        if (isset($_POST["email" . $katedra . $i]) and $_POST["email" . $katedra . $i] != "") {
                            $zamestnanecElement->addChild('email', $_POST["email" . $katedra . $i]);
                        }
                        if (isset($_POST["pozice" . $katedra . $i]) and $_POST["pozice" . $katedra . $i] != "") {
                            $poziceElement = $zamestnanecElement->addChild('pozice');
                            $poziceElement->addChild($_POST["pozice" . $katedra . $i]);
                        }
                    }

                    // create předměty element
                    $predmetyElement = $katedraElement->addChild('předměty');
                    for ($i = 0; $i < $_GET["predmety"]; $i++) {
                        $predmetElement = $predmetyElement->addChild('předmět');
                        $predmetElement->addAttribute("zkratka", $_POST["zkratka" . $katedra . $i]);
                        if (isset($_POST["typ" . $katedra . $i]) and $_POST["typ" . $katedra . $i] != "") {
                            $predmetElement->addAttribute("typ", $_POST["typ" . $katedra . $i]);
                        }
                        $predmetElement->addChild('název', $_POST["nazev" . $katedra . $i]);
                        $predmetElement->addChild('popis', $_POST["popis" . $katedra . $i]);
                    }
                }
                // save for validity
                $xml->asXML('xmls/kek.xml');

                $dom = new DOMDocument();

                // Load the XML file
                $dom->load("xmls/kek.xml");

                if ($dom->schemaValidate('xmls/valid.xsd')) {
                    $kek = 1;

                    // save XML file
                    $count = get_counter_plus_1("xmls");
                    $xml->asXML('xmls/kek' . $count . '.xml');
                } else {
                    $kek = 2;
                }
                unlink("xmls/kek.xml");
            }
            ?>
            <form method="post">
                <?php
                switch ($kek) {
                    case 1:
                        echo '<p class="end-dialog" id="success"><a href="showXML.php?file=kek' . $count . '.xml">XML is valid</a></p>';
                        break;
                    case 2:
                        echo '<p class="end-dialog" id="fail">XML is invalid</p>';
                        break;
                }

                for ($katedra = 0; $katedra < $_GET["katedra"]; $katedra++) {
                    echo '<label for="katedra">Katedra ' . $katedra + 1 . ':</label>';
                    echo '<label for="dekan">Jméno děkana:</label>
                    <input type="text" name="dekan" placeholder="Varady" required>';

                    echo '<label for="katedra">Zkratka katedry:</label>
                    <input type="text" name="katedra' . $katedra . '" placeholder="KI" required>';

                    echo '<label for="url">Webové stránky katedry:</label>
                    <input type="text" name="url' . $katedra . '" placeholder="https://ki.ujep.cz" required>';

                    echo '<label for="vedouci">Vedoucí katedry:</label>
                    <input type="text" name="vedouci' . $katedra . '" placeholder="Jiří Škvor" required>';

                    echo '<label for="vedoucicislo">Číslo na vedoucí katedry:</label>
                    <input type="tel" pattern="+[0-9]{3} [0-9]{3} [0-9]{3} [0-9]{3}" name="vedoucicislo' . $katedra . '" placeholder="+420 123 456 789">';

                    echo '<label for="zamestananci">Zaměstnanci:</label>';

                    for ($i = 0; $i < $_GET["zamestnanci"]; $i++) {
                        echo '<label for="zamestananci">Zaměstnanec ' . $i + 1 . ':</label>';
                        echo '<label for="jmeno">Jmeno:</label>
                        <input type="text" name="jmeno' . $katedra . '' . $i . '" placeholder="Honza Novotný" required>';

                        echo '<label for="email" >Email:</label>
                        <input type="email" name="email' . $katedra . '' . $i . '" placeholder="novotnak@ujep.cz">';

                        echo '<label for="vedoucicislo">Číslo na zaměstnance:</label>
                        <input type="tel" pattern="+[0-9]{3} [0-9]{3} [0-9]{3} [0-9]{3}" name="telefon' . $katedra . '' . $i . '" placeholder="+420 789 456 123">';

                        echo '<label for="pozice" >Pozice:</label>
                        <input type="text" name="pozice' . $katedra . '' . $i . '" placeholder="lektor">';
                    }

                    echo '<label for="predmety">Předměty:</label>';
                    for ($i = 0; $i < $_GET["predmety"]; $i++) {
                        echo '<label for="predmety">Předmět ' . $i + 1 . ':</label>';
                        echo '<label for="zkratka" >Zkratka:</label>
                        <input type="text" name="zkratka' . $katedra . '' . $i . '" placeholder="arp" required>';

                        echo '<label for="typ" >Typ:</label>
                        <input type="text" name="typ' . $katedra . '' . $i . '" placeholder="cvičení">';

                        echo '<label for="název" >Název:</label>
                        <input type="text" name="nazev' . $katedra . '' . $i . '" placeholder="Algoritmizace a programování" required>';

                        echo '<label for="popis" >Popis:</label>
                        <input type="text" name="popis' . $katedra . '' . $i . '" placeholder="V tomto předmětu se dozvíte vše o nou-eskjůel databázích." required>';
                    }
                }
                switch ($kek) {
                    case 0:
                        echo '<input type="submit" name="submit" value="Odeslat">';
                        break;
                    case 1:
                        echo '<p class="end-dialog" id="success"><a href="showXML.php?file=kek' . $count . '.xml">XML is valid</a></p>';
                        break;
                    case 2:
                        echo '<p class="end-dialog" id="fail">XML is invalid</p>';
                        break;
                }
                ?>

            </form>
        </section>
    </main>
</body>

</html>