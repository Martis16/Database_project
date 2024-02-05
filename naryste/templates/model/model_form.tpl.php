<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Automobilių modeliai</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Modelio redagavimas"; else echo "Naujas modelis"; ?></li>
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
		<label for="brand">Pavadinimas<?php echo in_array('fk_marke', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="brand" name="fk_marke" class="form-select form-control">
			<option value="-1">Pasirinkite markę</option>
			<?php
				// išrenkame visas markes
				$brands = $brandsObj->getBrandList();
				foreach($brands as $key => $val) {
					$selected = "";
					if(isset($data['fk_marke']) && $data['fk_marke'] == $val['id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id']}'>{$val['pavadinimas']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="pavadinimas">Pavadinimas<?php echo in_array('pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pavadinimas" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="pavadinimas" class="form-control" value="<?php echo isset($data['pavadinimas']) ? $data['pavadinimas'] : ''; ?>">
	</div>

	<?php if(isset($data['id'])) { ?>
		<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
	<?php } ?>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>