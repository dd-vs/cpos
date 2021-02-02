<?php 
    include("../include/include.php"); 
    $proid=isset($_POST['proid']) ? $_POST['proid']:'';
    $update=" select ti_category.* from  ti_category where id= '$proid'";
    $x=$conn->query($update);
    $x->setfetchmode(PDO::FETCH_ASSOC);
    while($r=$x->fetch()){
?>
<div class="popup-container">
<div class="form-container">
            <div class="pop-up-title">Category Edit</div>
            <div class="row" style="padding:10px;"></div> 
            <form  id="frmenquiry" name="frmenquiry" action="../update/catupdate.php" method="post"><input type="hidden" name="proid" id="proid" value="<?php echo $r['id']; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="blue">Category</span>
                            </span>
                            <input type="text" class="form-control" name="catname" id="Adm_txtCat" value="<?php echo $r['name']; ?>" placeholder="Enter Category Name" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span>Description</span>
                            </span>
                            <textarea class="form-control" name="catdescription" id="Adm_txtCatdis" value="<?php echo $r['category_desc']; ?>" placeholder="Enter Category Description"><?php echo $r['category_desc']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row -txt-" style="margin-top: 30px;"><button class="btn btn-primary">Save</button></div>
                
            </form>
        </div>
        </div>
<?php } ?>
<script>

 $("#toggelon").click(function(){
			if (document.getElementById("isactive").value== 1)
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
