<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
        <?php
            foreach($breadcrumbItems as $key => $item) {
                if (next($breadcrumbItems)==true) {
                    echo "<li class='breadcrumb-item'><a href='{$item['link']}'>{$item['title']}</a></li>";
                } else {
                    echo "<li class='breadcrumb-item active' aria-current='page'>{$item['title']}</li>";
                }
            }
	    ?>
	</ol>
</nav>