
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
                text:      '<i class="fa fa-clipboard"></i>Copiar',
                title:'Titulo de tabla copiada',
                titleAttr: 'Copiar',
                className: 'btn btn-app export barras',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8]
                }  
            },
            {
                extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>PDF',
                        title:'Titulo de tabla en pdf',
                        titleAttr: 'PDF',
                        className: 'btn btn-app export pdf',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8]
            }
        },
        
        {
            extend:    'excelHtml5',
            text:      '<i class="fa fa-file-excel-o"></i>Excel',
            title:'Titulo de tabla en excel',
            titleAttr: 'Excel',
            className: 'btn btn-app export excel',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8]
            },
        },

        {
            extend:    'csvHtml5',
                        text:      '<i class="fa fa-file-text-o"></i>CSV',
                        title:'Titulo de tabla en CSV',
                        titleAttr: 'CSV',
                        className: 'btn btn-app export csv',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8]
        }
    },
    {
        extend:    'print',
        text:      '<i class="fa fa-print"></i>Imprimir',
        title:'Titulo de tabla en impresion',
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


  