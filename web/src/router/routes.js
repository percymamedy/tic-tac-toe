function view(path) {
    return () => import(/* webpackChunkName: '' */ `./../views/${path}`).then(m => m.default || m);
}

export default [
    {
        path: '/',
        name: 'app.home',
        component: view('Home.vue')
    },
    {
        path: '/games/:game',
        name: 'app.game.play',
        component: view('GameBoard.vue')
    },
    {
        path: '*',
        name: 'app.errors.404',
        component: view('errors/404.vue')
    }
];
