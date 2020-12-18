<?php
    define("DB_HOST","localhost");
    define("DB_USER","root");
    define("DB_PASSWORD","");
    define("DB_NAME","technow");
    // PDO Attributes
    define("PDOATTRS", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ])

?>