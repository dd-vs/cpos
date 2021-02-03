

<?php 

include("../include/include.php"); 
	check_session();
html_head();
navbar_user(12);
//$emp_id=0;
$search_keyword = '';
	if(!empty($_POST['search']['salaryMonth'])) {
		$search_keyword1 = $_POST['search']['salaryMonth'];
		$search_keyword=DateTime::createFromFormat('m/Y', $search_keyword1)->format('Y-m');
	}
	$sql = 'SELECT ti_salary_issue.id,ti_employee.name,ti_employee.designation,ti_salary_issue.issue_date,ti_salary_issue.net_salary FROM ti_salary_issue 
	 join ti_employee on ti_employee.id=ti_salary_issue.emp_id where ti_salary_issue.salary_month like :salaryMonth   order by ti_employee.name';
	
	/* Pagination Code starts */
	$per_page_html = '';
	$page = 1;
	$start=0;
	if(!empty($_POST["page"])) {
		$page = $_POST["page"];
		$start=($page-1) * 30;
	}
	$limit=" limit " . $start . "," . 30;
	$pagination_statement = $conn->prepare($sql);
	$pagination_statement->bindValue(':salaryMonth', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pagination_statement->execute();

	$row_count = $pagination_statement->rowCount();
	if(!empty($row_count)){
		$per_page_html .= "<div style='text-align:center;margin:20px 0px;'>";
		$page_count=ceil($row_count/30);
		if($page_count>1) {
			
			for($i=1;$i<=$page_count;$i++){
				
				if($i==$page){
					
					
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
				} else {
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
				}
			}
		}
		$per_page_html .= "</div>";
	}
	
	$query = $sql.$limit;
	$pdo_statement = $conn->prepare($query);
	$pdo_statement->bindValue(':salaryMonth', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
?>
	
<div class="row" style="padding-top:10px;">
    <div class="col-md-4">
        <h2 style="margin-top:0;">Salary <span class="add-new-p" onclick="openPopup()" ><i class="fa fa-plus-square" aria-hidden="true"></i><div class="tool-tip p-help">Issue Salary </div></span> </h2> 
    </div>
     <form id="frm" action="" method="post">
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-addon">Salary Month</span>
            <input class="form-control" name='search[salaryMonth]'  placeholder="Search" value="<?php echo $search_keyword; ?>" type="text" id="salaryMonth">
        <span class="input-group-addon"> <button class="glyphicon glyphicon-search" type="submit" name="searchpro">
                    
                  </button></span>
        </div>
        
    </div>
    
</div>

<div>
    <table class="table default-table report-table">
        <tr>
            <th style="width: 5%;">No</th>
            <th>Name</th>
            <th style="width: 25%;">Designation</th>
            <th style="width: 12%;">Date</th>
            <th style="width: 15%;">Amount</th>
        </tr>
        <?php $y=$start+1;
   
    foreach($result as $s1){ ?>
         <tr>  
            <td><?php echo $y; ?></td>
            <td class="add-new-p" onclick="openPopupedit(this,'<?php echo $s1['id']; ?>')"  data-toggle='popup' a href='#editpopup'>
            <input type="hidden" id="idpro" name="proid"  value="<?php echo $s1['id']; ?>"><?php echo $s1['name']; ?></td>
            <td><?php echo $s1['designation'] ?></td>
            <td><?php echo $s1['issue_date']; ?></td>
            <td><?php echo $s1['net_salary'].'SAR'; ?></td>
        </tr>
             <?php $y++; }?>
    </table>
    <?php echo $per_page_html; ?>
</div>
 </form>
    
<div class="pop-up-overlay" id="popup">
    <div class="pop-up-head pro-pop-head"><a href="javascript:void(0)" class="closebtn" onclick="closePopup()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body">
        <div class="popup-container">
			 
            <div class="pop-up-title nomargin" style="">Issue Salary</div>
            <div class="row" style="padding:10px;"></div>
           	<form  id="frmenquiry" name="frmenquiry" action="../add/salary_issue.php" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Issue Date</span>
                            </span>
                            <input class="form-control" type="text" id="issueDate" name="issueDate">
                            <input class="form-control" type="hidden" name="salary_month"    id="salary_month">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Designation</span>
                            </span>
                           <select    id="designation" name="designation" value="" class="form-control" tabindex="1" required>
                               
                             </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Name</span>
                            </span>
                           <select    id="emp_name" name="emp_name" value="" class="form-control" tabindex="1" onchange="check(this);"   required>
                               <option value="6">select</option>
                             </select>
                             <input type="hidden" id="emp_id" name="emp_id" value="" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="">Remarks</span>
                            </span>
                           <input type="text"   id="remarks" name="remarks" value="" class="form-control" tabindex="1"  >
                            
                        </div>
                    </div>
                </div>
               	<div class="col-md-6">
				
					<title>Allowance</title>
                 <table class="table invoice-table">
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                            
                            <th style="width: 200px;">Value</th>
                           
                        </tr>
                        <tbody class="tbody" id="tbody"></tbody>
                     
                        </table>
                       
                        </div>
                        <div class="col-md-6">
							<title>Deduction</title>
                 <table class="table invoice-table">
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                         
                            <th style="width: 200px;">Value</th>
                           </tr>
                           <tbody class="tbody1" id="tbody1"></tbody>
                           
                         
                      
                        
                      
                        </table>
                        </div>
                        <div class="col-md-12 input-group" id="tamt">
							
                        </div>
                       
                     <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button class="btn btn-primary" tabindex="13">ISSUE</button></div>
                </div>
              

               
            </form>
        </div>
    </div>
</div>
<div class="pop-up-overlay" id="editpopup">
    <div class="pop-up-head pro-pop-head"><a href="javascript:void(0)" class="closebtn" onclick="closePopup1()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body" id="modelbody">
      
           
        </div>
    </div>
</div>


<?php html_close(); ?>

<script>
	

	 function openPopupedit(e,ide) {
      	$('#idpro').val(ide);
		var myvar = ide;
		//alert(myvar);
		 $.post('getempdetails.php?d=test',{ proid:ide },function(data) {
			$('#modelbody').html(data);
			document.getElementById("editpopup").style.height = "100%";
		});
		
    }
	
	
	
	var allowsum=0;
	var allowsum1=0;
	var dedsum=0;
	var dedsum1=0;
$(document).on('focusin', '.allow_value', function(){

$(this).data('val', $(this).val());

}).on('change','.allow_value', function(){
iv = $(this).data('val');
cv = $(this).val(); 
var new_qty=cv-iv;
var allowance=$('.totallow').val();

allowsum=parseFloat(allowance)+parseFloat(new_qty);
//alert(allowsum);
var tcalcal=$("#tcalcal").text();
//alert(tcalcal);
allowsum1=parseFloat(tcalcal)+parseFloat(new_qty);

var tcalc=parseFloat($("#tcalc").text());
//alert(tcalcal);
tcalc=parseFloat(tcalc)+parseFloat(new_qty);
var totamt=parseFloat($("#totamt").val());
totamt=parseFloat(totamt)+parseFloat(new_qty);
function round(value, decimals) {
return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

$("#tcalc").text(parseFloat(tcalc).toFixed(2));
$("#totamt").val(parseFloat(totamt).toFixed(2));
 $('.totallow').val(parseFloat(allowsum).toFixed(2));
$("#tot_allowance").val(parseFloat(allowsum).toFixed(2));
$("#tcalcal").text(parseFloat(allowsum1).toFixed(2));
$("#tot_salary").val(parseFloat(totamt).toFixed(2));


});
$(document).on('focusin', '.ded_value', function(){

$(this).data('val', $(this).val());

}).on('change','.ded_value', function(){
iv = $(this).data('val');
cv = $(this).val(); 
var new_qty=cv-iv;
var deduction=$('.totded').val();

dedsum=parseFloat(deduction)+parseFloat(new_qty);
 //~ alert(dedsum);
var tcalcded=$("#tcalcded").text();
//alert(tcalcded);
dedsum1=parseFloat(tcalcded)+parseFloat(new_qty);
//~ alert(dedsum1);
var tcalc=parseFloat($("#tcalc").text());
tcalc=parseFloat(tcalc)-parseFloat(new_qty);
var totamt=parseFloat($("#totamt").val());
totamt=parseFloat(totamt)-parseFloat(new_qty);
function round(value, decimals) {
return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}
$("#tcalc").text(parseFloat(tcalc).toFixed(2));
$("#totamt").val(parseFloat(totamt).toFixed(2));
$("#totded").val(parseFloat(dedsum).toFixed(2));
$("#tot_deduction").val(parseFloat(dedsum).toFixed(2));
$("#tcalcded").text(parseFloat(dedsum1).toFixed(2));
$("#tot_salary").val(parseFloat(totamt).toFixed(2));


});



	function check(e){
			var v=$("#emp_name").val();
		var myvar = v;
		var v1=$("#salary_month").val();
		var myvar1 = v1;
		
		$.ajax({
      type:'post',
              url:'../get/checkdata.php?q=get3',// put your real file name 
              data:{uname: v,date: v1},
              
              success:function(msg){
             //~ alert(msg); 
              if(msg!='')
              {
             notify("warning","already issued");
             $("#emp_name").val('select');
             $("#tbody").html('');
             ("#tbody1").html('');
             $("#tamt").empty();
             $("#totded").val('');
             $("#totamt").val('');
             $("#totallow").val('');
              }
              else
              {
	$.ajax({
		url:"getallow.php?p=getitem",
		method:"post",
		 data:{a1:v}
		 
		}).done(function(data) {
			$("#tbody").html(data);
			
		});
		$.ajax({
		url:"getded.php?p=getitem",
		method:"post",
		 data:{a1:v}
		 
		}).done(function(data) {
			$("#tbody1").html(data);
			
		});
		$.ajax({
		url:"gettot.php?p=getitem",
		method:"post",
		 data:{a1:v}
		 
		}).done(function(data) {
			//alert(data);
			$("#tamt").html(data);
			
		});
		
}
}
              
              
});
	
		}
	$.ajax({
			
		url:"../ajax/ajaxdesignation.php",
		method:"post",
	}).done(function(data){
		
		$("#designation").html(data);
	});
	$("#designation").change(function() {
		
		//alert("kkl");
		var a=$("#designation").val();
		//~ alert(a);
		$.ajax({
		  url:"../ajax/ajaxemployee.php",
		  method:"post",
		  data:{a1:a}
		}).done(function(data) {
			//alert(data);
			$("#emp_name").html(data);
			
			//var inp1 = $("#color").val();
		});
		});	
	$("#emp_name").blur(function() {
		
	
		var a=$("#emp_name").val();
		//~ alert(a);
		$.ajax({
		  url:"../get/post.php?p=getemp",
		  method:"post",
		  data:{itemid:a}
		}).done(function(data) {
			
			
			//$("#emp_id").val(parseInt(data));
			$("#emp_id").val($("#emp_name").val());
		});
		});	
		
  var picker = new Pikaday(
    {
        field: document.getElementById('salaryMonth'),
        firstDay: 1,
        yearRange: [2016,2030],
        format: 'MM/YYYY',
        defaultDate: new Date(),
        setDefaultDate: true
    });
    var picker = new Pikaday(
    {
        field: document.getElementById('issueDate'),
        firstDay: 1,
        yearRange: [2016,2030],
        format: 'DD/MM/YYYY',
        defaultDate: new Date(),
        setDefaultDate: true
    });
    var salarymonth= document.getElementById('salaryMonth').value;
document.getElementById('salary_month').value=salarymonth;
$("#salaryMonth").change(function(){
	
	 var salarymonth= document.getElementById('salaryMonth').value;
document.getElementById('salary_month').value=salarymonth;
	
	});
	    function closePopup() {
        document.getElementById("popup").style.height = "0%";
    }
    function closePopup1() {
        document.getElementById("editpopup").style.height = "0%";
    }

</script>
