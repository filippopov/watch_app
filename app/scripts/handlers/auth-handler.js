handlers.getLoginPage = function (ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    if (ctx.isAuth) {
        ctx.redirect('#/homePage');
        return;
    }

    $('body').removeClass('skin-blue');

    ctx.loadPartials({
        loginForm: './templates/forms/login-form.hbs'
    }).then(function () {
        this.partial('./templates/login.hbs');
    })
};

handlers.getRegisterPage = function (ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    if (ctx.isAuth) {
        ctx.redirect('#/homePage');
        return;
    }

    $('body').removeClass('skin-blue');

    ctx.loadPartials({
        registerForm: './templates/forms/register-form.hbs'
    }).then(function () {
        this.partial('./templates/register.hbs');
    })
};

handlers.getForgotPasswordPage = function (ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    if (ctx.isAuth) {
        ctx.redirect('#/homePage');
        return;
    }

    $('body').removeClass('skin-blue');

    ctx.loadPartials({
        forgotPasswordForm: './templates/forms/forgot-password-form.hbs'
    }).then(function () {
        this.partial('./templates/forgot-password.hbs');
    })
};

handlers.getHomePage = function (ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    if (!ctx.isAuth) {
        ctx.redirect('#/home');
        return;
    }

    $('body').addClass('skin-blue');

    ctx.loadPartials({
        aside: './templates/common/aside.hbs',
        header: './templates/common/header.hbs',
        footer: './templates/common/footer.hbs'
    })
    .then(function () {
        this.partial('./templates/home/home-page.hbs');
    })
};

handlers.forgotPassword = function (ctx) {
    let email = ctx.params.email;

};

handlers.registerUser = function (ctx) {
    let email = ctx.params.email;
    let password = ctx.params.password;
    let repeatPass = ctx.params.repeatPass;

    auth.register(email, password, repeatPass)
        .then((userData) => {
            try {
                userData = $.parseJSON(userData);
                let data = userData.data;
                let message = userData.message;
                let isSuccess = userData.success;

                if (isSuccess) {
                    auth.saveSession(data);
                    notify.showInfo(message);
                    ctx.redirect('#/homePage');
                } else {
                    notify.showError(message);
                }
            }catch(e){
                notify.showError('Error');
            }
        })
};

handlers.loginUser = function (ctx) {
    let email = ctx.params.email;
    let password = ctx.params.password;

    auth.login(email, password)
        .then((userData) => {
            try{
                userData = $.parseJSON(userData);
                let data = userData.data;
                let message = userData.message;
                let isSuccess = userData.success;

                if (isSuccess) {
                    auth.saveSession(data);
                    notify.showInfo(message);
                    ctx.redirect('#/homePage');
                } else {
                    notify.showError(message);
                }
            } catch (e) {
                notify.showError('Error');
            }
        })
};

handlers.logout = function (ctx) {
    let session_id = sessionStorage.getItem('session_id');

    auth.logout(session_id)
        .then((userData) => {
            try{
                userData = $.parseJSON(userData);
                let message = userData.message;
                let isSuccess = userData.success;

                if (isSuccess) {
                    sessionStorage.clear();
                    notify.showInfo(message);
                    ctx.redirect('#/home');
                } else {
                    notify.showError(message);
                }
            } catch (e) {
                notify.showError('Error');
            }
        });
};