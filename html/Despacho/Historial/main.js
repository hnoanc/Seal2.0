$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    LoadSecuritySeals();
    /*LoadUsersInfo();
    /*GetUserInfo();
    GetDepartments();
  /*  GetRoles();*/

  $('#Logout').click(function () {
    CloseSession()
    });
})

function LoadSecuritySeals() {
  
    $.post('main.php', {
        action: 'LoadSecuritySeals'
      }, function (e) {
        if (!e.error) {
          console.log(e.r);
  
        $('#tbUser').DataTable({
          pagingType: 'full_numbers',
          data: e.r,
          dom: 'Blfrtip',
  
          columns: [
            { title: 'Viaje'},
            { title: 'Tracto'},
            { title: 'Remolque'},
            { title: 'Operador'},
            { title: 'Fecha'},
            { title: 'id'},
            { title: 'test'}],
            buttons:[
              {
                extends: 'copyHtml5',
                text: '<i class="fas fa-copy"></i> copy',
                titleAttr: 'Copy'
              },
              {
                extends: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
              },
              {
                extends: 'cvsHtml5',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
              },
              {
                extends: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
              },
              {
              extends: 'print',
              text: '<i class="fas fa-print"></i> Print',
              titleAttr: 'Print'
             },
        ], 
        }); 
        }
      });
      return false;
  }