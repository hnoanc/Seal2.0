$(document).ready(function () {
  $('#Badge').click(function () {
    //console.log('hi');
    window.location.replace('../Inspector/Ver_Inspecciones');
  });
});

var Core = (function () {
  var CheckSession = function CheckSession() {
    var Url = window.location.pathname;
    Url = Url.split("/");
    Url = Url[Url.length - 2];
    $.post('../../Core/CoreFn.php ', {
      action: "CheckSession",
      url: Url
    }, function (e) {
      if (e.data) {
        if (e.r < e.Permit) {
          switch (e.r) {
            case "2":
            window.location.replace("../Inspeccion/Asignacion_Sellos");
            break;
        case "3":
             window.location.replace("../PuraSangre/Verificacion_Purasangre");
            break; 
        case "4":
             window.location.replace("../Despacho/Devolver_Sellos_Despacho");
            break;
        case "5":
             window.location.replace("../Seguridad/Dashboard");
            break;
        case "6":
            window.location.replace("../Seguridad/Dashboard");
            break;
          }
        }
      }
      if (!e.data) {
        window.location.replace("../../Login/index.html");
      }
    });
  };

  var LoadTopBar = function LoadTopBar() {
    $.post('../../Core/CoreFn.php', {
      action: "LoadTopBar"
    }, function (e) {
      Core.HtmlLoad($('#header'), "../../Templates/MasterTemplate.html", "Topbar", e.r);
      if ($('#Dept').text() != 'Admin') {
        $('#ItOnly').remove();
      }
    });
  };

  var SideBar = function SideBar() {
    $.post('../../Core/CoreFn.php', {
      action: "SideBar"
    }, function (e) {

      var MenuParents = [];
      var Menu = [];
      Menu['Menu'] = [];

      //se asigna un arrgelo vacio llamado menu a cada boton del menu traido de la base de datos
      for (var i = 0; i < e.r.length; i++) {
        e.r[i].Menu = [];
        //se guardan los ID de los botones que tienen alguna dependencia
        if ($.inArray(e.r[i].Menu_Parent, MenuParents) == -1) {
          MenuParents.push(e.r[i].Menu_Parent);
        }
      }
      //Se guardan los grupos de botones que pertenecen a un padre
      for (var k = MenuParents.length - 1; k > -1; k--) {
        var Temp = [];
        for (var l = e.r.length - 1; l > -1; l--) {
          if (e.r[l].Menu_Parent == MenuParents[k]) {
            Temp.push(e.r[l]);
          }
        }
        //se comienza a ensamblar el menu final
        for (var m = 0; m < e.r.length; m++) {
          if (Temp[0].Menu_Parent == e.r[m].Menu_ID) {
            for (var n = 0; n < Temp.length; n++) {
              e.r[m].Menu.push(Temp[n]);
            }
          }
        }
      }
      //se seleccionan los botones padres y se envia
      for (var o = 0; o < e.r.length; o++) {
        if (e.r[o].Menu_Parent == 0) {
          Menu['Menu'].push(e.r[o]);
        }
      }

      $('#main-menu').load("../../Templates/Handlebars.html", function () {
        var Source = $('#SideBar').html();
        var Template = Handlebars.compile(Source);
        Handlebars.registerPartial("Menu", $("#SideBar").html());
        var html = Template(Menu);
        $('#main-menu').html(html);
      });

      $('body').toggleClass('hidden', false);
    });
  };

  var LogOut = function LogOut() {
    $.post('../../Core/CoreFn.php', {
      action: "LogOut"
    }, function (e) { 
        window.location.replace("../../Login/index.html");
    });
  };

  var SendMail = function SendMail(Data) {
    $.post('../../Core/Mail.php', {
      action: "SendMail",
      message: Data
    }, function (e) {

    });
  };

  var HtmlLoad = function HtmlLoad(Target, TemplatePath, TemplateID, JsonData,dfd) {
    Target.load(TemplatePath + " #" + TemplateID, function () {
      var Source = $('#' + TemplateID).html();
      var Template = Handlebars.compile(Source);
      var html = Template(JsonData);
      Target.html(html);
    });
    if(dfd != null){
      setTimeout(function(){
        dfd.resolve();
    }, 500);
    }
  };

  var HtmlAppend = function HtmlAppend(Target, TemplatePath, TemplateID, JsonData) {
    Target.load(TemplatePath + " #" + TemplateID, function () {
      var Source = $('#' + TemplateID).html();
      var Template = Handlebars.compile(Source);
      var html = Template(JsonData);
      Target.append(html);
    });
  };

  var ShowNotific8 = function showNotification(msg, type, stick) {
    /*
    teal
    amethyst
    ruby
    tangerine
    lemon
    lime
    ebony
    smoke
    */
    var settings = {
      theme: type,
      sticky: stick,
      horizontalEdge: 'top',
      verticalEdge: 'right',
      life: 3000,
    };
    $.notific8('zindex', 11500);
    $.notific8(msg, settings);
  };
  var InitTableWithButtons = function (ds, c, table, Csettings, buttons, order) {
    if (buttons == 'undefined') {
      buttons = [];
    }
    if (Csettings == 'undefined') {
      Csettings = [];
    }
    if (order == 'undefined') {
      order = 'desc';
    }
    table.DataTable({
      //"scrollY": 400,
      //"scrollCollapse": false,
      "bFilter": true,
      "destroy": true,
      "data": ds,
      "columns": c,
      "language": {
        "aria": {
          "sortAscending": ": Orden Ascendente",
          "sortDescending": ": Orden Descendente"
        },
        "emptyTable": "No hay datos para mostrar",
        "info": "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
        "infoEmpty": "No se encontraron registros",
        "infoFiltered": "(Filtrado desde _MAX_ registros totales)",
        "lengthMenu": "_MENU_ Registros",
        "search": "Buscar:",
        "zeroRecords": "No se encontraron registros",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },

       dom: 'Blfrtip',
      'buttons': buttons,
      "responsive": true,
      "order": [
        [0, order]
      ],
      "lengthMenu": [
        [5, 10, 15, 20, -1],
        [5, 10, 15, 20, "Todos"] // change per page values here
      ],
      "pageLength": 5,
      "columnDefs": Csettings,
      fixedColumns: false
    });
  };
  var InitTable = function (ds, c, table, Csettings, buttons, order) {
    if (buttons == 'undefined') {
      buttons = [];
    }
    if (Csettings == 'undefined') {
      Csettings = [];
    }
    if (order == 'undefined') {
      order = 'asc';
    }
    table.DataTable({
      //"scrollY": 400,
      //"scrollCollapse": false,
      "bFilter": true,
      "destroy": true,
      "data": ds,
      "columns": c,
      "language": {
        "aria": {
          "sortAscending": ": Orden Ascendente",
          "sortDescending": ": Orden Descendente"
        },
        "emptyTable": "No hay datos para mostrar",
        "info": "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
        "infoEmpty": "No se encontraron registros",
        "infoFiltered": "(Filtrado desde _MAX_ registros totales)",
        "lengthMenu": "_MENU_ Registros",
        "search": "Buscar:",
        "zeroRecords": "No se encontraron registros",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },
      "buttons": buttons,
      "responsive":true,
      "order": [
        [0, order]
      ],
      "lengthMenu": [
        [5, 10, 15, 20, -1],
        [5, 10, 15, 20, "Todos"] // change per page values here
      ],
      "pageLength": 5,
      "columnDefs": Csettings,
      fixedColumns: false
    });
  };

  var ShowMenu = function(){
    $('body').toggleClass('menubar-visible');
  };

  var getUrlParameterFn = function (sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

    for (i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');

      if (sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : sParameterName[1];
      }
    }
  };

  var RandomColorFn = function () {

    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;

  };

  var Report = function (DataProvider, categoryField, graphs, target, GraphYTitle) {
    AmCharts.addInitHandler(function (chart) {
      // check if export to table is enabled
      if (chart.dataTableId === undefined)
        return;

      // get chart data
      var data = chart.dataProvider;

      // create a table
      var holder = document.getElementById(chart.dataTableId);

      while (holder.hasChildNodes()) {
        holder.removeChild(holder.firstChild);
      }

      var table = document.createElement("table");
      holder.appendChild(table);
      var tr, td;

      // add first row
      for (var x = 0; x < chart.dataProvider.length; x++) {
        // first row
        if (x == 0) {
          tr = document.createElement("tr");
          table.appendChild(tr);
          td = document.createElement("th");
          td.innerHTML = 'Empleado';
          tr.appendChild(td);
          for (var i = 0; i < chart.graphs.length; i++) {
            td = document.createElement('th');
            td.innerHTML = chart.graphs[i].title;
            tr.appendChild(td);
          }
        }

        // add rows
        tr = document.createElement("tr");
        table.appendChild(tr);
        td = document.createElement("td");
        td.className = "row-title";
        td.innerHTML = chart.dataProvider[x][chart.categoryField];
        tr.appendChild(td);
        for (var i = 0; i < chart.graphs.length; i++) {
          td = document.createElement('td');
          td.innerHTML = chart.dataProvider[x][chart.graphs[i].valueField];
          tr.appendChild(td);
        }
      }

    }, ["serial"]);

    var chart = AmCharts.makeChart("chartdiv", {
      "type": "serial",
      "theme": "light",
      "marginRight": 70,
      "dataProvider": DataProvider,
      "dataTableId": "chartdata",
      "startDuration": 1,
      "valueAxes": [{
        //"stackType": "regular",
        "gridAlpha": 0.07,
        "title": GraphYTitle
      }],
      "graphs": graphs,
      "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
      },
      "categoryField": "Nombre",
      "categoryAxis": {
        "gridAlpha": 0.07,
        "axisColor": "#DADADA",
        "startOnAxis": false,
        "gridPosition": "start",
        "tickPosition": "start",
        "tickLength": 25,
        "boldLabels": true,
        "labelRotation": 30
      },
      "export": {
        "enabled": true,
        "menu": []
      }
    });
  };

  var ShowNotific8Fn = function (msg, type, stick) {
    ShowNotific8(msg, type, stick);
  };

  var LoadPageFn = function () {
    CheckSession();
    LoadTopBar();
    SideBar();
   
    /*LoadTopBar();
    SideBar();*/
  };

  var CheckSessionFn = function () {
    CheckSession();
  };

  var LogOutFn = function () {
    LogOut();
  };

  var HtmlLoadFn = function (Target, TemplatePath, TemplateID, JsonData,dfd) {
    HtmlLoad(Target, TemplatePath, TemplateID, JsonData,dfd);
  };

  var HtmlAppendFn = function (Target, TemplatePath, TemplateID, JsonData) {
    HtmlAppend(Target, TemplatePath, TemplateID, JsonData);
  };

  var InitTableFn = function (ds, c, table, Csettings, buttons, order) {
    //console.log(Csettings);
    InitTable(ds, c, table, Csettings, buttons, order);
  };
  var InitTableWithButtonsFn = function (ds, c, table, Csettings, buttons, order) {
    //console.log(Csettings);
    InitTableWithButtons(ds, c, table, Csettings, buttons, order);
  };
  
  var InitTableReturnFn = function (ds, c, table, Csettings, buttons, order) {
    if (buttons == 'undefined') {
      buttons = [];
    }
    if (Csettings == 'undefined') {
      Csettings = [];
    }
    if (order == 'undefined') {
      order = 'asc';
    }
    return table.DataTable({
      //"scrollY": 400,
      //"scrollCollapse": false,
      "bFilter": true,
      "destroy": true,
      "data": ds,
      "columns": c,
      "language": {
        "aria": {
          "sortAscending": ": Orden Ascendente",
          "sortDescending": ": Orden Descendente"
        },
        "emptyTable": "No hay datos para mostrar",
        "info": "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
        "infoEmpty": "No se encontraron registros",
        "infoFiltered": "(Filtrado desde _MAX_ registros totales)",
        "lengthMenu": "_MENU_ Registros",
        "search": "Buscar:",
        "zeroRecords": "No se encontraron registros",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },
      "buttons": buttons,
      "responsive":true,
      "order": [
        [0, order]
      ],
      "lengthMenu": [
        [10, 15, 20, -1],
        [10, 15, 20, "Todos"] // change per page values here
      ],
      "pageLength": 10,
      "columnDefs": Csettings,
      fixedColumns: false
    });
  };

  var SendMailFn = function (Data) {
    SendMail(Data);
  };

  var ReportFn = function (DataProvider, categoryField, graphs, target, GraphYTitle) {
    Report(DataProvider, categoryField, graphs, target, GraphYTitle);
  }
  var ShowMenuFn = function(){
    ShowMenu();
  };

  return {
    LoadPage: LoadPageFn,
    LogOut: LogOutFn,
    HtmlLoad: HtmlLoadFn,
    HtmlAppend: HtmlAppendFn,
    ShowNotific8: ShowNotific8Fn,
    InitTable: InitTableFn,
    InitTableWithButtons:InitTableWithButtonsFn,
    InitTableReturn: InitTableReturnFn,
    getUrlParameter: getUrlParameterFn,
    CheckSession: CheckSessionFn,
    SendMail: SendMailFn,
    Report: ReportFn,
    RandomColor: RandomColorFn,
    ShowMenu: ShowMenuFn
  };
})();
