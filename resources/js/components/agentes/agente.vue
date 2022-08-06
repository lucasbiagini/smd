<template>
    <b-form-group class="mb-3">
        <template #label cols-lg="1">
            <b-icon :id="`${tipo}_${form_index}-icon`" icon="question-circle-fill" variant="warning"></b-icon>
            <b-popover :target="`${tipo}_${form_index}-icon`" triggers="hover" placement="top">
                <template #title>Ajuda</template>
                {{ helpers[tipo] }}
            </b-popover>
            <span class="font-weight-bold pt-0">{{ title }}</span>
            <b-badge v-if="deletable" href="#" @click.prenv="remove" variant="danger">Excluir</b-badge>
        </template>
        <b-form-group
            label="Nome:"
            :label-for="`${tipo}_${form_index}-nome`"
            label-cols-sm="3"
            label-align-sm="right"
        >
            <b-form-input
                :id="`${tipo}_${form_index}-nome`"
                debounce="1000"
                @change="save('nome')"
                v-model="form.nome"
                :state="states['nome']"
            ></b-form-input>
        </b-form-group>

        <b-form-group
            label="Endereço:"
            :label-for="`${tipo}_${form_index}-endereco`"
            label-cols-sm="3"
            label-align-sm="right"
        >
            <b-form-input
                :id="`${tipo}_${form_index}-endereco`"
                @change="save('endereco')"
                v-model="form.endereco"
                :state="states['endereco']"
            ></b-form-input>
        </b-form-group>

        <b-form-group
            label="CEP:"
            :label-for="`${tipo}_${form_index}-cep`"
            label-cols-sm="3"
            label-align-sm="right"
        >
            <b-form-input
                :id="`${tipo}_${form_index}-cep`"
                @change="save('cep')"
                v-model="form.cep"
                :state="states['cep']"
            ></b-form-input>
        </b-form-group>

        <b-form-group
            label="Telefone:"
            :label-for="`${tipo}_${form_index}-telefone`"
            label-cols-sm="3"
            label-align-sm="right"
        >
            <b-form-input
                :id="`${tipo}_${form_index}-telefone`"
                @change="save('telefone')"
                v-model="form.telefone"
                :state="states['telefone']"
            ></b-form-input>
        </b-form-group>

        <b-form-group
            label="Email:"
            :label-for="`${tipo}_${form_index}-email`"
            label-cols-sm="3"
            label-align-sm="right"
        >
            <b-form-input
                :id="`${tipo}_${form_index}-email`"
                @change="save('email')"
                v-model="form.email"
                :state="states['email']"
            ></b-form-input>
        </b-form-group>

        <b-form-group
            v-if="tipo === 'operador'"
            :label-for="`${tipo}_${form_index}-atuacao`"
            label-cols-sm="3"
            label-align-sm="right"
        >
            <template #label>
                <b-icon :id="`${tipo}_${form_index}-icon-atuacao`" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover :target="`${tipo}_${form_index}-icon-atuacao`" triggers="hover" placement="top">
                    <template #title>Fases do ciclo de vida do tratamento de dados pessoais</template>
                    Informações sobre o ciclo de vida do tratamento de dados pessoais podem ser observadas no capítulo 3 do Guia de Boas Práticas LGPD, disponível <a target="_blank" href="https://www.gov.br/governodigital/pt-br/seguranca-e-protecao-de-dados/guias/guia_lgpd.pdf">aqui</a>.
                </b-popover>
                <span>Atuação:</span>
            </template>
            <b-form-checkbox inline :disabled="atuacao.coleta.isSaving" v-model="atuacao.coleta.value" :value="1" :unchecked-value="0" @change="checked('coleta')">Coleta</b-form-checkbox>
            <b-form-checkbox inline :disabled="atuacao.retencao.isSaving" v-model="atuacao.retencao.value" :value="1" :unchecked-value="0" @change="checked('retencao')">Retenção</b-form-checkbox>
            <b-form-checkbox inline :disabled="atuacao.processamento.isSaving" v-model="atuacao.processamento.value" :value="1" :unchecked-value="0" @change="checked('processamento')">Processamento</b-form-checkbox>
            <b-form-checkbox inline :disabled="atuacao.compartilhamento.isSaving" v-model="atuacao.compartilhamento.value" :value="1" :unchecked-value="0" @change="checked('compartilhamento')">Compartilhamento</b-form-checkbox>
            <b-form-checkbox inline :disabled="atuacao.eliminacao.isSaving" v-model="atuacao.eliminacao.value" :value="1" :unchecked-value="0" @change="checked('eliminacao')">Eliminação</b-form-checkbox>
        </b-form-group>
    </b-form-group>
