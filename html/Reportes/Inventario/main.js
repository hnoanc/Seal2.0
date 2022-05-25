
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
          lengthChange: false,
          dom: 'Bfrtip',
          
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
                extend:    'copyHtml5',
                text:      'Copiar',
                title:'Reporte',
                titleAttr: 'Copiar',
                className: 'btn btn-app export barras',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8]
                }  
            },
            {
                extend:    'pdfHtml5',
                        text:      'PDF',
                        title:'Titulo de tabla en pdf',
                        titleAttr: 'PDF',
                        className: 'btn btn-app export pdf',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8]
            }
        },
        
        {
            extend:    'excelHtml5',
            text:      'Excel',
            title:'Reporte',
            titleAttr: 'Excel',
            className: 'btn btn-app export excel',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8]
            },
        },
    {
            extend:    'csvHtml5',
                        text:      'CSV',
                        title:'TReporte',
                        titleAttr: 'CSV',
                        className: 'btn btn-app export csv',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8]
        }
    },
    {
        extend:    'print',
        text:      'Imprimir',
        title:'Reporte',
        titleAttr: 'Imprimir',
        className: 'btn btn-app export imprimir',
        exportOptions: {
            columns: [ 0, 1 ]
        }
    },],
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


  