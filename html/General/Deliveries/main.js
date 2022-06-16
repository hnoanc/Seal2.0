$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    LoadDelivery();
})

function LoadDelivery(){
$.post('main.php', {
    action: 'LoadDelivery'
}, function (e){
    if(!e.error){
        console.log(e.r);
        $('#tbDevs').DataTable({
            pagingType: 'full_numbers',
            data: e.r,
            columns: [
                {data: 'ID_Delivery'},
                {data: 'ID_UserDelivery'},
                {data: 'ID_UserReceives'},
                {data: 'InitialFolio'},
                {data: 'FinalFolio'},
                {data: 'Quantity'},
                {data: 'ID_Supplier'},
                {data: 'Date'}
            ]
        });
    }
});
return false
}