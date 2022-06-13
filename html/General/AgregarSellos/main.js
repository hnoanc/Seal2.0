$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');

    LoadUsersInfo();

    $('#Logout').click(function () {
        CloseSession()
        });

    $('#btnSv').click(function () {
        CloseSession()
        });
})

function GuardarSellos(){
    var data = {
        'NoSello': $('#txtNoSello').val(),
        'txtColor': $('#txtColor').val(),
        'taxRef': $('#taxRef').val()
    };
  
    //if (Validar()) {
        $.post('main.php', {
            action: 'SaveSeals',
            Data: data
        }, function(e) {
            if (!e.error) {
                alert('asdasd')
            }
        });
    //}
}


function LoadUsersInfo(){
  
    $.post('main.php', {
        action: 'LoadUsersInfo'
    }, function (e){
        if (!e.error){
            console.log(e.r);
            $('#tbSeals').DataTable({
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