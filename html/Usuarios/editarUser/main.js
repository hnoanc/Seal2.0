var editor; 

$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    /*LoadSecuritySeals();*/
    LoadUsersInfo();
    GetRoles();


 /* $('select').select({
         with:"100%"
     });   */
})


/*function LoadSecuritySeals() {
  
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
}*/


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
          { title: "ID"},
          { title: "Nombre"},
          { title: "Rol"},
          { title: "Departamento"},
          { title: "Correo"},
          { title: "Extencion"},
          { title: "Oficina"},
          {title: "Estado"},
          {"data": null,
          "className": "button",
          "defaultContent": "<button type='button' name='BtnEd' class='btn btn-icon-toggle' data-toggle='modal' data-target='#ModUs'><i class='fas fa-edit'></i></button>"}
      ]
      
      });  
      document.getElementById("UserIDPass").value = "test";

      
      }
    });
    return false;
}

function GetRoles() {
  $.post('main.php', {
    action: 'GetRoles'
  }, function (e) {
    if (!e.error) {
      Core.HtmlLoad($('#CB_Roll'), '../../Templates/CoreTemplate.html', 'SelectItem', e.r);
    }
  });
  return false;
}


/*RegUsr*/

