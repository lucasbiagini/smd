<template>
    <div>
        <div v-if="agentes !== null">
            <h3>Agentes de  Tratamento e Encarregado</h3>
            <agente
                :agente="agentes.controlador"
                title="Controlador"
                tipo="controlador"
                :disabled="isApproved"
            ></agente>
            <agente
                :agente="agentes.encarregado"
                title="Encarregado"
                tipo="encarregado"
                :disabled="isApproved"
            ></agente>
            <agente
                v-for="(operador, index) in agentes.operadores"
                :key="`operador_${operador.id}`"
                :agente="operador.agente"
                :title="`${agentes.operadores.length > 1 ? (index + 1) + 'º ' : ''} Operador`"
                tipo="operador"
                :disabled="isApproved"
                :operador="operador"
                :form_index="index"
                :deletable="agentes.operadores.length > 1"
            ></agente>
            <b-button variant="success" @click="addOperador" class="float-right" v-if="!isApproved">Adicionar Operador</b-button>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['processo'],
    data () {
        return {
            agentes: null,
            isFetching: false,
            fetching: 0
        }
    },
    mounted () {
        this.fetch()
        this.$root.$on('remove:operador', (operador_id) => this.removeOperador(operador_id))
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
        async fetch () {
            this.startFetching()
            await axios.get(`/processos/${this.processo.id}/agentes`)
                .then(response => {
                    this.agentes = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            this.stopFetching()
        },
        async addOperador () {
            this.startFetching()
            await axios.post(`/processos/${this.processo.id}/operador`)
                .then(response => {
                    this.agentes.operadores = response.data
                })
                .then(error => {
                    console.log(error)
                })
            this.stopFetching()
        },
        async removeOperador (operador_id) {
            this.startFetching()
            await axios.delete(`/operadores/${operador_id}`)
                .then(response => {
                    this.agentes.operadores = response.data
                })
                .then(error => {
                    console.log(error)
                })
            this.stopFetching()
        }
    },
    computed: {
        isApproved () {
            return this.processo.checklist !== null &&
                (this.processo.checklist['agentes'].approved || this.processo.ready_at !== null)
        }
    }
})
</script>
