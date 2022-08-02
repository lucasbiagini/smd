<template>
    <b-container>
        <b-form-group
            v-if="permissionGroups !== null"
            v-for="(permissions, group) in permissionGroups"
            :key="group"
            :label="group"
            v-slot="{ ariaDescribedby }"
        >
            <b-form-checkbox
                v-for="permission in permissions"
                v-model="selected"
                :key="permission.id"
                :value="permission.name"
                :aria-describedby="ariaDescribedby"
                inline
            >
                {{ permission.desc }}
            </b-form-checkbox>
        </b-form-group>
    </b-container>
</template>

<script>
import axios from 'axios'

export default({
    props: [
        'role_id'
    ],
    data () {
        return {
            selected: [],
            permissionGroups: null,
            groups: null,
            isFetching: false,
            isFetchingAll: false
        }
    },
    mounted () {
        this.fetch()
        this.all()
        this.$root.$on('role:permissions', () => this.save())
    },
    methods: {
        async fetch ()
        {
            this.isFetching = true
            await axios.get(`/roles/${this.role_id}/permissions`)
                .then(response => {
                    this.selected = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            this.isFetching = false
        },
        async all () {
            this.isFetchingAll = true
            await axios.get('/permissions/all')
                .then(response => {
                    this.permissionGroups = response.data
                    this.groupes = Object.keys(this.permissionGroups)
                })
                .catch(error => {
                    console.log(error)
                })
            this.isFetchingAll = false
        },
        async save () {
            this.isSaving = true
            await axios.post(`/roles/${this.role_id}/permissions`, {
                permissions: this.selected
            })
                .then(response => {

                })
                .catch(error => {

                })
        }
    }
})
</script>
