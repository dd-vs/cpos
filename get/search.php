<?php
include("../include/include.php");

if(isset($_GET['p']) && $_GET['p']=='get1'){
if (isset($_GET['term'])){
	$return_arr = array();

	    
	    $stmt = $conn->prepare('SELECT id,name FROM ti_product WHERE name LIKE :term and IsActive=1');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
	    
	    while($row = $stmt->fetch()) {
	        $return_arr[] =  array('id'=>$row['id'],'value'=>$row['name']);
	        
	        
	    }

	


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
    
}
}
if(isset($_GET['p']) && $_GET['p']=='getallow'){
if (isset($_GET['term'])){
	$return_arr = array();

	    
	    $stmt = $conn->prepare('SELECT id,allowance_name FROM master_allowance WHERE allowance_name LIKE :term and IsActive=1');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
	    
	    while($row = $stmt->fetch()) {
	        $return_arr[] =  array('id'=>$row['id'],'value'=>$row['allowance_name']);
	        
	        
	    }

	


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
    
}
}
if(isset($_GET['p']) && $_GET['p']=='getdeduct'){
if (isset($_GET['term'])){
	$return_arr = array();

	    
	    $stmt = $conn->prepare('SELECT id,deduction_name FROM master_deduction WHERE deduction_name LIKE :term and IsActive=1');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
	    
	    while($row = $stmt->fetch()) {
	        $return_arr[] =  array('id'=>$row['id'],'value'=>$row['name']);
	        
	        
	    }

	


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
    
}
}
if(isset($_GET['p']) && $_GET['p']=='get12'){
if (isset($_GET['term'])){
	$return_arr = array();

	    
	    $stmt = $conn->prepare('SELECT id,item_code FROM ti_product WHERE item_code LIKE :term and IsActive=1');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
	    
	    while($row = $stmt->fetch()) {
	        $return_arr[] =  array('id'=>$row['id'],'value'=>$row['item_code']);
	        
	        
	    }

	


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
    
}
}
if(isset($_GET['p']) && $_GET['p']=='get'){
	
if (isset($_GET['term'])){
	$return_arr = array();

	    
	    $stmt = $conn->prepare('SELECT id,name FROM ti_suppllier WHERE name LIKE :term  and id>1 and IsActive=1');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
	    
	    while($row = $stmt->fetch()) {
	        $return_arr[] =  array('id'=>$row['id'],'value'=>$row['name']);
	        
	        
	    }

	


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
    
}

}
  if(isset($_GET['q']) && $_GET['q']=='getitem') {
if (isset($_GET['term'])){
$return_arr = array();

      
      $stmt = $conn->prepare('SELECT id,name FROM ti_customer WHERE name LIKE :term and id>1 and IsActive=1');
      $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
      
      while($row = $stmt->fetch()) {
              $return_arr[] =   array('id'=>$row['id'],'value'=>$row['name']);
              
              
      }
        echo json_encode($return_arr);
}}


  if(isset($_GET['p']) && $_GET['p']=='getsinv') {
	  if (isset($_GET['term'])){
$return_arr = array();

      
      $stmt = $conn->prepare('SELECT invoice_id,invoice_num FROM ti_sale_invoice WHERE invoice_num LIKE :term and IsActive=1 ');
      $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
      
      while($row = $stmt->fetch()) {
              $return_arr[] =   array('id'=>$row['invoice_id'],'value'=>$row['invoice_num']);
              
              
      }
        echo json_encode($return_arr);
}
}

  if(isset($_GET['p']) && $_GET['p']=='getpinv') {
	  if (isset($_GET['term'])){
$return_arr = array();

      
      $stmt = $conn->prepare('SELECT invoice_id,invoice_num FROM ti_purchase_invoice WHERE invoice_id LIKE :term and IsActive=1');
      $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
      
      while($row = $stmt->fetch()) {
              $return_arr[] =   array('value'=>$row['invoice_id']);
              
              
      }
        echo json_encode($return_arr);
}
}
  if(isset($_GET['p']) && $_GET['p']=='gethsn') {
	  if (isset($_GET['term'])){
$return_arr = array();

      
      $stmt = $conn->prepare('SELECT item_code FROM ti_product WHERE item_code LIKE :term and IsActive=1');
      $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
      
      while($row = $stmt->fetch()) {
              $return_arr[] =   array('value'=>$row['item_code']);
              
              
      }
        echo json_encode($return_arr);
}
}
if(isset($_GET['e']) && $_GET['e']=='getemp'){

if (isset($_GET['term'])){
$return_arr = array();

      
      $stmt = $conn->prepare('SELECT id,name FROM ti_employee WHERE name LIKE :term   and IsActive=1');
      $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
      
      while($row = $stmt->fetch()) {
              $return_arr[] =   array('id'=>$row['id'],'value'=>$row['name']);
              
              
      }




      /* Toss back results as json encoded array. */
      echo json_encode($return_arr);
      
}

}


?>
