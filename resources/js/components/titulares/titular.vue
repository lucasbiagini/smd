<template>
    <div v-if="form !== null">
        <b-form-group
            label-for="tipo-titular"
        >
            <template #label>
                <span>Tipo:</span>
            </template>
            <b-form-select
                id="tipos-select"
                v-model="form.tipo"
                :options="tipos"
            >
            </b-form-select>
        </b-form-group>
        <b-form-group
            label-for="desc-titular"
        >
            <template #label>
                <b-icon id="desc-titular-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="desc-titular-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Se necessário, descreva  informações complementares detalhando a categoria do titular dos dados pessoais.</p>
                    <p>Exemplo 1: Categoria de titular = Pessoas. Nesse caso, a coluna "Descrição" poderia ser preenchida com "Pessoas com deficiência", "Pessoas de baixa renda", etc.</p>
                    <p>Exemplo 2: Categoria de titular = Dependentes. Nesse caso, a coluna "Descrição" poderia ser preenchida com "Dependentes para fins de IRRF", "Dependentes de para fins de Plano de Saúde", etc.</p>
                </b-popover>
                <span>Descrição:</span>
            </template>
            <b-form-textarea
                id="desc-titular"
                rows="4"
                v-model="form.desc"
            ></b-form-textarea>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['titular', 'tipos'],
    data () {
        return {
            form: null
        }
    },
    mounted () {
        this.reset()
        this.$root.$on('titular:save', () => this.save())
    },
    methods: {
        reset () {
            this.form = {
                desc: this.titular.desc,
                tipo: this.titular.tipo !== null ? this.titular.tipo.value : null,
            }
        },
        save () {
            axios.patch('/titulares/' + this.titular.id, this.form)
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
                    this.$root.$emit('titular:updated')
                })
                .catch(error => {

                })
        },
    }
})
</script>
