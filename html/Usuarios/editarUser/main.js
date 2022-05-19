var editor; 

$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    LoadSecuritySeals();
 /*   GetDepartments();*/

 /* $('select').select({
         with:"100%"
     });   */
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
          { title: "ID" },
          { title: "Color" },
          { title: "Proveedor" },
          { title: "Requisicion." },
          { title: "Referencia" },
          { title: "Status" },
          { title: "Fecha adquisicion" },
          {"data": null,
          "className": "button",
          "defaultContent": "<button type='button' name='BtnEd' class='btn btn-icon-toggle' data-toggle='modal' data-target='#ModUs'><i class='fas fa-edit'></i></button>"}
      ]

      
      });  

      
      }
    });
    return false;
}


