<?php

require_once "DBInit.php";

class Baza {

    public static function insert($username, $password, $ime, $priimek, $urnaPostavka, $aktiven, $datumPrekinitveDela, $dobilZadnjoPlaco){
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO uporabniki (username, pass, ime, priimek, urnaPostavka, aktiven, datumPrekinitveDela, dobilZadnjoPlaco)
            VALUES (:username, :pass, :ime,:priimek, :urnaPostavka, :aktiven, :datumPrekinitveDela, :dobilZadnjoPlaco)");
        $statement->bindParam(":username", $username);
        $statement->bindParam(":pass", $password);
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":priimek", $priimek);
        $statement->bindParam(":urnaPostavka", $urnaPostavka);
        $statement->bindParam(":aktiven", $aktiven);
        $statement->bindParam(":datumPrekinitveDela", $datumPrekinitveDela);
        $statement->bindParam(":dobilZadnjoPlaco", $dobilZadnjoPlaco);
        $statement->execute();
    }

    public static function confirmLogin($username, $password){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT IDUser, username, pass from uporabniki WHERE username = :user AND pass = :pass");
        $statement->bindParam(":user", $username);
        $statement->bindParam(":pass", $password);
        $statement->execute();

        $result = $statement->fetchAll();
        if (empty($result)) {
            header("Location: index.php");
        }
        else{
            session_start();
            $_SESSION["user"] = $username;
            $_SESSION["all"] = $result;
            header("Location: homepage.php");
        }

    }

    public static function getSeznamPrisotnosti($userID){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT IDPrisotnosti, casPrihoda, casOdhoda, UserID from prisotnosti where UserID = :userID");
        $statement->bindParam(":userID", $userID);
        $statement->execute();

        return $statement->fetchAll();

    }

    public static function getSeznamOdsotnosti($userID){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT IDOdsotnosti, datumOdsotnosti, UserID, tipOdsotnosti from odsotnosti where UserID = :userID");
        $statement->bindParam(":userID", $userID);
        $statement->execute();

        return $statement->fetchAll();

    }



    public static function getAll(){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT username, pass from uporabniki");
        $statement->execute();

        return $statement->fetchAll();
    }
}
