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
      $('#btnUpdate').click(function (){
        UpdateUser();
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
                    {title: "Estatus"},
                    {"data": null,
                "className": "button",
                "defaultContent": '<button type="button" name="BtnEd" class="btn btn-icon-toggle" data-toggle="modal" data-target="#ModUs" ><i class="fas fa-edit"></i></button>'}
              ]
            });

           $("#tbUser tbody").on('click','button', function(){

           var currentRow = $(this).closest("tr");
           var UserId = currentRow.find("td:eq(0)").text();
           var UserName = currentRow.find("td:eq(1)").text();
         /*var UsDep = currentRow.find("td:eq(2)").text();*/
           var UsStat = currentRow.find("td:eq(7)").text();
         
          $('#UserIDPass').val(UserId);
          $('#CB_User').val(UserName);
          
          if(UsStat == 'Activo'){
            $('#rAc').attr('checked', 'checked');
          }else{
            $('#rIn').attr('checked', 'checked');
          }
          /*$('#cbDepM').val(UsDep); no funciona*/ 
            })
        }
    });
    return
}

function UpdateUser(){

let status = $('input[type=radio]:checked').val()
var data ={
  'Name':$('#CB_User').val(),
   'ID':$('#UserIDPass').val(),
   'Status': status
 };
 $.post('main.php', {
   action: 'UpdateUser',
   Data:data
 }, function (e){
   Swal.fire({
     icon: 'success',
     title: 'Logrado',
     text: 'Se ha actualizado el usuario'
   })
   LoadUsersInfo();
 })
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

        var $select = $('#cbDepM');
        for(let j = 0; j <e.r.length; j++){
          $select.append('<option value=' + e.r[j].value + '>' + e.r[j].Display + '</option>');
        }
      }
      
    });
    return false;
  }

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
