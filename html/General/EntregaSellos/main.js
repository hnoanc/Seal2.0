
$(document).ready(function () {
    $('#navbarNav').load('../../navMenu.html');
   // $(function(){ $("foot").load("../../foot.html") });
    GetUsersForReceiveSeals();
    LoadSealsDepartment();
    $('select').select2(); 

    $('#Logout').click(function () {
      CloseSession()
      });
})

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

function LoadSecuritySeals() {
    $.post('main.php', {
        action: 'LoadSecuritySeals'
      }, function (e) {
        if (!e.error) {
          console.log(e.r);

        $('#tbSeals').DataTable({
          pagingType: 'full_numbers',
          data: e.r,

          columns: [
            { title: "ID" },
            { title: "Color" },
            { title: "Proveedor" },
            { title: "Requisicion." },
            { title: "Referencia" },
            { title: "Status" },
            { title: "Fecha adquisicion" }
        ]
        });
        }
      });
      return false;
}

function LoadSealsDepartment() {
  $.post('main.php', {
      action: 'LoadSealsDepartment'

    }, function (e) {
      if (!e.error) {
        console.log(e.r);

      $('#tbSeals').DataTable({
        pagingType: 'full_numbers',
        data: e.r,
        order: [[3, 'desc']],

        columns: [
          { title: "Id_StatusSeal", visible: false },
          { title: "ID Sello" },
          { title: "Numero de Sello" },
          { title: "Estatus" },
          { title: "Fecha" }
      ]
      });
      }
    });
    return false;
}

function UpdateSealToSecurity() {

  var data = {
      'InitialFolio_ID': $('#txtFolioInicial').val(),
      'FinalFolio_ID': $('#txtFolioFinal').val(),
      'UserReceive': $('#cbxUser').val()
  };

  if (Validar()) {
      $.post('main.php', {
          action: 'UpdateSealToSecurity',
          Data: data
      }, function(e) {
          if (!e.error) {
              window.open('pdf.php?User=' + $('#cbxUser').val() + '&Type=R&InitialFolio=' + $('#txtFolioInicial').val() + '&FinalFolio=' + $('#txtFolioFinal').val() + '&UserR', '_blank');
              LoadSecuritySeals();
              clear();
          }
      });
  }
}

function Validar(data){

  let x = false;

  for (let i = 0; i < data.length; i++) {
    const element = data[i];
    if (element != "" || element != null) {
      x = true;
    }else{
      i = data.length;
      x = false;
    }
  }
  return x;

}




// var data = {
//   'InitialFolio': $('#txtFolioInicial').val(),
//   'FinalFolio': $('#txtFolioFinal').val(),
//   'UserDelivery': $('#cbxUser').val(),
//   'Color': $('#txtColor').val(),
//   'Supplier_ID': $('#cbxProveedor').val(),
//   'Requisition_ID': 0,
//   'Reference': $('#txtReferencia').val(),
//   'Status': 1,
//   'Quantity': $('#txtCantidad').val()
// };

//   $.post('main.php', {
//     action: 'AddNewSeals',
//     Data: data
//   }, function (e) {
//     if (!e.error) {
//       const div = document.getElementById("divAlert");
//       document.getElementById("alertMessage").textContent="Guardado correctamente";
//       div.style.backgroundColor = "#6ab150"
//       window.open('pdf.php?User=' + $('#cbxUser').val() + '&Type=R&InitialFolio=' + $('#txtFolioInicial').val() +'&FinalFolio='+$('#txtFolioFinal').val() +'&UserR', '_blank');
//       limpiar()
    
//     }else{
//       document.getElementById("alertMessage").textContent="Ha fallado correctamente";
//       div.style.backgroundColor = "#f86f6f"
//     }
//   });
