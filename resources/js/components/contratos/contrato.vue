<template>
    <div v-if="form !== null">
        <b-form-group
            label-for="numero-contrato"
        >
            <template #label>
                <b-icon id="numero-contrato-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="numero-contrato-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Informar o número do processo que referencia a documentação da contratação.</p>
                    <p>Se não existir contrato de serviço ou solução de TI que realize operação de tratamento com os dados pessoais elencados neste inventário, preencha a coluna"Nº Processo de Contratação" com “Não há contrato de serviço ou solução de TI que realize operação de tratamento com os dados pessoais elencados neste inventário”.</p>
                    <p>Exemplo: Se a instituição utiliza o Sistema Eletrônico de Informações (SEI), então preencher essa coluna com o número do processo gerado por este Sistema.</p>
                </b-popover>
                <span>Nº do processo de contratação:</span>
            </template>
            <b-form-input
                id="numero-contrato"
                v-model="form.numero"
                placeholder="Insira o número do contrato"
                required
            ></b-form-input>
        </b-form-group>

        <b-form-group
            label-for="objeto-contrato"
        >
            <template #label>
                <b-icon id="objeto-contrato-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="objeto-contrato-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Informe a descrição do objeto constante do contrato.</p>
                </b-popover>
                <span>Objeto do contrato:</span>
            </template>
            <b-form-textarea
                id="objeto-contrato"
                rows="4"
                v-model="form.objeto"
            ></b-form-textarea>
        </b-form-group>

        <b-form-group
            label-for="email-contrato"
        >
            <template #label>
                <span>Email do gestor do contrato:</span>
            </template>
            <b-form-input
                id="email-contrato"
                v-model="form.email"
                placeholder="Insira o email do gestor do contrato"
                required
            ></b-form-input>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['contrato'],
    data () {
        return {
            form: null
        }
    },
    mounted () {
        this.reset()
        this.$root.$on('contrato:save', () => this.save())
    },
    methods: {
        reset () {
            this.form = {
                numero: this.contrato.numero,
                objeto: this.contrato.objeto,
                email: this.contrato.email
            }
        },
        save () {
            axios.patch('/contratos/' + this.contrato.id, this.form)
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
                    this.$root.$emit('contrato:updated')
                })
                .catch(error => {

                })
        },
    }
})
</script>
