var timestamp = null;
var audio = new Audio('../../../assets/Notif.mp3');

function WaitForTicket(){
  $.ajax({
    type: "GET",
    url:"../../../assets/js/libs/comet/GetData.php?timestamp=" + timestamp,
    async : true,
    cache : false,

    success: function(data){
      var json = $.parseJSON(data);
      if(json['CurrentUser'] =="5"){
        audio.play();
        //console.log(json);
        $('#Badge').text(json['Count']);
        //console.log(window.location.pathname.split('/')[4]);
        switch (window.location.pathname.split('/')[4]) {
          case "Tickets_Disponibles":
            LoadNewTickets();
          break;
          case "Tickets_Historial":
          GetAllTickets();
          break;
          case "Tickets_Por_Aprovar":
          LoadIncomingTickets();
          break;
          default:
        }
      }
      else {
        $('#ItOnly').remove();
      }
      timestamp = json['timestamp'];

      setTimeout('WaitForTicket()',30);
    },
    error: function(XMLHttpRequest, textStatus, errorThrow){
      setTimeout('WaitForTicket()',25000);
    },
    timeout:25000
  })
};

function GetTicketCount(val){
  $.ajax({
    type: "GET",
    url:"../../../assets/js/libs/comet/WriteData.php?msg="+val,
    async : true,
    cache : false,

    success: function(data){

    },
    error: function(XMLHttpRequest, textStatus, errorThrow){

    }
  })
};
