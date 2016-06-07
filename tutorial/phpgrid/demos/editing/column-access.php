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

// set few params
$grid["caption"] = "Sample Grid";
$grid["height"] = "250";
$grid["width"] = "1200";
$grid["autowidth"] = true;
// $grid["scroll"] = true;
$grid["multiselect"] = true;
$grid["rowList"] = array();
$grid["rowNum"] = 15;
$grid["form"]["position"] = "center";
$g->set_options($grid);

// set database table for CRUD operations
$g->table = "clients";
// $g->select_command = "clients";


$col = array();
$col["title"] = "Id"; // caption of column
$col["name"] = "client_id"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Name"; // caption of column
$col["name"] = "name"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Gender"; // caption of column
$col["name"] = "gender"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
$col["editable"] = true;
$col["edittype"] = "select";
$col["editoptions"] = array("value" => "male:Male;female:Female");
$col["editrules"] = array("required"=>true, "readonly"=>true, "readonly-when"=>array("==","male"));
$col["show"] = array("list"=>true, "add"=>true, "edit"=>true, "view"=>true);
$cols[] = $col;

$col = array();
$col["title"] = "Company"; // caption of column
$col["name"] = "company"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
$col["editable"] = true;
// $col["formatter"] = "wysiwyg";
$col["editoptions"] = array("defaultValue" => "Default Company");
$cols[] = $col;

$g->set_columns($cols);

$e["js_on_load_complete"] = "grid_load";
$e["js_on_select_row"] = "grid_select";	
$g->set_events($e);

$g->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"view"=>true, // allow/disallow view
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"export"=>true, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);

// render grid
$out = $g->render("list1");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/themes/redmond/jquery-ui.custom.css"></link>	
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/jqgrid/css/ui.jqgrid.css"></link>	
	<script src="../../lib/js/ckeditor/ckeditor.js" type="text/javascript"></script>
	<script src="../../lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="../../lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
</head>
<body>

	<div style="margin:10px">
	<?php echo $out?>
	</div>	

	<script>
	function grid_load()
	{
		var grid = $('#list1');
		var rowids = grid.getDataIDs();
		var columnModels = grid.getGridParam().colModel;

		// check each visible row
		for (var i = 0; i < rowids.length; i++) 
		{
			var rowid = rowids[i];
			var data = grid.getRowData(rowid);

			if (data.name.indexOf("Ana") != -1) // show only edit, no delete
			{     
			  	jQuery("tr#"+rowid+" td[aria-describedby$='_act'] span:first").html(jQuery("tr#"+rowid+" td[aria-describedby$='_act']").find("a:first"));
			}
			else if (data.gender == 'male') // view only
			{     
				jQuery("tr#"+rowid).addClass("not-editable-row");
			  	jQuery("tr#"+rowid+" td[aria-describedby$='_act']").html("-");
			}
			
		}
		
		// for multiselect check all, list1 is grid id
		$("#cb_list1").click(function(){
			
			var selr_one = grid.getGridParam('selrow');
			var selr = [];
			selr = grid.jqGrid('getGridParam','selarrrow'); // array of id's of the selected rows when multiselect options is true. Empty array if not selection 
			if (selr.length < 2 && selr_one)
				selr[0] = selr_one;
				
			for (var x=0;x < selr.length;x++)
			{
				rowid = selr[x];
				var data = grid.getRowData(rowid);

				if (data.name.indexOf("Ana") != -1) // show only edit, no delete
				{
					jQuery("#del_list1").addClass("ui-state-disabled");
				}
				else if (data.gender == 'male') // view only
				{     
					jQuery("#edit_list1").addClass("ui-state-disabled");
					jQuery("#del_list1").addClass("ui-state-disabled");
				}
			}
		});
	}

	function grid_select(id)
	{
		var grid = $('#list1');
		
		var rowid = grid.getGridParam('selrow');
		var data = grid.getRowData(rowid);
		if (data.name.indexOf("Ana") != -1) // show only edit, no delete
		{
			jQuery("#del_list1").addClass("ui-state-disabled");
			jQuery("#edit_list1").removeClass("ui-state-disabled");
		}
		else if (data.gender == 'male') // view only
		{     
			jQuery("#edit_list1").addClass("ui-state-disabled");
			jQuery("#del_list1").addClass("ui-state-disabled");
		}
		else
		{
			jQuery("#edit_list1").removeClass("ui-state-disabled");
			jQuery("#del_list1").removeClass("ui-state-disabled");
		}
		
		// for multiselect
		var rowids = grid.getGridParam('selarrrow');
		if (rowids.length > 1)
		{
			for (var x=0;x < rowids.length;x++)
			{
				rowid = rowids[x];
				var data = grid.getRowData(rowid);

				if (data.name.indexOf("Ana") != -1) // show only edit, no delete
				{
					jQuery("#del_list1").addClass("ui-state-disabled");
				}
				else if (data.gender == 'male') // view only
				{     
					jQuery("#del_list1").addClass("ui-state-disabled");
				}
			}			
		}		
	}
	</script>
</body>
</html>