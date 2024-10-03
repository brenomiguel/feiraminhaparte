<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Projetos</title>
</head>
<body>
    <select id="cursoSelect" onchange="carregarProjetos()">
        <option value="">Selecione um curso</option>
        <option value="ADM">ADMINISTRAÇÃO</option>
        <option value="TI">TECNOLOGIA DA INTERNET</option>
        <option value="RH">RECURSOS HUMANOS</option>
        <option value="Q">QUÍMICA</option>
    </select>
    <div id="projetos"></div>

    <script>
    async function carregarProjetos() {
        const curso = document.getElementById('cursoSelect').value;
        const projetosDiv = document.getElementById('projetos');
        
        console.log(`Curso selecionado: ${curso}`);

        if (!curso) {
            projetosDiv.innerHTML = '<p>Selecione um curso para ver os projetos.</p>';
            return;
        }

        projetosDiv.innerHTML = '<p>Carregando...</p>'; 

        try {
            const response = await fetch(`application/api.php?curso=${curso}`);
            
            if (!response.ok) {
                throw new Error('Erro ao buscar os projetos');
            }

            const projetos = await response.json();
            console.log(projetos);
            let output = '<ul>';

            if (projetos.length === 0) {
                output += '<li>Nenhum projeto encontrado.</li>';
            } else {
                projetos.forEach(projeto => {
                    output += `
                        <li>
                            <strong>ID Stand:</strong> ${projeto.id_stand}<br>
                            <strong>Nome:</strong> ${projeto.nome}<br>
                            <strong>ODS:</strong> ${projeto.ods}<br>
                            <strong>Descrição:</strong> ${projeto.descricao}<br>
                            <strong>Integrantes:</strong> ${projeto.integrantes}<br>
                            <strong>Turma:</strong> ${projeto.turma}<br>
                            <strong>Local:</strong> ${projeto.local}<br>
                            <strong>Logo:</strong> <img src="${projeto.logo}" alt="Logo" style="max-width: 100px;"><br>
                        </li>
                        <hr>
                    `;
                });
            }

            output += '</ul>';
            projetosDiv.innerHTML = output;
        } catch (error) {
            projetosDiv.innerHTML = `<p>${error.message}</p>`;
        }
    }
</script>

</body>
</html>
