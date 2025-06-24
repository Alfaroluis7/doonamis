<template>
    <div class="container ">
        <h2>Usuarios</h2>


        <div v-if="mensaje.texto" :class="'alert alert-' + (mensaje.tipo || 'info')">
            {{ mensaje.cantidad > 1 ? mensaje.cantidad + ' ' : '' }} {{ mensaje.texto }}
        </div>

        <carga-csv @cambiaMensaje="cambiaMensaje"/>

        <table class="table table-bordered table-hover ">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Direccion</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(usuario, index) in usuarios" :key="usuario.id">
                    <td>{{ usuario.id }}</td>
                    <td>{{ usuario.nombre }} {{ usuario.apellidos }}</td>
                    <td>{{ usuario.email }}</td>
                    <td>{{ usuario.telefono }}</td>
                    <td>{{ usuario.direccion }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" @click="eliminarUsuario(usuario.id, index)">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <nav v-if="totalPaginas > 1" aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item" >
                    <a style="cursor: pointer;" class="page-link" :class="{ disabled: paginaActual === 1 }"
                        @click.prevent="irPagina(paginaActual - 1)">Anterior</a>
                </li>

                <li class="page-item" v-for="n in totalPaginas" :key="n" >
                    <a style="cursor: pointer;" class="page-link" :class="{ active: paginaActual === n }" @click.prevent="irPagina(n)">{{ n }}</a>
                </li>

                <li class="page-item" >
                    <a style="cursor: pointer;" class="page-link" :class="{ disabled: paginaActual === totalPaginas }"
                        @click.prevent="irPagina(paginaActual + 1)">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import cargaCsv from '../../components/cargaCsv.vue'
import api from '@/api/axios'

const usuarios = ref<any[]>([])
const paginaActual = ref(1)
const totalPaginas = ref(1)

const mensaje = ref({
    cantidad: 0,
    texto: '',
    tipo: ''
})


const route = useRoute()
const router = useRouter()

const cambiaMensaje = (texto: string, tipo: string = 'info', cantidad:number = 0) => {
    mensaje.value.texto = texto
    mensaje.value.tipo = tipo
    mensaje.value.cantidad += cantidad
    console.log(mensaje.value);
    setTimeout(() => {
        mensaje.value.texto = ''
        mensaje.value.tipo = ''
        mensaje.value.cantidad--;
        if (mensaje.value.cantidad < 0) {
            mensaje.value.cantidad = 0;
        }   
    }, 5000)
}

const cargarUsuarios = async () => {
    const page = parseInt(route.query.page as string) || 1
    paginaActual.value = page

    try {
        const res = await api.get('/usuarios', { params: { page } })

        usuarios.value = res.data.data
        totalPaginas.value = res.data.last_page
    } catch (error) {
        console.error('Error al cargar usuarios', error)
    }
}

const eliminarUsuario = async (id: number, index: number) => {
    if (!confirm('¿Estás seguro de que quieres eliminar este usuario?')) return

    try {
        await api.delete(`/usuarios/${id}`)
        usuarios.value.splice(index, 1);
        cambiaMensaje('Usuarios eliminado correctamente', 'success', 1)
    } catch (error) {
        cambiaMensaje('Error al eliminar usuario', 'danger')
        console.error('Error al eliminar usuario', error)
    }
}

const irPagina = (pagina: number) => {
    if (pagina < 1 || pagina > totalPaginas.value) return
    router.push({ query: { ...route.query, page: pagina } })
}

onMounted(cargarUsuarios)
watch(() => route.query.page, cargarUsuarios)
</script>
