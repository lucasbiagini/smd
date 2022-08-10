<template>
    <b-container fluid>
        <div>
            <b-overlay no-wrap rounded="sm" :show="isFetching">
                <template #overlay>
                </template>
            </b-overlay>
            <!-- User Interface controls -->
            <b-row>
                <b-col sm="3" class="ml-auto">
                    <b-form-group
                        label="Status"
                        label-for="status-select"
                        label-cols-sm="6"
                        label-cols-md="4"
                        label-cols-lg="3"
                        label-align-sm="right"
                        label-size="sm"
                        class="mb-0"
                    >
                        <b-form-select
                            id="status-select"
                            v-model="statusProcesso"
                            size="sm"
                        >
                            <b-select-option value="TODOS" :selected="true">Todos</b-select-option>
                            <b-select-option value="PENDENTE">Pendente</b-select-option>
                            <b-select-option value="ANALISE">Em Análise</b-select-option>
                            <b-select-option value="HOMOLOGADO">Homologado</b-select-option>
                            <b-select-option value="ARQUIVADO">Arquivado</b-select-option>
                        </b-form-select>
                    </b-form-group>
                </b-col>
                <b-col sm="3" class="ml-auto">
                    <b-form-group
                        label="Itens"
                        label-for="per-page-select"
                        label-cols-sm="6"
                        label-cols-md="4"
                        label-cols-lg="3"
                        label-align-sm="right"
                        label-size="sm"
                        class="mb-0"
                    >
                        <b-form-select
                            id="per-page-select"
                            v-model="per_page"
                            :options="pageOptions"
                            size="sm"
                        ></b-form-select>
                    </b-form-group>
                </b-col>

                <b-col sm="6">
                    <b-pagination
                        v-model="current_page"
                        :total-rows="total"
                        :per-page="per_page"
                        align="fill"
                        size="sm"
                        class="my-0"
                        :current-page="current_page"
                    ></b-pagination>
                </b-col>
            </b-row>

            <!-- Main table element -->
            <b-table
                class="mt-8"
                :items="processos"
                :fields="fields"
                :per-page="per_page"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :sort-direction="sortDirection"
                sticky-columns
                stacked="md"
                show-empty
                small
                fixed
                striped
                @filtered="onFiltered"
                empty-text="Nenhum processo para mostrar"
            >

                <template #cell(name)="row">
                    <a :href="`/processos/${row.item.id}`" v-b-tooltip.hover title="Acessar IDP">{{row.item.name}}</a>
                </template>

                <template #cell(actions)="row">
                    <b-button
                        size="sm"
                        @click="info(row.item, row.index, $event.target)"
                        v-if="$can('processos.update')"
                        variant="primary"
                        v-b-tooltip.hover
                        title="Editar"
                    >
                        <b-icon-pencil></b-icon-pencil>
                    </b-button>
                    <b-button
                        v-if="$can('processos.archive') && row.item.archived_at === null"
                        size="sm"
                        @click="archive(row.item.id)"
                        variant="dark"
                        v-b-tooltip.hover
                        title="Arquivar"
                    >
                        <b-icon-archive></b-icon-archive>
                    </b-button>
                    <b-button
                        v-if="$can('processos.unarchive') && row.item.archived_at !== null"
                        size="sm"
                        @click="unarchive(row.item.id)"
                        variant="dark"
                        v-b-tooltip.hover
                        title="Desarquivar"
                    >
                        <b-icon-archive></b-icon-archive>
                    </b-button>
                </template>

                <template #cell(status)="row">
                    <b-badge
                        v-if="row.item.approved_at !== null"
                        variant="success"
                    >HOMOLOGADO</b-badge>
                    <b-badge
                        v-else-if="row.item.ready_at !== null"
                        variant="warning"
                    >EM ANÁLISE</b-badge>
                    <b-badge
                        v-else
                        variant="secondary"
                    >PENDENTE</b-badge>
                    <b-badge
                        v-if="row.item.archived_at !== null"
                        variant="dark"
                    >ARQUIVADO</b-badge>
                </template>
            </b-table>

            <!-- Info modal -->
            <b-modal :id="`edit_processo_${infoModal.id}`" :title="infoModal.title" ref="modal" size="lg">
                <div v-if="selectedItem !== null">
                    <edit-processo :processo="selectedItem"></edit-processo>
                </div>
                <template #modal-footer="{ salvar, cancelar }">
                    <div class="w-100" v-show="selectedItem !== null">
                        <b-button id="cancelar" variant="danger" size="sm" class="float-right mr-auto" @click="resetInfoModal">
                            Cancelar
                        </b-button>
                        <b-button id="salvar" variant="primary" size="sm" class="float-right mr-2" @click="save">
                            Salvar
                        </b-button>
                    </div>
                </template>
            </b-modal>
        </div>
    </b-container>