</template>

<script>
import axios from 'axios'

export default({
    props: {
        title: {
            required: true
        },
        agente: {
            required: true
        },
        operador: {
            required: false
        },
        tipo: {
            required: true
        },
        form_index: {
            required: false,
            default: 0
        },
        deletable: {
            required: false,
            default: false,
            type: Boolean
        }
    },
    data () {
        return {
            helpers: {
                controlador: "Pessoa natural ou jurídica, de direito público ou privado, a quem competem as decisões referentes ao tratamento de dados pessoais (LGPD, art. 5º, IV). Informar o nome do órgão ou entidade.",
                encarregado: "Pessoa indicada pelo controlador e operador para atuar como canal de comunicação entre o controlador, os titulares dos dados e a Autoridade Nacional de Proteção de Dados - ANPD (LGPD, art. 5º, VIII)",
                operador: "Pessoa natural ou jurídica, de direito público ou privado, que realiza o tratamento de dados pessoais em nome do controlador; (LGPD, art. 5º, VII)"
            },
            oldForm: null,
            form: null,
            states: {
                nome: null,
                endereco: null,
                cep: null,
                telefone: null,
                email: null
            },
            atuacao: {
                coleta: {
                    value: this.operador ? (this.operador.coleta ? 1 : 0) : null,
                    isSaving: false
                },
                retencao: {
                    value: this.operador ? (this.operador.retencao ? 1 : 0) : null,
                    isSaving: false
                },
                processamento: {
                    value: this.operador ? (this.operador.processamento ? 1 : 0) : null,
                    isSaving: false
                },
                compartilhamento: {
                    value: this.operador ? (this.operador.compartilhamento ? 1 : 0) : null,
                    isSaving: false
                },
                eliminacao: {
                    value: this.operador ? (this.operador.eliminacao ? 1 : 0) : null,
                    isSaving: false
                }
            }
        }
    },
    created () {
        this.form = {
            nome: this.agente.nome ?? "",
            endereco: this.agente.endereco ?? "",
            cep: this.agente.cep ?? "",
            telefone: this.agente.telefone ?? "",
            email: this.agente.email ?? "",
            options: []
        }
        this.oldForm = { ...this.form }
    },
    methods: {
        savingStarted () {
            this.$root.$emit('savingStarted')
        },
        savingEnded () {
            this.$root.$emit('savingEnded')
        },
        savingFailed () {
            this.$root.$emit('savingFailed')
        },
        save(prop) {
            if (this.form[prop] !== this.oldForm[prop]) {
                this.savingStarted()
                axios.patch(`/agentes/${this.agente.id}`, {
                        prop: prop,
                        value: this.form[prop]
                    })
                    .then(response => {
                        this.oldForm[prop] = this.form[prop]
                        this.states[prop] = true
                        setTimeout(() => {
                            this.states[prop] = null
                        }, 10000)
                        this.savingEnded()
                    })
                    .catch(error => {
                        this.$swal.fire({
                            timer: 10000,
                            title: "Ocorreu um erro e não foi possível salvar.",
                            icon: 'error',
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end',
                            timerProgressBar: true
                        })
                        this.form[prop] = this.oldForm[prop]
                        this.savingFailed()
                    })
            }
        },
        remove () {
            this.$root.$emit('remove:operador', this.operador.id)
        },
        checked(prop) {
            this.savingStarted()
            axios.patch(`/operadores/${this.operador.id}`, {
                    prop: prop,
                    value: this.atuacao[prop].value
                })
                .then(response => {
                    this.savingEnded()
                })
                .catch(error => {
                    this.$swal.fire({
                        timer: 10000,
                        title: "Ocorreu um erro e não foi possível salvar.",
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true
                    })
                    this.atuacao[prop].value = this.atuacao[prop].value === 1 ? 0 : 1
                    this.savingFailed()
                })
        }
    }
})
</script>
