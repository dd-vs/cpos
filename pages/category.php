<?php 

include("../include/include.php"); 
	check_session();
html_head();
navbar_user(5);

$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$sql = 'SELECT * FROM ti_category WHERE name LIKE :keyword  order by name';
	
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
    <div class="col-md-3">
        <h2 style="margin-top:0;">Category <span class="add-new-p" onclick="openPopup()" ><i class="fa fa-plus-square" aria-hidden="true"></i><div class="tool-tip p-help">Add New Product</div></span></h2>
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
                <th>Category</th>
                <th style="width:45%;">Description</th>
                <th style="width:12%;">Status</th>
            </tr>
        <?php
           $y=$start+1;
            foreach($result as $a1){ 	
	       ?>
            <tr >
                <td class="-txt"><?php echo $y; ?></td>
                <td class="add-new-p" onclick="openPopupedit(this,'<?php echo $a1['id']; ?>')"  data-toggle='popup' a href='#editpopup'><input type="hidden" id="idpro" name="proid"  value="<?php echo $a1['id']; ?>"><?php echo $a1['name']; ?></td>
                <td><?php echo $a1['category_desc']; ?></td>
                <td>
                    <?php if($a1['IsActive']==1) { ?>
                    <a href='../status/activate.php?status=0&pid=<?php echo $a1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $a1['id']; ?>"><span  id="item_active"><span class="green table-item-toggle"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>Active</span></a>
                    <?php } else {?>
                    <a href='../status/activate.php?status=1&pid=<?php echo $a1['id']; ?>'><input type="hidden" name="pid" value="<?php echo $a1['id']; ?>"><span  id="item_nonactive" ><span class="red table-item-toggle"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>Inactive</span></a>
                    <?php }?>
                </td>
             </tr>
        <?php $y++; } ?>
    </table>
     <?php echo $per_page_html; ?>
    </div>
    </form>
<div class="pop-up-overlay" id="popup">
    <div class="pop-up-head pro-pop-head cat-pop"><a href="javascript:void(0)" class="closebtn" onclick="closePopup()">&times;<div class="tool-tip close-help">Close</div></a></div>
    
    <div class="pop-up-body pro-pop-body cat-pop">
        <div class="popup-container">
            <div class="form-container">
                <div class="pop-up-title">Add New Category</div>
                <div class="row" style="padding:10px;"></div>
                <form  id="frmenquiry" name="frmenquiry" action="../add/catsave.php" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="blue">Category</span>
                                </span>
                                <input type="text" class="form-control" name="catname" id="Adm_txtCat" minlength="2"  placeholder="Category name"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span>Description</span>
                                </span>
                                <textarea class="form-control" name="catdescription" id="Adm_txtCatdis" placeholder="Enter Category Description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row no-screen" id="toggelon">
                        <div class="-txt col-md-2"><label>Status</label></div>
                        <input type="hidden" name="isactive" id="isactive" value="1"> 
                        <div class="txt- col-md-4" id="customer-on"><i class="fa fa-toggle-on blue"  aria-hidden="true"></i> Active</div>
                        <div class="txt- col-md-4"  id="customer-off" style="display:none;"><i class="fa fa-toggle-off blue"  aria-hidden="true"></i> InActive </div>
                    </div>
                    <div class="row -txt-" style="margin-top: 20px;"><button class="btn btn-primary">Save</button></div>
                </form>
            </div>
        </div> 
    </div>
</div>
<div class="pop-up-overlay" id="editpopup">
    <div class="pop-up-head pro-pop-head cat-pop"><a href="javascript:void(0)" class="closebtn" onclick="closePopup1()">&times;<div class="tool-tip close-help">Close</div></a></div>
    <div class="pop-up-body pro-pop-body cat-pop" id="modelbody">
      
           
    </div>
</div>
<?php html_close(); ?>
<script>
		  <?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['i']);  } ?>
    function openPopup() {
        document.getElementById("popup").style.height = "100%";
    }

    function openPopupedit(e,ide) {
      	$('#idpro').val(ide);
		var myvar = ide;
		//alert(myvar);
		 $.post('getcatdetails.php?d=test',{ proid:ide },function(data) {
			$('#modelbody').html(data);
			document.getElementById("editpopup").style.height = "100%";
		});
		
    }

    function closePopup() {
        document.getElementById("popup").style.height = "0%";
    }
    function closePopup1() {
        document.getElementById("editpopup").style.height = "0%";
    }
    $("#toggelon").click(function(){
			if (document.getElementById("customer-off").style.display == "none")
			{
			
			var val=0;
				//alert("only cash");
			document.getElementById("isactive").value=val;
			document.getElementById("customer-on").style.display="none";
			document.getElementById("customer-off").style.display="inline-block";
		}
		else
		{
			var val=1;
				//alert("only cash");
			document.getElementById("isactive").value=val;
			document.getElementById("customer-on").style.display="inline-block";
			document.getElementById("customer-off").style.display="none";
		}
	});
	
</script>
