$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    /*LoadSecuritySeals();*/
    /*LoadUsersInfo();
    GetUserInfo();
    GetDepartments();
  /*  GetRoles();*/
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
            { title: "Vijae"},
            { title: "Tracto"},
            { title: "Remolque"},
            { title: "Operador"},
            { title: "Fecha"},
            { title: "Control"},
            {"data": null,
            "className": "button",
            "defaultContent": '<button type="button" name="BtnEd" class="btn btn-icon-toggle" Onclick="GetUserInfo()" data-toggle="modal" data-target="#ModUs"><i class="fas fa-edit"></i></button>'}
        
           ,
          ] 
        }); 
        }
      });
      return false;
  }