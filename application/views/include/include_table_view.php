				<div class="nld-mcont">		
					<div class="row">
						<div class="col-md-12">
      						<div class="block-flat">
								<div class="header">							
									<h3><?php echo $sub_page_title;?></h3>
								</div>
								<div class="content">
									<div>
										<button class="btn btn-primary" onclick="window.location.href='/<?php echo $seg1;?>/create'"><i class="fa fa-plus"></i><?php echo lang('common_create');?></button>
									</div>						
									<div class="table-responsive">
									<table class="table no-border hover">
										<thead class="no-border">
											<tr>
											<?php
												foreach ($table_data['header'] as $table_header) 
												{
													echo '<th>'.$table_header.'</th>';
												}
											?>
											</tr>
										</thead>
										<tbody class="no-border-y">	
										<?php
											if(isset($table_data['body']) && is_array($table_data['body']))
											{
												foreach($table_data['body'] as $table_rows)
												{
													echo "<tr>";
													foreach ($table_rows as $table_row) 
													{
														echo '<td>'.$table_row.'</td>';
													}
													echo "</tr>";
												}
											}
										?>								
										</tbody>
									</table>		
									</div>
									<label>
										<input type="text" onkeyup="if(event.keyCode == 13)window.location.href='/<?php echo $seg1;?>/index/'+this.value" class="form-control" value='<?php echo ($search_keyword != 'page' ? $search_keyword: '');?>' placeholder="<?php echo lang('common_search');?>" />
									</label>
								</div>
								<?php echo $this->pagination->create_links();?>
							</div>											
        	       		</div>						
					</div>
				</div> 
			</div>
		</div>
  
		<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.cookie/jquery.cookie.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.pushmenu/js/jPushMenu.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.nanoscroller/jquery.nanoscroller.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.sparkline/jquery.sparkline.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.ui/jquery-ui.js');?>" ></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.gritter/js/jquery.gritter.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/behaviour/core.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap/dist/js/bootstrap.min.js');?>"></script>
	</body>
</html>