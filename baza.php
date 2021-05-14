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

    public static function getUrnaPostavka($userID){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT urnaPostavka from uporabniki where IDUser = :userID");
        $statement->bindParam(":userID", $userID);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result[0];
    }

    public static function getOpravljeneUre($userID, $mesec, $leto){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * from prisotnosti where UserID = :userID AND month(casPrihoda) = :mesec AND year(casPrihoda) = :leto");
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":mesec", $mesec);
        $statement->bindParam(":leto", $leto);
        $statement->execute();
        $result = $statement->fetchAll();
        $ure = 0;
        foreach ($result as $vnos) {
            $date = strtotime($vnos["casPrihoda"]);
            $date2 = strtotime($vnos["casOdhoda"]);

            $razlika = $date2 - $date;
            $ure += $razlika;
        }
        $opUre = round($ure / 3600);
        //echo "V mescu " . $mesec . " si opravil " . $opUre . " ur.";

        return $opUre;
    }

    public static function getDniPrisotnosti($userID, $mesec, $leto){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * from prisotnosti where UserID = :userID AND month(casPrihoda) = :mesec AND year(casPrihoda) = :leto");
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":mesec", $mesec);
        $statement->bindParam(":leto", $leto);
        $statement->execute();
        $result = $statement->fetchAll();
        return count($result);

    }

    public static function getKoeficient($tipOdsotnosti){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT koeficient from tipiodsotnosti where tipOdsotnosti = :tipOdsotnosti");
        $statement->bindParam(":tipOdsotnosti", $tipOdsotnosti);
        $statement->execute();
        $result = $statement->fetchAll();

        return $result[0];
    }

    public static function getPrispevkiOdsotnosti($userID, $mesec, $leto){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * from odsotnosti where UserID = :userID AND month(datumOdsotnosti) = :mesec AND year(datumOdsotnosti) = :leto");
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":mesec", $mesec);
        $statement->bindParam(":leto", $leto);
        $statement->execute();
        $result = $statement->fetchAll();
        
        $urnaPostavka = Baza::getUrnaPostavka($userID)["urnaPostavka"];
        
        //TODO: if null;
        $naDan = $urnaPostavka * 8;
        $skupno = 0;
        foreach ($result as $vnos) {
            $koeficient = Baza::getKoeficient($vnos["tipOdsotnosti"])["koeficient"];
            $skupno += ($naDan * $koeficient);
        }
        return $skupno;

    }

    public static function getIzracunanaPlaca($urnaPostavka, $opravljeneUre, $dniPrisotnosti, $prispevkiOdsotnosti, $malca = 5.5){
        $placa = 0;
        $placa += ($opravljeneUre * $urnaPostavka);
        $placa += ($dniPrisotnosti * $malca);
        $placa += $prispevkiOdsotnosti;
        
        return $placa;
    }

    public static function getPlacilnaLista($userID, $mesec, $leto){

        $db = DBInit::getInstance();
        //SELECT * FROM `placilneliste` WHERE UserID = 2 and MONTH(datumIzracuna) = 5 and YEAR(datumIzracuna) = 2021
        $statement = $db->prepare("SELECT * from placilneliste where UserID = :userID AND mesec = :mesec AND leto = :leto");
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":mesec", $mesec);
        $statement->bindParam(":leto", $leto);
        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }

    public static function savePlacilnaLista($userID, $placa, $mesec, $leto){
        $db = DBInit::getInstance();
        $dat = date("Y-m-d");
        $statement = $db->prepare("INSERT INTO placilneliste (datumIzracuna, UserID, placa, mesec, leto)
            VALUES (:datumizracuna, :userID, :placa, :mesec, :leto)");
        $statement->bindParam(":datumizracuna", $dat);
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":placa", $placa);
        $statement->bindParam(":mesec", $mesec);
        $statement->bindParam(":leto", $leto);
        $statement->execute();
    }
}
