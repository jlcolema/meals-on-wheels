$.fn.cycle.defaults.timeout = 6000;
$(function() {   
    $('#slides').before('<div id="nav" class="nav">').cycle({
        fx:     'fade',
        speed:  'slow',
        timeout: 6000,
        delay: 10000,
        pager:  '#nav'
    });
});