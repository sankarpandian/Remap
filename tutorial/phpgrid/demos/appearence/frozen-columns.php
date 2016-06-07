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

// you can customize your own columns ...

$col = array();
$col["title"] = "Id"; // caption of column
$col["name"] = "id"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
$col["width"] = "20";
$col["frozen"] = true;
$col["editable"] = true;
$col["show"] = array("edit"=>true); // only show freezed column in edit dialog
$cols[] = $col;		

$col = array();
$col["title"] = "Date";
$col["name"] = "invdate"; 
$col["frozen"] = true;
$col["editable"] = true; // this column is editable
$col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
$col["editrules"] = array("required"=>true); // required:true(false), number:true(false), minValue:val, maxValue:val
$col["formatter"] = "date"; // format as date
$col["show"] = array("edit"=>true); // only show freezed column in edit dialog
$cols[] = $col;
		
$col = array();
$col["title"] = "Total";
$col["name"] = "total";
$col["editable"] = true;
// default render is textbox
$col["editoptions"] = array("value"=>'10');
$col["show"] = array("edit"=>false);
$cols[] = $col;

$col = array();
$col["title"] = "Closed";
$col["name"] = "closed";
$col["editable"] = true;
$col["edittype"] = "checkbox"; // render as checkbox
$col["editoptions"] = array("value"=>"Yes:No"); // with these values "checked_value:unchecked_value"
$col["show"] = array("edit"=>false);
$cols[] = $col;

$col = array();
$col["title"] = "Note";
$col["name"] = "note";
$col["width"] = "400";
$col["sortable"] = false; // this column is not sortable
$col["search"] = false; // this column is not searchable
$col["editable"] = true;
$col["show"] = array("edit"=>false);
$cols[] = $col;

# Customization of Action column width and other properties
$col = array();
$col["title"] = "Action";
$col["name"] = "act";
$col["width"] = "150";
$cols[] = $col;

$g = new jqgrid();

$grid["rowNum"] = 10; // by default 20
$grid["sortname"] = 'id'; // by default sort grid by this field
$grid["sortorder"] = "desc"; // ASC or DESC
$grid["caption"] = "Invoice Data"; // caption of grid

$grid["width"] = "800"; // expand grid to screen width
$grid["shrinkToFit"] = false; // dont shrink to fit on screen
$grid["sortable"] = false; // it is required for freezed column feature


$g->set_options($grid);

// disable all dialogs except edit
$g->navgrid["param"]["edit"] = false;
$g->navgrid["param"]["add"] = false;
$g->navgrid["param"]["del"] = false;
$g->navgrid["param"]["search"] = false;
$g->navgrid["param"]["refresh"] = false;

// enable inline editing buttons
$g->set_actions(array(	
						"inline"=>true,
						"rowactions"=>true
					) 
				);

// you can provide custom SQL query to display data
$g->select_command = "SELECT i.id, invdate, 
						i.note, i.total, i.closed FROM invheader i";

// this db table will be used for add,edit,delete
$g->table = "invheader";

// pass the cooked columns to grid
$g->set_columns($cols);

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

	<style>
	/* fix for freeze column div position */
	.ui-jqgrid .editable {margin: 0px;}
	</style>
	
	<script>
	jQuery(document).ready(function(){

		setTimeout(function(){
			jQuery('#list1').jqGrid('navButtonAdd', '#list1_pager', 
			{
				'caption'      : 'Freeze Mode', 
				'buttonicon'   : 'ui-icon-extlink', 
				'onClickButton': function()
				{

				   jQuery('div.frozen-div, div.frozen-bdiv').toggle();

				},
				'position': 'last'
			})
		},200);
	});
	</script>
	
	<div style="margin:10px">
	Refresh page to change themes randomly. You can also have your customized theme (jqueryui.com/themeroller).
	<br>
	<br>
	<?php echo $out?>
	</div>
</body>
</html>