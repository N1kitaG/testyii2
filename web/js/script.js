$(document).ready(function() {

    $("#findcurrenciesbydate-dateid").on("change", function() {
        location.href = '?dateID=' + $(this).val();
    });

});