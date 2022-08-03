<template>
    <div>
        <b-button
            v-b-modal.create-role
            variant="success"
        >
            Adicionar Perfil
        </b-button>
        <b-modal
            id="create-role"
            title="Criar Setor"
            size="lg"
            ref="modal"
        >
            <b-form-group id="nome-group" label="Nome:" label-for="nome">
                <b-form-input
                    id="nome"
                    v-model="form.name"
                    placeholder="Insira o nome do perfil"
                    required
                ></b-form-input>
            </b-form-group>

            <template #modal-footer="{ criar, cancelar }">
                <div class="w-100">
                    <b-button id="cancelar" variant="danger" size="sm" class="float-right mr-auto" @click="close">
                        Cancelar
                    </b-button>
                    <b-button id="criar" variant="primary" size="sm" class="float-right mr-2" @click="submit">
                        Criar
                    </b-button>
                </div>
            </template>
        </b-modal>
    </div>
</template>

<script>

export default({
    data () {
        return {
            form: {
                name: ''
            }
        }
    },
    mounted () {

    },
    methods: {
        submit () {
            axios.post('/roles/create', this.form)
                .then(response => {
                    this.close()
                    this.$swal.fire({
                        timer: 1000,
                        title: 'Sucesso!',
                        icon: 'success',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true
                    })
                    this.$root.$emit('role:created')
                })
                .catch(error => {

                })
        },
        reset () {
            this.form = {
                name: ''
            }
        },
        close () {
            this.reset()
            this.$refs['modal'].hide()
        },
    }
})
</script>
