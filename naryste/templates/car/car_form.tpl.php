<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Automobiliai</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Automobilio redagavimas"; else echo "Naujas automobilis"; ?></li>
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
		<label for="modelis">Modelis<?php echo in_array('modelis', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="modelis" name="modelis" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
				$brands = $brandsObj->getBrandList();
				foreach($brands as $key => $val) {
					echo "<optgroup label='{$val['pavadinimas']}'>";

					$models = $modelsObj->getModelListByBrand($val['id']);
					foreach($models as $key2 => $val2) {
						$selected = "";
						if(isset($data['modelis']) && $data['modelis'] == $val2['id']) {
							$selected = " selected='selected'";
						}
						echo "<option{$selected} value='{$val2['id']}'>{$val2['pavadinimas']}</option>";
					}
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="valstybinis_nr">Valstybinis numeris<?php echo in_array('valstybinis_nr', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="valstybinis_nr" name="valstybinis_nr" class="form-control" value="<?php echo isset($data['valstybinis_nr']) ? $data['valstybinis_nr'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="pagaminimo_data">Pagaminimo data<?php echo in_array('pagaminimo_data', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pagaminimo_data" name="pagaminimo_data" class="form-control datepicker" value="<?php echo isset($data['pagaminimo_data']) ? $data['pagaminimo_data'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="pavaru_deze">Pavarų dėžė<?php echo in_array('pavaru_deze', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="pavaru_deze" name="pavaru_deze" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
				$gearboxes = $carsObj->getGearboxList();
				foreach($gearboxes as $key => $val) {
					$selected = "";
					if(isset($data['pavaru_deze']) && $data['pavaru_deze'] == $val['id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="degalu_tipas">Degalų tipas<?php echo in_array('degalu_tipas', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="degalu_tipas" name="degalu_tipas" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
				$fueltypes = $carsObj->getFuelTypeList();
				foreach($fueltypes as $key => $val) {
					$selected = "";
					if(isset($data['degalu_tipas']) && $data['degalu_tipas'] == $val['id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="kebulas">Kėbulo tipas<?php echo in_array('kebulas', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="kebulas" name="kebulas" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
				$bodytypes = $carsObj->getBodyTypeList();
				foreach($bodytypes as $key => $val) {
					$selected = "";
					if(isset($data['kebulas']) && $data['kebulas'] == $val['id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="bagazo_dydis">Bagažo dydis<?php echo in_array('bagazo_dydis', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="bagazo_dydis" name="bagazo_dydis" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
				$lugage = $carsObj->getLugageTypeList();
				foreach($lugage as $key => $val) {
					$selected = "";
					if(isset($data['bagazo_dydis']) && $data['bagazo_dydis'] == $val['id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="busena">Būsena<?php echo in_array('busena', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="busena" name="busena" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
				$car_states = $carsObj->getCarStateList();
				foreach($car_states as $key => $val) {
					$selected = "";
					if(isset($data['busena']) && $data['busena'] == $val['ID']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['ID']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="rida">Rida<?php echo in_array('rida', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="rida" name="rida" class="form-control" value="<?php echo isset($data['rida']) ? $data['rida'] : ''; ?>">
	</div>

	<div class="form-group">
		<input type="checkbox" id="radijas" name="radijas" class="form-check-input"<?php echo (isset($data['radijas']) && ($data['radijas'] == 1 || $data['radijas'] == 'on'))  ? ' checked="checked"' : ''; ?>>
		<label for="radijas" class="form-check-label" for="radijas">Radijas</label>
	</div>

	<div class="form-group">
		<input type="checkbox" id="grotuvas" name="grotuvas" class="form-check-input"<?php echo (isset($data['grotuvas']) && ($data['grotuvas'] == 1 || $data['grotuvas'] == 'on'))  ? ' checked="checked"' : ''; ?>>
		<label for="grotuvas" class="form-check-label" for="grotuvas">Radijas</label>
	</div>

	<div class="form-group">
		<input type="checkbox" id="kondicionierius" name="kondicionierius" class="form-check-input"<?php echo (isset($data['kondicionierius']) && ($data['kondicionierius'] == 1 || $data['kondicionierius'] == 'on'))  ? ' checked="checked"' : ''; ?>>
		<label for="kondicionierius" class="form-check-label" for="kondicionierius">Kondicionierius</label>
	</div>

	<div class="form-group">
		<label for="vietu_skaicius">Vietų skaičius<?php echo in_array('vietu_skaicius', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="vietu_skaicius" name="vietu_skaicius" class="form-control" value="<?php echo isset($data['vietu_skaicius']) ? $data['vietu_skaicius'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="registravimo_data">Registravimo data<?php echo in_array('registravimo_data', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="registravimo_data" name="registravimo_data" class="form-control datepicker" value="<?php echo isset($data['registravimo_data']) ? $data['registravimo_data'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="verte">Vertė<?php echo in_array('verte', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="verte" name="verte" class="form-control" value="<?php echo isset($data['verte']) ? $data['verte'] : ''; ?>">
	</div>

	<?php if(isset($data['id'])) { ?>
		<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
	<?php } ?>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>