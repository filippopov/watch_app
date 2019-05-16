let remote = (() => {
    const BASE_URL = 'http://localhost/watch_app/api/';

    function makeRequest(method, controller, action, params) {
        return {
            url: BASE_URL + controller + '/' + action,
            method: method
        }
    }

    function get (controller, action, params) {
        return $.ajax(makeRequest('GET', controller, action, params));
    }

    function post (controller, action, params, data) {
        let obj = makeRequest('POST', controller, action, params);

        if (data) {
            obj.data = data;
        }
        return $.ajax(obj);
    }

    function update(controller, action, params, data) {
        let obj = makeRequest('PUT', controller, action, params);
        obj.data = data;
        return $.ajax(obj);
    }

    function remove(controller, action, params) {
        return $.ajax(makeRequest('DELETE', controller, action, params));
    }

    return {
        get,
        post,
        update,
        remove
    }
})();