

var attachmentsCount = 0;

$(document).ready(function() {

    updateFormIds();
    tinymce.init({
        selector: "textarea",
        plugins: "link",
        language: "ro",
        height: 400
    });

    $("#resursa-form").ajaxForm({
        dataType: "json",
        beforeSubmit: function(data_arr) {
            appendLoadingIndicator("#resursa-form-submit");
            // add the content HTML data thing
            data_arr.push({
                name: "continut",
                value: tinymce.activeEditor.getContent()
            });
        },
        complete: function() {
            $("#resursa-form-submit").children("span").remove();
            updateFormIds();
        },
        success: function() {
            $("#resursa-form-submit")
                .prop("disabled", true)
                .html("Asteptati...");
            window.location = "/portal/resurse";
        }
    });

    $("#add-file-button").click(function() {

        var template = $("#file-container-template").html();
        template = $(template);
        // fill in the ids
        template.filter(".file-container-alert").attr("data-index", attachmentsCount);
        template.filter(".file-container").attr("data-index", attachmentsCount);
        template.find("input[type='file']").attr("name", "file[" + attachmentsCount + "]");
        // attach the event handler for the Delete button
        var index = attachmentsCount;
        template.find("button").click(function() {
            $(".file-container[data-index='" + index + "']").remove();
            $(".file-container-alert[data-index='" + index + "']").remove();
        });
        // code for the Browse thing
        template.find(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        // put the template in the right place
        $("#files-container").append(template);
        attachmentsCount++;

    });

});