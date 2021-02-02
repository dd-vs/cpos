<?php 
  check_session();
			


			function navbar_report($selected='0') {
				?>
<div class="report-nav">
    <ul class="report-menu">
        <li <?php if($selected=='0') echo ' class="active" ';?>>
            <a href="#"><span class="report-nav-fa"><i class="fa fa-cart-plus" aria-hidden="true"></i></span><span class="report-nav-name">SALES</span></a>
                        <ul class="nav-sub">
                            <li><a href="sales_report.php">SALES</a></li>
                            <li><a href="sales_return_report.php">RETURN</a></li>
                        
                        </ul>
                    </li>
        <li <?php if($selected=='1') echo ' class="active" ';?>><a href="#"><span class="report-nav-fa"><i class="fa fa-shopping-bag" aria-hidden="true"></i></span><span class="report-nav-name">PURCHASE</span></a>
                        <ul class="nav-sub">
                            <li><a href="purchase_report.php">PURCHASE</a></li>
                            <li><a href="purchase_return_report.php">RETURN</a></li>
                          
                        </ul>
                    </li>

        <li <?php if($selected=='4') echo ' class="active" ';?>><a href="#"><span class="report-nav-fa"><i class="fa fa-cube" aria-hidden="true"></i></span><span class="report-nav-name">STOCK </span></a>
                            <ul class="nav-sub">
                                <li><a href="stock_report.php">STOCK</a></li>
                                <li><a href="stock_report_summ.php">SUMMARY</a></li>
                            </ul>
                        </li>
       
        <li <?php if($selected=='5') echo ' class="active" ';?>><span class="report-nav-fa"><i class="fa fa-credit-card" aria-hidden="true"></i></span><span class="report-nav-name">CREDIT</span>
            <ul class="nav-sub">
                                <li><a href="credit_report.php">CREDIT</a></li>
                                <li ><a href="creditsummaryreport.php">CREDIT SUMMARY</a></li>
                            </ul>
        </li>

                            

        <li <?php if($selected=='8') echo ' class="active" ';?>><a href="#"><span class="report-nav-fa"><i class="fa fa-money" aria-hidden="true"></i></span><span class="report-nav-name">TAX</span></a>
                            <ul class="nav-sub">
                                <li><a href="tax_report.php">TAX REPORT</a></li>
                                <li ><a href="tax_sumary.php">TAX SUMMARY</a></li>
                            </ul>
                        </li>
       
      
        
    </ul>
</div>
<style>
    .menu-min{width:60px;}
    .page-content{padding-left: 63px;}
    .nav-detail{display: none;}
    .top-panel{display: none;}
</style>
<?php } ?>
