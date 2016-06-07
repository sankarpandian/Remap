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
$col["width"] = "30";
$col["export"] = true;
$cols[] = $col;		

$col = array();
$col["title"] = "Client";
$col["name"] = "name";
$col["width"] = "100";
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Gender";
$col["name"] = "gender";
$col["width"] = "100";
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Company";
$col["name"] = "company";
$col["width"] = "100";
$col["editable"] = true;
$cols[] = $col;

// $grid["sortname"] = 'client_id'; // by default sort grid by this field
$grid["sortorder"] = "desc"; // ASC or DESC
$grid["caption"] = "Client Data"; // caption of grid
$grid["autowidth"] = true; // expand grid to screen width
$grid["multiselect"] = false; // allow you to multi-select through checkboxes
$grid["rowNum"] = 100; // allow you to multi-select through checkboxes
$grid["rowList"] = array(100,200,500);
// Predefined standard page formats: http://www.tcexam.org/doc/code/classTCPDF.html#a087d4df77e60b7054e97804069ed32c5
// Orientation: landscape, portrait
$grid["export"] = array("format"=>"pdf", "filename"=>"my-file", "heading"=>"Invoice Details", "orientation"=>"landscape", "paper"=>"a4");
$grid["export"]["render_type"] = "html";

// export pdf using html renderer
$grid["export"]["render_type"] = "html";

// export filtered data or all data
$grid["export"]["range"] = "all"; // or "all"
$g->set_options($grid);

// params are array(<function-name>,<class-object> or <null-if-global-func>)
$e["on_render_pdf"] = array("set_pdf_format", null);
$g->set_events($e);

function set_pdf_format($param)
{
	$grid = $param["grid"];
	$arr = $param["data"];

	$html .= "<h1>".$grid->options["export"]["heading"]."</h1>";
	$html .= '<table border="0" cellpadding="4" cellspacing="2">';
	
	$i = 0;
	foreach($arr as $v)
	{
		$shade = ($i++ % 2) ? 'bgcolor="#efefef"' : '';
		$html .= "<tr>";
		foreach($v as $d)
		{
			// bold header
			if  ($i == 1)
				$html .= "<td bgcolor=\"lightgrey\"><strong>$d</strong></td>";
			else
				$html .= "<td $shade>$d</td>";
		}
		$html .= "</tr>";
	}

	$html .= "</table>";
	
	return $html;
}


$g->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"export"=>true, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);

// this db table will be used for add,edit,delete
$g->table = "clients";
// $g->select_command = "select id, name, description from audios";

// pass the cooked columns to grid
$g->set_columns($cols);

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
