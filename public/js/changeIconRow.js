$('#showCode').click(function(){

    var showCode =$(this).data('codeshow');
    console.log("clickeado: "+showCode);
    if(showCode==='false')
    {
        $('#iconCode').removeClass('fa-arrow-down');
        $('#iconCode').addClass('fa-arrow-up');
        $(this).data('codeshow','true')
    }
    else{
        $('#iconCode').removeClass('fa-arrow-up');
        $('#iconCode').addClass('fa-arrow-down');
        $(this).data('codeshow','false')
    }
});
