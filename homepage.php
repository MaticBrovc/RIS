<?php
session_start();
$user = $_SESSION["user"];
require_once ("baza.php");
$userID = $_SESSION["all"][0]["IDUser"]
?>
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
    <script src="assets/js/script.js"></script>
</head>
<body>
    <?php
    // TODO v tem primeru nej se prikaže modal z napako
    if (isset($_SESSION["urnaError"]) && $_SESSION["urnaError"] == 1) {
        echo '<h1 style="color:red;">Napaka! Ni urne postavke</h1>';
    }
    ?>
    <div class="container mt-5">
            <div class="row ">
                <div class="col-12 text-center bg-light rounded-pill  mb-5 shadow fontS" style="z-index: 9;display: flex;justify-content: space-around;"><img src="assets/user.png" style="width:50px;"> Welcome <?=$user; ?> <a href="index.php"><img src="assets/logout.png" style="width:50px; margin-bottom: 5px;"></a></div>

    <?php
    $podatki = Baza::getSeznamPrisotnosti($userID);
    if (!empty($podatki)) {
        ?>
        <!-- <div class="container mt-5">
            <div class="row ">
                <div class="col-12 text-center bg-light rounded-pill  mb-5 shadow fontS" style="z-index: 9;display: flex;justify-content: space-around;"><img src="assets/user.png" style="width:50px;"> Welcome <?=$user; ?> <a href="index.php"><img src="assets/logout.png" style="width:50px; margin-bottom: 5px;"></a></div> -->
                <div class="col-12 text-center bg-light rounded-top shadow fontS" style="z-index: 9;display: flex;justify-content: space-around;">
                    Prisotnosti
                </div>
                <div class="col-12 opacityLess rounded shadow text-dark pt-5 text-center empty">
                <table>
                <tr class="border-bottom">
                    <th>prihod</th>
                    <th>odhod</th>
                    <th>Uporabnik</th>
                </tr>
                <?php foreach ($podatki as $evidenca): ?>
                    <tr>
                        <td><?=$evidenca["casPrihoda"]?></td>
                        <td><?=$evidenca["casOdhoda"]?></td>
                        <td><?=$evidenca["UserID"]?></td>
                    </tr>
                <?php endforeach; ?>
                </table>
                </div>
            </div>
        </div>  

        
    <?php
    }
    else{
        ?>
        </div>
        </div>
        </div> 
        <div class="container mt-5">
            <div class="row ">
                <div class="col-12 text-center bg-light rounded-top shadow fontS" style="z-index: 9;display: flex;justify-content: space-around;">
                    <img src="assets/warning.png" style="width:50px;"> Brez vnosov prisotnosti! <img src="assets/warning.png" style="width:50px;">
                </div>
                <div class="col-12 opacityLess rounded shadow text-dark pt-5 text-center empty">
                    <p>--------------------------------------------</p>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    $odsotnost = Baza::getSeznamOdsotnosti($userID);
    if (!empty($odsotnost)) {
    ?>
    <div class="container mt-5">
        <div class="row ">
            <div class="col-12 text-center bg-light rounded-top shadow fontS" style="z-index: 9;display: flex;justify-content: space-around;">
                Odsotnosti
            </div>
            <div class="col-12 opacityLess rounded shadow text-dark pt-5 text-center empty">    
                <table>
                    <tr class="border-bottom">
                    <th>Datum</th>
                    <th>Tip</th>
                    <th>Uporabnik</th>
                    </tr>
                    <?php foreach ($odsotnost as $evidenca): ?>
                        <tr>
                        <td><?=$evidenca["datumOdsotnosti"]?></td>
                        <td><?=$evidenca["tipOdsotnosti"]?></td>
                        <td><?=$evidenca["UserID"]?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>  

    <?php
    }
    else{
        ?> 
        <div class="container mt-5">
            <div class="row ">
                <div class="col-12 text-center bg-light rounded-top shadow fontS" style="z-index: 9;display: flex;justify-content: space-around;">
                    <img src="assets/warning.png" style="width:50px;"> Brez vnosov odsotnosti! <img src="assets/warning.png" style="width:50px;">
                </div>
                <div class="col-12 opacityLess rounded shadow text-dark pt-5 text-center empty">
                    <p>--------------------------------------------</p>
                </div>
            </div>
        </div>
        
    <?php
    }
    ?>

    <?php
    if (!empty($podatki) || !empty($odsotnost)) {
        echo '
        <div class="container mt-5">
            <div class="row ">
                <div class="col-12 text-center" >
                    <form name="vnos" action="calculate.php" method="post" onsubmit="return validateForm()">
                    <button class="gumb shadow">Izračunaj plačo</button>
                    <input type="number" name="mesec" id="mesec" placeholder="Mesec" />
                    <input type="number" name="leto" id="leto" placeholder="Leto" />
                    </form>
                </div>
';
    }
    ?>
</body>
</html>