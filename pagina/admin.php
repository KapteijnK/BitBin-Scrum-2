    <?php

    session_start();
    require_once '../src/database/connection.php';

    if (!isset($_SESSION['admin'])) {
        header("Location: verify.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wipe_posts'])) {

        $import = '../src/sql/import.sql';

        if (file_exists($import)) {

            $sql = file_get_contents($import);

            $conn->exec($sql);

            $succes = "Posts zijn succesvol gewiped!";
        } else {
            $fout = "Het bestand 'import.sql' kon niet gevonden worden!";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verwijder_post'])) {
        $postId = $_POST['verwijder_post'];

        $query = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $query->execute([$postId]);

        $succes = "Post $postId is succesvol verwijderd!";
    }

    $query = $conn->query("SELECT * FROM posts ORDER BY id desc");
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <!DOCTYPE html>
    <html lang="nl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../src/css/output.css">
        <title>BitBin | Admin</title>
        <link rel="icon" type="image/x-icon" href="img/Brand mark.png">
    </head>

    <body class="min-h-screen bg-(--color-primary) font-mukta text-(--color-secondary)">
        <header class="border-b border-(--color-secondary)/15">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-8">
                <a href="index.php" class="flex items-center gap-3">
                    <img class="size-9" src="img/Brand mark.png" alt="BitBin logo">
                    <span class="text-2xl font-bold tracking-wide">BITBIN</span>
                </a>
                <a href="to-home.php" class="rounded-full border border-(--color-secondary)/15 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-(--color-secondary)/60 transition duration-200 hover:scale-105 hover:border-(--color-accent) hover:text-(--color-accent) hover:ring-2 hover:ring-(--color-accent)/30">Home</a>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-5 py-10 sm:px-8 sm:py-14">
            <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-(--color-accent)">BitBin beheer</p>
                    <h1 class="mt-2 text-3xl font-bold sm:text-4xl">Admin dashboard</h1>
                    <p class="mt-2 text-sm text-(--color-secondary)/60">Beheer en verwijder opgeslagen posts.</p>
                </div>
                <form action="" method="POST">
                    <input type="hidden" name="wipe_posts" value="1">
                    <button type="submit" onclick="return confirm('Deze actie zal alle huidige posts verwijderen!')"
                        class="h-11 rounded-lg border border-red-500/30 px-5 text-sm font-semibold text-red-600 transition hover:bg-red-500/5 active:scale-[0.99]">
                        Wipe posts
                    </button>
                </form>
            </div>

            <?php if (isset($succes)): ?>
                <p role="status" class="mb-5 rounded-lg border border-green-600/20 bg-green-600/5 px-4 py-3 text-sm text-green-700"><?php echo htmlspecialchars($succes); ?></p>
            <?php endif; ?>
            <?php if (isset($fout)): ?>
                <p role="alert" class="mb-5 rounded-lg border border-red-500/20 bg-red-500/5 px-4 py-3 text-sm text-red-600"><?php echo htmlspecialchars($fout); ?></p>
            <?php endif; ?>

            <section class="overflow-hidden rounded-2xl border border-(--color-secondary)/15 shadow-[0_16px_48px_rgba(6,13,12,0.06)]">
                <div class="flex items-center justify-between border-b border-(--color-secondary)/15 px-5 py-4 sm:px-6">
                    <div>
                        <h2 class="font-semibold">Posts</h2>
                        <p class="mt-1 text-xs text-(--color-secondary)/60"><?php echo count($posts); ?> opgeslagen</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] text-left text-sm">
                        <thead class="bg-(--color-secondary)/5 text-xs uppercase tracking-wider text-(--color-secondary)/60">
                            <tr>
                                <th class="px-5 py-3 font-semibold">ID</th>
                                <th class="px-5 py-3 font-semibold">Titel</th>
                                <th class="px-5 py-3 font-semibold">Inhoud</th>
                                <th class="px-5 py-3 font-semibold">Categorie ID</th>
                                <th class="px-5 py-3 font-semibold">Link</th>
                                <th class="px-5 py-3 font-semibold">Gepost</th>
                                <th class="px-5 py-3 text-right font-semibold">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-(--color-secondary)/10">
                            <?php if (count($posts) > 0): ?>
                                <?php foreach ($posts as $post): ?>
                                    <tr class="transition hover:bg-(--color-secondary)/[0.025]">
                                        <td class="whitespace-nowrap px-5 py-4 font-medium"><?php echo htmlspecialchars($post['id']); ?></td>
                                        <td class="max-w-48 px-5 py-4 font-semibold"><?php echo htmlspecialchars($post['titel']); ?></td>
                                        <td class="max-w-72 px-5 py-4 text-(--color-secondary)/65">
                                            <p class="line-clamp-2 whitespace-pre-wrap"><?php echo htmlspecialchars($post['inhoud']); ?></p>
                                        </td>
                                        <td class="px-5 py-4 text-(--color-secondary)/65"><?php echo htmlspecialchars($post['categorie_id']); ?></td>
                                        <td class="px-5 py-4"><a class="font-semibold text-(--color-accent) hover:underline" href="<?php echo htmlspecialchars($post['link']); ?>" target="_blank">Open link</a></td>
                                        <td class="whitespace-nowrap px-5 py-4 text-xs text-(--color-secondary)/60"><?php echo htmlspecialchars($post['gepost_op']); ?></td>
                                        <td class="px-5 py-4 text-right">
                                            <form action="" method="POST" onsubmit="return confirm('Weet je zeker dat je deze post wilt verwijderen?');">
                                                <input type="hidden" name="verwijder_post" value="<?php echo htmlspecialchars($post['id']); ?>">
                                                <button type="submit" class="rounded-lg border border-red-500/25 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-500/5">Verwijder</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-5 py-12 text-center text-sm text-(--color-secondary)/60">Geen posts gevonden.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </body>

    </html>