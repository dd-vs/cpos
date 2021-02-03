<?php 
include("../include/include.php"); 
		check_session();
		 html_head();
	 navbar_user(10); 
	   ?>
	      <form  action="../add/cash_booksave.php" method="post">
        <h2 style="margin-top:0;">Cash Book</h2>
        <div class="report-head">
            <div class="form-container h-padding-50" style="padding: 4% 12% 4% 8%;" id="invoice">
	           <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon" >
                            <span>Date</span>
                        </span>
                        <input class="form-control" type="text" name="date"  id="AdmtxtDate" value="" required onblur="showDate(this)" tabindex="1" />
                        <div class="form-control print-only" id="datePrint"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>Cash Flow <i class="fa fa-exchange" aria-hidden="true"></i> </span>
                        </span>
                        <select class="form-control" name="inword" id="flowDirect" tabindex="2" onblur="showDate1(this)">
                            <option> SELECT </option>
                            <option value="0">  IN </option>
                            <option value="1"> OUT </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>Payment Mode</span>
                        </span>
                        <select class="form-control" id="selectmode" name="selectmode" tabindex="3"  onclick=" $('#tranModPrint').text($('#selectmode option:selected').text());">
                            
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon" >
                            <span>Party Type</span>
                        </span>
                        <select class="form-control" id="select" name="select" tabindex="4" onclick="$('#vocTypePrint').text($('#select option:selected').text());">

                        </select>
                    </div>
                </div> 
            </div>
    
             <div class="row">
                  <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span> Name</span>
                        </span>
                        <input type="text" name="supplier" id="supplier" class="purchase box form-control " onblur="showDate2(this)" style="display:none;"  tabindex="5"/>
                        <input type="hidden" name="sup_id" id="sup_id"/>
                        <input type="text" name="customer" id="customer" class="sales box form-control"  onblur="showDate2c(this)" style="display:none;" tabindex="5" />
                        <input type="hidden" name="cust_id" id="cust_id" />
                    </div>
                </div>
            </div>
           
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span> Amount</span>
                        </span>
                        <input type="number" id="amount" name="amt" class="form-control"  tabindex="6" onblur="showDate1(this)">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span> Reference</span>
                        </span>
                        <input type="text" id="reference" name="reference" class="form-control" onblur="showDate3(this)"tabindex="7">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span> Opening Balance</span>
                        </span>
                        <input type="text" id="open" class="form-control" tabindex="6" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span>Balance Due</span>
                        </span>
                        <input type="text" id="opendiff"  class="form-control" tabindex="7">
                    </div>
                </div>
            </div>
                <div class="margin-top-10 -txt-">
                     <button class="btn btn-success" tabindex="8" onclick="clickfun1();">SAVE</button>
                    <button class="btn btn-success" onclick="clickfun();">print</button>
                </div>
        </div>
    </div>
</form>
 
   <script src="libs/pdfmake.min.js"></script>
        <script src="libs/vfs_fonts.js"></script>             
<div class="no-screen">
    <div id="vocTypePrint"></div>
    <div id="tranDatePrint"></div>
    <div id="tranModPrint"></div>
    <div id="partyNamePrint"></div> <div id="nettAmtPrint"></div>
    <div id="amtPrint"></div>
    <div id="remarkPrint"></div>  <div id="custbaln"></div>  <div id="diff"></div>    
    
    
    
    
    </div>



<!--

             <div class="col-md-4 -txt-">
                                    <input type="submit" name="submit" value="save" >
                                </div>
-->
                                
              
 <?php
    html_close();
  
    
     ?>
<!--
 <link rel="stylesheet" href="js/jquery-ui.css">
      <script src="js/jquery-ui.js"></script> 
-->
<script>
	$(document).ready(function() {
                      //option A
                      $("form").submit(function(e){
                              //alert('submit intercepted');
                              e.preventDefault(e);
                      });
              });
	function clickfun(){
		 if(($("#AdmtxtDate").val() == "")&&($("#amount").val() == ""))
		 {
		alert("please fill the fields");
							
						  }	
						  else {
						setTimeout(function(){   $('form').unbind('submit').submit();   }, 2000); 
				
							  printInv().print();	
						//~ var k="submit";
						//~ $('#formsave1').val(k);	
						//~ $('form').unbind('submit').submit(); 
								  
							} 
  

  }
    function clickfun1(){
		if(($("#AdmtxtDate").val() == "")&&($("#amount").val() == ""))
		 {
		alert("please fill the fields");
							
						  }	
						  else {
						
		$('form').unbind('submit').submit(); 
	}						  
							 
  

  }
	  <?php  if(isset($_SESSION['i']) && $_SESSION['i'] !='') { ?>
  notify("success","Succesfully saved");
    <?php  unset($_SESSION['i']);  } ?>
		$.ajax({
		url:"../ajax/modeajax.php",
		method:"post",
	}).done(function(data){
		$("#selectmode").html(data);
	});
	function showDate(input){
$('#tranDatePrint').html(input.value);

}
	function showDate1(input){
$('#amtPrint').html(input.value);

$("#nettAmtPrint").html(input.value);

}

	function showDate2(input){
		
		var a2=$("#sup_id").val();
		
		 $.ajax({
		url:"../get/post.php?s=sustbal",
		method:"post",
		 data:{a4:a2}
		}).done(function(data){
		
				$('#custbaln').html(data);
				
				 $('#open').val(data);
				 });
				
				
				
$('#partyNamePrint').html(input.value);
}
	function showDate2c(input){
		
	var a2=$("#cust_id").val();
		
		  $.ajax({
		url:"../get/post.php?c=custbal",
		method:"post",
		 data:{a4:a2}
		}).done(function(data){
			
				$('#custbaln').html(data);
				 $('#open').val(data);
				 });	 
		
	 
$('#partyNamePrint').html(input.value);
}
 
 $("#amount").blur(function(){
	 
	 var am= document.getElementById("amtPrint").innerHTML;
	
				var s= document.getElementById("custbaln").innerHTML;
				
				
				
				var difference=parseFloat(s)-parseFloat(am);
			$('#opendiff').val(difference);
				$('#diff').html(difference);
 });
	function showDate3(input){
$('#remarkPrint').html(input.value);
}
	
//$("#toggelon").click(function(){
//			if (document.getElementById("customer-on").style.display == "none")
//			{
//			
//			
//			document.getElementById("inward").value="1";
//			document.getElementById("customer-on").style.display="inline-block";
//			document.getElementById("ticust").style.display="inline-block";
//			document.getElementById("tisup").style.display="none";
//			document.getElementById("customer-off").style.display="none";
//		}
//		else
//		{
//		
//			document.getElementById("inward").value="0";
//			document.getElementById("tisup").style.display="inline-block";
//			document.getElementById("ticust").style.display="none";
//			document.getElementById("customer-on").style.display="none";
//			document.getElementById("customer-off").style.display="inline-block";
//		}
//	});
  $(function(){
      
      $("#flowDirect").change(function(){
            if ($("#flowDirect").val() == 0){
                $("#select").html('<option id="ticust" style=""  value="sales">Customer</option>')

            } else if($("#flowDirect").val() == 1){
                $("#select").html('<option id="tisup" value="purchase">Supplier</option>')

            }
          if($("#select").val() == "sales"){
             $("#customer").show();
              $("#supplier").hide();
          } else if($("#select").val() == "purchase"){
               $("#customer").hide();
              $("#supplier").show();
          }
        }); 
      
      $("#customer").autocomplete({
        minLength:2,
        source: "../get/search.php?q=getitem",
        select: function (e, ui) {
        var i=ui.item.id;
        document.getElementById('cust_id').value=i;
        }
        });
      
      $("#supplier").autocomplete({
		minLength:2,
			source: "../get/search.php?p=get",
			select: function (e, ui) {
				var i=ui.item.id;
				document.getElementById('sup_id').value=i;
			}
		});
      
      
  });  
   
    
    
//	function changeVal(src, desti){
//					 var value =  document.getElementById(src).value;
//					 document.getElementById(desti).innerHTML=value;
//					 
//				 }
    
     var picker = new Pikaday(
    {
        field: document.getElementById('AdmtxtDate'),
        firstDay: 1,
        minDate: new Date(2016,01,01),
        maxDate: new Date(2020, 12, 31),
        yearRange: [2016,2030],
        format: 'DD/MM/YYYY',
    });
