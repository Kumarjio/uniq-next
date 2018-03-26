<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta information -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<!-- Title-->
<title>Sekolah Tinggi Intelijen Negara</title>
<!-- Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/stin_backend/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/stin_backend/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/stin_backend/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/stin_backend/ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/stin_backend/img/stin_logo.png">
<!-- CSS Stylesheet-->
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/stin_backend/css/bootstrap/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/stin_backend/css/bootstrap/bootstrap-themes.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/stin_backend/css/style.css" />

<!-- Styleswitch if  you don't chang theme , you can delete -->
<link type="text/css" rel="alternate stylesheet" media="screen" title="style1" href="<?php echo base_url(); ?>assets/stin_backend/css/styleTheme1.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style2" href="<?php echo base_url(); ?>assets/stin_backend/css/styleTheme2.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style3" href="<?php echo base_url(); ?>assets/stin_backend/css/styleTheme3.css" />
<link type="text/css" rel="alternate stylesheet" media="screen" title="style4" href="<?php echo base_url(); ?>assets/stin_backend/css/styleTheme4.css" />

</head>
<body class="full-lg">
<div id="wrapper">

<div id="loading-top">
		<div id="canvas_loading"></div>
		<span>Memverifikasi ...</span>
</div>

<div id="main" style="background: #B03060;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="account-wall">
					<section class="align-lg-center">
					<div class="site-logo"></div>
<<<<<<< HEAD
					<h1 class="login-title">PENDAFTARAN TARUNA BARU<br><span style="color: white;">SEKOLAH TINGGI INTELIJEN NEGARA </span><small style="color: white;"> Version 1.1.0 </small></h1>
=======
					<h1 class="login-title" style="color: white;">PENDAFTARAN TARUNA BARU<br><span style="color: white;">SEKOLAH TINGGI INTELIJEN NEGARA </span><small style="color: white;"> Version 1.0.0 </small></h1>
>>>>>>> 564c319f17a97d29177efba561a81642c936e0a6
					</section>
					<br>
					<?php /* echo form_open(base_url().'login/validate', array('class' => 'form-signin')); */ ?>
					<form id="form-signin" class="form-signin">
							<section>
									<div class="input-group">
											<div class="input-group-addon"><i style="color: black;" class="fa fa-user"></i></div>
											<input  type="text" class="form-control" name="usermail" placeholder="Username">
									</div>
									<div class="input-group">
											<div class="input-group-addon"><i style="color: black;" class="fa fa-key"></i></div>
											<input type="password" class="form-control" name="userpass" placeholder="Password">
									</div>
									<button class="btn btn-lg btn-theme-inverse btn-block" type="submit" id="sign-in">LOGIN</button>
							</section>
							<section class="clearfix">
									<!-- <div class="iCheck pull-left"  data-color="red">
									<input type="checkbox" checked>
									<label style="color: white;">Ingat Saya</label>
									</div> -->
									<a href="#" class="pull-right help" style="color: white;" data-toggle="modal" data-target="#forgotPassword">Lupa Password? </a>
							</section>
							<!-- <span class="or" data-text="Or"></span>
							<button class="btn btn-lg  btn-inverse btn-block" type="button"> New account </button> -->
					</form>
					<?php /* echo form_close(); */ ?>
					<div class="footer-link" style="color: white;">&copy; 2018 Sekolah Tinggi Inteligen Negara </div>
				</div>
				<!-- //account-wall-->
			</div>
			<!-- //col-sm-6 col-md-4 col-md-offset-4-->
		</div>
		<!-- //row-->
	</div>
	<!-- //container-->
</div>
<!-- //main-->


</div>
<!-- //wrapper-->

<!-- //modal-->
<div id="forgotPassword" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Permintaan reset password</h4>
      </div>
      <div class="modal-body">
				<form action="/action_page.php">
				  <div class="form-group">
				    <label for="clientId">Masukan E-mail atau NIK anda:</label>
				    <input type="text" class="form-control" id="clientId">
				  </div>
				</form>
				<p class="hide message">&nbsp;<p>
      </div>
      <div class="modal-footer">
				<button type="button" class="btn btn-primary" data-action="submit">Kirim</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div>
<!-- //modal end-->



<!--
////////////////////////////////////////////////////////////////////////
//////////     JAVASCRIPT  LIBRARY     //////////
/////////////////////////////////////////////////////////////////////
-->

