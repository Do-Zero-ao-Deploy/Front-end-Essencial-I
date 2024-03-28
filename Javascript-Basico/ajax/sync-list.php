<?php
if (!isset($_SESSION)) {
    session_start();
}

$redirectTo = $_SERVER['PHP_SELF'] ?? null;
$pessoas = (array) ($_SESSION['pessoas'] ?? []);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sync-list.php</title>
</head>
<body>
    <div>
        <form action="sync-put-session.php">
            <input type="hidden" name="redirect_to" value="<?= $redirectTo ?>">
            <input type="hidden" name="_key" value="pessoas">
            <input type="hidden" name="_type" value="push">

            <div><input type="text" name="name" placeholder="Name" required></div>
            <div>
                <select name="city">
                    <option value="Porto Velho">Porto Velho</option>
                    <option value="Curitiba">Curitiba</option>
                    <option value="Manaus">Manaus</option>
                    <option value="Comodoro">Comodoro</option>
                </select>
            </div>

            <div><button type="submit">Cadastrar</button></div>
        </form>
    </div>
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pessoas as $uid => $pessoa): ?>
                <tr>
                    <td><?= $uid ?></td>
                    <td><?= $pessoa['name'] ?? null ?></td>
                    <td><?= $pessoa['city'] ?? null ?></td>
                    <td>
                        <a
                            href="sync-put-session.php?_key=pessoas&_type=removeItem&redirect_to=<?= $redirectTo ?>&_uid=<?= $uid ?>">Remover</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>
