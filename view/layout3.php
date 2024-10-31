<?php
    if (!defined('ABSPATH')) exit; //Exit if accessed directly.

    include( MPG_PLUGIN_PATH . 'view/functions/mpgCreatePages.php');
    include( MPG_PLUGIN_PATH . 'view/functions/mpgCreateLayout.php');
?>
<!-- excel file reader inputs -->
<input type="file" id="excelfile" onchange="Export()" />
<!-- button that gets all the data from excel file -->
<input type="button" id="viewfile" value="Convert to the Pages" onclick="retrieveData()" class="button button-primary" />

<?php	
	mpgCreateLayout();
?>
<script>
//script for count characters in textarea
  document.getElementById('meta-description-textarea').onkeyup = function() {
    document.getElementById('count').innerHTML = "Characters: " + (this.value.length);
};
</script>
	<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $create_pages = new mpgCreatePages();
    $create_pages->mpg_insertPages($_POST);
}
?>
