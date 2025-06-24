<template>
  <div class="login-wrapper">
    <div class="login-card">
      <h2>Iniciar sesión</h2>
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <input id="email" v-model="email" type="email" required />
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <input id="password" v-model="password" type="password" required />
        </div>

        <button class="btn-submit" type="submit">Entrar</button>

        <div v-if="error" class="error-message">
          {{ error }}
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref  } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api/axios'

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)

const router = useRouter()

const handleLogin = async () => {
    error.value = ''
    loading.value = true

    try {
        const response = await api.post('/auth/login', {
            email: email.value,
            password: password.value
        })

        const token = response.data.token

        localStorage.setItem('auth_token', token)

        router.replace({ path: '/users' })

    } catch (err) {
        console.log(err);
        error.value =
            err.response?.data?.message || 'Error al iniciar sesión. Intenta nuevamente.'
    } finally {
        loading.value = false
    }
}
</script>
