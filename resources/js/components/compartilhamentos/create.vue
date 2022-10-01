<template>
    <div>
        <b-button
            v-b-modal.create-compartilhamento
            variant="success"
            style="position: absolute; top: 0; right: 0"
            :disabled="disabled"
        >
            Cadastrar
        </b-button>
        <b-modal
            id="create-compartilhamento"
            title="Cadastrar Compartilhamento"
            size="xl"
            ref="modal"
        >

            <b-form-group
                label-for="dados_compartilhados-compartilhamento"
            >
                <template #label>
                    <b-popover target="dados_compartilhados-compartilhamento-icon" triggers="hover" placement="top">
                        <template #title>Ajuda</template>
                        <p>Informe quais dados pessoais e dados pessoais sensíveis são compartilhados.</p>
                    </b-popover>
                    <span>Dados compartilhados:</span>
                </template>
                <b-form-checkbox-group
                    id="dados_compartilhadoss-checkbox"
                    v-model="form.dados_compartilhados"
                    :options="dados"
                    stacked
                ></b-form-checkbox-group>
            </b-form-group>

            <b-form-group
                label-for="dados_compartilhados-compartilhamento"
            >
                <template #label>
                    <b-icon id="nome_instituicao-compartilhamento-icon" icon="question-circle-fill" variant="warning"></b-icon>
                    <b-popover target="nome_instituicao-compartilhamento-icon" triggers="hover" placement="top">
                        <template #title>Ajuda</template>
                        <p>Informe com quais instituições os dados pessoais são compartilhados. Insira na planilha quantas linhas forem necessárias para registrar todas as instituições que tem acesso ao dado pessoal via compartilhamento.</p>
                    </b-popover>
                    <span>Nome da instituição:</span>
                </template>
                <b-form-input
                    id="nome_instituicao-compartilhamento"
                    v-model="form.nome_instituicao"
                    placeholder="Insira o nome da instituição"
                    required
                    maxlength="255"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label-for="finalidade-compartilhamento"
            >
                <template #label>
                    <span>Finalidade:</span>
                </template>
                <b-form-textarea
                    id="finalidade-compartilhamento"
                    rows="4"
                    v-model="form.finalidade"
                ></b-form-textarea>
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
    props: ['processo_id', 'dados', 'disabled'],
    data () {
        return {
            form: {
                finalidade: '',
                nome_instituicao: '',
                dados_compartilhados: []
            }
        }
    },
    mounted () {

    },
    methods: {
        submit () {
            axios.post('/compartilhamentos', {
                processo_id: this.processo_id,
                finalidade: this.form.finalidade,
                nome_instituicao: this.form.nome_instituicao,
                dados_compartilhados: this.form.dados_compartilhados,
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
                    this.$root.$emit('compartilhamento:created')
                })
                .catch(error => {
                    console.log(error)
                })
        },
        reset () {
            this.form = {
                finalidade: '',
                nome_instituicao: '',
                dados_compartilhados: [],
            }
        },
        close () {
            this.reset()
            this.$refs['modal'].hide()
        },
    },
    computed: {
        isReadyToSubmit () {
            return this.form.finalidade !== '' && this.form.dados_compartilhados !== [] && this.form.nome_instituicao !== ''
        }
    }
})
</script>
