<nav aria-label="Page navigation example">
	<ul class="pagination justify-content-center"">
		<?php foreach ($paging->data as $key => $value) {
			$activeClass = "";
			if($value['isActive'] == 1) {
				$activeClass = " active";
			}
			echo "<li class='page-item{$activeClass}'><a class='page-link' href='index.php?module={$module}&action=list&page={$value['page']}' title=''>{$value['page']}</a></li>";
		} ?>
	</ul>
</nav>