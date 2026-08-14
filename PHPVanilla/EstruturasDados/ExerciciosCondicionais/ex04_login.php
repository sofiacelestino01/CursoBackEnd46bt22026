<?php

declare(strict_types=1);

$cargoUsuario = "Gerente";
$senhaDigitada = "SenhaSegura123";

$senhaSistema = "SenhaSegura123";

if (
    $senhaDigitada === $senhaSistema &&
    ($cargoUsuario === "Diretor" || $cargoUsuario === "Gerente")
) {
    echo "Acesso Liberado";
} else {
    echo "Acesso Negado";
}