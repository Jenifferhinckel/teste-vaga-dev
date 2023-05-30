# Rodando o projeto
1.Instale o wamp https://www.wampserver.com/en/download-wampserver-64bits/
2.Após instalado clone o projeto dentro da pasta www do wamp.
3.Com o wamp rodando, acesse o link http://localhost/phpmyadmin/ para poder fazer a importação do banco, com isso basta importar o arquivo "bd-teste.sql" do teste. Obs: o nome do banco tem que permanecer como teste para o funcionamento do sistema ou mude o nome no config.php
4.Após a importação do banco acesse o link http://localhost/teste-vaga-dev/public/ e aproveite o sistema!

# Estrutura
A estrutura geral do sistema seria com MVC, model, view e controller.
Na model fazendo a busca no banco, controller ajustando os dados e na view mostrando os dados.

### public
* Na pasta assets e css contém o que é necessário para rodar o css e javascript do sistema.
* O "htaccess" seria uma configuração do FLIGHTPHP.
* No "config.php" esta as configurações do banco.
* No index.php estão as rotas em FLIGHTPHP.

### src
* Na pasta Controllers contém os arquivos aonde há as funções que tratam as informações.
* Na pasta Models contém o arquivo que busca as informações do banco.

### vendor 
* Há as configurações do FLIGHTPHP.

### views
* Contém os arquivos da parte visual do sistema como o formulário e a listagem de clientes.

# Motivações
Em relação ao projeto quis fazer algo sucinto, funcional e com fácil entendimento.

