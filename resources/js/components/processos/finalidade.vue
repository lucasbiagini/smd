<template>
    <div>
        <h3>Finalidade do Tratamento de Dados Pessoais</h3>

        <b-form-group
            label-for="hipotese-finalidade"
        >
            <template #label>
                <b-icon id="hipotese-finalidade-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="hipotese-finalidade-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>As hipóteses de tratamento estão descritas nos arts. 7º e 11 da LGPD.</p>
                    <p>Os órgãos e entidades da administração pública tem a prerrogativa de tratar os dados pessoais para o exercício de suas competências legais ou execução de políticas públicas sem a necessidade de obter consentimento do titular dos dados pessoais.</p>
                </b-popover>
                <span>Hipótese de tratamento:</span>
            </template>
            <b-form-select v-model="form.hipotese" :options="hipoteses" @change="save('hipotese')"></b-form-select>
        </b-form-group>

        <b-form-group
            label-for="finalidade-finalidade"
        >
            <template #label>
                <b-icon id="finalidade-finalidade-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="finalidade-finalidade-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Razão ou motivo pela qual se deseja tratar os dados pessoais. É importantíssimo estabelecer claramente a finalidade, pois é ela que justifica o tratamento de dados pessoais e fornece os elementos para informar o titular dos dados.</p>
                </b-popover>
                <span>Finalidade:</span>
            </template>
            <b-form-textarea
                id="finalidade-finalidade"
                placeholder="Descreva aqui a finalidade."
                rows="16"
                v-model="form.finalidade"
                debounce="1000"
                @change="save('finalidade')"
            ></b-form-textarea>
        </b-form-group>
        <b-form-group
            label-for="previsao_legal-finalidade"
        >
            <template #label>
                <b-icon id="previsao_legal-finalidade-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="previsao_legal-finalidade-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Informar  Lei, Decreto, normativo ou regulamento que respalda a finalidade do tratamento de dados pessoais realizado.</p>
                    <p>Exemplo fícitício de previsão legal considerando o Programa de Localização de Desaparecidos:</p>
                    <p>• Decreto nº 8.956, de 25 de janeiro de 2218, institui o Programa de Localização de Desaparecidos.</p>
                </b-popover>
                <span>Previsão legal:</span>
            </template>
            <b-form-textarea
                id="previsao_legal-finalidade"
                placeholder="Descreva aqui a previsão legal."
                rows="16"
                v-model="form.previsao_legal"
                debounce="1000"
                @change="save('previsao_legal')"
            ></b-form-textarea>
        </b-form-group>
        <b-form-group
            label-for="resultados-finalidade"
        >
            <template #label>
                <span>Resultados pretendidos para o titular de dados:</span>
            </template>
            <b-form-textarea
                id="resultados-finalidade"
                placeholder="Descreva aqui a os resultados pretendidos."
                rows="16"
                v-model="form.resultados"
                debounce="1000"
                @change="save('resultados')"
            ></b-form-textarea>
        </b-form-group>
        <b-form-group
            label-for="beneficios-finalidade"
        >
            <template #label>
                <span>Benefícios esperados para o órgão, entidade ou para a sociedade como um todo</span>
            </template>
            <b-form-textarea
                id="beneficios-finalidade"
                placeholder="Descreva aqui os benefícios esperados."
                rows="16"
                v-model="form.beneficios"
                debounce="1000"
                @change="save('beneficios')"
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
            isFetching: false,
            fetching: 0,
            oldForm: null,
            form: null,
            hipoteses: []
        }
    },
    created () {
        this.form = {
            finalidade: this.processo.finalidade ?? "",
            previsao_legal: this.processo.previsao_legal ?? "",
            resultados: this.processo.resultados ?? "",
            beneficios: this.processo.beneficios ?? "",
            hipotese: this.processo.hipotese ?? ""
        }
        this.oldForm = { ...this.form }
    },
    mounted () {
        this.fetch()
    },
    methods: {
        startFetching () {
            if (this.fetching === 0) this.$root.$emit('startFetching')
            this.fetching++
        },
        stopFetching () {
            this.fetching--;
            if (this.fetching === 0) this.$root.$emit('stopFetching')
        },
        savingStarted () {
            this.$root.$emit('savingStarted')
        },
        savingEnded () {
            this.$root.$emit('savingEnded')
        },
        savingFailed () {
            this.$root.$emit('savingFailed')
        },
        async fetch () {
            this.startFetching()
            await axios.get(`/processos/hipoteses`)
                .then(response => {
                    this.hipoteses = response.data.map((hipotese, index) => {
                        return {
                            value: index,
                            text: hipotese
                        }
                    })
                })
                .catch(error => {
                    console.log(error)
                })
            this.stopFetching()
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
    }
})
</script>
