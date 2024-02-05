<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Pradžia</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Sutartys</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Sutarties redagavimas"; else echo "Nauja sutartis"; ?></li>
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

	<h4 class="mt-3">Sutarties informacija</h4>
  	
	<div class="form-group">
		<label for="Nr">Numeris<?php echo in_array('Nr', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="Nr" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="Nr" class="form-control" value="<?php echo isset($data['Nr']) ? $data['Nr'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="Pasirasymo_data">Pasirasymo Data<?php echo in_array('Pasirasymo_data', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="Pasirasymo_data" name="Pasirasymo_data" class="form-control datepicker" value="<?php echo isset($data['Pasirasymo_data']) ? $data['Pasirasymo_data'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="Baigia_galioti">Baigia galioti<?php echo in_array('Baigia_galioti', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="Baigia_galioti" name="Baigia_galioti" class="form-control datepicker" value="<?php echo isset($data['Baigia_galioti']) ? $data['Baigia_galioti'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="busena">Busena<?php echo in_array('busena', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="busena" name="busena" class="form-control" value="<?php echo isset($data['busena']) ? $data['busena'] : ''; ?>">
	</div>


	<div class="form-group">
		<label for="fk_Asmens_id">Klientas<?php echo in_array('fk_Asmens_id', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_Asmens_id" name="fk_Asmens_id" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// išrenkame klientus
				$customers = $customersObj->getCustomersList();
				foreach($customers as $key => $val) {
					$selected = "";
					if(isset($data['fk_Asmens_id']) && $data['fk_Asmens_id'] == $val['Asmens_id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['Asmens_id']}'>{$val['Vardas']} {$val['Pavarde']}</option>";
				}
			?>
		</select>
	</div>

	<h4 class="mt-3">Naryste</h4>

	<div class="form-group">
		<label for="fk_Narysteid_Naryste">Naryste<?php echo in_array('fk_Narysteid_Naryste', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_Narysteid_Naryste" name="fk_Narysteid_Naryste" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// išrenkame klientus
				$customers = $modelsObj->getNarysteList();
				foreach($customers as $key => $val) {
					$selected = "";
					if(isset($data['fk_Narysteid_Naryste']) && $data['fk_Narysteid_Naryste'] == $val['id_Naryste']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_Naryste']}'>Pavadinimas: {$val['Pavadinimas']}  Kaina: {$val['Kaina']}</option>";
				}
			?>
		</select>
	</div>

		<h4 class="mt-3">Saskaita</h4>

	<div class="form-group">
		<label for="fk_Saskaitaid_Saskaita">Saskaita<?php echo in_array('fk_Saskaitaid_Saskaita', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_Saskaitaid_Saskaita" name="fk_Saskaitaid_Saskaita" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// išrenkame klientus
				$customers = $carsObj->getSaskaitaList();
				foreach($customers as $key => $val) {
					$selected = "";
					if(isset($data['fk_Saskaitaid_Saskaita']) && $data['fk_Saskaitaid_Saskaita'] == $val['Numeris']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['Numeris']}'>Numeris: {$val['Numeris']}</option>";
				}
			?>
		</select>
	</div>

	<h4 class="mt-3">Papildomos paslaugos</h4>

	<div class="row w-75">
		<div class="formRowsContainer column">
			<div class="row headerRow<?php if(empty($data['uzsakyta_paslauga']) || sizeof($data['uzsakyta_paslauga']) == 1) echo ' d-none'; ?>">
				<div class="col-6">Paslauga</div>
				<div class="col-1">Kaina</div>
				<div class="col-1">Kiekis</div>
				<div class="col-4"></div>
			</div>
			<?php
				if(!empty($data['uzsakyta_paslauga']) && sizeof($data['uzsakyta_paslauga']) > 0) {
					foreach($data['uzsakyta_paslauga'] as $key => $orderedService) {

						$disabledAttr = "";
						if($key === 0) {
							$disabledAttr = "disabled='disabled'";
						}

						$kaina = '';
						if(isset($orderedService['Sumine_kaina']) ) {
							$kaina = $orderedService['Sumine_kaina'];
						}

						$kiekis = '';
						if(isset($orderedService['kiekis']) ) {
							$kiekis = $orderedService['kiekis'];
						}

					?>
						<div class="formRow row col-12 <?php echo $key > 0 ? '' : 'd-none'; ?>">
							<div class="col-6">
								<select class="elementSelector form-select form-control" name="paslauga[]" <?php echo $disabledAttr; ?>>
									<?php
										$allServices = $servicesObj->getServicesList();
										foreach($allServices as $service) {
											echo "<optgroup label='{$service['Tipas']}'>";
											$prices = $servicesObj->getServicePrices($service['id_Papildoma_Paslauga']);
											foreach($prices as $price) {
												$selected = "";
												if(isset($orderedService['fk_Papildoma_Paslaugaid_Papildoma_Paslauga']) ) {
													if($orderedService['fk_Papildoma_Paslaugaid_Papildoma_Paslauga'] == $price['id_Papildoma_Paslauga']) {
														$selected = " selected='selected'";
													}
												}
												echo "<option{$selected} value='{$price['id_Papildoma_Paslauga']}#{$price['Trukme']}}'>{$service['Tipas']} {$price['kaina']} EUR ({$price['Trukme']})</option>";
											}
										}
									?>
								</select>
							</div>

							<div class="col-1"><input type="text" name="paslaugos_kaina[]" class="form-control" value="<?php echo $kaina; ?>" <?php echo $disabledAttr; ?> /></div>
							<div class="col-1"><input type="text" name="paslaugos_kiekis[]" class="form-control" value="<?php echo $kiekis; ?>" <?php echo $disabledAttr; ?> /></div>
							<div class="col-4"><a href="#" onclick="return false;" class="removeChild">šalinti</a></div>
						</div>
					<?php 
					}
				}
					?>
		</div>
		<div class="w-100">
			<a href="#" class="addChild">Pridėti</a>
		</div>
	</div>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Išsaugoti">
</form>