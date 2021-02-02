<?php 
 //ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 //error_reporting(E_ALL);
 include("../include/include.php"); 
 check_session();
 html_head();
 navbar_user(); 
?>
<h2 style="margin-top:0;">Email Invoice</h2>
<div class="report-head">
        <form class="" id="" action="sendinvoice.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>Mail to</span>
                        </span>
                       <input type="text" class="form-control" name="customermail" value="<?php echo $_SESSION['customermail']; ?>" required="required">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>Invoice</span>
                        </span>
                        <input id="file" class="form-control" name="invoice" type="file" required="required"/>
                    </div>
                </div>
                
             
                <div class="col-md-2">
                    <button class="btn btn-primary" type="submit" name="searchbydate">SEND MAIL</button>
                </div>
                 <div class="col-md-1"><div class="btn btn-primary" onclick="window.location = 'saleinvoice.php';">ABORT</div></div>
                <div class="col-md-3">
                    <?php if(isset($_SESSION['inv_mail_status'])) { ?>
                    <div style="background: #FFEB3B; border: 2px solid #f0de39; padding: 5px 20px; color: #7d7c7c; border-radius: 5px; font-size: 1.2em;"><?php echo $_SESSION['inv_mail_status']; ?></div>
                    <?php } ?>
                </div>
                  

            
                 
                
                
            </div></form>
            
        
    </div>

 <?php 
    unset($_SESSION['inv_mail_status']);
    html_close();
  ?>