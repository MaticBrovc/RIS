<?php

require_once ("baza.php");
session_start();


$user = $_SESSION["user"];
$userID = $_SESSION["all"][0]["IDUser"];

echo $user . " " . $userID . '<br>';
//TODO: if null;
$urnaPostavka = Baza::getUrnaPostavka($userID)["urnaPostavka"];
if ($urnaPostavka == NULL) {
    $_SESSION["urnaError"] = 1;
    header("Location: homepage.php");
}
else{
    $_SESSION["urnaError"] = 0;

    echo $urnaPostavka . "<br>";

    //TODO potrebno dodati, da se mesec in leto vnašata preko vmesnika!
    $opUre = Baza::getOpravljeneUre($userID, 4, 2021);
    //var_dump($result);

    //TODO
    $dniPrisotnosti = Baza::getDniPrisotnosti($userID, 4, 2021);
    //echo $dniPrisotnosti;

    $skupno = Baza::getPrispevkiOdsotnosti($userID, 4, 2021);
    //echo $skupno;

    //Na koncu je vnaprej definiran parameter malca, ki je nastavljen na 5.5€ na/dan.
    $palca = Baza::getIzracunanaPlaca($urnaPostavka, $opUre, $dniPrisotnosti, $skupno);
    echo "Plača: " . $palca;
}

?>
