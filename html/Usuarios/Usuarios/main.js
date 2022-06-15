$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    LoadUsersInfo();
    GetDepartments();

    $('#btnUsr').click(function () {
      CloseSession()
      });
    
    GetUsersForReceiveSeals();
    $('select').select2(); 
})

function LoadUsersInfo(){
  
    $.post('main.php', {
        action: 'LoadUsersInfo'
    }, function (e){
        if (!e.error){
            console.log(e.r);
            $('#tbUser').DataTable({
                paginType: 'full_numbers',
                data: e.r,
                "lengthChange": false,

                columns: [
                    {title: "ID"},
                    {title: "Nombre"},
                    {title: "Rol"},
                    {title: "Departamento"},
                    {title: "Correo"},
                    {title: "Extencion"},
                    {title: "Oficina"},
                    {"data": null,
                "className": "button",
                "defaultContent": '<button type="button" name="BtnEd" class="btn btn-icon-toggle" data-toggle="modal" data-target="#ModUs"><i class="fas fa-edit"></i></button>'}                ]
            });

            var table = $('#tbUser').DataTable();

            $("#tbUser").on('click','#BtnEd', function(){
              let data= table.row($(this).parents('tr')).data();
              $("#UserIDPass").val(data[0])
            })
        }
    });
    return
}


function GetUsersForReceiveSeals() {
    $.post('main.php', {
      action: 'GetUsersForReceiveSeals'
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

  function GetDepartments() {
    $.post('main.php', {
      action: 'GetDepartments'
    }, function (e) {
      if (!e.error) {
        var $select = $('#cbDep');
        for (let i = 0; i < e.r.length; i++) {
            $select.append('<option value=' + e.r[i].Value + '>' + e.r[i].Display + '</option>');
        }
      }
      
    });
    return false;
  }

  
function GetUserInfo(id) {

  var Data = {
    'ID': id
  };

  $.post('main.php', {
    action: 'GetUserInfo',
    Data: Data
  }, function (e) {
    if (!e.error) {
      $('#UserIDPass').val([0][0]);
      $('#UserPass').val(e.r[0][1]);
      $('#CB_Roll').val(e.r[0][2]);
      $('#CB_Roll').trigger('change');
      if(e.r[0][3]==1){
        $('input[value=1]').attr('checked', 'checked');
      }
      else{
       $('input[value=0]').attr('checked', 'checked');
      }
    }
  });
}
