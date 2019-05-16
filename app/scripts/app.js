const handlers = {};

$(() => {
    // Define routes here using Sammy.js
    const app = Sammy('.wrapper', function () {
        this.use('Handlebars', 'hbs');

        this.get('index.html', handlers.getLoginPage);
        this.get('#/home', handlers.getLoginPage);
        this.get('#/registerPage', handlers.getRegisterPage);
        this.get('#/forgotPasswordPage', handlers.getForgotPasswordPage);
        this.get('#/homePage', handlers.getHomePage);

        this.post('#/forgotPassword', handlers.forgotPassword);
        this.post('#/register', handlers.registerUser);
        this.post('#/login', handlers.loginUser);
        this.get('#/logout', handlers.logout);

    });

    app.run();
});