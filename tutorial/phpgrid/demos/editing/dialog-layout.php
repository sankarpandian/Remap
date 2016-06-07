<?php
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.5.2
 * @license: see license.txt included in package
 */

/**
 * todos:Grid with 2 column layout, implemented tabindex for vertical tab focusing
 * and custom width & height of dialog boxes
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
$opt["caption"] = "Sample Grid";
$opt["multiselect"] = true;

$opt["export"]["range"] = "filtered"; // or "all"
$opt["form"]["position"] = "center"; // or "all"

// # set add/edit dialog width ... to apply css (see below)

$opt["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420');
$opt["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420');
$opt["add_options"]["topinfo"] = "Add New Client Information. Enter client name, gender and company name.<br />&nbsp;";
$opt["add_options"]["bottominfo"] = "This text is dialog footer text";

// show confirmation box before close
#$opt["edit_options"]["onClose"] = "function(){ return confirm('Are you sure you wish to close?'); }";
#$opt["add_options"]["onClose"] = "function(){ return confirm('Are you sure you wish to close?'); }";

// you can also set top, left position for dialog (after removing $opt["form"]["position"])
// $opt["edit_options"][ = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420', 'top'=>'200', 'left'=>'200');

$opt["view_options"]['width']='520';

// Edit button in view dialog
$opt["view_options"]["beforeShowForm"] = 'function (form) 
				{
	        		$(\'<a href="#">Edit<span class="ui-icon ui-icon-disk"></span></a>\')
	            	.addClass("fm-button ui-state-default ui-corner-all fm-button-icon-left")
	              	.prependTo("#Act_Buttons>td.EditButton")
	              	.click(function() 
							{
		                		jQuery("#cData").click();
		                		jQuery("#edit_list1").click();
		            		});
				}';
 
$opt["edit_options"]["afterShowForm"] = 'function (form) 
				{
	        		$(\'<a href="#">Export<span class="ui-icon ui-icon-disk"></span></a>\')
	            	.addClass("fm-button ui-state-default ui-corner-all fm-button-icon-left")
	              	.prependTo("#Act_Buttons>td.EditButton")
	              	.click(function() 
							{
		                		alert("click!");
		            		});
													
					// insert new form section before specified field
					insert_form_section(form, "client_id", "Section 1");
					insert_form_section(form, "gender", "Section 2");
				}';

// add sample button in add dialog
$opt["add_options"]["afterShowForm"] = 'function (form) 
				{
	        		$(\'<a href="#">Load Default<span class="ui-icon ui-icon-disk"></span></a>\')
	            	.addClass("fm-button ui-state-default ui-corner-all fm-button-icon-left")
	              	.prependTo("#Act_Buttons>td.EditButton")
	              	.click(function() 
							{
		                		alert("click!");
		            		});

					// insert new form section before specified field
					insert_form_section(form, "client_id", "Section 1");
					insert_form_section(form, "gender", "Section 2");
					
		
					// increase colspan and size of field
					jQuery("#client_id").attr("size",61);
					jQuery("#client_id").parent().next().remove();
					jQuery("#client_id").parent().next().remove();
					jQuery("#client_id").parent().attr("colspan",3);
		
				}';


// add sample button in add dialog
$opt["search_options"]["afterShowSearch"] = 'function () 
				{
	        		$(\'<a href="#">Load Default<span class="ui-icon ui-icon-disk"></span></a>\')
	            	.addClass("fm-button ui-state-default ui-corner-all fm-button-icon-left")
	              	.prependTo("td.EditButton:last")
	              	.click(function() 
							{
		                		alert("click!");
		            		});
				}';

$g->set_options($opt);

// set database table for CRUD operations
$g->table = "clients";

$col = array();
$col["title"] = "Id"; // caption of column
$col["name"] = "client_id"; 
$col["width"] = "20";
$col["editable"] = true;
$col["formoptions"] = array("rowpos"=>"1", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"100");
$cols[] = $col;	

$col = array();
$col["title"] = "Name"; // caption of column
$col["name"] = "name"; 
$col["editable"] = true;
$col["formoptions"] = array("rowpos"=>"3", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"101");
$cols[] = $col;	

$col = array();
$col["title"] = "Gender"; // caption of column
$col["name"] = "gender"; 
$col["width"] = "30";
$col["editable"] = true;
$col["formoptions"] = array("rowpos"=>"2", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"102");
$cols[] = $col;	

$col = array();
$col["title"] = "Company"; // caption of column
$col["name"] = "company"; 
$col["editable"] = true;
$col["editrules"] = array ('required' => true);
$col["formoptions"] = array("rowpos"=>"2", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"103");

$cols[] = $col;	

$g->set_columns($cols);

$g->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"view"=>true, // allow/disallow view
						"rowactions"=>true, // show/hide row wise edit/del/save option
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
	
	<script src="../../lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="../../lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
</head>
<body>
	<?php /* css for add/edit dialog editing */ ?>
	<style>
		/* Alternate way if we dont use formoptions */
		/*
		.FormGrid .EditTable .FormData
		{
			float: left;
			width: 200px;
		}
	   */
		/* Give 50px width to all captions */
		.FormGrid .EditTable .FormData .CaptionTD
		{
			width: 50px;
			vertical-align: top;
		}
		
		/* give #closed width of 25px */
		.FormGrid .EditTable .FormData .DataTD #closed
		{
			width: 25px;
		}
	</style>
	<script>
	function insert_form_section(form,beforeField,label) 
	{
		jQuery('<tr class="FormData"><td class="CaptionTD ui-widget-content" colspan="99">' +
		'<div style="padding:3px" class="ui-widget-header ui-corner-all">' +
		'<b>'+label+'</b></div></td></tr>')
		.insertBefore(jQuery('#tr_'+beforeField, form));
	}
	</script>
	<div style="margin:10px">
	<?php echo $out?>
	</div>
</body>
</html>
