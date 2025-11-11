<!DOCTYPE html>

<html lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<meta name="description" content="">

	<meta name="author" content="">



	<title>Login</title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/themes/admin-lte/styles/style.min.css">



	<!-- Waves Effect -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/themes/admin-lte/plugin/waves/waves.min.css">



</head>



<body>



<div id="single-wrapper">


	<form method="POST" class="frm-single" action="<?php echo base_url(); ?>">

		<div class="inside">

			<div class="title"><strong>Laris</strong>23</div>

			<!-- /.title -->

			<div class="frm-title">Login</div>

            <?php echo $this->session->flashdata('data'); ?>
			<!-- /.frm-title -->

			<div class="frm-input"><input type="text" name="username" placeholder="Username" class="frm-inp"><i class="fa fa-user frm-ico"></i></div>

			<!-- /.frm-input -->

			<div class="frm-input"><input type="password" name="password" placeholder="Password" class="frm-inp"><i class="fa fa-lock frm-ico"></i></div>

			<!-- /.frm-input -->

			

			<!-- /.clearfix -->

			<button type="submit" name="login" class="frm-submit">Login<i class="fa fa-arrow-circle-right"></i></button>

			

			<!-- /.row -->

			<!-- /.footer -->

		</div>

		<!-- .inside -->

	</form>

	<!-- /.frm-single -->

</div><!--/#single-wrapper -->



	<!-- 

	================================================== -->

	<!-- Placed at the end of the document so the pages load faster -->

	<script src="<?php echo base_url(); ?>assets/public/themes/admin-lte/scripts/jquery.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/public/themes/admin-lte/scripts/modernizr.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/public/themes/admin-lte/plugin/bootstrap/js/bootstrap.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/public/themes/admin-lte/plugin/nprogress/nprogress.js"></script>

	<script src="<?php echo base_url(); ?>assets/public/themes/admin-lte/plugin/waves/waves.min.js"></script>



	<script src="<?php echo base_url(); ?>assets/public/themes/admin-lte/scripts/main.min.js"></script>

</body>

</html>