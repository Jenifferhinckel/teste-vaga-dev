<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edição de Cliente</title>
    
    
    <link href="../../public/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../public/css/estilo.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body class="container">
        <div class="container bg-light border-style: dotted">
            <h5 class="my-4  fw-normal text-center font-weight: bold">Formulário de edição</h5>
            <form action="../update/<?php echo $cliente['id']; ?>" method="post">
                <div class="row">
                    <div class="col-4">
                        <label for="cnpj">CNPJ:</label>
                        <input type="text" id="cnpj" name="cnpj" class="form-control" maxlength="18" onkeyup="campoCNPJ(this)" value="<?php echo $cliente['cnpj']; ?>" placeholder="Ex.: 000.000.000-00" required>
                    </div>
                    <div class="col-8">
                        <label for="nome_empresa">Nome da Empresa:</label>
                        <input type="text" id="nome_empresa" name="nome_empresa" value="<?php echo $cliente['nome_empresa']; ?>" class="form-control" required>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-3">
                        <label for="cep">CEP:</label>
                        <input type="text" id="cep" name="cep" class="form-control" maxlength="9" onkeyup="campoCEP(this)" value="<?php echo $cliente['cep']; ?>" placeholder="00000-000" required>
                    </div>
                    <div class="col-7">
                        <label for="endereco">Endereço:</label>
                        <input type="text" id="endereco" name="endereco" value="<?php echo $cliente['endereco']; ?>" class="form-control" required>
                    </div>
                    <div class="col-2">
                        <label for="numero">Número:</label>
                        <input type="number" id="numero" name="numero" value="<?php echo $cliente['numero']; ?>" class="form-control" required>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-4">
                        <label for="bairro">Bairro:</label>
                        <input type="text" id="bairro" name="bairro" value="<?php echo $cliente['bairro']; ?>" class="form-control" required>
                    </div>
                    <div class="col-4">
                        <label for="uf">UF</label>
                        <select name="uf" id="uf" class="form-control form-control" required>
                            <option disabled selected>Escolha um estado</option>
                        </select>
                        <input type="hidden" id="ufAnterior" value="<?php echo $cliente['uf']; ?>"/>
                    </div>
                    <div class="col-4">
                        <label for="cidade">Cidade</label>
                        <select name="cidade" id="cidade" class="form-control form-control" required>
                        </select>
                        <input type="hidden" id="cidadeAnterior" value="<?php echo $cliente['cidade']; ?>"/>
                    </div>
                </div>
                <div class="row d-flex justify-content-end my-5">
                    <div class="col-3">
                        <a class="w-100 btn btn-danger btn-lg " href="../">Voltar</a><br>
                    </div>
                    <div class="col-3">
                        <button class="w-100 btn btn-lg btn-success" type="submit">Editar</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
<script>
    $(document).ready(function($){ 
        //busca estados
        $.ajax({
            url: '../estados',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var dadosSelect = $('#uf');

                var estados = JSON.parse(response).sort(function(a, b) {
                    return a.nome.localeCompare(b.nome);
                });

                $.each(estados, function(index, dados) {
                    var ufAnterior = $('#ufAnterior').val();
                    var selecionado;
                    if (dados.sigla == ufAnterior) {
                        selecionado = 'selected';
                    }
                    dadosSelect.append("<option value=" + dados.sigla +" "+ selecionado + ">" + dados.nome + "</option>");
                });
                if ($('#uf').val() !== null) {
                    $("#uf").change();
                }
            },
            error: function(xhr, status, error) {
                console.log('Erro: ' + error);
            }
        });
    });    
    //busca cidade
    $('#uf').on('change', function(e){ 
        let sigla = $('#uf').val();
        if (sigla !== null) {
            $.ajax({
                url: '../cidades/'+ sigla,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var dadosSelect = $('#cidade');
                    dadosSelect.empty();
                    dadosSelect.append("<option disabled selected>Escolha uma cidade</option>")

                    JSON.parse(response).map(function(item, indice){
                        let cidadeAnterior = $('#cidadeAnterior').val();
                        var cidade = item.nome.charAt(0).toUpperCase() + item.nome.slice(1).toLowerCase();
                        if (cidade == cidadeAnterior) {
                            dadosSelect.empty();
                            dadosSelect.append("<option value=" + cidadeAnterior +" selected>" + cidadeAnterior + "</option>")
                        }
                    });

                    $.each(JSON.parse(response), function(index, dados) {
                        var cidade = dados.nome.charAt(0).toUpperCase() + dados.nome.slice(1).toLowerCase();
                        dadosSelect.append("<option value=" + cidade +">" + cidade + "</option>");
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Erro: ' + error);
                }
            });
        }
    });  

    function formatCNPJ(cnpj) {
      cnpj = cnpj.replace(/\D/g, '');
      cnpj = cnpj.replace(/^(\d{2})(\d)/, '$1.$2');
      cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
      cnpj = cnpj.replace(/\.(\d{3})(\d)/, '.$1/$2');
      cnpj = cnpj.replace(/(\d{4})(\d)/, '$1-$2');
      return cnpj;
    }
    
    function campoCNPJ(input) {
      var formatted = formatCNPJ(input.value);
      input.value = formatted;
    }

    function formatCEP(cep) {
        cep = cep.replace(/\D/g, '');
        cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
        return cep;
    }
    
    function campoCEP(input) {
      var formatted = formatCEP(input.value);
      input.value = formatted;
    }
</script>