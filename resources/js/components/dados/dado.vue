<template>
    <div v-if="form !== null">
        <b-form-group
            label-for="categoria-dado"
        >
            <template #label>
                <span>Categoria:</span>
            </template>
            <b-form-select
                id="categoria-select"
                v-model="form.categoria"
            >
                <b-form-select-option-group
                    v-for="(subcategorias, categoria) in categorias"
                    :key="categoria"
                    :label="categoria">
                    <b-form-select-option
                        v-for="subcategoria in subcategorias"
                        :key="subcategoria.value"
                        :value="subcategoria.value"
                    >
                        {{ subcategoria.text }}
                    </b-form-select-option>
                </b-form-select-option-group>
            </b-form-select>
        </b-form-group>

        <b-form-group
            label-for="desc-dado"
        >
            <template #label>
                <span>Descrição:</span>
            </template>
            <b-form-textarea
                :disabled="form.categoria === null"
                id="desc-dado"
                :placeholder="form.categoria ? form.categoria.desc : ''"
                rows="4"
                v-model="form.desc"
            ></b-form-textarea>
        </b-form-group>

        <b-form-group
            label-for="tempo-dado"
        >
            <template #label>
                <b-icon id="tempo-dado-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="tempo-dado-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Para definição do tempo de retenção é indicado verificar:</p>
                    <p>- se existe alguma definição legal de tempo de retenção/guarda/arquivamento de documentos e/ou dos dados tratados pelo órgão e/ou entidade;e</p>
                    <p>- tabela de temporalidade do CONARQ, disponível <a target="_blank" href="http://conarq.gov.br/publicacoes-tecnicas/37-publicacoes/20-classificacao-temporalidade-e-destinacao-de-documentos-de-arquivo-relativo-as-atividades-meio-da-administracao-publica.html">aqui.</a></p>
                </b-popover>
                <span>Tempo de retenção dos dados:</span>
            </template>
            <b-form-textarea
                id="tempo-dado"
                placeholder="Descreva aqui o tempo de retenção dos dados."
                rows="4"
                v-model="form.tempo"
            ></b-form-textarea>
        </b-form-group>

        <b-form-group
            label-for="fonte-dado"
        >
            <template #label>
                <b-icon id="fonte-dado-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="fonte-dado-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Informar a principal fonte de retenção/armazenamento dos dados para a categoria de dados pessoais.</p>
                </b-popover>
                <span>Fonte de retenção dos dados:</span>
            </template>
            <b-form-select
                id="fontes-select"
                v-model="form.fonte"
                :options="fontes"
                @change="checkFonte"
            >
            </b-form-select>
        </b-form-group>

        <b-form-group
            label-for="base-dado"
        >
            <template #label>
                <b-icon id="base-dado-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="base-dado-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Preencher a base de dados, se a principal fonte de retenção / armazenamento dos dados pessoais for uma base de dados do SGD.</p>
                    <p>Caso a instituição ainda não conheça a iniciativa de Catálogo de Base de Dados da SGD, acesse o link <a target="_blank" href="https://www.gov.br/governodigital/pt-br/governanca-de-dados/catalogo-de-bases-de-dados">aqui.</a></p>
                </b-popover>
                <span>Base de dados SGD:</span>
            </template>
            <b-form-select
                :disabled="form.fonte !== 0"
                id="bases-select"
                v-model="form.base_dados"
                :options="bases"
            >
            </b-form-select>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['dado', 'categorias', 'bases', 'fontes'],
    data () {
        return {
            form: null
        }
    },
    mounted () {
        this.reset()
        this.$root.$on('dado:save', () => this.save())
    },
    methods: {
        checkFonte ()
        {
            if (this.form.fonte !== 0) {
                this.form.base_dados = null
            }
        },
        reset () {
            this.form = {
                categoria: this.dado.categoria !== null ? this.dado.categoria.value : null,
                desc: this.dado.desc,
                tempo: this.dado.tempo,
                fonte: this.dado.fonte !== null ? this.dado.fonte.value : null,
                base_dados: this.dado.base_dados !== null ? this.dado.base_dados.value : null
            }
        },
        save () {
            axios.patch('/dados/' + this.dado.id, this.form)
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
                    this.$root.$emit('dado:updated')
                })
                .catch(error => {

                })
        },
    }
})
</script>
