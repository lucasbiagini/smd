<!DOCTYPE html>
<html>
<head>
    <title>{{ $name }} / {{ $ref }}</title>
</head>
<body>
    <h1>Inventário de Dados Pessoais</h1>
    <p><strong>Processo:</strong>{{ $name }}</p>
    <p><strong>Ref:</strong>{{ $ref }}</p>
    <p><strong>Status:</strong>{{ $approved_at !== null ? 'HOMOLOGADO - ' . (new \Carbon\Carbon($approved_at))->format('d/m/Y H:m:i') : ($ready_at !== null ? 'EM ANÁLISE - ' . (new \Carbon\Carbon($ready_at))->format('d/m/Y H:m:i') : 'PENDENTE') }}</p>
    <p><strong>Data de Criação:</strong>{{ (new \Carbon\Carbon($created_at))->format('d/m/Y H:m:i') }}</p>
    <p><strong>Última Atualização:</strong>{{ (new \Carbon\Carbon($updated_at))->format('d/m/Y H:m:i') }}</p>
    <p><strong>Descrição:</strong>{{ $description }}</p>

    <div class="page_break"></div>
    <h1>Imagem do Processo</h1>
    <img style="width:100%" src="{{public_path($image)}}" alt="image" >

    <div class="page_break"></div>
    <h1>Agentes de Tratamento</h1>
    <h2>Controlador</h2>
    <p><strong>Nome: </strong>{{ $controlador['nome'] !== null && $controlador['nome'] !== '' ? $controlador['nome'] : '-' }}</p>
    <p><strong>Endereço: </strong>{{ $controlador['endereco'] !== null && $controlador['endereco'] !== '' ? $controlador['endereco'] : '-' }}</p>
    <p><strong>CEP: </strong>{{ $controlador['cep'] !== null && $controlador['cep'] !== '' ? $controlador['cep'] : '-' }}</p>
    <p><strong>Telefone: </strong>{{ $controlador['telefone'] !== null && $controlador['telefone'] !== '' ? $controlador['telefone'] : '-' }}</p>
    <p><strong>Email: </strong>{{ $controlador['email'] !== null && $controlador['email'] !== '' ? $controlador['email'] : '-' }}</p>

    <h2>Encarregado</h2>
    <p><strong>Nome: </strong>{{ $encarregado['nome'] !== null && $encarregado['nome'] !== '' ? $encarregado['nome'] : '-' }}</p>
    <p><strong>Endereço: </strong>{{ $encarregado['endereco'] !== null && $encarregado['endereco'] !== '' ? $encarregado['endereco'] : '-' }}</p>
    <p><strong>CEP: </strong>{{ $encarregado['cep'] !== null && $encarregado['cep'] !== '' ? $encarregado['cep'] : '-' }}</p>
    <p><strong>Telefone: </strong>{{ $encarregado['telefone'] !== null && $encarregado['telefone'] !== '' ? $encarregado['telefone'] : '-' }}</p>
    <p><strong>Email: </strong>{{ $encarregado['email'] !== null && $encarregado['email'] !== '' ? $encarregado['email'] : '-' }}</p>

    @foreach($operadores as $key => $operador)
        <h2>{{sizeof($operadores) > 1 ? ($key + 1) . 'º ' : ''}}Operador</h2>
        <p><strong>Nome: </strong>{{ $operador['agente']['nome'] !== null && $operador['agente']['nome'] !== '' ? $operador['agente']['nome'] : '-' }}</p>
        <p><strong>Endereço: </strong>{{ $operador['agente']['endereco'] !== null && $operador['agente']['endereco'] !== '' ? $operador['agente']['endereco'] : '-' }}</p>
        <p><strong>CEP: </strong>{{ $operador['agente']['cep'] !== null && $operador['agente']['cep'] !== '' ? $operador['agente']['cep'] : '-' }}</p>
        <p><strong>Telefone: </strong>{{ $operador['agente']['telefone'] !== null && $operador['agente']['telefone'] !== '' ? $operador['agente']['telefone'] : '-' }}</p>
        <p><strong>Email: </strong>{{ $operador['agente']['email'] !== null && $operador['agente']['email'] !== '' ? $operador['agente']['email'] : '-' }}</p>
    @endforeach

    <div class="page_break"></div>
    <h1>Fluxo do Tratamento</h1>
    <p><strong>Descrição: </strong>{{ $desc !== null && $desc !== '' ? $desc : '-' }}</p>

    <div class="page_break"></div>
    <h1>Escopo e Natureza dos Dados Pessoais</h1>
    <p><strong>Abrangência da área geográfica do tratamento: </strong>{{ $abrangencia !== null && $abrangencia !== '' ? $abrangencia : '-' }}</p>
    <p><strong>Fonte de dados utilizada para obtenção dos dados pessoais: </strong>{{ $fonte !== null && $fonte !== '' ? $fonte : '-' }}</p>

    <div class="page_break"></div>
    <h1>Finalidade do Tratamento de Dados Pessoais</h1>
    <p><strong>Hipótese de tratamento: </strong>{{ $hipotese !== null && $hipotese !== '' ? $hipotese : '-' }}</p>
    <p><strong>Finalidade: </strong>{{ $finalidade !== null && $finalidade !== '' ? $finalidade : '-' }}</p>
    <p><strong>Previsão legal: </strong>{{ $previsao_legal !== null && $previsao_legal !== '' ? $previsao_legal : '-' }}</p>
    <p><strong>Resultados pretendidos para o titular de dados: </strong>{{ $resultados !== null && $resultados !== '' ? $resultados : '-' }}</p>
    <p><strong>Benefícios esperados para o órgão, entidade ou para a sociedade como um todo: </strong>{{ $beneficios !== null && $beneficios !== '' ? $beneficios : '-' }}</p>

    <div class="page_break"></div>
    <h1>Categoria de Dados Pessoais</h1>
    <p><strong>Trata dados de crianças e adolescentes? </strong> {{ $criancas !== null ? ($criancas === 1 ? 'Sim' : 'Não') : '-' }}</p>
    <p><strong>Além de crianças e adolescente trata dados de outro grupo vulnerável? </strong> {{ $vulneraveis !== null ? ($vulneraveis === 1 ? 'Sim' : 'Não') : '-' }}</p>
    <ol>
    @foreach($dados as $dado)
        <li>
            <h2>{{$dado['categoria']['text']}}</h2>
            <p><strong>Descrição: </strong>{{ $dado['desc'] }}</p>
            <p><strong>Tempo de retenção dos dados: </strong>{{ $dado['tempo'] }}</p>
            <p><strong>Fonte de retenção dos dados: </strong>{{ $dado['fonte']['text'] }}</p>
            @if(isset($dado['base_dados']))
                <p><strong>Base de dados SGD: </strong>{{ $dado['base_dados']['text'] }}</p>
            @endif
        </li>
    @endforeach
    </ol>

    <div class="page_break"></div>
    <h1>Frequência e totalização das categorias de dados pessoais tratados</h1>
    <p><strong>Frequência: </strong>{{ $frequencia }}</p>
    <p><strong>Quantidade: </strong>{{ $quantidade }}</p>

    <div class="page_break"></div>
    <h1>Categorias dos titulares de titulares pessoais</h1>
    <ol>
    @foreach($titulares as $titular)
        <li>
            <p><strong>Tipo: </strong>{{ $titular['tipo']['text'] }}</p>
            <p><strong>Descrição: </strong>{{ $titular['desc'] }}</p>
        </li>
    @endforeach
    </ol>

    <div class="page_break"></div>
    <h1>Compartilhamento de Dados Pessoais</h1>
    <ol>
    @foreach($compartilhamentos as $compartilhamento)
        <li>
            <p><strong>Nome da instituição: </strong>{{ $compartilhamento['nome_instituicao'] !== null && $compartilhamento['nome_instituicao'] !== '' ? $compartilhamento['nome_instituicao'] : '-' }}</p>
            <p><strong>Finalidade: </strong>{{ $compartilhamento['finalidade'] !== null && $compartilhamento['finalidade'] !== '' ? $compartilhamento['finalidade'] : '-' }}</p>
            <p><strong>Dados compartilhados: </strong>@foreach ($compartilhamento['dados'] as $dado) {{$dado}}; @endforeach</p>
        </li>
    @endforeach
    </ol>

    <div class="page_break"></div>
    <h1>Medidas de Segurança/Privacidade</h1>
    <ol>
    @foreach($medidas as $medida)
        <li>
            <p><strong>Tipo: </strong>{{ $medida['tipo']['text'] !== null && $medida['tipo']['text'] !== '' ? $medida['tipo']['text'] : '-' }}</p>
            <p><strong>Descrição: </strong>{{ $medida['desc'] !== null && $medida['desc'] !== '' ? $medida['desc'] : '-' }}</p>
        </li>
    @endforeach
    </ol>

    <div class="page_break"></div>
    <h1>Transferência Internacional de Dados Pessoais</h1>
    <ol>
    @foreach($transferencias as $transferencia)
        <li>
            <p><strong>Nome da organização: </strong>{{  $transferencia['organizacao'] !== null && $transferencia['organizacao'] !== '' ? $transferencia['organizacao'] : '-' }}</p>
            <p><strong>País: </strong>{{  $transferencia['pais'] !== null && $transferencia['pais'] !== '' ? $transferencia['pais'] : '-' }}</p>
            <p><strong>Garantia: </strong>{{  $transferencia['garantia']['text'] !== null && $transferencia['garantia']['text'] !== '' ? $transferencia['garantia']['text'] : '-' }}</p>
            <p><strong>Dados compartilhados: </strong>@foreach ($transferencia['dados'] as $dado) {{$dado}}; @endforeach</p>
        </li>
    @endforeach
    </ol>

    <div class="page_break"></div>
    <h1>Contratos de serviços</h1>
    <ol>
        @foreach($contratos as $contrato)
            <li>
                <p><strong>Nº do processo de contratação: </strong>{{  $contrato['numero'] !== null && $contrato['numero'] !== '' ? $contrato['numero'] : '-' }}</p>
                <p><strong>Objeto do contrato: </strong>{{  $contrato['objeto'] !== null && $contrato['objeto'] !== '' ? $contrato['objeto'] : '-' }}</p>
                <p><strong>Email do gestor do contrato: </strong>{{  $contrato['email'] !== null && $contrato['email'] !== '' ? $contrato['email'] : '-' }}</p>
            </li>
        @endforeach
    </ol>
</body>

<style>
    .page_break { page-break-before: always; }
</style>
</html>
