$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    LoadUsersInfo();
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