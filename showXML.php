<head>
    <meta charset="UTF-8">
    <title>PRI show XML</title>
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
            <h1>HTML from XML+XSL</h1>
        </section>
        <section>
            <?php
            include("functions.php");

            if (file_exists("xmls/" . $_GET["file"])) {
                $dom = new DOMDocument();

                // Load the XML file
                $dom->load("xmls/" . $_GET["file"]);

                $xslDoc = new DOMDocument();
                $xslDoc->load('xmls/html.xsl');

                $processor = new XSLTProcessor();
                $processor->importStylesheet($xslDoc);

                $htmlDoc = $processor->transformToDoc($dom);
                echo $htmlDoc->saveHTML();
            } else {
                echo "file dosnt exits";
            }
            ?>
        </section>
    </main>
</body>

</html>