

function ajax_updateMaterii() {

    $("#materii-table").html(
        $("<span>")
            .addClass("spinner-border text-primary m-3"));

    $.ajax({
        url: "/portal/situatia/ajax/materii/?uid=" + _elevId + "&sem=" + _sem,
        //data: ,
        method: "GET",
        dataType: "json"})
    .done(function(result) {
        if (result.status == "success") {
            
            var template = $("#situatie-elev-template").html();

            result.materii.forEach(function(materie, materie_i) {

                materie.nrcrt = materie_i + 1;
                
                var dataFunc = function(item, index) {
                    item.lunaRoman = "&#x216" + (item.Luna-1).toString(16) + ";";
                };
                materie.note.forEach(dataFunc);
                materie.absente.forEach(dataFunc);
                materie.note.forEach(function(nota, nota_i) {
                    nota.isTeza = nota.Tip == "teza";
                });
                materie.isSem1 = _sem == "1";
                materie.isSem2 = _sem == "2";

            });

            $("#materii-table").html(
                Mustache.render(template, result));

            $("#materii-table [data-toggle='popover']").popover();
            applyMateriiViewFilters();

        } else {
            console.error("AJAX status: " + result.status);
        }
    })
    .fail(function(req, err) {
        console.error("AJAX error: " + err);
    })
    .always(function() {
        // do sth
    });

}

function applyMateriiViewFilters() {
    var showAbsente = $("#materii-filter-tabs [data-filter='all'],[data-filter='absente']").hasClass("active");
    var showNote = $("#materii-filter-tabs [data-filter='all'],[data-filter='note']").hasClass("active");
    if (showNote)
        $("div[data-type='note']").removeClass("d-none");
    else $("div[data-type='note']").addClass("d-none");
    if (showAbsente)
        $("div[data-type='absente']").removeClass("d-none");
    else $("div[data-type='absente']").addClass("d-none");
}

$(document).ready(function() {

    ajax_updateMaterii();

    $("#materii-filter-tabs [data-filter]").click(function(e) {
        e.preventDefault();
        $("#materii-filter-tabs [data-filter]").removeClass("active");
        $(this).addClass("active");
        applyMateriiViewFilters();
    });

});