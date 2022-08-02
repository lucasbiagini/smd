<template>
    <div>
            <b-modal
                id="modal-select-setor"
                title="Selecione um setor"
                centered
                hide-footer
                no-close-on-backdrop
                no-close-on-esc
                hide-header-close
                body-class="position static"
            >
                <b-overlay no-wrap rounded="sm" :show="isFetching || didSelect">
                    <template #overlay>
                    </template>
                </b-overlay>
                <b-form-select
                    v-model="setor"
                    @change="selected"
                >
                    <b-form-select-option :value="null">Para continuar, selecione um setor</b-form-select-option>
                    <b-form-select-option
                        v-for="(setor, index) in setores"
                        :key="index"
                        :value="setor"
                    >
                        {{ setor.name }}
                    </b-form-select-option>
                </b-form-select>
            </b-modal>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: [
      'user_id'
    ],
    data () {
        return {
            setores: [],
            setor: null,
            isFetching: false,
            didSelect: false
        }
    },
    mounted () {
        this.$root.$emit('bv::show::modal', 'modal-select-setor', '#focusThisOnClose')
        this.fetch()
    },
    methods: {
        async fetch () {
            this.isFetching = true
            await axios.get(`/users/${this.user_id}/setores`)
                .then(response => {
                    this.setores = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            this.isFetching = false
        },
        async selected () {
            this.didSelect = true
            await axios.post(`/setores/${this.setor.id}/select`)
                .then(response => {
                    location.reload();
                })
                .catch(error => {
                    console.log(error)
                    this.didSelect = false
                })
        }
    }
})
</script>
