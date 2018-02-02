<?php
/*
 * DBConnection Helper Class
 */
class DBConnect {

    function DBConnect() {
        $serverName = "localhost";
        $userName = "root";
        $pwd = "c4916a6b2e2b4286e1ae91bc79bafb65cde9973edafe0544";
        $db = "phone_book";

        $conn = mysqli_connect($serverName, $userName, $pwd, $db);
        if (!$conn) {
            die("Connection Failed: " . mysqli_connect_error());
        }
        return $conn;
    }
  
}
