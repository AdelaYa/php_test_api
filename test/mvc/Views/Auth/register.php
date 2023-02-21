<div class="registration">
    <form action='' method="post" class="register_form">

        <h1>Регистрация</h1>

        <input type="text" id="register_login" name="register_login" placeholder="Логин">
        <input type="password" id="register_password" name="register_password" placeholder="Пароль">
        <input type="submit" value="Регистрация" name="authClick">

    </form>
</div>
<div id="results">
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.register_form').on('submit', function (e) {
            e.preventDefault();
            $(".error").remove();
            console.log($('#register_login').val());
            console.log($('#register_password').val());

            var $hasErrors = false
            var login = $('#register_login').val();

            if ($('#register_login').val().length <= 5) {
                $('#register_login').after('<br><span class="error">Длина логина должна быть <strong>более 5 символов</span>');
                $hasErrors = true
            }

            if (!login.match(/.+@/)) {
                $('#register_login').after('<br><span class="error">Логин должен содержать <strong>символ "@"</span>');
                $hasErrors = true
            }

            var password = $('#register_password').val();
            if (password.length <= 3) {
                $('#register_password').after('<br><span class="error">Длина пароля должна быть <strong>более 3 символов</strong></span>');
                $hasErrors = true

            }
            if (!$hasErrors) {
                $.ajax({
                    type: "POST",
                    url: "/auth/register",
                    data: {"register_login": login, "register_password": password},
                    success: function (data) {
                        $('#results').html(data);
                        window.location.href = "/index/index";

                    }
                });
            }
        });

    });
</script>

