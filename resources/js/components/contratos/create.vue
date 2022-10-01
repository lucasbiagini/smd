<template>
    <div>
        <b-button
            v-b-modal.create-contrato
            variant="success"
            style="position: absolute; top: 0; right: 0"
        >
            Cadastrar
        </b-button>
        <b-modal
            id="create-contrato"
            title="Cadastrar Contrato"
            size="xl"
            ref="modal"
        >

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
                    maxlength="255"
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
                    type="email"
                    maxlength="255"
                    required
                ></b-form-input>
            </b-form-group>

            <template #modal-footer="{ criar, cancelar }">
                <div class="w-100">
                    <b-button id="cancelar" variant="danger" size="sm" class="float-right mr-auto" @click="close">
                        Cancelar
                    </b-button>
                    <b-button :disabled="!isReadyToSubmit" id="criar" variant="primary" size="sm" class="float-right mr-2" @click="submit">
                        Criar
                    </b-button>
                </div>
            </template>
        </b-modal>
    </div>
</template>

<script>

import axios from "axios";

export default({
    props: ['processo_id'],
    data () {
        return {
            form: {
                numero: '',
                objeto: '',
                email: ''
            }
        }
    },
    mounted () {

    },
    methods: {
        submit () {
            axios.post('/contratos', {
                processo_id: this.processo_id,
                numero: this.form.numero,
                objeto: this.form.objeto,
                email: this.form.email,
            })
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
                    this.$root.$emit('contrato:created')
                })
                .catch(error => {
                    console.log(error)
                })
        },
        reset () {
            this.form = {
                numero: '',
                objeto: '',
                email: ''
            }
        },
        close () {
            this.reset()
            this.$refs['modal'].hide()
        },
        checkEmailFormat() {
            return this.form.email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)
        }
    },
    computed: {
        isReadyToSubmit () {
            return this.form.numero !== null && this.form.objeto !== '' && this.form.email !== null && this.checkEmailFormat()
        }
    }
})
</script>
