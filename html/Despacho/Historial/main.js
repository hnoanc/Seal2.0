$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    LoadSecuritySeals();
    /*LoadUsersInfo();
    /*GetUserInfo();
    GetDepartments();
  /*  GetRoles();*/
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
  
          columns: [
            { title: "Vijae"},
            { title: "Tracto"},
            { title: "Remolque"},
            { title: "Operador"},
            { title: "Fecha"},
            { title: "Control"},
            {"data": null,
            "className": "button",
            "defaultContent": '<button type="button" name="BtnEd" class="btn btn-icon-toggle" Onclick="GetUserInfo()" data-toggle="modal" data-target="#ModUs"><i class="fas fa-eye"></i></button>'}
        
           ,
          ] 
        }); 
        }
      });
      return false;
  }