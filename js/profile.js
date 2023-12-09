function saveChanges() {
    var dob = $("#dob").val();
    var contactn = $("#contactNumber").val();
    var orage = $("#age").val(); 
    var username = $("#username").val();
    var email = $("#email").val();

    if (contactn) {
        $.ajax({
            type: 'POST',
            url: '/guvi/php/profile.php',
            data: JSON.stringify({
                dob: dob,
                age: orage, 
                contactnumber: contactn,
                username:username,
                email:email
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                alert(response.message);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    }
}