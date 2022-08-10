<template>
    <div>
        <h3>Escopo e Natureza dos Dados Pessoais</h3>

        <b-form-group
            label-for="abrangencia-escopo"
        >
            <template #label>
                <b-icon id="abrangencia-escopo-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="abrangencia-escopo-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Informar se a abrangência do dados tratados é nacional, estadual, distrital, municipal ou regional.</p>
                </b-popover>
                <span>Abrangência da área geográfica do tratamento:</span>
            </template>
            <b-form-textarea
                id="abrangencia-escopo"
                placeholder="Descreva aqui a abrangência da área geográfica."
                rows="8"
                v-model="form.abrangencia"
                debounce="1000"
                @change="save('abrangencia')"
                :disabled="isApproved"
            ></b-form-textarea>
        </b-form-group>
        <b-form-group
            label-for="fonte-escopo"
        >
            <template #label>
                <b-icon id="fonte-escopo-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="fonte-escopo-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Informar de qual fonte dos dados pessoais: Titular dos dados pessoais, XML, API, etc.</p>
                    <p>Exemplo 1: Se os dados pessoais são obtidos por meio de preenchimento de formulário eletrônico, então a fonte de dados é o titular dos dados</p>
                    <p>Exemplo 2: Fonte de dados que não seja o titular de dados, é importante detalhar a fonte, como por exemplo, API CONSULTA CPF.</p>
                </b-popover>
                <span>Fonte de dados utilizada para obtenção dos dados pessoais:</span>
            </template>
            <b-form-textarea
                id="fonte-escopo"
                placeholder="Descreva aqui a abrangência da área geográfica."
                rows="8"
                v-model="form.fonte"
                debounce="1000"
                @change="save('fonte')"
                :disabled="isApproved"
            ></b-form-textarea>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['processo'],
    data () {
        return {
            oldForm: null,
            form: null,
        }
    },
    created () {
        this.form = {
            abrangencia: this.processo.abrangencia ?? "",
            fonte: this.processo.fonte ?? ""
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
        save (prop) {
            this.savingStarted()
            axios.patch(`/processos/${this.processo.id}/prop`, {
                prop: prop,
                value: this.form[prop]
            })
                .then(response => {
                    this.oldForm[prop] = this.form[prop]
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
    computed: {
        isApproved () {
            return this.processo.checklist !== null &&
                (this.processo.checklist['escopo'].approved || this.processo.ready_at !== null)        }
    }
})
</script>
