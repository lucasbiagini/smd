<template>
    <div>
        <b-button
            v-b-modal.create-setor
            variant="success"
        >
            Cadastrar
        </b-button>
        <b-modal
            id="create-setor"
            title="Criar Setor"
            size="lg"
            ref="modal"
        >
            <b-form-group id="nome-group" label="Nome:" label-for="nome">
                <b-form-input
                    id="nome"
                    v-model="form.name"
                    placeholder="Insira o nome do setor"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group id="desc-group" label="Descrição:" label-for="desc">
                <b-form-textarea
                    id="desc"
                    v-model="form.desc"
                    placeholder="Insira uma descrição para o setor..."
                    rows="3"
                    max-rows="6"
                ></b-form-textarea>
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
                name: '',
                desc: ''
            }
        }
    },
    mounted () {

    },
    methods: {
        submit () {
            axios.post('/setores/create', this.form)
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
                    this.$root.$emit('setor:created')
                })
                .catch(error => {

                })
        },
        reset () {
            this.form = {
                name: '',
                desc: ''
            }
        },
        close () {
            this.reset()
            this.$refs['modal'].hide()
        },
    }
})
</script>
