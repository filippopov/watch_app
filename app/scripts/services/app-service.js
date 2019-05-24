let app = (() => {
    function addSkinClass() {
        $('body').addClass('skin-blue');
    }

    function getBrands () {
        let userId = sessionStorage.getItem('userId');
        let session_id = sessionStorage.getItem('session_id');

        let obj = {userId, session_id};

        return remote.post('home', 'getWatchFormData', '', obj);
    }

    function getWatchPictures (watch_id) {
        let user_id = sessionStorage.getItem('userId');
        let session_id = sessionStorage.getItem('session_id');

        let obj = {user_id, session_id, watch_id};

        return remote.post('home', 'watchPictures', '', obj);
    }

    function getWatchesModels () {
        let userId = sessionStorage.getItem('userId');
        let session_id = sessionStorage.getItem('session_id');

        let obj = {userId, session_id};

        return remote.post('home', 'homePage', '', obj);
    }

    function addWatch(base_caliber, bazel_material, bracelet_color, bracelet_material, brand, caliber, calsp_material, case_diameter, case_material, clasp, dial, dial_numerals, frequency, gender, glass, model, movement, picture, power_reserve, reference_number, thickness, watch_characteristics, watch_functions, water_resistance, number_of_jewels, userId, session_id) {

        let obj = {base_caliber, bazel_material, bracelet_color, bracelet_material, brand, caliber,
            calsp_material, case_diameter, case_material, clasp, dial, dial_numerals, frequency,
            gender, glass, model, movement, picture, power_reserve, reference_number, thickness,
            watch_characteristics, watch_functions, water_resistance, number_of_jewels, userId, session_id};

        return remote.post('home', 'addWatch', '', obj);
    }

    return {
        addSkinClass,
        getBrands,
        addWatch,
        getWatchesModels,
        getWatchPictures
    }
})();