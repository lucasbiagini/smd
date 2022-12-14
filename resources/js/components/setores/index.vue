<template>
    <b-container fluid>
        <div>
            <b-overlay no-wrap rounded="sm" :show="isFetching">
                <template #overlay>
                </template>
            </b-overlay>
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
                            v-model="status"
                            size="sm"
                        >
                            <b-select-option :value="null" :selected="true">Todos</b-select-option>
                            <b-select-option :value="1">Ativo</b-select-option>
                            <b-select-option :value="0">Inativo</b-select-option>
                        </b-form-select>
                    </b-form-group>
                </b-col>
                <b-col sm="3" class="ml-auto">
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
                :items="setores"
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
                empty-text="Nenhum setor para mostrar"
            >

                <template #cell(actions)="row">
                    <b-button
                        size="sm"
                        @click="info(row.item, row.index, $event.target)"
                        v-if="$can('setores.update')"
                        variant="primary"
                    >
                        <b-icon-pencil></b-icon-pencil>
                    </b-button>
                </template>

                <template #cell(status)="row">
                    <b-badge
                        v-if="row.item.status === 1"
                        variant="success"
                    >ATIVO</b-badge>
                    <b-badge
                        v-else-if="row.item.status === 0"
                        variant="secondary"
                    >INATIVO</b-badge>
                </template>
            </b-table>

            <!-- Info modal -->
            <b-modal :id="`edit_setor_${infoModal.id}`" :title="infoModal.title" ref="modal" size="lg">
                <div v-if="selectedItem !== null">
                    <edit-setor :setor="selectedItem"></edit-setor>
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
            setores: [],
            current_page: 1,
            per_page: 10,
            total: null,
            paginator: null,
            isFetching: true,
            fields: [
                { key: 'name', label: 'Nome', sortable: true, sortDirection: 'desc', class: 'text-center', stickyColumn: true, isActive: false},
                { key: 'desc', label: 'Descri????o', sortable: true, class: 'text-center', stickyColumn: true },
                { key: 'status', label: 'Status', class: 'text-right', stickyColumn: true },
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
            status: null
        }
    },
    mounted () {
        this.fetch()
        this.$root.$on('setor:created', () => this.fetch())
        this.$root.$on('setor:updated', () => {
            this.resetInfoModal()
            this.fetch()
        })
    },
    methods: {
        async fetch () {
            this.isFetching = true
            await axios.post('/setores', {
                perPage: this.per_page,
                page: this.current_page,
                sortBy: this.sortBy ? this.sortBy : 'id',
                sortDirection: this.sortDesc ? 'desc' : 'asc',
                status: this.status
            })
                .then(response => {
                    this.paginator = response.data
                    this.setores = this.paginator.data
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
                status: item.status === 1
            }
            this.$root.$emit('bv::show::modal', `edit_setor_${this.infoModal.id}`, button)
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
            this.$root.$emit('setor:save')
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
        status () {
            this.current_page = 1
            return !this.isFetching ? this.fetch() : null
        },
    }
})
</script>
