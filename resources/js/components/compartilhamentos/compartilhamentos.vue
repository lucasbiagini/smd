<template>
    <div>
        <h3>Compartilhamento de Dados Pessoais</h3>

        <create-compartilhamento
            :processo_id="processo.id"
            :dados="dados"
            :disabled="isApproved"
        ></create-compartilhamento>

        <b-container fluid class="mt-5">
            <!-- User Interface controls -->
            <b-row>
                <b-col sm="5" md="6" class="ml-auto">
                    <b-form-group
                        label="Per page"
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

                <b-col sm="7" md="6">
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
                :items="compartilhamentos"
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
                empty-text="Nenhum compartilhamento para mostrar"
            >

                <template #cell(actions)="row">
                    <b-button
                        size="sm"
                        @click="info(row.item, row.index, $event.target)"
                        v-if="$can('processos.dados')"
                        variant="primary"
                        :disabled="isApproved"
                    >
                        <b-icon-pencil></b-icon-pencil>
                    </b-button>
                    <b-button size="sm" @click="row.toggleDetails">
                        <b-icon-eye v-if="!row.detailsShowing"></b-icon-eye>
                        <b-icon-eye-slash v-else></b-icon-eye-slash>
                    </b-button>
                    <b-button size="sm" variant="danger" @click="remove(row.item.id)" :disabled="isApproved">
                        <b-icon-trash></b-icon-trash>
                    </b-button>
                </template>

                <template #row-details="row">
                    <b-card>
                        <ul>
                            <li
                                v-for="(value, key) in row.item"
                                :key="key"
                                v-if="['finalidade'].includes(key) && value !== null && value !== ''"
                            >
                                <p><strong>{{ columnName(key) }}:</strong> {{ value.text !== undefined ? value.text : value }}</p>
                            </li>
                        </ul>
                        <ol>
                            <p><strong>Categorias dos Dados:</strong></p>
                            <li
                                v-for="(dado, key) in row.item.dados"
                                :key="'li_'+key"
                            >
                                • {{ dado.categoria.text }}
                            </li>
                        </ol>
                    </b-card>
                </template>
            </b-table>

            <!-- Info modal -->
            <b-modal :id="`edit_compartilhamento_${infoModal.id}`" title="Editar" ref="modal" size="xl">
                <div v-if="selectedItem !== null">
                    <compartilhamento
                        :compartilhamento="selectedItem"
                        :dados="dados"
                    ></compartilhamento>
                </div>
                <template #modal-footer="{ salvar, cancelar }" v-if="selectedItem !== null">
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


        </b-container>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['processo'],
    data () {
        return {
            isFirstFetch: true,
            isFetching: false,
            fetching: 0,
            defaults: {
                current_page: 1,
                per_page: 10
            },
            compartilhamentos: [],
            current_page: 1,
            per_page: 10,
            total: null,
            paginator: null,
            fields: [
                {key: 'id', label: 'ID', sortable: true, sortDirection: 'desc', strickyColumn: true},
                { key: 'nome_instituicao', label: 'Nome da Instituição', sortable: true, class: 'text-center', stickyColumn: true, formatter: nome => {
                    return nome.substring(0, 35) + "..."
                    } },
                { key: 'actions', label: 'Actions', class: 'text-right', stickyColumn: true }
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
            dados: []
        }
    },
    mounted () {
        this.fetch()
        this.fetchDados()
        this.$root.$on('compartilhamento:created', () => this.fetch())
        this.$root.$on('compartilhamento:updated', () => {
            this.resetInfoModal()
            this.fetch()
        })
        this.$root.$on('compartilhamento:removed', () => this.fetch())
        this.$root.$on('dados:fetched', dados => {
            this.dados = dados.map(dado => {
                return {
                    value: dado.id,
                    text: dado.categoria.text
                }
            })
        })
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
        async fetchDados () {
            this.startFetching()
            await axios.get(`/processos/${this.processo.id}/dados/all`)
                .then(response => {
                    this.dados = response.data.map(dado => {
                        return {
                            value: dado.id,
                            text: dado.categoria.text
                        }
                    })
                })
                .catch(error => {
                    console.log(error)
                })
            this.stopFetching()
        },
        async fetch () {
            this.startFetching()
            await axios.post(`/processos/${this.processo.id}/compartilhamentos`, {
                perPage: this.per_page,
                page: this.current_page,
                sortBy: this.sortBy ? this.sortBy : 'id',
                sortDirection: this.sortDesc ? 'desc' : 'asc'
            })
                .then(response => {
                    this.paginator = response.data
                    this.compartilhamentos = this.paginator.data
                    this.current_page = this.paginator.current_page
                    this.per_page = this.paginator.per_page
                    this.total = this.paginator.total
                    this.pageOptions = [10, 25, 50, 100, { value: this.total, text: "Todos" }]
                    if (this.isFirstFetch) this.isFirstFetch = false
                })
                .catch(error => {
                    console.log(error)
                });
            this.stopFetching()
        },
        info(item, index, button) {
            this.infoModal.title = item.name
            this.infoModal.content = item
            this.selectedItem = {
                id: item.id,
                nome_instituicao: item.nome_instituicao,
                dados_compartilhados: item.dados.map(dado => {
                    return dado.id
                }),
                finalidade: item.finalidade,
            }
            this.$root.$emit('bv::show::modal', `edit_compartilhamento_${this.infoModal.id}`, button)
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
            this.$root.$emit('compartilhamento:save')
        },
        async remove(compartilhamento_id) {
            this.startFetching()
            await axios.delete(`/compartilhamentos/${compartilhamento_id}`)
                .then(response => {
                    this.$root.$emit('compartilhamento:removed')
                })
                .catch(error => {
                    console.log(error)
                })
            this.stopFetching()
        },
        columnName(c)
        {
            if (c === 'finalidade') return 'Finalidade'
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
        },
        isApproved () {
            return this.processo.checklists.length > 0 &&
                (this.processo.checklist['compartilhamentos'].approved || this.processo.ready_at !== null)
        }
    },
    watch: {
        per_page () {
            this.current_page = 1
            return !this.isFetching && !this.isFirstFetch ? this.fetch() : null
        },
        current_page () {
            return !this.isFetching && !this.isFirstFetch ? this.fetch() : null
        },
        sortBy () {
            this.current_page = 1
            return !this.isFetching && !this.isFirstFetch ? this.fetch() : null
        },
        sortDesc () {
            this.current_page = 1
            return !this.isFetching && !this.isFirstFetch ? this.fetch() : null
        }
    }
})
</script>
