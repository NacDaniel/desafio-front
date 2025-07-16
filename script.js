$(document).ready(function () {
    $("#formbutton").on("click", function () {
        data = {}
        data["nome"] = $("#nome").val()
        data["email"] = $("#email").val()
        $.ajax({
            accepts: 'application/json',
            type: "POST",
            dataType: "JSON",
            url: "/src/form.php",
            data: JSON.stringify(data),
        }).done(function (response) {
            alert(response.message)
        }).fail(function (jqXHR, textStatus) {
            alert(jqXHR.responseJSON.message)
        });
    })
})
