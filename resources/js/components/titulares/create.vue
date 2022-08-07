<template>
    <div>
        <b-button
            v-b-modal.create-titular
            variant="success"
            style="position: absolute; top: 0; right: 0"
        >
            Cadastrar
        </b-button>
        <b-modal
            id="create-titular"
            title="Criar Setor"
            size="xl"
            ref="modal"
        >

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

            <template #modal-footer="{ criar, cancelar }">
                <div class="w-100">
                    <b-button id="cancelar" variant="danger" size="sm" class="float-right mr-auto" @click="close">
                        Cancelar
                    </b-button>
                    <b-button :disabled="!isReadyToSubmit" id="criar" variant="primary" size="sm" class="float-right mr-2" @click="submit">
                        Criar
                    </b-button>
                </div>
            </template>
        </b-modal>
    </div>
</template>

<script>

import axios from "axios";

export default({
    props: ['processo_id', 'tipos'],
    data () {
        return {
            form: {
                desc: '',
                tipo: null
            }
        }
    },
    mounted () {

    },
    methods: {
        submit () {
            axios.post('/titulares', {
                processo_id: this.processo_id,
                desc: this.form.desc,
                tipo: this.form.tipo,
            })
                .then(response => {
                    this.close()
                    this.$swal.fire({
                        timer: 1000,
                        title: 'Sucesso!',
                        icon: 'success',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true
                    })
                    this.$root.$emit('titular:created')
                })
                .catch(error => {
                    console.log(error)
                })
        },
        reset () {
            this.form = {
                desc: '',
                tipo: null,
            }
        },
        close () {
            this.reset()
            this.$refs['modal'].hide()
        },
    },
    computed: {
        isReadyToSubmit () {
            return this.form.desc !== '' && this.form.tipo !== null
        }
    }
})
</script>
