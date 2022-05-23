$(document).ready(function () {
    $('#navbarNav').load('../../navMenu.html');
    GetUsersForReceiveSeals();
    GetSuppliers();
    
    $('select').select2({
      width: "100%"
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
        alert('Favor de llenar todos los campos')
      } else {
        AddSealsFromPurchase();
      }
      });

})

function AddSealsFromPurchase() {
  
  /*var objects = [
    ['#CB_User', '#FG_User', '#CB_UserE'],
    ['#Txt_Quantity', '#FG_Quantity', '#Txt_QuantityE'],
    ['#Txt_InitialFolio', '#FG_InitialFolio', '#Txt_InitialFolioE'],
    ['#Txt_FinalFolio', '#FG_FinalFolio', '#Txt_FinalFolioE'],
    ['#CB_Supplier', '#FG_Supplier', '#CB_SupplierE']
    
  ];*/

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
          const div = document.getElementById("divAlert");
          document.getElementById("alertMessage").textContent="Guardado correctamente";
          div.style.backgroundColor = "#6ab150"
          window.open('pdf.php?User=' + $('#cbxUser').val() + '&Type=R&InitialFolio=' + $('#txtFolioInicial').val() +'&FinalFolio='+$('#txtFolioFinal').val() +'&UserR', '_blank');
          limpiar()
        
        }else{
          document.getElementById("alertMessage").textContent="Ha fallado correctamente";
          div.style.backgroundColor = "#f86f6f"
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