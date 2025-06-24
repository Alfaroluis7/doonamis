<template>
    <div>
        <nav class="navbar">
            <a class="navbar-brand" href="#">Doonamis</a>
        </nav>

        <div class="container">
            <div class="row">
                <nav class="col-md-2 d-none sidebar pt-3">
                    <div class="position-sticky">
                        <ul class="nav">
                            <li class="nav-item">
                                <router-link class="nav-link" to="/users">Usuarios</router-link>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="#" @click="logout">Cerrar sesión</a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-10 " style="padding: 40px;">
                    <router-view />
                </main>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'

const router = useRouter()

const logout = () => {
    localStorage.removeItem('auth_token')
    router.push('/')
}
</script>

<style scoped>
.sidebar {
    height: 100vh;
    border-right: 1px solid #dee2e6;
}
</style>
