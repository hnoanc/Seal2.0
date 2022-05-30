
$(document).ready(function () {
    $('#navbarNav').load('../../navMenu.html');
    GetUsersForReceiveFromSecurity();
    LoadSecuritySeals(); /* <---- Test de tabla*/ 
    
    $('select').select2({
      width: "100%"
    });

 /*   $('#Logout').click(function () {
      CloseSession()
      });*/
})

function GetUsersForReceiveFromSecurity() {
    $.post('main.php', {
      action: 'GetUsersForReceiveFromSecurity'
    }, function (e) {
      if (!e.error) {
        var $select = $('#cbxUser');
        for (let i = 0; i < e.r.length; i++) {
            $select.append('<option value=' + e.r[i].Value + '>' + e.r[i].Display + '</option>');
        }
      }
      
    });
    return false;
}

function LoadSecuritySeals() {
  $.post('main.php', {
      action: 'LoadSecuritySeals'
    }, function (e) {
      if (!e.error) {
        console.log(e)
      $('#tbSeals').DataTable({
        pagingType: 'full_numbers',
        data: e.r,

        columns: [
          { title: "No. Sello" },
          { title: "Fuente" },
          { title: "Color" },
          { title: "Proveedor" },
          { title: "Requisicion" },
          { title: "Viaje" },
          { title: "Status" }
      ]
    });
  }
 });
return false;
}