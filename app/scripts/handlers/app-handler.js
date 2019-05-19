handlers.getHomePage = function (ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    if (!ctx.isAuth) {
        ctx.redirect('#/home');
        return;
    }

    app.addSkinClass();

    ctx.loadPartials({
            aside: './templates/common/aside.hbs',
            header: './templates/common/header.hbs',
            footer: './templates/common/footer.hbs',
            content: './templates/home/home-page-content.hbs'
        })
        .then(function () {
            this.partial('./templates/home/home-page.hbs');
        })
};


handlers.getWatchForm = async function (ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    if (!ctx.isAuth) {
        ctx.redirect('#/home');
        return;
    }

    app.addSkinClass();
    $( "#accordion" ).accordion();

    let brands = await app.getBrands();

    try {
        brands = $.parseJSON(brands);

        if (!brands.success) {
            notify.showError('Error');
            ctx.redirect('#/homePage');
        }

        ctx.brands = brands.data.brands;
        ctx.genders = brands.data.genders;
        ctx.movements = brands.data.movements;
        ctx.caseMaterials = brands.data.caseMaterials;
        ctx.braceletMaterials = brands.data.braceletMaterials;
    }catch (e){
        notify.showError('Error');
    }


    ctx.loadPartials({
            aside: './templates/common/aside.hbs',
            header: './templates/common/header.hbs',
            footer: './templates/common/footer.hbs',
            content: './templates/forms/add-watch-form.hbs'
        })
        .then(function () {
            this.partial('./templates/home/home-page.hbs');
        })
};
