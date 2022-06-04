
$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    /*LoadSecuritySeals();*/
    LoadUsersInfo();
    GetUserInfo();
    GetDepartments();

    $('#Logout').click(function () {
      CloseSession()
      });

})

function LoadUsersInfo() {

  var table = document.getElementById("tbUser");
  $.post('main.php', {
      action: 'LoadUsersInfo'
    }, function (e) {
      if (!e.error) {
        console.log(e.r);

      $('#tbUser').DataTable({
        pagingType: 'full_numbers',
        data: e.r,

        columns: [
          { name: "id",title: "ID"},
          { title: "Nombre"},
          { title: "Rol"},
          { title: "Departamento"},
          { title: "Correo"},
          { title: "Extencion"},
          { title: "Oficina"},
          {title: "Estado"},      
         , 
          
        ]              
                                                              
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


