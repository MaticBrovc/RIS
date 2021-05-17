<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propalitus d.o.o.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>
<body>
<script>
$(window).on("load", function () {
  $("#placaModal").modal("show");
});
</script>
<div class="modal fade shadow" id="placaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="accModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-body text-center">

<?php

require_once ("baza.php");
session_start();


$user = $_SESSION["user"];
$userID = $_SESSION["all"][0]["IDUser"];

echo "<h1 class='username' >Uporabnik: " . $user . '</h1><br>';
// if null;
$urnaPostavka = Baza::getUrnaPostavka($userID)["urnaPostavka"];
if ($urnaPostavka == NULL) {
    $_SESSION["urnaError"] = 1;
    header("Location: homepage.php");
}
else{
    //TODO: Izgled strani.
    $_SESSION["urnaError"] = 0;

    echo "<h3>Urna postavka: <strong> " . $urnaPostavka . "</strong>€</h3><br>";
    //if mesec = empty and leto = empty => take current month and year OR leto = empty and mesec != empty => take current year with mesec
    if(isset($_POST["mesec"]) && !empty($_POST["mesec"])){$mesec = $_POST["mesec"];}
    else{$mesec = date("n");}
    if(isset($_POST["leto"]) && !empty($_POST["leto"])){$leto = $_POST["leto"];}
    else{$leto = date("Y");}

    echo "<h3>Izračun za mesec: <strong>" . $mesec . "</strong> Leta:<strong> ". $leto . "</strong></h3><br>";
    if ($mesec == date("n") && $leto == date("Y")) {
        $opUre = Baza::getOpravljeneUre($userID, $mesec, $leto);
        //var_dump($result);

        $dniPrisotnosti = Baza::getDniPrisotnosti($userID, $mesec, $leto);
        //echo $dniPrisotnosti;

        $skupno = Baza::getPrispevkiOdsotnosti($userID, $mesec, $leto);
        //echo $skupno;

        //Na koncu je vnaprej definiran parameter malca, ki je nastavljen na 5.5€ na/dan.
        $palca = Baza::getIzracunanaPlaca($urnaPostavka, $opUre, $dniPrisotnosti, $skupno);
        echo "<div class='w-100 bg-dark text-light fs-1'> Plača: <strong>" . $palca . "€ </strong></div>";
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
        echo "<div class='w-100 bg-dark text-light fs-1'> Plača: <strong>" . $placa . "€ </strong></div>";

            Baza::savePlacilnaLista($userID, $placa, $mesec, $leto);
            echo "<h6 class='text-warning mt-3'>Izračunana plača je zapisana v Bazo</h6>";
        }
        else{
            //V primeru, da je.
            echo "Datum izračuna: <strong>" . $placilnaLista[0]["datumIzracuna"] . "</strong>";
        }
    }
    
    //TODO potrebno dodati, da se mesec in leto vnašata preko vmesnika!
    

    
}

?>
            </div>
            <button onclick="window.location.href='homepage.php' " class="btn w-100 bg-dark text-light fs-2 rounded-0 shadow" id="nazaj"> NAZAJ </button>
        </div>
    </div>
</div>
</body>
</html>