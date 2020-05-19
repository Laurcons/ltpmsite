

$(document).ready(function() {

    $("#login-form").submit(function(e) {

        hideFormErrors("login-form");
        appendLoadingIndicator("#login-form-submit");

        e.preventDefault();

        var redir = urlGet("redir");
        var url = "";
        if (redir == null)
            url = "/portal/logare/post/";
        else url = "/portal/logare/post/?redir=" + encodeURI(redir);

        $.ajax({
            url: url,
            data: $(this).serialize(),
            method: "POST",
            dataType: "json"})
        .done(function(result) {
            if (result.status == "success") {
                
                $("#login-form-submit")
                    .html("Așteptați...")
                    .prop("disabled", true);
                window.location = result.redir;

            } else if (result.status == "username-not-found") {
                showFormError("login-form", "login", "Numele de utilizator dat nu a fost găsit!");
            } else if (result.status == "password-failed") {
                showFormError("login-form", "login", "Parola dată nu este corectă!");
            } else {
                showFormError("login-form", "login", "A apărut o eroare necunoscută: status " + result.status);
            }
        })
        .fail(function(req, err) {
            console.error("AJAX error: " + err);
            showFormError("login-form", "login", "A apărut o eroare necunoscută: " + err);
        })
        .always(function() {
            $("#login-form-submit").children("span").remove();
        });

    });

});