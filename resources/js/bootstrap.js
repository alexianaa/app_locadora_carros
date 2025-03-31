window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });


/**
 * Interceptar os requests das aplicações
 */
axios.interceptors.request.use(
    config => {
        // definir para todas as requisições accept e authorization
        config.headers['Accept'] = 'application/json'

        let token = document.cookie
            .split(';')
            .find(index => {
                return index.includes('token')
            })
            .split('=');

        token = 'Bearer ' + token[1]

        config.headers['Authorization'] = token

        return config
    },
    error => {
        console.log('erro da requisicao', error)
        return Promise.reject(error)
    }
)

/**
 * Interceptar os responses da aplicação
 */
axios.interceptors.response.use(
    response => {
        console.log('interceptando a resposta antes do envio', response)
        return response
    },
    error => {
        if(error.response.status == 401 && error.response.data.message == 'Token has expired'){
            axios.post("http://localhost:8000/api/refresh")
                .then(response => {
                    document.cookie = 'token=' + response.data;
                    window.location.reload()
                })
        }
        return Promise.reject(error)
    }
)