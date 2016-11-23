
           <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
				<?php
				//echo count($get_dashborad_data);
				//print_r($get_dashborad_data);
				$get_unique_sect_name = "";
				$get_unique_menu_name = "";
				$get_unique_sub_menu_name = "";
				$k=0;
				echo ' <ul class="nav side-menu">';
				for($i=0;$i<count($get_dashborad_data );$i++)
				{
				  $section_name = $get_dashborad_data[$i]->remap_section_name;
				  $menu_name    = $get_dashborad_data[$i]->remap_menu_name;
				  $sub_menu_name= $get_dashborad_data[$i]->remap_sub_menu_name;
				  
				 
				  if($get_unique_sect_name!='' && $get_unique_sect_name!=$section_name)
					{
						echo '</ul>'; //menu ul
					}
					 if($get_unique_sub_menu_name!='' && $get_unique_sub_menu_name!=$sub_menu_name)
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
				 // $menu_name1 = $menu_name;
				 // if($get_unique_menu_name!=$menu_name1)
				 // {
				//	 echo '<ul class="nav child_menu">';					  
				 // }
				 
				   if($get_unique_menu_name!=$menu_name)
					{
						echo'<li><a href="#">';
						echo $get_unique_menu_name=$menu_name;
					    echo '</a>';
						 if($sub_menu_name!='')
						{
							 echo ' <ul class="nav child_menu">';
						}
									  
					}
					 if($get_unique_sub_menu_name!=$sub_menu_name)
						{
							 echo'<li><a href="#">';
						echo $get_unique_sub_menu_name=$sub_menu_name;
					    echo '</a>';
						}
					
					echo '</li>'; // menu li
					
					
					 if($get_unique_sect_name!=$section_name)
				   {
					  
					echo '</li>'; // section li
					
				   }
				   
				   
				   if($sub_menu_name!='' && $get_unique_sub_menu_name!=$sub_menu_name)
						{
							 echo ' <ul class="nav child_menu">';
						}
				   
				   
				   
				   if($get_unique_sub_menu_name!=$sub_menu_name)
					{
						//echo $get_unique_sub_menu_name=$sub_menu_name;
					}
					
		         /* if($get_unique_sect_name!=$section_name)
				   {
					$get_unique_sect_name =$section_name;
					echo '<li><a><i class="fa fa-home"></i>'.$get_unique_sect_name.'<span class="fa fa-chevron-down"></span></a>';   
				   
					
					if($get_unique_menu_name!=$menu_name)
					{
						echo '<ul class="nav child_menu">
						<li><a href="index.html">
						';
						echo $get_unique_menu_name=$menu_name;
						
						echo '</a></li>';
						if($get_unique_sub_menu_name!=$sub_menu_name)
						{
							 echo ' <ul class="nav child_menu">';
							 echo '<li class="sub_menu"><a href="level2.html"><a href="level2.html">';
							 echo $get_unique_sub_menu_name=$sub_menu_name;
							 echo '</a></li></ul>';
							 
						}
						echo '</ul>';
					}
					
				    echo ' </li>';

				   }*/
				   
				  
				   
				}
				echo '</ul>';
				//print_r($get_data); 
				?>
              <!--  <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.html">Leads Dashboard</a></li>
                      <li><a href="index2.html">My Activity</a></li>
                      <li><a href="index3.html">Bucket Leads dasboard</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Call Center Activity<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
						 <li><a href="index3.html">Create Lead (No Scripts)</a></li>
						 <li><a href="index3.html">Data Entry (No Scripts)</a></li>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Inbound</a></li>
                            <li><a href="#level2_1">Outbound New</a></li>
                            <li><a href="#level2_2">Outbound Old</a></li>
                          </ul>
                        
                        <li><a>Scheduling<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Inbound</a>
                            </li>
                            <li><a href="#level2_1">Outbound New</a>
                            </li>
                            <li><a href="#level2_2">Outbound Old</a>
                            </li>
                          </ul>
                        </li>
						<li><a>Confirmation<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Inbound</a>
                            </li>
                            <li><a href="#level2_1">Outbound</a>
                            </li>
                            <li><a href="#level2_2">Modify</a>
                            </li>
                          </ul>
                        </li>
						<li><a>Rescheduling<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu">
								<a href="level2.html">Outbound New</a>
                            </li>
                            <li><a href="#level2_1">Outbound - Old</a>
                            </li>
                          </ul>
                        </li>
						<li><a>Boost Campaigns<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu">
								<a href="level2.html">Campaign 1</a>
                            </li>
                            <li><a href="#level2_1">Campaign 2</a>
                            </li>
							<li><a href="#level2_1">Campaign 3</a>
                            </li>
                          </ul>
                        </li>
					  </ul>
				</li>
				<li><a><i class="fa fa-sitemap"></i>Manager Activity<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					    <li><a>Notification Center<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                             <li><a href="#level2_1">Duplicates</a>
                            </li>
                            <li><a href="#level2_2">Overbook</a>
                            </li>
							 <li><a href="#level2_2">Expired leads</a>
                            </li>
							 <li><a href="#level2_2">Run Request Approval</a>
                            </li>
                          </ul>
                        </li>
						 <li><a>Calender Management<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                             <li><a href="#level2_1">Slot Availability</a>
                            </li>
                            <li><a href="#level2_2">Weekly Run Request By Branch</a>
                            </li>
							 <li><a href="#level2_2">Real Time Calender</a>
                            </li>
                          </ul>
                        </li>
  
					  </ul>
				</li>
				 
				<li><a><i class="fa fa-sitemap"></i> Sales Activity <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="general_elements.html">Lead Assignment</a></li>
                      <li><a href="media_gallery.html">Resulting Leads</a></li>
                      <li><a href="typography.html">Add Sales Consultants</a></li>
					  <li><a href="typography.html">Prior Lead Assignments</a></li>
					  <li><a href="typography.html">Discrepancy</a></li>
					  <li><a href="typography.html">Request Addon/Beback Leads</a></li>
					  </ul>
				</li>
				<li><a><i class="fa fa-bar-chart-o"></i> Reports <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li><a href="general_elements.html">Raw Leads</a></li>
						<li><a href="media_gallery.html">Bucket leads</a></li>
						<li><a href="media_gallery.html">Media Source leads</a></li>
						<li><a href="typography.html">Sales Conversion</a></li>
						<li><a href="typography.html">Agent Activity</a></li>
						<li><a href="typography.html">Sales Rep Activity</a></li>
						<li><a href="typography.html">History of Leads</a></li>
						<li><a href="typography.html">Find my Lead</a></li>
					</ul>
				</li>
				<li><a><i class="fa fa-sitemap"></i> Admin <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li><a href="general_elements.html">MDM</a></li>
						<li><a href="general_elements.html">Add New Calender</a></li>
						<li><a href="general_elements.html">Leads Queue Reappear Timing</a></li>
						<li><a href="general_elements.html">Bucket Leads Attempts</a></li>
						<li><a href="general_elements.html">Life of Leads in Days</a></li>
						<li><a href="general_elements.html">Agent Role Access Management</a></li>
						<li><a href="general_elements.html">Agent Group Access Management</a></li>
						
					</ul>
				</li>					
				<li><a><i class="fa fa-sitemap"></i> Remap API <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
					        <li class="sub_menu">
								<a href="level2.html">Lead Create</a>
                            </li>
                            <li><a href="#level2_1">Lead Update</a>
                            </li>
							<li><a href="#level2_1">Lead Search</a>
                            </li>
							<li><a href="#level2_1">Sales Consultant Mywork Day</a>
                            </li>
							<li><a href="#level2_1">Sales Manager Mywork Day</a>
                            </li>
							<li><a href="#level2_1">Lead Result</a>
                            </li>
							<li><a href="#level2_1">Lead Details</a>
                            </li>
							<li><a href="#level2_1">Create Addon Lead</a>
                            </li>
					</ul>
				</li>	
                </ul>-->
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
              </div>

            </div>
		
			