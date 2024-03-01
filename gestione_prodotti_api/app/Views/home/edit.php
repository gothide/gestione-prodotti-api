<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Prodotto</title>
</head>
<body>
    <h1>Modifica Prodotto</h1>
    <form action="<?= base_url('prodotti/update/' . $prodotto['id']) ?>" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= $prodotto['nome'] ?>" required>
        <label for="prezzo">Prezzo:</label>
        <input type="text" id="prezzo" name="prezzo" value="<?= $prodotto['prezzo'] ?>" required>
        <label for="quantita">Quantità:</label>
        <input type="text" id="quantità_in_magazzino" name="quantità_in_magazzino" value="<?= $prodotto['quantità_in_magazzino'] ?>" required>
        <button type="submit">Salva Modifiche</button>
    </form>
</body>
</html>