</template>

<script>
import axios from 'axios'

export default ({
    data () {
        return {
            defaults: {
                current_page: 1,
                per_page: 10
            },
            processos: [],
            current_page: 1,
            per_page: 10,
            total: null,
            paginator: null,
            isFetching: true,
            fields: [
                { key: 'name', label: 'Nome', sortable: true, sortDirection: 'desc', class: 'text-center', stickyColumn: true, isActive: false},
                { key: 'ref', label: 'Referência', sortable: true, sortDirection: 'desc', class: 'text-center', stickyColumn: true, isActive: false},
                { key: 'status', label: 'Status', class: 'text-right', stickyColumn: true },
                { key: 'actions', label: 'Opções', class: 'text-right', stickyColumn: true }
            ],
            pageOptions: null,
            sortBy: '',
            sortDesc: true,
            sortDirection: 'desc',
            infoModal: {
                id: 'info-modal',
                title: '',
                content: ''
            },
            selectedItem: null,
            statusProcesso: 'TODOS'
        }
    },
    mounted () {
        this.fetch()
        this.$root.$on('processo:created', () => this.fetch())
        this.$root.$on('processo:updated', () => {
            this.resetInfoModal()
            this.fetch()
        })
    },
    methods: {
        async fetch () {
            this.isFetching = true
            await axios.post('/processos', {
                perPage: this.per_page,
                page: this.current_page,
                sortBy: this.sortBy ? this.sortBy : 'id',
                sortDirection: this.sortDesc ? 'desc' : 'asc',
                status: this.statusProcesso
            })
                .then(response => {
                    this.paginator = response.data
                    this.processos = this.paginator.data
                    this.current_page = this.paginator.current_page
                    this.per_page = this.paginator.per_page
                    this.total = this.paginator.total
                    this.pageOptions = [10, 25, 50, 100, { value: this.total, text: "Todos" }]
                })
                .catch(error => {
                    console.log(error)
                });
            this.isFetching = false
        },
        info(item, index, button) {
            this.infoModal.title = item.name
            this.infoModal.content = item
            this.selectedItem = {
                id: item.id,
                name: item.name,
                ref: item.ref
            }
            this.$root.$emit('bv::show::modal', `edit_processo_${this.infoModal.id}`, button)
        },
        resetInfoModal() {
            this.infoModal.title = ''
            this.infoModal.content = ''
            this.selectedItem = null
            this.$refs['modal'].hide()
        },
        onFiltered(filteredItems) {
            this.per_page = filteredItems.length > 0 ? filteredItems.length : this.defaults.per_page
        },
        save() {
            this.$root.$emit('processo:save')
        },
        async archive(processo_id) {
            await axios.post(`/processos/${processo_id}/archive`)
                .then(() => this.fetch())
                .catch(error => {})
        },
        async unarchive(processo_id) {
            await axios.post(`/processos/${processo_id}/unarchive`)
                .then(() => this.fetch())
                .catch(error => {})
        }
    },
    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.fields
                .filter(f => f.sortable)
                .map(f => {
                    return { text: f.label, value: f.key }
                })
        }
    },
    watch: {
        per_page () {
            this.current_page = 1
            return !this.isFetching ? this.fetch() : null
        },
        current_page () {
            return !this.isFetching ? this.fetch() : null
        },
        sortBy () {
            this.current_page = 1
            return !this.isFetching ? this.fetch() : null
        },
        sortDesc () {
            this.current_page = 1
            return !this.isFetching ? this.fetch() : null
        },
        statusProcesso () {
            this.current_page = 1
            return !this.isFetching ? this.fetch() : null
        }
    }
})
</script>
