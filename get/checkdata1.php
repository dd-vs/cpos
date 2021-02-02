   <?php

include("../include/include.php");
if(isset($_GET['q']) && $_GET['q']=='get2')
    {
$name=isset($_POST['uname']) ? $_POST['uname']:'';
$echeck="select count(uname) as ecount from ti_user where uname='$name'";
  $r1=$conn->query($echeck);
$r1->setfetchmode(PDO::FETCH_ASSOC);
while($ss=$r1->fetch())
{
  
  if($ss['ecount']!=0)
    {
          echo "name already exists";
    }}}
    else if(isset($_GET['p']) && $_GET['p']=='get1')
    {
$sku=isset($_POST['uname']) ? $_POST['uname']:'';

$echeck1="select count(item_code) as code from ti_product where item_code='$sku'";
  $r11=$conn->query($echeck1);
$r11->setfetchmode(PDO::FETCH_ASSOC);
while($s=$r11->fetch())
{
  
  if($s['code']!=0)
    {
          echo "code already exists";
    }
    else
    echo 1;
    
    }   }
