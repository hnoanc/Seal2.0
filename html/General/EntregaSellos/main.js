$(document).ready(function () {
    $('#navbarNav').load('../../navMenu.html');
    GetUsersForReceiveSeals();
   LoadSealsDepartment();
   
    $('select').select2(); 

    $('#Logout').click(function () {
      CloseSession()
      });  
})

var InitialSeal_ID = 0;
var FinalSeal_ID = 0;


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


function LoadSealsDepartment() {
  $.post('main.php', {
      action: 'LoadSealsDepartment'
    }, function (e) {
      if (!e.error) {
        console.log(e.r);
      $('#tbSeals').DataTable({
        pagingType: 'full_numbers',
        data: e.r,
         columns: [
          { title: "Id_StatusSeal", visible: false },
          { title: "ID Sello" },
          { title: "Numero de Sello" },
          { title: "Estatus" },
          { title: "Fecha" },
          {"data": null,
          "className": "button",
          "defaultContent": '<button type="button" name="BtnInt" class="btn btn-outline-success" id="btnIn"><i id="IbtnIn" class="fas fa-arrow-up"></i></button>'+
          '<button type="button" name="BtnEnd" class="btn btn-outline-danger"id="btnEnd" ><i id="IbtnEnd" class="fas fa-arrow-down"></i></button>'}               
               ]
          });
          
          var table = $('#tbSeals').DataTable();

          $("#tbSeals").on('click','#btnIn', function(){

            let data = table.row($(this).parents('tr')).data();

            let folioInicial = $('#txtFolioInicial').val();
            let folioFinal = $('#txtFolioFinal').val();

            $("#txtFolioInicial").val(data[1])

          })





          $("#tbSeals").on('click', '#btnEnd', function(){
            let data = table.row($(this).parents('tr')).data();
            let folioInicial = $('#txtFolioInicial').val();
            let folioFinal = $("#txtFolioFinal").val();

              $("#txtFolioFinal").val(data[1])

          })
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


function SetInitialFolio(SealID, SealNo) {
  if ($('#txtFolioFinal').val() != '') {
      if ($('#txtFolioFinal').val() >= SealNo) {
          $('#txtFolioInicial').addClass("dirty");
          $('#txtFolioInicial').val(SealNo);
          InitialSeal_ID = SealID;
      } else {
        alert("error 404");
      }
  } else {
      $('#txtFolioInicial').addClass("dirty");
      $('#txtFolioInicial').val(SealNo);
      InitialSeal_ID = SealID;
  }
}

function SetFinalFolio(SealID, SealNo) {
  if ($('#txtFolioInicial').val() != '') {
      if ($('#txtFolioInicial').val() <= SealNo) {
          $('#txtFolioFinal').addClass("dirty");
          $('#v').val(SealNo);
          FinalSeal_ID = SealID;
      } else {
        alert("error 404");
      }
  } else {
      $('#txtFolioFinal').addClass("dirty");
      $('#txtFolioFinal').val(SealNo);
      FinalSeal_ID = SealID;
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
