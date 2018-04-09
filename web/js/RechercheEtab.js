$("Document").ready(function () {
    $("#jkl").keyup(function () {
        if ($(this).val().length > 0) {
            $.ajax
            ({
                type: 'POST',
                url: 'http://127.0.0.1:8000/BonPlan/JSON/' + $(this).val(),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function(response){
                    $("#fgh").html(response);
                }
            });
        }
        else {
            $("#fgh").html("");
        }
    });
});