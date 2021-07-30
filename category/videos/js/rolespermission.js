$(document).ready(function(){
$('#user_permissions').hide();
$('#user_role').change(function(){
// alert($('#user_role').val());
var user_role = $('#user_role').val();

if(user_role != ""){
    // alert('test');
$('#user_permissions').show();

}else{
    // alert('testone');

$('#user_permissions').hide();

}
});
});
