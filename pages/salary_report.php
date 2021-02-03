<?php 

include("../include/include.php"); 
include("../include/report-head-nav.php"); 
html_head();
navbar_user(4);
navbar_report(6);
$query="SELECT ti_salary_issue.*,DATE_FORMAT(ti_salary_issue.issue_date,'%d/%m/%Y') as issuedate,ti_employee.name FROM `ti_salary_issue` left join ti_employee on ti_employee.id=ti_salary_issue.emp_id WHERE ti_salary_issue.issue_date between (CURRENT_DATE - INTERVAL 30 DAY ) and now() and ti_salary_issue.IsActive=1";
				$s=$conn->query($query);
				$result2=$s->fetchAll(PDO::FETCH_ASSOC);
				$query33="SELECT sum(ti_salary_issue.tot_allow) as tot_allow,sum(ti_salary_issue.tot_deduct) as tot_deduct,
				sum(ti_salary_issue.net_salary) as net_salary from ti_salary_issue  left join ti_employee on ti_employee.id=ti_salary_issue.emp_id 
				WHERE ti_salary_issue.IsActive=1";
				$s33=$conn->query($query33);
				$r33=$s33->fetch();
				
?>
<!---- report content ----->
<div class="report-container">
    <h2 class="margin-top-10">Salary Report</h2>
    <div class="report-head">
        <form class="" id="" action="salary_report.php" method="post">
            <div class="row">
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>From</span>
                        </span>
                       <input type="text" class="form-control" name="fromdate" id="fdate" value="" required/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>To</span>
                        </span>
                       <input type="text" class="form-control" name="todate" id="todate" value="" required/>
                    </div>
                </div>
              
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit" name="searchbydate">search</button>
                </div>
                <form class="" id="" action="salary_report.php" method="post">
                
                        

            
             </form>    
                
                
            </div>
            
        </form>
    </div>
           
     
    <div class="report-body">
        <table class="table default-table report-table">
            <tr>
                <th><i class="fa fa-th-large" aria-hidden="true"></i></th>
                 
                <th>Issue date</th>
                <th>Employee Name</th>
                
                <th>Salary Month</th>
           
                <th>Total allowance</th>
                <th>Total deduction</th>
                 <th>Net salary</th><th>Remarks</th>
                
            </tr>
             <?php
          if(isset($_POST['searchbydate'])){
				$f=DateTime::createFromFormat('d/m/Y', $_POST['fromdate'])->format('Y-m-d');
				$t=DateTime::createFromFormat('d/m/Y', $_POST['todate'])->format('Y-m-d');

					$query="SELECT ti_salary_issue.*,DATE_FORMAT(ti_salary_issue.issue_date,'%d/%m/%Y') as issuedate,ti_employee.name FROM `ti_salary_issue` left join ti_employee on ti_employee.id=ti_salary_issue.emp_id WHERE ti_salary_issue.issue_date between '$f 00:00:00' and '$t 23:59:59' and ti_salary_issue.IsActive=1";
				$s=$conn->query($query);
				$result2=$s->fetchAll(PDO::FETCH_ASSOC);
				
				$query33="SELECT sum(ti_salary_issue.tot_allow) as tot_allow,sum(ti_salary_issue.tot_deduct) as tot_deduct,
				sum(ti_salary_issue.net_salary) as net_salary from ti_salary_issue  left join ti_employee on ti_employee.id=ti_salary_issue.emp_id WHERE 
				ti_salary_issue.issue_date between '$f 00:00:00' and '$t 23:59:59'
				  and ti_salary_issue.IsActive=1";
				$s33=$conn->query($query33);
				$r33=$s33->fetch();	
			  }
            

 

          
 if(count($result2)>0) {
						
							$i=1; 
						foreach($result2 as $r){
							$sal=$r['salary_month'];
							$show_issue_date = DateTime::createFromFormat('Y-m-00', $sal)->format('Y-m');

$time=strtotime($show_issue_date);
							
$month=date("F",$time);
$year=date("Y",$time)
								
								//$show_date = DateTime::createFromFormat('Y-m-d', $r['sale_date'])->format('d/m/Y');
								
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $r['issuedate']; ?></td>
									<td><?php echo $r['name']; ?></td>
                                   
									<td><?php echo $month.$year;?></td>
							
									<td><?php echo $r['tot_allow'].'SAR'; ?></td><td><?php echo $r['tot_deduct'].'SAR'; ?></td><td><?php echo $r['net_salary'].'SAR'; ?></td>
									<td><?php echo $r['remarks']; ?></td>
									
								</tr>
						<?php $i++; }
						echo "<tr id=\"\" class=\"tbl-footer\">
                                            <td colspan=\"2\" align=\"right\">Total</td>
											<td colspan=\"1\" align=\"right\"></td>
											<td></td>
											<td></td>
											<td></td>
											<td align=\"left\">".number_format($r33['net_salary'],2,'.','').'SAR'."</td>
											<td></td>
											
										</tr>";
									}							 
									else	{
										echo "<tr id=\"\" class=\" tbl-footer\"><td colspan=\"9\" align=\"center\">No Data To show</td></tr>";
										}										  
													 
									
				
  ?>
        </table>
    </div>
</div>
<?php
html_close();
?>
<!-----report content end ----->
<script>
	 //~ function edit(e,id) {

//~ $('#txtedit_transaction').val(id);
//~ var myvar = id;
//~ //alert(myvar);
//~ '<%Session["temp"] = "' + myvar +'"; %>';
//~ window.location="invoiceedit.php?temp=" + myvar;
//~ }
$(document).ready(function(){
    $("select").change(function(){
		//~ document.getElementById("cash").style.display="inline-block";
		//~ document.getElementById("credit").style.display="none";
		
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});
    
    var picker = new Pikaday(
    {
        field: document.getElementById('fdate'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2030, 12, 31),
        yearRange: [2016,2030],
        format: 'DD/MM/YYYY',
    });
    var picker = new Pikaday(
    {
        field: document.getElementById('fdate'),
        field: document.getElementById('todate'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2030, 12, 31),
        yearRange: [2016,2030],
        format: 'DD/MM/YYYY',
    });
 var today = new Date();                     

                      var formattedtoday = today.getDate() + '/' + (today.getMonth() + 0) + '/' + today.getFullYear();
                    
                      
                      document.getElementById("fdate").value=formattedtoday;
    document.getElementById('todate').value=moment(new Date()).format('DD/MM/YYYY');
</script>
