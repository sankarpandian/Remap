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

// master grid
$grid = new jqgrid();
$opt["caption"] = "Clients Data";
$opt["height"] = "150";
// following params will enable subgrid -- by default first column (PK) of parent is passed as param 'id'
$opt["detail_grid_id"] = "list2";

// extra params passed to detail grid, column name comma separated
$opt["subgridparams"] = "client_id,gender,company";
$opt["multiselect"] = false;
$opt["export"] = array("filename"=>"my-file", "sheetname"=>"test", "format"=>"pdf");
$opt["export"]["range"] = "filtered";
$grid->set_options($opt);
$grid->table = "clients";

$grid->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>false, // show/hide row wise edit/del/save option
						"export"=>true, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);
				
$out_master = $grid->render("list1");

// detail grid
$grid = new jqgrid();

$opt = array();
$opt["sortname"] = 'id'; // by default sort grid by this field
$opt["sortorder"] = "desc"; // ASC or DESC
$opt["height"] = ""; // autofit height of subgrid
$opt["caption"] = "Invoice Data"; // caption of grid
$opt["multiselect"] = true; // allow you to multi-select through checkboxes
$opt["export"] = array("filename"=>"my-file", "sheetname"=>"test", "format"=>"pdf"); // export to excel parameters
$opt["export"]["range"] = "filtered";
// Check if master record is selected before detail addition
$opt["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('Please select master record first'); return false; } }";
$grid->set_options($opt);

$grid->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"export"=>true, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);


// receive id, selected row of parent grid
$id = intval($_GET["rowid"]);
$gender = $_GET["gender"];
$company = $_GET["company"];
$cid = intval($_GET["client_id"]);

// for non-int fields as PK
// $id = (empty($_GET["rowid"])?0:$_GET["rowid"]);

// and use in sql for filteration
$grid->select_command = "SELECT id,client_id,invdate,amount,tax,note,total,'$company' as 'company' FROM invheader WHERE client_id = $id";
// this db table will be used for add,edit,delete
$grid->table = "invheader";

$col = array();
$col["title"] = "Id"; // caption of column
$col["name"] = "id"; // field name, must be exactly same as with SQL prefix or db field
$col["width"] = "10";
$col["formoptions"] = array("rowpos"=>"1", "colpos"=>"1");
$cols[] = $col;	

$col = array();
$col["title"] = "Company"; // caption of column
$col["name"] = "company"; // field name, must be exactly same as with SQL prefix or db field
$col["width"] = "100";
$col["editable"] = false;
$col["formoptions"] = array("rowpos"=>"1", "colpos"=>"2");
$col["show"] = array("list"=>true,"edit"=>true,"add"=>false,"view"=>false);
$cols[] = $col;	

$col = array();
$col["title"] = "Client";
$col["name"] = "client_id";
$col["width"] = "100";
$col["align"] = "left";
$col["hidden"] = true;
$col["editable"] = true;
$col["edittype"] = "select"; // render as select
$col["editrules"] = array("edithidden"=>true);
$col["editoptions"]["onload"]["sql"] = "select distinct client_id as k, name as v from clients WHERE client_id = '$cid'"; 
$col["editoptions"]["onchange"]["sql"] = "select note as k, note as v from invheader WHERE client_id = '{client_id}'"; 
$col["editoptions"]["onchange"]["update_field"] = "note"; 
$cols[] = $col;

$col = array();
$col["title"] = "Invoices";
$col["name"] = "note";
$col["width"] = "100";
$col["search"] = true;
$col["editable"] = true;
$col["edittype"] = "select"; // render as select
$col["editrules"] = array("edithidden"=>true);
$col["editoptions"]["onload"]["sql"] = "select note as k, note as v from invheader WHERE client_id = '$cid'"; 
$cols[] = $col;

$grid->set_columns($cols);
$e["on_insert"] = array("add_client", null, true);
$grid->set_events($e);

function add_client(&$data)
{
	$id = intval($_GET["rowid"]);
	$data["params"]["client_id"] = $id;
}

// generate grid output, with unique grid name as 'list1'
$out_detail = $grid->render("list2");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/themes/start/jquery-ui.custom.css"></link>	
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/jqgrid/css/ui.jqgrid.css"></link>	
	
	<script src="../../lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="../../lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
</head>
<body>
	<div style="margin:10px">
	Master Detail Grid, on same page
	<br>
	<br>
	<?php echo $out_master ?>
	<br>
	<br>
	<?php echo $out_detail; ?>
	</div>
</body>
</html>
