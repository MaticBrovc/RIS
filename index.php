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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>
<body>
<script>
$(window).on("load", function () {
  $("#accModal").modal("show");
});
</script>
<!-- <form action="login.php" method="post">
    <label for="query">Uporabnisko Ime:</label>
    <input type="text" name="username" id="username" />
    <label for="query">Geslo:</label>
    <input type="password" name="pass" id="pass"/>
    <button type="submit">Prijava</button>
</form> -->

<div class="modal fade shadow" id="accModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="accModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content ">
			<div class="modal-body" style="padding: 0;">
				<form action="login.php" method="post">
					<div class="col-12 text-center mt-3">
						<span class="text-center accTitle" id="accModalLabel">Vpis uporabnika</span>
					</div>
					<div class="row mt-5">
						<div class="form-group col-12" style="padding-left: 2rem;padding-right:2rem;">
							<input type="text" class="form-control formLabel" name="username" id="username" placeholder="Vpišite uporabniško ime">
						</div>
						<div class="form-group col-12 mt-2 mb-5 " style="padding-left: 2rem;padding-right:2rem;">
							<input type="password" class="form-control formLabel"
                            name="pass" id="pass" placeholder="Vpišite geslo">
						</div>
						<div class="col-12 mt-2" style="height: 70px !important;">
							<button type="submit"
								class="shadow h-100 btn btn-success border-0 rounded-0 w-100 modalButtonColor">Prijava</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<ul>
    <?php foreach (Baza::getAll() as $user): ?>
        <li><?= $user["username"] ?>: <?= $user["pass"] ?></a></li>
    <?php endforeach; ?>
</ul>
</body>
</html>