//    document.getElementById("AdmtxtDate").value = moment(new Date()).format('DD/MM/YYYY');
//    $(document).ready(function(){
////    $("select").change(function(){
////        $(this).find("option:selected").each(function(){
////            var optionValue = $(this).attr("value");
////            if(optionValue){
////                $(".box").not("." + optionValue).hide();
////                $("." + optionValue).show();
////            } else{
////                $(".box").hide();
////            }
////        });
////    }).change();
//});
function printInv(){
        return pdfMake.createPdf({
                        // a string or { width: number, height: number }
                          pageSize: {width: 585, height: 830},

                        // by default we use portrait, you can change it to landscape if you wish
                          pageOrientation: 'portrait',

                        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
                          pageMargins: [ 43, 40, 22, 120 ],
                        //background layer
                        //background:{  image: "data:image/jpeg;base64,/9j/4AAQSkZJRgABAgAAZABkAAD/7AARRHVja3kAAQAEAAAAMgAA/+4AIUFkb2JlAGTAAAAAAQMAEAMDBgkAAA9vAAAWRAAAJMz/2wCEAAgGBgYGBggGBggMCAcIDA4KCAgKDhANDQ4NDRARDA4NDQ4MEQ8SExQTEg8YGBoaGBgjIiIiIycnJycnJycnJycBCQgICQoJCwkJCw4LDQsOEQ4ODg4REw0NDg0NExgRDw8PDxEYFhcUFBQXFhoaGBgaGiEhICEhJycnJycnJycnJ//CABEIAWIBoAMBIgACEQEDEQH/xADAAAEAAwEBAQEAAAAAAAAAAAAAAQQFAwIGBwEBAAAAAAAAAAAAAAAAAAAAABAAAgIBBAEEAwEBAQEBAAAAAQIAAwQQIBESEzAhMxRAMSIyI1CQYBEAAQIEBAUEAQMEAwAAAAAAAQARECExAiBBURJhcYGRMjBAIgMTULHR8MFSYmChQhIBAAAAAAAAAAAAAAAAAAAAkBMBAAECBAUDBQEBAQEAAAAAAREAIRAxQVEgYXGBkaGxwTBA0eHx8FCQYP/aAAwDAQACEQMRAAAA/fwAAAAAAAAAAefWLtACncxjZAAAAVLYAAAAAAAAAAAAAM40a9jDNwAAGNs5WidOHfgdse5UNgxTZnE2D3GdQPoWdeMfbyNEzNnK1QAAAAAAAAAAABl6ng41+GqcLWRrjx74HrrjdRep3TrTrejrN0KM8Cna73zKr7ooebXEc9HIL1kAAADh7OgAAAAAByJoxBOnj+jlt1LZSugcKxfZHI2OeWNNljVnKg2PeLBvMLobLL7l1w7EgAinV6nC3Xrm8UCjt0rR4sYm2AAAAKV2CtaxfRd4dboAipQL1LwIJCOpyXu5letn2Ys7Ix/O0MON2DDjY5GZ6t8DpZzRuTh2i1Y5dSKtsZHjaDE0a5e6RmGoz75II5dKRf4deR05UtIzNYBxPeXz8iAmJ9Hizcslex5pF6vm+C7x4+xHT0cfXvwe+1KDUsYcm6yrh3r2hmVtyDDs2qZpdMK8X0SecrXGd5tUzQmhpjxz5luMq6ZXadcp9e4Hg8ZM+REiJiyRqSJp16xPnppFG37zzS95Ggd45ZptsfRO3HvwK1TaGE0KB10ckbrO0CQcqOmMjU80zRePYAAzdLOPHrpeIkAGVcyiYAmTpr+OhGV7qjr52BV95YOxep6WKWrGbtmG68jT74usZ97pkG7xr3jE8bOQebHAbfrI1iQAefQAAAAADiZvFIiYGhS2ialnGPExZLveRj+doYujZFXP2hi6NkVM/bGJ72AoX4MPQo+Tdq++5grVUW6g3lO4AAAAAAAM/QxziBMC7o17BRoe/BGtmbZ4ybdA6OcGnb5DMjmOnrjBvU7HkzHKTrrYeieaG1inXYwtM64+9kHGJE7OJdNEAAAAAAEYezikxMEno2uXakZxJZ1KN0yeEwT682DVq2qJQgANWzSumH578Ce/AbuPr55T68RvUbPkyQJgbfqpbAAAAAAOOPr5BMBPXl2NfN0ssqpg1OkeTKlAu09Au52jmFQAku6GbpGbTv0SJQbPDoMqA0refomC9+SAWtTF2gAAAAADjj7eIAO/DsbGVq5hVINjtx7EJESAEJEJACJEJDj25GMSWdTK1TH42K5KJI3MPZOoAAAAAGHuZJwiYHryN7PvVzMINb3x6FVSkuWsm6aFS3mkqcF1Sk07WdoletNEuqUmxDwZUoLWpn6Bk8OvIhME6+PsHYAAAAACje5mKCYDV7UtAwneuX7uXrGFHXkLdTsbGfoUzNkCBfv1LZl1evMI7GvTu5hUJNK34gx/KQQNrG3CQAAAAAAZdXYyCJQdNrC1CMvexznt4ekcqOxjiYG5y8WDEiQBrdPVQzkBfobJ1xdXGFivqFqldyDgmCYDrs5mmAAAAAAAM3Sgw468h34SbvHlbMLrbzjer+bRWcRa60Lhyj1XO3qvZO3Kah2cZO/d4KVH1B12OHc449jgRMSRMezSsxIAAAAAAAByydviY735J18f2bWdc6mJs0uJ2obuYVblQa2Ts5Rz2M3SKNSYGjy0hldaJN7npin2yTymBIRo09gkAAAAADl1FS3WoGwq2gDnl7EGHF+iTpZg3eGfcItx6M+lu8zOsxYONTR4GdetVi5nV4PNztcHLxlk+AEkTGkde4AAAAAAAOfQZHjapnm3j+TdZdkt+J9GfU24MKdSsVO/jmXOmdJpec4XuPDqcl+2UL/uoWqFXmTAAJnTOd0AAAAAAAAAAIpXhi+N2sZfbpWLvbLg2/eD7NuMn2X/ADUkteqfk0pyuJrVs8dOchCSE9zhZu9zx7AAAAAAAAAAAAABEivwvjJ47gwW14MhpeShF7yVFuSkvezPavUybV8cuoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAf//aAAgBAgABBQH/AOK3/9oACAEDAAEFAf8A4rf/2gAIAQEAAQUB/G5G228VN/5x/nL2Zfy+hZetb/nLcjtuyf5v0sV2A/WX8mnPOvI1+TKikvk/lNkMtsf/AI5G7MErPKS7nx4zs6ZfyRy11zo2MVPZcsPx1Tx4tjvGPVcQcta3WvDX8vLT2ofvXlpyuO3arRmCLW4sWZjDiocVzIsC14qla7qDa0txw7Wh1IGWgJynD471ivIp4vuTx4q9a8tuFoXrV+U6h1xW6WOvZcU9X0uTyV1XmkHJd5XjsWscVr9mx4mMzHSx7wxOW8qx+h1ampoMWoGXBnv9C20VBHVx6zOqRstZVkWWWS3j7E8H/bXgGewhsQQ3VTz1iedJ5655q55a52U+mSBHyawobKcU39zo5ORcqhQ1yI3qWd+iYvMvK1j61yTx5VkqoSvY1qLDkGG1z6XJgscQXvBkCC6s7st+WOIvRbnoiP2yJlWdVxauq2OK1oQ3Wek+SiFMitzLb1rlNTM2pIEbIEZ2b0ODOjzxvPHZOjzqdoJEF7iLepgIOhpQvpbjpZO2RREre+yWub7EQIvpcAzJrWsj7birHVNj3gRmLbgjtBjmCisQIo38Aw1VmHHSHHMNTjUEiLkMItivuyCVqxEHWNlElcoc/vUkKFtRlltq1BGDrbaKglb3vqzBA9rPuSlmi0oun6jXIIcgw3WGd3nZp2aeR4LrIMgwXoYGB1Kgw0IY1DiEEaJeyxXV9hAYGu3HPnSyvD68PWtgRAi6Nx1VReg6y5VavDJn8sdbLAgZix2KpcpSq6FgobIhZm1COZ4bJ4bJ4bJ43G1bnWLcjbCAY1CGNS6z9RL5+9j0VvDiuhF16HTsvaEcjl8az/tkzhqgtSo2llgQEljsrrLxVCiPeBCS2i0u0FCCc1JFZWjMqwOp2GpDGx4ysuqWMkS1X2tWrxqGESxqyrBxuts8alVEryzyb6gtatfZsZgoZix2VV9yBxCQBZaW0VGcpUqR7VSNY7RF7tYRXWvFtbKUK2usS1X0a1VIIMIBj0T9a138bmRXnR6irBxuyT2fJWtVTEXj9bbn7tsrTuQAATwLLC5ldZcqoUW28a0p1W5uz0Nw16dl0qt7R0Dj+6mruDaPWHjKVOldpSAgjaABvvqsZ6qCG23P1XYASUUIsus7GIpcqoUW2dBpWvd2PVZ+oD2Fi9G0qs7ixO6/qVXaOgcEFTpXYUIPP4djd32UJpe/UaVJ0U+wYWMejzo8pTqt/br0edHlPPS9Ow6POjxRYhl6aU286XV9hrTZ1P4NrdU2KOxA4BPAZixlK9n9cjkMOplT91lydW1os5H4GQffZjr7zIbWleqM3VfI88jzyPKCxENjk+R55Hi2ODLywnkeeR55HEU9hkLpW/RpYvdNQSpVuy+vaeX2UjiuO3Zoo7NMhtlY6pYeE2IeUtHZNcdvZ17LpQ3Ky1er6478H8QDgWnqmlA5eWnl9FHLS8/xso+OEcHSk8WSwdXlbdXmQNgPBB5HqueE2L7tMg+2mOITwNaBzZMjbj/qXDizQexmQP60rPZLhzXsx25X1bfj2VfJMj/WlA/i08V64/7mR/rZj/uZA/rWs8pkD+dMc/yRyNlB4f1bfj2VfJL/AJNKfjv+PXHHtL/97Mf/AHMgbKPjuH/PTHP9RvZtUPDerb8eyr5Jf8mlXxzicCcDZxOBOBOBs4E41t+PSj5Jb8mwe49Rvddlf+5kf70q+P8ACs/xpR8ku+TZX/j1SODqDwZkD30p+Oxui/YafYafYaVWeQSy4o32Gn2Gn2Gn2GlVpcy2zxz7DT7DT7DStu62/HpR/uXfJsq+P1bhxZsU8reP40xz/F3vXrjaZH+9mP8A6mR+9ahxXf8AHpjj3lvvZsq+P1chfbZQea2HZdMcxhyuuOf7mTtxtLz/AHqPYZB9tMccJD7nZX/j1XXsuzHPvLl6vKTxZLBw+lR4eZH+dmOP4lh5fSodnmQeX0UdVsPVNo9h61y9X1RurS9eywHgg8jIHvqDyLhzXsqHFbHhdcddHPZpSvZ5kN7bEHL+vYnddlLdklidGlDcrYvZNaG5QjkbAOBkNwuta9VsbqmlC8LLW7Psxxy/4F6cHWp+jSxO6ytujw01k+CueCuKipoaUJ8Fc8FcFKAxq1eeCueCuClAZkN7ytO7S1uibaF4T8AgEOhQ60PyJdXzpQ/ZZ9ifZn2YrBxZZ459ifZlb9w7BB9mfZgyOTGYKpPJlSdFlr922KvZv1+E6BwylToCQUcOJbVxFYqVIYX160Nw1o7JpWvVL25bSivjS6zuZTXpfZwNuOnt+HZWHDKVOisUKOHEsplVnjP7ltXTT9RG7q69WrXs9jdF0qq7aXW86VVdtLLAgJ5OxE7sBx6zqTFuG50Dh62TUEqUuDaPUrxRZVP3LKNKbOhvXkUL1W1+7cEyuiEhRZcW0rp7aPYEDMWO2pOi+vZUHgZ6yt6nb+49EPI1S1ki3qYCDqyK0OOsVeFdOyjHWf8AOuNkRmLQAk10gaWWhISWO2mrr+E6K4etkiuyxcgQMrbGVWj0GEFdeSILrBBkGfYE+wk+wsOQYbrDP3olDGKirCQJZfzvqp4/FegGMpUxb3EF6GAg68AxqEMOO0KON4qdouPFVV0e9RGdn3AFjXUE/HIBjY4jIy6i1xBkQX1mBlOvAhrQzw1zw1zxVicAaNYixsiM7NvSlmioqD8pqUMahxCCNnZhPNZPO8+w0+w0+w0+w881kLMfQWl2iVKn/gGmsw48NNghUj1RW5i48WtF/wDGKIZ4a59dZ9afXM+u0+u8+u0+sZ9cQU1iBVH/AOJ//9oACAECAgY/ARW//9oACAEDAgY/ARW//9oACAEBAQY/AfbM88O1n/T+v74Ry9HYz+/2W4xdyMfhdtU1byjLF1/aEjJ/+h7vYQ1sHyd++O0q08IXG0sRNHdMgq3lD8bsHZC626qF2oQI8c1vF/y/xRF0wM0ToFdef6dXXcFdf092Ps0kUDmJFC/RDUSMd11FuFIW251VoOkCM7pAJz/6mgXZobrTtuQsuv3cEwp0W3ayF3lqm8OCNtpclP8A5TQt1VvGZ92bTmj9Zz/cI26q76z/AE0TaK5L8d9tE31WTX5PumdFuKb6rOq3/cX4Ray1xqmbat95e7BO1PM8IW2tKn8+i57LdbT13uLL4WuhawbOA2Vl3h+V2zbBNaLyU5wzhVeSqPTc0RNpc6LfbRbL5XRa2lB/KFooFsu9U/j8lu+0udEPq+sMbqst1hmmuLD+tE9btcFX5L4juq+n5LIqYVe+IfWFLz1Wz7LZCiF9HMNgrd+y3mt37I3Hot99BM+m1eSYSOhg1btF+b7K5DA5XxHVTPo+JXiV4leJVMMlOanJSh+TOL0u1TEbrVv+zxz/AIgLLKZfyhaPTmgbJPkmyOae75XYGtmdU9xxSC+RWqkMc14qUlIqkXEl8pqR6YiyN+ZlBvrtdN9g2lSi5ot4MuMHPQIXBOQ70X5PslbkMDlaDTFoFqeMdeSkFVeRVSqleRVVMKclIvGYdSkpTUw0JzCl2wMaFbvrnbmFdb43EZq7/L+ya4IWjKJcONExt2Wg/FNblJHd3VwyW2RIywccgnOFrU5mYOZL4DqVMvGQVFRUXjh15qcjgmpSWo4KSa/vhmGOoW76rpoW/ZY8drzOUGojn/dN42K2z6bX1KN4qY8cgnOHhqmEGtmU5Lw0HFTmsgvjNfKSkcFOy+J7r5BoypotDphmOq+MwuGYTjG7OckfvNvzahTfZTULdufgF+W7xGFynOFz4pgnKYStgwWp1TVOimei2hNbyCY8imKr0K0OkGulxThTT2dlOLX01xT7rdbMJxjs+kZ1QtA+VLUDfXMJhhYUGHhmmCcr/XKHDMpgtttczF8ymyEk2q3Cojtu8kxgxkYcdUxj/qnGJxnjH2fXVfk+w7r8TCpwsE0NooIMEwTDyMWyzROkHT6ojtGdRVccobb+hg2eRTGseGYTj2ZOWWHeekNoqY8TWDkFeJXiVOpTAPqvErxKYhmTioXiV4lbhaYbx1hsurkYOKjBtPifZHthA1TJzktxzg+Q9gxRGkOIrB8jg2mop7EW9cJu0gLOpjzmjdovIryK8iibi+kHdeRXkUJwBBYLyK8ivJA6oX9DB+8CM8sAIyQuGfsDhHGcCYAawFvXAArsIKPfAbdERHbpA98GzWntQETF9IHtECDa4yNIjjKBEAe8Bd0wOMkDr6xPDCBxgBG4onByhaMJEDF4A6xBRwtp612G2A5R5q7ATAcsN0AeGC1A8YkaIjC2vrXYbYdIjCTDphPKFpwBGJEDzwA8fWuw24bfZ3YbsIPqkcMNsOkbfZ3coiBw28vWIwAwtMQtyoFQKi5QYBUCoFQKgTEQDZqgVFQLcro9IHDb6x4zwgp9I8ijgugOWEwtwW4LjC7Db6wu6YeUkRrG4IjXB0hbhuhywMgIvrAnDby9YjCbesOc4DjKBERAHjhfUwuMRBtIgaIn2r5HALoPmIPogdULumAHVHCETgN3SBMBwnAW64bRx9g2eWHiJQbLKG3REZ5YG0RGuFk2uABExfMwPCWF9PY7xQ1wcM4ccoA5ZwdlRUXxg6oqJ2h8lRUTtAW6Vg2WcOOWJ9fYsU3bBtNRDfb1htNRDxXivFOEJO68V4p2ZOV4rxTbYbinMOJrDgKYRbqm9k3ZMYuKp88xDdbTMLcE4W8dY7dUe8QFtyEd56QYUEN56Q2Cpri3nOntOORTGLhOOohus7JjTNcE48Yv3RHZAZVKftHddSG22mZhuPjDjknOFu6Yes9vkE18jiYqdNYuE10jDQ6pvK3hB7O0GNCtwyW45/spUFEwT39lOQTWyEHuppDjkE5xcTX2DjyTU4L5SwsU9nZMY8NFOSkXj8gpFbSXC2gspl1kF8O6cl0wT3TOkGE7k5ri3XVy9lPuuGqkV8h1Ui+CYXw7KYjJVfmphUVCqKVqq3JTh8pBMAnKazvj3XVyHtXslwTGE5qclIvGa0UpqYx0XyPZSEPjMqeJhVOZ3e3Yr4dlMRr3XyHZaKRweIVFReKlCZXxHdTONzIJh7vTkpTUw2CRVVkqBUVFQKqmfQ0HFanX9Ao3JSKo/JTHqyC+R7KQ/Rp2hUVSvJeSqFUKoXkplUdSH/Cf/9oACAECAwE/EP8AxW//2gAIAQMDAT8Q/wDFb//aAAgBAQMBPxD7a/Y5JvwiU5AyO7H/AD/KP+eeH0P3foiEkhc56ffvUVCZiC3GOZEnR/WJokjd3KCAUoAu7Xpnu4KF2gZg9MRLCLycTqh6f5wfrEkw/wCMvuyYwYXNRycDCbQdmas7nFa657VzOD6YIsAQTlU6LBLs1/o54NXHQNLcqnvCjbLRK0+iY61IljYm+k0GIJ2XnlFBSgWftNTnqPgrPQhE8/4qCMxR1bFSqdD6v3c4PwNKl75AqJC7h6P7qWz8J+sXiQM6hCkkJ1jC4OZRyypLcQSYTZtdA5tRkhUOmlEMwRCTrhdVM9l3qeJzArD3ogEggLre9NmA2WAt3aWAAuSbfqoWFmy3kp4O1toa1CrNeGRUb65ehUM1Hcfu8goRSWLcRQD2hKewVvHPNimZl+ovSBFzySetKTFat/QqYF2TP5pSahoc6dTO6PirxDO+Z6tABBYMjB2OMiC/NAQgc0g92aMNRmw78+CVRl1LPpQCEGptQAQWDIp2ItDFkzVABBkfQCnMsAz50DSV2+ufDHr4oVke7Y+a6AKmxvM4OUplKMEZCKQA114HIB6k1Z0His2HZn2pBChtC0WRMciv9iuc+KH2dmhNHe1GUbuVnl9IFQBmtiiRZZdUyGGQQDGxrTsEOWkx84nMp4DOgMwEFHUhSV0Ov1fTCfikctLofdoiXUEbd6sRsLgw9NmoHP8AKUV85p0OCzMm11OyTndWdsNi3tSrmz1+iBkp0rJ13v70PPuH4rVZ0vW03soRJGTlwppeFN1ypMEkMzaaInNhn+hoGLZemmF3N7lqqxu1y/atMqw3dClF5JN3b6cdizNyVMpTKxPTAdHKGnWtYq7e/wCOAGQDdokkzusVm8m2R9ATIXoUJl4GpfwU/qKi/A0jmzs8KMpHcrOgeefpVmK/JQMoTcwGwYs52XBBsk1YHKGXcrQSybp5zKigg1WI2VYOVXqCx1a0yuzXd3+mggCbJWvMSOWpUBNAzQWeedQ+8S5HQxyu1P8Asik7h4s903yPNOuJyL1mA9T+KyNO3G5APUrMB2t7UjM900PLetvzWdtNy9IjCQ4Kyq3KtBhuWa3q3WeJztWCeS0XOs9AUoCtgutWT+7KvYpkrvad6EAqRyTFw8C6tI4BYWyKGbmVZhVyNaXGR9HahiFYDLzUC4e4bHLgnjGxq0zHZfPFc05z+K0jmYFBKwbtZOz2/Kl5Zzb1sHoBS2fka/pNR/maBy8k0Ld1Ch5b0Yq3SfP9Vey6HG1l1FXyT5XPWrpE+H1peGXOsss6sXfZ+aMl31WZwOTmwlMUf9knzS8MgBkmN6sG+9L0WzqdGsjPdiEFoZzTRVdiDElRExGUacqFbQJNiV2te9MxWBVDGzwXNd0Jll9DhhhO7oV5k3I6YTRBzrS/wbU5LdWOar2oX9yuW8lI7+5Tnl2v7UiWROuIoyMO5VmWO35VGC5Tl54AIAmzerrN8svFSDHM/ChVKRNSsvx/mhAIyOScFz7INZALez5pgLWBLL3yxSDAUmrCQkyIkzOlJobrs5DepUhBmmX7pjhrefeildeWYnbGRt1Q4SVz4VZyOf4UGOAwmeaOhT10wvMcymeV+CspLbET6UKqgWWoWV2TVjFdpxQcyetZ/F3spS83L8qVhFitdO5lUYd18cO9WyzV96LWoBnqanj1NTjaOmYGku9ZaicxAlTA3Ngy7VaRsuL2qHsNY3jIOFnlHq7UzznTY24VygZu/IoABAZBSJIC61O/OOEQeq5FXzuvivTC061pobLFKGpm7FZCl6nNp5tfUNaY5xruUzaR1CrT1V8YQOdkJGgZBNygIAmzR38v4pFIITMcUhe0azrQiCMjk8J0G+gzpy98+nMoz3jZ41sAY9zBQWZxBmHPeioLCZLTtQAAgLAcN0Nvm78Kx5C65UCCAsFAiQF1qNFhk+XCBFjQGOAq/f2lc8L23XkaFTg2XXWr/wAveVYD8OAoiMJk16cO9eCzqNMsGE8JUH8a9MD72OVE5wn+tizDdZm3SjSyOTxLIQ5o147pgAiYRHO9chI2OLpYnTXhBFKsBQg93dwuzzt3ATrZuxvQM4CrybHI3rrhGK4v0FcvVuulKrLm3oVAzGTtRCMhPmtlc+hwFERhMmrH8pzo4tN1SKRIRhKkhr6vs4TtYdhpwUDPG+rv+lABJHJ+zjDJboOGIcxt0auF19zkY3x3vwpSMTBMGdI5p5NuVfwGv4DSzCL6bGhUgdJyE5V/Aa/gNRyUjE2tnSmc6BmlfwGv4DRGQNIbm1Fycqj8XxcMyWZmvLCx3zG3BdnY5P2UmM2zvwqLmooAGQQUbZQlpDmYIxbr10+wBgkSGlVzUUKIjCXGhvbQ+cLW3e+vBcuxdufr7GfRBLvwyNyEHVwshr4NMYl1vfFExoypVnwNf1K/qUnQTEr5Z0sEuRSgMFsDX9Sv7lKS0kkXTAtq4MWvX9yv7lDhkxoslCLkJq6Gv6MEHTkOVCIJcbjUYZL9RwZ4SkosoD7CX7MHa3Dz5c74bWrboZYc0QUAEGRUQOt3bLg3SiXq3qZco824ZqzQmo3qEO3BIzNSdGt7Ut1MsZ5Z5ejhAtGzvwSCyu6vrrAu1LKu9+HlIB4qFs4g72x6ar3bYT/Qs7Y87kHCLnA8X4VINlPmkkh1rnaTxjdmVzvhG2UydG+E0ZNuhwt957nAhZykojcgP1uQS9uE82B64R79nxja5geKmDQXxSqq5t3GAdi/GD9R4X0yPnDqGHyYpAZjPihkE1qPZo8f3HdKL9S1dAw+OGReu3R+t6T54RPUwdvaXlxinuX4qYco824D0wHnB2dvc8Lschwi3nseCbco8Wqbae4xm3ifNTJqJwwugJ8/W9Me/D6x9sH4DEx3/epyjcngi3yB2wnnLQjhnyM3nBuRcXglc3Y81NyIfXGLdE+P7gYey9+DkcJ+sJ6HD6x9sMzoY+k+cIbFcgrkFZZYIOZUNiuQVyCuQVBjyCobFQbYegxdnMcDHU+OF80B+qeZI9OFw3P3wEF3Hzj6T5+z9cx9A+2Hs/Y4VPSfW5SKeHg5SI4dYCeMXPf96VQSkEda/wBTX+prlfLSKpCothEI2lWv9TX+pr/U1/qaVkIJEwQQSyz5V/qa5Xy1/qaUUQs26U46EYmelYez9uH0H1uWIDh5gA1Nzg+bYyI3KHQ38PArjo++AhN/lwm7sfODscl4IBynzenCN0PnHpADzgpHOPFuH0H1phaMu/DCGqaGjoisrYXug1yJJWWMCN/Y4C66nCM3Q98Jo7A+cQVg1oQbCK62V8f3GQ3F7FsHzRXzwiC5Pb6wO6luulcnPgjdqQ6mEjGVjvnhy5cw6vSdG+Mn3Ye9sDO29xwwLcelsOpieLYwvQZe18IDQPfDpXLMFbpBbq24hAbAfXnAavfXg5GN+lZ1ZRq9tcEAZoTtRE5CTvUYtSXbEURMy5RG5Aa6Bv4eGI7k+b1y7F4Lz9Hu4bLrbpphyFc7ZYREzUvQ4elD0v8AYTIyX6iuvBGDuummEyM1+jCdWbt0aijJfqODnFx2cq5Wk81lZzMQVAzbFAAyCDtUCc3focG5ub1a3qiDq43fu9tMJ8ZWO3DKaT6v2P6YD++CBXNb8sDi0XXOkRRISyVOHJ0OChIm7DXMeWuY8tTkInOWcsEyGW7DXMeWuY8tFipLks4NCGTKGK5jy1zHloMLi5LOEocrurTBB0LrlQRYyqURhW6uK5M3PbT7FkUiQ0zeWa3OC721zMI0FzLub4dAHqYLGGKZk/qv8T+q/wAT+qM5TmbNRFmIzip/1+ql/X6qXyDG9dk4btS/r9V/if1SAJqxA/rBlkFI15WWs2DOs23vwwyna/LhYjVny1oAAyLH2UzWdWzSM4TE00C41G1h2HC+Pdsc6J5hpuUJaRrM7f5xnnll6lRozLO2M0Z5vVq3v2uMCG7l5b4XE2ubvhln0/OFyfYHFAgvZ0faQJsOxSY4T16YnXvqblauO4YZ4dfxpNU5NnehBJde1Is9emAqEYS40InWw2da2tmehqeMngKFdeQ50qsubdcGQFuRv+sLp+Q15GDMGzI3/VZVM83kpESVuvCwHLNbFAAICwfWAGjI5m1OYorK5UIklzfhgj0dSmdWgZYmFhNajup6OFyTkvmnJHqjtUAhJHRpCb5r+NIjCQmY1cTe5O9R+dn6NSthv+FdmXNzoRBK6FZHb/OpcgKkec7uDQONOpoAILBkVNm67lI3leEFQCVsFDE7y+PsNM/Q9az8hm8qtN3nl5oRJGTfgQCEjmNZ/l/DQSCEzHGCBncyqz3/ACUPJDkzjkY89fNKbpyb0+1ok02prQ6wZm1CzuTKgH+rREgnmy8UlKVQJVdCoXlmgwG7Bt1pw8rXiyFfk2PsoUb6DMp2W+kfNJ5Rtp4plouS54oiS6OASCedCupN1PQx1xESkdy1bSbXVo16MUa7OjNfwD806TfBWiDqzW0m1lKqUru0CsBK6Vdem1oGy3dWgVIDNaSVo8+1Z3eKwP2HN+0QbOVSlxuyqDKNCjIw7lWNB55+ayyvyUPJDliggSc6uIS5UW7ORs1mr1CfauvCXsXrKmG7ahzm5flQsEc9aULtipE+FTEudgyOIwMrSoz4w6fbiwiOjTLqObKkcrnp5wFGRh3Kt5M2up/l/aswXqPxWSr0cVMwetZl4IpX92v81/NGQHe/vRkAdDDJGdi76UOXe/CtTjbTjiepub0KiDG7q/dRNmruE9/wq6IPhqzt1HAZhOi0Bv6g0Hu7Vv8AqfmuV9a5X1p0A8/mltB0CsxHq/QvKc78KhmOY+Pv0EhJNmt5N7Kf40/FbQb3VmQdT6mdZ+xu2PWlz7P5Vcb27d/42aDsUtt6LS+QeKRp5FOkPFP96v8AQ/it/wBajUHijXXoBXyg1kudD/4n/9k=", width: 180,margin: [ 190, 80, 0, 0]},
                        
                        
                        content: [   
                        	
            
			
			//~ {
			//~ style: 'tableExample',
			//~ table: {
				//~ widths: [500],
				//~ body: [
					
					//~ {text:[ { text: 'Room No.VIII/238,Vadama P.O., Mala-680 732,Thrissur,Kerala\n ', fontSize: 12, bold: true,alignment: 'center'},{ text: 'Room No.VIII/238,Vadama P.O., Mala-680 732,Thrissur,Kerala ', fontSize: 12, bold: true,alignment: 'center'} ]}
				//~ ]
			//~ }
		//~ },   
		                                //~ { canvas: [{ type: 'line', x1: 0, y1: 2, x2: 500, y2: 2, lineWidth: 0.5 }] },
		                                //~ { canvas: [{ type: 'line', x1: 2, y1: 0, x2: 2, y2: 500, lineWidth: 0.5 }] }, 
		                                 //~ { canvas: [{ type: 'line', x1: 500, y1: 0, x2: 2, y2: 2, lineWidth: 0.5 }] },  
		                                 	//~ {
			//~ style: 'tableExample',
			//~ table: {
				//~ widths: [496],
				//~ body: [
					//~ [
						
					 //~ //{image:"data:image/jpeg;base64,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aHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOC0wOC0wMlQxNjo0MDowMyswNTozMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxOC0wOC0wMlQxNjo0MDowMyswNTozMCIgeG1wOk1vZGlmeURhdGU9IjIwMTgtMDgtMDJUMTY6NDA6MDMrMDU6MzAiIHBob3Rvc2hvcDpDb2xvck1vZGU9IjEiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJEb3QgR2FpbiAyMCUiIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMDQ4MEFCMDI0OTZFODExQUNGMzg2MDlENjM1RjdCMCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMDQ4MEFCMDI0OTZFODExQUNGMzg2MDlENjM1RjdCMCIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjMwNDgwQUIwMjQ5NkU4MTFBQ0YzODYwOUQ2MzVGN0IwIj4gPHBob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4gPHJkZjpCYWc+IDxyZGY6bGk+YWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjdjN2IzYTgxLTgwNDktMTFlOC05ZmQxLWQ3Njc5NjM5OTMxMTwvcmRmOmxpPiA8L3JkZjpCYWc+IDwvcGhvdG9zaG9wOkRvY3VtZW50QW5jZXN0b3JzPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjMwNDgwQUIwMjQ5NkU4MTFBQ0YzODYwOUQ2MzVGN0IwIiBzdEV2dDp3aGVuPSIyMDE4LTA4LTAyVDE2OjQwOjAzKzA1OjMwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0idyI/Pv/iA6BJQ0NfUFJPRklMRQABAQAAA5BBREJFAhAAAHBydHJHUkFZWFlaIAfPAAYAAwAAAAAAAGFjc3BBUFBMAAAAAG5vbmUAAAAAAAAAAAAAAAAAAAABAAD21gABAAAAANMtQURCRQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABWNwcnQAAADAAAAAMmRlc2MAAAD0AAAAZ3d0cHQAAAFcAAAAFGJrcHQAAAFwAAAAFGtUUkMAAAGEAAACDHRleHQAAAAAQ29weXJpZ2h0IDE5OTkgQWRvYmUgU3lzdGVtcyBJbmNvcnBvcmF0ZWQAAABkZXNjAAAAAAAAAA1Eb3QgR2FpbiAyMCUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhZWiAAAAAAAAD21gABAAAAANMtWFlaIAAAAAAAAAAAAAAAAAAAAABj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", alignment: 'center',width: 200},
					 
						 
						 //~ ]
						 
				//~ ]
			//~ }
		//~ },
	{table: {
		widths: [496],
		 body:[
			    [
			    
				   {stack:[	
					       
				    {image:"data:image/jpeg;base64,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aHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOC0wOC0wMlQxNjo0MDowMyswNTozMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxOC0wOC0wMlQxNjo0MDowMyswNTozMCIgeG1wOk1vZGlmeURhdGU9IjIwMTgtMDgtMDJUMTY6NDA6MDMrMDU6MzAiIHBob3Rvc2hvcDpDb2xvck1vZGU9IjEiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJEb3QgR2FpbiAyMCUiIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMDQ4MEFCMDI0OTZFODExQUNGMzg2MDlENjM1RjdCMCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMDQ4MEFCMDI0OTZFODExQUNGMzg2MDlENjM1RjdCMCIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjMwNDgwQUIwMjQ5NkU4MTFBQ0YzODYwOUQ2MzVGN0IwIj4gPHBob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4gPHJkZjpCYWc+IDxyZGY6bGk+YWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjdjN2IzYTgxLTgwNDktMTFlOC05ZmQxLWQ3Njc5NjM5OTMxMTwvcmRmOmxpPiA8L3JkZjpCYWc+IDwvcGhvdG9zaG9wOkRvY3VtZW50QW5jZXN0b3JzPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjMwNDgwQUIwMjQ5NkU4MTFBQ0YzODYwOUQ2MzVGN0IwIiBzdEV2dDp3aGVuPSIyMDE4LTA4LTAyVDE2OjQwOjAzKzA1OjMwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0idyI/Pv/iA6BJQ0NfUFJPRklMRQABAQAAA5BBREJFAhAAAHBydHJHUkFZWFlaIAfPAAYAAwAAAAAAAGFjc3BBUFBMAAAAAG5vbmUAAAAAAAAAAAAAAAAAAAABAAD21gABAAAAANMtQURCRQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABWNwcnQAAADAAAAAMmRlc2MAAAD0AAAAZ3d0cHQAAAFcAAAAFGJrcHQAAAFwAAAAFGtUUkMAAAGEAAACDHRleHQAAAAAQ29weXJpZ2h0IDE5OTkgQWRvYmUgU3lzdGVtcyBJbmNvcnBvcmF0ZWQAAABkZXNjAAAAAAAAAA1Eb3QgR2FpbiAyMCUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhZWiAAAAAAAAD21gABAAAAANMtWFlaIAAAAAAAAAAAAAAAAAAAAABjdXJ2AAAAAAAAAQAAAAAQACAAMABAAFAAYQB/AKAAxQDsARcBRAF1AagB3gIWAlICkALQAxMDWQOhA+wEOQSIBNoFLgWFBd4GOQaWBvYHVwe7CCIIigj0CWEJ0ApBCrQLKQugDBoMlQ0SDZIOEw6WDxwPoxAsELgRRRHUEmUS+BONFCQUvRVXFfQWkhcyF9QYeBkeGcYabxsbG8gcdh0nHdoejh9EH/wgtSFxIi4i7SOtJHAlNCX5JsEniihVKSIp8CrAK5IsZS06LhEu6i/EMKAxfTJcMz00HzUDNek20De5OKQ5kDp+O208Xj1RPkU/O0AzQSxCJkMiRCBFH0YgRyNIJ0ktSjRLPExHTVNOYE9vUH9RkVKlU7pU0VXpVwJYHlk6WlhbeFyZXbxe4GAGYS1iVmOAZKxl2WcIaDhpaWqda9FtB24/b3hwsnHucyt0anWqdux4L3l0erp8AX1KfpV/4YEugnyDzYUehnGHxYkbinKLy40ljoGP3ZE8kpuT/ZVflsOYKJmPmvecYJ3LnzegpaIUo4Wk9qZpp96pVKrLrEStvq85sLayNLO0tTS2t7g6ub+7RbzNvla/4MFswvnEh8YXx6jJO8rOzGPN+s+S0SvSxdRh1f7XnNk82t3cf94j38jhbuMW5L/maegU6cHrb+0f7tDwgvI18+r1oPdX+RD6yvyF/kH////uAA5BZG9iZQBkAAAAAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwP/wAALCAA5AZABAREA/90ABAAy/8QA0gAAAAYCAwEAAAAAAAAAAAAABwgGBQQJAwoCAQALEAACAQMEAQMDAgMDAwIGCXUBAgMEEQUSBiEHEyIACDEUQTIjFQlRQhZhJDMXUnGBGGKRJUOhsfAmNHIKGcHRNSfhUzaC8ZKiRFRzRUY3R2MoVVZXGrLC0uLyZIN0k4Rlo7PD0+MpOGbzdSo5OkhJSlhZWmdoaWp2d3h5eoWGh4iJipSVlpeYmZqkpaanqKmqtLW2t7i5usTFxsfIycrU1dbX2Nna5OXm5+jp6vT19vf4+fr/2gAIAQEAAD8A3+PfvZAv5mnyeovin8Pu1d+0e52212LmsLVbS6gekmWPKz9h5anlbGV1FG8csclLtejgny1b5QIWpKJ4ydciI4r/AAi+RNL8tPiP8e/kbTpTw1HbHV+2tyZympNIpKHdi0v8M3njqUK72psbu3H1sEYJ1BIwCAbgGm9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9//Q3+PaG7M7H2j1D1/u/s7fuUTDbP2Pgq/cOeyDL5HjoqCIv4KWAEPV5CtmKwU0CXkqKiRI0BZgPfz0P5l/zo7t/mLd9UG0tm4LPZODKZ4dbdMdS7dD5Orpl3HkqWhpNr4amoyy5Teu9K+GnbO5NeH8aUsTLSUqAbT38qruXq/43ZHZX8nbJbgo8v3V8bPjpgd9ZrdNDlKOr2zu/sLcW7M9unv3r7a8yCEz1PTu4d9Y2BVXXPUUc8ryxwPSTILyvYOdX/IHpzurcfbe1Oq994ne+a6K30ese1o8JFXy0W0uwIsXR5mt2lPl5aOHE5LMYqir4hWx0U9SKKoZqecx1EckSFq+Tv8ANC+Bfw53fS9ffIf5HbQ2Pv2ppIK99l0ON3XvjdGNoaqMS0lXn8JsHb+6K/bcNbCwkgOQSmM8bB4wym/ss3/QQB/KT/7yxpf/AEUPfH+9f6ML+xz+OP8ANp+A3y37WxvSfx17sruzuycniMvuBcDiuqu4cZBj8BgoVlyWbzed3DsHEbfwWMikligSWrqoVmqp4oY9UsiqbHvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvfvf/9Hf491SfzrML2Dm/wCXb3SnXtHka+fF1Wzs9u2nxMdRNkE2HhtzY+t3NXxwUx8klLiII0rKtirLBRwSzNYRll1tf5LO0dvbc2986vlti4cZXdxdAbF68686krq2np6+Lr6fu+bcNBuff9HDNFJ9rmY8Pio6Slq0YWpjWwOGinkVq0fjD3N2E385j4Ubx62OcyGWn+UGE2JT0tBNUS5jcWwN61OX2/27XZeoYySTxZja2TyORyM8xMccEWuQgLf3sL/zvf54R6qbdvww+Fm7437bK1e3u9O9dvVUc0PT8UimDJdedd5KFmhqO3JonMeRyMZZNsIxjjJypJx9bP8ALx+be5fgL/Ji+X3anXzQp212T8vKbpjqHJZFRkEw2+t3dU7dymW3vW09TIz5Ko2jtmgr8nGZvLHPkkp1qA8cjq1THwy+EXyW/mPd4Z/YfTxh3Fuwwyb87c7b7O3DXnEYKmzOTNPNurfG4pIspn9w7h3Blpn8FLTR1VdVssrhFhhkeO49v+EsvzfuwHyC+LLAEhbT9sLdfxcf3DNrj/be9kX+UL/K4wX8tXpbP0G58tt7ffyJ7UycWU7c7F2/BWjCjHYh6mDaOw9mNlqSiykG0du0c71DtNDFPW5KrnmlGgQJFbr71Pd5/wDCxb+WPsjeG69l5HpL5z1+Q2juTO7Yrq/EdadAT4qtrMBlKrE1VZjJqv5N0NXNj6mekZ4GlghkaMgsiNdRfJ/L0+ffSv8AMs+M+3vlR0Jh+wdu7C3BuXd201wHaWI25g974nM7Ny8mJyUOXx2092b3wMSVaiOqpjBkpy9LPGXEchaNatPnb/wpw/l9/wAv35PdhfE/tXYHyj7A7G6vj20u78x03sjqTcGyqHJbm21it10+Diyu8e8dh5ifL43F5qnFYn8PEUM7GMSOyPpNL/Kz/nYfFr+bnle6sT8buu/kLsqXojH7DyO8anu7anXG26Suj7Eqd202Bg28+xO1+yZqupibZdY1QKlKRUXRoaQlglwnv3v3uqr+YT/Oh/l/fyy6qi218lu26p+08tg5dxYbpPrTA1O++06/DiCregr63EUs1Fg9o0ecqaNqbH1GeyOKp6yYkxSNHFPJFVFsP/hYn/Kf3fnDidw7P+YfVlAKOWpG59+dQde5HBtPHLTxpjhT9Ydz9j7l+8qI5mkRjjhThIn1SqxRX2itkbz212PsvaHYey8mub2dvza+A3ntPMpS1tCmX21ujE0mcwWTWiydNRZGkWvxddFKIqiGKeMPpdFYFQqPfvdbH8zv+aV8e/5T/Texe7/kVtTt/eW1+wezaTqvB4npfAbL3FuaHPVe1tz7uGRyNHvnsDrnFw4KDH7VmiklirJpxUTQqISjO8dH4/4We/yvD/zQb58fW3/Mrvjz/wDdS++/+gz3+V5xfob58C/9ervjz/h/4FL/AI+7vP5YX80z4/8A82Hp/fndnx22Z3NsvafXnZM/VuZo+69u7K25nazcNNtfbm7ZarE0+xuwuxsbUYlcbuemTXLVwTiYODEE0u8n+Z1/ND6B/lQ9KbJ74+RG0O4d57R352ljeo8Rjeltv7L3FuSm3JlNp7v3lBXZKj3x2B1zjIcGmM2XVRvJFWTTieSJRCUZ3jo5/wCgz3+V5/z4b58fn/ml/wAeObf0/wCcpefYn9Q/8K/P5TPZ29aHaW58X8qeisbXCJV3/wBu9S7MqNlUtTNkKChjpa5uoO1+2d10h8da9S074oUkdPTSl5lfxJJs57N3ltPsTaW2d/bD3Jhd47J3pgcVujaW7Nt5KlzG39ybcztFDksNnMLlaGWajyOMydBUxzQTROySRuCCQfal91ifzP8A+bR8Xf5THXPW3YvyTx3Z+6R2xvLIbN2XsrpzBbS3FvjIvhcM+Z3DuN8fvXfPXuGj2xt1JqKnrJxXtOlTk6RFhdZHeOrr46f8K0/5aHyR746i6AwHXHy82BuHufsHa/Wm293dnbA6Ww+wcPuTeWUp8Ht9t1ZbbXyC3bmcViqvM1kFO9THj6hIGmDy6IleRNoD373rj/OH/hT18CPgJ8pu1/iN3F1H8vty9kdPVW1qTc2b602D0xmNkV0m7djbY7AxzYLJbp7+2bnqqODDbsp4pzUY2lK1SSKgdFWRyof9Bnv8rv8A58N8+P8A0V3x5/8AupfdkHwF/wCFD/8ALP8A5h2+sH1J1h2LvLqjufdBlj2p1L8g9q0Ow9zbrq4quvp/4TtrPYDcO9Ot83uCeno46mDGU+dkyNTBUp4oHkjqY6e8f3XR/M3/AJm/Qv8AKk6F2l8iPkRtLt3eWyt5du4HpfF4vpfA7N3FumDdO4tm7+3xRV9fRb43911iYsBFieuq2OWWOtlqFqJYFWBkaSSKjAf8LPf5XZ/5oP8APfj6/wDGLvj1x/r/APOUnvr/AKDPf5XfH/GB/nvzf/ml/wAefwbf95S+9r7Y+7cfv7ZWz99Ymmr6LFb12tt/duMo8rHSxZOkx+48TSZijpsjFRVdfRR18FNWKsywzzRCQEJI62Y1VfzTf51XxZ/lF13SOP8AkjsH5Ab2m76pOwqzZ79IbV663JFjY+tZtlw51dyHfnavWr0klW2+qQ0gpVrA4jm8hi0p5Klv+gz7+V3/AM+H+e/5/wCaX/Hj8f8Al0vsxXxp/wCFYX8pr5FdgUHXmZzXefxrrszkcXicFuT5Hdf7UwGx8pX5U1yIk+6+sux+1cZtejo56WKOorM4cXRRGribzFFneHZZilinijngkjmhmjSWGaJ1kilikUPHJHIhKPG6EEEEgg3HsqfzG+cXxa+AvU83dPyv7c2/1Rshq04jCnIR1+V3JvDcBppauLbeydo4OkyO5N15ySnhaRoaOmlFPArTztFAjyrr2VP/AAsh/lUwbsk27F1v81azDpnhiBv2m6k6nXacuPNd9od0pR1ffdLvkYFYL1JjbCrk/ALCk837XvYI+EXzl+On8wzoyi+RPxg3Vlt2dbVW5s/s2epzu189tDMYzc+2mpTlcTX4jP0VHP5IqbIU06SwmaneKoW0msOif//S3+PdRn83b5I9nfFLrvoLuDq3KGHJ43u6HD7i2xXu821N/bQymztySZvaG7cZ/mq3HZFKJDFKLT0c6rPAySqrBq+BfTP8uvvujz3yq+M3V9H1lnOx9vZzr/5C9P4PMV1DtGrrc6Kavrdrb/6wFTNst4cRVK1Vg67F0WPieGod0ClpIItdX+Zf8h/gn/L57G7C6O/lY9TbO2d8pM1jMvszvD5YYPPbj3nm+icFmwY9xdTdIbh3Rn9xLtvszL0zGDMZHFNAMBTO1PrfJf8AFt1rBtvPQ7ag3gcHmV2fWbir9rU+7ZqOr/geR3dR0UGay+Cgzc6mDJbho6DIRVdZGkkk0S1CPLYyLqtE2913uDeX8j3sbeuBoaqvoOkP5lOJ3fvkwUpmTE7Q3t0VgNgRZ+qnS5pqLH7oyGPp5CRp/wAsDMVC8nA/4T6fzGOivhB2n3X1r8jMvBsPYPyCg2VkcN2xWUU9Thtp7x2FDuKlpsDvCehgqK7Gbe3Lj9wv9vWmN6elroQs3jjmaaPcF21/NR/lx7uzMW38F80/jzNlJzphir+xsHg6eRi4jVFyOcnxuNMjubKvlu34B9nxoMhQZWho8pi62kyWNyNLBXY/I0FTDWUNdRVUSz01XR1dO8lPVUtRC6vHIjMjqQQSD7b9y52k2vtzP7lryoodu4TK52tLyLCgpMTQz19QWmYMsSiGnN2IIUc+/hfbB6t3r3XD3VuTBIcnkur+tMx3ZuuniplNRX7foN8bM27uarhSnWGnpRiYt7HJTmwRaWjlCrqKD3u3f8JFvnZt3pb4j/zJ9hdqZeqpuv8A4yYql+Y9N5Z9cNNtefY+4MX2lT0BlUrRzR/6MsM0MAYioqa5yieTyGTT67BTuL5u7r+cXza3dLU1FVgMsO+e1stJrrqCPPd3977W2Pt/ZtDVTVFO9BGlRvmokx0SRPHFj8I8KRRxqpj3J/8AhEJhoo8P/Mm3AXSSasyXxKw0aGnUS00WOpfkfWzMlUXLtHWvlEDRhVANOpJa4C75nv3v3v48X/ChTr3urYH84D5qy93Y7M0+T392dP2H13l8rDOKTc3SubpKag6myO36+RRT5TDYXaGHgwZeFnSlrcRUUbFZqaVE2tP5RX8oD/hPP/Me+DvXW5dldd7i3/35t/Yu0MT8jq3Kd+dzba7j2D21LjKWTdMmS2DhN+4vr6j2xls3T1gwddT4CXG1uO4SRqqKcQ7jvS3VW3+iuneqOkdp1+eyu1enettj9W7YyW6a6nye5q7buwNs4zamEqtw5OkocbTZHNTYzExNVTpTwrNMWfQt7exM9+9k1+an8vz4i/zENh7U6y+YnUzdv7H2Ru4b72xghv8A7P6/TG7rGGye31yzV/Vu9dk5SvZcPmKmEQ1M81OBKWEesKw0AP8AhU9/LH+Bn8t7G/B6H4adCv07ku6a75HS7+rR2f3D2FHnKLrWn6MTb1K0PavYW+Y8U9HUdgVbK1CtMZQ5ExfTFoF//hL5/KH+An8w/wCOPyW7L+ZXQUncOe2P3ZgdjbIyJ7S7o69iw2I/uLj8/lqFKXqvsfZFHkZKisy8UjSVkU8sYChHCkr73qfhd8CPib/Lz633H1H8PuqP9EPXu7d71nY24dv/AN+uyt//AMQ3lX4HAbZq8x/Fu0N471zlJ5cJtehg+3gqYqRfBrWISPIz60X/AAtMrTH8BPi3jxUKgqvmBQVn2mtA85oel+2IBUCI+t1pv4iVJHC+YX5I90X/APCdz4O/yjvkF8ffk93T/NWHT+Hwe2O5OtOrupt291fJvePxq23TZbKbJ3ZuzO7cxWXwnbnVOE3LnMvR0UdSKad6yrigoZHjCR+UtUp/Oi2J/Lf62+bec2l/K53K26Pjhj9h7WfM1NBuzce/tmY7tWordwz7mw/XO9911+Xzu69m0O3mw9quaurh/EXq40qJI41Pv6Tv/CcvrTt7qj+Th8Odq91Y/NYXdFTgOwd34PA7hWoTM4Xrvfna29959c09XFVKtTTQZDZ+cpK+lgclqaiq4YrJo8SXcyyxQRSTTSRwwwxvLLLK6xxRRRqXkkkkchUjRQSSSAAPfyO/52fzi3n/ADiP5oy7W6Jlrd8dZ4Hd+C+MHxI23jnL0u63ye5KTBVW8aBIpJqeWftjf9Y1XBVBUc4ZcfHKAacn2C385b+XHmv5RvzR2R0/tXc2ZyGKrOkei+3djdgRS1NPVVu8aXAU21+yc9iq5HSWhcd37FzmRoKe0U+OoKujjIIWOWX6qf8ALc+WmL+c3wW+MXynx89FJkO1+qtv5DelLQTx1FNiOzcGkm1u0cDHIixkpg+wsJkqVNSRu0cSsUW9gd338f3/AIUfZT+L/wA67521StE4i3n1li7w6ggbCdC9U4ZlIdnJmRqC0luDICQALD3ux/FL/hND/J+7f+EPxh3Xv/4vZ+l7b7I+MXRW6999kYX5Ad/Uu4p9/wC5+sdp53d25aTDP2fketaOtymeq6iVqeDCfwuLylaemjjEar8+v+ZV8Pc5/LO/mCd5/F7A703BlX6O3vtrM9bdhqf4Duir2zubbW2uzut9w/e4WWGOk3TisJuOiSpqaJolTJ0srRLCVEafW/8A5XXyU3B8v/5eXw/+R+8Joqne3aHR2zclvytp4hBT5Hf+GpG2vvvJ01MpIpabJ7uwdbURw3bxJIEudNzrw/8AC0nJ+H+Xp8ZMR+a75m4HJf563GK6Q7qpT/k1v3f+Lz+u48f0518akH8kmP8AkrHd/wAgZP5ytQV2om29gRdD0nj+V7ebcEuT3Q2+p/P8Vj/EovtcbDjVKZn9h/Len9Sy+9n745/HX/hGh8s+6dh/Hj4+bNbsDuLs3IV+L2Rs9c9/NT2uc1XYzC5PcNfF/Ht55rbu2MYtPhsPUzmSrraeMiIqGLlVO67gcHi9s4PDbbwdL9lhdvYnHYPEUXnqKn7TF4mjhoMfS/c1k1RV1H29JTomuWR5HtdmLEk/P/8A+FuVYX7I/l34/wA6v9tsj5I1gpQ6l4TXZ7pmE1DRg61Wq/hoUMeCYTblT7Dv+SJ8Af5FHYP8uLbHyB/mmTdDbZ7V3/3H3XjNl5zub5d9g/Hmv3JsfrePZ9BPjNobTwneHW2M3Z/d/I5J2qJaGgqqvyV8UUjsWhQauv8AMD2j8U8T84O99lfy/cnuTfHxdpd+Y/AdH11e+YzeXz0bYTBUmbpcJU5GnGez+FbfzZKnwlRMjVVdjFppWLvIWb7Cv8uTYXaPVnwB+FfW3dkeRg7b2H8W+i9pdh0OYmapzGK3Xgettu43LYTM1Llnqsxg6inNHVSlpDJUQOxdydbaUP8Awtd687pfub4X9r1WPzNX8dabrHefXmDy0UM8+3tvd1Vu6qncm6sfkKiNHpsVmd5bGx+Hko0lKSZCDBVRhDijn0Fl/wCE1nwv/knfOja3YHTXzZ2rV77+bD72yWT2DsTd3b3afVu39zdUU2Bw0tI3Va9Yb32DHurdeNysWTkzNBWVFZXx0giqKeL7ZKh4t+n4Ffy+/jz/AC3Opd1dG/GKl3piesN0dm5rtVNt7y3bVbzO3Nwbg23tLbOVoNvZbJ065qLA1EOzoKrwVdRWSLWT1DrKEdY0/9Pf49kM/mJfC6D5wdBTdcUW5X2nvja2bi3x11lalpH27Luqgx1fjo8Tu2lgimqZMBmKDIzQPPADUUUrR1CLMInpp64P5IXWu+OmsF83+rezNuV2zextl732Tjdy7dyBRa+gkbZ+5J8dVQ1NNLLBXYnKUripx9bTySU1ZTSLPBI8bqx1OP5Y/wDK67b/AJkvcmXxmHbI7G+O+w96V8Hdnc4jXy0JfJVFfUbC2C1ZHURZzs7NUU6szuslPiIJxVVepmggqLeP+FIfQvU3xg6E/lw9DdIbUx+x+tdgZTvehwG3qFpJHJlw/Xc+RzWVrZ2erzGezWQmkqa6tqHkqKqpleR2JY+zT/8ACZfYOze0/gj8wOtuxNu4zd+xN9955rae79sZmH7jGZ7b2c6q2lj8rjK2JWR/DV0lQy6kZZEJDIysAQRT5i/8JkfknsPeOUy3wn3LtnurqjI1NRPhNh9jbqx+yu09m0zuXiwdRuPLw02zd64+kRvHDXST46rZFtNC7DyvWh3D/JH/AJmnSfXm4uzd/wDxcar2ZtShqMruR9j7+647HzeLw9HTzVmRzMu1Np7gyedq8Zi6SneWpkggmMMalium59mP/kg/zTOxPh133110BvvduQ3F8R+693YrZdZt7NVs+Qpund5burYcbtnf+yJ6mR5cNt+qztVBT5zHRkUklNO1WkQqIBr3mvndvim6x+EHzH7Iq5TDTbA+K/yD3nPKIhOyx7Y6l3bmmKQEMKiQ/ZWWOx1tZbG9vfzV/wDhLp8acV8rPk/87undxUkVRt7sP+WJ8i+raiWVgrUmV7T3x05tDF1cExH+S1NFDV1NRDOCGhmgRl5FxQ/1d3x2x8bsJ8nesttSVe3ZPkF1FVfHPtTH1gnp67H7dou3Otex81R/ZSLpiy8uR6uGJnaRNcdDkKyNSvka+wF1x8Uv9CX/AAlm+Tvybz+MjpN0/Mj5Z9JU2ArJIEp6ufqTpXsaTa+2o9csa1Eq1PYMW6Z9AIieEQSi9r+7r/8AhEvRTJ0N88skzReCr7d6aoY0Ut5Vmx+zd5VE7OunQInTKR6CGJJDXAABO7Huvde19ibX3JvjfG5MBs3ZWzcBmN17v3fuvMY7bu19qbX27jqnL7g3JuTcGXqaPE4LAYLE0c1VWVlVNFT0tPE8kjqiswLn1L87vg/37vGn666J+ZXxU7q7Bq6GvylJsXqX5D9Rdj7xqcbi4hPk8jT7Y2du/M5uahx0J1zzLAY4V5cgezV+6rfnZ8Bfgn/Oe+O/9z96ZvZW/wBMZTT13UfyG6c3HtLdO7urc3nKCiyNPk9q7sxE+XxuR2/nqQUk1fiKiR6DLUgichJUpqmH5VH99O/v5PX8wnebfHbvzbGZ7Q+M3Zmc2dR9pdX5UZvrbs/A0NZD/EMPmselTJR57aW56BUgzGGqZJlp6pJIRKZ6aOcfYh+Inez/ACh+Kfxr+Scm322pL370R1P3HNtgzmqXb8/ZGxsHu6fDw1Zs1XTY6XLNFFMQrSxqrkAmwmd4fKz4u/GP+7H+zJfJLoP49/32/jf9zP8ATh3D151P/e7+7X8J/vH/AHY/v7uLAfx/+Afx+g+9+08v2v3sHl0+aPUreou7emPkBs+LsPobt3rDu3YE2RrsRDvnqLf21Oydny5bGNGmSxcW5tm5bNYWTI49pUE8AnMsJYa1Fx7E/wB/Pp/4W45wVHZX8u/bQdS+J2P8ks4Yxr1ou4c701QCQ/uMmmQ7YIFkBupuTwFsX/4Rd4pYf5bnyMzgCasj83t54osHkMpXDdD/AB9rFDxkCFUBzp0svqYlg3Cr72//AHpRf8LXc3FT/Ff4U7cL2nyvyB33m4o/Td4tv9c/YTNYqXIR9zRjggDVzfi1UP8AKB+Fn+zxf8J8P5r3WGJx0uQ7B233hhe4+pxHEklQ3YfSvVO3t6UOKxeqGUDI7uwDZHAE/UR5Y2KE6vdcf/CbnOfFOD+al0xsP5bdRdc9q7U7hxuZ646wn7PwtFuLbmxe9a6pxW4er9wJgsxUtgq/LZ7MbebbtAKijrXjyObp2iWNgZV+uv71m/8AhUP/ADMP9ke+CVd0d1zuSXEfIj5kU+e612tNi6kxZjZ/UtNDRwdwb5SanqIarF1NVh8tDgcbOpSYVeWeop2L0MhX59H8uX+XJ/NC+X2Szfef8uTrPsDJ5vorc2Jx1T2xsLunr7ofP7J3dnMXX1NDBtXeW9OzOtMtNm1w6yNUnDVE81HT1EX3BiWqh8o8/wAyv+Xf/PG6i6zwPyP/AJnWF763h19tXNUHXW3uwu5Plfsb5L1e0slvJqyvpcNQU+J7t7T3PtjEZqqwzeScU9Pj2qhDHJIJpYFfZe/4RgfNb+ObC+SXwD3Xl2kyOx8lD8juoKKrq43lO09yzYrZ3auHxsEhWaHHYLdCYSvEaakNRnamQhSSX3pPfxuP59uXgzv84n+YBWwSNIkPfOSwzFnL/vbd2/t/b9SgY/2YqnGMoW3pC2+g9/WR6u7G6s+O3wy6P3d2/wBg7O6s6+2R0B1bDl939gbgxGz9v4ykwnWeJnmNXkMxU0VFDNHQYyWTwq2srE2lTpPv5Gn84n5g7c/mBfzL/k/8letoMjVbC39vbAbW6wSejngr8zsvrfZ22OrNqZlMW6fe0s28aLaKZVaWRRPE9f42VXUqPq9/yo/jrur4nfy4fhr8fd90S4vffXnRe0IN84hVlU4Xeu4YJd3btwkvm9b1OF3Dn6mllawDyQsygAgDWn/4WvZuGD4r/CnbjPafK/IHfebjj9HqiwHXP2Ez8jXaN9yxjggerm/FqQv+E7v8jf4tfzbOuPk1vj5I7/8AkNsmTp3e3Xe1dnR9Jbp6423RZBNzYHcuXzzZ/wDv31V2TNW1VK1BR+A0zUaokj6xKWUptz/Bn/hMR8BvgB8qOqfl10/2v8ut19j9Pz7uqds4HtDf/TuX2NWTby2DurryvfOY3aPQuyNwVX2WJ3fUVFMIMnTBayKJpfLCJIZNjT386v8A4WwZuKf5N/CHbqteoxPRHY+blj9Hph3B2BQ0ED/QONb7akHJI9PFubgxF8LP9mQ/4SU9c9zYDGy1W/8A4i/I3uvu/HyRxq1VVdc5TsSv2D2vjIHaBmXGU2Jmos9UlWU/7979VhoKa/4SA5z4pV/zx7D6v7w6j643b3luHYVB2J8Veyd64aizmb2TvHqqfK5De+39hJlamopcVu3N7QzTZqCupKJa+npdtVRFTGLI/wBOD2WzuXaPxW+We2e0PiV3IOpO5cVlMfHhe0ek8xndv5vP4pZ8Xgt042fMbbpcgdy7UzdDjc9isvjq1Upa2jFVR1tNJGXglPynf54/8s3bX8of5r4HZPRHef8Ae3Z+6sXS9t9X08W5Yoe8OkpaHMpJi8HvqowBoaiiylBWxRVeAzcS0UtfTL5BFHNA7yb/AF/wm7/mH9y/zGf5d0W+/kDN/HO2+ke2NwfH7dHYPhhp5uzods7O2HvLA7yy8EASGLdEuB33T0eUZEVaqrpGq7K1S0af/9Tf49+9stVt7D1X8bk+xp6Wt3DjlxeXytBFHRZeto4YKqnpI5snAiVkhx8dbL9uWc+AyMUtc3D3ovojqX409W7V6Y6P2Rhuvut9m0bUmE27hYWWMSTyvUV+TyNZO81dmM5l62R6itrqqSaqq6iRpJZGdifeq7/wrCUfwL4Lv6gf7z98L9WKW/gXXJ/RfTqv+frb2J3/AAl53ps3afxK+RS7q3ftXbUlZ8k5mpYc/uLDYeonjTrfZgMsVNkK2nnaBmBCyadDlGAJKMF2Z/8ATN0+fp2t1qf/ACetr/8A109oXsz5Y/Gbp3Y24OyOye9+qtrbM2xQz1+XzFZvbAT6I4InlFLQ0FDXVWSy+VqtGino6SGerqZSEijdyFPy3MHLRdn/ACx23VdZ7Rq8bi+yPldtrJ9d7EpImmrsfit1d14/Jba21T06KGaopcfVxx+MC6FdNuPf02f5iXQfZnyo+DXyo+NvTuZ2jt/sjvTpfefVm2czv3JZrD7OoJd6Y5sFkpdwZLbu3d2Zumx7YasqFY02OqpGZgukAlloG/4Tz/yIPlj/ACme9u/u1Pkd2B8cN64vtHqXC9fbXi6U3d2buPM4+vo940W48hJmYd9dRdb0VNjKimoYwrwT1MplQAxqvq91IfNn/hIf86e6/mB8mu5+h+4vhtt/qDt7vHsvtLYO3d+b67owO69t4LsLdeT3dFtzK4nbPx73XgqP+79RmZKOAU+Rq1amgjZn1lgNiD+ZX/J27O+RX8n7oz+WX8Sdz9SbTyvTtT0JjTuLt/L7t23tbK4DqbbGUoNwZY1uy9idgZlt07o3NPFXuGoEileeod5UbSrwP+E8P8pD5H/ylOovkbsH5G716R3rme3+x9n7w21U9J7j33uPGUOM2/titwtZBnJt9dbdb1VNXy1VSGiWnhqY2jBLOrek25fPLozenyd+FHyw+OPXVftfFb773+PfbXUW08pvWty2N2ljc72FsnM7Vx9fuKvwWG3FmaTE0k+UEkz01BVzKinTE59J1bf5FX/Ccv5p/wAsj52Unyg+QHZ/xZ3fsWi6i7E2LBien969sZ/dy7g3e+CTH1f2G9ej9hYcYuGloKhZpBkBOpdAsbgtbdE9/PE+UX/CM75Xbh7L33vP46/K343Z/A7x7D3ZuWhwHbOF7M6qn27t3P5StzGPx6VWyts9zU+Tr8W9YKQqIqSKSOITBlLeBRF+Gn/CLzeGP33tvc/z1+TfX+W2NhcqtfnOqPjZDvLJT71pKKspJqXC1fam+9vbAyG2cXl4Eljr2o8DLWrEdFNUwystTDvubb25gdnbdwG0dq4jH7f2xtbC4rbm3MDiqaOjxeEwODoYMZh8RjaOFVhpMfjcfSxwwxoAscaBQLD3rL/8KK/5Kvyu/m6Z74mV/wAb9+/HrZFB0JiO6KTdX+m7dfZG3KzJ1nZdZ1hNijt+PYnVHZUFVTUUGxJ/uDUvSOrypoEgLFLDv5IPwC7a/lo/APZXxY7v3F1tursbA7/7M3dmM11Pl9y5zZdRTby3LNlMTHRZHd2zdh52Wrp8YIkqBLj0VJVIR3QA+7dPepr/AMKF/wCRb8zv5tXfnQvYfx57I+NezNi9R9QZTZmQoO6t7dpbez9Vu3ObzymbydZi8bsfprsbFPhzho8egnlrIah50dTCEjR5LDf5BH8tDur+VV8Kt4fHPvvcvUm7N+7o+Q+9+4GzHTOc3huDasmG3JsTq/aOOhrK/e2xevcuM7A2w5BLGtA0CweErM7F1S733rJf8KLP5Nny4/m6v8Scf8bt/wDx82Ngug07trN3x92bt7I23VZrL9mHqqHBvgodidT9kwVVPiKPYVWJWqJKRlarAVZASUHn/hPf/Kw+Qf8AKd+Mfc/S/wAit49N703T2L3vUdoYSv6V3DvbceApNvzdfbJ2otHlKrfXXvXORgzAyO253McNLPD4XjPl1FkXWg7s/wCEgn8wWP5R9n9r/Frvz4f7F63/ANN26Oxug13F2F3htbsHYm2n3pV7o68o8hSbX+Pe5sLi9ybNpGpoRJRZCohM1KJY2UEIv0FOqV7MTrDrtO6Rs8dwR7I2tH2meva7K5PYb9hx4SiTeUuy6/OYTbWaq9rS7hWoagerx9HUGlKeSGN7qNKX+b7/AMJ3/wCbV/NG+bvZHyUq+7vhPt7raOOj2F0PsLcXbXfkuR2P1BteSqGAosjT474xVuMotxbmyNZWZ3Lw09RVwQZTKTwxVNRBFFIdmr+UV/L7x38sz4IdP/FuSr2/muwMVDkt6917s2vLX1OC3b3DvGaKs3bk8PW5TFYHKZDA4iCnpMNi6iqoaOqlxOLpWmgjlLqF7/M7+HTfPv4F/Jj4m0U22aLdHbHXdTS9e5beMmRpts4TtDbWQx+7+tMxna7D43M5nG4ah3vgKFqyopKOsqI6TylKef8AzMmpl/Kf/wCE13807+W988+iPldN3d8KsxsvZmayGC7Y2vtXtDveTObr6o3li6vbu9cTjKHLfGnE4jJ5ijoa5cjjaerq6WnfKUFMXnhA8qb3/v55nzf/AOEnf8y/5S/Mr5WfJHAd4fCOh213t8iO5O19qY3c3Y3etFuLE7R312Bn9xbTxGdo8R8a8vi6bMYfblfS01QlPV1cSyxMFnmAEjFhg/4RgfzPWqIVqe/fgbBStNGKiWn7K+QdRPFTlwJZIaeT4xUsdRMkZJVGljDMANag3F9n8rP/AISgdE/CzuLbHyM+UnbsHyp7L6+zMe4Os9iY/ZQ2l09tPcePnSbCbvzuPy+V3Bm9/bkwlRClXj1mOPx9DVWd6arlihmTbl96yn/Civ8Ak2fLb+bofiPQfG3sH4+7GwvQf+nCr3jF3bursbbdRmcp2Z/oohwEmATYnVPZUVXDiqTYdYJjUNRMjVS6RKGPj1lP+gML+aH/AM/4+A/0t/zND5Dfj/X+LVhz7Fbof/hHv/Mk627y6Z7F3b3b8GchtXYXa/XW9dzUGG7I78rMxW7f2ru/D5zM0mJpK741YqhqsnUY6hlSCOaqponlZVeWNSXX6QHvT3/4UAfyBfnB/Nf+YvXnfPQvZ3xc2Z1xsL477T6igwvcG9+2cDuqfcmK7B7P3nm8wuP2X0n2Dhxjaun3vSQRP9+JWNIdUSWBe3T+VT/LS3p8RP5U+L/l5fKXLddb6yeWxHyC2j2LV9VZXcWd2Tltn937o3tVVFBjchvPZ2y8xPOdr7s8FQs+LjjWfWqmVAHbVB+NX/CUb+bl8R/kx1D8k+n/AJE/BKTdHR/aO3+wNpy5Ds35DYV8/SbdzCVE2E3BSUHxoyq0mN3fgxLj8nSx1FShpKuaHySqdTfRPiMpijMyRxzGNDLHFI00SSlQZEjleKBpY1a4DFELDnSPp70/P523/CZ7t3+ZV8s93fL/AKM+R/Vmw9x7q672Xtqr617P2juqgxVRuPYuJh29Q5CfsLaT7qrYqDLYenhWRv4BNLSGnCqs6veOoXp//hFd80spuqnh7++WHxe2JshJ6F6vJdPJ2v2vuqop/vIxk4KbC70686YxNHOtBqaCVshOpmsHjC3Pve5+BXwa6O/l0/GPYXxY6AoMnHsvZgr8lk9w7iqKeu3dvzeWdnFZuffO78hS01FTVWdzlWFGmGGGmpKSGClp446enijX/9Xf49+9+9+96tH/AApk+OPyJ+QmF+G0HQPQ/bXd021Nxd0VG6o+rdk5feLbbp8ththQ4qXNrioZTj0yctHMsBksJGhcDlfeqNL/AC0v5iE5Bl+BHy0kKgqCek94gBb/AEAFGB7xf8Nl/wAwsc/7IL8tP/RJ7y/+pPrb3Ox38r7+Ynka2CmpfgP8pUqXdTDJkuo89iqVHvYM1fl0pKClN2/U8i2F+QAfe1N/Jh/kSbr+NXYGF+W/zQp9uy9wbbimn6a6Zw2Sp9y4vq3JV1NNRVW+t7ZulVsNnOwoqGeSHG01E9RQYhJWnE01YYzSbUPv3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v3v/9bf49+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9+9/wD/2Q==", alignment: 'center',width: 200},
					{text: 'Room No.VIII/238,Vadama P.O., Mala-680 732,Thrissur,Kerala', fontSize: 10,  alignment: 'center' }, 
					{text: 'Email : mstraders2k18@gmail.com , www.mstraders.net.in', fontSize: 10,   alignment: 'center' },
					{ text: 'Mobile Phone: +91-7593927218 |  +91-7909178767', fontSize: 10,   alignment: 'center' },
					 {
			style: 'tableExample',
			table: {
				 
				widths: [400,80],
				body: [
					[{text: ' Date: '+document.getElementById("tranDatePrint").innerHTML ,fontSize: 10,margin: [ 20,10,3,0]}, {text: ' Amount : '+document.getElementById("amtPrint").innerHTML ,fontSize: 10 }],
					
				
				
				]
			},
				layout: 'noBorders'
		},
				    //~ {text: ' Date: '+document.getElementById("tranDatePrint").innerHTML ,fontSize: 10 },					
					//~ {text: ' Amount : '+document.getElementById("amtPrint").innerHTML ,fontSize: 10, alignment: 'right' },						
				    {text: 'Receiver From :   '+document.getElementById("partyNamePrint").innerHTML , fontSize: 10,margin: [ 20,10,3,0] }, 
				    { canvas: [{ type: 'line', x1: 85, y1: 2, x2: 470, y2: 2, lineWidth: 0.5 }] },
				    {width: '85%', text: 'Amount in words : '+inWords(parseInt($('#nettAmtPrint').text()))+' Rupees only ', fontSize: 10, margin: [ 20,10,3,0] },
				      { canvas: [{ type: 'line', x1: 100, y1: 2, x2: 470, y2: 2, lineWidth: 0.5 }] },
					
				    { width: '85%', text: 'For:   '+document.getElementById("remarkPrint").innerHTML , fontSize: 10, margin: [ 20,10,3,0]},
				    { canvas: [{ type: 'line', x1: 35, y1: 2, x2: 470, y2: 2, lineWidth: 0.5 }] },
				    {width: 80, text: '   ', fontSize: 10, bold: true},
				    					   
					
					 {
			style: 'tableExample',
			
			table: {
				 
				widths: [180,180],
				
				body: [
					['Opening Balance:', {  text:document.getElementById("custbaln").innerHTML.trim()}],
					['This Receipt :', { text:document.getElementById("amtPrint").innerHTML.trim() }],
						['Balance Due :', {  text:document.getElementById("diff").innerHTML.trim() }],
				
				
				]
			},
			margin: [ 20,10,3,0]
		},	
		{ text: '', fontSize: 10, bold: true},			
		{ width: '25%', text: 'Payment Mode: '+document.getElementById("tranModPrint").innerHTML ,fontSize: 10, margin: [ 20,10,3,0] },
		{ text: '', fontSize: 10, bold: true},	
		  
		{
			style: 'tableExample',
			table: {
				 
				widths: [370,100],
				body: [
					[ {  text: 'FOR MS TRADERS', bold: true, fontSize: 10,margin: [ 2,10,3,0] },{  text: 'Payers Signature ' ,fontSize: 10 }],
					
				
				
				]
			},
				layout: 'noBorders'
		},       
				   
				   
					]},		   
				 ],
	  
			  ]			 
			}
		},
		
                                  
                                       //~ {
                                        //~ columns: [
                                                   

                                                    //~ [
									
                                                    //~ { text: 'Room No.VIII/238,Vadama P.O., Mala-680 732,Thrissur,Kerala ', fontSize: 12, bold: true, margin: [ 80,0,3,1] },
                                                    //~ { text: 'Email : mstraders2k18@gmail.com , www.mstraders.net.in ', fontSize: 12, bold: true, margin: [ 80,0,3,1] },
                                                     //~ { text: 'Mobile Phone: +91-7593927218 |  +91-7909178767 ', fontSize: 12, bold: true, margin: [ 80,0,3,0] }
                                                    //~ ]
                                                     
                                             //~ ]
                            
                            //~ },
                                       
                               	
                                      
                                       
                          
                            //~ { columns: [
                                           
                                            //~ {text: ' Date: '+document.getElementById("tranDatePrint").innerHTML ,fontSize: 10, alignment: 'right', margin: [ 3,15,23,0] }  ],
                             //~ // optional space between columns
                            
                                                  //~ columnGap: 10
                                                //~ },
                                            
                            //~ { columns: [
                                            
                                            //~ {text: ' Amount : '+document.getElementById("amtPrint").innerHTML + '',fontSize: 10, alignment: 'right', margin: [ 3,10,23,0] }  ],
                             //~ // optional space between columns
                                                  //~ columnGap: 10
                                                //~ },
                            
                                          //~ {  text: 'Receiver From :   '+document.getElementById("partyNamePrint").innerHTML, fontSize: 10, margin: [ 3,10,3,0] },
                                         
                                         //~ { columns: [
                                            //~ { width: '85%', text: 'Amount in words : '+inWords(parseInt($('#nettAmtPrint').text()))+' Rupees only ', fontSize: 10, margin: [ 3,10,3,0] }
                                             
                                             //~ ],
                             //~ // optional space between columns
                                                  //~ columnGap: 10
                                                //~ },
                                         //~ { columns: [
                                            //~ { width: '85%', text: 'For:   '+document.getElementById("remarkPrint").innerHTML, fontSize: 10, margin: [ 3,10,3,0] }
                                             
                                             //~ ],
                             //~ // optional space between columns
                                                  //~ columnGap: 10
                                                //~ },
                                                
                                         //~ { columns: [
                                            //~ { width: '85%', text: 'Opening Balance:'+document.getElementById("custbaln").innerHTML, fontSize: 10, margin: [ 3,10,3,0] }
                                             
                                             //~ ],
                             //~ // optional space between columns
                                                  //~ columnGap: 10
                                                //~ },
                                                 
                                                 //~ { columns: [
                                            //~ { width: '85%', text: 'This Receipt  : '+document.getElementById("amtPrint").innerHTML, fontSize: 10, margin: [ 3,10,3,0] }
                                             
                                             //~ ],
                             //~ // optional space between columns
                                                  //~ columnGap: 10
                                                //~ },
                                                 //~ { columns: [
                                            //~ { width: '85%', text: 'Balance Due : '+document.getElementById("diff").innerHTML, fontSize: 10, margin: [ 3,10,3,0] }
                                             
                                             //~ ],
                             //~ // optional space between columns
                                                  //~ columnGap: 10
                                                //~ },
                                                 //~ { columns: [
                                            //~ { width: '85%', text: 'Payment Mode: '+document.getElementById("tranModPrint").innerHTML, fontSize: 10, margin: [ 3,10,3,0] }
                                             
                                             //~ ],
                             //~ // optional space between columns
                                                  //~ columnGap: 10
                                                //~ },
                                         
                                          
                            
                                   
                                         
                               
                 ]
            });
    }
</script>
