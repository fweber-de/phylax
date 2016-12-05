$(document).ready(function () {

    var currentPage = $('#current-page').html();
    $('#nl-' + currentPage).addClass('active');

    var invokeSparkline = function() {
        $(".inlinesparkline").sparkline('html', {
            type: 'bar',
            barWidth: 5,
            barSpacing: 4,
            barColor: '#4c4c4c',
            height: '40'
        });
    };

    $('.vnd-appgraph-toggles a').click(function(e) {
        e.preventDefault();

        $('.vnd-appgraph-toggles a').removeClass('active');
        $(this).addClass('active');

        var toggle = $(this).data('toggle');

        if(toggle === '14d') {
            $('.sparkdata-24h').hide();
            $('.sparkdata-14d').show();
            $.sparkline_display_visible();
        }

        if(toggle === '24h') {
            $('.sparkdata-14d').hide();
            $('.sparkdata-24h').show();
            $.sparkline_display_visible();
        }
    });

    invokeSparkline();

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('.vnd-moment-ago').html(function() {
        var current = $(this).html();
        var d = moment(current);
        var now = moment();

        return d.from(now);
    });

});
