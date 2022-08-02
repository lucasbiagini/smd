<template>
    <b-container>
        <b-row>
            <b-col cols="5">
                <b-form-group label="Setor:" label-for="multiselect-setores">
                    <multiselect
                        v-model="setor"
                        id="multiselect-setores"
                        label="name"
                        track-by="code"
                        placeholder="Digite o nome do setor"
                        deselect-label="Remover setor selecionado"
                        select-label="Selecionar"
                        open-direction="bottom"
                        :options="setores"
                        :searchable="true"
                        :loading="isLoadingSetores"
                        :internal-search="false"
                        :multiple="false"
                        :clear-on-select="false"
                        :close-on-select="true"
                        :max-height="600"
                        :show-no-results="true"
                        :hide-selected="false"
                        :allow-empty="true"
                        :preserve-search="true"
                        @search-change="searchSetor"
                        @open="openSetor"
                        @close="closeSetor">
                        <span slot="noResult">Nenhum setor encontrado.</span>
                    </multiselect>
                </b-form-group>
            </b-col>
            <b-col cols="5">
                <b-form-group label="Perfil:" label-for="multiselect-roles">
                    <multiselect
                        v-model="role"
                        id="multiselect-roles"
                        label="name"
                        track-by="code"
                        placeholder="Digite o nome do role"
                        deselect-label="Remover role selecionado"
                        select-label="Selecionar"
                        open-direction="bottom"
                        :options="roles"
                        :searchable="true"
                        :loading="isLoadingRoles"
                        :internal-search="false"
                        :multiple="false"
                        :clear-on-select="false"
                        :close-on-select="true"
                        :max-height="600"
                        :show-no-results="true"
                        :hide-selected="false"
                        :allow-empty="true"
                        :preserve-search="true"
                        @search-change="searchRole"
                        @open="openRole"
                        @close="closeRole">
                        <span slot="noResult">Nenhum role encontrado.</span>
                    </multiselect>
                </b-form-group>
            </b-col>
            <b-col cols="2">
                <b-form-group>
                    <b-button
                        id="include"
                        variant="success"
                        @click="include"
                        style="margin-top: 34px;"
                        :disabled="isIncluding"
                    >
                        <b-spinner v-if="isIncluding" small></b-spinner>
                        Incluir
                    </b-button>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row >
            <div v-if="userRoles !== null && userRoles.length > 0">
                <span>Permissões:</span>
                <ul>
                    <div
                        v-for="(userRole, userRoleIndex) in userRoles"
                    >
                        <li
                            class="mt-3"
                            v-for="(role, roleIndex) in userRole.roles"
                            @mouseover="hovering = userRoleIndex + '_' + roleIndex"
                            @mouseout="hovering = null"
                        >
                            O usuário <strong>{{ userRole.user.name }}</strong> do setor <strong>{{ userRole.setor.name }}</strong> possui perfil <strong>{{ role.name }}</strong>
                            <b-badge
                                v-show="hovering === userRoleIndex + '_' + roleIndex "
                                size="sm"
                                variant="danger"
                                href="#"
                                @click.prevent="removeRole(userRole.id, role.id)"
                                :disabled="isRemovingRole"
                            >
                                <b-icon icon="trash" aria-hidden="true"></b-icon>
                            </b-badge>
                        </li>
                    </div>
                </ul>
            </div>
            <div v-else>
                <p>O usuário ainda não possui nenhum setor associado. Selecione um Setor, um Perfil e clique em Incluir.</p>
            </div>
        </b-row>
    </b-container>
</template>

<script>
import axios from 'axios'
import Multiselect from "vue-multiselect";

export default({
    components: {
        Multiselect
    },
    props: ['user_id'],
    data () {
        return {
            oldSetor: null,
            setor: null,
            setores: [],
            isLoadingSetores: false,
            oldRole: null,
            role: null,
            roles: [],
            isLoadingRoles: false,
            isIncluding: false,
            userRoles: null,
            hovering: null,
            isRemovingRole: false
        }
    },
    mounted () {
        this.searchSetor("")
        this.searchRole("")
        this.fetchRoles()
    },
    methods: {
        searchSetor (query) {
            this.isLoadingSetores = true
            axios.post('/setores/search', {
                query: query
            }).then(response => {
                this.setores = response.data
                this.isLoadingSetores = false
            })
        },
        openSetor () {
            this.oldSetor = this.setor
            this.setor = null
        },
        closeSetor () {
            if (this.setor == null) {
                this.setor = this.oldSetor
                this.oldSetor = null
            }
        },
        searchRole (query) {
            this.isLoadingRoles = true
            axios.post('/roles/search', {
                query: query
            }).then(response => {
                this.roles = response.data
                this.isLoadingRoles = false
            })
        },
        openRole () {
            this.oldRole = this.setor
            this.role = null
        },
        closeRole () {
            if (this.role == null) {
                this.role = this.oldRole
                this.oldRole = null
            }
        },
        async include () {
            this.isIncluding = true
            await axios.post('/setor-user/create', {
                user_id: this.user_id,
                setor_id: this.setor.id,
                role_id: this.role.id
            })
            .then(response => {
                this.fetchRoles()
            })
            .catch(error => {

            })
            this.isIncluding = false
        },
        async fetchRoles () {
            this.fetchingRoles = true
            await axios.get(`/users/${this.user_id}/roles`)
                .then(response => {
                    this.userRoles = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },
        async removeRole (setor_user_id, role_id) {
            this.isRemovingRole = true
            await axios.post(`/setor-user/${setor_user_id}/role`, {
                    role_id: role_id
                })
                .then(response => {
                    this.fetchRoles()
                })
                .catch(error => {
                    console.log(error)
                })
            this.isRemovingRole = false

        }
    },
    watch: {

    }
})
</script>
