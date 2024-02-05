<?php
	// suformuojame puslapių kelio (breadcrumb) elementų masyvą
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Pradžia'), array('link' => "index.php?module=report&action=list", 'title' => "Ataskaitos"), array("title" => "Sutarčių ataskaita"));
	
	// puslapių kelio šabloną
	include 'templates/common/breadcrumb.tpl.php';
?>

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
		<label for="dataNuo">Sutartys sudarytos nuo</label>
		<input type="text" id="dataNuo" name="dataNuo" class="form-control datepicker" value="<?php echo isset($data['dataNuo']) ? $data['dataNuo'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="dataIki">Sutartys sudarytos iki</label>
		<input type="text" id="dataIki" name="dataIki" class="form-control datepicker" value="<?php echo isset($data['dataIki']) ? $data['dataIki'] : ''; ?>">
	</div>

	<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Sudaryti ataskaitą">
</form>