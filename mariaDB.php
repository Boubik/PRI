<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>PRI</title>
    <link rel="stylesheet" href="styles.css">
    <script src="js/sha3.js"></script>
    <script type="text/javascript">
        function changePasswords() {
            if (document.getElementById("password").value.length >= 3) {
                var hash = CryptoJS.SHA3(document.getElementById("password").value, {
                    outputLength: 512
                });
                document.getElementById("password").value = hash;
            }
        }
    </script>
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
            <h1>MariaDB</h1>
        </section>
        <section>
            <?php
            include('functions.php');
            session_start();
            $conn = connect_db_oop();
            if (isset($_POST["submit"]) and isset($_POST["username"]) and isset($_POST["username"])) {
                $timestamp = get_timestamp_of__user($conn, filter_input(INPUT_POST, "username"), filter_input(INPUT_POST, "password"));
                if (user_exist($conn, filter_input(INPUT_POST, "username"))) {
                    if (login($conn, filter_input(INPUT_POST, "username"), filter_input(INPUT_POST, "password"))) {
                        add_user_to_session(filter_input(INPUT_POST, "username"), filter_input(INPUT_POST, "password"));
                    } else {
                        echo "bad password";
                    }
                } else {
                    create_user($conn, filter_input(INPUT_POST, "username"), filter_input(INPUT_POST, "password"));
                    add_user_to_session(filter_input(INPUT_POST, "username"), filter_input(INPUT_POST, "password"));
                }
                unset($_POST["submit"]);
            } else {
                session_destroy();
            }
            ?>
            <form method="post" onsubmit="changePasswords()">
                <label for="Userrname">Userrname:</label>
                <input type="userrname" name="username" placeholder="Userrname" required>

                <label for="Password">Password:</label>
                <input type="password" id="password" min=3 name="password" placeholder="Password" required>

                <input type="submit" name="submit" value="Odeslat">
            </form>
            <p>
                <?php
                if (isset($timestamp) and !is_null($timestamp)) {
                    echo "User Creted: " . $timestamp;
                }
                ?>
            </p>
            <p>
                Session: <?php print_r($_SESSION) ?>
            </p>
        </section>
    </main>
</body>

</html>