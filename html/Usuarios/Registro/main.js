$(document).ready(function(){
    $('#navbarNav').load('../../navMenu.html');
    GetUsersForReceiveSeals();
    GetDepartments();


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

  function GetDepartments() {
    $.post('main.php', {
      action: 'GetDepartments'
    }, function (e) {
      if (!e.error) {
        var $select = $('#cbDep');
        for (let i = 0; i < e.r.length; i++) {
            $select.append('<option value=' + e.r[i].Value + '>' + e.r[i].Display + '</option>');
        }
      }
      
    });
    return false;
  }

  