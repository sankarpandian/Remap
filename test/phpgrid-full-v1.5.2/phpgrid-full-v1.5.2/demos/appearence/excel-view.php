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

$grid["scroll"] = true; // by default 20
$grid["caption"] = "Invoice Data"; // caption of grid
$grid["autowidth"] = true; // expand grid to screen width
$grid["export"] = array("filename"=>"my-file", "sheetname"=>"test"); // export to excel parameters

// excel visual params
$grid["cellEdit"] = true; // inline cell editing, like spreadsheet
$grid["rownumbers"] = true;
$grid["rownumWidth"] = 30;

$g->set_options($grid);

$g->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"export"=>true, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);

// you can provide custom SQL query to display data
$g->select_command = "SELECT * FROM invheader";

// this db table will be used for add,edit,delete
$g->table = "invheader";

// pass the cooked columns to grid
$g->set_columns($cols);

// server-validation & custom events work on excel view, but only first (pk) and changed column is available
$e["on_update"] = array("update_client", null, true);
$g->set_events($e);

function update_client($data)
{
	/*
		These comments are just to show the input param format

		$data => Array
		(
			[id] => 2
			[params] => Array
				(
					[amount] => 400
				)

		)
	*/

	if (isset($data["params"]["amount"]))
	{
		if ($data["params"]["amount"] < 100)
			phpgrid_error("Amount must be greater than 100");

		$str = "UPDATE invheader SET amount={$data["params"]["amount"]}+10
						WHERE id = {$data["id"]}";
						echo "$str";

		mysql_query($str);
	}
}
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
	.ui-jqgrid tr.jqgrow td {
		height: 25px;
	}
	</style>
	<script type="text/javascript">
		var opts = {
		    errorCell: function(res,stat,err)
		    {
				jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,
											'<div class=\"ui-state-error\">'+ res.responseText +'</div>', 
											jQuery.jgrid.edit.bClose,
											{buttonalign:'right'}
										);		    	
		    }
		};	
	</script>
	<div style="margin:10px">
	<?php echo $out?>
	</div>
</body>
</html>