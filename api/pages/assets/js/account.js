function showUpdateAccountForm(){
    let jwt = getCookie('jwt');
    $.post("../validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
        let html = `
            <h2>Atualizar Cadastro</h2>
            <form id='update_account_form'>
                <div class="mb-3">
                    <label for="firstname">Nome</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" required value="` + result.data.firstname + `" />
                </div>
                <div class="mb-3">
                    <label for="lastname">Sobrenome</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" required value="` + result.data.lastname + `" />
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required value="` + result.data.email + `" />
                </div>
                <div class="mb-3">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control" name="password" id="password" required/>
                </div>
                <button type='submit' class='btn btn-primary'>Salvar</button>
            </form>`;

        $('#response').html('');
        $('#content').html(html);

        $('#update_account_form').on('submit', function(){
            let update_account_form=$(this);
            let jwt = getCookie('jwt'); 
            let update_account_form_obj = serializeObject(update_account_form);
            update_account_form_obj.jwt = jwt;
            let form_data=JSON.stringify(update_account_form_obj);

        
            $.ajax({
                url: "../update_user.php",
                type : "POST",
                contentType : 'application/json',
                data : form_data,
                success : function(result) {     
                    $('#response').html("<div class='alert alert-success'>Account was updated.</div>");
                    setCookie("jwt", result.jwt, 1);
                },
                error: function(xhr, resp, text){
                    if(xhr.responseJSON.message=="Unable to update user."){
                        $('#response').html("<div class='alert alert-danger'>Unable to update account.</div>");
                    }else if(xhr.responseJSON.message=="Access denied."){
                        showLoginPage();
                        $('#response').html("<div class='alert alert-success'>Acesso negado.</div>");
                    };
                }
            });
        
            return false;
        });
    }).fail(function(result){
        showLoginPage();
        $('#response').html("<div class='alert alert-danger'>Faça o login para acessar a área de contas de usuário</div>");
    });
};

$('#update_account').on('click', function(){
    showUpdateAccountForm();
});
 
$('#logout').on('click', function(){
    showLoginPage();
    $('#response').html('').css('display', 'inline');
    $('#response').html("<div class='alert alert-info'>You are logged out.</div>");
    document.cookie = '';
    setTimeout(() => {
        $('#response').fadeOut(250)
    }, 1000);
});