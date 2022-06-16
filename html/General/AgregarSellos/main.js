$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');

    LoadSealRecycled();
    guardar();

    $('#Logout').click(function () {
        CloseSession()
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
                console.log("mensaje desde la pagina")
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
                "lengthChange": false,
                "iDisplayLength": 16,

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

function guardar(){

    $('#btnSv').click(function () {
        let NoSello = $('#txtNoSello').val()
        let Color = $('#txtColor').val()
        let Reference = $('#taxRef').val()

        if(NoSello == '' | Color == '' | Reference== ''){
          
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Los campos estan vacillos'
            })
            
        }else{
            GuardarSellos();

             Swal.fire({
                icon: 'success',
                title: 'Logrado',
                text: 'Los datos se han guardado'
            })
           
            clear();
        }
        });
}

function clear(){
    $('input[type="text"]').val('');
    $('textarea').val('');

}