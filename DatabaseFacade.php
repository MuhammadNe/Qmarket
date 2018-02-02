<?php

include_once 'DBConnect.php'; // database helper

class PhoneBook {

    public $dbConn; // MySQL Connection Variable

    function PhoneBook() {
        $dbConnObj = new DBConnect();
        $this->dbConn = $dbConnObj->DBConnect();
    }

    /*
     * main funcion that calls the function for phone book action
     * e.g. Load Book, Insert, Edit, Delete
     */

    function main($function = "", $item = array(), $previousItem = array()) {

        switch ($function) :
            case 'LoadBook':
                $this->loadBook();
                break;
            case 'AddEntry':
                $this->addEntry($item);
                break;
            case 'EditEntry':
                $this->editEntry($item, $previousItem);
                break;
            case 'DeleteEntry':
                $this->deleteEntry($item);
                break;
        endswitch;

        $this->dbConn->close();
    }

    /*
     * Function that loads the book from DB
     */

    function loadBook() {

        $selectQuery = "select name, phoneNumber, email from book;";
        $result = mysqli_query($this->dbConn, $selectQuery);
        if (!$result) { // checks if error happened, return error message
            $responseErr = array("code" => "400", "result" => "Error Loading Book");
            header("Content-Type: application/json");
            echo json_encode($responseErr);
            die();
        }
        $resultArr = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $resultArr[] = $row;
            }
        }
        header("Content-Type: application/json");
        echo json_encode($resultArr);
    }

    /*
     * Function that adds a new entry to the phone book DB  
     */

    function addEntry($item) {


        if (count($item) > 0) {

            $name = $item['name'];
            $phoneNumber = $item['phoneNumber'];
            $email = $item['email'];

            //add Array\n(\n    [name] => 111\n    [phoneNumber] => 222\n    [email] => 333\n)
            // First check if the phone already exist in the DB, if yes then don't add it
            try {
                $selectStatement = $this->dbConn->prepare("select * from book where phoneNumber=?");
                $selectStatement->bind_param('d', $phoneNumber);
                $phoneNumber = $item['phoneNumber'];
                $selectStatement->execute();
                $selectStatement->store_result();

                // if phone exists then don't add it
                if ($selectStatement->num_rows > 0) {
                    $responseErr = array("code" => "400", "result" => "Phone Number Already Exists");
                } else {
                    // prepare the insert statement to add the new entry
                    $insertStatement = $this->dbConn->prepare("insert into book (name, phoneNumber, email) values (?, ?, ?)");
                    $insertStatement->bind_param("sds", $name, $phoneNumber, $email);

                    $result = $insertStatement->execute();
                    $responseErr = array();
                    if (false === $result) {
                        $responseErr = array("code" => "400", "result" => "Error Inserting To Book");
                    } else {
                        $responseErr = array("code" => "200", "result" => "New Entry Added");
                    }
                }
                header("Content-Type: application/json");
                echo json_encode($responseErr);
            } catch (Exception $ex) {
                
            }
        }
    }

    /*
     * Function that edits an entry inside the phone book DB
     */

    function editEntry($item, $previousItem) {

        if (count($item) > 0 && count($previousItem) > 0) {

            $name = $item['name'];
            $phoneNumber = $item['phoneNumber'];
            $email = $item['email'];

            $old_name = $previousItem['name'];
            $old_phoneNumber = $previousItem['phoneNumber'];

            try {
                // Check if the old phone Number = the new phone number
                // If yes then the user edited the phone
                // this fixes bug that prevented editing the row without changing the phone number
                if ($old_phoneNumber != $phoneNumber) {
                    $selectStatement = $this->dbConn->prepare("select * from book where phoneNumber=?");
                    $selectStatement->bind_param('d', $phoneNumber);
                    $phoneNumber = $item['phoneNumber'];
                    $selectStatement->execute();
                    $selectStatement->store_result();

                    // also checks if phone already exists
                    if ($selectStatement->num_rows > 0) {
                        $responseErr = array("code" => "400", "result" => "Phone Number Already Exists");
                        header("Content-Type: application/json");
                        echo json_encode($responseErr);
                        die();
                    }
                }

                // Update entry
                $editStatement = $this->dbConn->prepare("update book set name=?, phoneNumber=?, email=? where name=? and phoneNumber=?");
                $editStatement->bind_param("sdssd", $name, $phoneNumber, $email, $old_name, $old_phoneNumber);

                $result = $editStatement->execute();
                $responseErr = array();
                if (false === $result) {
                    $responseErr = array("code" => "400", "result" => "Error EditingEntry");
                } else {
                    $responseErr = array("code" => "200", "result" => "Entry Edited");
                }

                header("Content-Type: application/json");
                echo json_encode($responseErr);
            } catch (Exception $ex) {
                
            }
        }
    }

    /*
     * Function that deletes an entry from the phone book DB
     */

    function deleteEntry($item) {
        error_log("delete " . print_r($item, true));

        if (count($item > 0)) {
            try {

                $name = $item['name'];
                $phoneNumber = $item['phoneNumber'];
                $email = $item['email'];

                $deleteStatamenet = $this->dbConn->prepare("delete from book where name=? and phoneNumber=? and email=?");
                $deleteStatamenet->bind_param("sss", $name, $phoneNumber, $email);

                $result = $deleteStatamenet->execute();
                $responseErr = array();
                if (false === $result) {
                    $responseErr = array("code" => "400", "result" => "Error Deleting From Book");
                } else {
                    $responseErr = array("code" => "200", "result" => "Entry Deleted");
                }
                header("Content-Type: application/json");
                echo json_encode($responseErr);
            } catch (Exception $ex) {
                
            }
        }
    }

}

// If we have a post request then check its index
if (isset($_POST['function'])) {
    $item = null;
    $previousItem = null;
    $valid = true;

    // Checks if the item values are correct using regex
    // Also no need to check regex if we want to delete rows
    if (isset($_POST['item'])) {
        $item = $_POST['item'];
        if ($_POST['function'] != 'DeleteEntry') {
            // (X* X* * X*)*
            if (!preg_match("/^[a-zA-Z]{1}[a-zA-Z\s]+$/", $item['name'])) {
                $responseErr = array("code" => "400", "result" => "Invalid Name");
                $valid = false;
            }
            // checks if email is valid
            if (!filter_var($item['email'], FILTER_VALIDATE_EMAIL)) {
                $responseErr = array("code" => "400", "result" => "Invalid Email Address");
                $valid = false;
            }
            // checks if phone is only digits
            if (!preg_match("/^[0-9]+$/", $item['phoneNumber'])) {
                $responseErr = array("code" => "400", "result" => "Phone Number Should Contain Digits Only ");
                $valid = false;
            }
            // if one of them isn't valid then display error message
            if (!$valid) {
                header("Content-Type: application/json");
                echo json_encode($responseErr);
                die();
            }
        }
    }

    // Create obj and call the right function
    if (isset($_POST['previousItem'])) {
        $previousItem = $_POST['previousItem'];
    }
    $phoneBookObj = new PhoneBook();
    $phoneBookObj->main($_POST['function'], $item, $previousItem);
}



