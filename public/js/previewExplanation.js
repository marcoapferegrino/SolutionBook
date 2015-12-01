

var allowed = "<strong><p><br><code><h3><h4><h2><kbd>";


function strip_tags(str, allow) {
    // making sure the allow arg is a string containing only tags in lowercase (<a><b><c>)
    allow = (((allow || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
    var commentsAndPhpTags = /|<(?:\?|\%)(?:php|=)?[\s\S]*?(?:\?|\%)>/gi;
    return str.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
        return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
}

$('#explanation').keyup(function () {
    var explanation = $('#explanation').val();
    var divContenido =$('#contenido');
    /*Cleaning explanation from html tags*/
    explanation = strip_tags(explanation,allowed);
    divContenido.html(explanation);

});


function insertTag(tag) {
    $('#explanation').val($('#explanation').val() + tag);
}
    $('#strong').click(function () {
        insertTag("<strong> </strong>");
    });

    $('#br').click(function () {
        insertTag("</br>");
    });
    $('#code').click(function () {
        insertTag("<code> </code>");
    });
    $('#h2').click(function () {
        insertTag("<h2> </h2>");
    });
    $('#h3').click(function () {
        insertTag("<h3> </h3>");
    });

    $('#cmd').click(function () {
        insertTag("<kbd> </kbd>");
    });
    $('#h4').click(function () {
        insertTag("<h4> </h4>");
    });
    $('#pPrimary').click(function () {
        insertTag("<p class='text-primary'>  </p>");
    });
    $('#pInfo').click(function () {
        insertTag("<p class='text-info'>  </p>");
    });
    $('#pWarning').click(function () {
        insertTag("<p class='text-warning'>  </p>");
    });
    $('#pDanger').click(function () {
        insertTag("<p class='text-danger'>  </p>");
    });
    $('#pSuccess').click(function () {
        insertTag("<p class='text-success'>  </p>");
    });
