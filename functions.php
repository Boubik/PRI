<?php
//stop showing errors
error_reporting(E_ERROR | E_PARSE);

/**
 * will return counter +1 from folder and save it
 * @param string $where folder name
 * @return int counter + 1
 */
function get_counter_plus_1(string $where): int
{
    $file = $where . '/count.txt';

    // get count
    $count = get_counter($where);


    // set count
    $count += 1;

    //write count 
    set_counter($where, $count);
    return $count;
}

/**
 * will return counter from folder
 * @param string $where folder name
 * @return int counter
 */
function get_counter(string $where): int
{
    $file = $where . '/count.txt';

    // get count
    $file = fopen($file, "r");

    // Read the contents of the file
    $count = fgets($file);

    // Close the file
    fclose($file);
    return $count;
}

/**
 * will set counter in folder
 * @param string $where folder name
 * @param int $count to set
 */
function set_counter(string $where, int $count): void
{
    $file = $where . '/count.txt';

    // Open the file for writing
    $handle = fopen($file, 'w');

    // Write the data to the file
    fwrite($handle, $count);

    // Close the file
    fclose($handle);
}

/**
 * Will connect to db with config from file config.phh
 * @return PDO Connection to db
 */
function connect_db()
{
    $configs = include('config.php');
    $servername = $configs["servername"];
    $dbname = $configs["dbname"];
    $username = $configs["username"];
    $password = $configs["password"];

    $dsn = "mysql:host=$servername;dbname=$dbname;";
    //connect
    try {
        if (isset($password)) {
            $conn = new PDO($dsn, $username, $password);
        } else {
            $conn = new PDO($dsn, $username);
        }
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $execute = false;
    } catch (PDOException $e) {
        $execute = true;
        $dsn = "mysql:host=$servername;";
        //connect
        try {
            if (isset($password)) {
                $conn = new PDO($dsn, $username, $password);
            } else {
                $conn = new PDO($dsn, $username);
            }
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $execute = false;
            echo "Something goes wrong give us time to fix it";
        }

        $sql = $conn->prepare("SET character SET UTF8");
        $sql->execute();
    }
    return $conn;
}

/**
 * Will connect to db with Config OOP
 * @return PDO Connection to db
 */
function connect_db_oop()
{
    $config = new DB_config("boubik.cz", "PRI", "PRI", "Ujep123456");

    $dsn = "mysql:host=" . $config->get_servername() . ";dbname=" . $config->get_dbname() . ";";
    //connect
    try {
        if (!is_null($config->get_password())) {
            $conn = new PDO($dsn, $config->get_username(), $config->get_password());
        } else {
            $conn = new PDO($dsn, $config->get_username());
        }
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $execute = false;
    } catch (PDOException $e) {
        $execute = true;
        $dsn = "mysql:host=" . $config->get_servername() . ";";
        //connect
        try {
            if (!is_null($config->get_password())) {
                $conn = new PDO($dsn, $config->get_username(), $config->get_password());
            } else {
                $conn = new PDO($dsn, $config->get_username());
            }
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $execute = false;
            echo "Something goes wrong give us time to fix it";
        }

        $sql = $conn->prepare("SET character SET UTF8");
        $sql->execute();
    }
    return $conn;
}

/**
 * Select in SQL db
 * @param PDO Connection to db
 * @param string SQL query
 * @return array Data from db
 */
function select($conn, $sql)
{
    $sql = $conn->prepare($sql);
    $sql->execute();
    $select = $sql->fetchAll();

    return $select;
}

/**
 * Insert in SQL db
 * @param PDO Connection to db
 * @param string SQL query
 * @return int Last ID (ID from insert)
 */
function insert($conn, $sql)
{
    $sql = $conn->prepare($sql);
    $sql->execute();

    return $conn->lastInsertId();
}

/**
 * Update in SQL db
 * @param PDO Connection to db
 * @param string SQL query
 */
function update($conn, $sql)
{
    $sql = $conn->prepare($sql);
    $sql->execute();
}

/**
 * Delete in SQL db
 * @param PDO Connection to db
 * @param string SQL query
 */
function delete($conn, $sql)
{
    $sql = $conn->prepare($sql);
    $sql->execute();
}


/**
 * Check if user exist in db
 * @param PDO Connection to db
 * @param string Username
 * @return bool True - exist False - dosnt exist
 */
function user_exist($conn, $username)
{
    $sql = "SELECT `username` FROM `Users` WHERE `username` = '" . $username . "'";
    $select = select($conn, $sql);
    return (bool)count($select);
}

/**
 * Will login user "in" db
 * @param PDO Connection to db
 * @param string Username
 * @param string Password
 * @return bool True - will login False - will not login
 */
function login($conn, $username, $password)
{
    $sql = "SELECT * FROM `Users` WHERE `username` = '" . $username . "' AND `password` = '" . $password . "'";
    $select = select($conn, $sql);
    return (bool)count($select);
}

/**
 * Will create user in db
 * @param PDO Connection to db
 * @param string Username
 * @param string Password
 */
function create_user($conn, $username, $password)
{
    $sql = "INSERT INTO `Users`(`username`, `password`, `timestamp`) VALUES ('" . $username . "', '" . $password . "', '" . date("Y-m-d H:i:s") . "')";
    insert($conn, $sql);
}


/**
 * Add user to session
 * @param string Username
 * @param string Password
 */
function add_user_to_session($username, $password)
{
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
}

/**
 * Get timestamp of user
 * @param PDO Connection to db
 * @param string Username
 * @param string Password
 * @return bool True - will login False - will not login
 */
function get_timestamp_of__user($conn, $username, $password)
{
    $sql = "SELECT * FROM `Users` WHERE `username` = '" . $username . "' AND `password` = '" . $password . "'";
    $select = select($conn, $sql);
    if (isset($select[0])) {
        return $select[0]["timestamp"];
    } else {
        return null;
    }
}


class DB_config
{
    private static $servername;
    private static $username;
    private static $password;
    private static $dbname;

    /**
     * will return servername
     * @return string servername
     */
    function get_servername()
    {
        return self::$servername;
    }

    /**
     * will return username
     * @return string username
     */
    function get_username()
    {
        return self::$username;
    }

    /**
     * will return password
     * @return string password
     */
    function get_password()
    {
        if (!is_null(self::$password)) {
            return self::$password;
        } else {
            return null;
        }
    }

    /**
     * will return dbname
     * @return string dbname
     */
    function get_dbname()
    {
        return self::$dbname;
    }

    /**
     * constructor
     * @param string servername 
     * @param string username 
     * @param string dbname 
     * @param string password default null
     */
    function __construct($servername, $username, $dbname, $password = null)
    {
        if (!is_null($password)) {
            self::$password = $password;
        }
        self::$servername = $servername;
        self::$username = $username;
        self::$dbname = $dbname;
    }
}
