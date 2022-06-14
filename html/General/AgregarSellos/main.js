$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');

    LoadSealRecycled();

    $('#Logout').click(function () {
        CloseSession()
        });

    $('#btnSv').click(function () {
        let NoSello = $('#txtNoSello').val()
        let Color = $('#txtColor').val()
        let Reference = $('#taxRef').val()

        if(NoSello == '' | Color == '' | Reference== ''){
            alert('Favor de llenar todos los campos')
            
        }else{
            GuardarSellos();
        }
        });
})

function GuardarSellos(){
    var data = {
        'NoSello': $('#txtNoSello').val(),
        'Color': $('#txtColor').val(),
        'Reference': $('#taxRef').val()
    };
  
    //if (Validar()) {
        $.post('main.php', {
            action: 'SaveSeals',
            Data: data
        }, function(e) {
            if (!e.error) {
                console.log("asdasd")
            }
        });
    //}
}


function LoadSealRecycled(){
  
    $.post('main.php', {
        action: 'LoadSealRecycled'
    }, function (e){
        if (!e.error){
            console.log(e.r);
            $('#tbSeals').DataTable({
                paginType: 'full_numbers',
                data: e.r,

                columns: [
                    {data: 'Id_Seal'},
                    {data: 'SealNo'},
                    {data: 'SealType'},
                    {data: 'Color'},
                    {data: 'Supplier_ID'},
                    {data: 'Source', visible: false},
                    {data: 'Office_ID'},
                    {data: 'Reference'},
                   ]
            });
        }
    });
    return
}