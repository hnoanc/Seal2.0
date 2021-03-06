$(document).ready(function () {
    $('#navbarNav').load('../../navMenu.html');
    GetUsersForReceiveSeals();
    GetSuppliers();
    
    $('select').select2({
      width: "100%"
    });

    $('#Logout').click(function () {
      CloseSession()
      });
    

    $('#btnGuardar').click(function () {
      let folioInicial =$('#txtFolioInicial').val()
      let folioFinal =$('#txtFolioFinal').val()
      let user = $('#cbxUser').val()
      let color =$('#txtColor').val()
      let proveedor = $('#cbxProveedor').val()
      let referencia = $('#txtReferencia').val()
      let quantity = $('#txtCantidad').val()

      var elements = document.querySelectorAll("input[type='text'],input[type='number'], input[type='number']");

      if (folioInicial == '' || folioFinal == '' || user == '' || color == '' || proveedor == '' || referencia == '' || quantity == '' ||
          folioInicial == null || folioFinal == null || user == null || color == null || proveedor == null || referencia == null || quantity == null) {
        
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Los campos estan vacillos'
          })

      } else {
        AddSealsFromPurchase();
      }
      });

})

function AddSealsFromPurchase() {

    var data = {
      'InitialFolio': $('#txtFolioInicial').val(),
      'FinalFolio': $('#txtFolioFinal').val(),
      'UserDelivery': $('#cbxUser').val(),
      'Color': $('#txtColor').val(),
      'Supplier_ID': $('#cbxProveedor').val(),
      'Requisition_ID': 0,
      'Reference': $('#txtReferencia').val(),
      'Status': 1,
      'Quantity': $('#txtCantidad').val()
    };
  
      $.post('main.php', {
        action: 'AddNewSeals',
        Data: data
      }, function (e) {
        if (!e.error) {
         
          window.open('pdf.php?User=' + $('#cbxUser').val() + '&Type=R&InitialFolio=' + $('#txtFolioInicial').val() +'&FinalFolio='+$('#txtFolioFinal').val() +'&UserR', '_blank');
          Swal.fire({
                icon: 'success',
                title: 'Logrado',
                text: 'Los datos se han guardado'
            })

          limpiar()
        
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Los campos estan vacillos'
        })
        }
      });
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

function GetSuppliers() {
  $.post('main.php', {
    action: 'GetSuppliers'
  }, function (e) {
    if (!e.error) {
      //Core.HtmlLoad($('#CB_User'), '../../Templates/CoreTemplate.html', 'SelectItem', e.r);
      var $select = $('#cbxProveedor');
      for (let i = 0; i < e.r.length; i++) {
          $select.append('<option value=' + e.r[i].Value + '>' + e.r[i].Display + '</option>');
      }
    }
    
  });
  return false;
}

function limpiar()
{
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('select').val(1);
}