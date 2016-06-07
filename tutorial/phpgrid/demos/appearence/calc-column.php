
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
$col["name"] = "client_id"; 
$col["width"] = "10";
$col["editable"] = true;
$cols[] = $col;		


$col = array();
$col["title"] = "Formula"; // caption of column
$col["name"] = "cal_field"; 
$col["width"] = "20";
$col["editable"] = false;
$cols[] = $col;	

$col = array();
$col["title"] = "Client";
$col["name"] = "name";
$col["width"] = "100";
$col["search"] = true;
$col["editable"] = true;
$col["export"] = false; // this column will not be exported
$cols[] = $col;

$col = array();
$col["title"] = "Diff";
$col["name"] = "diff";
$col["width"] = "20";
$col["search"] = true;
$col["editable"] = false;
$cols[] = $col;

$col = array();
$col["title"] = "Calc Text";
$col["name"] = "newcol";
$col["width"] = "100";
$col["search"] = true;
$col["editable"] = false;
$cols[] = $col;

$grid["sortname"] = 'client_id'; // by default sort grid by this field
$grid["sortorder"] = "desc"; // ASC or DESC
$grid["caption"] = "Clients Data"; // caption of grid
$grid["autowidth"] = true; // expand grid to screen width
$grid["multiselect"] = false; // allow you to multi-select through checkboxes
$grid["reloadedit"] = true;

$g->set_options($grid);

$g->set_actions(array(	
						"add"=>false, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);

// you can provide custom SQL query to display data
$g->select_command = "SELECT * FROM clients";

// this db table will be used for add,edit,delete
$g->table = "clients";

// pass the cooked columns to grid
$g->set_columns($cols);

$e["on_data_display"] = array("filter_display", null, true);
$g->set_events($e);

function filter_display($data)
{
	foreach($data["params"] as &$d)
	{
		$d["cal_field"] = "<a href='/index.php?i=".md5($d["client_id"])."'>Click Me</a>";
		$d["newcol"] = "Hello, ".$d["name"] . " ({$d["client_id"]})";
		$d["diff"] = 200-$d["client_id"];
	}
}


// generate grid output, with unique grid name as 'list1'
$out = $g->render("list1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/themes/smoothness/jquery-ui.custom.css"></link>	
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