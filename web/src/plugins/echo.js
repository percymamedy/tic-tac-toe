import Echo from 'laravel-echo';
import io from 'socket.io-client';

export default new Echo({
    broadcaster: 'socket.io',
    client: io,
    host: window.location.hostname + ':6001',
    path: '/socket.io/'
});
