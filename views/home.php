<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Clientes</title>
    
    
    <link href="../public/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/estilo.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body class="container">
        <div class="container bg-light border-style: dotted">
            <h5 class="my-4  fw-normal text-center font-weight: bold">Formulário de Cadastro</h5>
            <form action="cadastrar" method="post">
                <div class="row">
                    <div class="col-4">
                        <label for="cnpj">CNPJ:</label>
                        <input type="text" id="cnpj" name="cnpj" class="form-control" maxlength="18" onkeyup="campoCNPJ(this)" placeholder="Ex.: 000.000.000-00" required>
                    </div>
                    <div class="col-8">
                        <label for="nome_empresa">Nome da Empresa:</label>
                        <input type="text" id="nome_empresa" name="nome_empresa" class="form-control" required>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-3">
                        <label for="cep">CEP:</label>
                        <input type="text" id="cep" name="cep" class="form-control" maxlength="9" onkeyup="campoCEP(this)" placeholder="00000-000" required>
                    </div>
                    <div class="col-7">
                        <label for="endereco">Endereço:</label>
                        <input type="text" id="endereco" name="endereco" class="form-control" required>
                    </div>
                    <div class="col-2">
                        <label for="numero">Número:</label>
                        <input type="number" id="numero" name="numero" class="form-control" required>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-4">
                        <label for="bairro">Bairro:</label>
                        <input type="text" id="bairro" name="bairro" class="form-control" required>
                    </div>
                    <div class="col-4">
                        <label for="uf">UF</label>
                        <select name="uf" id="uf" class="form-control form-control" required>
                            <option disabled selected>Escolha um estado</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="cidade">Cidade</label>
                        <select name="cidade" id="cidade" class="form-control form-control" required>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-end my-5">
                    <div class="col-3">
                        <button class="w-100 btn btn-lg btn-danger" type="reset">Cancelar</button>
                    </div>
                    <div class="col-3">
                        <button class="w-100 btn btn-lg btn-success" type="submit">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
        
        <h5>Empresas Cadastradas</h5>
        <div class="col-lg-12 ">
            <div class="card mt-3">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">CNPJ</th>
                            <th scope="col">Nome da empresa</th>
                            <th class="text-center" scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody id="dadosClientes">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    $(document).ready(function($){ 
        //busca estados
        $.ajax({
            url: 'estados',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var dadosSelect = $('#uf');

                var estados = JSON.parse(response).sort(function(a, b) {
                    return a.nome.localeCompare(b.nome);
                });

                $.each(estados, function(index, dados) {
                    dadosSelect.append("<option value=" + dados.sigla +">" + dados.nome + "</option>");
                });
            },
            error: function(xhr, status, error) {
                console.log('Erro: ' + error);
            }
        });

        //busca clientes
        $.ajax({
            url: 'clientes',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var dadosContainer = $('#dadosClientes');
                $.each(response, function(index, dados) {
                    dadosContainer.append(`
                    <tr>
                        <td>${dados.cnpj}</td>
                        <td>${dados.nome_empresa}</td>
                        <td class="text-center">
                            <a class="btn btn-dark btn-sm me-2" href="edit/${dados.id}">Editar</a><br>
                        </td>
                    </tr>
                    `);
                });
            },
            error: function(xhr, status, error) {
                console.log('Erro: ' + error);
            }
        });
    });    

    $('#uf').on('change', function(){ 
        let sigla = $('#uf').val();
        if (sigla !== null) {
            $.ajax({
                url: 'cidades/'+ sigla,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var dadosSelect = $('#cidade');
                    dadosSelect.empty();
                    dadosSelect.append("<option disabled selected>Escolha uma cidade</option>")
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