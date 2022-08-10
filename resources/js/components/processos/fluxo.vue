<template>
    <div>
        <h3>De que forma (como) os dados  pessoais são coletados, retidos/armazenados, processados/usados, compartilhados e eliminados</h3>

        <b-form-group
            label-for="desc-fluxo"
        >
            <template #label>
                <b-icon id="desc-fluxo-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="desc-fluxo-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Descrever  como (de que forma) os dados  pessoais são coletados, retidos/armazenados, processados/ usados e eliminados.</p>
                    <p>Nessa seção, pode até ser colocado um desenho com um fluxo de dados. Abaixo, segue exemplo de descrição do fluxo de dados.</p>
                    <p>Exemplo descrição do fluxo de tratamento de dados pessoais do programa fictício de localização de desaparecidos do Departamento de Segurança Púbica - DSP.</p>
                    <ol>
                        <li>1. Os dados pessoais são coletados mediante preenchimento formulário eletrônico do Sistema Nacional pelo titular dos dados pessoais.</li>
                        <li>2. Os dados são transferidos armazenados nas instalações físicas da Empresa de Processamento e Tecnologia Fictum.</li>
                        <li>3. A empresa Fictum realiza processamento sobre os dados pessoais e disponibiliza para uso do DSP. O DSP disponibiliza os dados pessoais para utilização e consumo do comunicante.</li>
                        <li>4. O DSP transfere dados de comunicantes e pessoas desaparecidas para a SDH desenvolver as ações de apoio psicológico para as famílias do desaparecidos.</li>
                        <li>5. Os dados pessoais podem ser eliminados à pedido do titular. Nesse caso, o DSP encaminha essa solicitação para a empresa Fictum executar a eliminação dos dados pessoais da base de dados do SND.</li>
                    </ol>
                </b-popover>
                <span>Descrição do Fluxo do tratamento dos dados pessoais:</span>
            </template>
            <b-form-textarea
                id="desc-fluxo"
                placeholder="Descreva aqui o fluxo de dados do processo."
                rows="16"
                v-model="form.desc"
                debounce="1000"
                @change="save"
                :disabled="isApproved"
            ></b-form-textarea>
        </b-form-group>
        <b-form-group>
            <input :disabled="isApproved" type="file" ref="file" class="mt-3" @change="uploadFiles">
            <b-progress v-if="isUploading" :value="uploadProgress" max="100" class="mt-2" show-progress animated></b-progress>
        </b-form-group>
        <b-overlay :show="isFetchingFiles" rounded="sm">
            <b-list-group v-if="files !== null && files.length > 0">
                <b-list-group-item variant="secondary">Lista de arquivos</b-list-group-item>
                <b-list-group-item
                    v-for="(file, index) in files"
                    :key="index"
                    class="d-flex justify-content-between align-items-center"
                >
                    <a target="_blank" :href="`/files/${file.id}`">{{ file.filename }}</a>
                    <b-badge href="#" variant="danger" @click.prevent="remove(file.id)"><b-icon icon="trash"></b-icon></b-badge>
                </b-list-group-item>
            </b-list-group>
        </b-overlay>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['processo'],
    data () {
        return {
            oldForm: null,
            form: null,
            files: null,
            isUploading: false,
            isFetchingFiles: true,
            uploadProgress: 0
        }
    },
    created () {
        this.form = {
            desc: this.processo.desc ?? ""
        }
        this.oldForm = { ...this.form }
    },
    mounted () {
        this.fetch()
    },
    methods: {
        savingStarted () {
            this.$root.$emit('savingStarted')
        },
        savingEnded () {
            this.$root.$emit('savingEnded')
        },
        savingFailed () {
            this.$root.$emit('savingFailed')
        },
        async fetch () {
            this.isFetchingFiles = true
            await axios.get(`/processos/${this.processo.id}/files`)
                .then(response => {
                    this.files = response.data
                })
                .catch(error => {
                    this.$swal.fire({
                        timer: 10000,
                        title: "Ocorreu um erro e não foi possível carregar os arquivos.",
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true
                    })
                })
            this.isFetchingFiles = false
        },
        save () {
            this.savingStarted()
            axios.patch(`/processos/${this.processo.id}/prop`, {
                    prop: 'desc',
                    value: this.form.desc
                })
                .then(response => {
                    this.oldForm.desc = this.form.desc
                    this.savingEnded()
                })
                .catch(error => {
                    this.$swal.fire({
                        timer: 10000,
                        title: "Ocorreu um erro e não foi possível salvar.",
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true
                    })
                    this.form.desc = this.oldForm.desc
                    this.savingFailed()
                })
        },
        async uploadFiles () {
            this.isUploading = true
            this.uploadProgress = 0
            var formData = new FormData();
            formData.append('file', this.$refs.file.files[0])
            formData.append('filename', this.$refs.file.files[0].name)
            await axios.post(`/processos/${this.processo.id}/file`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: (event) => {
                        this.uploadProgress = Math.round((100 * event.loaded) / event.total)
                    }
                })
                .then(response => {
                    this.fetch()
                })
                .catch(error => {
                    this.$swal.fire({
                        timer: 10000,
                        title: "Ocorreu um erro e não foi possível salvar o arquivo.",
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true
                    })
                })
            this.isUploading = false
            this.$refs.file.value = ''
        },
        async remove (file_id) {
            this.isRemoving = true
            await axios.delete(`/files/${file_id}`)
                .then(response => {
                    this.fetch()
                })
                .catch(error => {
                    this.$swal.fire({
                        timer: 10000,
                        title: "Ocorreu um erro e não foi possível remover o arquivo.",
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true
                    })
                })
            this.isRemoving = false
        },
    },
    computed: {
        isApproved () {
            return this.processo.checklist !== null &&
                (this.processo.checklist['fluxo'].approved || this.processo.ready_at !== null)
        }
    }
})
</script>
