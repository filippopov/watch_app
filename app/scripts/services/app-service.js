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

    return {
        addSkinClass,
        getBrands
    }
})();