$(function() {
    var url = window.location.toString().split('#')[0];
    var panel = window.location.toString().split('#')[1];
    sesskey(url);

    if (panel) {
        show_panel(panel);
    }

    $('.panel-links').each(function(i, elm) {
        var id = $(elm).attr('id').split('-')[0];
        $('#'+id+'-link').bind({
            click: function() {
                show_panel(id);
            }
        });
    });

});

function show_panel(panel) {
    $('.display-panels').each(function(i, elm) {
        var id = $(elm).attr('id').split('-')[0];
        if (id == panel) {
            $('#'+id+'-panel').css("display", "block");
        } else {
            $('#'+id+'-panel').css("display", "none");
        }
    });
}

function send_request(url, json) {
    var return_data = $.getJSON(url+'/?json='+json, function(data) {
        return data;
    });
    return return_data;
}

function sesskey(url) {
    $.getJSON(url+'json/session.json.php', function(json){
        var obj = json;
        $.cookie('vote_app', obj.sesskey, { expires: 1 });
    });
}
