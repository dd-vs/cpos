function notify(type, message) {
              switch(type) {
                  case "success":
                       $("#notify").css("background","rgba(91, 208, 117, 0.90)");
                      break;
                  case "warning":
                      $("#notify").css("background","rgba(234, 171, 89, 0.9)");
                      break;
                  case "danger":
                      $("#notify").css("background","rgba(199, 51, 51, 0.9)");
                      break;
                         }
              $("#notify").text(message);
              $("#notify").fadeIn(500);
              setTimeout(function() {$("#notify").fadeOut(500);},3000);
           };

function round(value, decimals) {
						return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
						};

function notifyPopup(content){
    $("#notifyPop").text(content);
    $("#notifyPop").fadeIn(100);
    setTimeout(function() {$("#notifyPop").fadeOut(200);},2000);
};