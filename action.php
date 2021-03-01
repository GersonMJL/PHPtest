<?php

$cep = (string) $_GET['value'];

$cep = preg_replace('/\D/', '', $cep);

if (strlen($cep) > 8 or strlen($cep) < 8) {
    die("Esse CEP não existe, tente novamente");
}

$url = "https://viacep.com.br/ws/" . $cep . "/xml";

try {
    $connect = new PDO(
        'mysql:host=localhost;dbname=consultas_cep;charset=utf8mb4',
        'root',
        '',
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => false
        )
    );
} catch (PDOException $ex) {
    die("Ocorreu um erro interno, tente novamente mais tarde");
}

$stmt = $connect->prepare('SELECT * FROM enderecos WHERE cep= ?');

$stmt->bindValue(1, $cep);

$stmt->execute();

$response = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$response) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $getXML = curl_exec($ch);
    $xml = new SimpleXMLElement($getXML);

    $values = array();

    foreach ($xml as $key => $value) {
        $valueString = (string) $value;
        if($valueString === "true"){
            die("CEP inválido, verifique se digitou corretamente");
        }
        array_push($values, $valueString);
    }

    $stmt2 = $connect->prepare('INSERT INTO enderecos(cep, logradouro, complemento, bairro, localidade, uf, ibge, gia, ddd, siafi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    for ($i = 0; $i < 10; $i++) {
        $stmt2->bindValue(($i + 1), $values[$i]);
    }

    $stmt2->bindValue(1, $cep);

    $stmt2->execute();

    curl_close($ch);
} else {
    foreach ($response as $key => $value) {
        echo "
        <div class='col-12 rounded bg-dark text-white my-4 p-4'>
        <h5 class='fw-bold text-uppercase'>" . $key . "</h5>
        " . $value . "
        </div>
        ";
    }
}
