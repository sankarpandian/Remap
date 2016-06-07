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

session_start();

// preserve selection for ajax call
if (!empty($_POST["tables"]))
{
	$_SESSION["tab"] = $_POST["tables"];
	$tab = $_SESSION["tab"];
}

// update on ajax call
if (!empty($_GET["grid_id"]))
	$tab = $_SESSION["tab"];

if (!empty($tab))
{
	$g = new jqgrid();

	// set few params
	$grid["caption"] = "Grid for '$tab'";
	$grid["width"] = 900;
	$grid["multiselect"] = true;
	$g->set_options($grid);

	// set database table for CRUD operations
	$g->table = $tab;

	$g->set_actions(array(	
							"add"=>false, // allow/disallow add
							"edit"=>true, // allow/disallow edit
							"delete"=>true, // allow/disallow delete
							"bulkedit"=>true, // allow/disallow delete
							"showhidecolumns"=>true, // allow/disallow delete
							"rowactions"=>true, // show/hide row wise edit/del/save option
							"autofilter" => true, // show/hide autofilter for search
						) 
					);

	// render grid
	$out = $g->render("list1_$tab");
}
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
</head>
<body>
	<style>* {font-family: "Open Sans", tahoma;}</style>
	<form method="post">
		<fieldset>
		<legend>Database Tables</legend>
		Select: <select name="tables">
		<?php
			$q = mysql_query('SHOW TABLES');
			while($rs = mysql_fetch_array($q))
			{ 
				$sel = (($rs[0] == $_POST["tables"])?"selected":"");
			?>
				<option <?php echo $sel?>><?php echo $rs[0]?></option>
			<?php
			}
		?>
		</select>
		<input type="submit" value="Load Table">
		</fieldset>
	</form>
	<?php if (!empty($out)) { ?>
	<script src="//cdn.jsdelivr.net/jstorage/0.1/jstorage.min.js" type="text/javascript"></script>	
	<script src="//cdn.jsdelivr.net/json2/0.1/json2.min.js" type="text/javascript"></script>	
	<script src="http://yourjavascript.com/1331549655/jqgrid-state.js" type="text/javascript"></script>	
	<script>
	var opts = {
		"stateOptions": {         
					storageKey: "gridState-<?php echo $tab?>",
					columns: true, // remember column chooser settings
					filters: false, // search filters
					selection: true, // row selection
					expansion: false, // subgrid expansion
					pager: false, // page number
					order: true // field ordering
					}
		};
	</script>	
	<br>
	<fieldset>
		<?php echo $out?>
	</fieldset>	
	<?php } ?>
</body>
</html>