<?php
include("include.php");

	$proid= isset($_POST['proid']) ? $_POST['proid']:'';
	$x=$conn->prepare("SELECT ti_sale_item.* FROM `ti_sale_item` left join ti_sale_invoice on ti_sale_item.invoice_id=ti_sale_invoice.invoice_id WHERE ti_sale_invoice.invoice_num=?");
	$y=array($mobile);
  $x->execute($y);
   $x->setfetchmode(PDO::FETCH_ASSOC);
   $result=$x->fetchAll();
   
	$html='';
	$i=1;
		if(count($result) >0) {
			foreach($result as $row) {
				$html .='<tr class="tr_row">';
				$html .='<td class="td_sl">$i</td>';
				$html .='<td><input type="hidden" name="eitem_id[]" class="eitem_id" value="'.$row['id'].'" />';
				
				$html .='<td><input type="hidden" value="'.$row['product_id'].'" name="color[]" />'.$row['colorname'].'</td>';
				$html .='<td><input type="hidden" value="'.$row['qty'].'" name="sqft[]"/>'.$row['sqft'].'</td>';
				$html .='<td><input type="hidden" value="'.$row['sell_price'].'" name="rate[]"/>'.$row['rate'].'</td>';
				
				$html .='<td><img src="image/delete.png" onclick="btnremove(this)"></td>';
				$html .='</tr>';
			}
		}
		echo $html;
