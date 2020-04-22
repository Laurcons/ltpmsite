
// https://stackoverflow.com/questions/1349404/generate-random-string-characters-in-javascript
function generateKey(length = 10) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

function hideFormErrors(form) {

	$("div[data-form='" + form + "']").addClass("d-none");

}

function showFormError(form, field, text) {

	var selector = "div[data-form='" + form + "'][data-for='" + field + "']";
	$(selector).html(text);
	$(selector).removeClass("d-none");

}

function updateFormIds(selector = "[name='form-id']") {

   // form ids
   $(selector).each(function() {
      $(this).val(generateKey());
   });

}

function urlGet(param) {

   var searchParams = new URLSearchParams(window.location.search);
   return searchParams.get(param);

}

function urlId() {

   // ia id-ul din URL, fara query
   // taie query
   var noquery = window.location.href.split("?")[0];
   // taie restul url-ului
   var id = noquery.substring(noquery.lastIndexOf("/") + 1);

   return id;

}

function appendLoadingIndicator(selector) {

   $(selector)
      .append(
         $("<span>")
            .addClass("spinner-border spinner-border-sm"));

}

function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

//// MODAL FORMS

function createModalForm(options) {

   // options it should have:
   //  modal: the modal jquery object
   //  form: the form jquery object
   //  formErrorName: name for form errors
   //  action: the URL to POST to
   //  on_open: on modal open event
   //  bind_data: array, contains the data fields name from the
   //   relatedTarget button to put into the form data
   //  validator: validation function
   //  on_ajax_success(result, modal, form)
   //  on_ajax_nonsuccess(result, modal, form)
   //  on_ajax_fail(req, error)
   //  on_ajax_complete(modal, form)

   options.modal.on("show.bs.modal", function(e) {

      if (options.bind_data != null) {
         options.bind_data.forEach(function(item) {

            $("#" + options.form.attr("id") + " [name='" + item + "']")
               .val(
                  $(e.relatedTarget).data(item));

         });
      }

      if (options.formErrorName != null)
         hideFormErrors(options.formErrorName);

   });

   if (options.on_open != null)
      options.modal.on("show.bs.modal", options.on_open);

   options.form.submit(function(e) {

      e.preventDefault();

      if (options.validator != null)
         if (!options.validator())
            return;

      if (options.formErrorName != null)
         hideFormErrors(options.formErrorName);

      $("[form='" + options.form.attr("id") + "'][type='submit']")
         .append(
            $("<span>")
               .addClass("spinner-border spinner-border-sm"));

      $.ajax({
         url: options.action,
         method: "POST",
         dataType: "json",
         data: $(this).serialize(),
         success: function(result) {
      
            if (result.status == "success") {
               if (options.on_ajax_success != null)
                  options.on_ajax_success(result, options.modal, options.form);
            } else {
               console.error("AJAX status: " + result.status);
               if (options.on_ajax_nonsuccess != null)
                  options.on_ajax_nonsuccess(result, options.modal, options.form);
            }
      
         },
         error: function(req, err) {
            console.error("AJAX failed: " + err);
            if (options.on_ajax_fail != null)
               options.on_ajax_fail(req, err);
         },
         complete: function() {
            updateFormIds();
            if (options.on_ajax_complete != null)
               options.on_ajax_complete(options.modal, options.form);
            $("[form='" + options.form.attr("id") + "'][type='submit']")
               .children("span")
                  .remove();
         }
      
      });

   });

}