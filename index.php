<?php include("include/include.php"); ?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>CALCULUS INVENTORY</title>
		<link href="pages/css/bootstrap.css" rel="stylesheet">
        <link href="pages/images/ico/favicon.png" rel="shortcut icon" type="image/x-icon">
        <link href="pages/images/ico/ico-phone.png" rel="apple-touch-icon">
	<style>
				@font-face{
					font-family:Roboto;
					src:url(../fonts/Roboto-Regular.ttf);
				}
				*{font-family: Roboto,sans-serif;}
				html { 
					height:100%
						; }
				body { 
					min-height:100%;
					display: flex;
					flex-direction: column;
					background-color: #474747;
					background-image: url(pages/images/bg.jpg);
					background-position: 50% 50%;
					background-size: cover;
					background-repeat: no-repeat;
					background-attachment: fixed;
					margin: 0;
				}
				.content { flex:1;}
				.page-content{min-height: 100vh;}
                .footer{
                position:absolute;
                bottom:0;
                width:100%;
                background: rgba(0, 0, 0, 0.48);
                color: #fff;
                padding: 15px;
                min-height: 45px;
                }
                .footer a{ color: #00f7ed;}
                .panel {
				background-color: rgba(255, 255, 255, 0.23);
				border: 1px solid rgba(255, 255, 255, 0.5);
				}
		.profile-img{width:150px;}
		.center-block{text-align: center; padding-bottom: 20px;}
        a{color: #3e3e3e;}
        a:hover{text-decoration: none;
        color: #068c65; }
        .logged-in-warning{text-align: center; color: #3e3e3e; line-height: 25px; margin-bottom: 15px;}
        .btn{border-radius: 0!important;}
        .customer-panel{background-color: rgba(255, 255, 255, 0.30); border: 1px solid rgba(255,255,255, 0.3); width: 25%; padding-top: 5px; padding-bottom: 5px; font-size: 20px; font-weight: bold; color: #fff; text-align: center;     border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; color: #005E8E;}
		</style>
         <div class="customer-panel">CPOS</div>
         <div class="container" style="margin-top:5%;" id="loggin">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-md-offset-4">
					<div class="panel panel-default">
						<!--<div class="panel-heading">
							<strong> Sign in to continue</strong>
						</div> -->
						<div class="panel-body"  >
							<form id="frmlogin" action="login.php" method="POST">
								<fieldset>
									<div class="row">
										<div class="center-block">
											<img class="profile-img"
												src="pages/images/login.png" alt="">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 col-md-10  col-md-offset-1 ">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</span> 
													<input class="form-control" placeholder="Username" id="txtuser_name" name="txtuser_name" type="text" autofocus>
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="glyphicon glyphicon-lock"></i>
													</span>
													<input class="form-control" placeholder="Password" id="txtpwd" name="txtpwd" type="password" value="">
												</div>
											</div>
											<div class="form-group">
												<input type="submit" id="btnlogin" class="btn btn-lg btn-primary btn-block" value="Sign in">
											</div>
										</div>
									</div>
									<div style="text-align: center"><a href="javascript:void(0)" onclick="edit(this)">Forgot Password?</a> </div> 
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>			   
        <div class="container" style="margin-top:8%; display:none;" id="forgot" >
            <div class="row" >
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body" >
                            <form action="passreset.php" method="post">
                                <fieldset>
                                    <div class="row">
                                        <div class="center-block">
                                            <img class="profile-img"
                                            src="pages/images/login.png" alt="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="glyphicon glyphicon-user"></i>
                                                    </span> 
                                                    <input  class="form-control"  type="text" id="txtusername" name="txtusername" value="">
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="submit">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top:8%; display: none;" id="divlogged" >
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
				    <div class="panel-body" >
				        <form action="update.php" method="post">
				            <fieldset>
					           <div class="row">
						          <div class="center-block"></div>
                                </div>
								<div class="row" style="text-align: center;">
                                    <div class="logged-in-warning" style="text-align: center;">You Have already Logged in from another computer <br> Do you wish to logout the Previous session and continue? </div>
									
                                    <button type='submit' class='btn btn-primary'>LOGOUT</button>
								</div>
				            </fieldset>
				        </form>
				    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div style="float: left;">CALCULUS INVENTORY <span style="color: #00fdff">V 1.02.020817</span> &#169; 2017</div>
        <div style="float: right;"> <span style="color: #00fdff">&#9658;</span> Developed By <a href="#" target="_blank">TCi</a></div>
    </footer>                   
                         
<script>
    function edit()
        {
            document.getElementById("forgot").style.display="inline-block";
            document.getElementById("loggin").style.display="none";
        }
    <?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
    alert('<?php echo $_SESSION["status"]; ?>');
    <?php  unset($_SESSION['i']); unset($_SESSION['status']); } ?>
    <?php  if(isset($_SESSION['i2']) && $_SESSION['i2'] !='') { ?>
    alert('<?php echo $_SESSION["status2"]; ?>');
    <?php  unset($_SESSION['i2']); unset($_SESSION['status2']); } ?>
    <?php     if(isset($_SESSION['in']) && $_SESSION['in'] !='') { ?>
    alert('<?php echo $_SESSION["stat"]; ?>');
    document.getElementById("divlogged").style.display="inline-block";
    document.getElementById("loggin").style.display="none";
    <?php     unset($_SESSION['in']); unset($_SESSION['stat']); } ?>
    //browser code
    
</script>	
