<?php

require_once ("baza.php");
session_start();


$user = $_SESSION["user"];
$userID = $_SESSION["all"][0]["IDUser"];

echo $user . " " . $userID . '<br>';
// if null;
$urnaPostavka = Baza::getUrnaPostavka($userID)["urnaPostavka"];
if ($urnaPostavka == NULL) {
    $_SESSION["urnaError"] = 1;
    header("Location: homepage.php");
}
else{
    //TODO: Izgled strani.
    $_SESSION["urnaError"] = 0;

    echo $urnaPostavka . "<br>";
    //if mesec = empty and leto = empty => take current month and year OR leto = empty and mesec != empty => take current year with mesec
    if(isset($_POST["mesec"]) && !empty($_POST["mesec"])){$mesec = $_POST["mesec"];}
    else{$mesec = date("n");}
    if(isset($_POST["leto"]) && !empty($_POST["leto"])){$leto = $_POST["leto"];}
    else{$leto = date("Y");}

    echo "Izračun za mesec: " . $mesec . " Leta: ". $leto . "<br>";
    if ($mesec == date("n") && $leto == date("Y")) {
        $opUre = Baza::getOpravljeneUre($userID, $mesec, $leto);
        //var_dump($result);

        $dniPrisotnosti = Baza::getDniPrisotnosti($userID, $mesec, $leto);
        //echo $dniPrisotnosti;

        $skupno = Baza::getPrispevkiOdsotnosti($userID, $mesec, $leto);
        //echo $skupno;

        //Na koncu je vnaprej definiran parameter malca, ki je nastavljen na 5.5€ na/dan.
        $palca = Baza::getIzracunanaPlaca($urnaPostavka, $opUre, $dniPrisotnosti, $skupno);
        echo "Plača: " . $palca;
    }
    else{
        $placilnaLista = Baza::getPlacilnaLista($userID, $mesec, $leto);
        if (count($placilnaLista) < 1) {
            //V primeru, da še ni v bazi
            $opUre = Baza::getOpravljeneUre($userID, $mesec, $leto);
            //var_dump($result);

            $dniPrisotnosti = Baza::getDniPrisotnosti($userID, $mesec, $leto);
            //echo $dniPrisotnosti;

            $skupno = Baza::getPrispevkiOdsotnosti($userID, $mesec, $leto);
            //echo $skupno;

            //Na koncu je vnaprej definiran parameter malca, ki je nastavljen na 5.5€ na/dan.
            $placa = Baza::getIzracunanaPlaca($urnaPostavka, $opUre, $dniPrisotnosti, $skupno);
            echo "Plača: " . $placa;

            Baza::savePlacilnaLista($userID, $placa, $mesec, $leto);
            echo "Izračunana plača je zapisana v Bazo";
        }
        else{
            //V primeru, da je.
            var_dump($placilnaLista);
        }
    }
    
    //TODO potrebno dodati, da se mesec in leto vnašata preko vmesnika!
    

    
}

?>
