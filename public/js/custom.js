$(document).ajaxStart(function () {
    if($('.dashboard-count .ibox-content').length <= 0) {
        $('.ibox-content').addClass('sk-loading');
    } else {
        $('.ibox-content').addClass('sk-loading');
        $('.dashboard-count .ibox-content').removeClass('sk-loading');
    }
}).ajaxStop(function () {
    $('.ibox-content').removeClass('sk-loading');
});