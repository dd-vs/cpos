

<?php 

include("../include/include.php"); 
	check_session();
html_head();
navbar_user(11);
$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$sql = 'SELECT ti_employee.*  FROM ti_employee  WHERE ti_employee.name LIKE :keyword  ORDER BY ti_employee.name';
	
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
	$pagination_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
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
	$pdo_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
?>
	
<div class="row" style="padding-top:10px;">
    <div class="col-md-4">
        <h2 style="margin-top:0;">Employees <a href="javascript:void(0)" onclick="edit1()">
									<i class="fa fa-plus-square" aria-hidden="true"></i></a><div class="tool-tip p-help">Add New Employee</div></span></h2>
    </div>
    <div class="col-md-4 search-c">
        <form id="frm" action="" method="post">
            <div class="input-group">
<input type='text' class="form-control" name='search[keyword]' placeholder="Search" value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25'>
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit" name="searchpro">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
                </div>
            </div>
       
    </div>
</div>
<div class="row" style="height:20px;"></div>
<div class="form-container">
    <table class="table default-table report-table">
        <tr>
            <th style="width:5%;">SI</th>
            <th style="">Name</th>
            <th style="width:25%;">Designation</th>
            <th style="width:12%;">Status</th>
        </tr>
          <?php $y=$start+1;
   
    foreach($result as $s1){ ?>
       
        <tr >
            <td class="-txt"><?php echo $y; ?></td>
            <td ><a href="javascript:void(0)" onclick="edit(this,'<?php echo $s1['id']; ?>')"><form method="get" action="">
				<input type="hidden" name="txtedit_transaction" id="txtedit_transaction" value="0" />
										<input type="hidden" name="id" id="id" value="<?php     echo $s1['id']; ?>" /><?php echo $s1['name']; ?></form></a></td>
            <td><?php echo $s1['designation']; ?></td>
			  <td>
                 <?php if($s1['IsActive']==1) { ?>
                <a href='../status/employeeactivate.php?status=0&pid=<?php echo $s1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s1['id']; ?>"><span  id="item_active"><span class="green table-item-toggle"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>Active</span></a>
              <?php } 
            else {?>
                <a href='../status/employeeactivate.php?status=1&pid=<?php echo $s1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $s1['id']; ?>"><span  id="item_nonactive" ><span class="red table-item-toggle"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>Inactive</span></a>
       <?php }?>
            </td>
        </tr>
        <?php $y++; }?>
        
    </table>
  <?php echo $per_page_html; ?>
</div>
</form>
 

<?php html_close(); ?>
<script>
function popup(url) 
	{
	 var width  = 960;
	 var height = 500;
	 var left   = (screen.width  - width)/2;
	 var top    = (screen.height - height)/2;
	 var params = 'width='+width+', height='+height;
	 params += ', top='+top+', left='+left;
	 params += ', directories=no';
	 params += ', location=no';
	 params += ', menubar=no';
	 params += ', resizable=no';
	 params += ', scrollbars=yes';
	 params += ', status=no';
	 params += ', toolbar=no';
	 newwin=window.open(url,'windowname5', params);
	 if (window.focus) {newwin.focus()}
	 return false;
	}
	
	 function edit(e,id) {

$('#txtedit_transaction').val(id);
var myvar = id;
//alert(myvar);
'<%Session["temp"] = "' + myvar +'"; %>';
popup("employeedit.php?temp=" + myvar);
}
	 function edit1() {


popup("employeenew.php");
}




</script>
