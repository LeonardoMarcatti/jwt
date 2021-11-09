$('#login').on('click',  function(){
    showLoginPage();
});

function setCookie(name, value, exdays) {
    let d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000)); //cookie will last for a day
    let expires = "expires="+ d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
};

function showLoggedOutMenu(){
    $("#logout").show();
};

function serializeObject(val) {
    let object = {};
    let a = val.serializeArray();
    $.each(a, function() {
        if (object[this.name] !== undefined) {
            if (!object[this.name].push) {
                object[this.name] = [object[this.name]];
            }
            object[this.name].push(this.value || '');
        } else {
            object[this.name] = this.value || '';
        }
    });
    return object;
};

function showLoginPage(){
    setCookie("jwt", "", 1);
 
    let html = `
        <h2>Login</h2>
        <form id='login_form'>
            <div class="mb-3">
                <label for='email' class="form-label">Email address</label>
                <input type='email' class='form-control' id='email' name='email' placeholder='Enter email'>
            </div>
 
            <div class="mb-3">
                <label for='password' class="form-label">Password</label>
                <input type='password' class='form-control' id='password' name='password' placeholder='Password'>
            </div>
 
            <button type='submit' class='btn btn-primary'>Login</button>
        </form>
        `;
 
    $('#content').html(html);
    $('#response').html('');
    showLoggedOutMenu();

    $('#login_form').on('submit', function(){
 
        let login_form=$(this);
        let form_data=JSON.stringify(serializeObject(login_form));
    
        $.ajax({
            url: "../login.php",
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result){
                setCookie("jwt", result.jwt, 1);
                showHomePage();
                $('#response').html("<div class='alert alert-success'>Successful login.</div>");
            },
            error: function(xhr, resp, text){
                $('#response').html("<div class='alert alert-danger'>Login failed. Email or password is incorrect.</div>");
                login_form.find('input').val('');
            }
        });
        return false;   
    });
};

function showHomePage(){
    let jwt = getCookie('jwt');
    $.post("../validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
        var html = `
            <div class="card">
                <div class="card-header">Welcome to Home!</div>
                <div class="card-body">
                    <h5 class="card-title">You are logged in.</h5>
                    <p class="card-text">You won't be able to access the home and account pages if you are not logged in.</p>
                </div>
            </div>
            `;
 
        $('#content').html(html);
        showLoggedInMenu();
    });
 
    // show login page on error will be here
}

$.post("url", data,
    function (data, textStatus, jqXHR) {
        
    },
    "dataType"
);
 
function getCookie(cname){
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' '){
            c = c.substring(1);
        };
 
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        };
    };
    return "";
}
 
function showLoggedInMenu(){
    // hide login and sign up from navbar & show logout button
    $("#login, #sign_up").hide();
    $("#logout").show();
}





