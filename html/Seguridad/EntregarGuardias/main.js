$(document).ready(function () {
    $('#navbarNav').load('../../navMenu.html');
    $('head').load('../../head.html');
    $('select').select2(); 

    $('#Logout').click(function () {
        CloseSession()
        });
})
