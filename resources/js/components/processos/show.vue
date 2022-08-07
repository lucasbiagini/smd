<template>
    <b-container>
        <b-row>
            <b-col cols="4">
                <b-list-group>
                    <b-list-group-item button @click="open('agentes')" :active="tab === 'agentes'">Agentes de Tratamento</b-list-group-item>
                    <b-list-group-item button @click="open('fluxo')" :active="tab === 'fluxo'">Fluxo do Tratamento</b-list-group-item>
                    <b-list-group-item button @click="open('escopo')" :active="tab === 'escopo'">Escopo e Natureza dos Dados Pessoais</b-list-group-item>
                    <b-list-group-item button @click="open('finalidade')" :active="tab === 'finalidade'">Finalidade do Tratamento de Dados Pessoais</b-list-group-item>
                    <b-list-group-item button @click="open('dados')" :active="tab === 'dados'">Categoria de Dados Pessoais</b-list-group-item>
                    <b-list-group-item button @click="open('frequencia')" :active="tab === 'frequencia'">Frequência e Totalização</b-list-group-item>
                    <b-list-group-item button @click="open('titulares')" :active="tab === 'titulares'">Titulares de dados pessoais</b-list-group-item>
                    <b-list-group-item button @click="open('compartilhamentos')" :active="tab === 'compartilhamentos'">11 - Compartilhamento de  Dados Pessoais</b-list-group-item>
                    <b-list-group-item button @click="open('medidas')" :active="tab === 'medidas'">12 - Medidas de Segurança/Privacidade</b-list-group-item>
                    <b-list-group-item button @click="open('transferencias')" :active="tab === 'transferencias'">13 - Transferência Internacional de Dados Pessoais</b-list-group-item>
                    <b-list-group-item button @click="open('contratos')" :active="tab === 'contratos'">14 - Contrato(s) de serviços e/ou soluções de TI que trata(m) dados pessoais do serviço/processo de negócio</b-list-group-item>
                </b-list-group>
            </b-col>
            <b-col cols="8">
                <b-overlay no-wrap rounded="sm" :show="isFetching">
                    <template #overlay>
                    </template>
                </b-overlay>
                <p v-if="isSaving === true">Salvando...</p>
                <p v-else-if="isSaving === false && saving === 0">{{ lastSave }}</p>
                <p v-else-if="saving === null">Falha ao salvar!</p>
                <div v-if="processo !== null">
                    <div v-if="tabs.agentes">
                      <agentes v-show="tab === 'agentes'" :processo="processo"></agentes>
                    </div>
                    <div v-if="tabs.fluxo">
                        <fluxo v-show="tab === 'fluxo'" :processo="processo"></fluxo>
                    </div>
                    <div v-if="tabs.escopo">
                        <escopo v-show="tab === 'escopo'" :processo="processo"></escopo>
                    </div>
                    <div v-if="tabs.finalidade">
                        <finalidade v-show="tab === 'finalidade'" :processo="processo"></finalidade>
                    </div>
                    <div v-if="tabs.dados">
                        <dados v-show="tab === 'dados'" :processo="processo"></dados>
                    </div>
                    <div v-if="tabs.frequencia">
                        <frequencia v-show="tab === 'frequencia'" :processo="processo"></frequencia>
                    </div>
                    <div v-if="tabs.titulares">
                        <titulares v-show="tab === 'titulares'" :processo="processo"></titulares>
                    </div>
                </div>
                <div v-if="tab === null">
                    <b-jumbotron header="Inventário de Dados Pessoais">
                        <p>Para mais informações acesse o link abaixo</p>
                        <b-button variant="primary" target="_blank" href="https://www.gov.br/governodigital/pt-br/seguranca-e-protecao-de-dados/guias/guia_lgpd.pdf">Guia de Boas Práticas da LGPD</b-button>
                    </b-jumbotron>
                </div>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import axios from 'axios'

export default({
    props: [
        'processo_id'
    ],
    data () {
        return {
            isFetching: false,
            processo: null,
            tab: null,
            tabs: {
                agentes: false,
                fluxo: false,
                escopo: false,
                finalidade: false,
                dados: false,
                categoria_dados_sensiveis: false,
                frequencia: false,
                titulares: false,
                compartilhamentos: false,
                medidas: false,
                transferencias: false,
                contratos: false
            },
            isSaving: null,
            saving: 0,
            lastSave: ''
        }
    },
    mounted () {
        this.fetch()
        this.$root.$on('startFetching', () => this.startFetching())
        this.$root.$on('stopFetching', () => this.stopFetching())
        this.$root.$on('savingStarted', () => this.savingStarted())
        this.$root.$on('savingEnded', () => this.savingEnded())
        this.$root.$on('savingFailed', () => this.savingFailed())
    },
    methods: {
        startFetching () {
            this.isFetching = true
        },
        stopFetching () {
            this.isFetching = false
        },
        savingStarted () {
            if (this.saving === null) this.saving = 0
            if (this.saving === 0) this.isSaving = true
            this.saving++
        },
        savingEnded () {
            if (this.saving !== null) {
                this.saving--
                if (this.saving === 0) {
                    this.isSaving = false
                    const today = new Date()
                    const now = today.toLocaleString("pt-BR").substring(11)
                    this.lastSave = 'Salvo com sucesso às ' + now
                }
            }
        },
        savingFailed () {
            this.saving = null
            this.isSaving = false
        },
        open (tab) {
            this.isSaving = null
            this.saving = 0
            this.tabs[tab] = true
            this.tab = tab
        },
        async fetch () {
            this.startFetching()
            await axios.post(`/processos/${this.processo_id}`)
                .then(response => {
                    this.processo = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            this.stopFetching()
        }
    }
})
</script>
