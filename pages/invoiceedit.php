<?php 
include("../include/include.php"); 
$id=$_GET['temp'];
 $qq="select IsActive from ti_sale_invoice where invoice_id ='$id'";
 $ww=$conn->query($qq);
 $ww->setfetchmode(PDO::FETCH_ASSOC);
 $rr=$ww->fetch();
 if($rr['IsActive']==0){
	  header('location:saleinvoice.php');
	 if(!isset($_GET['temp']) || $_GET['temp']=='' || $rr['IsActive']==0){
header('location:saleinvoice.php');
	 }
	
	 }
	$sql="SELECT AUTO_INCREMENT as eno
	FROM information_schema.tables
	WHERE table_name = 'ti_sale_invoice'";
	$s=$conn->query($sql); $res=$s->fetch();
$query="select *,max(ti_sale_invoice.invoice_id)+1 as inv_no from ti_sale_invoice where ti_sale_invoice.IsHidden=10";
$s1=$conn->query($query); $res1=$s1->fetch();
//~ $quu="select ti_product.name from ti_product";
//~ $s2=$conn->query($quu); $re=$s2->fetch();
check_session();
 html_head();
navbar_user(); 
unset($_SESSION['customermail']);
	$quu="select ti_sale_invoice.*, ti_customer.name as custname ,ti_customer.*,master_states.name as state,master_states.tin_code,master_cities.name as city,date(ti_sale_invoice.sale_date) as date from ti_sale_invoice left join ti_customer on ti_sale_invoice.cust_id=ti_customer.id left join master_cities on master_cities.id=ti_customer.city_id left join master_states on master_states.id=master_cities.state_id  where ti_sale_invoice.invoice_id ='$id' and ti_sale_invoice.IsActive=1";
$s22=$conn->query($quu); $re1=$s22->setfetchmode(PDO::FETCH_ASSOC);
while($wr=$s22->fetch())

