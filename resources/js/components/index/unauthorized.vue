<template>
    <div>
        <b-modal
            id="modal-unauthorized"
            centered
            hide-footer
            hide-header
            no-close-on-backdrop
            no-close-on-esc
            hide-header-close
            body-class="position static"
        >
            <b-overlay no-wrap rounded="sm" :show="isLoggingOut">
                <template #overlay>
                </template>
            </b-overlay>
            <p>{{ message }} <b-icon-exclamation-triangle-fill variant="warning"></b-icon-exclamation-triangle-fill></p>
            <a href="#"
               @click.prevent="logout">
                Sair
            </a>
        </b-modal>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: [
        'message'
    ],
    data () {
        return {
            isLoggingOut: false
        }
    },
    mounted () {
        this.$root.$emit('bv::show::modal', 'modal-unauthorized', '#focusThisOnClose')
    },
    methods: {
        async logout () {
            this.isLoggingOut = true
            await axios.post('/logout')
                .then(() => {})
                .catch(() => window.location.href='/')
        }
    }
})
</script>
