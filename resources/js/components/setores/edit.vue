<template>
    <div>
        <b-form-group id="nome-group" label="Nome:" label-for="nome">
            <b-form-input
                id="nome"
                v-model="form.name"
                placeholder="Insira o nome do setor"
                required
            ></b-form-input>
        </b-form-group>
        <b-form-group id="status-group" label="Status:" label-for="status">
            <b-form-checkbox v-model="form.status" switch size="lg">
                {{ form.status ? 'Setor ATIVO (Clique para desativar)' : 'Setor INATIVO (Clique para ativar)'}}
            </b-form-checkbox>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: [
        'setor'
    ],
    data () {
        return {
            form: {
                name: this.setor.name,
                status: this.setor.status
            }
        }
    },
    mounted () {
        this.$root.$on('setor:save', () => this.save())
    },
    methods: {
        reset () {
            this.form = {
                name: this.setor.name,
                status: this.setor.status
            }
        },
        save () {
            axios.patch('/setores/' + this.setor.id, {
                name: this.form.name,
                status: this.form.status
            })
                .then(response => {
                    this.$swal.fire({
                        timer: 1000,
                        title: 'Sucesso!',
                        icon: 'success',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true
                    })
                    this.$root.$emit('setor:updated')
                })
                .catch(error => {

                })
        },
    }
})
</script>
