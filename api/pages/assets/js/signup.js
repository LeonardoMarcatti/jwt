$('#sign_up').on('click', function(){

    var html = `
        <h2>Sign Up</h2>
        <form id='sign_up_form'>
            <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" name="firstname" id="firstname" required />
            </div>

            <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" name="lastname" id="lastname" required />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required />
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">Repeat Password</label>
                <input type="password" class="form-control" name="password2" id="password2" required />
            </div>

            <button type='submit' id="submit" class='btn btn-light' disabled>Sign Up</button>
        </form>
        `;

    
    $('#content').html(html);
    $('#response').html('');

    $('#password2').on('keyup', function () { 
        if ($('#password').val() == $('#password2').val() && $('#password').val() != '' && $('#password2').val() != '') {
            $('#submit').removeAttr('disabled');
            $('#submit').removeClass('btn-light');
            $('#submit').addClass('btn-primary');
        } else{
            $('#submit').attr('disabled', '');
            $('#submit').removeClass('btn-primary');
            $('#submit').addClass('btn-light');
        };
    });

    $('#password2').on('blur', function () { 
        if ($('#password').val() != $('#password2').val() && $('#password').val() != '' && $('#password2').val() != '') {
            alert('Confira suas senhas!');
        };
     });


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

    $('#sign_up_form').on('submit', function(){
            let sign_up_form=$(this);
            let form_data=JSON.stringify(serializeObject(sign_up_form));
            $.ajax({
                type : "POST",
                url: "../create_user.php",                
                contentType : 'application/json',
                data : form_data,
                success : function(result) {
                    $('#response').html("<div class='alert alert-success'>Successful sign up. Please login.</div>");
                    sign_up_form.find('input').val('');
                },
                error: function(xhr, resp, text){
                    $('#response').html("<div class='alert alert-danger'>Unable to sign up. Please contact admin.</div>");
                },
                complete: function (e) { 
                    $('#submit').attr('disabled', '');
                    $('#submit').removeClass('btn-primary');
                    $('#submit').addClass('btn-light');
                 }
            });

        return false;
    });
});
