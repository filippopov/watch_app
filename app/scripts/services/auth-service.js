let auth = (() => {
    function isAuth() {
        return sessionStorage.getItem('userId') !== null;
    }

    function saveSession(userData) {
        sessionStorage.setItem('session_id', userData.session_id);
        sessionStorage.setItem('userId', userData.user_id);
    }

    function register (email, password, repeatPass) {
        let obj = {email, password, repeatPass};

        return remote.post('user', 'register', '', obj);
    }

    function login(email, password) {
        let obj = {email, password};

        return remote.post('user', 'login', '', obj)
    }

    function logout(session_id) {
        let obj = {session_id};
        return remote.post('user', 'logout', '', obj);
    }

    return {
        isAuth,
        login,
        logout,
        register,
        saveSession
    }
})();