<template>
    <div>
        <div v-if="agentes !== null">
            <h3>1 - Agentes de  Tratamento e Encarregado</h3>
            <agente
                :agente="agentes.controlador"
                tipo="controlador"
            ></agente>
            <agente
                :agente="agentes.encarregado"
                tipo="encarregado"
            ></agente>
            <agente
                v-for="(operador, index) in agentes.operadores"
                :key="`operador_${operador.id}`"
                :agente="operador.agente"
                tipo="operador"
                :operadores="agentes.operadores.length > 1"
                :operador="operador"
                :form_index="index"
                :deletable="agentes.operadores.length > 1"
            ></agente>
            <b-button variant="success" @click="addOperador" class="float-right">Adicionar Operador</b-button>
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
            tipos: null,
            isFetching: false,
            fetching: 0
        }
    },
    mounted () {
        this.fetchAgentes()
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
        async fetchAgentes () {
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
})
</script>
