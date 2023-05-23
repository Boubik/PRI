<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>PRI</title>
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
            <h1>Index</h1>
        </section>
        <section>
            <?php
            $files = glob("./xmls/kek*.xml");

            foreach ($files as $file) {
                $file = explode("/", $file);
                echo '<p><a href="showXML.php?file=' . end($file) . '">' . end($file) . '</a></p>'; // You can modify this line to suit your needs
            }
            ?>
        </section>
    </main>
</body>

</html>