<template>
    <div>
        <h3>Categoria de Dados Pessoais</h3>

        <create-dado
            :processo_id="processo.id"
            :grouped_categorias="grouped_categorias"
            :categorias="categorias"
            :bases="bases"
            :fontes="fontes"
            :disabled="isApproved"
        ></create-dado>

        <b-form-group label="Trata dados de crianças e adolescentes?" v-slot="{ ariaDescribedby }">
            <b-form-radio-group
                id="radio-criancas"
                v-model="form.criancas"
                :aria-describedby="ariaDescribedby"
                name="radio-criancas"
                @change="saveProp('criancas')"
                :disabled="isApproved"
            >
                <b-form-radio value="1">Sim</b-form-radio>
                <b-form-radio value="0">Não</b-form-radio>
            </b-form-radio-group>
        </b-form-group>

        <b-form-group label="Além de crianças e adolescente trata dados de outro grupo vulnerável?" v-slot="{ ariaDescribedby }">
            <b-form-radio-group
                id="radio-vulneraveis"
                v-model="form.vulneraveis"
                :aria-describedby="ariaDescribedby"
                name="radio-vulneraveis"
                @change="saveProp('vulneraveis')"
                :disabled="isApproved"
            >
                <b-form-radio value="1">Sim</b-form-radio>
                <b-form-radio value="0">Não</b-form-radio>
            </b-form-radio-group>
        </b-form-group>

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
                :items="dados"
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
                empty-text="Nenhum dado para mostrar"
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
                                v-if="['desc', 'tempo', 'base_dados'].includes(key) && value !== null && value !== ''"
                            >
                                <p><strong>{{ columnName(key) }}:</strong> {{ value.text !== undefined ? value.text : value }}</p>
                            </li>
                        </ul>
                    </b-card>
                </template>
            </b-table>

            <!-- Info modal -->
            <b-modal :id="`edit_dado_${infoModal.id}`" title="Editar categoria de dado pessoal" ref="modal" size="xl">
                <div v-if="selectedItem !== null">
                    <dado
                        :dado="selectedItem"
                        :categorias="grouped_categorias"
                        :bases="bases"
                        :fontes="fontes"
                    ></dado>
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
            grouped_categorias: [],
            categorias: [],
            bases: [],
            fontes: [],
            defaults: {
                current_page: 1,
                per_page: 10
            },
            dados: [],
            current_page: 1,
            per_page: 10,
            total: null,
            paginator: null,
            fields: [
                {key: 'id', label: 'ID', sortable: true, sortDirection: 'desc', strickyColumn: true},
                { key: 'categoria.text', label: 'Categoria', sortable: true, sortDirection: 'desc', class: 'text-center', stickyColumn: true, isActive: false},
                // { key: 'desc', label: 'Descrição', sortable: true, class: 'text-center', stickyColumn: true },
                // { key: 'tempo', label: 'Tempo de Retenção dos Dados', sortable: true, class: 'text-center', stickyColumn: true },
                { key: 'fonte.text', label: 'Fonte de Retenção', sortable: true, class: 'text-center', stickyColumn: true },
                // { key: 'base_dados', label: 'Base de Dados', sortable: true, class: 'text-center', stickyColumn: true },
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
            oldForm: null,
            form: null,
        }
    },
    created () {
        this.form = {
            criancas: this.processo.criancas ?? "",
            vulneraveis: this.processo.vulneraveis ?? ""
        }
        this.oldForm = { ...this.form }
    },
    mounted () {
        this.fetch()
        this.fetchCategorias()
        this.fetchBasesSGD()
        this.fetchFontesSGD()
        this.$root.$on('dado:created', () => this.fetch())
        this.$root.$on('dado:updated', () => {
            this.resetInfoModal()
            this.fetch()
        })
        this.$root.$on('dado:removed', () => this.fetch())
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
        async fetchCategorias () {
            this.startFetching()
            await axios.get(`/dados/categorias`)
                .then(response => {
                    this.grouped_categorias = response.data.grouped_categorias
                    this.categorias = response.data.categorias
                })
                .catch(error => {
                    console.log(error)
                })
            this.stopFetching()
        },
        async fetchBasesSGD () {
            this.startFetching()
            await axios.get(`/dados/bases`)
                .then(response => {
                    this.bases = response.data.map((base, index) => {
                        return {
                            value: index,
                            text: base
                        }
                    })
                })
                .catch(error => {
                    console.log(error)
                })
            this.stopFetching()
        },
        async fetchFontesSGD () {
            this.startFetching()
            await axios.get(`/dados/fontes`)
                .then(response => {
                    this.fontes = response.data.map((fonte, index) => {
                        return {
                            value: index,
                            text: fonte
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
            await axios.post(`/processos/${this.processo.id}/dados`, {
                perPage: this.per_page,
                page: this.current_page,
                sortBy: this.sortBy ? this.sortBy : 'id',
                sortDirection: this.sortDesc ? 'desc' : 'asc'
            })
                .then(response => {
                    this.paginator = response.data
                    this.dados = this.paginator.data
                    this.current_page = this.paginator.current_page
                    this.per_page = this.paginator.per_page
                    this.total = this.paginator.total
                    this.pageOptions = [10, 25, 50, 100, { value: this.total, text: "Todos" }]
                    if (this.isFirstFetch) this.isFirstFetch = false
                    this.$root.$emit('dados:fetched', this.dados)
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
                categoria: item.categoria,
                desc: item.desc,
                tempo: item.tempo,
                fonte: item.fonte,
                base_dados: item.base_dados
            }
            this.$root.$emit('bv::show::modal', `edit_dado_${this.infoModal.id}`, button)
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
            this.$root.$emit('dado:save')
        },
        saveProp (prop) {
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
        },
        async remove(dado_id) {
            this.startFetching()
            await axios.delete(`/dados/${dado_id}`)
                .then(response => {
                    this.$root.$emit('dado:removed')
                })
                .catch(error => {
                    console.log(error)
                })
            this.stopFetching()
        },
        columnName(c)
        {
            if (c === 'desc') return 'Descrição'
            if (c === 'tempo') return 'Tempo'
            if (c === 'base_dados') return 'Base de dados'
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
                (this.processo.checklist['dados'].approved || this.processo.ready_at !== null)
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
    },
})
</script>
