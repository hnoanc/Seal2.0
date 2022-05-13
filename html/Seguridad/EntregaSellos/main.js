
$(document).ready(function () {
    $('#navbarNav').load('../../navMenu.html');
   // $(function(){ $("foot").load("../../foot.html") });
    GetUsersForReceiveSeals();
    LoadSecuritySeals();
    $('select').select2(); 
})

function GetUsersForReceiveSeals() {
    $.post('main.php', {
      action: 'GetUsersForReceiveSeals'
    }, function (e) {
      if (!e.error) {
        //Core.HtmlLoad($('#CB_User'), '../../Templates/CoreTemplate.html', 'SelectItem', e.r);
        var $select = $('#cbxUser');
        for (let i = 0; i < e.r.length; i++) {
            $select.append('<option value=' + e.r[i].Value + '>' + e.r[i].Display + '</option>');
        }
      }
      
    });
    return false;
}

function LoadSecuritySeals() {

    
    $.post('main.php', {
        action: 'LoadSecuritySeals'
      }, function (e) {
        if (!e.error) {
          console.log(e.r);

        $('#tbSeals').DataTable({
          data: e.r,

          columns: [
            { className: "", title: "Name" },
            { className: "", title: "Position" },
            { className: "", title: "Office" },
            { className: "", title: "Extn." },
            { className: "", title: "Start date" },
            { className: "", title: "Start date2" },
            { className: "", title: "Salary" }
        ]
        
        });
            
        }
      });
      return false;

    

}
