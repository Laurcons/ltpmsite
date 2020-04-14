
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

function appendLoadingIndicator(selector) {

   $(selector)
      .append(
         $("<span>")
            .addClass("spinner-border spinner-border-sm"));

}