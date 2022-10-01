<template>
    <div v-if="form !== null">
        <b-form-group
            label-for="dados_compartilhados-compartilhamento"
        >
            <template #label>
                <b-popover target="nome_instituicao-contrato-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Informe quais dados pessoais e dados pessoais sensíveis são compartilhados.</p>
                </b-popover>
                <span>Dados compartilhados:</span>
            </template>
            <b-form-checkbox-group
                id="dados_compartilhadoss-checkbox"
                v-model="form.dados_compartilhados"
                :options="dados"
                stacked
            ></b-form-checkbox-group>
        </b-form-group>

        <b-form-group
            label-for="nome_instituicao-contrato"
        >
            <template #label>
                <b-icon id="nome_instituicao-contrato-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="nome_instituicao-contrato-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Informe com quais instituições os dados pessoais são compartilhados. Insira na planilha quantas linhas forem necessárias para registrar todas as instituições que tem acesso ao dado pessoal via compartilhamento.</p>
                </b-popover>
                <span>Nome da instituição:</span>
            </template>
            <b-form-input
                id="nome_instituicao-contrato"
                v-model="form.nome_instituicao"
                placeholder="Insira o nome da instituição"
                maxlength="255"
                required
            ></b-form-input>
        </b-form-group>

        <b-form-group
            label-for="finalidade-compartilhamento"
        >
            <template #label>
                <span>Finalidade:</span>
            </template>
            <b-form-textarea
                id="finalidade-compartilhamento"
                rows="4"
                v-model="form.finalidade"
            ></b-form-textarea>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['compartilhamento', 'dados'],
    data () {
        return {
            form: null
        }
    },
    mounted () {
        this.reset()
        this.$root.$on('compartilhamento:save', () => this.save())
    },
    methods: {
        reset () {
            this.form = {
                nome_instituicao: this.compartilhamento.nome_instituicao,
                dados_compartilhados: this.compartilhamento.dados_compartilhados,
                finalidade: this.compartilhamento.finalidade
            }
        },
        save () {
            axios.patch('/compartilhamentos/' + this.compartilhamento.id, this.form)
                .then(response => {
                    this.$swal.fire({
                        timer: 1000,
                        title: 'Sucesso!',
                        icon: 'success',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true
                    })
                    this.$root.$emit('compartilhamento:updated')
                })
                .catch(error => {

                })
        },
    },
    computed: {
        isReadyToSubmit () {
            return this.form.finalidade !== '' && this.form.dados_compartilhados !== [] && this.form.nome_instituicao !== ''
        }
    }
})
</script>
