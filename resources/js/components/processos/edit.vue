<template>
    <div>
        <b-form-group id="nome-group" label="Nome:" label-for="nome">
            <b-form-input
                id="nome"
                v-model="form.name"
                placeholder="Insira o nome do processo"
                required
            ></b-form-input>
        </b-form-group>
        <b-form-group id="nome-group" label="Referência:" label-for="ref">
            <b-form-input
                id="ref"
                v-model="form.ref"
                placeholder="Insira o código de referência do processo"
                required
            ></b-form-input>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: [
        'processo'
    ],
    data () {
        return {
            form: {
                name: this.processo.name,
                ref: this.processo.ref
            }
        }
    },
    mounted () {
        this.$root.$on('processo:save', () => this.save())
    },
    methods: {
        reset () {
            this.form = {
                name: this.processo.name,
                ref: this.processo.ref
            }
        },
        save () {
            axios.patch('/processos/' + this.processo.id, {
                name: this.form.name,
                ref: this.form.ref
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
                    this.$root.$emit('processo:updated')
                })
                .catch(error => {

                })
        },
    }
})
</script>
