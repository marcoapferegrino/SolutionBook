function checkPasswords()
{
    var password = $('#password').val();
    var passwordConfirm = $('#passwordConfirm').val();
    var label =  $('#labelPasswordConfirm').text();

    console.log(password+"----"+passwordConfirm+"-----"+label);
    if(password === passwordConfirm)
    {
        $('#formGroup').removeClass('has-error').addClass('has-success');
        $('#labelPasswordConfirm').text('Verifica Contraseña*       Válido');
        $('#guardar').removeClass('hidden');
    }
    else
    {
        $('#formGroup').addClass('has-error');
        $('#labelPasswordConfirm').text('Verifica Contraseña*    No coincide');
        $('#guardar').addClass('hidden');
    }
}
$('#passwordConfirm').keyup(function()
{
    checkPasswords();
});

$('#password').keyup(function()
{
    checkPasswords();
});
