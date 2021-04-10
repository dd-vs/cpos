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
                          pageMargins: [ 40,90, 40, 80 ],
                                 header: {
							  margin: [40, 20, 40, 35],
							  columns: [
								[
								{image:"data:image/jpeg;base64,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aHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOC0wOC0wMlQxNjo0MDowMyswNTozMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxOC0wOC0wMlQxNjo0MDowMyswNTozMCIgeG1wOk1vZGlmeURhdGU9IjIwMTgtMDgtMDJUMTY6NDA6MDMrMDU6MzAiIHBob3Rvc2hvcDpDb2xvck1vZGU9IjEiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJEb3QgR2FpbiAyMCUiIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMDQ4MEFCMDI0OTZFODExQUNGMzg2MDlENjM1RjdCMCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMDQ4MEFCMDI0OTZFODExQUNGMzg2MDlENjM1RjdCMCIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjMwNDgwQUIwMjQ5NkU4MTFBQ0YzODYwOUQ2MzVGN0IwIj4gPHBob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4gPHJkZjpCYWc+IDxyZGY6bGk+YWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjdjN2IzYTgxLTgwNDktMTFlOC05ZmQxLWQ3Njc5NjM5OTMxMTwvcmRmOmxpPiA8L3JkZjpCYWc+IDwvcGhvdG9zaG9wOkRvY3VtZW50QW5jZXN0b3JzPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjMwNDgwQUIwMjQ5NkU4MTFBQ0YzODYwOUQ2MzVGN0IwIiBzdEV2dDp3aGVuPSIyMDE4LTA4LTAyVDE2OjQwOjAzKzA1OjMwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0idyI/Pv/iA6BJQ0NfUFJPRklMRQABAQAAA5BBREJFAhAAAHBydHJHUkFZWFlaIAfPAAYAAwAAAAAAAGFjc3BBUFBMAAAAAG5vbmUAAAAAAAAAAAAAAAAAAAABAAD21gABAAAAANMtQURCRQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABWNwcnQAAADAAAAAMmRlc2MAAAD0AAAAZ3d0cHQAAAFcAAAAFGJrcHQAAAFwAAAAFGtUUkMAAAGEAAACDHRleHQAAAAAQ29weXJpZ2h0IDE5OTkgQWRvYmUgU3lzdGVtcyBJbmNvcnBvcmF0ZWQAAABkZXNjAAAAAAAAAA1Eb3QgR2FpbiAyMCUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhZWiAAAAAAAAD21gABAAAAANMtWFlaIAAAAAAAAAAAAAAAAAAAAABjdXJ2AAAAAAAAAQAAAAAQACAAMABAAFAAYQB/AKAAxQDsARcBRAF1AagB3gIWAlICkALQAxMDWQOhA+wEOQSIBNoFLgWFBd4GOQaWBvYHVwe7CCIIigj0CWEJ0ApBCrQLKQugDBoMlQ0SDZIOEw6WDxwPoxAsELgRRRHUEmUS+BONFCQUvRVXFfQWkhcyF9QYeBkeGcYabxsbG8gcdh0nHdoejh9EH/wgtSFxIi4i7SOtJHAlNCX5JsEniihVKSIp8CrAK5IsZS06LhEu6i/EMKAxfTJcMz00HzUDNek20De5OKQ5kDp+O208Xj1RPkU/O0AzQSxCJkMiRCBFH0YgRyNIJ0ktSjRLPExHTVNOYE9vUH9RkVKlU7pU0VXpVwJYHlk6WlhbeFyZXbxe4GAGYS1iVmOAZKxl2WcIaDhpaWqda9FtB24/b3hwsnHucyt0anWqdux4L3l0erp8AX1KfpV/4YEugnyDzYUehnGHxYkbinKLy40ljoGP3ZE8kpuT/ZVflsOYKJmPmvecYJ3LnzegpaIUo4Wk9qZpp96pVKrLrEStvq85sLayNLO0tTS2t7g6ub+7RbzNvla/4MFswvnEh8YXx6jJO8rOzGPN+s+S0SvSxdRh1f7XnNk82t3cf94j38jhbuMW5L/maegU6cHrb+0f7tDwgvI18+r1oPdX+RD6yvyF/kH////uAA5BZG9iZQBkAAAAAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwP/wAALCAA5AZABAREA/90ABAAy/8QA0gAAAAYCAwEAAAAAAAAAAAAABwgGBQQJAwoCAQALEAACAQMEAQMDAgMDAwIGCXUBAgMEEQUSBiEHEyIACDEUQTIjFQlRQhZhJDMXUnGBGGKRJUOhsfAmNHIKGcHRNSfhUzaC8ZKiRFRzRUY3R2MoVVZXGrLC0uLyZIN0k4Rlo7PD0+MpOGbzdSo5OkhJSlhZWmdoaWp2d3h5eoWGh4iJipSVlpeYmZqkpaanqKmqtLW2t7i5usTFxsfIycrU1dbX2Nna5OXm5+jp6vT19vf4+fr/2gAIAQEAAD8A3+PfvZAv5mnyeovin8Pu1d+0e52212LmsLVbS6gekmWPKz9h5anlbGV1FG8csclLtejgny1b5QIWpKJ4ydciI4r/AAi+RNL8tPiP8e/kbTpTw1HbHV+2tyZympNIpKHdi0v8M3njqUK72psbu3H1sEYJ1BIwCAbgGm9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9//Q3+PaG7M7H2j1D1/u/s7fuUTDbP2Pgq/cOeyDL5HjoqCIv4KWAEPV5CtmKwU0CXkqKiRI0BZgPfz0P5l/zo7t/mLd9UG0tm4LPZODKZ4dbdMdS7dD5Orpl3HkqWhpNr4amoyy5Teu9K+GnbO5NeH8aUsTLSUqAbT38qruXq/43ZHZX8nbJbgo8v3V8bPjpgd9ZrdNDlKOr2zu/sLcW7M9unv3r7a8yCEz1PTu4d9Y2BVXXPUUc8ryxwPSTILyvYOdX/IHpzurcfbe1Oq994ne+a6K30ese1o8JFXy0W0uwIsXR5mt2lPl5aOHE5LMYqir4hWx0U9SKKoZqecx1EckSFq+Tv8ANC+Bfw53fS9ffIf5HbQ2Pv2ppIK99l0ON3XvjdGNoaqMS0lXn8JsHb+6K/bcNbCwkgOQSmM8bB4wym/ss3/QQB/KT/7yxpf/AEUPfH+9f6ML+xz+OP8ANp+A3y37WxvSfx17sruzuycniMvuBcDiuqu4cZBj8BgoVlyWbzed3DsHEbfwWMikligSWrqoVmqp4oY9UsiqbHvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvf/9Hf491SfzrML2Dm/wCXb3SnXtHka+fF1Wzs9u2nxMdRNkE2HhtzY+t3NXxwUx8klLiII0rKtirLBRwSzNYRll1tf5LO0dvbc2986vlti4cZXdxdAbF68686krq2np6+Lr6fu+bcNBuff9HDNFJ9rmY8Pio6Slq0YWpjWwOGinkVq0fjD3N2E385j4Ubx62OcyGWn+UGE2JT0tBNUS5jcWwN61OX2/27XZeoYySTxZja2TyORyM8xMccEWuQgLf3sL/zvf54R6qbdvww+Fm7437bK1e3u9O9dvVUc0PT8UimDJdedd5KFmhqO3JonMeRyMZZNsIxjjJypJx9bP8ALx+be5fgL/Ji+X3anXzQp212T8vKbpjqHJZFRkEw2+t3dU7dymW3vW09TIz5Ko2jtmgr8nGZvLHPkkp1qA8cjq1THwy+EXyW/mPd4Z/YfTxh3Fuwwyb87c7b7O3DXnEYKmzOTNPNurfG4pIspn9w7h3Blpn8FLTR1VdVssrhFhhkeO49v+EsvzfuwHyC+LLAEhbT9sLdfxcf3DNrj/be9kX+UL/K4wX8tXpbP0G58tt7ffyJ7UycWU7c7F2/BWjCjHYh6mDaOw9mNlqSiykG0du0c71DtNDFPW5KrnmlGgQJFbr71Pd5/wDCxb+WPsjeG69l5HpL5z1+Q2juTO7Yrq/EdadAT4qtrMBlKrE1VZjJqv5N0NXNj6mekZ4GlghkaMgsiNdRfJ/L0+ffSv8AMs+M+3vlR0Jh+wdu7C3BuXd201wHaWI25g974nM7Ny8mJyUOXx2092b3wMSVaiOqpjBkpy9LPGXEchaNatPnb/wpw/l9/wAv35PdhfE/tXYHyj7A7G6vj20u78x03sjqTcGyqHJbm21it10+Diyu8e8dh5ifL43F5qnFYn8PEUM7GMSOyPpNL/Kz/nYfFr+bnle6sT8buu/kLsqXojH7DyO8anu7anXG26Suj7Eqd202Bg28+xO1+yZqupibZdY1QKlKRUXRoaQlglwnv3v3uqr+YT/Oh/l/fyy6qi218lu26p+08tg5dxYbpPrTA1O++06/DiCregr63EUs1Fg9o0ecqaNqbH1GeyOKp6yYkxSNHFPJFVFsP/hYn/Kf3fnDidw7P+YfVlAKOWpG59+dQde5HBtPHLTxpjhT9Ydz9j7l+8qI5mkRjjhThIn1SqxRX2itkbz212PsvaHYey8mub2dvza+A3ntPMpS1tCmX21ujE0mcwWTWiydNRZGkWvxddFKIqiGKeMPpdFYFQqPfvdbH8zv+aV8e/5T/Texe7/kVtTt/eW1+wezaTqvB4npfAbL3FuaHPVe1tz7uGRyNHvnsDrnFw4KDH7VmiklirJpxUTQqISjO8dH4/4We/yvD/zQb58fW3/Mrvjz/wDdS++/+gz3+V5xfob58C/9ervjz/h/4FL/AI+7vP5YX80z4/8A82Hp/fndnx22Z3NsvafXnZM/VuZo+69u7K25nazcNNtfbm7ZarE0+xuwuxsbUYlcbuemTXLVwTiYODEE0u8n+Z1/ND6B/lQ9KbJ74+RG0O4d57R352ljeo8Rjeltv7L3FuSm3JlNp7v3lBXZKj3x2B1zjIcGmM2XVRvJFWTTieSJRCUZ3jo5/wCgz3+V5/z4b58fn/ml/wAeObf0/wCcpefYn9Q/8K/P5TPZ29aHaW58X8qeisbXCJV3/wBu9S7MqNlUtTNkKChjpa5uoO1+2d10h8da9S074oUkdPTSl5lfxJJs57N3ltPsTaW2d/bD3Jhd47J3pgcVujaW7Nt5KlzG39ybcztFDksNnMLlaGWajyOMydBUxzQTROySRuCCQfal91ifzP8A+bR8Xf5THXPW3YvyTx3Z+6R2xvLIbN2XsrpzBbS3FvjIvhcM+Z3DuN8fvXfPXuGj2xt1JqKnrJxXtOlTk6RFhdZHeOrr46f8K0/5aHyR746i6AwHXHy82BuHufsHa/Wm293dnbA6Ww+wcPuTeWUp8Ht9t1ZbbXyC3bmcViqvM1kFO9THj6hIGmDy6IleRNoD373rj/OH/hT18CPgJ8pu1/iN3F1H8vty9kdPVW1qTc2b602D0xmNkV0m7djbY7AxzYLJbp7+2bnqqODDbsp4pzUY2lK1SSKgdFWRyof9Bnv8rv8A58N8+P8A0V3x5/8AupfdkHwF/wCFD/8ALP8A5h2+sH1J1h2LvLqjufdBlj2p1L8g9q0Ow9zbrq4quvp/4TtrPYDcO9Ot83uCeno46mDGU+dkyNTBUp4oHkjqY6e8f3XR/M3/AJm/Qv8AKk6F2l8iPkRtLt3eWyt5du4HpfF4vpfA7N3FumDdO4tm7+3xRV9fRb43911iYsBFieuq2OWWOtlqFqJYFWBkaSSKjAf8LPf5XZ/5oP8APfj6/wDGLvj1x/r/APOUnvr/AKDPf5XfH/GB/nvzf/ml/wAefwbf95S+9r7Y+7cfv7ZWz99Ymmr6LFb12tt/duMo8rHSxZOkx+48TSZijpsjFRVdfRR18FNWKsywzzRCQEJI62Y1VfzTf51XxZ/lF13SOP8AkjsH5Ab2m76pOwqzZ79IbV663JFjY+tZtlw51dyHfnavWr0klW2+qQ0gpVrA4jm8hi0p5Klv+gz7+V3/AM+H+e/5/wCaX/Hj8f8Al0vsxXxp/wCFYX8pr5FdgUHXmZzXefxrrszkcXicFuT5Hdf7UwGx8pX5U1yIk+6+sux+1cZtejo56WKOorM4cXRRGribzFFneHZZilinijngkjmhmjSWGaJ1kilikUPHJHIhKPG6EEEEgg3HsqfzG+cXxa+AvU83dPyv7c2/1Rshq04jCnIR1+V3JvDcBppauLbeydo4OkyO5N15ySnhaRoaOmlFPArTztFAjyrr2VP/AAsh/lUwbsk27F1v81azDpnhiBv2m6k6nXacuPNd9od0pR1ffdLvkYFYL1JjbCrk/ALCk837XvYI+EXzl+On8wzoyi+RPxg3Vlt2dbVW5s/s2epzu189tDMYzc+2mpTlcTX4jP0VHP5IqbIU06SwmaneKoW0msOif//S3+PdRn83b5I9nfFLrvoLuDq3KGHJ43u6HD7i2xXu821N/bQymztySZvaG7cZ/mq3HZFKJDFKLT0c6rPAySqrBq+BfTP8uvvujz3yq+M3V9H1lnOx9vZzr/5C9P4PMV1DtGrrc6Kavrdrb/6wFTNst4cRVK1Vg67F0WPieGod0ClpIItdX+Zf8h/gn/L57G7C6O/lY9TbO2d8pM1jMvszvD5YYPPbj3nm+icFmwY9xdTdIbh3Rn9xLtvszL0zGDMZHFNAMBTO1PrfJf8AFt1rBtvPQ7ag3gcHmV2fWbir9rU+7ZqOr/geR3dR0UGay+Cgzc6mDJbho6DIRVdZGkkk0S1CPLYyLqtE2913uDeX8j3sbeuBoaqvoOkP5lOJ3fvkwUpmTE7Q3t0VgNgRZ+qnS5pqLH7oyGPp5CRp/wAsDMVC8nA/4T6fzGOivhB2n3X1r8jMvBsPYPyCg2VkcN2xWUU9Thtp7x2FDuKlpsDvCehgqK7Gbe3Lj9wv9vWmN6elroQs3jjmaaPcF21/NR/lx7uzMW38F80/jzNlJzphir+xsHg6eRi4jVFyOcnxuNMjubKvlu34B9nxoMhQZWho8pi62kyWNyNLBXY/I0FTDWUNdRVUSz01XR1dO8lPVUtRC6vHIjMjqQQSD7b9y52k2vtzP7lryoodu4TK52tLyLCgpMTQz19QWmYMsSiGnN2IIUc+/hfbB6t3r3XD3VuTBIcnkur+tMx3ZuuniplNRX7foN8bM27uarhSnWGnpRiYt7HJTmwRaWjlCrqKD3u3f8JFvnZt3pb4j/zJ9hdqZeqpuv8A4yYql+Y9N5Z9cNNtefY+4MX2lT0BlUrRzR/6MsM0MAYioqa5yieTyGTT67BTuL5u7r+cXza3dLU1FVgMsO+e1stJrrqCPPd3977W2Pt/ZtDVTVFO9BGlRvmokx0SRPHFj8I8KRRxqpj3J/8AhEJhoo8P/Mm3AXSSasyXxKw0aGnUS00WOpfkfWzMlUXLtHWvlEDRhVANOpJa4C75nv3v3v48X/ChTr3urYH84D5qy93Y7M0+T392dP2H13l8rDOKTc3SubpKag6myO36+RRT5TDYXaGHgwZeFnSlrcRUUbFZqaVE2tP5RX8oD/hPP/Me+DvXW5dldd7i3/35t/Yu0MT8jq3Kd+dzba7j2D21LjKWTdMmS2DhN+4vr6j2xls3T1gwddT4CXG1uO4SRqqKcQ7jvS3VW3+iuneqOkdp1+eyu1enettj9W7YyW6a6nye5q7buwNs4zamEqtw5OkocbTZHNTYzExNVTpTwrNMWfQt7exM9+9k1+an8vz4i/zENh7U6y+YnUzdv7H2Ru4b72xghv8A7P6/TG7rGGye31yzV/Vu9dk5SvZcPmKmEQ1M81OBKWEesKw0AP8AhU9/LH+Bn8t7G/B6H4adCv07ku6a75HS7+rR2f3D2FHnKLrWn6MTb1K0PavYW+Y8U9HUdgVbK1CtMZQ5ExfTFoF//hL5/KH+An8w/wCOPyW7L+ZXQUncOe2P3ZgdjbIyJ7S7o69iw2I/uLj8/lqFKXqvsfZFHkZKisy8UjSVkU8sYChHCkr73qfhd8CPib/Lz633H1H8PuqP9EPXu7d71nY24dv/AN+uyt//AMQ3lX4HAbZq8x/Fu0N471zlJ5cJtehg+3gqYqRfBrWISPIz60X/AAtMrTH8BPi3jxUKgqvmBQVn2mtA85oel+2IBUCI+t1pv4iVJHC+YX5I90X/APCdz4O/yjvkF8ffk93T/NWHT+Hwe2O5OtOrupt291fJvePxq23TZbKbJ3ZuzO7cxWXwnbnVOE3LnMvR0UdSKad6yrigoZHjCR+UtUp/Oi2J/Lf62+bec2l/K53K26Pjhj9h7WfM1NBuzce/tmY7tWordwz7mw/XO9911+Xzu69m0O3mw9quaurh/EXq40qJI41Pv6Tv/CcvrTt7qj+Th8Odq91Y/NYXdFTgOwd34PA7hWoTM4Xrvfna29959c09XFVKtTTQZDZ+cpK+lgclqaiq4YrJo8SXcyyxQRSTTSRwwwxvLLLK6xxRRRqXkkkkchUjRQSSSAAPfyO/52fzi3n/ADiP5oy7W6Jlrd8dZ4Hd+C+MHxI23jnL0u63ye5KTBVW8aBIpJqeWftjf9Y1XBVBUc4ZcfHKAacn2C385b+XHmv5RvzR2R0/tXc2ZyGKrOkei+3djdgRS1NPVVu8aXAU21+yc9iq5HSWhcd37FzmRoKe0U+OoKujjIIWOWX6qf8ALc+WmL+c3wW+MXynx89FJkO1+qtv5DelLQTx1FNiOzcGkm1u0cDHIixkpg+wsJkqVNSRu0cSsUW9gd338f3/AIUfZT+L/wA67521StE4i3n1li7w6ggbCdC9U4ZlIdnJmRqC0luDICQALD3ux/FL/hND/J+7f+EPxh3Xv/4vZ+l7b7I+MXRW6999kYX5Ad/Uu4p9/wC5+sdp53d25aTDP2fketaOtymeq6iVqeDCfwuLylaemjjEar8+v+ZV8Pc5/LO/mCd5/F7A703BlX6O3vtrM9bdhqf4Duir2zubbW2uzut9w/e4WWGOk3TisJuOiSpqaJolTJ0srRLCVEafW/8A5XXyU3B8v/5eXw/+R+8Joqne3aHR2zclvytp4hBT5Hf+GpG2vvvJ01MpIpabJ7uwdbURw3bxJIEudNzrw/8AC0nJ+H+Xp8ZMR+a75m4HJf563GK6Q7qpT/k1v3f+Lz+u48f0518akH8kmP8AkrHd/wAgZP5ytQV2om29gRdD0nj+V7ebcEuT3Q2+p/P8Vj/EovtcbDjVKZn9h/Len9Sy+9n745/HX/hGh8s+6dh/Hj4+bNbsDuLs3IV+L2Rs9c9/NT2uc1XYzC5PcNfF/Ht55rbu2MYtPhsPUzmSrraeMiIqGLlVO67gcHi9s4PDbbwdL9lhdvYnHYPEUXnqKn7TF4mjhoMfS/c1k1RV1H29JTomuWR5HtdmLEk/P/8A+FuVYX7I/l34/wA6v9tsj5I1gpQ6l4TXZ7pmE1DRg61Wq/hoUMeCYTblT7Dv+SJ8Af5FHYP8uLbHyB/mmTdDbZ7V3/3H3XjNl5zub5d9g/Hmv3JsfrePZ9BPjNobTwneHW2M3Z/d/I5J2qJaGgqqvyV8UUjsWhQauv8AMD2j8U8T84O99lfy/cnuTfHxdpd+Y/AdH11e+YzeXz0bYTBUmbpcJU5GnGez+FbfzZKnwlRMjVVdjFppWLvIWb7Cv8uTYXaPVnwB+FfW3dkeRg7b2H8W+i9pdh0OYmapzGK3Xgettu43LYTM1Llnqsxg6inNHVSlpDJUQOxdydbaUP8Awtd687pfub4X9r1WPzNX8dabrHefXmDy0UM8+3tvd1Vu6qncm6sfkKiNHpsVmd5bGx+Hko0lKSZCDBVRhDijn0Fl/wCE1nwv/knfOja3YHTXzZ2rV77+bD72yWT2DsTd3b3afVu39zdUU2Bw0tI3Va9Yb32DHurdeNysWTkzNBWVFZXx0giqKeL7ZKh4t+n4Ffy+/jz/AC3Opd1dG/GKl3piesN0dm5rtVNt7y3bVbzO3Nwbg23tLbOVoNvZbJ065qLA1EOzoKrwVdRWSLWT1DrKEdY0/9Pf49kM/mJfC6D5wdBTdcUW5X2nvja2bi3x11lalpH27Luqgx1fjo8Tu2lgimqZMBmKDIzQPPADUUUrR1CLMInpp64P5IXWu+OmsF83+rezNuV2zextl732Tjdy7dyBRa+gkbZ+5J8dVQ1NNLLBXYnKUripx9bTySU1ZTSLPBI8bqx1OP5Y/wDK67b/AJkvcmXxmHbI7G+O+w96V8Hdnc4jXy0JfJVFfUbC2C1ZHURZzs7NUU6szuslPiIJxVVepmggqLeP+FIfQvU3xg6E/lw9DdIbUx+x+tdgZTvehwG3qFpJHJlw/Xc+RzWVrZ2erzGezWQmkqa6tqHkqKqpleR2JY+zT/8ACZfYOze0/gj8wOtuxNu4zd+xN9955rae79sZmH7jGZ7b2c6q2lj8rjK2JWR/DV0lQy6kZZEJDIysAQRT5i/8JkfknsPeOUy3wn3LtnurqjI1NRPhNh9jbqx+yu09m0zuXiwdRuPLw02zd64+kRvHDXST46rZFtNC7DyvWh3D/JH/AJmnSfXm4uzd/wDxcar2ZtShqMruR9j7+647HzeLw9HTzVmRzMu1Np7gyedq8Zi6SneWpkggmMMalium59mP/kg/zTOxPh133110BvvduQ3F8R+693YrZdZt7NVs+Qpund5burYcbtnf+yJ6mR5cNt+qztVBT5zHRkUklNO1WkQqIBr3mvndvim6x+EHzH7Iq5TDTbA+K/yD3nPKIhOyx7Y6l3bmmKQEMKiQ/ZWWOx1tZbG9vfzV/wDhLp8acV8rPk/87undxUkVRt7sP+WJ8i+raiWVgrUmV7T3x05tDF1cExH+S1NFDV1NRDOCGhmgRl5FxQ/1d3x2x8bsJ8nesttSVe3ZPkF1FVfHPtTH1gnp67H7dou3Otex81R/ZSLpiy8uR6uGJnaRNcdDkKyNSvka+wF1x8Uv9CX/AAlm+Tvybz+MjpN0/Mj5Z9JU2ArJIEp6ufqTpXsaTa+2o9csa1Eq1PYMW6Z9AIieEQSi9r+7r/8AhEvRTJ0N88skzReCr7d6aoY0Ut5Vmx+zd5VE7OunQInTKR6CGJJDXAABO7Huvde19ibX3JvjfG5MBs3ZWzcBmN17v3fuvMY7bu19qbX27jqnL7g3JuTcGXqaPE4LAYLE0c1VWVlVNFT0tPE8kjqiswLn1L87vg/37vGn666J+ZXxU7q7Bq6GvylJsXqX5D9Rdj7xqcbi4hPk8jT7Y2du/M5uahx0J1zzLAY4V5cgezV+6rfnZ8Bfgn/Oe+O/9z96ZvZW/wBMZTT13UfyG6c3HtLdO7urc3nKCiyNPk9q7sxE+XxuR2/nqQUk1fiKiR6DLUgichJUpqmH5VH99O/v5PX8wnebfHbvzbGZ7Q+M3Zmc2dR9pdX5UZvrbs/A0NZD/EMPmselTJR57aW56BUgzGGqZJlp6pJIRKZ6aOcfYh+Inez/ACh+Kfxr+Scm322pL370R1P3HNtgzmqXb8/ZGxsHu6fDw1Zs1XTY6XLNFFMQrSxqrkAmwmd4fKz4u/GP+7H+zJfJLoP49/32/jf9zP8ATh3D151P/e7+7X8J/vH/AHY/v7uLAfx/+Afx+g+9+08v2v3sHl0+aPUreou7emPkBs+LsPobt3rDu3YE2RrsRDvnqLf21Oydny5bGNGmSxcW5tm5bNYWTI49pUE8AnMsJYa1Fx7E/wB/Pp/4W45wVHZX8u/bQdS+J2P8ks4Yxr1ou4c701QCQ/uMmmQ7YIFkBupuTwFsX/4Rd4pYf5bnyMzgCasj83t54osHkMpXDdD/AB9rFDxkCFUBzp0svqYlg3Cr72//AHpRf8LXc3FT/Ff4U7cL2nyvyB33m4o/Td4tv9c/YTNYqXIR9zRjggDVzfi1UP8AKB+Fn+zxf8J8P5r3WGJx0uQ7B233hhe4+pxHEklQ3YfSvVO3t6UOKxeqGUDI7uwDZHAE/UR5Y2KE6vdcf/CbnOfFOD+al0xsP5bdRdc9q7U7hxuZ646wn7PwtFuLbmxe9a6pxW4er9wJgsxUtgq/LZ7MbebbtAKijrXjyObp2iWNgZV+uv71m/8AhUP/ADMP9ke+CVd0d1zuSXEfIj5kU+e612tNi6kxZjZ/UtNDRwdwb5SanqIarF1NVh8tDgcbOpSYVeWeop2L0MhX59H8uX+XJ/NC+X2Szfef8uTrPsDJ5vorc2Jx1T2xsLunr7ofP7J3dnMXX1NDBtXeW9OzOtMtNm1w6yNUnDVE81HT1EX3BiWqh8o8/wAyv+Xf/PG6i6zwPyP/AJnWF763h19tXNUHXW3uwu5Plfsb5L1e0slvJqyvpcNQU+J7t7T3PtjEZqqwzeScU9Pj2qhDHJIJpYFfZe/4RgfNb+ObC+SXwD3Xl2kyOx8lD8juoKKrq43lO09yzYrZ3auHxsEhWaHHYLdCYSvEaakNRnamQhSSX3pPfxuP59uXgzv84n+YBWwSNIkPfOSwzFnL/vbd2/t/b9SgY/2YqnGMoW3pC2+g9/WR6u7G6s+O3wy6P3d2/wBg7O6s6+2R0B1bDl939gbgxGz9v4ykwnWeJnmNXkMxU0VFDNHQYyWTwq2srE2lTpPv5Gn84n5g7c/mBfzL/k/8letoMjVbC39vbAbW6wSejngr8zsvrfZ22OrNqZlMW6fe0s28aLaKZVaWRRPE9f42VXUqPq9/yo/jrur4nfy4fhr8fd90S4vffXnRe0IN84hVlU4Xeu4YJd3btwkvm9b1OF3Dn6mllawDyQsygAgDWn/4WvZuGD4r/CnbjPafK/IHfebjj9HqiwHXP2Ez8jXaN9yxjggerm/FqQv+E7v8jf4tfzbOuPk1vj5I7/8AkNsmTp3e3Xe1dnR9Jbp6423RZBNzYHcuXzzZ/wDv31V2TNW1VK1BR+A0zUaokj6xKWUptz/Bn/hMR8BvgB8qOqfl10/2v8ut19j9Pz7uqds4HtDf/TuX2NWTby2DurryvfOY3aPQuyNwVX2WJ3fUVFMIMnTBayKJpfLCJIZNjT386v8A4WwZuKf5N/CHbqteoxPRHY+blj9Hph3B2BQ0ED/QONb7akHJI9PFubgxF8LP9mQ/4SU9c9zYDGy1W/8A4i/I3uvu/HyRxq1VVdc5TsSv2D2vjIHaBmXGU2Jmos9UlWU/7979VhoKa/4SA5z4pV/zx7D6v7w6j643b3luHYVB2J8Veyd64aizmb2TvHqqfK5De+39hJlamopcVu3N7QzTZqCupKJa+npdtVRFTGLI/wBOD2WzuXaPxW+We2e0PiV3IOpO5cVlMfHhe0ek8xndv5vP4pZ8Xgt042fMbbpcgdy7UzdDjc9isvjq1Upa2jFVR1tNJGXglPynf54/8s3bX8of5r4HZPRHef8Ae3Z+6sXS9t9X08W5Yoe8OkpaHMpJi8HvqowBoaiiylBWxRVeAzcS0UtfTL5BFHNA7yb/AF/wm7/mH9y/zGf5d0W+/kDN/HO2+ke2NwfH7dHYPhhp5uzods7O2HvLA7yy8EASGLdEuB33T0eUZEVaqrpGq7K1S0af/9Tf49+9stVt7D1X8bk+xp6Wt3DjlxeXytBFHRZeto4YKqnpI5snAiVkhx8dbL9uWc+AyMUtc3D3ovojqX409W7V6Y6P2Rhuvut9m0bUmE27hYWWMSTyvUV+TyNZO81dmM5l62R6itrqqSaqq6iRpJZGdifeq7/wrCUfwL4Lv6gf7z98L9WKW/gXXJ/RfTqv+frb2J3/AAl53ps3afxK+RS7q3ftXbUlZ8k5mpYc/uLDYeonjTrfZgMsVNkK2nnaBmBCyadDlGAJKMF2Z/8ATN0+fp2t1qf/ACetr/8A109oXsz5Y/Gbp3Y24OyOye9+qtrbM2xQz1+XzFZvbAT6I4InlFLQ0FDXVWSy+VqtGino6SGerqZSEijdyFPy3MHLRdn/ACx23VdZ7Rq8bi+yPldtrJ9d7EpImmrsfit1d14/Jba21T06KGaopcfVxx+MC6FdNuPf02f5iXQfZnyo+DXyo+NvTuZ2jt/sjvTpfefVm2czv3JZrD7OoJd6Y5sFkpdwZLbu3d2Zumx7YasqFY02OqpGZgukAlloG/4Tz/yIPlj/ACme9u/u1Pkd2B8cN64vtHqXC9fbXi6U3d2buPM4+vo940W48hJmYd9dRdb0VNjKimoYwrwT1MplQAxqvq91IfNn/hIf86e6/mB8mu5+h+4vhtt/qDt7vHsvtLYO3d+b67owO69t4LsLdeT3dFtzK4nbPx73XgqP+79RmZKOAU+Rq1amgjZn1lgNiD+ZX/J27O+RX8n7oz+WX8Sdz9SbTyvTtT0JjTuLt/L7t23tbK4DqbbGUoNwZY1uy9idgZlt07o3NPFXuGoEileeod5UbSrwP+E8P8pD5H/ylOovkbsH5G716R3rme3+x9n7w21U9J7j33uPGUOM2/titwtZBnJt9dbdb1VNXy1VSGiWnhqY2jBLOrek25fPLozenyd+FHyw+OPXVftfFb773+PfbXUW08pvWty2N2ljc72FsnM7Vx9fuKvwWG3FmaTE0k+UEkz01BVzKinTE59J1bf5FX/Ccv5p/wAsj52Unyg+QHZ/xZ3fsWi6i7E2LBien969sZ/dy7g3e+CTH1f2G9ej9hYcYuGloKhZpBkBOpdAsbgtbdE9/PE+UX/CM75Xbh7L33vP46/K343Z/A7x7D3ZuWhwHbOF7M6qn27t3P5StzGPx6VWyts9zU+Tr8W9YKQqIqSKSOITBlLeBRF+Gn/CLzeGP33tvc/z1+TfX+W2NhcqtfnOqPjZDvLJT71pKKspJqXC1fam+9vbAyG2cXl4Eljr2o8DLWrEdFNUwystTDvubb25gdnbdwG0dq4jH7f2xtbC4rbm3MDiqaOjxeEwODoYMZh8RjaOFVhpMfjcfSxwwxoAscaBQLD3rL/8KK/5Kvyu/m6Z74mV/wAb9+/HrZFB0JiO6KTdX+m7dfZG3KzJ1nZdZ1hNijt+PYnVHZUFVTUUGxJ/uDUvSOrypoEgLFLDv5IPwC7a/lo/APZXxY7v3F1tursbA7/7M3dmM11Pl9y5zZdRTby3LNlMTHRZHd2zdh52Wrp8YIkqBLj0VJVIR3QA+7dPepr/AMKF/wCRb8zv5tXfnQvYfx57I+NezNi9R9QZTZmQoO6t7dpbez9Vu3ObzymbydZi8bsfprsbFPhzho8egnlrIah50dTCEjR5LDf5BH8tDur+VV8Kt4fHPvvcvUm7N+7o+Q+9+4GzHTOc3huDasmG3JsTq/aOOhrK/e2xevcuM7A2w5BLGtA0CweErM7F1S733rJf8KLP5Nny4/m6v8Scf8bt/wDx82Ngug07trN3x92bt7I23VZrL9mHqqHBvgodidT9kwVVPiKPYVWJWqJKRlarAVZASUHn/hPf/Kw+Qf8AKd+Mfc/S/wAit49N703T2L3vUdoYSv6V3DvbceApNvzdfbJ2otHlKrfXXvXORgzAyO253McNLPD4XjPl1FkXWg7s/wCEgn8wWP5R9n9r/Frvz4f7F63/ANN26Oxug13F2F3htbsHYm2n3pV7o68o8hSbX+Pe5sLi9ybNpGpoRJRZCohM1KJY2UEIv0FOqV7MTrDrtO6Rs8dwR7I2tH2meva7K5PYb9hx4SiTeUuy6/OYTbWaq9rS7hWoagerx9HUGlKeSGN7qNKX+b7/AMJ3/wCbV/NG+bvZHyUq+7vhPt7raOOj2F0PsLcXbXfkuR2P1BteSqGAosjT474xVuMotxbmyNZWZ3Lw09RVwQZTKTwxVNRBFFIdmr+UV/L7x38sz4IdP/FuSr2/muwMVDkt6917s2vLX1OC3b3DvGaKs3bk8PW5TFYHKZDA4iCnpMNi6iqoaOqlxOLpWmgjlLqF7/M7+HTfPv4F/Jj4m0U22aLdHbHXdTS9e5beMmRpts4TtDbWQx+7+tMxna7D43M5nG4ah3vgKFqyopKOsqI6TylKef8AzMmpl/Kf/wCE13807+W988+iPldN3d8KsxsvZmayGC7Y2vtXtDveTObr6o3li6vbu9cTjKHLfGnE4jJ5ijoa5cjjaerq6WnfKUFMXnhA8qb3/v55nzf/AOEnf8y/5S/Mr5WfJHAd4fCOh213t8iO5O19qY3c3Y3etFuLE7R312Bn9xbTxGdo8R8a8vi6bMYfblfS01QlPV1cSyxMFnmAEjFhg/4RgfzPWqIVqe/fgbBStNGKiWn7K+QdRPFTlwJZIaeT4xUsdRMkZJVGljDMANag3F9n8rP/AISgdE/CzuLbHyM+UnbsHyp7L6+zMe4Os9iY/ZQ2l09tPcePnSbCbvzuPy+V3Bm9/bkwlRClXj1mOPx9DVWd6arlihmTbl96yn/Civ8Ak2fLb+bofiPQfG3sH4+7GwvQf+nCr3jF3bursbbdRmcp2Z/oohwEmATYnVPZUVXDiqTYdYJjUNRMjVS6RKGPj1lP+gML+aH/AM/4+A/0t/zND5Dfj/X+LVhz7Fbof/hHv/Mk627y6Z7F3b3b8GchtXYXa/XW9dzUGG7I78rMxW7f2ru/D5zM0mJpK741YqhqsnUY6hlSCOaqponlZVeWNSXX6QHvT3/4UAfyBfnB/Nf+YvXnfPQvZ3xc2Z1xsL477T6igwvcG9+2cDuqfcmK7B7P3nm8wuP2X0n2Dhxjaun3vSQRP9+JWNIdUSWBe3T+VT/LS3p8RP5U+L/l5fKXLddb6yeWxHyC2j2LV9VZXcWd2Tltn937o3tVVFBjchvPZ2y8xPOdr7s8FQs+LjjWfWqmVAHbVB+NX/CUb+bl8R/kx1D8k+n/AJE/BKTdHR/aO3+wNpy5Ds35DYV8/SbdzCVE2E3BSUHxoyq0mN3fgxLj8nSx1FShpKuaHySqdTfRPiMpijMyRxzGNDLHFI00SSlQZEjleKBpY1a4DFELDnSPp70/P523/CZ7t3+ZV8s93fL/AKM+R/Vmw9x7q672Xtqr617P2juqgxVRuPYuJh29Q5CfsLaT7qrYqDLYenhWRv4BNLSGnCqs6veOoXp//hFd80spuqnh7++WHxe2JshJ6F6vJdPJ2v2vuqop/vIxk4KbC70686YxNHOtBqaCVshOpmsHjC3Pve5+BXwa6O/l0/GPYXxY6AoMnHsvZgr8lk9w7iqKeu3dvzeWdnFZuffO78hS01FTVWdzlWFGmGGGmpKSGClp446enijX/9Xf49+9+9+96tH/AApk+OPyJ+QmF+G0HQPQ/bXd021Nxd0VG6o+rdk5feLbbp8ththQ4qXNrioZTj0yctHMsBksJGhcDlfeqNL/AC0v5iE5Bl+BHy0kKgqCek94gBb/AEAFGB7xf8Nl/wAwsc/7IL8tP/RJ7y/+pPrb3Ox38r7+Ynka2CmpfgP8pUqXdTDJkuo89iqVHvYM1fl0pKClN2/U8i2F+QAfe1N/Jh/kSbr+NXYGF+W/zQp9uy9wbbimn6a6Zw2Sp9y4vq3JV1NNRVW+t7ZulVsNnOwoqGeSHG01E9RQYhJWnE01YYzSbUPv3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v/9bf49+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9/wD/2Q==", alignment: 'center',width: 220},
									
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
