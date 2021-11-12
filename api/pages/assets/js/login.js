$('#login').on('click',  function(){
    showLoginPage();
    $('#response').html('').css('display', 'inline');
});

function getCategorias() {
    $.ajax({
        type: "GET",
        url: "https://api.mercadolibre.com/sites/MLB/categories",
        data: null,
        success: response => {
            $.each(response, function (k, v) { 
                $('#categoria').append(`<option value="${v.id}">${v.name}`)
            });
            gravaCategoriaBD(response);
        }
    });
};

function gravaCategoriaBD(val) {
    val.forEach(element => {
        $.ajax({
            type: "post",
            url: "../create_categoria.php",
            data: JSON.stringify(element),
            success: function (response) {
                null;
            },
            error: e =>{
                console.log('Error!');
            }
        });
    });
};

function showLoginPage(){
    setCookie("jwt", "", 1);
 
    let html = `
        <h2>Login</h2>
        <form id='login_form'>
            <div class="mb-3">
                <label for='email' class="form-label">Email:</label>
                <input type='email' class='form-control' id='email' name='email'>
            </div>
 
            <div class="mb-3">
                <label for='password' class="form-label">Senha:</label>
                <input type='password' class='form-control' id='password' name='password'>
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
                setTimeout(() => {
                    getCategorias();
                }, 100);
                
            },
            error: function(xhr, resp, text){
                login_form.find('input').val('');
               
            },
            complete: () => {
                
             }
        });         
        return false;   
    });
};

function setCookie(name, value, exdays) {
    let d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000)); //cookie will last for a day
    let expires = "expires="+ d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
};

function showLoggedOutMenu(){
    $("#login, #sign_up").show();
    $("#logout").hide();
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

function showHomePage(){
    let jwt = getCookie('jwt');
    $.post("../validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
        let html = `
            <form id="categorias_form">
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <select name="categoria" id="categoria" class="form-select">
                        <option value="0" selected>Selecione uma categoria</option>
                    </select>
                </div>
            </form>
            <div id="card">

            </div>`;
 
        $('#content').html(html);
        showLoggedInMenu();
    }).fail(function(result){
        showLoginPage();
        $('#response').html("<div class='alert alert-danger'>Por favor faça o login para ter acesso a consulta</div>");
    });
}
 
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
};
 
function showLoggedInMenu(){
    $("#login, #sign_up").hide();
    $("#logout").show();
};