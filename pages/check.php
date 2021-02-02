<!DOCTYPE html>
<html>
      <head>
              <meta charset="UTF-8">
              <title>Example Ajax PHP Form</title>
      </head>
      <body>
              
              <form id="my_form_id">
                      Your Email Address: <input type="text" id="email" /><br>
                      <input type="submit" />
              </form>
              
              <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
              <script>
                      $(document).ready(function(){
                              $('#my_form_id').on('submit', function(e){
								  
                                      //Stop the form from submitting itself to the server.
                                      e.preventDefault();
                                      var email = $('#email').val();
                                      $.ajax({
                                              type: "POST",
                                              url: 'submission.php',
                                              data: {email: email},
                                              success: function(data){
												  alert("Sdgfsg");
                                                      alert(data);
                                              }
                                      });
                              });
                      });
              </script>
      </body>
</html>
