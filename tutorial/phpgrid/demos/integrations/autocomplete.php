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

$grid["caption"] = "Group Headers"; // expand grid to screen width
$grid["autowidth"] = true; // expand grid to screen width
$grid["multiselect"] = false; // allow you to multi-select through checkboxes
$grid["form"]["position"] = "center";
$grid["view_options"] = array("width"=>"500");

$g->set_options($grid);

$g->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"view"=>true, // allow/disallow delete
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"search" => "advance", // show single/multi field search condition (e.g. simple or advance)
						"showhidecolumns" => false
					) 
				);

// this db table will be used for add,edit,delete
$g->table = "clients";

$col = array();
$col["title"] = "Id";
$col["name"] = "client_id"; 
$col["width"] = "20";
$col["editable"] = true;
$cols[] = $col;	

$col = array();
$col["title"] = "Name";
$col["name"] = "name"; 
$col["editable"] = true;
$col["width"] = "80";
$col["formatter"] = "autocomplete"; // autocomplete
$col["formatoptions"] = array(	"sql"=>"SELECT name as k, name as v FROM clients",
								"search_on"=>"name", 
								"update_field" => "name");
$cols[] = $col;	

$col = array();
$col["title"] = "Gender";
$col["name"] = "gender"; 
$col["width"] = "30";
$col["editable"] = true;
$cols[] = $col;	

$col = array();
$col["title"] = "Company";
$col["name"] = "company"; 
$col["editable"] = true;
$col["edittype"] = "textarea"; 
$col["editoptions"] = array("rows"=>2, "cols"=>20); 
$cols[] = $col;	

$col = array();
$col["title"] = "Code";
$col["name"] = "client_id"; 
$col["width"] = "40";
$col["editable"] = true;
$cols[] = $col;

$g->set_columns($cols);

// group columns header
$g->set_group_header( array(
						    "useColSpanStyle"=>true,
						    "groupHeaders"=>array(
						        array(
						            "startColumnName"=>'name', // group starts from this column
						            "numberOfColumns"=>2, // group span to next 2 columns
						            "titleText"=>'Personal Information' // caption of group header
						        ),
						        array(
						            "startColumnName"=>'company', // group starts from this column
						            "numberOfColumns"=>2, // group span to next 2 columns
						            "titleText"=>'Company Details' // caption of group header
						        )
						    )
						)
					);

// generate grid output, with unique grid name as 'list1'
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
</head>
<body>
	<div style="margin:10px">
	<?php echo $out?>
	</div>
</body>
</html>