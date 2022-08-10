<template>
    <div>
        <b-button
            v-b-modal.create-transferencia
            variant="success"
            style="position: absolute; top: 0; right: 0"
            :disabled="disabled"
        >
            Cadastrar
        </b-button>
        <b-modal
            id="create-transferencia"
            title="Cadastrar Transferência"
            size="xl"
            ref="modal"
        >

            <b-form-group
                label-for="dados_compartilhados-transferencia"
            >
                <template #label>
                    <b-icon id="dados_compartilhados-transferencia-icon" icon="question-circle-fill" variant="warning"></b-icon>
                    <b-popover target="dados_compartilhados-transferencia-icon" triggers="hover" placement="top">
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
                label-for="organizacao-transferencia"
            >
                <template #label>
                    <b-icon id="organizacao-transferencia-icon" icon="question-circle-fill" variant="warning"></b-icon>
                    <b-popover target="organizacao-transferencia-icon" triggers="hover" placement="top">
                        <template #title>Ajuda</template>
                        <p>Verifique se o país estrangeiro para o qual você está transferindo os dados possui legislação de proteção de dados e se é reconhecida como adequada pela Autoridade Nacional de Proteção de Dados - ANPD. Caso a legislação  do país estrangeiro não seja considerada como adequada pela ANPD, a instituição precisará indicar ao país estrangeiro uma estrutura legal para garantir a proteção dos dados pessoais do cidadãos brasileiros no exterior.</p>
                        <p>Exemplo: Transferência Internacional para o U.S. Department of Agriculture (USDA). Nesse caso, preencha o campo organização como "U.S. Department of Agriculture (USDA)" e preencha o campo "País" com "Estados Unidos".</p>
                    </b-popover>
                    <span>Nome da organização:</span>
                </template>
                <b-form-input
                    id="organizacao-transferencia"
                    v-model="form.organizacao"
                    placeholder="Insira o nome da Organização"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label-for="pais-transferencia"
            >
                <template #label>
                    <b-icon id="pais-transferencia-icon" icon="question-circle-fill" variant="warning"></b-icon>
                    <b-popover target="pais-transferencia-icon" triggers="hover" placement="top">
                        <template #title>Ajuda</template>
                        <p>Indique o país caso realize transferência internacional de dados pessoais.</p>
                    </b-popover>
                    <span>Nome da instituição:</span>
                </template>
                <b-form-input
                    id="pais-transferencia"
                    v-model="form.pais"
                    placeholder="Insira o nome da instituição"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label-for="garantia-transferencia"
            >
                <template #label>
                    <b-icon id="garantia-transferencia-icon" icon="question-circle-fill" variant="warning"></b-icon>
                    <b-popover target="garantia-transferencia-icon" triggers="hover" placement="top">
                        <template #title>Ajuda</template>
                        <p>A transferência internacional de dados pessoais somente é permitida nos casos elencados no art. 33 da LGPD.</p>
                    </b-popover>
                    <span>Garantia:</span>
                </template>
                <b-form-select
                    id="garantias-select"
                    v-model="form.garantia"
                    :options="garantias"
                >
                </b-form-select>
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
    props: ['processo_id', 'dados', 'garantias', 'disabled'],
    data () {
        return {
            form: {
                pais: '',
                organizacao: '',
                dados_compartilhados: [],
                garantia: null
            }
        }
    },
    mounted () {

    },
    methods: {
        submit () {
            axios.post('/transferencias', {
                processo_id: this.processo_id,
                pais: this.form.pais,
                organizacao: this.form.organizacao,
                garantia: this.form.garantia,
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
                    this.$root.$emit('transferencia:created')
                })
                .catch(error => {
                    console.log(error)
                })
        },
        reset () {
            this.form = {
                pais: '',
                organizacao: '',
                garantia: null,
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
            return this.form.dados_compartilhados !== [] && this.form.organizacao !== ''
        }
    }
})
</script>
