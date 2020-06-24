
$(document).ready(function() {

    ajax_updateResurse();

});

function ajax_updateResurse() {

    // loading indicator
    $("#latest-resurse-div").html(
        $("<span>")
            .addClass("spinner-border spinner-border-lg text-primary")
    );

    $.ajax({
        url: "/portal/resurse/ajax/ultimele",
        dataType: "json"
    }).done(function(result) {

        var template = $("#resurse-template").html();

        result.resurse.forEach(function(resursa) {
            var continutLen = resursa.ContinutHtml.length;
            if (continutLen > 100) {
                resursa.continutRestricted =
                    resursa.ContinutHtml.substring(0, 100);
                resursa.continutRestricted +=
                    " (...)";
            } else resursa.continutRestricted = resursa.ContinutHtml;
            resursa.clasa =
                (resursa.Nivel == "notset") ?
                null :
                "a " + resursa.Nivel + "-a";
        });

        $("#latest-resurse-div").html(
            Mustache.render(template, result)
        );

    });

}