$(document).ready(function() {
    $("#confirmAgain").on('click', function() {
        console.log("OKI-DOKI");
        $.post("/account/new_conf", {}, function(data) {
            if (data) {
                $("#okAlert").show('fade');
                $("#confirmAgain").hide();
            } else {
                $("#wrongAlert").show('fade');
                $("#confirmAgain").hide();
            }
        });
    });
});
