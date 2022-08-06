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

    public function getBaseDadosAtribute($base_dados)
    {
        return [
            'value' => $base_dados,
            'text' => BaseSGD::BASES[$base_dados]
        ];
    }
}
