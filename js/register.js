function submitRegister() {
    var username = $("#username").val();
    var password = $("#password").val();
    var email = $("#email").val();
    if (username && password && email) {
        $.ajax({
            type: 'POST',
            url: '/guvi/php/register.php',
            data: JSON.stringify({
                username: username,
                password: password,
                email: email
            }),
            contentType: "application/json; charset=utf-8",
            dataType:"json",
            success: function (response) {
                alert(response.message);
                if (response.status === "success") {
                    window.location.href = 'login.html';
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    } else {
        alert("Please fill all the blanks !!");
    }
}
