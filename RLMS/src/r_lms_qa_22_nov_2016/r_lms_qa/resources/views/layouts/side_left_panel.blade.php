           <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
				<?php
				//echo count($get_dashborad_data);
			//	print_r($get_dashborad_data);
				$get_unique_sect_name = "";
				$get_unique_menu_name = "";
				$get_unique_sub_menu_name = "";
				$k=0;
				$test=0;
				echo ' <ul class="nav side-menu">';
				for($i=0;$i<count($get_dashborad_data );$i++)
				{
				  $section_name       = $get_dashborad_data[$i]->rs_SectionName;
				  $menu_name          = $get_dashborad_data[$i]->rm_MenuName;
				  $sub_menu_name      = $get_dashborad_data[$i]->rsm_SubMenuName;
				  $datalink           = $get_dashborad_data[$i]->rm_MenuUrl;
				  $remap_sub_menu_url = $get_dashborad_data[$i]->rsm_SubMenuUrl;
				  if($get_unique_sect_name!='' && $get_unique_sect_name!=$section_name)
					{
						echo '</ul>'; //menu ul
					}
					 if($get_unique_sub_menu_name!='' && $get_unique_sub_menu_name!=$sub_menu_name && $get_unique_menu_name!=$menu_name)
					{
						echo "</ul>"; //submenu ul
					}
				  if($get_unique_sect_name!=$section_name)
				   {
					echo '<li><a><i class="fa fa-home"></i>';   
					echo $get_unique_sect_name =$section_name;
					echo '<span class="fa fa-chevron-down"></span></a>';
					echo '<ul class="nav child_menu">';
				   }
				   
							 
				   if($get_unique_menu_name!=$menu_name)
					{

						if($datalink!='')
						{
						if($sub_menu_name!='')
						{ 
							//echo '<span class="fa fa-chevron-down"></span>';
						}

						echo'<li><a href="'.$datalink.'">';
						}
						echo $get_unique_menu_name=$menu_name; 
						if($test==2)
						{
							//echo '<span class="fa fa-chevron-down"></span>';
						}
					    echo '</a>';
						 if($sub_menu_name!='')
						{ 
							 echo ' <ul class="nav child_menu">';
						}
									  
					}
					
					 if($get_unique_sub_menu_name!=$sub_menu_name)
						{
							 $test=1;
							if($remap_sub_menu_url)
							{
							 echo'<li><a href="'.$remap_sub_menu_url.'">';
							}
						echo $get_unique_sub_menu_name=$sub_menu_name;
					    echo '</a>';
						}
					
					echo '</li>'; // menu li
					
					
				   if($get_unique_sect_name!=$section_name)
				   {
					  
					echo '</li>'; // section li
					
				   }
				   
				   
				 //  if($sub_menu_name!='' && $get_unique_sub_menu_name!=$sub_menu_name)
						//{
						//	$test=1;
							// echo ' <ul class="nav sub_menu">';
						//}
				   
				   
				   
				   if($get_unique_sub_menu_name!=$sub_menu_name)
					{
						//echo $get_unique_sub_menu_name=$sub_menu_name;
					}
					
		        
				   
				  
				 $test++;  
				}
				
				echo '</ul>';
				//print_r($get_data); 
				?>
             
              </div>
                <div class="menu_section">
                <h3>Extras</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">FAQ</a></li>
                      <li><a href="projects.html">Helpdesk</a></li>
                      <li><a href="project_detail.html">Help Live</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                </ul>
				 <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Themes <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                     <li><a href="#" data-theme="default" class="theme-link">Default</a></li>
					 <li><a href="#" data-theme="cerulean" class="theme-link">cerulean</a></li>
					 <li><a href="#" data-theme="flatly" class="theme-link">flatly</a></li>
					 <li><a href="#" data-theme="cyborg" class="theme-link">cyborg</a></li>
					 <li><a href="#" data-theme="cosmo" class="theme-link">cosmo</a></li>
					 <li><a href="#" data-theme="journal" class="theme-link">journal</a></li>
                  </li>
                </ul>
              </div>

            </div>
		
			