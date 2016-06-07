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

$grid["caption"] = "Clients"; // caption of grid
$grid["autowidth"] = true; // expand grid to screen width
$grid["multiselect"] = false; // allow you to multi-select through checkboxes

// export to excel parameters - range could be "all" or "filtered"
$grid["export"] = array("format"=>"xls", "filename"=>"my-file", "heading"=>"Export to Excel Test", "range" => "filtered");

$g->set_options($grid);

$g->set_actions(array(	
						"add"=>false, // allow/disallow add
						"edit"=>false, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"export"=>true, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);

// this db table will be used for add,edit,delete
$g->table = "clients";

// params are array(<function-name>,<class-object> or <null-if-global-func>,<continue-default-operation>)
$e["on_export"] = array("custom_export", null, false);
$g->set_events($e);

// custom on_export callback function
function custom_export($param)
{
	$sql = $param["sql"]; // the SQL statement for export
	$grid = $param["grid"]; // the complete grid object reference

	if ($grid->options["export"]["format"] == "xls")
	{
		function xlsBOF(){
			echo pack("ssssss",0x809,0x8,0x0,0x10,0x0,0x0);
			return;
		}

		function xlsEOF(){
			echo pack("ss",0x0A,0x00);
			return;
		}

		function xlsWriteNumber($Row,$Col,$Value){
			echo pack("sssss",0x203,14,$Row,$Col,0x0);
			echo pack("d",$Value);
			return;
		}

		function xlsWriteLabel($Row,$Col,$Value){
			$L= strlen($Value);
			echo pack("ssssss",0x204,8+$L,$Row,$Col,0x0,$L);
			echo $Value;
			return;
		}

		//Query Database
		$rs=mysql_query($sql);

		//Send Header
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate,post-check=0,pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=".$grid->options["export"]["filename"].".xls");
		header("Content-Transfer-Encoding: binary");

		//XLS Data Cell
		xlsBOF();
		if(!empty($grid->options["export"]["heading"])){
			xlsWriteLabel(0,0,$grid->options["export"]["heading"]);
		}

		$col=0;
		$rs_cols = mysql_fetch_assoc($rs);

		foreach($rs_cols as $k=>$v)
		{
			xlsWriteLabel(2,$col,ucwords($k));
			$col++;
		}

		mysql_data_seek($rs,0);

		$total=mysql_num_rows($rs);
		$xlsRow=3;
		while($rec = mysql_fetch_row($rs))
		{
			for($i=0;$i<$total;$i++)
			{
				xlsWriteLabel($xlsRow,$i,utf8_decode($rec[$i]));
			}
			$xlsRow++;
		}

		xlsEOF();
		exit();
	}
	else if ($grid->options["export"]["format"] == "csv")
	{
		// for big datasets, export without using array to avoid memory leaks
		
		$result = $grid->execute_query($sql);

		foreach ($grid->options["colModel"] as $c)
			$header[$c["name"]] = $c["title"];
		
		if (strstr($grid->options["export"]["filename"],".csv") === false)
			$grid->options["export"]["filename"] .= ".csv";
							
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename='.$grid->options["export"]["filename"]);		

		$fp = fopen('php://output', 'w');
		
		// push rows header
		fputcsv($fp, $header);
		
		// push rows
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
			fputcsv($fp, $row);
		
		die;
	}
	else if ($grid->options["export"]["format"] == "pdf")
	{
		// your custom pdf generation code goes here ...		
	}

}

// Example Export handler if want to redirect using other file
function custom_export_external($param)
{
	$cols_skip = array();
	$titles = array();
	foreach ($grid->options["colModel"] as $c)
	{
		if ($c["export"] === false)
			$cols_skip[] = $c["name"];

		$titles[$c["index"]] = $c["title"];
	}
	
	$_SESSION["phpgrid_sql"]=$sql;
	$_SESSION["phpgrid_filename"]=$grid->options["export"]["filename"];
	$_SESSION["phpgrid_heading"]=$grid->options["export"]["heading"];
	$_SESSION["phpgrid_cols_skip"]=serialize($cols_skip);
	$_SESSION["phpgrid_cols_title"]=serialize($titles);

	// just for example
	header("Location: export-external.php");
	die();	
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
	<br>
	<?php echo $out?>
	</div>
</body>
</html>