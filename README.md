Uma API JWT feita em PHP e JS.

INSTRUÇÕES DE INSTALAÇÃO E USO!
1 - No seu banco de dados rode o script jwt.sql 
    1.1 - Esse scrip é responsável por gerar o banco de dados e o popular com as tabelas necessárias.
2 - Vá em api/config/Database.php e altere os atributos password e user de acordo com o seu sistema.
    2.2 - Essas configurações são necessárias para se criar uma conexão com o DB.
3 - O endpoint para listar as categorias cadastradas é caminho_do_server/jwt/api/retrieve_categorias.php.
4 - Aponte seu navegador para caminho_do_server/jwt/api/pages/
5 - Cadastre um usuário clicando em Cadastr-se e após isso é necessário fazer o login.
6 - Com o login feito é possível verificar todas as categorias na lista. Escolha uma.
7 - A atualização no banco de dados é faita automaticamente quando se escolhe uma categoria.
