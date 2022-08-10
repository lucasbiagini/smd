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
        <b-form-group id="ref-group" label="Referência:" label-for="ref">
            <b-form-input
                id="ref"
                v-model="form.ref"
                placeholder="Insira o código de referência do processo"
                required
            ></b-form-input>
        </b-form-group>
        <b-form-group id="description-group" label="Descrição:" label-for="description">
            <b-form-textarea
                id="description"
                placeholder="Descreva aqui sobre o processo."
                rows="8"
                v-model="form.description"
            ></b-form-textarea>
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
                ref: this.processo.ref,
                description: this.processo.description
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
                ref: this.processo.ref,
                description: this.processo.description
            }
        },
        save () {
            axios.patch('/processos/' + this.processo.id, {
                name: this.form.name,
                ref: this.form.ref,
                description: this.form.description
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
