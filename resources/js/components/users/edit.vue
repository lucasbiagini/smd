<template>
    <div>
        <b-form-group id="nome-group" label="Nome:" label-for="nome">
            <b-form-input
                id="nome"
                v-model="form.name"
                placeholder="Insira o nome do usuário"
                required
            ></b-form-input>
        </b-form-group>
        <b-form-group id="status-group" label="Status:" label-for="status">
            <b-form-checkbox v-model="form.status" switch size="lg">
                {{ form.status ? 'Usuário ATIVO (Clique para desativar)' : 'Usuário INATIVO (Clique para ativar)'}}
            </b-form-checkbox>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: [
        'user'
    ],
    data () {
        return {
            form: {
                name: this.user.name,
                status: this.user.status
            }
        }
    },
    mounted () {
        this.$root.$on('user:save', () => this.saveUser())
    },
    methods: {
        reset () {
          this.form = {
              name: this.user.name,
              status: this.user.status
          }
        },
        saveUser () {
            axios.patch('/users/' + this.user.id, {
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
                    this.$root.$emit('user:updated')
                })
                .catch(error => {

                })
        },
    }
})
</script>
