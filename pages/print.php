<html>
<head>
<script type="text/javascript">
  function openWin()
  {
    var myWindow=window.open('','','width=200,height=100');
    myWindow.document.write("<p>This is 'myWindow'</p>");
    
    myWindow.document.close();
myWindow.focus();
myWindow.print();
myWindow.close();
    
  }
</script>
</head>
<body>

<input type="button" value="Open window" onclick="openWin()" />

</body>
</html>
https://stackoverflow.com/questions/40674532/how-to-display-base64-encoded-pdf
https://stackoverflow.com/questions/45493234/jspdf-not-allowed-to-navigate-top-frame-to-data-url
https://stackoverflow.com/questions/37660416/images-pdfmake
