<?php
session_start();
require_once '../src/database/connection.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wachtwoord = $_POST['wachtwoord'];

    $query = $conn->prepare("SELECT wachtwoord FROM admin LIMIT 1");
    $query->execute();
    $admin = $query->fetch();

    if ($admin && password_verify($wachtwoord, $admin['wachtwoord'])) {
        $_SESSION['admin'] = true;

        header("Location: admin.php");
        exit();
    } else {
        $error = "Het opgegeven wachtwoord is onjuist!";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/output.css">
    <title>BitBin | Verify</title>
    <link rel="icon" type="image/x-icon" href="img/Brand mark.png">
</head>

<body class="flex min-h-screen items-center justify-center bg-(--color-primary) px-5 py-10 font-mukta text-(--color-secondary)">
    <main class="w-full max-w-md">
        <a href="index.php" class="mb-8 flex items-center justify-center gap-3">
            <img class="size-9" src="img/Brand mark.png" alt="BitBin logo">
            <span class="text-2xl font-bold tracking-wide">BITBIN</span>
        </a>

        <section class="rounded-2xl border border-(--color-secondary)/15 bg-(--color-primary) p-8 shadow-[0_16px_48px_rgba(6,13,12,0.10)] sm:p-10">
            <div class="mb-8 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-(--color-accent)">Beveiligde toegang</p>
                <h1 class="mt-2 text-3xl font-bold">Verifier Admin</h1>
            </div>

            <form method="post" class="space-y-5">
                <label for="wachtwoord" class="block text-sm font-semibold">
                    Wachtwoord
                    <input
                        id="wachtwoord"
                        type="password"
                        name="wachtwoord"
                        placeholder="Admin wachtwoord"
                        autocomplete="current-password"
                        required
                        class="mt-2 h-12 w-full rounded-lg border border-(--color-secondary)/15 bg-transparent px-4 text-base font-normal outline-none transition placeholder:text-(--color-secondary)/40 focus:border-(--color-accent) focus:ring-2 focus:ring-(--color-accent)/20">
                </label>

                <button
                    type="submit"
                    class="flex h-12 w-full items-center justify-center rounded-lg bg-(--color-accent) px-4 text-base font-semibold text-(--color-primary) shadow-[0_8px_18px_rgba(0,112,255,0.2)] transition hover:brightness-105 active:scale-[0.99]">
                    Inloggen
                </button>
            </form>

            <?php if (!empty($error)) : ?>
                <p role="alert" class="mt-5 rounded-lg border border-red-500/20 bg-red-500/5 px-4 py-3 text-sm text-red-600">
                    <?php echo htmlspecialchars($error); ?>
                </p>
            <?php endif; ?>
        </section>
    </main>

</body>

</html>