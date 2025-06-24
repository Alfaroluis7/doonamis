import LoginView from '../views/Login/login.vue'

const routes = [
    {
        path: '/',
        name: 'login',
        component: LoginView,
    },
    {
        path: '/',
        component: () => import('../layouts/mainLayout.vue'),
        children: [
            {
                path: 'users',
                name: 'users',
                component: () => import('../views/Users/user.vue'),
                meta: { requiresAuth: true }    
            }
        ]
    },
];

export default routes;