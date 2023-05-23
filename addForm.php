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
            <form method="get" action="formular.php">
                <label for="katedra">Počet kateder:</label>
                <input type="number" min=1 name="katedra" value="1" required>

                <label for="zaměstnanci">Počet zaměstnanců:</label>
                <input type="number" min=1 name="zamestnanci" value="1" required>

                <label for="predmety">Počet předmětů:</label>
                <input type="number" min=1 name="predmety" value="1" required>

                <input type="submit" name="submit" value="Odeslat">
            </form>
        </section>
    </main>
</body>

</html>