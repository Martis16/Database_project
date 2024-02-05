<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Darbuotojai</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Darbuotojo redagavimas"; else echo "Naujas darbuotojas"; ?></li>
	</ol>
</nav>

<?php if($formErrors != null) { ?>
	<div class="alert alert-danger" role="alert">
		Neįvesti arba neteisingai įvesti šie laukai:
		<?php 
			echo $formErrors;
		?>
	</div>
<?php } ?>

<form action="" method="post" class="d-grid gap-3">
	<div class="form-group">
		<label for="tabelio_nr">Tabelio numeris<?php echo in_array('tabelio_nr', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="tabelio_nr" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="tabelio_nr" class="form-control" value="<?php echo isset($data['tabelio_nr']) ? $data['tabelio_nr'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="vardas">Vardas<?php echo in_array('vardas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="vardas" name="vardas" class="form-control" value="<?php echo isset($data['vardas']) ? $data['vardas'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="pavarde">Pavardė<?php echo in_array('pavarde', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavarde" name="pavarde" class="form-control" value="<?php echo isset($data['pavarde']) ? $data['pavarde'] : ''; ?>">
	</div>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>