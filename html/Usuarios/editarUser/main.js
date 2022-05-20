var editor; 

$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    /*LoadSecuritySeals();*/
    LoadUsersInfo();
    GetUserInfo();
    GetDepartments();
  /*  GetRoles();*/
   


 /* $('select').select({
         with:"100%"
     });   */
})

function LoadUsersInfo() {
  
  $.post('main.php', {
      action: 'LoadUsersInfo'
    }, function (e) {
      if (!e.error) {
        console.log(e.r);

      $('#tbUser').DataTable({
        pagingType: 'full_numbers',
        data: e.r,

        columns: [
          { name: "ID",title: "ID"},
          { title: "Nombre"},
          { title: "Rol"},
          { title: "Departamento"},
          { title: "Correo"},
          { title: "Extencion"},
          { title: "Oficina"},
          {title: "Estado"},
          {"data": null,
          "className": "button",
          "defaultContent": '<button type="button" name="BtnEd" class="btn btn-icon-toggle" Onclick="GetUserInfo()" data-toggle="modal" data-target="#ModUs"><i class="fas fa-edit"></i></button>'}
      
         ,
        ]         
                                                                                 /*onclick="GetUserInfo('+e.r[i][0]+')"*/ 
                 
      }); 


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
      $('#UserIDPass').val(e.r[0][0]);
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

function GetDepartments() {
  $.post('main.php', {
    action: 'GetDepartments'
  }, function (e) {
    if (!e.error) {
      var $select = $('#CB_Roll');
      for (let i = 0; i < e.r.length; i++) {
          $select.append('<option value=' + e.r[i].Value + '>' + e.r[i].Display + '</option>');
      }
    }
    
  });
  return false;
}


