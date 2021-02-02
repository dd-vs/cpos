<?php

	include("include.php");



		$order_no=isset($_POST['order_no_hidden'])? $_POST['order_no_hidden'] : '0';
   //~ $color=isset($_POST['color']) ? $_POST['color']:'';
   
 $query="SELECT ti_product.name,ti_product.id as pro,ti_product.item_sell_price as rate,ti_sale_item.* FROM `ti_sale_item` left join ti_sale_invoice on 
 ti_sale_item.invoice_id=ti_sale_invoice.invoice_id left join ti_product on ti_product.id=ti_sale_item.product_id WHERE ti_sale_invoice.invoice_num='$order_no'";
  $val1=$conn->query($query);
  $val1->setfetchmode(PDO::FETCH_ASSOC);
$result=$val1->fetchAll();
		
		
		$html='';
		if(count($result) >0) {
			foreach($result as $row) {
				$html .='<tr class="tr_row">';
				$html .='<td class="td_sl"></td>';
				
				
				$html .='<input type="hidden" value="'.$row['pro'].'" name="prodname[]" />'.$row['name'].'</td>';
				$html .='<td><input type="hidden" value="'.$row['rate'].'" name="rate[]" />'.$row['rate'].'</td>';
				$html .='<td><input type="hidden" value="'.$row['qty'].'" name="qty[]"/>'.$row['qty'].'</td>';
				$html .='<td><input type="hidden" value="" name="dispatch_qty[]"/>''</td>';
				$html .='<td></td>';
				
				$html .='</tr>';
			}
		}
		echo $html;
	
	
	
?>

