<template>
    <b-container>
        <b-row>
            <b-col cols="4">
                <b-list-group>
                    <b-list-group-item button @click="tab = null" :active="tab === null">
                        <b-badge v-if="isAnalysisReady && processo.ready_at !== null" variant="secondary">PRONTO</b-badge>
                        Início
                    </b-list-group-item>
                    <b-list-group-item button @click="open('agentes')" :active="tab === 'agentes'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.agentes.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-else-if="processo.checklist.agentes.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-else-if="processo.checklist.agentes.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('agentes') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('fluxo')" :active="tab === 'fluxo'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.fluxo.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.fluxo.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.fluxo.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('fluxo') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('escopo')" :active="tab === 'escopo'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.escopo.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.escopo.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.escopo.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('escopo') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('finalidade')" :active="tab === 'finalidade'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.finalidade.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.finalidade.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.finalidade.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('finalidade') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('dados')" :active="tab === 'dados'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.dados.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.dados.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.dados.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('dados') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('frequencia')" :active="tab === 'frequencia'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.frequencia.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.frequencia.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.frequencia.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('frequencia') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('titulares')" :active="tab === 'titulares'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.titulares.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.titulares.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.titulares.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('titulares') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('compartilhamentos')" :active="tab === 'compartilhamentos'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.compartilhamentos.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.compartilhamentos.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.compartilhamentos.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('compartilhamentos') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('medidas')" :active="tab === 'medidas'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.medidas.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.medidas.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.medidas.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('medidas') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('transferencias')" :active="tab === 'transferencias'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.transferencias.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.transferencias.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.transferencias.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('transferencias') }}
                    </b-list-group-item>
                    <b-list-group-item button @click="open('contratos')" :active="tab === 'contratos'">
                        <div v-if="processo !== null && processo.checklist !== null">
                            <b-badge v-if="processo.checklist.contratos.approved === null" variant="secondary" pill>PENDENTE</b-badge>
                            <b-badge v-if="processo.checklist.contratos.approved === true" variant="success" pill>APROVADO</b-badge>
                            <b-badge v-if="processo.checklist.contratos.approved === false" variant="danger" pill>REJEITADO</b-badge>
                        </div>
                        {{ columnName('contratos') }}
                    </b-list-group-item>
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
                    <b-toast
                        v-for="(checklist, index) in processo.checklists"
                        :key="index"
                        v-if="processo.ready_at !== null && checklist.approved === false && (tab === null || tab === checklist.section)"
                        :id="`toast_${checklist.section}`"
                        :title="`REJEITADO: ${columnName(checklist.section)}`"
                        variant="danger"
                        class="mb-3"
                        style="max-width: 1000px !important;"
                        visible
                        static
                        no-auto-hide
                        no-close-button
                        @click="open(checklist.section)"
                    >
                        <div v-if="isEditing[checklist.section] === true">
                            <b-textarea
                                v-model="checklist.message"
                                rows="6"
                                max-rows="6"
                            ></b-textarea>
                        </div>
                        <div v-else>{{ checklist.message }}</div>
                        <b-link v-if="tab === null" href="#" @click.prevent="open(checklist.section)">Visualizar</b-link>
                        <b-link v-else href="#" @click.prevent="editOrSaveChecklistMessage(checklist.section, checklist.message)">
                            <span v-if="isEditing[checklist.section] === false">Editar</span>
                            <span v-else>Salvar</span>
                        </b-link>
                    </b-toast>
                    <div v-if="processo.ready_at !== null && processo.approved_at === null && tab !== null" class="mb-3">
                        <b-button
                            variant="success"
                            @click="approve(tab)"
                            v-if="processo.checklist[tab].approved !== true"
                        >
                            APROVAR
                        </b-button>
                        <b-button
                            variant="danger"
                            v-b-modal.modal-reject
                            v-if="processo.checklist[tab].approved !== false"
                        >
                            REJEITAR
                        </b-button>
                        <b-modal id="modal-reject" title="REJEITAR" size="lg">
                            <b-textarea
                                v-model="processo.checklist[tab].message"
                                rows="6" max-rows="6"
                            ></b-textarea>
                            <template #modal-footer>
                                <b-button
                                    variant="danger"
                                    @click="reject(tab)"
                                    class="float-right"
                                    :disabled="processo.checklist[tab].message === null || processo.checklist[tab].message.length === 0"
                                >
                                    REJEITAR
                                </b-button>
                            </template>
                        </b-modal>
                    </div>
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
                    <div v-if="tabs.compartilhamentos">
                        <compartilhamentos v-show="tab === 'compartilhamentos'" :processo="processo"></compartilhamentos>
                    </div>
                    <div v-if="tabs.medidas">
                        <medidas v-show="tab === 'medidas'" :processo="processo"></medidas>
                    </div>
                    <div v-if="tabs.transferencias">
                        <transferencias v-show="tab === 'transferencias'" :processo="processo"></transferencias>
                    </div>
                    <div v-if="tabs.contratos">
                        <contratos v-show="tab === 'contratos'" :processo="processo"></contratos>
                    </div>
                </div>
                <div v-if="tab === null">
                    <b-jumbotron header="Inventário de Dados Pessoais">
                        <p>Para mais informações acesse o link abaixo</p>
                        <b-button variant="primary" target="_blank" href="https://www.gov.br/governodigital/pt-br/seguranca-e-protecao-de-dados/guias/guia_lgpd.pdf">Guia de Boas Práticas da LGPD</b-button>
                    </b-jumbotron>
                    <b-button
                        v-if="processo !== null && (processo.ready_at === null || processo.approved_at !== null) && processo.archived_at === null"
                        size="sm"
                        @click="analyseProcesso"
                        variant="warning"
                    >
                        SOLICITAR ANÁLISE
                    </b-button>
                    <div v-if="processo !== null && processo.ready_at !== null && processo.approved_at === null">
                        <b-button
                            variant="success"
                            @click="approveProcesso"
                            :disabled="!isAnalysisReady || !isAllApproved"
                        >
                            HOMOLOGAR PROCESSO
                        </b-button>
                        <b-button
                            variant="danger"
                            @click="rejectProcesso"
                            :disabled="!isAnalysisReady || isAllApproved"
                        >
                            REJEITAR PROCESSO
                        </b-button>
                    </div>
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
            isEditing: {
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
        columnName (column) {
            if (column === 'agentes') return 'Agentes de Tratamento'
            if (column === 'fluxo') return 'Fluxo do Tratamento'
            if (column === 'escopo') return 'Escopo e Natureza dos Dados Pessoais'
            if (column === 'finalidade') return 'Finalidade do Tratamento de Dados Pessoais'
            if (column === 'dados') return 'Categoria de Dados Pessoais'
            if (column === 'frequencia') return 'Frequência e Totalização'
            if (column === 'titulares') return 'Titulares de dados pessoais'
            if (column === 'compartilhamentos') return 'Compartilhamento de  Dados Pessoais'
            if (column === 'medidas') return 'Medidas de Segurança/Privacidade'
            if (column === 'transferencias') return 'Transferência Internacional de Dados Pessoais'
            if (column === 'contratos') return 'Contratos de serviços'
        },
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
        },
        editOrSaveChecklistMessage (section, message) {
            if (this.isEditing[section]) {
                axios.post(`/checklists/${this.processo.checklist[section].id}/message`, {
                    message: message
                })
                .then(() => this.fetch())
                .catch(error => console.log(error))
            }
            this.isEditing[section] = !this.isEditing[section]
        },
        approve (section) {
            axios.post(`/checklists/${this.processo.checklist[section].id}/approve`)
                .then(() => this.fetch())
                .catch(error => console.log(error))
        },
        reject (section) {
            axios.post(`/checklists/${this.processo.checklist[section].id}/reject`, {
                message: this.processo.checklist[section].message
            })
                .then(() => {
                    this.$bvModal.hide('modal-reject')
                    this.fetch()
                })
                .catch(error => console.log(error))
        },
        async analyseProcesso () {
            await axios.post(`/processos/${this.processo.id}/analyse`)
                .then(() => this.fetch())
                .catch(error => {})
        },
        approveProcesso () {
            axios.post(`/processos/${this.processo.id}/approve`)
                .then(() => this.fetch())
                .catch(error => {})
        },
        rejectProcesso () {
            axios.post(`/processos/${this.processo.id}/reject`)
                .then(() => this.fetch())
                .catch(error => {})
        }
    },
    computed: {
        isAnalysisReady () {
            if (this.processo === null) return false
            else if (this.processo.checklists === null || this.processo.checklists.length === 0) return false
            else return this.processo.checklists
                    .map(checklist => checklist.approved !== null)
                    .reduce((acc, value) => { return acc && value })
        },
        isAllApproved () {
            if (this.isAnalysisReady === false) return false
            else if (this.processo.checklists === null || this.processo.checklists.length === 0) return false
            else return this.processo.checklists
                    .map(checklist => checklist.approved === true)
                    .reduce((acc, value) => { return acc && value })
        }
    }
})
</script>

<style>
.toast {
    max-width: 1000px !important;
}
</style>