{
	$ssdate=$wr['date'];
$show_date = DateTime::createFromFormat('Y-m-d', $ssdate)->format('d/m/Y');
    $_SESSION['customermail']   =   $wr['email'];
	?>
 <h2 style="margin-top:0;">Sales Invoice Edit</h2>
<!-- <button onclick="pdfMake.createPdf(docDefinition).print();" class="n-screen">Print</button>-->
<button onclick="printInv().print();" class="no-screen">Print</button>
            <div class="form-container" id="invoice">
               <form  id="frmenquiry" name="frmenquiry" action="../add/sale_report_save.php" method="post">
                    <div class="invoice-head col-md-12">
                        <div class="col-md-6 right-border">
                            <div class="row">
                                <div class="col-md-4 print-left">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Date</span>
                                        </span>
                                    <label class="form-control" type="text" name="date"  id="AdmtxtDate" value=><?php echo $show_date; ?> </label>
                                        <div class="form-control print-only" id="datePrint"><?php echo $show_date; ?></div>
                                    </div>
                                </div>
                                 <div class="col-md-3 print-right">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span> Bill No</span>
                                        </span>
                                        <input type="hidden" id="invoiceid" name="invoiceid" value="<?php   echo $wr['invoice_id'];?>">
                                        <?php if ($wr['sale_type']== 0 ){?>
                                        <input type="number" class="form-control" id="retail"   value="<?php   echo $wr['invoice_num'];?>" onchange="changeid();">
                                        <?php } else { ?>
											  <input type="number" class="form-control" id="whole"   value="<?php   echo $wr['invoice_num'];?>" onchange="changeid();">
											  <?php } ?>
                                       
                                        <input type="hidden" id="invNum" name="invno" value="<?php  echo $wr['invoice_num'];?>">
                                          <span class="input-group-addon">
                                         <span><i class="fa fa-play" id="btnsaleedit"  aria-hidden="true"></i></span>
                                        </span>

                                    </div>
                                </div>
<!--
                                 <i class="fa fa-angle-double-right" id="btnsaleedit" style="font-size:24px"></i>
-->
                                 <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Bill Series</span>
                                        </span>
                                        <select id="selectsale" name="selectsale" onchange="saletype();" disabled class="form-control" >
											<?php if ($wr['sale_type']== 0 ){?>
                                            <option value="0">B TO C</option>
                                            <?php } else {?>
                                            <option value="1">B TO B</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 no-print no-screen">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Off</span>
                                        </span>
                                        <input class="form-control" type="text" name="discount" id="dis" value="<?php echo $wr['discount'];?>" > 
                                        
                                    </div>
                                </div>
                                <div class="" id="disPrint "></div>
                                <div class="col-md-3 input-label no-print no-screen">
                                    <select id="select" class="form-control" name="select" onchange="discCal();">
                                        
                                        <option value="2">Flat</option>
                                    </select>
                                </div>
                            </div> 
                             <input class="form-control no-screen" type="text" name="advance_amt" id="advance_amt"  value="0">
                            <input id="setHidden" hidden name="hidden" value="10" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group no-print">
										<span class="input-group-addon">
                                            <span><i class="fa fa-plus-square" id="btnAddCust" aria-hidden="true"></i></span>
                                        </span>
                                        <span class="input-group-addon">
                                            <span>Customer</span>
                                        </span>
                                       <input type="text" name="customer" id="customer" class="form-control" value="<?php echo $wr['custname'];?>"   />
                                        <div class="form-control print-only" id="customerPrint"><?php   $wr['custname']; ?></div>  
                                       <input type="hidden" name="cust_id" id="cust_id" value="<?php echo $wr['cust_id'];?>">
								          <div class="no-screen" id="custaddress"><?php echo $wr['Address_l1'];?></div>
                    <div class="no-screen" id="custphone"><?php echo $wr['mobile']; ?></div>
                    <div class="no-screen" id="custstate"><?php echo $wr['state']; ?></div>
                    <div class="no-screen" id="custstatecode"><?php echo $wr['tin_code']; ?></div>
                    <div class="no-screen" id="custcity"><?php echo $wr['city']; ?></div>
                    <div  class="no-screen"id="custgstin"><?php echo $wr['TIN']; ?></div>
                                        <span class="input-group-addon" id="toggelon">
                                            <span style="display:none;" class="toggle-btn" id="customer-on"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>
                                            <span  class="toggle-btn" id="customer-off"><i class="fa fa-toggle-off" aria-hidden="true"></i></span>
                                              
                                        </span>
                                     
                                    </div>
                                     
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 right-border">
                            <div class="row">
                                <div class="col-md-6" id="collect_amt">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Cash</span>
                                        </span>
                                        <input class="form-control tableOut"  type="text" name="" id="collect" value="" onblur="sum4(); changeVal2('collect','collectPrint');" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)";/>
                                        <label class="form-control no-screen -txt" id="collectPrint"></label>
                                    </div>
                                 </div>
                                <div class="col-md-6" id="bal_amt">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span>Balance</span>
                                        </span>
                                        <label class="form-control" id="c_diff"></label>
                                    </div>                               
                                </div>
                            </div>
                           <div class="row">
                                <div class="col-md-4 -txt-">
									 <input type="hidden" id="cash-credit"  name="cash_credit" value="<?php echo $wr['cash_credit']; ?>">
									 <?php if($wr['cash_credit']=="10"){?>
                                    <span  id="cash" class="b-type btn btn-primary" >Cash</span>
                                    
                                    <?php } else { ?>
                                   <span  id="credit"  class="b-type btn btn-primary btn-credit"  >Credit</span>
                                     
                                    <?php } ?>
                                </div>
                               
                                <div class="col-md-4 -txt-">
                                    <button class="btn btn-primary" name="submit" onclick="printInv().print(); pdfMake.createPdf(docSave).download('invoice'+$('#invNum').text());">Print</button>
                                </div>
                                
                                <div class="col-md-4 -txt-">
                                    <button type="submit" name="submit" class="btn btn-primary" onclick="printInv().download('invoice'+$('#invNum').text());">Save</button>
                                </div>
                            </div>
                        </div>
                         <?php }?>
                        <div class="col-md-2">
							<div class="col-md-4 -txt-">
                                    <button type="submit" class="btn btn-danger"  onClick="javascript: return confirm('Please confirm deletion');"  name="delete">Delete</button>
                            </div>
							<div class="bal-notify green -txt-" id="bal_amt11"></div>
                            <div class="red -txt" id="total-amt" >
                             
                            </div>
                        </div>
                    </div>
 
                    <div class="invoice-body col-md-12">
                        <div class="focusGuard" id="focusFirst" tabindex="2"></div>
                        <table class="table invoice-table">
							<tbody class="tbody">
                            <tr class="no-print">
                                <th rowspan="2" colspan="2" class="siNo">No</th>
                                <th rowspan="2" colspan="2" class="sItem">Item</th>
                                <th rowspan="2" colspan="2" class="sRate">Rate</th>
                                <th rowspan="2" colspan="2" class="sRate">HSN</th>
                                <th rowspan="2" colspan="2" class="sQty">Qty</th>
                                <th rowspan="2" colspan="2" class="sQty">UoM</th>
                                <th colspan="2" class="tax">CGST</th>
                                <th colspan="2" class="tax">SGST</th>
                                <th rowspan="1" class="sdis no-screen">DISCOUNT</th>
                                <th rowspan="2" colspan="2" class="sAmt">Amount</th>
                                <th rowspan="2" colspan="2" class="sAdd no-print">&nbsp;</th>
                            </tr>
                            <tr class="no-print">
                                <th rowspan="1" class="cgstP">%</th>
                                <th rowspan="1" class="cgstA">Amt</th>
                                <th rowspan="1" class="sgstP">%</th>
                                <th rowspan="1" class="sgstA">Amt</th>
                             
                            </tr>
                            <tr class="no-screen">
                                <th colspan="2" class="siNo">No</th>
                                <th colspan="2" class="sItem">Item</th>
                                <th colspan="2" class="sRate">Rate</th>
                                <th colspan="2" class="sRate no-print">HSN</th>
                                <th colspan="2" class="sQty">Qty</th>
                                <th colspan="2" class="tax">CGST</th>
                                <th colspan="2" class="tax">SGST</th>
                                
                                <th colspan="2" class="sAmt">Amount</th>
                            </tr>
                            <tr class="datainput no-print">
								<td class="S/Num -txt" colspan="2">&nbsp;</td>
								<td class="sCode" colspan="">
									<input type="text" tabindex="3" name="code" id="Adm_txtCode" value="" class="form-control no-print" />
									<input type="hidden" id="1dCode" value="">
								</td>
								<td class="table-item" colspan="">
									<input type="text" name="proname"    id="Adm_txtPro" value="" class="form-control" tabindex="4">
									<input type="hidden" id="1tag" value="">
								</td>
								<td colspan="2">
									<span id="spanid">
										<input type="number" class="form-control -txt"  name="buyprice" id="Adm_txtprice" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" value=""  onkeyup="sum();" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  tabindex="5">
									</span>
								</td> 
								  <td colspan="2">
								<input type="text" class="form-control" id="hsn_code">
								</td>
								<input type="hidden" id="grossamt" >
															<td colspan="2" class="hasNotify">
									<input type="number"  name="qty" id="Adm_txtqty" value="" class="form-control  -txt" onkeyup="sum()" tabindex="6" >
									<div id="notifyPop">  </div>
								</td>
                                <td colspan="2"><span id="qty_unit" style="display: inline-block" ></span></td>
								
								<td class="-txt" colspan="1">
									<span id="spantax">
										<span id="Adm_txttax" ></span>
									</span>
								</td>
									<input type="hidden"  name="amount" id="Adm_txtamt" value="" class="form-control" onkeyup="sum23()">
								<td class="-txt"  >
									<span   id="Adm_txttax16666"></span>
								</td>
								<td class="-txt" colspan="1">
									<span id="spantax1">
										<span id="Adm_txttax1" ></span>
									</span>
								</td>
								<td class="-txt" >
									<span   id="Adm_txttax17777"></span>
								</td>
									<td colspan="2" class="no-screen">
									<input type="text" name="discount"    id="Adm_txtDis" class="form-control -txt" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"  tabindex="" value=0  onkeyup="sum();">
								</td> 
								<td class="no-screen -txt" colspan="2">
									<span id="Adm_txtsum"></span>
									<input type="hidden" id="item_stock">
								</td>
								<td class="-txt" colspan="2">
									<span class="no-screen" id="grossItemRate"></span>
									<span id="grossLineAmt"></span>
								</td>
								<td class="green -txt-" colspan="2">
									<button type="button" id="btn_additem" class="fa fa-plus" aria-hidden="true" tabindex="7"></button>
								</td>
                            </tr>
                        </tbody>
                         <div class="focusGuard" id="focusLast" tabindex="8"></div>
                        <?php
						$grossAmtTot=0;
				$query="SELECT ti_sale_item.cgst_percent as cgst,ti_sale_item.sgst_percent as sgst,ti_sale_item.discount,ti_sale_invoice.*,ti_sale_item.id as saleid,hsn_code.hsn_code,master_unit.unit_name,ti_sale_item.discount,ti_product.name,ti_product.item_code,ti_product.id as pro,ti_sale_item.sell_price as rate,ti_sale_item.* FROM `ti_sale_item` left join ti_sale_invoice
				on ti_sale_item.invoice_id=ti_sale_invoice.invoice_id left join ti_product on ti_product.id=ti_sale_item.product_id 
			left join hsn_code on hsn_code.id=ti_product.hsn_id left join master_unit on master_unit.id=ti_product.unit_id
				WHERE ti_sale_invoice.invoice_id='$id' and ti_sale_item.isActive=1";
				$val1=$conn->query($query);
				$val1->setfetchmode(PDO::FETCH_ASSOC);
				
                /*<!----- get total number of rows in the exsisting invoice and load it to input--->*/
                $rowcount=$val1->rowCount();  ?>
                <input type="hidden" id="rowcount" value="<?php echo $rowcount;?>">
            
			    <?php	$i=1; while($v1=$val1->fetch()){
				
				  $amount=$v1['rate']*$v1['qty'];
				  $tax1=$v1['cgst'];
				  $rate=$v1['rate'];
				  $tax2=$v1['sgst'];
				  $tottax=$tax1+$tax2;
				  $a=$amount*$tottax;
				  $b=100+$tottax;
				  $b1=$a/$b;
				  $grossamt=$amount-$b1;
				  $grossAmtTot=round($grossAmtTot+$grossamt,2);
				  $c1=$grossamt*$tax1;
				  $c2=$grossamt*$tax2;
				  $cgst=$c1/100;
				  $sgst=$c2/100;
				  $cgst1=round($cgst,2);
				  $sgst1=round($sgst,2);
				  $grossRate= round($grossamt/$v1['qty'],2);
				
			  
			  ?>		 
			<tr class="datainput tr_row">
               
            <input type="hidden" class="cgstnew" id="Adm_txttax16666" value="<?php echo $cgst1;?>">
			  <input type="hidden" class="sgstnew" name="nwsgst" id="Adm_txttax17777" value="<?php echo $sgst1;?>">
			  <input type="hidden" class="cgst_cal" name="nwcgst" id="newcgst" value="">
			  <input type="hidden" name="nwsgst" id="newsgst" value="">
				<td class="td_sl1 S/Num -txt" colspan="2"><?php echo $i; ?></td>
				<td class="no-screen"> <input type="hidden" name="estatus[]" class="estatus" value="1"></td>
				<td class="sCode no-screen" colspan="">
									<input type="text" tabindex="3" name="code" id="Adm_txtCode" class="form-control no-print" value="<?php echo $v1['item_code'];?>"  />
									<input type="hidden" tabindex="-1" name="id[]" id="" value="<?php echo $v1['pro'];?>" class="form-control no-print" />
									<input type="hidden" tabindex="" class="form-control no-print" name="saleid[]" id="" value="<?php echo $v1['saleid'];?>"  />
				</td>
                <td class="no-screen"><input type="text" class="grossamt" value="<?php echo $grossamt; ?>"></td>
				  
				<td class="table-item" colspan="2">
					<input type="text" name="saleproid[]" class="prodid form-control"  id="proid" value="<?php echo $v1['name']; ?>" value="<?php echo $v1['pro']; ?>"><input type="hidden" id="1tag" value=""></td>
				<td class="no-screen -txt" colspan="2"><input type="text" name="salerate[]" id="rate"  class="form-control rate1" value="<?php echo $v1['rate']; ?>"></td> 
				<td class="n-screen -txt" colspan="2"><input type="text" class="form-control rate1" value="<?php echo $grossRate; ?>"></td> <!--Gross Rate-->
				<td class="-txt" colspan="2"><input type="text" name="hsn_code[]" id="hsn_code"  class="form-control hsn_code" value="<?php echo $v1['hsn_code']; ?>"></td>
				
				<td class="-txt" colspan="2"><input type="text" name="saleqty[]" id="qty"  class="form-control qty" oninput="sums(this);" value="<?php echo $v1['qty']; ?>"></td>
                <td colspan="2"><?php echo $v1['unit_name']; ?></td>
<!--oninput="sums(this);" -->
                 <td class="-txt" colspan="1"><input type="hidden" name="salecgst[]" id="cgst"  class="cgst" value="<?php echo $v1['cgst']; ?>" ><?php echo $v1['cgst']; ?> </td>
                 <td class="cgst1" style="text-align:right" colspan="1" ><?php echo $cgst1; ?></td>
				<td class="-txt" colspan="1"><input type="hidden" name="salesgst[]" id="sgst"  class="sgst" value="<?php echo $v1['sgst']; ?>"><?php echo $v1['sgst']; ?>
				<input type="hidden" id="Adm_txtamt1" class="Adm_txtamt"></td>
				<td class="sgst1" colspan="1" style="text-align:right"><?php echo $sgst1; ?></td>
				<td class="-txt no-screen" colspan="2"><input type="text" name="dis[]" id="dis" onchange="sums(this); sum23();"  class="dis  form-control" value="<?php echo $v1['discount']; ?>"></td>
				<td class="no-screen sum2" colspan="2" style="text-align:right" id="Adm_txtsum"><?php echo $amount?></td>
				<td class="" colspan="2" style="text-align:right" id=""><?php echo round($grossamt,2);?></td><!--Gross Amt -->
				<td class="red -txt-"  colspan="2"><i class="fa fa-times" aria-hidden="true" id ="<?php echo $i; ?>"  onclick="btnremove1(this)"></i> </td>
					
			</tr>            
		<?php $i++; 
	}
	?>
	
                      <?php
                      $queryq="SELECT * from ti_sale_invoice WHERE invoice_id='$id'";
		$val=$conn->query($queryq);
		$val->setfetchmode(PDO::FETCH_ASSOC); 
		while($vq=$val->fetch()){  ?>       
                      
                      
                           
                          
                            <tr>
								
								<input type="hidden" id="active" name="active" value="<?php echo $vq['IsActive'];?>">
								<input type="hidden" id="has_return" name="has_return" value="<?php echo $vq['has_return'];?>">
								<input type="hidden" id="taxcgst" name="totcgst" value="">
								<input type="hidden" id="taxsgst" name="totsgst" value="">
								<input type="hidden" id="amttotal" name="amttotal" value="">
								<td class="-txt" colspan="6">Total</td>
								<td colspan="2" name="totqty" class="-txt" id="totqty" value="0"></td>
                                <td colspan="2" class="totqty"></td>
                                <td colspan="2"></td>
								<td  colspan="2"class="tottax  -txt" id="tottax" value="0"><?php echo $vq['cgst_amt'];?></td>
								<td colspan="2"class="tottax1 -txt" id="tottax1" value="0"><?php echo $vq['sgst_amt'];?></td>
								
								<td colspan="2"name="totamt" class="totamt -txt" id="totamt"  colspan="2" value="0"><?php echo $grossAmtTot;}?></td>
								<td class="-txt no-print n-screen"> </td>
                            </tr>
                        </table>
                   

                         
                          
                            
                            <input type="hidden" id="amount" name="amount1">
                            <input type="hidden" id="balance-amount" name="balance-amount">
                           <input type="hidden" name="fraction" id="fraction">
                                    <input type="hidden" name="amtpart" id="amtpart">
                        
                    
                    </div>
            </form>
            </div>
          
  <!---------Invoice head  ---------->
            <?php 
            $query="select ti_transport.vehicle_num from ti_transport left join ti_sale_invoice on ti_sale_invoice.invoice_id=ti_transport.invoice_id where ti_transport.invoice_type=1 and ti_sale_invoice.invoice_id='$id'";
            $res=$conn->query($query);
            $res->setfetchmode(PDO::FETCH_ASSOC);
            while($re=$res->fetch()){
            ?>
        <div id="invNoPrint" class="no-screen"><?php echo $wr['invoice_num']; ?></div>
        <div id="vehPrint" class="no-screen"><?php echo $re['vehicle_num'];?></div>
       
        <?php } ?>
             <?php $quer="SELECT * FROM `master_company` WHERE 1";
            $set=$conn->query($quer);
            $set->setfetchmode(PDO::FETCH_ASSOC);
            while($ss=$set->fetch()){
            ?>
            <div class="print-only" id="invoice-head">
                <p id="brand-name"><?php echo $ss['c_name'];?></p>
                <p class="address" id="address-line1"><?php echo $ss['address_1']; ?></p><span class="" id="mobilePrint"> Mobile: <?php echo $ss['mobile']; ?></span>
                <p class="contact"><span class="no-print" > <?php echo $ss['website']; ?> </span>  <span class="" id="address-website" ><?php echo $ss['mailid']; ?></span> </p>
                <p class="print-left no-print">CIN :<?php echo $ss['cin']; ?> </p>
            </div>
           <div class="print-only" id="invoice-head1">
            <p class="contact" style="text-align:right"; > <span class="" id="address-phone">Ph : <?php echo $ss['phone']; ?> </span>|&nbsp; <span class=""> Mob: <?php echo $ss['mobile']; ?></span></p>
            <p id="pGst"><?php echo $ss['gstin'];?>  </p>
           
</div>
<div id="statePrint" class="no-screen"><?php echo $ss['state']; ?></div>
<div id="state_codePrint" class="no-screen"><?php echo $ss['state_code'];?></div>
  <?php }?>
            <!---------Invoice Table ---------->
 <div id="invNum" class="no-screen"></div>
            <!---------Invoice Table ---------->
            <table id="invPTable" class="no-screen" border=1>
                
              <td>No</td>
                        <td>Item</td>
                        <td>HSN</td>
                        <td>Rate</td> 
                        <td>Qty</td>
                        <td>%</td>
						<td>CGST</td> 
						<td>%</td> 						
                        <td>SGST</td>
                       <td>G.Amt</td>
                </thead>
                    
                <tbody class="ptBody">
					 <?php
					 $grosTotAmt=0;
					 $totCgstAmt=0;
					 $totSgstAmt=0;
					$query="SELECT ti_sale_item.cgst_percent as cgst,ti_sale_item.sgst_percent as sgst,ti_sale_item.discount,ti_sale_invoice.*,ti_sale_item.id as saleid,hsn_code.hsn_code,master_unit.unit_name,ti_sale_item.discount,ti_product.name,ti_product.item_code,ti_product.id as pro,ti_sale_item.sell_price as rate,ti_sale_item.* FROM `ti_sale_item` left join ti_sale_invoice
				on ti_sale_item.invoice_id=ti_sale_invoice.invoice_id left join ti_product on ti_product.id=ti_sale_item.product_id 
			left join hsn_code on hsn_code.id=ti_product.hsn_id left join master_unit on master_unit.id=ti_product.unit_id
				WHERE ti_sale_invoice.invoice_id='$id' and ti_sale_item.isActive=1";
				$val1=$conn->query($query);
				$val1->setfetchmode(PDO::FETCH_ASSOC);
				

				$i=1; while($v1=$val1->fetch()){
								
				  $amount=$v1['rate']*$v1['qty'];
				  $tax1=$v1['cgst'];
				  $rate=$v1['rate'];
				  $tax2=$v1['sgst'];
				  $tottax=$tax1+$tax2;
				  $a=$amount*$tottax;
				  $b=100+$tottax;
				  $b1=$a/$b;
				  $grossamt=$amount-$b1;
				  $rgrossamt=round($grossamt,2);
				  $rgrosrate=round($rgrossamt/$v1['qty'],2);
				  $c1=$grossamt*$tax1;
				  $c2=$grossamt*$tax2;
				  $cgst=$c1/100;
				  $sgst=$c2/100;
				  $cgst1=round($cgst,2);
				  $sgst1=round($sgst,2);
				  $grosTotAmt=$grosTotAmt+$rgrossamt;
				  $totCgstAmt=$totCgstAmt+$cgst1;
				  $totSgstAmt=$totSgstAmt+$sgst1;
			?>	
			  
			    <tr class="pt_row" id="r<?php echo $i;?>" style="height: 7mm;">
                        <td class="td_sl S/Num "><?php echo $i;?></td>
                        <td><?php echo $v1['name']; ?></td>
						<td><?php echo $v1['hsn_code']; ?></td>
                        <td><?php echo $rgrosrate; ?></td>
                        <td><?php echo $v1['qty']; ?></td>
                        <td><?php echo $v1['cgst']; ?></td>
						<td><?php echo $cgst1; ?></td>
                        <td><?php echo $v1['sgst']; ?></td>
                        <td><?php echo $sgst1; ?></td>
                      
                        <td><?php echo $rgrossamt; ?></td>
                    </tr>
			  <?php $i++; 
	}
	?>
			 		
	</tbody>
	<?php 
	$query="SELECT ti_sale_item.cgst_percent as cgst,ti_sale_item.sgst_percent as sgst,ti_sale_item.discount,ti_sale_invoice.*,ti_sale_item.id as saleid,hsn_code.hsn_code,master_unit.unit_name,ti_sale_item.discount,ti_product.name,ti_product.item_code,ti_product.id as pro,ti_sale_item.sell_price as rate,ti_sale_item.* FROM `ti_sale_item` left join ti_sale_invoice
				on ti_sale_item.invoice_id=ti_sale_invoice.invoice_id left join ti_product on ti_product.id=ti_sale_item.product_id 
			left join hsn_code on hsn_code.id=ti_product.hsn_id left join master_unit on master_unit.id=ti_product.unit_id
				WHERE ti_sale_invoice.invoice_id='$id' and ti_sale_item.isActive=1";
				$val1=$conn->query($query);
				$val1->setfetchmode(PDO::FETCH_ASSOC);
				$v11=$val1->fetch();
				
	?>
                <tr>
                    <td> </td>
                   
                   
                    <td>Sub-Total</td>
					<td></td>
                    <td></td>
                    <td></td>
                    <td ></td> <td id="totCgstPrint" ><?php echo $totCgstAmt; ?></td>
					<td ></td> <td id="totSgstPrint"><?php echo $totSgstAmt; ?></td>
                    <td id="nettAmtPrint"><?php echo $grosTotAmt; ?></td>
                </tr>
				<tr>
                    <td> </td>
                   
                   
                    <td>Grand-Total</td>
					<td></td>
                    <td></td>
                    <td></td>
                    <td ></td> <td id="totCgstPrint" ></td>
					<td ></td> <td id="totSgstPrint"></td>
                    <td id="totAmtPrint"><?php echo $v11['amt']; ?></td>
                </tr>
			
            </table>
			                           
