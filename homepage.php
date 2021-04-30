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
    <title>Domača Stran</title>
</head>
<body>
    <?php
    $podatki = Baza::getSeznamPrisotnosti($userID);
    if (!empty($podatki)) {
        ?>
        <h1>Welcome <?=$user; ?>
        </h1>

        <table>
        <tr>
        <th>Čas prihoda</th>
        <th>Čas odhoda</th>
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
    <?php
    }
    else{
        ?> 
        <h1>Napaka: Brez vnosov prisotnosti!</h1>
    <?php
    }
    ?>
    

    <h1>---------------------------------------------</h1>

    <?php
    $odsotnost = Baza::getSeznamOdsotnosti($userID);
    if (!empty($odsotnost)) {
    ?>
    <table>
        <tr>
        <th>Datum odsotnosti</th>
        <th>Tip Odsotnosti</th>
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
    <?php
    }
    else{
        ?> 
        <h1>Napaka: Brez vnosov Odsotnosti!</h1>
    <?php
    }
    ?>

    <?php
    if (!empty($podatki) || !empty($odsotnost)) {
        echo '<button>Izračunaj plačo</button>';
    }
    ?>
    
</body>
</html>