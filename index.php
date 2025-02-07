<?php
/**
 * Obtiene información de un Pokémon desde la PokéAPI.
 * @param string $pokemon Nombre o número del Pokémon.
 * @return array|null Retorna un array con los datos o null si hay error.
 */
function obtenerPokemon($pokemon) {
    $url = "https://pokeapi.co/api/v2/pokemon/" . strtolower($pokemon);
    $json = @file_get_contents($url); // @ evita mostrar errores en caso de fallo
    if ($json === FALSE) {
        return null;
    }
    return json_decode($json, true);
}

$pokemon = isset($_GET['pokemon']) ? $_GET['pokemon'] : '1';
$datos = obtenerPokemon($pokemon);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéAPI - Información de Pokémon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
        }
        img {
            width: 150px;
        }
        input {
            padding: 8px;
            font-size: 16px;
        }
        button {
            padding: 8px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Información de Pokémon</h1>
    <form method="GET">
        <input type="text" name="pokemon" placeholder="Nombre o número" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($datos): ?>
        <h2><?php echo ucfirst($datos['name']); ?></h2>
        <img src="<?php echo $datos['sprites']['front_default']; ?>" alt="Imagen de Pokémon">
        <p><strong>ID:</strong> <?php echo $datos['id']; ?></p>
        <p><strong>Altura:</strong> <?php echo $datos['height'] / 10; ?> m</p>
        <p><strong>Peso:</strong> <?php echo $datos['weight'] / 10; ?> kg</p>
        <p><strong>Tipos:</strong> 
            <?php foreach ($datos['types'] as $tipo) {
                echo ucfirst($tipo['type']['name']) . "; ";
            } ?>
        </p>
    <?php else: ?>
        <p style="color: red;">Pokémon no encontrado. Intenta con otro nombre o número.</p>
    <?php endif; ?>
</div>

</body>
</html>