</div>
            


            <!---------Invoice Table ---------->
            <!---------Invoice head  ---------->
            <!---- Invoice Footer------->
            <div class="print-only" id="invoice-footer">
                <p class="footer"></p>
            </div>
            <!---- Invoice Footer------->


    <?php
    html_close();
     ?>
 <script src="libs/pdfmake.min.js"></script>
        <script src="libs/vfs_fonts.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
<script>
		  <?php  if(isset($_SESSION['eid']) && $_SESSION['eid'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['eid']);  } ?>
		
	
	$(function() {
var w= $('#has_return').val();
if(w==1)
{ notify("warning","Some items in invoice have returned – Invoice edit might not work"); }
changeVal('customer','customerPrint');
if($('#selectsale').val() == 0)
    {changeVal('retail','invNoPrint');}
    else
        {changeVal('whole','invNoPrint');}
});
	<?php   if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
      alert('<?php echo $_SESSION["status"]; ?>');
      <?php   unset($_SESSION['i']); unset($_SESSION['status']); } ?>
	
	function changeid(){
		var selecttype=$("#selectsale").val();
		  if(selecttype==1){
	id= $('#whole').val();

//alert(myvar);
$.ajax({
					url:"../get/post.php?p=getwholeid",
					method:"post",
					data:{ itemid:id }
				}).done(function(data) {
					//alert(data);
					$("#invoiceid").val(data);
				
				});
				
			}
			
		  if(selecttype==0){
				 id= $('#retail').val();

$.ajax({
					url:"../get/post.php?p=getretailid",
					method:"post",
					data:{ itemid:id }
				}).done(function(data) {
					//alert(data);
					$("#invoiceid").val(data);
				
				});
			}
			}
	 $("#btnsaleedit").click(function(ev){
		 

			//$.post('customeradd.php',{inv_no:$('#inv_no').text()},function(data) {
			  var selecttype=$("#selectsale").val();
		  if(selecttype==1){
			
				var myvar = $("#invoiceid").val();
				
'<%Session["temp"] = "' + myvar +'"; %>';
window.location="invoiceedit.php?temp=" + myvar;
		  }
		   if(selecttype==0){
			
				var myvar = $("#invoiceid").val();
//alert(myvar);
'<%Session["temp"] = "' + myvar +'"; %>';
window.location="invoiceedit.php?temp=" + myvar;
		  }
					//});
					});
	
	$(document).ready(function(){
		$("#dis").blur(function(){
		var dis=$("#dis").val();
	
		var b=$("#total-amt").text();
		var n=dis;
		$("#amount").val(n);
		var c=$("#amount").val();
		if(b>0){
			//~ alert(c);
			//~ alert(diff);
		var diff=b-c;
		$("#balance-amount").val(diff);
		$("#total-bal").text(parseFloat(diff).toFixed(2));
		
		$()
	} else{
		//alert(c);
			//alert(diff);
		$("#balance-amount").val(c);
		$("#total-bal").text(parseFloat(c).toFixed(2));
		}
		
		  $("select").change(function(){
		    $(this).find("option:selected").each(function(){
					var optionValue = $(this).attr("value");
						if(optionValue=='percentage'){
							document.getElementById('btn_additem').style.pointerEvents = 'none';
							if(dis<=100){
							var c= b *(dis/100);
								function round(value, decimals) {
									return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
								}
								var n=round(c,2);
								$("#amount").val(n);
								var c1=$("#amount").val();
										if(b>0){
											
										var diff=b-c1;

										$("#balance-amount").val(diff);
										$("#total-bal").text(parseFloat(diff).toFixed(2));
										} else{

										$("#balance-amount").val(c1);
										$("#total-bal").text(parseFloat(c1).toFixed(2));
										}
							}
							else
							{
								alert("please enter valid percent");
								$("#dis").val('');
								}
						}
						else{
							document.getElementById('btn_additem').style.pointerEvents = 'auto';
							var n=dis;
							$("#amount").val(n);
							var c=$("#amount").val();
									if(b>0){
									var diff=b-c;
									//~ alert(c);
									//~ alert(diff);
									$("#balance-amount").val(diff);
									$("#total-bal").text(parseFloat(diff).toFixed(2));
									} else{
									//~ alert(c);
									//alert(diff);
									$("#balance-amount").val(c);
									$("#total-bal").text(parseFloat(c).toFixed(2));
									}

							
							}
				});
			}).change();sum4();

		});

	});

