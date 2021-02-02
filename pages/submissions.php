 <?php  $emailAddress = false;
if(isset($_POST['email'])){
      $emailAddress = $_POST['email'];
}

echo 'Received email was: ' . $emailAddress;
