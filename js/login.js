function submitLogin(username)
{
    // var username=$("#username").val();
    $.ajax({
        type: 'GET',
        url: '/guvi/php/profile.php',
        data:{
            username:username,
        },
        contentType: "application/json; charset=utf-8",
        dataType:"json",
        success: function (response) {
            console.log(response);
            if(response.username)
            {
                localStorage.setItem("rusername", response.username);
            }
            if(response.email)
            {
                localStorage.setItem("remail", response.email);
            }
            if(response.dob)
            {
                localStorage.setItem("rdob", response.dob);
            }
            if(response.age)
            {
                localStorage.setItem("rage", response.age);
            }
            if(response.contact)
            {
                localStorage.setItem("rcontact", response.contact);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + " - " + error);
        }
    });
    
}
function newsubmit() {
    var username = $("#username").val();
    var password = $("#password").val();
    if (username && password) {
        $.ajax({
            type: 'POST',
            url: '/guvi/php/login.php',
            data: JSON.stringify({
                username: username,
                password: password
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                alert(response.message);  
                
                if (response.status === "success") {
                    submitLogin(response.username);
                    window.location.href = 'profile.html';
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    } else {
        alert("Please enter both username and password.");
    }
}