//	document.getElementById('cash').style.pointerEvents = 'none';
        $(function() { // can replace the onload function with any other even like showing of a dialog

          $('#Adm_txtCode').focus();
            changeVal('retail','invNum');
          
        })
        $('#focusLast').on('focus', function() {
          // "last" focus guard got focus: set focus to the first field
         $('#Adm_txtCode').focus();
           
        });

        $('#focusFirst').on('focus', function() {
          // "first" focus guard got focus: set focus to the last field
         $('#btn_additem').focus();
          
        });
    function changeVal(src, desti){
					 var value =  document.getElementById(src).value;
					 document.getElementById(desti).innerHTML=value;
					 
				 }
    
     var picker = new Pikaday(
    {
        field: document.getElementById('AdmtxtDate'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2030, 12, 31),
        yearRange: [2016,2030],
        format: 'DD/MM/YYYY',
    });
    document.getElementById("AdmtxtDate").value = moment(new Date()).format('DD/MM/YYYY');

	$(function () {         
		$("#Adm_txtPro").autocomplete({
			
		minLength:2,
			source: "../get/search.php?p=get1",
				
			select: function (e, ui) {
				var i=ui.item.id;
			
				document.getElementById('1tag').value=i;
			}
		});
	});
	$(function () {         
		$("#Adm_txtCode").autocomplete({
		minLength:1,
			source: "../get/search.php?p=get12",
			select: function (e, ui) {
				var i=ui.item.id;
				document.getElementById('1dCode').value=i;
			}
		});
	});
    
