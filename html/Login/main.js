$(document).ready(function () {
    CheckSession();
    $('#btnLogin').click(function () {
        $('#btnLogin').attr('disabled', 'disabled');
        UserLogin();
    });
    $(document).keypress(function (e) {
        if (e.which == 13) {
            $('#btnLogin').attr('disabled', 'disabled');
            UserLogin();
        }
    });
    $('#chkRememberMe').click(function () {
        if (!$('#chkBox').attr('checked')) {
            $('#chkBox').attr("checked", "checked");
        } else {
            $('#chkBox').removeAttr("checked", "");
        }
    });
    $('#btnClient').click(function () {
        $('#btnClient').attr('disabled', 'disabled');
        ClientLogin();
    });
});
function UserLogin() {
    $.post('main.php', {
        action: "UserLogin",
        user: $('#username').val(),
        password: $('#password').val(),
        remember: $('#chkBox').is(':checked')
    }, function (e) {
        if (!e.error) {
            console.log(e)
            if (e.r[0]['Role_Name'] == 'Sistemas/Admin' || e.r[0]['Role_Name'] == 'Administrador') {
                window.location.replace("../Seguridad/RecibirCompras");
            } /*else if (e.r[0]['Role_Name'] == 'Seguridad') {
                window.location.replace("../Seguridad/Dashboard");
            } else if (e.r[0]['Role_Name'] == 'Despacho Impo') {
                window.location.replace("../Despacho/Devolver_Sellos_Despacho");
            }else if (e.r[0]['Role_Name'] == 'Despacho Expo') {
                window.location.replace("../Despacho/Devolver_Sellos_Despacho");
            } else if (e.r[0]['Role_Name'] == 'PuraSangre') {
                window.location.replace("../PuraSangre/Verificacion_Purasangre");
            } else if (e.r[0]['Role_Name'] == 'Inspecciones') {
                window.location.replace("../Inspeccion/Asignacion_Sellos");
            } else if (e.r[0]['Role_Name'] == 'Cliente') {
                window.location.replace("../Cliente/Entregar_Sellos_Operador");
            } */
        } else {
            //Core.ShowNotific8('Usuario o Contraseña incorrecta, favor de verificar', 'ruby', false);
            $('#btnLogin').removeAttr('disabled');
        }
    });
    $('#btnLogin').removeAttr('disabled');
    return false;
}
function ClientLogin() {
    window.location.replace("../ClientLogin/");
    return false;
}
function CheckSession() {
    var Url = window.location.pathname;
    Url = Url.split("/");
    Url = Url[Url.length - 2];
    $.post('../Core/CoreFn.php ', {
        action: "CheckSession",
        url: Url
    }, function (e) {
        //console.log(e);
        if (e.data) {
            switch (e.r) {
                case "1":
                    window.location.replace("../Cliente/Entregar_Sellos_Operador");
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
                     window.location.replace("../Despacho/Devolver_Sellos_Despacho");
                break;
                case "6":
                     window.location.replace("../Seguridad/Dashboard");
                    break;
                case "7":
                    window.location.replace("../Seguridad/Dashboard");
                    break;
               
            }
        }
    });
}
