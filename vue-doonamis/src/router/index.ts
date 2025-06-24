import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: routes,
})


router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('auth_token')

    console.log(to);
    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: 'login' })
    } else if (to.fullPath === '/' && isAuthenticated) {
        next({ name: 'users' })
    }else 
        next()
})

export default router
