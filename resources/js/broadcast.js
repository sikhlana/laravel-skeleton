import Echo from "laravel-echo";

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_HOST ?? window.location.href,
    wsPort: process.env.MIX_PUSHER_PORT,
    forceTLS: false,
    disableStats: true,
});