<!-- Jquery Library -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/js/jquery.ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/plugins/bootstrap/bootstrap.min.js"></script>
<!-- Modernizr Library For HTML5 And CSS3 -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/js/modernizr/modernizr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/plugins/mmenu/jquery.mmenu.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/js/styleswitch.js"></script>
<!-- Library 10+ Form plugins-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/plugins/form/form.js"></script>
<!-- Datetime plugins -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/plugins/datetime/datetime.js"></script>
<!-- Library Chart-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/plugins/chart/chart.js"></script>
<!-- Library  5+ plugins for bootstrap -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/plugins/pluginsForBS/pluginsForBS.js"></script>
<!-- Library 10+ miscellaneous plugins -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/plugins/miscellaneous/miscellaneous.js"></script>
<!-- Library Themes Customize-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/stin_backend/js/caplet.custom.js"></script>
<script type="text/javascript">
$(function() {
		   //Login animation to center
			function toCenter(){
					var mainH=$("#main").outerHeight();
					var accountH=$(".account-wall").outerHeight();
					var marginT=(mainH-accountH)/2;
						   if(marginT>30){
							   $(".account-wall").css("margin-top",marginT-15);
							}else{
								$(".account-wall").css("margin-top",30);
							}
				}
				toCenter();
				var toResize;
				$(window).resize(function(e) {
					clearTimeout(toResize);
					toResize = setTimeout(toCenter(), 500);
				});

			//Canvas Loading
			  var throbber = new Throbber({  size: 32, padding: 17,  strokewidth: 2.8,  lines: 12, rotationspeed: 0, fps: 15 });
			  throbber.appendTo(document.getElementById('canvas_loading'));
			  throbber.start();

			//Set note alert
			setTimeout(function () {
				$.notific8('Pastikan <strong>Username</strong> dan <strong>Password</strong> anda sesuai untuk dapat mengakses akun anda.',{ sticky:false, horizontalEdge:"top", theme:"inverse" ,heading:"PMB STIN"})
				}, 500);


			$("#form-signin").submit(function(event){
					event.preventDefault();
					var main=$("#main");
					//scroll to top
					main.animate({
						scrollTop: 0
					}, 500);
					main.addClass("slideDown");

					// send username and password to php check login
					$.ajax({
						async: false,
						url: "login/validate", data: $(this).serialize(), type: "POST", dataType: 'json',
						success: function (e) {
								setTimeout(function () { main.removeClass("slideDown") }, !e.status ? 500:3000);
								 if (!e.status) {
									 $.notific8('Periksa Kembali Username Dan Password Anda !! ',{ life:5000,horizontalEdge:"bottom", theme:"danger" ,heading:" Akses Ditolak"});
									return false;
								 }

								 var link = e.group;
								 //console.log(link);

								 setTimeout(function () { $("#loading-top span").text("Akses Diterima ...") }, 500);
								 setTimeout(function () { $("#loading-top span").text("Meneruskan Ke Halaman Utama ...")  }, 1500);
								 setTimeout( "location.href='" + link + "'", 3400 );
						}
					});
			});


			//action lists
			$("#forgotPassword [data-action=submit]").unbind().on("click", function(){ forgotPassword() });
	});

	function forgotPassword(){
		// send request
		 $("#forgotPassword .message").html("Harap tunggu ...");
		 $("#forgotPassword .message").removeClass("hide");
		 $("#forgotPassword form, #forgotPassword .modal-footer").removeClass("hide").addClass("hide");

		$.ajax({
			async: false,
			url: "login/forgotPassword", data: { clientId : $("#forgotPassword form #clientId").val() }, type: "POST", dataType: 'json',
			success: function (e) { 
				$("#forgotPassword form #clientId").val("");
				if(e == false || e == "" || e ==null) {
					$("#forgotPassword .message").html("<span class='fa fa-times-circle text-danger'>&nbsp;</span> Gagal mengirim permintaan.., NIK atau E-Mail yang Anda masukan tidak terdaftar!");
					setTimeout(function () {
						$("#forgotPassword .message").removeClass("hide").addClass("hide").html("");
						$("#forgotPassword form, #forgotPassword .modal-footer").removeClass("hide");
					}, 2500);
				}else{
					$("#forgotPassword .message").html("<span class='fa fa-check-circle text-success'>&nbsp;</span> E-Mail berhasil dikirim, silahkan cek E-Mail Anda untuk melanjutkan reset password.");
					setTimeout(function () {
						$("#forgotPassword .message").removeClass("hide").addClass("hide").html("");
						$("#forgotPassword form, #forgotPassword .modal-footer").removeClass("hide");
						$("#forgotPassword").modal("hide");
					}, 3000);
				}
			}
		});
	}

</script>
</body>
</html>
