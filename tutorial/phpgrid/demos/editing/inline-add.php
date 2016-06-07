<?php
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.5.2
 * @license: see license.txt included in package
 */
 
// include db config
include_once("../../config.php");

// set up DB
mysql_connect(PHPGRID_DBHOST, PHPGRID_DBUSER, PHPGRID_DBPASS);
mysql_select_db(PHPGRID_DBNAME);

// include and create object
include(PHPGRID_LIBPATH."inc/jqgrid_dist.php");

$g = new jqgrid();

$col = array();
$col["title"] = "Id"; // caption of column
$col["name"] = "id"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias) 
$col["width"] = "10";
$cols[] = $col;		

$col = array();
$col["title"] = "Client Id"; // caption of column
$col["name"] = "client_id"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias) 
$col["width"] = "10";
$col["editable"] = true;
$cols[] = $col;		

$col = array();
$col["title"] = "Date";
$col["name"] = "invdate"; 
$col["width"] = "30";
$col["editable"] = true; // this column is editable
$col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
$col["editrules"] = array("required"=>true); // and is required
$col["formatter"] = "date"; // format as date
$cols[] = $col;

$col = array();
$col["title"] = "Amount"; // caption of column
$col["name"] = "amount"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias) 
$col["width"] = "30";
$col["editable"] = true;
$cols[] = $col;		

$col = array();
$col["title"] = "Total"; // caption of column
$col["name"] = "total"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias) 
$col["width"] = "30";
$col["editable"] = true;
$cols[] = $col;		

$col = array();
$col["title"] = "Note"; // caption of column
$col["name"] = "note"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias) 
$col["width"] = "50";
$col["editable"] = true;
$cols[] = $col;		

// set few params
$grid["caption"] = "Sample Grid";
$g->set_options($grid);


// disable all dialogs except edit
$g->navgrid["param"]["edit"] = false;
$g->navgrid["param"]["add"] = false;
$g->navgrid["param"]["del"] = false;
$g->navgrid["param"]["search"] = false;
$g->navgrid["param"]["refresh"] = true;

// enable inline editing buttons
$g->set_actions(array(	
						"inline"=>true,
						"rowactions"=>true
					) 
				);
			
// set database table for CRUD operations
$g->table = "invheader";

$g->set_columns($cols);

// render grid
$out = $g->render("list1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/themes/redmond/jquery-ui.custom.css"></link>	
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/jqgrid/css/ui.jqgrid.css"></link>	
	
	<script src="../../lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="../../lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>

	<script src="//cdn.jsdelivr.net/jquery.hotkeys/0.8b/jquery.hotkeys.js"></script>
</head>
<body>
	<div style="margin:10px">
	<?php echo $out?>
	</div>
	
	<script>
	// insert key to add new row, tab to focus on save icon & press enter to save
	$(document).bind('keyup', 'insert', function(){
		  jQuery('#list1_iladd').click();
		});
	</script>
</body>
</html>