$(function () {                 
$("#customer").autocomplete({
minLength:2,
source: "../get/search.php?q=getitem",
select: function (e, ui) {
var i=ui.item.id;
document.getElementById('cust_id').value=i;
}
});
});
	  $("#customer").blur(function(){
		  var a2=$("#cust_id").val();
		  $.ajax({
		url:"../get/customerbalance.php",
		method:"post",
		 data:{a4:a2}
		}).done(function(data){
			
	var res=data.split(",");
					

					 $("#bal_amt11").html(res[0]); 
		
		 if(document.getElementById('bal_amt11').innerText ==0){
			  document.getElementById("bal_amt11").style.display="none";
			  }
		});
		 
	  });
	  function sums(e) {
				 
				$(e).parent().parent().find('.estatus').val(3);
				 var txtFirstNumberValue=$(e).parent().parent().find('.rate1').val();
				 

var txtSecondNumberValue = $(e).parent().parent().find('.qty').val();
var discount = $(e).parent().parent().find('.dis').val();
if(txtSecondNumberValue>0)
{
	
var result = parseFloat(txtFirstNumberValue).toFixed(2) * parseFloat(txtSecondNumberValue).toFixed(2);
var ress=result-parseFloat(discount);
if (!isNaN(ress)) {
var re=parseFloat(ress).toFixed(2);

function round(value, decimals) {
return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}
var tt=document.getElementById('totamt').innerText; 
var r=$(e).parent().parent().find('.sum2').text();
//~ alert(r); 
//~ alert(tt);

var nres=round(ress,2);

$(e).parent().parent().find('.Adm_txtamt').val(nres);

var amt=$(e).parent().parent().find('.Adm_txtamt').val();
var sum = parseFloat(amt);
var s=   $(e).parent().parent().find('.sum2').text(sum);

if(amt>r)
{
	//alert(r);
	//alert(amt);
	
	//alert(tt);

	var a1=parseFloat(amt)-parseFloat(r);
	//~ var a2=parseFloat(a2)+parseFloat(a1);
	var abc=parseFloat(tt)+parseFloat(a1);
	//~ var as +=parseFloat(abc);
	  //alert(abc);
	document.getElementById('totamt').innerText=abc;
}
else{
	//alert("samll");
	var a3=parseFloat(r)-parseFloat(amt);
	var abc3=parseFloat(tt)-parseFloat(a3);
	//~ var a2=r-s;
	//~ var ab=tt-a2;
	document.getElementById('totamt').innerText=abc3;
} tblRowCount++;


//alert(s); 

//alert(nres);
 
                              var totTax=parseFloat($(e).parent().parent().find('.cgst').val())+parseFloat($(e).parent().parent().find('.sgst').val());
                              var totitemamt =$(e).parent().parent().find('.Adm_txtamt').val();
                             // alert(totTax);
                             //alert(totitemamt);
                             var qe=$('#Adm_txtamt1').val(totitemamt);
                             //alert(qe);
                              
                              var a=parseFloat(totitemamt)*parseFloat(totTax);
                              var b=parseFloat(100)+parseFloat(totTax);
                              var c=parseFloat(a)/parseFloat(b);
                              var grossamt=parseFloat(totitemamt)-parseFloat(c);
                              var cgst=$(e).parent().parent().find('.cgst').val();
                             
                               var tt1=document.getElementById('tottax').innerText;
                               var cgstcur=$(e).parent().parent().find('.cgst1').text();
                              //alert(cgst);
                              
                              var sgst=$(e).parent().parent().find('.sgst').val();
                              //alert(sgst);
                              var d=parseFloat(grossamt)*parseFloat(cgst);
                              var totcgst=parseFloat(d) / parseFloat(100);
                              var ncgst=round(totcgst,2);
                              var rr1=$(e).parent().parent().find('.cgst1').text(ncgst);
                              
//alert(tt1);
//alert(cgstcur);
//alert(ncgst);
if(ncgst>cgstcur)
{
	//alert(r);
	//alert(amt);
	
	//alert(tt);

	var a12=parseFloat(ncgst)-parseFloat(cgstcur);
	//~ var a2=parseFloat(a2)+parseFloat(a1);
	var abc123=parseFloat(tt1)+parseFloat(a12);
	//~ var as +=parseFloat(abc);
	  //alert(abc);
	  var curcgst=round(abc123,2);
	 document.getElementById('tottax').innerText=curcgst;
}
else{
	//alert("samll");
	var a31=parseFloat(cgstcur)-parseFloat(ncgst);
	var abc31=parseFloat(tt1)-parseFloat(a31);
	//~ var a2=r-s;
	//~ var ab=tt-a2;
	var cur1cgst=round(abc31,2);
	document.getElementById('tottax').innerText=cur1cgst;
}
var tt2=document.getElementById('tottax1').innerText;
//alert(tt2);
                               var sgstcur=$(e).parent().parent().find('.sgst1').text();
                               //alert(sgstcur);
                               

                              //alert(totcgst);
                               var q=parseFloat(grossamt)*parseFloat(sgst);
                              var totsgst=parseFloat(q) / parseFloat(100);
                              var nsgst=round(totsgst,2);
                              var r2=$(e).parent().parent().find('.sgst1').text(nsgst);
                              //alert(nsgst);
                              if(nsgst>sgstcur)
{
	//alert(r);
	//alert(amt);
	
	//alert(tt);

	var a121=parseFloat(nsgst)-parseFloat(sgstcur);
	//~ var a2=parseFloat(a2)+parseFloat(a1);
	var abc1234=parseFloat(tt2)+parseFloat(a121);
	//~ var as +=parseFloat(abc);
	  //alert(abc);
	  var cur1sgst=round(abc1234,2);
	 document.getElementById('tottax1').innerText=cur1sgst;
}
else{
	//alert("samll");
	var a311=parseFloat(sgstcur)-parseFloat(nsgst);
	var abc311=parseFloat(tt2)-parseFloat(a311);
	//~ var a2=r-s;
	//~ var ab=tt-a2;
	var cur1ssgst=round(abc311,2);
	document.getElementById('tottax1').innerText=cur1ssgst;
}


                            var e=parseFloat(grossamt)*parseFloat(sgst);
                             var totsgst=parseFloat(e) / parseFloat(100);
                           //alert(totsgst);
                              totalcgstamt=totalcgstamt+ncgst;
                             // alert(totalcgstamt);
                               totalsgst=totalsgst+nsgst;
                                totalamt=tt+sum;
                              //alert(totalamt);
                              
                            
                          

//~ var nsgst=round(totsgst,2);
//~ //alert(ncgst);
//~ //alert(nsgst);
//~ $(e).parent().parent().find('.cgst1').text(ncgst);
//~ $(e).parent().parent().find('.sgst1').text(nsgst);
                              
                              


}}
else
{
	//alert("please enter valid qty");
	}}
	 var tblRowCount = $('#rowcount').val();
	// document.getElementById('table').value=tblRowCount;
	$("#btn_additem").click(function() {
		  		  		  document.getElementById("Adm_txtPro").required = false;
		  		  		  document.getElementById("Adm_txtCode").required = false;
		if(parseFloat($('#Adm_txtsum').text())>0) {
			 tblRowCount++;
			 // document.getElementById('table').value=tblRowCount;
			var s= $('#has_return').val();
			if(s==0){
			
				var html='<tr class="tr_row">';
				html +='<td class="td_sl1" colspan="2"></td>';
				html +='<input type="hidden" name="estatus" class="estatus" value="1">';
				html +='<td colspan="2" class="no-print"><input type="hidden" value="'+$('#Adm_txtPro').val()+'" name="proname1[]" />'+$('#Adm_txtPro').val()+'</td>';	//PRODUCT
                html +='<td colspan="2" class="no-screen no-print"><input type="hidden" value="'+$('#1tag').val()+'" name="proid[]" />'+$('#1tag').val()+'</td>';	//PRO ID
				html +='<td class="n-screen no-print" colspan="2">'+$('#grossItemRate').text()+'</td>'; //GROSS RATE
				html +='<td class="no-screen no-print" colspan="2"><input type="hidden" class="Adm_txtmrp" value="'+$('#Adm_txtmrp').val()+'" name="Adm_txtmrp[]"/>'+$('#Adm_txtmrp').val()+'</td>'; //MRP
				html +='<td class="no-screen no-print" colspan="2"><input type="hidden" class="Adm_txtbuyprice" value="'+$('#Adm_txtbuyprice').val()+'" name="Adm_txtbuyprice[]"/>'+$('#Adm_txtbuyprice').val()+'</td>'; //BUY PRICE
				html+='<td class="no-screen no-print"><input type="hidden" class="totdiff" id="totdiff"></td>';
				html +='<td colspan="2" class="no-screen -txt"><input type="hidden" class="Adm_txtsellingprice" value="'+$('#Adm_txtprice').val()+'" name="buyprice1[]"/>'+$('#Adm_txtprice').val()+'</td>'; //RATE
				html +='<td class="" colspan="2"><input type="hidden" value="'+$('#hsn_code').val()+'" name="buypri[]"/>'+$('#hsn_code').val()+'</td>';//HSN
				html +='<td colspan="2" class="-txt"><input type="hidden" class="qty" value="'+$('#Adm_txtqty').val()+'" name="qty1[]"/>'+$('#Adm_txtqty').val()+' </td>';
				html +='<td colspan="2" class="-txt">'+$('#qty_unit').val()+$('#qty_unit').text()+'</td>';
				html +='<td class="no-print"><input type="hidden" id="taxcgsttax"  class="cgst" value="'+$('#Adm_txttax').text()+'" name="cgst[]"/>'+$('#Adm_txttax').text()+'</td>';
				html +='<td class="no-screen" colspan="2"><input type="hidden" class="" value="'+$('#Adm_txttax16666').text()+'" name="tax1[]"/>'+$('#Adm_txttax16666').text()+'</td>';
				html +='<td class="cgst1 no-print"><input type="hidden" class="tax" value="'+$('#Adm_txttax16666').text()+'" name="cgstamt[]"/>'+$('#Adm_txttax16666').text()+'</td>';
				html +='<td class="no-print"><input type="hidden" id="taxsgsttax" class="sgst" value="'+$('#Adm_txttax1').text()+'" name="sgst[]"/>'+$('#Adm_txttax1').text()+'</td>';
				html +='<td class="no-screen" colspan="2"><input type="hidden" class="" value="'+$('#Adm_txttax17777').text()+'" name="tax2[]"/>'+$('#Adm_txttax17777').text()+'</td>';
				html +='<td class="sgst1 no-print"><input type="hidden" class="tax1" value="'+$('#Adm_txttax17777').text()+'" name="sgstamt[]"/>'+$('#Adm_txttax17777').text()+'</td>';
				html +='<td colspan="2" class="-txt no-screen"><input type="hidden" class="disprice" value="'+$('#Adm_txtDis').val()+'" name="disprice1[]"/>'+$('#Adm_txtDis').val()+'</td>';// discount
				html +='<td colspan="2" class="sum2 -txt no-screen"><input type="hidden" class="sum2" value="'+$('#Adm_txtsum').text()+'" name="added1[]"/>'+$('#Adm_txtsum').text()+'</td>';
				html +='<td colspan="2" class="sum2 -txt no-screen">'+$('#Adm_txtsum').text()+'</td>';
				html +='<td colspan="2" class="sum2 -txt no-screen">'+$('#Adm_txtsum').text()+'</td>';
				html +='<td class="n-screen no-print" colspan="2"><input type="hidden" class="grossamt" value="'+$('#grossamt').val()+'" name="grossamt[]"/>'+$('#grossamt').val()+'</td>'; //GROSS AMT
				html +='<td class="red -txt- no-print"><i class="fa fa-times" aria-hidden="true" id = "'+tblRowCount+'" onclick="btnremove1(this)"></i> </td>';
				html +='</tr>';
				$('.tbody').append(html);

			     //+$("#grossamt").text()+
                  
                       //------To add item to print table--------
					var ptRow = '<tr style="height: 7mm;" class ="pt_row" id = "r'+tblRowCount+'" >';
					ptRow +='<td class="td_sl"></td>';
					ptRow +='<td>'+$('#Adm_txtPro').val()+'</td>';
					ptRow +='<td>'+$('#hsn_code').val()+'</td>';
					ptRow +='<td>'+$('#grossItemRate').text()+'</td>';
					ptRow +='<td>'+$('#Adm_txtqty').val()+'</td>';
					ptRow +='<td>'+$('#Adm_txttax').text().trim()+'</td>';
					ptRow +='<td>'+$('#Adm_txttax16666').text().trim()+'</td>';
					ptRow +='<td>'+$('#Adm_txttax1').text().trim()+'</td>';
					ptRow +='<td>'+$('#Adm_txttax17777').text().trim()+'</td>';
					ptRow +='<td style="text-align: right;">'+$('#grossamt').val()+'</td>';
					ptRow +='</tr>'
					$('.ptBody').prepend(ptRow);
                    
				slno1();
				document.getElementById('Adm_txtCode').value = '';
				document.getElementById('Adm_txtPro').value = '';
				document.getElementById('Adm_txtprice').value = '';
				document.getElementById('Adm_txttax').innerText = '';
				document.getElementById('Adm_txttax1').innerText = '';
				document.getElementById('Adm_txtqty').value = '';
				document.getElementById('Adm_txttax16666').innerText = '';
				document.getElementById('Adm_txttax17777').innerText = '';
				document.getElementById('Adm_txtsum').innerText = '';
				document.getElementById('qty_unit').innerText = '';
				document.getElementById('hsn_code').value = '';
				$('#grossLineAmt').text('');
				function discCal(){
			var billAmt = parseFloat(document.getElementById('total-amt').innerText);
			//alert(billAmt);
			var disc = parseFloat(document.getElementById('dis').value);
			//alert(disc);
				function round(value, decimals) {
					return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
				}
			var dType = parseFloat(document.getElementById('select').value);
			if (dType == "1"){
				document.getElementById('btn_additem').style.pointerEvents = 'none';
				if(disc<=100){
				var qm=parseFloat(billAmt) * parseFloat(disc);
				var w=qm/parseFloat(100);
				var diff=parseFloat(billAmt)-parseFloat(w);
				var n=round(diff,2);


				document.getElementById('balance-amount').value = n;

				document.getElementById('total-bal').innerText = n;
			
			}
			else
			{
				//~ //alert("please enter valid percent");
				$("#dis").val('0');
			}
			}else if(dType == "2"){
				document.getElementById('btn_additem').style.pointerEvents = 'auto';
				var r=parseFloat(billAmt)-parseFloat(disc);
				var z=round(r,2);
				document.getElementById('balance-amount').value = z;
				document.getElementById('total-bal').innerText =z;
			}
			sum4();
		}

}
			else{
				
				alert("cannot be add");
				
				}
				
			}else {
				notify('warning', 'Please Select a Product!');
				$('#Adm_txtPro').focus().val('');
				$('#Adm_txtCode').focus().val('');
			}
		}); 
	function slno1() {
        $(".tottax").html('0.00');
        $(".tottax1").html('0.00');
        $(".totamt").html('0.00');
		var i=1;
		var totamt=0;
		var tottax=0;   //cgst
		var tottax1=0;  //sgst
		var totqty=0;
        var grosTot = 0;
        var totamtfraction =0; // gross + cgst + sgst
		$('.tr_row').each(function() {
			$(this).find('.td_sl1').html(i);
            var amt=$(this).find('.sum2').text();
            var qty=$(this).find('.qty').val();
            var gamt=$(this).find('.grossamt').val();
            //var gross=$(this).find('.1grossamt').val();
            //var gg=parseFloat(gamt)+parseFloat(gross);
            var tax=$(this).find('.cgst1').text();      
            var tax1=$(this).find('.sgst1').text();
            totamt=parseFloat(totamt)+parseFloat(amt);   //total amount
            grosTot = parseFloat(grosTot) + parseFloat(gamt);  //total gross amount
            tottax=parseFloat(tottax)+parseFloat(tax);          //total cgst amt
            tottax1=parseFloat(tottax1)+parseFloat(tax1);       //total sgst amt
            totamtfraction = grosTot + tottax + tottax1;        // gross amt + cgst amt + sgst amt
            totqty=parseFloat(totqty)+parseFloat(qty);    
            var whole=Math.floor(totamtfraction);
var fraction=parseFloat(totamtfraction)-parseFloat(whole);
if(fraction==0){
$("#fraction").val(0);
$("#amtpart").val(parseFloat(totamtfraction).toFixed(2));
}
else if(fraction>0.50){
var dec=1-parseFloat(fraction);

amtblnc=parseFloat(totamtfraction)+parseFloat(dec);

$("#fraction").val(parseFloat(dec).toFixed(2));
$("#amtpart").val(parseFloat(amtblnc).toFixed(2));
}
else{

amtblnc=parseFloat(totamtfraction)-parseFloat(fraction);
$("#fraction").val(parseFloat(-fraction).toFixed(2));
$("#amtpart").val(parseFloat(amtblnc).toFixed(2));
}      // gross amt + cgst amt + sgst amt      //total qty
				$(".tottax").html(parseFloat(tottax).toFixed(2));   //Display total CGST in billing table 
                $(".tottax1").html(parseFloat(tottax1).toFixed(2));  //Display total SGST in billing table 
                $(".totamt").html(parseFloat(grosTot).toFixed(2));   //Display Total amount in billing table
                $("#total-amt").html(parseFloat(totamt).toFixed(2)); //Display in invoice screen top
                $(".totqty").text(totqty);	//Display Total Qty in invoice table
                $("#taxcgst").val(parseFloat(tottax).toFixed(2)); //For saving
				$("#taxsgst").val(parseFloat(tottax1).toFixed(2)); //For saving
				$("#amttotal").val(parseFloat(totamt).toFixed(2));  //For saving
				$("#totCgstPrint").html(parseFloat(tottax).toFixed(2)); //Print table total GST
                $("#totSgstPrint").html(parseFloat(tottax1).toFixed(2));//Print table total GST
                $("#pTotQty").text(totqty);                             //
                $("#pTotAmt").text(parseFloat(grosTot).toFixed(2));     //total taxable print
               var roundtotPrint=parseFloat(totamtfraction)+parseFloat($('#fraction').val());
			  $("#roundtotPrint").text(round(roundtotPrint,2).toFixed(2));
				$("#nettAmtPrint").text(grosTot.toFixed(2));
                $("#roundoffPrint").text($('#fraction').val());
				$('#totAmtPrint').text(round(totamt,2));
				i++;
			});
			
			    var siJ = 1;
            $('.pt_row').each(function() {
                $(this).find('.td_sl').html(siJ);
                siJ++;
            });
			
			}
	function btnremove1(e) {
		 //----remove from print table
          //  $("#p"+$(e).attr('id')+"").remove();
            $("#r"+$(e).attr('id')+"").remove();
			var s= $('#has_return').val();
			//alert(s);
			var d=$('#active').val();
			//alert(d);
			
			if(s==0) 
			{
                $(e).parent().parent().find('.estatus').val(0);
			var r=$(e).parent().parent().find('.estatus').val();
			//alert(r);
				
			$(e).parent().parent().removeClass('tr_row');
			$(e).parent().parent().hide();
		
			
			slno1();
	  
  }
  else
  {
	notify("danger","Can't Delete!");
  }
}
  
		
			
				
		
		
			
			
		function check(e) {
			if($(e).val().length<3) {} else {
				$('#person_list').html('');
					$.ajax({
					url:"../get/post.php?p=getitemlist",
					method:"post",
					data:{itemname:$(e).val().trim()}
				}).done(function(data) {
					$('#person_list').append(data.trim());
				});
			}
			}
		
		$(document).ready(function(){	
			$.ajax({
			url:"../ajax/customerajax.php",
			method:"post",
			}).done(function(data){
			$("#customer").html(data);
			});
			$("#Adm_txtPro").change(function() {
				var a=$("#Adm_txtPro").val();
				var a2=$("#code").val();
				var pid = $("#1tag").val();
				$.ajax({
					url:"../get/post.php?p=geteachitem",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					var res=data.split(",");
					var ttt=res[2];
					$("#Adm_txtprice").val(parseFloat(res[2]));
					$("#Adm_txttax").html(res[0]);
					$("#qty_unit").html(res[1]);
					$("#hsn_code").val(res[3]);
					$("#Adm_txtCode").val(res[4]);
					$("#item_stock").val(res[7]);
					sum();
				});
				$.ajax({
					url:"../get/post.php?p=geteachitemtax",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					$("#Adm_txttax1").html(data);
					sum();
				});
			});
			$("#Adm_txtCode").change(function() {
				var a=$("#Adm_txtCode").val();
				var a2=$("#code").val();
				var pid = $("#1dCode").val();
				$.ajax({
					url:"../get/post.php?p=geteachitem1",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					var res=data.split(",");
					var ttt=res[2];
					$("#Adm_txtprice").val(parseFloat(res[2]));
					$("#Adm_txttax").html(res[0]);
					$("#qty_unit").html(res[1]);
					$("#hsn_code").val(res[3]);
					$("#item_stock").val(res[7]);
					sum();
				});
				$.ajax({
					url:"../get/post.php?p=geteachitemtax1",
					method:"post",
					data:{ itemid:pid }
				}).done(function(data) {
					var res1=data.split(",");
					$("#Adm_txttax1").html(res1[0]);
					$("#Adm_txtPro").val(res1[1]);
					sum();
				});
			});
		});
		     function sum() {
				 
				var item_stock=document.getElementById('item_stock').value;
				var qty = document.getElementById('Adm_txtqty').value;
				if(qty!=''){
						notifyPopup(item_stock);
						if(parseFloat(qty)<=parseFloat(item_stock) && parseFloat(qty)>=0 ){
							var txtFirstNumberValue = document.getElementById('Adm_txtprice').value;
							var txttt = document.getElementById('Adm_txtDis').value;
							var txtSecondNumberValue = document.getElementById('Adm_txtqty').value;
							var result = parseFloat(txtFirstNumberValue).toFixed(2) * parseFloat(txtSecondNumberValue).toFixed(2);
							var resultdis=parseFloat(result)-parseFloat(txttt);
							if (!isNaN(resultdis)) {
					var re=parseFloat(resultdis).toFixed(2);
					
					function round(value, decimals) {
						return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
						}

						var nres=round(resultdis,2);
						//alert(resultdis);
				document.getElementById('Adm_txtamt').value = nres;
                	var totTax=parseFloat(document.getElementById('Adm_txttax').innerText)+parseFloat(document.getElementById('Adm_txttax1').innerText);
                	var totitemamt = document.getElementById('Adm_txtamt').value;
                	var a=parseFloat(totitemamt)*parseFloat(totTax);
                	var b=parseFloat(100)+parseFloat(totTax);
                	var c=parseFloat(a)/parseFloat(b);
                	var grossamt=parseFloat(totitemamt)-parseFloat(c);
                	var rgrossamt=round(grossamt,2);
                	document.getElementById('grossamt').value=rgrossamt;
					var grossRate = round(rgrossamt/qty,2);
                	var cgst=document.getElementById('Adm_txttax').innerText;
                	var sgst=document.getElementById('Adm_txttax1').innerText;
                	var d=parseFloat(grossamt)*parseFloat(cgst);
                	var totcgst=parseFloat(d) / parseFloat(100);
                	var e=parseFloat(grossamt)*parseFloat(sgst);
                	var totsgst=parseFloat(e) / parseFloat(100);
                	function round(value, decimals) {
						return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
						}

						var ncgst=round(totcgst,2);
						var nsgst=round(totsgst,2);
                	document.getElementById('Adm_txttax16666').innerText=ncgst;
                	document.getElementById('Adm_txttax17777').innerText=nsgst;
                	var amt=document.getElementById('Adm_txtamt').value;
                	//~ var ma=document.getElementById('totamt').innerText;
                	//~ alert(ma);
                	//~ var mb=document.getElementById('tottax1').innerText;
                	//~ alert(mb);
                	//~ var mc=document.getElementById('tottax').innerText;
                	//~ alert(mc);
                	//parseFloat(grossItemRate)*parseFloat(txtSecondNumberValue)
                	
						var sum = parseFloat(amt);
						document.getElementById('Adm_txtsum').innerText=sum.toFixed(2);
						$('#grossItemRate').text(grossRate);
						$('#grossLineAmt').text(rgrossamt);
					
			}
			
			
			}
			else 
{
notifyPopup(item_stock);
document.getElementById('Adm_txtqty').value='';
}
		}
			}
					//~ if(parseFloat(txtyyumberValue) >0 && parseFloat(txtthird1NumberValue) >0 ) {
						
						//~ document.getElementById('Adm_txttax16666').innerText=n;
						//~ }else {
						//~ document.getElementById('Adm_txttax16666').innerText='0.00';
					//~ }
					
        function sum23(){
				var txtthirdNumberValue = document.getElementById('Adm_txtamt').value;
				var txtSecondNumberValue = document.getElementById('Adm_txtqty').value;
				var result1 = parseFloat(txtthirdNumberValue) / parseFloat(txtSecondNumberValue);
				document.getElementById('Adm_txtprice').value = result1;
                
			}
		 /*function sum3(){
				var txtthirdNumberValue = document.getElementById('Adm_txtamt').value;
				var txtyyumberValue=document.getElementById('Adm_txttax').innerText;
				var re = parseFloat(txtyyumberValue) * parseFloat(txtthirdNumberValue);
				var re1=re / 100;
				document.getElementById('Adm_txttax16666').innerText=re1;
                
			}*/
        function sum4(){
				var txt1NumberValue = document.getElementById('total-bal').innerText;
				var txt2Value=document.getElementById('collect').value
				var re = parseFloat(txt2Value) - parseFloat(txt1NumberValue);
				document.getElementById('c_diff').innerHTML=re.toFixed(2);
                
			}
		$("#toggelon").click(function(){
			if (document.getElementById("customer-on").style.display == "none")
			{
				document.getElementById('cash').style.pointerEvents = 'auto';
				document.getElementById('credit').style.pointerEvents = 'auto';
			$('#customer').attr('disabled',false);
			$('#cash').attr('disabled',false);
			$('#credit').attr('disabled',false);
			var val=10;
				//alert("only cash");
			document.getElementById("cash-credit").value=val;
			
			document.getElementById("customer-on").style.display="inline-block";
			document.getElementById("customer-off").style.display="none";
		}
		else
		{
			document.getElementById('cash').style.pointerEvents = 'none';
			document.getElementById('credit').style.pointerEvents = 'none';
			$('#customer').attr('disabled',true);
			$('#cash').attr('disabled',true);
			$('#credit').attr('disabled',true);
			
			document.getElementById("customer-on").style.display="none";
			document.getElementById("customer-off").style.display="inline-block";
		}
	});
		$("#cash").click(function(){
		var val=11;
				//alert("only cash");
			document.getElementById("cash-credit").value=val;
				//alert("only cash");
			//document.getElementById("cash-credit").value="10";
			document.getElementById("cash").style.display="none";
			document.getElementById("credit").style.display="inline-block";
		
	});
	$("#credit").click(function(){
	var val=10;
				//alert("only cash");
			document.getElementById("cash-credit").value=val;
			document.getElementById("credit").style.display="none";
			document.getElementById("cash").style.display="inline-block";
		
	});
		 function changeVal(src, desti){
					 var value =  document.getElementById(src).value;
					 document.getElementById(desti).innerHTML=value;
					// document.getElementById("datelabel").innerHTML=value;
					 //alert(value);
					 
				 }
    
    function changeVal2(src, desti){
     
					 var value =  document.getElementById(src).value;
					 document.getElementById(desti).innerHTML=value;
        
					 
				 }
				 
				//~ $("#date1").blur(function(){
					//~ alert($(this).val());
				//~ });
                function alertinput(){
                var div1 = document.getElementById("div1");
                    //~div1.setAttribute("align", "helloButton");
                    var align = div1.getAttribute("dataid");

                    alert(align); 
                }
                         
    //  <!------  PDF Print -------------->
    var docSave = {};
     function printInv(){
                   
                     function parseTableHead(tabId) {
                        var tBody   =   new Array();
                        var tWidth  =   document.getElementById(tabId).rows[0].cells.length;
                            tBody[0] = new Array();
                                for(j = 0; j < tWidth; j++){ 
                                    tBody [0][j] = { text: document.getElementById(tabId).rows[0].cells[j].innerHTML, bold: true, fontSize: 10, };
                                }  
                         //console.log(JSON.stringify(tBody, null, 4));
                        return tBody;
                    }
                     function parseTableBody(tabId) {
                        var tHeight =   document.getElementById(tabId).rows.length;
                        var tBody   =   new Array();
                        for(i = 0, k = 1; k < tHeight -1; i++, k++){
                            var tWidth  =   document.getElementById(tabId).rows[i].cells.length;
                            tBody[i] = new Array();
                            for(j = 0; j < tWidth; j++){    //alert(document.getElementById(tabId).rows[k].cells[j].innerHTML);
															var x=document.getElementById(tabId).rows[k].cells[j].style.textAlign;
								switch (x)
									{
											case "right":
											tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 9,alignment:'right' ,};
											break;
											case "left" :
											tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 9,alignment:'left' ,};
											break;
											case "center" :
											tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 9,alignment:'center' ,};
											break;
											default:
											 tBody[i][j] = { text: document.getElementById(tabId).rows[k].cells[j].innerHTML, fontSize: 9,};
										}
                                                             
															 } 
                          }
                        return tBody;
                    }
                    function parseTableFoot(tabId){
                        var tHeight =   document.getElementById(tabId).rows.length;
                        var tBody   =   new Array();
                        var k2      =   tHeight - 1;
                        var tWidth  =   document.getElementById(tabId).rows[k2].cells.length;
                        tBody[0] = new Array();
                        for(j = 0; j < tWidth; j++){     
                                                     
													 var x=document.getElementById(tabId).rows[k2].cells[j].style.textAlign;
														switch (x)
                                                        {
                                                                case "right":
                                                                tBody[0][j] = { text: document.getElementById(tabId).rows[k2].cells[j].innerHTML, fontSize: 10,alignment:'right' ,};
                                                                break;
                                                                case "left" :
                                                                tBody[0][j] = { text: document.getElementById(tabId).rows[k2].cells[j].innerHTML, fontSize: 10,alignment:'left' ,};
                                                                break;
                                                                case "center" :
                                                                tBody[0][j] = { text: document.getElementById(tabId).rows[k2].cells[j].innerHTML, fontSize: 10,alignment:'center' ,};
                                                                break;
                                                                default:
                                                                tBody[0][j] = { text: document.getElementById(tabId).rows[k2].cells[j].innerHTML, fontSize: 10,};
                                                            }
                        


													 } 
                        //console.log(JSON.stringify(tBody, null, 4));
                        return tBody;
                     }
                   // return pdfMake.createPdf({
                    var docDefinition = {
                        // a string or { width: number, height: number }
                           pageSize: {width: 585, height: 830},

                        // by default we use portrait, you can change it to landscape if you wish
                          pageOrientation: 'portrait',

                        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
                          pageMargins: [ 40,125, 40, 80 ],
                                 header: {
							  margin: [40, 20, 40, 35],
							  columns: [
								[
								{image:"data:image/jpeg;base64,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", alignment: 'center',width: 120, margin: [ 0, 12]},
									
                                        {text: ''+document.getElementById("address-line1").innerHTML, fontSize: 8, alignment: 'center', margin: [ 10, 0]},
                                        {text: ''+document.getElementById("address-website").innerHTML, fontSize: 8, alignment: 'center', margin: [ 10, 0]},
                                        {text: ''+document.getElementById("address-phone").innerHTML, fontSize: 8, alignment: 'center', margin: [ 10, 0]},
                                        {text: ' ', fontSize: 7, alignment: 'center', margin: [ 10, 2, 10, 0]},
                                       ]
							
							  ]
	  
						  },
						 

                         
                           content: [
                           {columns: [
											{width: 80, text: 'Slno', fontSize: 10, bold: true, alignment: 'left'},
										{width: 150, text: ': '+document.getElementById('invNum').value, fontSize: 10, alignment: 'left'},
										{width: 100, text: 'CREDIT/CASH', fontSize: 10, bold: true, alignment: 'left'},
										
											{width: 55, text: 'State', fontSize: 10, bold: true, alignment: 'left'},
										{width: 100, text: ': Kerala', fontSize: 10, alignment: 'left'}
												
								],
                                 margin: [0,5]},       
                                        {columns: [ 
											{width: 80, text: 'Date of issue',  fontSize: 10, bold: true, alignment: 'left'},
										{width: 110, text: ': '+document.getElementById('datePrint').innerHTML, fontSize: 10, alignment: 'left'},
										{width: 140, text: 'GSTIN : 32ABJFM1167G1ZG', fontSize: 10, bold: true, alignment: 'left'},
											{width: 55, text: 'State Code',   fontSize: 10, bold: true, alignment: 'left'},
											
										{width: 100, text: ': 32', fontSize: 10, alignment: 'left'}
												
								],
                                 margin: [0,5]},  
                                                            	{
			style: 'tableExample',
			table: {
					widths: [248,248],
				body: [
					['Details of Receiver (Billed to) ', 'Details of Consignor'],
					[{text: [
								
								{width: 80, text: 'Name', fontSize: 10, bold: true},
								{width: 150, text: ': '+document.getElementById('customerPrint').innerHTML, fontSize: 10},
									{text: '\n', italics: true},
									{width: 80, text: 'Address', fontSize: 10, bold: true},
										{width: 150, text: ': '+document.getElementById('custaddress').innerHTML, fontSize: 10},
											{text: '\n', italics: true},
											{width: 80, text: '', fontSize: 10, bold: true},
											{text: '\n', italics: true},
										{width: 80, text: 'GSTIN', fontSize: 10, bold: true},
										
										{width: 150, text: ': '+document.getElementById('custgstin').innerHTML, fontSize: 10},
										{text: '\n', italics: true},
										{width: 80, text: 'State', fontSize: 10, bold: true},
										{width: 150, text: ': '+document.getElementById('custstate').innerHTML, fontSize: 10},
                                        {width: 80, text: '\nPhone', fontSize: 10, bold: true},
										{width: 150, text: ': '+document.getElementById('custphone').innerHTML, fontSize: 10}
										]
						}, {text: [
								
								{width: 80, text: 'Name', fontSize: 10, bold: true},
								{width: 150, text: ': '+document.getElementById('brand-name').innerHTML, fontSize: 10},
									{text: '\n', italics: true},
									{width: 80, text: 'Address', fontSize: 10, bold: true},
										{width: 150, text: ': '+document.getElementById('address-line1').innerHTML, fontSize: 10},
											{text: '\n', italics: true},
											{width: 80, text: '', fontSize: 10, bold: true},
											{text: '\n', italics: true},
										{width: 80, text: 'GSTIN', fontSize: 10, bold: true},
										{width: 150, text: ': 32ABJFM1167G1ZG', fontSize: 10},
										{text: '\n', italics: true},
										{width: 80, text: 'State', fontSize: 10, bold: true},
										{width: 150, text: ': Kerala ', fontSize: 10}
										]
						}]
				]
			}
		},
                                        
										 {table: { 
                                            widths: [ 15,150,48,35,30,20,33,20,33,40],
                                            body: parseTableHead("invPTable") }, layout: '' },
										
                                           
						
                                        {table: {
                                                widths: [ 15,150,48,35,30,20,33,20,33,40],
												margin: [10,0,10,0],
                                                 body: parseTableBody("invPTable") }, layout: '' },
                                       
                                        {table: {
                                                widths: [ 15,150,48,35,30,20,33,20,33,40],
												
                                                 body: parseTableFoot("invPTable") }, layout: '' },
                                        {
			style: 'tableExample',
			table: {	
				
					widths: [505],
				body: [
					
					[{text: 'Amount: '+inWords(parseInt($('#totAmtPrint').text()))+' Rupees only '}],
					]}},
                                        {
			style: 'tableExample',
			table: {	
					heights: [100],
					widths: [162,130,195],
				body: [[
                    { text:[
                        {text:'MS TRADERS', alignment: 'left', fontSize: 9, bold: true},
                        {text:'\nAC NO :', alignment: 'left', fontSize: 9},
                        {text:' 37830818575', alignment: 'left', fontSize: 9, bold: true},
                        {text:'\nIFSC :', alignment: 'left', fontSize: 9},
                        {text:' SBIN0015040 ', alignment: 'left', fontSize: 9, bold: true},
                        {text:'\nSBI KODAKARA', alignment: 'left', fontSize: 9},
                    ]},
                    {text: '(Common seal)',alignment: 'center'},
                    {text: 
                      [
                        {text:'Certified that the particulars given above the true and correct', fontSize: 7},
                        {text: '\n', italics: true}, { text: 'FOR M.S TRADERS', fontSize: 10,bold: true},
                        {text: '\n', italics: true},{width: 80, text: '', fontSize: 10, bold: true},
                        {text: '\n', italics: true},{ text: 'Authorised Signatory', fontSize: 10}
                      ]
                     }
                    ]]}},
                                    ]
                      }
                    //);
                    docSave = jQuery.extend(true, {}, docDefinition);
                 return pdfMake.createPdf(docDefinition);
                }     
    
// <!------  PDF Print -------------->
               
 
           
            </script>
