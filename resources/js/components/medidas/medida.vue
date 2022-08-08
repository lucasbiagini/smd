<template>
    <div v-if="form !== null">
        <b-form-group
            label-for="tipo-medida"
        >
            <template #label>
                <b-popover target="desc-medida-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Descrever o(s) controle(s) específico adotado(s) para a medida de segurança.</p>
                    <p>Exemplo 1:</p>
                    <p>Tipo de medida de segurança selecionada = Controles Criptográficos.</p>
                    <p>Descrição do(s) Controle(s) = Utilização de criptografia para a proteção de dados pessoais armazenados em dispositivos móveis, mídias removíveis e banco de dados.</p>
                    <p>Exemplo 2:</p>
                    <p>Tipo de medida de segurança selecionada = Controles de Acessos Lógicos.</p>
                    <p>Descrição do(s) Controle(s) = Política de senha; Análise crítica de direitos de acesso em período de tempo previamente definido ou a qualquer momento depois de qualquer mudança nos direitos de usuários.</p>
                </b-popover>
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
            label-for="desc-medida"
        >
            <template #label>
                <b-icon id="desc-medida-icon" icon="question-circle-fill" variant="warning"></b-icon>
                <b-popover target="desc-medida-icon" triggers="hover" placement="top">
                    <template #title>Ajuda</template>
                    <p>Proteja os dados pessoais.</p>
                    <p>Garanta a integridade dos dados pessoais, minimizando o risco de perda ou vazamento de dados.</p>
                    <p>As medidas a serem tomadas, eletrônicas ou físicas, dependem da sensibilidade dos dados pessoais que você está tratando e dos riscos para os titulares de dados no caso de um incidente.</p>
                    <p>Várias ações devem ser implementadas: atualização de seu antivírus e software, alteração regular de senhas e adoção de senhas complexas ou criptografia de dados em determinadas situações. A adoação de criptografia propicia que no caso de perda ou roubo de um dispositivo eletrônico, será mais difícil para terceiros acessá-lo.</p>
                    <p>Insira quantas linhas forem necessárias para registrar as medidas de segurança adotadas. Se adotar menos de 3 medidas de segurança, exclua as linhas que não serão preenchidas. Exemplo: Se adotar apenas duas medidas de segurança, então exclua a linha identificadas por "Medida de Segurança 3".</p>
                </b-popover>
                <span>Descrição:</span>
            </template>
            <b-form-textarea
                id="desc-medida"
                rows="4"
                v-model="form.desc"
            ></b-form-textarea>
        </b-form-group>
    </div>
</template>

<script>
import axios from 'axios'

export default({
    props: ['medida', 'tipos'],
    data () {
        return {
            form: null
        }
    },
    mounted () {
        this.reset()
        this.$root.$on('medida:save', () => this.save())
    },
    methods: {
        reset () {
            this.form = {
                desc: this.medida.desc,
                tipo: this.medida.tipo !== null ? this.medida.tipo.value : null,
            }
        },
        save () {
            axios.patch('/medidas/' + this.medida.id, this.form)
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
                    this.$root.$emit('medida:updated')
                })
                .catch(error => {

                })
        },
    }
})
</script>
