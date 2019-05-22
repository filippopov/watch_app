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

    function addWatch(base_caliber, bazel_material, bracelet_color, bracelet_material, brand, caliber, calsp_material, case_diameter, case_material, clasp, dial, dial_numerals, frequency, gender, glass, model, movement, picture, power_reserve, reference_number, thickness, watch_characteristics, watch_functions, water_resistance, number_of_jewels, userId, sessionId) {

        let obj = {base_caliber, bazel_material, bracelet_color, bracelet_material, brand, caliber,
            calsp_material, case_diameter, case_material, clasp, dial, dial_numerals, frequency,
            gender, glass, model, movement, picture, power_reserve, reference_number, thickness,
            watch_characteristics, watch_functions, water_resistance, number_of_jewels, userId, sessionId};

        return remote.post('home', 'addWatch', '', obj);
    }

    return {
        addSkinClass,
        getBrands,
        addWatch
    }
})();