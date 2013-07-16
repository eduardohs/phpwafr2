<?php
include_once("../inc/common.php");
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php include(SIS_DASHBOARD); ?>
		</div>
    </body>
</html>