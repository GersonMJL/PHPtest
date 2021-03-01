<?php

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Buscar Endereço</title>
</head>

<body>

    <main class="d-flex flex-column justify-content-center align-items-center">
        <div class="search-div w-25 rounded py-5 px-4">
            <label for="input" class="form-label text-white">Insira o CEP abaixo :)</label>
            <input required type="text" name="input" class="form-control mb-3" placeholder="12345678" id="input">
            <button class="btn" id="submit" onclick="makeRequest(event)" data-bs-toggle="modal" data-bs-target="#modalResultado">Procurar</button>
        </div>
    </main>

    <div class="modal fade text-center" id="modalResultado" tabindex="-1" aria-labelledby="modalResultadoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title" id="modalResultadoLabel">Resultado da procura!</h5>
                </div>
                <div class="modal-body">
                    <div class="row" id="result">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script>
        var button = document.getElementById("submit");
        button.addEventListener("click", function(e) {
            e.preventDefault();
        })

        function makeRequest() {
            var xhr = new XMLHttpRequest();
            var cep = document.getElementById("input").value;
            var url = './action.php?value=' + cep;
            var result = document.getElementById('result');
            var clearResult = function() {
                result.innerHTML = '';
            };
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    result.innerHTML = xhr.responseText;
                } else {
                    result.innerText = "";
                }
            };
            xhr.open('GET', url, true);
            xhr.send();
        };
    </script>
</body>

</html>