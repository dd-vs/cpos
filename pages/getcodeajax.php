<?php
  include("../include/include.php");
  if(isset($_GET['p']) && $_GET['p']=='getitem') {
		$a=isset($_POST['a1']) ? $_POST['a1']:'';
		//~ $color=isset($_POST['color']) ? $_POST['color']:'';

	$q1="SELECT count(ti_sale_return.id)  as number FROM `ti_sale_return` left join ti_sale_invoice on 
	ti_sale_return.invoice_id=ti_sale_invoice.invoice_id WHERE ti_sale_invoice.invoice_id='$a'";
	
$r1=$conn->query($q1);
		$r1->setfetchmode(PDO::FETCH_ASSOC);
		$rc=$r1->fetch();
$number=$rc['number'];

if($number<=0){
	
	
		$query="SELECT ti_sale_item.cgst_percent as cgst ,ti_sale_item.sgst_percent as sgst,ti_sale_item.id as saleid,ti_product.name,ti_product.id as pro,ti_sale_item.sell_price as rate,ti_sale_item.* FROM `ti_sale_item` 
  left join ti_product on ti_product.id=ti_sale_item.product_id 
 WHERE ti_sale_item.invoice_id='$a' and ti_sale_item.IsActive=1";
		$val1=$conn->query($query);
		$val1->setfetchmode(PDO::FETCH_ASSOC);
		

$query1="select count(ti_sale_item.id) as num, master_tax.tax_percent as sgst from ti_sale_item left join ti_sale_invoice on ti_sale_item.invoice_id=ti_sale_invoice.invoice_id left join ti_product on ti_product.id=ti_sale_item.product_id left join master_tax on master_tax.id=ti_product.sgst where ti_sale_invoice.invoice_id='$a' and ti_sale_item.IsActive=1";
		$val11=$conn->query($query1);
		$val11->setfetchmode(PDO::FETCH_ASSOC);
		$qw=$val11->fetch();
		?>
		<?php $i=1; while($v1=$val1->fetch()){ 
			?>
			 <input type="hidden" name="invnum" class="invnum" id="invnum" value="<?php echo $v1['invnum']; ?>">
			  <input type="hidden" name="invnum" class="invnum" id="vnum" value="<?php echo $qw['num']; ?>">
			 
			  <?php $tax1=$v1['cgst'];
			$rate=$v1['rate'];
			  $tax2=$v1['sgst'];
			  $tottax=$tax1+$tax2;
			  $a=$rate*$tottax;
			  $b=100+$tottax;
			  $b1=$a/$b;
			  $grossamt=$rate-$b1;
			 
			  $c1=$grossamt*$tax1;
			  $c2=$grossamt*$tax2;
			  $cgst=$c1/100;
			  $sgst=$c2/100;
			  $cgst1=$cgst;
			   $sgst1=$sgst;
		
						
							$name=$v1['name'];
							?>
			  
			<tr>
				 
				<td class="S/Num -txt"><?php echo $i; ?></td>
				 <td class="no-screen"><input type="hidden" name="sgst[]" class="sgst" id="Adm_txttax1" value="<?php echo $v3['sgst']; ?>" ></td><!-- sgst percentage -->
<td class="no-screen"> <input type="hidden" name="cgst[]" class="cgst" id="Adm_txttax" value="<?php echo $v1['cgst']; ?>" > </td><!-- cgst percentage -->
  <td class="no-screen">
 <input type="hidden" class="cgstnew" id="Adm_txttax16666" value="<?php echo $cgst1;?>"> </td><!--  cgst tax amount of one qty -->
<td class="no-screen"><input type="hidden" class="sgstnew" name="nwsgst" id="Adm_txttax17777" value="<?php echo $sgst1;?>"> </td><!--  sgst tax amount of one qty -->
<td class="no-screen"> <input type="hidden" class="changecgst" name="changecgst[]" id="changecgst" value=""></td><!--  cgst tax amount of changed qty -->
  <td class="no-screen"> <input type="hidden" class="changesgst" name="changesgst[]" id="changesgst" value=""> </td><!--  sgst tax amount of changed qty -->
  <td class="no-screen"> <input type="hidden" class="grossamt" name="grossamt[]" id="grossamt" value="<?php echo $grossamt;?>"> </td> 
  <td class="no-screen"> <input type="hidden" class="saleid" name="saleid[]" id="saleid" value="<?php echo $v1['saleid'];?>"> </td> <td class="no-screen"> <input type="hidden" class="grossamt" name="grossamt[]" id="grossamt" value="<?php echo $grossamt;?>"> </td> <td class="no-screen"> <input type="hidden" class="grossamt" name="grossamt[]" id="grossamt" value="<?php echo $grossamt;?>"> </td><!--  grossamt of changed qty -->
				<td class="table-item"><input type="hidden" name="proid[]" class="prodid" id="proid<?php echo $i; ?>" value="<?php echo $v1['pro']; ?>"><input type="hidden" name="prodname[]" class="prod" id="prodname" value="<?php echo $v1['id']; ?>"><?php echo $name; ?></td>
				<td class="-txt"><input type="hidden" name="rate[]" id="Adm_txtamt"  class="rate1" value="<?php echo $v1['rate']; ?>"><?php echo $v1['rate']; ?></td>
				<td class="-txt"><input type="hidden" name="qty[]" id="qty"   class="qty" value="<?php echo $v1['qty']; ?>"><?php echo $v1['qty']; ?></td>
				<td class="-txt"><input type="number" name="dispatch_qty[]" id="dispatch_qty"  onclick=""class="dispatch_qty" style="width:150px;" value="0" ></td>
				<td class="sum" id="Adm_txtsum">0.00</td>
			</tr>             
		<?php $i++;} }
		
		
		else{

		
			//~ echo $a;
			
			$q2="SELECT count(ti_sale_return_item.product_id) as nm FROM `ti_sale_return_item` left join ti_sale_return on ti_sale_return_item.return_inv_id=ti_sale_return.id left join ti_sale_invoice on ti_sale_return.invoice_id=ti_sale_invoice.invoice_id
			where  ti_sale_invoice.invoice_id='$a'";//ti_sale_return_item.product_id='".$v1['pro']."' and
			
			$qc=$conn->query($q2);
			$qc->setfetchmode(PDO::FETCH_ASSOC);
			$rcc=$qc->fetch();
			$nm=$rcc['nm'];
						
			
			if($nm<=0){
					$query="SELECT ti_sale_ietm.cgst_percent as cgst,ti_sale_item.sgst_percent as sgst,ti_sale_item.id as saleid,ti_product.name,ti_product.id as pro,ti_sale_item.sell_price as rate,ti_sale_item.* FROM `ti_sale_item` 
  left join ti_product on ti_product.id=ti_sale_item.product_id 
 WHERE ti_sale_item.invoice_id='$a' and ti_sale_item.IsActive=1";
		$val1=$conn->query($query);
		$val1->setfetchmode(PDO::FETCH_ASSOC);
	
		//$v3=$val33->fetch();

$query1="select count(ti_sale_item.id) as num, master_tax.tax_percent as sgst from ti_sale_item left join ti_sale_invoice on ti_sale_item.invoice_id=ti_sale_invoice.invoice_id left join ti_product on ti_product.id=ti_sale_item.product_id left join master_tax on master_tax.id=ti_product.sgst where ti_sale_invoice.invoice_id='$a'";
		$val11=$conn->query($query1);
		$val11->setfetchmode(PDO::FETCH_ASSOC);
		$qw=$val11->fetch();
		$i=1; while($v1=$val1->fetch()){ 
			
			//echo $v1['pro'];		
				
				?>
				<input type="hidden" name="invnum" class="invnum" id="invnum" value="<?php echo $v1['invnum']; ?>">
			  <input type="hidden" name="invnum" class="invnum" id="vnum" value="<?php echo $qw['num']; ?>">
			 
			  <?php $tax1=$v1['cgst'];
			$rate=$v1['rate'];
			  $tax2=$v1['sgst'];
			  $tottax=$tax1+$tax2;
			  $a=$rate*$tottax;
			  $b=100+$tottax;
			  $b1=$a/$b;
			  $grossamt=$rate-$b1;
			 
			  $c1=$grossamt*$tax1;
			  $c2=$grossamt*$tax2;
			  $cgst=$c1/100;
			  $sgst=$c2/100;
			  $cgst1=$cgst;
			   $sgst1=$sgst;
			  
						
							$name=$v1['name'];
							?>
			
			 
			<tr>
				  
				<td class="S/Num -txt"><?php echo $i; ?></td>
				 <td class="no-screen"><input type="hidden" name="sgst[]" class="sgst" id="Adm_txttax1" value="<?php echo $v3['sgst']; ?>" ></td><!-- sgst percentage -->
<td class="no-screen"> <input type="hidden" name="cgst[]" class="cgst" id="Adm_txttax" value="<?php echo $v1['cgst']; ?>" > </td><!-- cgst percentage -->
  <td class="no-screen">
 <input type="hidden" class="cgstnew" id="Adm_txttax16666" value="<?php echo $cgst1;?>"> </td><!--  cgst tax amount of one qty -->
<td class="no-screen"><input type="hidden" class="sgstnew" name="nwsgst" id="Adm_txttax17777" value="<?php echo $sgst1;?>"> </td><!--  sgst tax amount of one qty -->
<td class="no-screen"> <input type="hidden" class="changecgst" name="changecgst[]" id="changecgst" value=""></td><!--  cgst tax amount of changed qty -->
  <td class="no-screen"> <input type="hidden" class="changesgst" name="changesgst[]" id="changesgst" value=""> </td><!--  sgst tax amount of changed qty -->
  <td class="no-screen"> <input type="hidden" class="grossamt" name="grossamt[]" id="grossamt" value="<?php echo $grossamt;?>"> 
  </td>
  <td class="no-screen"> <input type="hidden" class="saleid" name="saleid[]" id="saleid" value="<?php echo $v1['saleid'];?>"> </td><!--  grossamt of changed qty -->
				<td class="table-item"><input type="hidden" name="proid[]" class="prodid" id="proid<?php echo $i; ?>" value="<?php echo $v1['pro']; ?>"><input type="hidden" name="prodname[]" class="prod" id="prodname" value="<?php echo $v1['id']; ?>"><?php echo $name; ?></td>
				<td class="-txt"><input type="hidden" name="rate[]" id="Adm_txtamt"  class="rate1" value="<?php echo $v1['rate']; ?>"><?php echo $v1['rate']; ?></td>
				
				<td class="-txt"><input type="hidden" name="qty[]" id="qty"   class="qty" value="<?php echo $v1['qty']; ?>"><?php echo $v1['qty']; ?></td>
				<td class="-txt"><input type="number" name="dispatch_qty[]" id="dispatch_qty"  onclick=""class="dispatch_qty" style="width:150px;" value="0" ></td>
				<td class="sum" id="Adm_txtsum">0.00</td>
			</tr>                        
		<?php $i++;}}
				
				else
				{
					//echo "turutrui";
			$query="SELECT ti_sale_item.cgst_percent as cgst,ti_sale_item.sgst_percent as sgst,ti_sale_item.id as saleid,ti_product.name,ti_product.id as pro,ti_sale_item.sell_price as rate,ti_sale_item.* FROM `ti_sale_item` 
  left join ti_product on ti_product.id=ti_sale_item.product_id 
 WHERE ti_sale_item.invoice_id='$a' and ti_sale_item.IsActive=1";
		$val1=$conn->query($query);
		$val1->setfetchmode(PDO::FETCH_ASSOC);
		

$query1="select count(ti_sale_item.id) as num, master_tax.tax_percent as sgst from ti_sale_item left join ti_sale_invoice on ti_sale_item.invoice_id=ti_sale_invoice.invoice_id left join ti_product on ti_product.id=ti_sale_item.product_id left join master_tax on master_tax.id=ti_product.sgst where ti_sale_invoice.invoice_id='$a'";
		$val11=$conn->query($query1);
		$val11->setfetchmode(PDO::FETCH_ASSOC);
		$qw=$val11->fetch();
			//echo $v1['pro'];
		$q23="SELECT ti_sale_return_item.return_inv_id as xnum FROM `ti_sale_return_item` left join ti_sale_return on ti_sale_return_item.return_inv_id=ti_sale_return.id left join ti_sale_invoice on ti_sale_return.invoice_id=ti_sale_invoice.invoice_id
			where  ti_sale_invoice.invoice_id='$a' ";//ti_sale_return_item.product_id='".$v1['pro']."' and
			$qc3=$conn->query($q23);
			$qc3->setfetchmode(PDO::FETCH_ASSOC);
			
					$rcc3=$qc3->fetch();
			$xnum=$rcc3['xnum'];
			//echo $xnum;
		
			$i=1; while($v1=$val1->fetch()){ 
			
		
			$qn="SELECT ti_sale_return_item.ret_qty as ret FROM `ti_sale_return_item` left join ti_sale_return on ti_sale_return_item.return_inv_id=ti_sale_return.id left join ti_sale_invoice on ti_sale_return.invoice_id=ti_sale_invoice.invoice_id
			where ti_sale_return_item.return_inv_id='$xnum' and  ti_sale_return_item.product_id='".$v1['pro']."' ";
			$qn22=$conn->query($qn);
			$qn22->setfetchmode(PDO::FETCH_ASSOC);
			$rn=$qn22->fetch();
			$ret=$rn['ret'];
			
			
			
			
			$ret1=$v1['qty']-$ret;
			
			
			//echo $v1['pro'];
			//echo $v1['qty'];
			 //echo $ret1;
			 
			
				//~ echo $ret1;
			//echo $v1['pro'];
			
			?>
			 <input type="hidden" name="invnum" class="invnum" id="invnum" value="<?php echo $v1['invnum']; ?>">
			  <input type="hidden" name="invnum" class="invnum" id="vnum" value="<?php echo $qw['num']; ?>">
			 
			 <?php $tax1=$v1['cgst'];
			$rate=$v1['rate'];
			  $tax2=$v1['sgst'];
			  $tottax=$tax1+$tax2;
			  $a=$rate*$tottax;
			  $b=100+$tottax;
			  $b1=$a/$b;
			  $grossamt=$rate-$b1;
			 
			  $c1=$grossamt*$tax1;
			  $c2=$grossamt*$tax2;
			  $cgst=$c1/100;
			  $sgst=$c2/100;
			  $cgst1=$cgst;
			   $sgst1=$sgst;
			  
						
							$name=$v1['name'];
							?>
			  
			<tr>
				
				<td class="S/Num -txt"><?php echo $i; ?></td>
				 <td class="no-screen"><input type="hidden" name="sgst[]" class="sgst" id="Adm_txttax1" value="<?php echo $v3['sgst']; ?>" ></td><!-- sgst percentage -->
<td class="no-screen"> <input type="hidden" name="cgst[]" class="cgst" id="Adm_txttax" value="<?php echo $v1['cgst']; ?>" > </td><!-- cgst percentage -->
  <td class="no-screen">
 <input type="hidden" class="cgstnew" id="Adm_txttax16666" value="<?php echo $cgst1;?>"> </td><!--  cgst tax amount of one qty -->
<td class="no-screen"><input type="hidden" class="sgstnew" name="nwsgst" id="Adm_txttax17777" value="<?php echo $sgst1;?>"> </td><!--  sgst tax amount of one qty -->
<td class="no-screen"> <input type="hidden" class="changecgst" name="changecgst[]" id="changecgst" value=""></td><!--  cgst tax amount of changed qty -->
  <td class="no-screen"> <input type="hidden" class="changesgst" name="changesgst[]" id="changesgst" value=""> </td><!--  sgst tax amount of changed qty -->
  <td class="no-screen"> <input type="hidden" class="grossamt" name="grossamt[]" id="grossamt" value="<?php echo $grossamt;?>"> </td>
  <td class="no-screen"> <input type="hidden" class="saleid" name="saleid[]" id="saleid" value="<?php echo $v1['saleid'];?>"> </td><!--  grossamt of changed qty -->
				<td class="table-item"><input type="hidden" name="proid[]" class="prodid" id="proid<?php echo $i; ?>" value="<?php echo $v1['pro']; ?>"><input type="hidden" name="prodname[]" class="prod" id="prodname" value="<?php echo $v1['id']; ?>"><?php echo $name; ?></td>
				<td class="-txt"><input type="hidden" name="rate[]" id="Adm_txtamt"  class="rate1" value="<?php echo $v1['rate']; ?>"><?php echo $v1['rate']; ?></td>
				<td class="-txt"><input type="hidden" name="qty[]" id="qty"   class="qty" value="<?php  echo $ret1; ?>"><?php echo $ret1; ?></td>
				<td class="-txt"><input type="number" name="dispatch_qty[]" id="dispatch_qty"  onclick=""class="dispatch_qty" style="width:150px;" value="0" ></td>
				<td class="sum" id="Adm_txtsum">0.00</td>
			</tr>     
				<?php $i++;	
				//}
				//else{?>
					
<!--
<tr>
<td colspan="9" align="center"> ITEM  RETURNED</td></tr>					
-->
					<?php
					//}
				}}
			}
		}
		
	

	?>
