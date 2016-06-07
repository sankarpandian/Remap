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
// following params will enable subgrid -- by default first column (PK) of parent is passed as param 'id'
$opt["detail_grid_id"] = "list2,list3";
$opt["height"] = "200";
$opt["width"] = "820";
$grid->set_options($opt);
$grid->table = "clients";

$f2 = array();
$f2["column"] = "name";
$f2["op"] = "cn";
$f2["value"] = "maria";
$f2["css"] = "'background-color':'#f56b0a'";
$f2_conditions[] = $f2;
$grid->set_conditional_css($f2_conditions);

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
$opt["height"] = "100";
$opt["width"] = "400";
$opt["caption"] = "Invoice Data"; // caption of grid
$opt["multiselect"] = true; // allow you to multi-select through checkboxes
$opt["export"] = array("filename"=>"my-file", "sheetname"=>"test"); // export to excel parameters
$grid->set_options($opt);

$f2_conditions = array();
$f2 = array();
$f2["column"] = "amount";
$f2["op"] = "cn";
$f2["value"] = "200";
$f2["css"] = "'background-color':'#8bf471'";
$f2_conditions[] = $f2;
$grid->set_conditional_css($f2_conditions);

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
// and use in sql for filteration
$grid->select_command = "SELECT id,client_id,invdate,amount,tax,total FROM invheader WHERE client_id = $id";
// this db table will be used for add,edit,delete
$grid->table = "invheader";

$col = array();
$col["title"] = "Id"; // caption of column
$col["name"] = "id"; // field name, must be exactly same as with SQL prefix or db field
$col["width"] = "10";
$cols[] = $col;	

$col = array();
$col["title"] = "Client Id";
$col["name"] = "client_id";
$col["width"] = "10";
$col["editable"] = true;
$col["hidden"] = true;
$cols[] = $col;		

$col = array();
$col["title"] = "Date";
$col["name"] = "invdate";
$col["width"] = "50";
$col["editable"] = true; // this column is editable
$col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
$col["editrules"] = array("required"=>true); // and is required
$cols[] = $col;

$col = array();
$col["title"] = "Amount";
$col["name"] = "amount";
$col["width"] = "50";
$col["editable"] = true; // this column is editable
$col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
$col["editrules"] = array("required"=>true); // and is required
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
$out_list2 = $grid->render("list2");

// another detail grid.

$grid = new jqgrid();

$opt = array();
$opt["sortname"] = 'id'; // by default sort grid by this field
$opt["sortorder"] = "desc"; // ASC or DESC
$opt["height"] = "100";
$opt["width"] = "400";
$opt["caption"] = "Invoice Detail Grid 2"; // caption of grid
$grid->set_options($opt);

$grid->set_actions(array(	
						"add"=>false, // allow/disallow add
						"edit"=>false, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>false, // show/hide row wise edit/del/save option
						"export"=>true, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);

// receive id, selected row of parent grid
$id = intval($_GET["rowid"]);
// and use in sql for filteration
$grid->select_command = "SELECT id,client_id,invdate,amount,tax,total FROM invheader WHERE client_id = $id";
// this db table will be used for add,edit,delete
$grid->table = "invheader";

$col = array();
$col["title"] = "Id"; // caption of column
$col["name"] = "id"; // field name, must be exactly same as with SQL prefix or db field
$col["width"] = "10";
$cols[] = $col;	

$col = array();
$col["title"] = "Client Id";
$col["name"] = "client_id";
$col["width"] = "10";
$col["editable"] = true;
$col["hidden"] = true;
$cols[] = $col;		

$col = array();
$col["title"] = "Date";
$col["name"] = "invdate";
$col["width"] = "50";
$col["editable"] = true; // this column is editable
$col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
$col["editrules"] = array("required"=>true); // and is required
$cols[] = $col;

$f2_conditions = array();
$f2 = array();
$f2["column"] = "tax";
$f2["op"] = "cn";
$f2["value"] = "40";
$f2["css"] = "'background-color':'#FF704D'";
$f2_conditions[] = $f2;
$grid->set_conditional_css($f2_conditions);

// generate grid output, with unique grid name as 'list1'
$out_list3 = $grid->render("list3");

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
	Master Detail Grid, on same page
	<br>
	<br>
	<?php echo $out_master ?>
	<br>
	
	<div style="float:left">
	<?php echo $out_list2?>
	</div>	
	<div style="float:left; margin-left:20px">
	<?php echo $out_list3?>
	</div>
	
	
	</div>
</body>
</html>