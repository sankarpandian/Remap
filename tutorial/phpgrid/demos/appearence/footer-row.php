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

$opt["rowNum"] = 5; // by default 20
$opt["sortname"] = 'id'; // by default sort grid by this field
$opt["sortorder"] = "desc"; // ASC or DESC
$opt["caption"] = "Footer Row"; // caption of grid
$opt["autowidth"] = true; // expand grid to screen width
$opt["multiselect"] = true; // allow you to multi-select through checkboxes
$opt["footerrow"] = true;
$opt["reloadedit"] = true;

$g->set_options($opt);

$g->set_actions(array(
                        "add"=>true, // allow/disallow add
                        "edit"=>true, // allow/disallow edit
                        "delete"=>true, // allow/disallow delete
                        "rowactions"=>true, // show/hide row wise edit/del/save option
                        "search" => "advance", // show single/multi field search condition (e.g. simple or advance)
                        "autofilter" => true
                    )
                );

// you can provide custom SQL query to display data
$g->select_command = "SELECT id,invdate,total,(SELECT sum(total) from invheader) AS table_total FROM invheader";

// this db table will be used for add,edit,delete
$g->table = "invheader";

$cols = array();

$col = array();
$col["title"] = "id";
$col["name"] = "id";
$col["width"] = "100";
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "invdate";
$col["name"] = "invdate";
$col["width"] = "100";
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "total";
$col["name"] = "total";
$col["width"] = "100";
$col["editable"] = true;
$cols[] = $col;

// virtual column for running total
$col = array();
$col["title"] = "running_total";
$col["name"] = "running_total";
$col["width"] = "100";
$col["hidden"] = true;
$cols[] = $col;

// virtual column for grand total
$col = array();
$col["title"] = "table_total";
$col["name"] = "table_total";
$col["width"] = "100";
$col["hidden"] = true;
$cols[] = $col;

// pass the cooked columns to grid
$g->set_columns($cols);

// running total calculation
$e = array();
$e["on_data_display"] = array("pre_render","",true);

$e["js_on_select_row"] = "grid_onselect";
$e["js_on_load_complete"] = "grid_onload";

$g->set_events($e);

function pre_render($data)
{
	$rows = $_GET["jqgrid_page"] * $_GET["rows"];
	$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
	$sord = $_GET['sord']; // get the direction
	
	// same sql as in select_command
	$rs = mysql_fetch_assoc(mysql_query("SELECT SUM(total) as s FROM (SELECT total FROM invheader ORDER BY $sidx $sord LIMIT $rows) AS tmp"));
	foreach($data["params"] as &$d)
	{
		$d["running_total"] = $rs["s"];
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
    <div style="margin:0px;">
	<script>
	// e.g. to show footer summary
	function grid_onload() 
	{
		var grid = $("#list1");

		// sum of displayed result
		sum = grid.jqGrid('getCol', 'total', false, 'sum'); // 'sum, 'avg', 'count' (use count-1 as it count footer row).

		// sum of running total records
		sum_running = grid.jqGrid('getCol', 'running_total')[0];

		// sum of total records
		sum_table = grid.jqGrid('getCol', 'table_total')[0];

		// record count
		c = grid.jqGrid('getCol', 'id', false, 'sum');

		grid.jqGrid('footerData','set', {id: 'Total: ' + sum, invdate: 'Sub Total: '+sum_running, total: 'Grand Total: '+sum_table});
	};
	
	// e.g. to update footer summary on selection
	function grid_onselect() 
	{

		var grid = $("#list1");

		var t = 0;
		var selr = grid.jqGrid('getGridParam','selarrrow'); // array of id's of the selected rows when multiselect options is true. Empty array if not selection 
		for (var x=0;x<selr.length;x++)
		{
			t += parseInt(grid.jqGrid('getCell', selr[x], 'total'));
		}
		grid.jqGrid('footerData','set', {invdate: 'Total: '+t});
	};
	</script>

    <?php echo $out?>
    </div>
</body>
</html>