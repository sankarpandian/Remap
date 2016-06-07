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

$grid["height"] = '250'; // by default sort grid by this field
$grid["sortname"] = 'id'; // by default sort grid by this field
$grid["sortorder"] = "asc"; // ASC or DESC
$grid["caption"] = "Invoice Data"; // caption of grid
$grid["autowidth"] = true; // expand grid to screen width
$grid["multiselect"] = false; // allow you to multi-select through checkboxes
$grid["form"]["position"] = "center"; // allow you to multi-select through checkboxes
$g->set_options($grid);

$g->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);

// this db table will be used for add,edit,delete
$g->table = "invheader";
// select query with FK_data as FK_id, e.g. clients.name as client_id
$g->select_command = "SELECT id, invdate, clients.name as client_id, amount, note FROM invheader 
						INNER JOIN clients on clients.client_id = invheader.client_id
						";


$col = array();
$col["title"] = "Id"; // caption of column
$col["name"] = "id"; 
$col["width"] = "10";
$cols[] = $col;		
		
$col = array();
$col["title"] = "Client";
$col["name"] = "client_id";
$col["dbname"] = "clients.name"; // this is required as we need to search in name field, not id
$col["width"] = "100";
$col["align"] = "left";
$col["editable"] = true;
$col["edittype"] = "select"; // render as select
$str = $g->get_dropdown_values("select distinct client_id as k, name as v from clients");
$col["editoptions"] = array("value"=>$str); 
$cols[] = $col;

$col = array();
$col["title"] = "Date";
$col["name"] = "invdate"; 
$col["width"] = "50";
$col["editable"] = true; // this column is editable
$col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
$col["editrules"] = array("required"=>true); // and is required
$col["formatter"] = "date"; // format as date
$col["search"] = false;
$cols[] = $col;

$col = array();
$col["title"] = "Amount";
$col["name"] = "amount"; 
$col["width"] = "50";
$col["editable"] = true; // this column is editable
$col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
$col["editrules"] = array("required"=>true); // and is required
$cols[] = $col;

// file upload column
$col = array();
$col["title"] = "Note";
$col["name"] = "note"; 
$col["width"] = "50";
$col["editable"] = true; // this column is editable
$col["edittype"] = "file"; // render as file
$col["upload_dir"] = "temp"; // upload here
$col["editrules"] = array("ifexist"=>"error"); // "rename", "override" can also be set
$col["show"] = array("list"=>false,"edit"=>true,"add"=>true); // only show in add/edit dialog
$cols[] = $col;

// get upload folder url for display in grid -- change it as per your upload path
$upload_url = explode("/",$_SERVER["REQUEST_URI"]);
array_pop($upload_url);
$upload_url = implode("/",$upload_url)."/";

// virtual column to display uploaded file in grid
$col = array();
$col["title"] = "Image";
$col["name"] = "logo";
$col["width"] = "200";
$col["editable"] = true;
$col["editable"] = true;
// display none if nothing is uploaded, otherwise make link.
$col["condition"] = array('$row["note"] == ""', "None", "<a href='$upload_url/{note}' target='_blank'><img height=100 src='$upload_url/{note}'></a>");
$col["show"] = array("list"=>true,"edit"=>true,"add"=>false); // only show in listing & image in edit
// display image in edit dialog
$col["editoptions"]["dataInit"] = "function(o){jQuery(o).parent().html(o.value);}";
$cols[] = $col;

// pass the cooked columns to grid
$g->set_columns($cols);

// use events if you need custom logic for upload
$e["on_insert"] = array("add_invoice", null, true);
$e["on_update"] = array("update_invoice", null, true);
$e["on_delete"] = array("delete_upload", null, true);
$g->set_events($e);

// generate grid output, with unique grid name as 'list1'
$out = $g->render("list1");

// callback for add
function add_invoice($data)
{
	$upload_file_path = $data["params"]["note"];
	
	// if file is uploaded
	if ($upload_file_path)
	{
		// your custom upload code goes here e.g. File DB insertion
		$f = pathinfo(realpath($upload_file_path));
		
		$ext = pathinfo(realpath($upload_file_path), PATHINFO_EXTENSION);
		if ($ext <> "pdf" && $ext <> "gif" && $ext <> "jpg" && $ext <> "txt" && $ext <> "doc" && $ext <> "bmp" && $ext <> "png")
		{
			unlink(realpath($upload_file_path));
			phpgrid_error("Only pdf, gif, jpg, txt, doc, bmp, png files are allowed!");
		}
		
		// rename file OR place folder
		// rename($f["dirname"]."/".$f["basename"],$f["dirname"]."/"."custom-".$f["basename"]);	
	}
}

// callback for update
function update_invoice($data)
{
	$upload_file_path = $data["params"]["note"];
	$file_content = file_get_contents($upload_file_path);
	// your custom upload code goes here e.g. File DB insertion
}

function delete_upload($data)
{
	$rs = mysql_fetch_assoc(mysql_query("SELECT note FROM invheader WHERE id = {$data[id]}"));
	unlink(realpath($rs["note"]));
}
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
