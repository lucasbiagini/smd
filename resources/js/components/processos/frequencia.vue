<template>
    <div>
        <h3>Frequência e totalização das categorias de dados pessoais tratados</h3>

        <b-form-group
            label-for="frequencia-freq"
        >
            <template #label>
                <b-icon id="frequencia-freq-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="frequencia-freq-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Descrever em que frequência os dados são tratados. Isso representa a disponibilidade e horário de funcionamento do sistema automatizado ou processo manual que trata os dados pessoais. Abaixo segue exemplo fictício de descrição do Sistema Nacional de Desaparecidos -SND a ser preenchido no inventário.</p>
                    <p>Exemplo: O SND está disponível no regime 24x7 (24 horas por dia nos 7 dias da semana) para comunicação (coleta) dos dados do desaparecimentos e as demais fases e operações de tratamento são realizadas no horário comercial em dias úteis.</p>
                </b-popover>
                <span>Frequência de tratamento dos dados pessoais:</span>
            </template>
            <b-form-textarea
                id="frequencia-freq"
                placeholder="Descreva aqui sobre a frequência de tratamento dos dados pessoais."
                rows="16"
                v-model="form.frequencia"
                debounce="1000"
                @change="save('frequencia')"
                :disabled="isApproved"
            ></b-form-textarea>
        </b-form-group>
        <b-form-group
            label-for="quantidade-freq"
        >
            <template #label>
                <b-icon id="quantidade-freq-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="quantidade-freq-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Informar a quantidade total de dados pessoais e dados pessoais sensíveis descritos no invetário. Exemplo:</p>
                    <p>- Tratamento de dados pessoais de detalhes pessoais como Idade, sexo, data de nascimento, local de nascimento, estado civil, nacionalidade.</p>
                    <p>- Tratamento de dados pessoais de saúde como CID10 e data de último exame médico.<p/>
                    <p>A informação que deve ser preenchida no inventário é:</p>
                    <p>São tratados 6 dados pessoais e 2 dados pessoais sensíveis, totalizando 8 dados pessoais tratados pelo serviço.</p>
                </b-popover>
                <span>Quantidade de dados pessoais e dados pessoais sensíveis tratados:</span>
            </template>
            <b-form-textarea
                id="quantidade-freq"
                placeholder="Descreva aqui sobre a quantidade de dados tratados."
                rows="16"
                v-model="form.quantidade"
                debounce="1000"
                @change="save('quantidade')"
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
            frequencia: this.processo.frequencia ?? "",
            quantidade: this.processo.quantidade ?? ""
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
                (this.processo.checklist['frequencia'].approved || this.processo.ready_at !== null)        }
    }
})
</script>
