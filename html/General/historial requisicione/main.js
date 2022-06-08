$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    GetRequisition();



  $('#Logout').click(function () {
    CloseSession()
    });
})

function GetRequisition() {
  
    $.post('main.php', {
        action: 'GetRequisition'
      }, function (e) {
        if (!e.error) {
          console.log(e.r);
        $('#tbRequis').DataTable({
          pagingType: 'full_numbers',
          data: e.r,
           columns: [
            { data: 'ID_Requisition'},
            { data: 'ID_UserDelivery'},
            { data: 'ID_UserReceives'},
            { data: 'InitialFolio'},
            { data: 'FinalFolio'},
            { data: 'Quantity'},
            { data: 'ID_Supplier'},
            { data: 'Date'},
            { "data": null,
            "className": "button",
              "defaultContent": '<button class="btn btn-outline-success btn-rounded waves-effect"><i class="fas fa-print"></i></button>'
          }] 
        }); 
        }
      });
      return false;
  }