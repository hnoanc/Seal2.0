$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    GetUsersWithOutAccess();
    GetDepartments();
    LoadUsersInfo();

    
    $('#btnUsr').click(function () {
      CloseSession()
      });

      $('#btnUsr').click(function (){
        AddUser();
      })
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
                "defaultContent": '<button type="button" name="BtnEd" class="btn btn-icon-toggle" data-toggle="modal" data-target="#ModUs" ><i class="fas fa-edit"></i></button>'}
              ]
            });

            $("#tbUser tbody").on('click','button', function(){

           var currentRow = $(this).closest("tr");

           var UserId = currentRow.find("td:eq(0)").text();
           var UserName = currentRow.find("td:eq(1)").text();
           var UsDep = currentRow.find("td:eq(2)").text();
         

          $('#UserIDPass').val(UserId);
          $('#CB_User').val(UserName);
          
          $("#select1").change(function(){
            $('#cbDepM').val(UsDep);
          })

          

            })
        }
    });
    return
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

        var $select = $('#cbDepM');
        for(let j = 0; j <e.r.length; j++){
          $select.append('<option value=' + e.r[j].value + '>' + e.r[j].Display + '</option>');
        }
      }
      
    });
    return false;
  }

 /* 
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
}*/

function AddUser(){
  var data = { 
    'Role':$('#CB_Roll').val(),
    'User':$('#CB_User').val()
  };

  $.post('main.php',{
    action: 'AddUser',
    Data: data
  }, function(e){
    if (!e.error){
      Swal.fire({
        icon: 'success',
        title: 'Logrado',
        text: 'El usuario se agrego'
      })
    }
  });
}

function GetUsersWithOutAccess(){
  $.post('main.php', {
    action: 'GetUsersWithOutAccess'
  }, function(e){
    if (!e.error){
      var $select = $('#cbxUser');
        for (let i = 0; i < e.r.length; i++) {
            $select.append('<option value=' + e.r[i].Value + '>' + e.r[i].Display + '</option>');
        }
    }
  });
  return
}
