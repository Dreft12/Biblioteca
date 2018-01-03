// Login Form

$(function() {
    var button = $('#loginButton');
    var box = $('#loginBox');
    var form = $('#loginForm');
    var wrapper = $('#wrapper');
    button.removeAttr('href');
    button.mouseup(function(login) {
        box.toggle();
        button.toggleClass('active');
    });
    form.mouseup(function() { 
        return false;
    });
    $(this).mouseup(function(login) {
        if(!($(login.target).parent('#loginButton').length > 0)) {
            button.removeClass('active');
            box.hide();
        }
    });
});

$(function() {
    var button = $('#loginButton2');
    var box = $('#div2');
    var form = $('#div3');
    var wrapper = $('#wrapper');
    button.removeAttr('href');
    button.mouseup(function(login) {
        box.toggle();
        button.toggleClass('active');
        wrapper.css('z-index', -1);
    });
    form.mouseup(function() {
        return false;
    });
    $(this).mouseup(function(login) {
        if(!($(login.target).parent('#loginButton2').length > 0)) {
            button.removeClass('active');
            box.hide();
            wrapper.css('z-index',0);
        }
    });
});

$(function(){
    $('#recibir').click(function() {
        location.reload();
    });
});