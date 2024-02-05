<ul id="reportInfo">
	<li class="title">Sudarytų sutarčių ataskaita</li>
	<li>Sudarymo data: <span><?php echo date("Y-m-d"); ?></span></li>
	<li>Sutarčių sudarymo laikotarpis:
		<span>
		<?php
			if(!empty($data['dataNuo'])) {
				if(!empty($data['dataIki'])) {
					echo "nuo {$data['dataNuo']} iki {$data['dataIki']}";
				} else {
					echo "nuo {$data['dataNuo']}";
				}
			} else {
				if(!empty($data['dataIki'])) {
					echo "iki {$data['dataIki']}";
				} else {
					echo "nenurodyta";
				}
			}
		?>
		</span>
	</li>
</ul>
<?php
	if(sizeof($contractData) > 0) { ?>
		<table class="table">
			<thead>	
				<tr>
					<th>Sutartis</th>
					<th>Data</th>
					<th>Sudarytų sutarčių vertė</th>
					<th>Užsakyta paslaugų vertė</th>
				</tr>
			</thead>

			<tbody>
				<?php
					// suformuojame lentelę
					for($i = 0; $i < sizeof($contractData); $i++) {
						
						if($i == 0 || $contractData[$i]['Asmens_id'] != $contractData[$i-1]['Asmens_id']) {
							echo
								"<tr class='table-primary'>"
									. "<td colspan='4'>{$contractData[$i]['Vardas']} {$contractData[$i]['Pavarde']}</td>"
								. "</tr>";
						}
						
						if($contractData[$i]['sutarties_paslaugu_kaina'] == 0) {
							$contractData[$i]['sutarties_paslaugu_kaina'] = "neužsakyta";
						} else {
							$contractData[$i]['sutarties_paslaugu_kaina'] .= " &euro;";
						}
						
						echo
							"<tr>"
								. "<td>#{$contractData[$i]['Nr']}</td>"
								. "<td>{$contractData[$i]['Pasirasymo_data']}</td>"
								. "<td>{$contractData[$i]['sutarties_kaina']} &euro;</td>"
								. "<td>{$contractData[$i]['sutarties_paslaugu_kaina']}</td>"
							. "</tr>";
						if($i == (sizeof($contractData) - 1) || $contractData[$i]['Asmens_id'] != $contractData[$i+1]['Asmens_id']) {
							if($contractData[$i]['bendra_kliento_paslaugu_kaina'] == 0) {
								$contractData[$i]['bendra_kliento_paslaugu_kaina'] = "neužsakyta";
							} else {
								$contractData[$i]['bendra_kliento_paslaugu_kaina'] .= " &euro;";
							}
							
							echo 
								"<tr>"
									. "<td colspan='2'></td>"
									. "<td>{$contractData[$i]['bendra_kliento_sutarciu_kaina']} &euro;</td>"
									. "<td>{$contractData[$i]['bendra_kliento_paslaugu_kaina']}</td>"
								. "</tr>";
						}
					}
				?>
				
				<tr>
					<td colspan='4'>Bendra suma</td>
				</tr>
				
				<tr>
					<td colspan="2"></td>
					<td><?php echo $totalPrice[0]['nuomos_suma']; ?> &euro;</td>
					<td>
						<?php
							if($totalServicePrice[0]['paslaugu_suma'] == 0) {
								$totalServicePrice[0]['paslaugu_suma'] = "neužsakyta";
							} else {
								$totalServicePrice[0]['paslaugu_suma'] .= " &euro;";
							}
							
							echo $totalServicePrice[0]['paslaugu_suma'];
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<a href="index.php?module=report&action=contracts" title="Nauja ataskaita" style="margin-bottom: 15px" class="button large float-right">nauja ataskaita</a>
<?php   
	} else {
?>
		<div class="warningBox">
			Nurodytu laikotartpiu sutarčių sudaryta nebuvo.
		</div>
<?php
	}
?>