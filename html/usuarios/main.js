$(document).ready(function(){
    $('#navbarNav').load('../navMenu.html');
    GetUsersForReceiveSeals();

  $('select').select({
         with:"100%"
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