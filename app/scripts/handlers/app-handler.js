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

    let createWatchForm = await app.getCreateWatchForm();


    createWatchForm = JSON.parse(createWatchForm);

    if (!createWatchForm.success) {
        notify.showError('Error');
        ctx.redirect('#/homePage');
    }

    ctx.brands = createWatchForm.data.brands;
    ctx.genders = createWatchForm.data.genders;
    ctx.movements = createWatchForm.data.movements;
    ctx.caseMaterials = createWatchForm.data.caseMaterials;
    ctx.braceletMaterials = createWatchForm.data.braceletMaterials;
    ctx.braceletColors = createWatchForm.data.braceletColors;
    ctx.claspMaterials = createWatchForm.data.claspMaterials;
    ctx.clasps = createWatchForm.data.clasps;
    ctx.bezelMaterials = createWatchForm.data.bezelMaterials;
    ctx.glass = createWatchForm.data.glass;
    ctx.waterResistance = createWatchForm.data.waterResistance;
    ctx.dial = createWatchForm.data.dial;
    ctx.dialNumerals = createWatchForm.data.dialNumerals;
    ctx.watchFunctions = createWatchForm.data.watchFunctions;
    ctx.watchCharacteristics = createWatchForm.data.watchCharacteristics;

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

handlers.editWatchPost = function (ctx) {
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

    let watch_id = ctx.params.watchId;

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

    app.editWatch(base_caliber, bazel_material, bracelet_color, bracelet_material, brand, caliber,
        calsp_material, case_diameter, case_material, clasp, dial, dial_numerals, frequency,
        gender, glass, model, movement, picture, power_reserve, reference_number, thickness,
        watch_characteristics, watch_functions, water_resistance, number_of_jewels, userId, session_id, watch_id)
        .then((data) => {
            data = $.parseJSON(data);
            let message = data.message;
            let isSuccess = data.success;
            if (isSuccess) {
                notify.showInfo(message);
                ctx.redirect(`#/viewWatch/${watch_id}`);
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

    let watchForm = await app.getEditWatchForm(watchId);


    watchForm = JSON.parse(watchForm);

    if (!watchForm.success) {
        notify.showError('Error');
        ctx.redirect('#/homePage');
    }

    ctx.brands = watchForm.data.brands;
    ctx.genders = watchForm.data.genders;
    ctx.movements = watchForm.data.movements;
    ctx.caseMaterials = watchForm.data.caseMaterials;
    ctx.braceletMaterials = watchForm.data.braceletMaterials;
    ctx.braceletColors = watchForm.data.braceletColors;
    ctx.claspMaterials = watchForm.data.claspMaterials;
    ctx.clasps = watchForm.data.clasps;
    ctx.bezelMaterials = watchForm.data.bezelMaterials;
    ctx.glass = watchForm.data.glass;
    ctx.waterResistance = watchForm.data.waterResistance;
    ctx.dial = watchForm.data.dial;
    ctx.dialNumerals = watchForm.data.dialNumerals;
    ctx.watchFunctions = watchForm.data.watchFunctions;
    ctx.watchCharacteristics = watchForm.data.watchCharacteristics;
    ctx.model = watchForm.data.watchData[0]['model'];
    ctx.referenceNumber = watchForm.data.watchData[0]['reference_number'];
    ctx.caseDiameter = watchForm.data.watchData[0]['case_diameter'];
    ctx.thickness = watchForm.data.watchData[0]['thickness'];
    ctx.caliber = watchForm.data.watchData[0]['caliber'];
    ctx.baseCaliber = watchForm.data.watchData[0]['base_caliber'];
    ctx.powerReserve = watchForm.data.watchData[0]['power_reserve'];
    ctx.numberOfJewels = watchForm.data.watchData[0]['number_of_jewels'];
    ctx.frequency = watchForm.data.watchData[0]['frequency'];



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

    deletePicture = JSON.parse(deletePicture);
    console.log(deletePicture);
    if (deletePicture.success && deletePicture.data) {
        notify.showInfo(deletePicture.message);
    }

    console.log('oppaaaa');
    ctx.redirect(`#/editWatch/${watchId}`);
    return;
};

