<?php
require_once ("baza.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propalitus d.o.o.</title>
</head>
<body>
<form action="login.php" method="post">
    <label for="query">Uporabnisko Ime:</label>
    <input type="text" name="username" id="username" />
    <label for="query">Geslo:</label>
    <input type="password" name="pass" id="pass"/>
    <button type="submit">Prijava</button>
</form>


<ul>
    <?php foreach (Baza::getAll() as $user): ?>
        <li><?= $user["username"] ?>: <?= $user["pass"] ?></a></li>
    <?php endforeach; ?>
</ul>
</body>
</html>