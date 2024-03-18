import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'app-key',
    wsHost: 'localhost',
    wsPort: 6002,
    wssPort: 6002,
    forceTLS: 'http',
    enabledTransports: ['ws', 'wss'],
});
