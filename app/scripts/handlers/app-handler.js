handlers.getHomePage = async function (ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    if (!ctx.isAuth) {
        ctx.redirect('#/home');
        return;
    }

    app.addSkinClass();

    ctx.dashboard = true;
    ctx.watchCollection = true;
    ctx.addWatch = false;

    let watchesData = await app.getWatchesModels();

    watchesData = JSON.parse(watchesData);

    ctx.watchesData = watchesData.data;

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

    let brands = await app.getBrands();


    brands = JSON.parse(brands);

    if (!brands.success) {
        notify.showError('Error');
        ctx.redirect('#/homePage');
    }

    ctx.brands = brands.data.brands;
    ctx.genders = brands.data.genders;
    ctx.movements = brands.data.movements;
    ctx.caseMaterials = brands.data.caseMaterials;
    ctx.braceletMaterials = brands.data.braceletMaterials;
    ctx.braceletColors = brands.data.braceletColors;
    ctx.claspMaterials = brands.data.claspMaterials;
    ctx.clasps = brands.data.clasps;
    ctx.bezelMaterials = brands.data.bezelMaterials;
    ctx.glass = brands.data.glass;
    ctx.waterResistance = brands.data.waterResistance;
    ctx.dial = brands.data.dial;
    ctx.dialNumerals = brands.data.dialNumerals;
    ctx.watchFunctions = brands.data.watchFunctions;
    ctx.watchCharacteristics = brands.data.watchCharacteristics;

    ctx.dashboard = true;
    ctx.watchCollection = false;
    ctx.addWatch = true;

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

handlers.createWatch = function (ctx) {
    let base_caliber = ctx.params.base_caliber;
    let bazel_material = ctx.params.bazel_material;
    let bracelet_color = ctx.params.bracelet_color;
    let bracelet_material = ctx.params.bracelet_material;
    let brand = ctx.params.brand;
    let caliber = ctx.params.caliber;
    let calsp_material = ctx.params.calsp_material;
    let case_diameter = ctx.params.case_diameter;
    let case_material = ctx.params.case_material;
    let clasp = ctx.params.clasp;
    let dial = ctx.params.dial;
    let dial_numerals = ctx.params.dial_numerals;
    let frequency = ctx.params.frequency;
    let gender = ctx.params.gender;
    let glass = ctx.params.glass;
    let model = ctx.params.model;
    let movement = ctx.params.movement;
    let picture = ctx.params.picture;
    let power_reserve = ctx.params.power_reserve;
    let reference_number = ctx.params.reference_number;
    let thickness = ctx.params.thickness;
    let watch_characteristics = ctx.params['watch_characteristics[]'];
    let watch_functions = ctx.params['watch_functions[]'];
    let water_resistance = ctx.params.water_resistance;
    let number_of_jewels = ctx.params.number_of_jewels;

    if (brand === '') {
        notify.showError('Please choose brand!');
        return;
    }

    if (model === '') {
        notify.showError('Please add model!');
        return;
    }

    let userId = sessionStorage.getItem('userId');
    let session_id = sessionStorage.getItem('session_id');

    app.addWatch(base_caliber, bazel_material, bracelet_color, bracelet_material, brand, caliber,
        calsp_material, case_diameter, case_material, clasp, dial, dial_numerals, frequency,
    gender, glass, model, movement, picture, power_reserve, reference_number, thickness,
    watch_characteristics, watch_functions, water_resistance, number_of_jewels, userId, session_id)
        .then((data) => {
            data = $.parseJSON(data);
            let message = data.message;
            let isSuccess = data.success;
            if (isSuccess) {
                notify.showInfo(message);
                ctx.redirect('#/homePage');
            } else {
                console.log(message);
                notify.showError(message);
            }
        })
};

handlers.viewWatch = async function(ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    let watchId = ctx.params.watchId;

    ctx.watch_id = watchId;

    let isWatchExist = await app.isWatchExist(watchId);

    isWatchExist = JSON.parse(isWatchExist);

    if (!isWatchExist.success) {
        ctx.redirect('#/home');
        return
    }

    if (isWatchExist.data.length == 0) {
        ctx.redirect('#/home');
        return
    }

    if (!ctx.isAuth) {
        ctx.redirect('#/home');
        return;
    }

    app.addSkinClass();

    let watchPictures = await app.getWatchPictures(watchId);
    let watchData = await app.getWatchData(watchId);
    let watchFunctions = await app.getWatchFunctions(watchId);
    let watchCharacteristics = await app.getWatchCharacteristics(watchId);

    watchPictures = JSON.parse(watchPictures);
    watchData = JSON.parse(watchData);
    watchFunctions = JSON.parse(watchFunctions);
    watchCharacteristics = JSON.parse(watchCharacteristics);

    ctx.watchPictures = watchPictures.data;
    ctx.watchData = watchData.data;

    let watchFunctionsArray = [];
    watchFunctions.data.forEach((e, i) => {
        watchFunctionsArray.push(e.watch_function_name);
    });

    let watchCharacteristicsArray = [];
    watchCharacteristics.data.forEach((e, i) => {
        watchCharacteristicsArray.push(e.watch_characteristic_name);
    });

    ctx.watchFunctions = watchFunctionsArray.join(', ');
    ctx.watchCharacteristics = watchCharacteristicsArray.join(', ');

    ctx.dashboard = true;
    ctx.watchCollection = false;
    ctx.addWatch = false;

    ctx.loadPartials({
            aside: './templates/common/aside.hbs',
            header: './templates/common/header.hbs',
            footer: './templates/common/footer.hbs',
            content: './templates/home/view-watch-info.hbs'
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

    let brands = await app.getBrands();


    brands = JSON.parse(brands);

    if (!brands.success) {
        notify.showError('Error');
        ctx.redirect('#/homePage');
    }

    ctx.brands = brands.data.brands;
    ctx.genders = brands.data.genders;
    ctx.movements = brands.data.movements;
    ctx.caseMaterials = brands.data.caseMaterials;
    ctx.braceletMaterials = brands.data.braceletMaterials;
    ctx.braceletColors = brands.data.braceletColors;
    ctx.claspMaterials = brands.data.claspMaterials;
    ctx.clasps = brands.data.clasps;
    ctx.bezelMaterials = brands.data.bezelMaterials;
    ctx.glass = brands.data.glass;
    ctx.waterResistance = brands.data.waterResistance;
    ctx.dial = brands.data.dial;
    ctx.dialNumerals = brands.data.dialNumerals;
    ctx.watchFunctions = brands.data.watchFunctions;
    ctx.watchCharacteristics = brands.data.watchCharacteristics;

    ctx.dashboard = true;
    ctx.watchCollection = false;
    ctx.addWatch = true;

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

handlers.deleteWatch = async function(ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    let watchId = ctx.params.watchId;

    if (!ctx.isAuth) {
        ctx.redirect('#/home');
        return;
    }

    //$('.modal-backdrop').remove();

    app.addSkinClass();

    let deleteWatch = await app.deleteWatch(watchId);

    deleteWatch = JSON.parse(deleteWatch);

    if (deleteWatch.success && deleteWatch.data) {
        ctx.redirect('#/home');
        return;
    }

    ctx.redirect(`#/viewWatch/${watchId}`);
    return;
};

handlers.getEditWatchForm = async function (ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    let watchId = ctx.params.watchId;

    ctx.watch_id = watchId;

    let isWatchExist = await app.isWatchExist(watchId);

    isWatchExist = JSON.parse(isWatchExist);

    if (!isWatchExist.success) {
        ctx.redirect('#/home');
        return
    }

    if (isWatchExist.data.length == 0) {
        ctx.redirect('#/home');
        return
    }

    if (!ctx.isAuth) {
        ctx.redirect('#/home');
        return;
    }

    app.addSkinClass();

    let watchPictures = await app.getWatchPictures(watchId);
    watchPictures = JSON.parse(watchPictures);
    ctx.watchPictures = watchPictures.data;

    let brands = await app.getBrands();


    brands = JSON.parse(brands);

    if (!brands.success) {
        notify.showError('Error');
        ctx.redirect('#/homePage');
    }

    ctx.brands = brands.data.brands;
    ctx.genders = brands.data.genders;
    ctx.movements = brands.data.movements;
    ctx.caseMaterials = brands.data.caseMaterials;
    ctx.braceletMaterials = brands.data.braceletMaterials;
    ctx.braceletColors = brands.data.braceletColors;
    ctx.claspMaterials = brands.data.claspMaterials;
    ctx.clasps = brands.data.clasps;
    ctx.bezelMaterials = brands.data.bezelMaterials;
    ctx.glass = brands.data.glass;
    ctx.waterResistance = brands.data.waterResistance;
    ctx.dial = brands.data.dial;
    ctx.dialNumerals = brands.data.dialNumerals;
    ctx.watchFunctions = brands.data.watchFunctions;
    ctx.watchCharacteristics = brands.data.watchCharacteristics;

    ctx.dashboard = true;
    ctx.watchCollection = false;
    ctx.addWatch = false;

    ctx.loadPartials({
            aside: './templates/common/aside.hbs',
            header: './templates/common/header.hbs',
            footer: './templates/common/footer.hbs',
            content: './templates/forms/edit-watch-form.hbs'
        })
        .then(function () {
            this.partial('./templates/home/home-page.hbs');
        })
};

handlers.deletePicture = async function (ctx) {
    ctx.isAuth = auth.isAuth();
    ctx.user_id = sessionStorage.getItem('userId');

    let pictureId = ctx.params.pictureId;
    let watchId = ctx.params.watchId;

    if (!ctx.isAuth) {
        ctx.redirect('#/home');
        return;
    }

    app.addSkinClass();

    let deletePicture = await app.deletePicture(pictureId, watchId);

    //deletePicture = JSON.parse(deletePicture);
    //
    //if (deleteWatch.success && deleteWatch.data) {
    //    ctx.redirect('#/home');
    //    return;
    //}
    //
    //ctx.redirect(`#/editWatch/${watchId}`);
    //return;
};

