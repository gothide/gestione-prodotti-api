<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Prodotti</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Elenco Prodotti</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Prezzo</th>
                <th>Quantità in magazzino</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
    <?php if (!empty($prodotti)) : ?>
        <?php foreach ($prodotti as $prodotto): ?>
            <tr>
                <td><?= $prodotto['id'] ?></td>
                <td><?= $prodotto['nome'] ?></td>
                <td><?= $prodotto['prezzo'] ?></td>
                <td><?= $prodotto['quantità_in_magazzino'] ?></td>
                <td>
                    <form action="/prodotti/<?= $prodotto['id'] ?>" method="POST" style="display: inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Elimina</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="5">Nessun prodotto trovato.</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table>

    <h2>Aggiungi Prodotto</h2>
    <form action="/prodotti" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <label for="prezzo">Prezzo:</label>
        <input type="text" id="prezzo" name="prezzo">
        <label for="quantita">Quantità:</label>
        <input type="text" id="quantita" name="quantita">
        <button type="submit">Aggiungi</button>
    </form>

</body>
</html>
