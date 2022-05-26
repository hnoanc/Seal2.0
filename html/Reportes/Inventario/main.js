
$(document).ready(function () {
    $('#navbarNav').load('../../navMenu.html');
    LoadAllSecuritySeals()
    LoadAllSecuritySealsDetail()
})

function LoadAllSecuritySeals() {
    $.post('main.php', {
        action: 'LoadAllSecuritySeals'
      }, function (e) {
        if (!e.error) {

        $('#tbSeals').DataTable({
          pagingType: 'full_numbers',
          data: e.r,
          dom: 'Blfrtip',
          columnDefs: [
            {
                target: 0,
                visible: false,
                searchable: false,
            },
            {
                target: 5,
                visible: false,
                searchable: false,
            },
        ],

          columns: [
            { title: "Sello ID" },
            { title: "No. Sello" },
            { title: "Fuente" },
            { title: "Color" },
            { title: "Proveedor" },
            { title: "Requisicion" },
	        { title: "Referencia/Viaje" },
	        { title: "Status" },
            { title: "Fecha Recibido" }
        ],
        buttons: [ 
                {
                    extend: 'copyHtml5',
                    text: '<i class="fas fa-copy"></i> Copy',
                    titleAttr: 'Copy'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    titleAttr: 'CSV'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    titleAttr: 'PDF'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    titleAttr: 'Print'
                }  
],
 });


    }
      });
      return false;
  }

function LoadAllSecuritySealsDetail(){
    $.post('main.php', {
      action: "LoadAllSecuritySealsDetail"
    }, function (e) {
      if (e.error == false) {
        $('#Advailable').html(e.r[0][0]);
        $('#Recycled').html(e.r[0][1]);
        $('#Total').html(e.r[0][2]);
      }
    });
  }


  