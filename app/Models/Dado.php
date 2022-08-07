<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dado extends Model
{
    use HasFactory;

    const CATEGORIAS = [
        [
            'classe' => 'Dados de Identificação Pessoal',
            'value' => 0,
            'text' => 'Informações de identificação pessoal',
            'desc' => 'Descrever se são tratados dados: Nome, endereço  residencia, histórico de endereços anteriores, número de telefone fixo residencial, número celular  pessoal, e-mail pessoal, etc)',
        ],
        [
            'classe' => 'Dados de Identificação Pessoal',
            'value' => 1,
            'text' => 'Informações de identificação atribuídas por instituições governamentais',
            'desc' => 'Descrever se são tratados dados: CPF, RG, número do passaporte, número da carteira de motorista, número da placa, número de registro em conselho profissional, etc.',
        ],
        [
            'classe' => 'Dados de Identificação Pessoal',
            'value' => 2,
            'text' => 'Dados de identificação eletrônica',
            'desc' => 'Descrever se são tratados dados:  Endereços IP, cookies, momentos de conexão etc.',
        ],
        [
            'classe' => 'Dados de Identificação Pessoal',
            'value' => 3,
            'text' => 'Dados de localização  eletrônica',
            'desc' => 'Informar se são tratados dados: dados de comunicação de torres de celulares (ex: GSM), dados de GPS etc.',
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 4,
            'text' => 'Dados de identificação financeira',
            'desc' => 'Descrever se são tratados dados: Números de identificação, números de contas bancárias, números de cartões de crédito ou débito, códigos secretos.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 5,
            'text' => 'Recursos financeiros',
            'desc' => 'Descrever se são tratados dados: Renda, posses, investimentos, renda total, renda profissional, poupança, datas de início e término dos investimentos, receita de investimento, dívidas sobre ativos.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 6,
            'text' => 'Dívidas e despesas',
            'desc' => 'Descrever se são tratados dados: Total de despesas, aluguel, empréstimos, hipotecas e outras formas de crédito.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 7,
            'text' => 'Situação financeira (Solvência)',
            'desc' => 'Descrever se são tratados dados: Avaliação do rendimento e avaliação de capacidade de pagamento.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 8,
            'text' => 'Empréstimos, hipotecas, linhas de crédito',
            'desc' => 'Descrever se são tratados dados: Natureza do empréstimo, valor emprestado, saldo remanescente, data de início, período do empréstimo, taxa de juros, visão geral do pagamento, detalhes sobre as garantias.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 9,
            'text' => 'Assistência financeira',
            'desc' => 'Descrever se são tratados dados: Benefícios, assistência, bonificações, subsídios, etc.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 10,
            'text' => 'Detalhes da apólice de seguro',
            'desc' => 'Descrever se são tratados dados: Natureza da apólice de seguro, detalhes sobre os riscos cobertos, valores segurados, período segurado, data de rescisão, pagamentos feitos, recebidos ou perdidos, situação do contrato, etc.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 11,
            'text' => 'Detalhes do plano de pensão',
            'desc' => 'Descrever se são tratados dados:  Data efetiva do plano de pensão, natureza do plano, data de término do plano, pagamentos recebidos e efetuados, opções, beneficiários, etc.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 12,
            'text' => 'Transações financeiras',
            'desc' => 'Descrever se são tratados dados: Valores pagos e a pagar pelo titular dos dados, linhas de crédito concedidas, avais, forma de pagamento, visão geral do pagamento, depósitos e outras garantias, etc.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 13,
            'text' => 'Compensação',
            'desc' => 'Descrever se são tratados dados: Detalhes sobre compensações reivindicadas, valores pagos ou outros tipos de compensação, etc.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 14,
            'text' => 'Atividades profissionais',
            'desc' => 'Descrever se são tratados dado de atividades profissionais executadas pelo titular dos dados: natureza da atividade, natureza dos bens ou serviços utilizados ou entregues pela pessoa no registro, relações comerciais, etc.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 15,
            'text' => 'Acordos e ajustes',
            'desc' => 'Descrever se são tratados dados: Detalhes sobre acordos ou ajustes comerciais; acordos sobre representação ou acordos legais, etc.'
        ],
        [
            'classe' => 'Dados Financeiros',
            'value' => 16,
            'text' => 'Autorizações ou consentimentos',
            'desc' => 'Descrever se são tratados dados de: Autorizações ou consentimentos realizados pelo titular de dados, etc.'
        ],
        [
            'classe' => 'Características Pessoais',
            'value' => 17,
            'text' => 'Detalhes pessoais',
            'desc' => 'Descrever se são tratados dados: Idade, sexo, data de nascimento, local de nascimento, estado civil, nacionalidade.'
        ],
        [
            'classe' => 'Características Pessoais',
            'value' => 18,
            'text' => 'Detalhes militares',
            'desc' => 'Descrever se são tratados dados: Situação militar, patente militar, distinções militares, etc.'
        ],
        [
            'classe' => 'Características Pessoais',
            'value' => 19,
            'text' => 'Situação de Imigração',
            'desc' => 'Descrever se são tratados dados: Detalhes sobre o visto, autorização de trabalho, limitações de residência ou movimentação, condições especiais relacionadas à autorização de residência, etc.'
        ],
        [
            'classe' => 'Características Pessoais',
            'value' => 20,
            'text' => 'Descrição Física',
            'desc' => 'Dados de descrição física são informações físicas de uma pessoa com possibilidade de serem visivelmente indetificadas. Descrever se são tratados: Altura, peso, cor do cabelo, cor dos olhos, características distintivas, etc.'
        ],
        [
            'classe' => 'Hábitos Pessoais',
            'value' => 21,
            'text' => 'Hábitos',
            'desc' => 'Descrever se são tratados dados: Uso de tabaco, uso de álcool , hábito alimentar, dieta alimentar etc.'
        ],
        [
            'classe' => 'Hábitos Pessoais',
            'value' => 22,
            'text' => 'Estilo de vida',
            'desc' => 'Descrever se são tratados dados: Informações sobre o uso de bens ou serviços, comportamento dos titulares dos dados, etc.'
        ],
        [
            'classe' => 'Hábitos Pessoais',
            'value' => 23,
            'text' => 'Viagens e deslocamentos',
            'desc' => 'Descrever se são tratados dados: sobre antigas residências e deslocamentos, visto de viagem, autorizações de trabalho, etc.'
        ],
        [
            'classe' => 'Hábitos Pessoais',
            'value' => 24,
            'text' => 'Contatos sociais',
            'desc' => 'Descrever se são tratados dados: Amigos, parceiros de negócios, relacionamentos com pessoas que não sejam familiares próximos; etc.'
        ],
        [
            'classe' => 'Hábitos Pessoais',
            'value' => 25,
            'text' => 'Posses',
            'desc' => 'Descrever se são tratados dados: Terra, propriedade ou outros bens.'
        ],
        [
            'classe' => 'Hábitos Pessoais',
            'value' => 26,
            'text' => 'Denúncias, incidentes ou acidentes',
            'desc' => 'Descrever se são tratados dados: Informações sobre um acidente, incidente ou denúncia na qual o titular dos dados está envolvido, a natureza dos danos ou ferimentos, pessoas envolvidas, testemunhas, etc.'
        ],
        [
            'classe' => 'Hábitos Pessoais',
            'value' => 27,
            'text' => 'Distinções',
            'desc' => 'Descrever se são tratados dados: Distinções civis, administrativas ou militares.'
        ],
        [
            'classe' => 'Hábitos Pessoais',
            'value' => 28,
            'text' => 'Uso de mídia',
            'desc' => 'Descrever se são tratados dados: que definem o comportamento de uso de mídias e meios de comunicação.'
        ],
        [
            'classe' => 'Características Psicológicas',
            'value' => 29,
            'text' => 'Descrição Psicológica',
            'desc' => 'Descrever se são tratados dados sobre personalidade ou caráter.'
        ],
        [
            'classe' => 'Composição Familiar',
            'value' => 30,
            'text' => 'Casamento ou forma atual de coabitação',
            'desc' => 'Descrever se são tratados dados: Nome do cônjuge ou companheiro(a), nome de solteira do cônjuge ou companheira, data do casamento, data do contrato de coabitação, número de filhos, etc.'
        ],
        [
            'classe' => 'Composição Familiar',
            'value' => 31,
            'text' => 'Histórico conjugal',
            'desc' => 'Descrever se são tratados dados  sobre casamentos ou parcerias anteriores, divórcios, separações, nomes de parceiros anteriores.'
        ],
        [
            'classe' => 'Composição Familiar',
            'value' => 32,
            'text' => 'Familiares ou membros da família',
            'desc' => 'Descrever se são tratados dados sobre Detalhes de outros familiares ou membros da família do titular de dados.'
        ],
        [
            'classe' => 'Interesses de Lazer',
            'value' => 33,
            'text' => 'Atividades e interesses de lazer',
            'desc' => 'Descrever se são tratados dados sobre hobbies, esportes, outros interesses.'
        ],
        [
            'classe' => 'Associações',
            'value' => 34,
            'text' => 'Associações (exceto profissionais, políticas, em sindicatos ou qualquer outra associação que se enquadre em dados pessoais sensíveis)',
            'desc' => 'Descrever se são tratados dados sobre participação em organizações de caridade ou benevolentes, clubes, parcerias, organizações, grupos, etc.'
        ],
        [
            'classe' => 'Processo Judicial/Administrativo/Criminal',
            'value' => 35,
            'text' => 'Suspeitas',
            'desc' => 'Descrever se são tratados dados sobre suspeitas de violações, conexões conspiratórias com criminosos conhecidos. Inquéritos ou ações judiciais (civis ou criminais) empreendidas por ou contra o titular dos dados, etc.'
        ],
        [
            'classe' => 'Processo Judicial/Administrativo/Criminal',
            'value' => 36,
            'text' => 'Condenações e sentenças',
            'desc' => 'Descrever se são tratados dados sobre condenações e sentenças, etc.'
        ],
        [
            'classe' => 'Processo Judicial/Administrativo/Criminal',
            'value' => 37,
            'text' => 'Ações judiciais',
            'desc' => 'Descrever se são tratados dados sobre tutela, guarda temporária ou definitiva, interdição, adoção, etc.'
        ],
        [
            'classe' => 'Processo Judicial/Administrativo/Criminal',
            'value' => 38,
            'text' => 'Penalidades Administrativas',
            'desc' => 'Descrever se são tratados dados sobre multas, processo disciplinar, advertências, bem como qualquer outro tipo de penalidade ou sanção administrativa prevista em leis, normas e regulamentos.'
        ],
        [
            'classe' => 'Hábitos de Consumo',
            'value' => 39,
            'text' => 'Dados de bens e serviços',
            'desc' => 'Descrever se são tratados dados sobre bens e serviços vendidos, alugados ou emprestados ao titular dos dados.'
        ],
        [
            'classe' => 'Dados Residenciais',
            'value' => 40,
            'text' => 'Residência',
            'desc' => 'Descrever se são tratados dados sobre natureza da residência, propriedade própria ou alugada, duração da residência nesse endereço, aluguel, custos, classificação da residência, detalhes sobre a avaliação, nomes das pessoas que possuem as chaves.'
        ],
        [
            'classe' => 'Educação e Treinamento',
            'value' => 41,
            'text' => 'Dados acadêmicos/escolares',
            'desc' => 'Descrever se são tratados dados sobre  diplomas, certificados obtidos, resultados de exames, avaliação do progresso dos estudos, histórico escolar, grau de formação, etc.'
        ],
        [
            'classe' => 'Educação e Treinamento',
            'value' => 42,
            'text' => 'Registros financeiros do curso/treinamento',
            'desc' => 'Descrever se são tratados dados sobre taxas de inscrição e custos pagos, financiamento, formas de pagamento, registros de pagamento, etc.'
        ],
        [
            'classe' => 'Educação e Treinamento',
            'value' => 43,
            'text' => 'Qualificação e experiência profissional',
            'desc' => 'Descrever se são tratados dados sobre certificações profissionais, interesses profissionais, interesses acadêmicos, interesses de pesquisam experiência de ensino, etc.'
        ],
        [
            'classe' => 'Profissão e Emprego',
            'value' => 44,
            'text' => 'Emprego atual',
            'desc' => 'Descrever se são tratados dados sobre empregador, descrição do cargo e função, antiguidade, data de recrutamento, local de trabalho, especialização ou tipo de empresa, modos e condições de trabalho, cargos anteriores e experiência anterior de trabalho no mesmo empregador, etc.'
        ],
        [
            'classe' => 'Profissão e Emprego',
            'value' => 45,
            'text' => 'Recrutamento',
            'desc' => 'Descrever se são tratados dados sobre data de recrutamento, método de recrutamento, fonte de recrutamento, referências, detalhes relacionados com o período de estágio, etc.'
        ],
        [
            'classe' => 'Profissão e Emprego',
            'value' => 46,
            'text' => 'Rescisão de trabalho',
            'desc' => 'Descrever se são tratados dados sobre data de rescisão, motivo, período de notificação, condições de rescisão, etc.'
        ],
        [
            'classe' => 'Profissão e Emprego',
            'value' => 47,
            'text' => 'Carreira',
            'desc' => 'Descrever se são tratados dados sobre emprego anterior e empregadores, períodos sem emprego, serviço militar, etc.'
        ],
        [
            'classe' => 'Profissão e Emprego',
            'value' => 48,
            'text' => 'Absentismo e disciplina',
            'desc' => 'Descrever se são tratados dados sobre registos de absentismo, motivos de ausência, medidas disciplinares, etc.'
        ],
        [
            'classe' => 'Profissão e Emprego',
            'value' => 49,
            'text' => 'Avaliação de Desempenho',
            'desc' => 'Descrever se são tratados dados sobre avaliação de desempenho ou qualquer outro tipo de análise de qualificação ou habilidades profissionais, etc.'
        ],
        [
            'classe' => 'Registros/gravações de vídeo, imagem e voz',
            'value' => 50,
            'text' => 'Vídeo e imagem',
            'desc' => 'Descrever se são tratados arquivos de vídeos, fotos digitais, fitas de vídeo, etc.'
        ],
        [
            'classe' => 'Registros/gravações de vídeo, imagem e voz',
            'value' => 51,
            'text' => 'Imagem de Vigilância',
            'desc' => 'Descrever se são tratadas imagens e/ou vídeos de câmeras de segurança/vigilância (ex: CFTV), etc.'
        ],
        [
            'classe' => 'Registros/gravações de vídeo, imagem e voz',
            'value' => 52,
            'text' => 'Voz',
            'desc' => 'Descrever se são tratadas fitas e arquivos digitais de voz, bem como outros registros de gravações de voz , etc'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 53,
            'text' => 'Dados que revelam origem racial ou ética',
            'desc' => 'Descreva aqui sobre os dados.'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 54,
            'text' => 'Dados que revelam convicção religiosa',
            'desc' => 'Descreva aqui sobre os dados.'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 55,
            'text' => 'Dados que revelam opinião política',
            'desc' => 'Descreva aqui sobre os dados.'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 56,
            'text' => 'Dados que revelam filiação a sindicato',
            'desc' => 'Descreva aqui sobre os dados.'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 57,
            'text' => 'Dados que revelam filiação a organização de caráter religioso',
            'desc' => 'Descreva aqui sobre os dados.'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 58,
            'text' => 'Dados que revelam filiação ou crença filosófica',
            'desc' => 'Descreva aqui sobre os dados.'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 59,
            'text' => 'Dados que revelam filiação ou preferências política',
            'desc' => 'Descreva aqui sobre os dados.'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 60,
            'text' => 'Dados referentes à saúde ou à vida sexual',
            'desc' => 'Descreva aqui sobre os dados.'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 61,
            'text' => 'Dados genéticos',
            'desc' => 'Descreva aqui sobre os dados.'
        ],
        [
            'classe' => 'Dados Pessoais Sensíveis',
            'value' => 62,
            'text' => 'Dados biométricos',
            'desc' => 'Dados de impressões digitais e de voz, digitalizações de íris, reconhecimento facial, reconhecimento de formato de dedo ou mão, assinaturas dinâmicas etc.'
        ],
        [
            'classe' => 'Outros',
            'value' => 63,
            'text' => 'Outros (Especificar)',
            'desc' => 'Descreva aqui sobre os dados.'
        ]
    ];

    protected $table = 'dados';

    protected $fillable = [
        'processo_id',
        'categoria',
        'desc',
        'tempo',
        'fonte',
        'base_dados'
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function getCategoriaAttribute($categoria)
    {
        return [
            'value' => $categoria,
            'text' => self::CATEGORIAS[$categoria]['text']
        ];
    }

    public function getFonteAttribute($fonte)
    {
        return [
            'value' => $fonte,
            'text' => FonteSGD::FONTES[$fonte]
        ];
    }

    public function getBaseDadosAttribute($base_dados)
    {
        return $base_dados === null ? null : [
            'value' => $base_dados,
            'text' => BaseSGD::BASES[$base_dados]
        ];
    }
}
