<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Klientai</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Kliento redagavimas"; else echo "Naujas klientas"; ?></li>
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
		<label for="asmens_kodas">Asmens kodas<?php echo in_array('asmens_kodas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="asmens_kodas" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="asmens_kodas" class="form-control" value="<?php echo isset($data['asmens_kodas']) ? $data['asmens_kodas'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="vardas">Vardas<?php echo in_array('vardas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="vardas" name="vardas" class="form-control" value="<?php echo isset($data['vardas']) ? $data['vardas'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="pavarde">Pavardė<?php echo in_array('pavarde', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavarde" name="pavarde" class="form-control" value="<?php echo isset($data['pavarde']) ? $data['pavarde'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="gimimo_data">Gimimo data<?php echo in_array('gimimo_data', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="gimimo_data" name="gimimo_data" class="form-control datepicker" value="<?php echo isset($data['gimimo_data']) ? $data['gimimo_data'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="telefonas">Telefonas<?php echo in_array('telefonas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="telefonas" name="telefonas" class="form-control" value="<?php echo isset($data['telefonas']) ? $data['telefonas'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="epastas">Elektroninis paštas<?php echo in_array('epastas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="email" id="epastas" name="epastas" class="form-control" value="<?php echo isset($data['epastas']) ? $data['epastas'] : ''; ?>">
	</div>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>