<?php
include('conexao.php');

?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="styles.css">

</head>
<body>
<div class="container"> 
    <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
            Filtro
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li class="dropdown-submenu">
                <a class="test" tabindex="-1" href="#">Local<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a tabindex='-1' href='#' class='local-item' data-local='quadra'>Quadra</a></li>
                    <li><a tabindex='-1' href='#' class='biblioteca-item' data-local='biblioteca'>Biblioteca</a></li>
                    <li><a tabindex='-1' href='#' class='blocoa-item' data-local='blocoa'>Bloco A</a></li>
                    <li><a tabindex='-1' href='#' class='blocob-item' data-local='blocob'>Bloco B</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <br><br><br>

    <div id="informacoes-container"></div> <!-- Container para as caixas de informações -->
</div>

<script>
document.querySelectorAll('.local-item, .biblioteca-item, .blocoa-item, .blocob-item').forEach(item => {
    item.addEventListener('click', function(event) {
        event.preventDefault();
        const local = this.getAttribute('data-local'); // Captura o local clicado

        // Limpa o container antes de adicionar novas informações
        document.getElementById('informacoes-container').innerHTML = '';

        fetch(`get_info.php?local=${local}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error); // Exibe erro no console
                } else {
                    // Itera sobre os dados retornados e cria uma nova div para cada um
                    data.forEach(item => {
                        const infoDiv = document.createElement('div');
                        infoDiv.style.borderRadius = '15px';
                        infoDiv.style.border = '1px solid #ccc';
                        infoDiv.style.padding = '20px';
                        infoDiv.style.backgroundColor = '#f9f9f9';
                        infoDiv.style.maxWidth = '400px';
                        infoDiv.style.fontFamily = 'Arial, sans-serif';
                        infoDiv.innerHTML = `
                            <h2 style="text-align: center;">🌟 Informações do Stand 🌟</h2>
                            <p><strong>ID do Stand:</strong> ${item.id_stand || '-'}</p>
                            <p><strong>Nome:</strong> ${item.nome || '-'}</p>
                            <p><strong>ODS:</strong> ${item.ods || '-'}</p>
                            <p><strong>Descrição:</strong> ${item.descricao || '-'}</p>
                            <p><strong>Integrantes:</strong> ${item.integrantes || '-'}</p>
                            <p><strong>Turma:</strong> ${item.turma || '-'}</p>
                            <p><strong>Local:</strong> ${item.local || '-'}</p>
                            <p><strong>Logo:</strong> <img src="${item.url_logo || ''}" alt="Logo" style="max-width: 100%; border-radius: 10px;"></p>
                            <p><strong>Votos:</strong> ${item.votos || '-'}</p>
                        `;

                        // Adiciona a nova div ao container
                        document.getElementById('informacoes-container').appendChild(infoDiv);
                    });
                }
            })
            .catch(error => console.error('Erro:', error));
    });
});

$(document).ready(function(){
    $('.dropdown-submenu a.test').on("click", function(e){
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
});
</script>


</body>
</html>
