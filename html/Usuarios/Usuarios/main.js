$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    LoadUsersInfo();
    GetUsersForReceiveSeals();
    $('select').select2(); 
})

function LoadUsersInfo(){
    var table = document.getElementById("tbUser");
    $.post('main.php', {
        action: 'LoadUsersInfo'
    }, function (e){
        if (!e.error){
            console.log(e.r);
            $('#tbUser').DataTable({
                paginType: 'full_numbers',
                data: e.r,

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
                "defaultContent": '<button type="button" name="BtnEd" class="btn btn-icon-toggle" Onclick="GetUserInfo(+e.r[i][0]+)" data-toggle="modal" data-target="#ModUs"><i class="fas fa-edit"></i></button>'}
                ]
            });
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