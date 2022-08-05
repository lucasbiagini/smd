<template>
    <b-form-group class="mb-3">
        <template #label cols-lg="1">
            <span class="font-weight-bold pt-0">{{ labels[tipo].title }}</span>
            <b-icon :id="`${tipo}_${form_index}-icon`" icon="question-circle-fill" variant="warning"></b-icon>
            <b-popover :target="`${tipo}_${form_index}-icon`" triggers="hover" placement="top">
                <template #title>Ajuda</template>
                {{ labels[tipo].helper }}
            </b-popover>
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
                :state="form.nome !== null && form.nome !== '' ? true : null"
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
                :state="form.endereco !== null && form.endereco !== '' ? true : null"
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
                :state="form.cep !== null && form.cep !== '' ? true : null"
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
                :state="form.telefone !== null && form.telefone !== '' ? true : null"
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
                :state="form.email !== null && form.email !== '' ? true : null"
            ></b-form-input>
        </b-form-group>
    </b-form-group>
</template>

<script>
import axios from 'axios'

export default({
    props: {
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
        operadores: {
            required: false,
            default: false,
            type: Boolean
        },
        deletable: {
            required: false,
            default: false,
            type: Boolean
        }
    },
    data () {
        return {
            labels: {
                controlador: {
                    title: 'Controlador',
                    helper: "Pessoa natural ou jurídica, de direito público ou privado, a quem competem as decisões referentes ao tratamento de dados pessoais (LGPD, art. 5º, IV). Informar o nome do órgão ou entidade."
                },
                encarregado: {
                    title: 'Encarregado',
                    helper: "Pessoa indicada pelo controlador e operador para atuar como canal de comunicação entre o controlador, os titulares dos dados e a Autoridade Nacional de Proteção de Dados - ANPD (LGPD, art. 5º, VIII)"
                },
                operador: {
                    title: `${this.operadores ? (this.form_index + 1) + 'º ' : ''} Operador`,
                    helper: "Pessoa natural ou jurídica, de direito público ou privado, que realiza o tratamento de dados pessoais em nome do controlador; (LGPD, art. 5º, VII)"
                }
            },
            oldForm: null,
            form: null
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
    mounted () {

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
                        this.savingEnded()
                    })
                    .catch(error => {
                        this.form[prop] = this.oldForm[prop]
                        this.savingFailed()
                    })
            }
        },
        remove () {
            this.$root.$emit('remove:operador', this.operador.id)
        }
    }
})
</script>
