		<div id="nld-wrapper">
		 	<div class="nld-sidebar">
		    <div class="nld-toggle"><i class="fa fa-bars"></i></div>
		    <div class="nld-navblock">
		    	<div class="menu-space">
		        	<div class="content">
		         		<div class="sidebar-logo">
		            		<div class="logo"><a href="/dashboard"></a></div>
		         		</div>
		          		<div class="side-user">
		          			<a href="/member/profile/<?php echo $this->session->userdata(md5('nld_member_id'));?>">
				            <div class="avatar"><img src="<?php echo base_url('asset/member-images/'.$this->session->userdata(md5('nld_member_image')));?>" alt="Avatar" /></div>
				            <div class="info">
				            	<p> <?php echo $this->session->userdata(md5('nld_member_name'));?></p>
				            </div>
				            </a>
		          		</div>
		          		<ul class="nld-vnavigation">
		          		<?php
		          			$menu_array = array(array('link' => 'dashboard', 'icon' => 'fa fa-home', 'text' => lang('common_dashboard')),
		          								array(array('link' => '#', 'icon' => 'fa fa-location-arrow', 'text' => lang('common_location')),
		          									  array('link' => 'region', 'icon' => 'fa fa-sitemap', 'text' => lang('common_region')),
		          									  array('link' => 'township', 'icon' => 'fa fa-sitemap', 'text' => lang('common_township')),
		          									  array('link' => 'sector', 'icon' => 'fa fa-sitemap', 'text' => lang('common_sector'))),
		          								array('link' => 'office', 'icon' => 'fa fa-building-o', 'text' => lang('common_office')),
		          								array('link' => 'member', 'icon' => 'fa fa-user', 'text' => lang('common_member')),
		          								array('link' => 'member_group', 'icon' => 'fa fa-users', 'text' => lang('common_member_group')),
		          								array('link' => 'logout', 'icon' => 'fa fa-sign-in', 'text' => lang('common_logout')));

		          			$temp_permission = $this->Member_group_model->get_data_by_id($this->session->userdata(md5('nld_member_group')))->row_array();

		          			foreach ($menu_array as $menu)
		         			{
		          				if(isset($menu[0]))
		          				{
		          		?>
		          				<li><a href="#"><i class="<?php echo $menu[0]['icon']?>"></i><span><?php echo $menu[0]['text']?></span></a>
		          					<ul class="sub-menu">
		          				<?php
		          					for($i = 1; $i < sizeof($menu); $i++)
		          					{
		          						if($temp_permission['permission_'.$menu[$i]['link'].'_view'] == 1)
		          						{
			          						if($menu[$i]['text'] == $page_title)
			          						{
		          				?>
										<li class="active">
								<?php
											}
			          						else
			          						{
		          				?>
		          						<li>
		          				<?php
		          							}
		          				?>
										<a href="<?php echo '/'.$menu[$i]['link']?>"><i class="<?php echo $menu[$i]['icon']?>"></i><span><?php echo $menu[$i]['text']?></span></a></li>
								<?php
		          						}
		          					}
		          				?>
		          					</ul>
		          				</li>
		          		<?php
		          				}
		          				else
		          				{
		          					if($menu['link'] == 'dashboard' || $menu['link'] == 'member' || $menu['link'] == 'logout' || $temp_permission['permission_'.$menu['link'].'_view'] == 1)
		          					{
				          				if($menu['text'] == $page_title)
				          				{
			          	?>
			          			<li class="active">
			          	<?php
				          				}			          	
				          				else
				          				{
			          	?>
			          			<li>
			          	<?php
			          					}
			          	?>
			          				<a href="<?php echo '/'.$menu['link']?>"><i class="<?php echo $menu['icon']?>"></i><span><?php echo $menu['text']?></span></a>
			          			</li>
			          	<?php
			          				}
			          			}
		          			}
		          		?>
		          		</ul>
    				</div>
  				</div>
			</div>
			</div>
			<div class="container-fluid" id="pcont">
				<div id="head-nav" class="navbar navbar-default">
					<div class="container-fluid">
				    	<div class="navbar-collapse">
				        	<ul class="nav navbar-nav navbar-right user-nav">
				          		<li class="dropdown profile_menu alert-primary"><a href="/logout"><i class="fa fa-sign-in fa-lg"></i></a></li>
				          	</ul>
				      	</div>
				    </div>
				</div>