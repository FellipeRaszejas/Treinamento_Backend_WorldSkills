<form method="GET">
    Digite a url que deseja encurtar:
    <input type="text" name="url" placeholder="https://example.com" required>
    <button type="submit">Encurtar</button>
</form>

<?php
//Ideia: Usuário digita uma url e o sistema encurta a url.
//Por lógica guardar o valor do link da url em uma variavel, ao pesquisar descobri que se utiliza o $_GET para capturar o valor digita pelo usuário

//ERRO: Verificação se foi enviado URL
if (isset($_GET['url'])) {

    $URLdoUsuario = $_GET['url'];
    //receber url do sistema
    $DominioDoSistema = "http://localhost:8000/";
    //22 para receber local host, e deve receber alteração caso eu tenha um dominio publicado online, um encurtador real

    $NovoPosBarra = substr(hash('sha256', $URLdoUsuario), 0, 6);

    $NewUrl = ($DominioDoSistema . $NovoPosBarra);
    echo "Sua url encurtada é: " . $NewUrl;
}



?>