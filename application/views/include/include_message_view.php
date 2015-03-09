				<div class="nld-mcont">		
					<div class="row">
						<div class="col-md-12">
      						<div class="block-flat">
								<div class="header">							
									<h3><?php echo $sub_page_title;?></h3>
								</div>
								<div class="content">
									<?php
										if($message_type == "success")
											echo '<div class="alert alert-success">';
										else
											echo '<div class="alert alert-danger">';
										echo $message;
									?>
									</div>
								</div>
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