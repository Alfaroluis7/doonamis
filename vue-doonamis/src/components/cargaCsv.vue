<template>
    <div>
        <button class="btn" @click="mostrarModal = true">
            Subir CSV
        </button>

        <div v-if="mostrarModal" class="modal-overlay">
            <div class="modal">


                <div class="modal-header">Subir archivo CSV</div>
                <div class="modal-body">
                    <div class="file-input-wrapper">
                        <label for="file">Selecciona un archivo</label>
                        <input type="file" id="file" @change="handleArchivo" accept=".csv" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="cerrarModal">Cancelar</button>
                    <button class="btn btn-primary" @click="subirCsv">Subir</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import api from '@/api/axios'

const mostrarModal = ref(false)
const archivo = ref<File | null>(null)
const mensaje = ref('')

const emit = defineEmits(['cambiaMensaje'])

const handleArchivo = (event: Event) => {
    const target = event.target as HTMLInputElement
    if (target.files?.length) {
        archivo.value = target.files[0]
    }
}

const subirCsv = async () => {
    if (!archivo.value) return
    const formData = new FormData()
    formData.append('csv', archivo.value)

    try {
        const response = await api.post('usuarios/import-csv', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        })
        emit('cambiaMensaje', response.data.message, 'success')
        mostrarModal.value = false
        archivo.value = null
    } catch (error) {
        mostrarModal.value = false
        emit('cambiaMensaje', 'Error al subir el archivo.', 'danger')
    }
}

const cerrarModal = () => {
    mostrarModal.value = false
    archivo.value = null
    mensaje.value = ''
}
</script>
