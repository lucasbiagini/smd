<template>
    <div v-if="form !== null">
        <b-form-group
            label-for="dados_compartilhados-transferencia"
        >
            <template #label>
                <b-icon id="dados_compartilhados-transferencia-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="dados_compartilhados-transferencia-icon" triggers="hover" placement="top">
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
            label-for="organizacao-transferencia"
        >
            <template #label>
                <b-icon id="organizacao-transferencia-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="organizacao-transferencia-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Verifique se o país estrangeiro para o qual você está transferindo os dados possui legislação de proteção de dados e se é reconhecida como adequada pela Autoridade Nacional de Proteção de Dados - ANPD. Caso a legislação  do país estrangeiro não seja considerada como adequada pela ANPD, a instituição precisará indicar ao país estrangeiro uma estrutura legal para garantir a proteção dos dados pessoais do cidadãos brasileiros no exterior.</p>
                    <p>Exemplo: Transferência Internacional para o U.S. Department of Agriculture (USDA). Nesse caso, preencha o campo organização como "U.S. Department of Agriculture (USDA)" e preencha o campo "País" com "Estados Unidos".</p>
                </b-popover>
                <span>Nome da organização:</span>
            </template>
            <b-form-input
                id="organizacao-transferencia"
                v-model="form.organizacao"
                placeholder="Insira o nome da organização"
                required
            ></b-form-input>
        </b-form-group>

        <b-form-group
            label-for="pais-transferencia"
        >
            <template #label>
                <b-icon id="pais-transferencia-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="pais-transferencia-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Indique o país caso realize transferência internacional de dados pessoais.</p>
                </b-popover>
                <span>Nome da instituição:</span>
            </template>
            <b-form-input
                id="pais-transferencia"
                v-model="form.pais"
                placeholder="Insira o nome da instituição"
                required
            ></b-form-input>
        </b-form-group>

        <b-form-group
            label-for="garantia-transferencia"
        >
            <template #label>
                <b-icon id="garantia-transferencia-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="garantia-transferencia-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>A transferência internacional de dados pessoais somente é permitida nos casos elencados no art. 33 da LGPD.</p>
                </b-popover>
                <span>Garantia:</span>
            </template>
            <b-form-select
                id="garantias-select"
                v-model="form.garantia"
                :options="garantias"
            >
            </b-form-select>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['transferencia', 'dados', 'garantias'],
    data () {
        return {
            form: null
        }
    },
    mounted () {
        this.reset()
        this.$root.$on('transferencia:save', () => this.save())
    },
    methods: {
        reset () {
            this.form = {
                organizacao: this.transferencia.organizacao,
                dados_compartilhados: this.transferencia.dados_compartilhados,
                pais: this.transferencia.pais,
                garantia: this.transferencia.garantia !== null ? this.transferencia.garantia.value : null
            }
        },
        save () {
            axios.patch('/transferencias/' + this.transferencia.id, this.form)
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
                    this.$root.$emit('transferencia:updated')
                })
                .catch(error => {

                })
        },
    },
    computed: {
        isReadyToSubmit () {
            return this.form.garantia !== '' && this.form.dados_compartilhados !== [] && this.form.organizacao !== ''
        }
    }
})
</script>
