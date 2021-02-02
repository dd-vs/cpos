<?php
$newsele="select ti_purchase_return.invoice_id,ti_purchase_return_item.return_inv_id,ti_purchase_return_item.product_id,ti_purchase_return_item.ret_qty 
from ti_purchase_return left join ti_purchase_return_item 
				on ti_purchase_return.id=ti_purchase_return_item.return_inv_id where ti_purchase_return.invoice_id='$inv'";
				echo $newsele;
			//	exit;
				$consel=$conn->query($newsele);
				while($selsel=$consel->fetch()){
					$selinv=$selsel['invoice_id'];
					$selretqty=$selsel['ret_qty'];
					$selpro=$selsel['product_id'];
					$newsel1="select ti_purchse_items.id as sale_id ,ti_purchse_items.qty from ti_purchse_items where ti_purchse_items.product_id='$selpro' 
					and ti_purchse_items.inv_id='$inv'";
					echo $newsel1;
					
					$consel1=$conn->query($newsel1);
					while($selsel1=$consel1->fetch()){
						$saleidpro=$selsel1['sale_id'];
						$saleidqty=$selsel1['qty'];
						//echo $saleidpro;
						echo $saleidqty;
						if($saleidqty==$selretqty){
							$updsale="update ti_purchse_items set IsActive=0 where id='$saleidpro'";
							$conupsa=$conn->query($updsale);
							
							}
						
						}
					}
					$sale1="SELECT count(id) as id FROM ti_purchse_items where invoice_id='$inv' and IsActive=1";//ti_sale_return_item.product_id='".$v1['pro']."' and
			$saler1=$conn->query($sale1);
			$saler1->setfetchmode(PDO::FETCH_ASSOC);
			
					$sale2=$saler1->fetch();
					$isact=$sale2['id'];
					if($isact==0)
					{
				$qe1e1="UPDATE `ti_purchase_invoice` SET `IsActive`=0  WHERE `invoice_id`='$inv'";
			$eqeq1=$conn->query($qe1e1);
		}	
		?>
ti_purchase_invoice
ti_purchase_return
ti_purchase_return_item
ti_purchse_items //inv_id
