<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>PRI add XML</title>
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
            <h1>Input Form XML</h1>
        </section>
        <section>
            <?php
            include("functions.php");
            if (isset($_POST['submit'])) {
                // save for validity
                file_put_contents("xmls/kek.xml", $_POST["xml"]);

                $dom = new DOMDocument();

                // Load the XML file
                $dom->load("xmls/kek.xml");


                if ($dom->schemaValidate('xmls/valid.xsd')) {
                    echo 'XML is valid';

                    // save XML file
                    $count = get_counter_plus_1("xmls");
                    file_put_contents('xmls/kek' . $count . '.xml', $_POST["xml"]);

                    /*$xslDoc = new DOMDocument();
                    $xslDoc->load('xmls/html.xsl');

                    $processor = new XSLTProcessor();
                    $processor->importStylesheet($xslDoc);

                    $htmlDoc = $processor->transformToDoc($dom);
                    echo $htmlDoc->saveHTML();*/
                } else {
                    echo 'XML is invalid';
                }
                unlink("xmls/kek.xml");
            }
            ?>
            <form method="post">
                <label for="xml">Input XML:</label>
                <textarea name="xml" id="xml" placeholder='<?xml version="1.0"?>' required></textarea>

                <input type="submit" name="submit" value="Odeslat">
            </form>
        </section>
    </main>
</body>

</html>