<?php

require_once '../src/database/connection.php';
require_once '../src/savedata.php';
require_once '../src/UniqueLinkGenerator.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uniquelink = generatelink();
    $message = savepost($conn, $_POST['titel'], $_POST['inhoud'], $_POST['categorie'], $uniquelink[1]);
}

$ophalen = $conn->prepare("SELECT * FROM categorien");
$ophalen->execute();
$categorien = $ophalen->fetchAll();

?>
<!DOCTYPE html>
<html lang="nl" class="bg-(--color-secondary)">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/output.css">
    <title>Bitbin</title>
    <link rel="icon" type="image/x-icon" href="img/Brand mark.png">
</head>

<body class="font-mukta text-(--color-secondary) bg-(--color-primary)">
    <nav
        class="sticky top-0 z-50 flex h-20 items-center justify-between border-b bg-(--color-primary) border-(--color-secondary)/15 px-14">
        <div class="flex items-center gap-8">
            <a href="index.php" class="flex items-center gap-3">
                <img class="size-8.5" src="img/Brand mark.png" alt="BitBin logo">
                <span class="text-[22px] font-bold">BITBIN</span>
            </a>
            <div class="h-7 w-px bg-(--color-secondary)/15"></div>
            <div class="flex gap-7 text-[15px] text-(--color-secondary)/60">
                <a href="">API</a>
                <a href="">TOOLS</a>
                <a href="">FAQ</a>
            </div>
            <div class="h-7 w-px bg-(--color-secondary)/15"></div>
            <div class="relative">
                <input id="search" placeholder="Search..."
                    class="peer block w-full border-0 border-b-2 border-(--color-secondary)/40 bg-(--color-secondary)/5 p-2.5 text-base outline-none"
                    type="text">
                <label for="search"
                    class="pointer-events-none absolute left-0 top-0 text-base text-transparent transition-all duration-300 ease-in peer-focus:-top-5 peer-focus:text-xs peer-focus:text-[#007bff]"></label>
                <span
                    class="absolute bottom-0 left-0 h-0.5 w-0 bg-[#007bff] transition-all duration-250 ease-in peer-focus:w-full"></span>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <a href="" class="font-semibold text-(--color-accent)">Make new paste</a>

            <input class="peer hidden" type="checkbox" id="checkbox">
            <label for="checkbox"
                class="relative z-50 flex size-10 cursor-pointer flex-col items-center justify-center gap-2.5 duration-500 peer-checked:rotate-180 peer-checked:[&>div]:absolute peer-checked:[&>div]:duration-500 peer-checked:[&>#bar1]:rotate-45 peer-checked:[&>#bar2]:scale-x-0 peer-checked:[&>#bar3]:-rotate-45">
                <div class="h-1 w-full rounded-sm bg-(--color-secondary)" id="bar1"></div>
                <div class="h-1 w-full rounded-sm bg-(--color-secondary) duration-800" id="bar2"></div>
                <div class="h-1 w-full rounded-sm bg-(--color-secondary)" id="bar3"></div>
            </label>

            <label for="checkbox"
                class="pointer-events-none fixed inset-0 top-20 z-30 bg-(--color-secondary)/30 opacity-0 transition-opacity duration-300 peer-checked:pointer-events-auto peer-checked:opacity-100"></label>

            <aside
                class="fixed right-0 top-20 z-40 flex h-[calc(100vh-5rem)] w-80 translate-x-full flex-col overflow-y-auto bg-(--color-primary) p-8 shadow-2xl transition-transform duration-300 peer-checked:translate-x-0">
                <p class="text-xs font-semibold uppercase text-(--color-secondary)/60">Recent Public Pastes</p>
                <div class="mt-6 divide-y divide-(--color-secondary)/15">
                    <a href="" class="block py-4">
                        <p class="font-semibold text-(--color-accent)">Express rate limiter</p>
                        <p class="mt-1 text-xs text-(--color-secondary)/60">TypeScript · 1 minute ago</p>
                    </a>
                    <a href="" class="block py-4">
                        <p class="font-semibold text-(--color-accent)">Python API request</p>
                        <p class="mt-1 text-xs text-(--color-secondary)/60">Python · 4 minutes ago</p>
                    </a>
                    <a href="" class="block py-4">
                        <p class="font-semibold text-(--color-accent)">Responsive navbar</p>
                        <p class="mt-1 text-xs text-(--color-secondary)/60">HTML · 8 minutes ago</p>
                    </a>
                    <a href="" class="block py-4">
                        <p class="font-semibold text-(--color-accent)">Database connection</p>
                        <p class="mt-1 text-xs text-(--color-secondary)/60">PHP · 12 minutes ago</p>
                    </a>
                    <a href="" class="block py-4">
                        <p class="font-semibold text-(--color-accent)">Docker compose setup</p>
                        <p class="mt-1 text-xs text-(--color-secondary)/60">YAML · 19 minutes ago</p>
                    </a>
                    <a href="" class="block py-4">
                        <p class="font-semibold text-(--color-accent)">Array helper functions</p>
                        <p class="mt-1 text-xs text-(--color-secondary)/60">JavaScript · 25 minutes ago</p>
                    </a>
                </div>
            </aside>
        </div>
    </nav>
    <header class="px-14 py-12">
        <section
            class="overflow-hidden rounded-2xl border border-(--color-secondary)/15 shadow-[0_8px_12px_rgba(6,13,12,0.06)]">
            <form method="post" class="grid min-h-139 overflow-hidden lg:grid-cols-[minmax(0,1fr)_392px]">
                <div class="flex min-h-139 max-h-139 flex-col bg-(--color-secondary) text-(--color-primary)">
                    <div class="flex h-13 items-center justify-between border-b border-(--color-primary)/15 px-4">
                        <div class="flex items-center gap-3">
                            <img class="size-4.25" src="img/file-code-2.svg" alt="">
                            <p class="text-[15px] font-semibold">New paste</p>
                            <p class="text-xs text-(--color-primary)/70"># onbewaard</p>
                        </div>
                    </div>

                    <div class="relative flex-1 overflow-hidden py-4">
                        <ol id="line-numbers" class="text-xs leading-5.75 text-(--color-primary)/70"></ol>
                        <textarea id="code-editor" name="inhoud"
                            class="absolute inset-y-4 left-16 right-4 resize-none bg-transparent text-sm leading-5.75 text-(--color-primary) outline-none"
                            aria-label="Plak hier je code" spellcheck="false" wrap="off"></textarea>
                    </div>
                </div>
                <div class="flex flex-col gap-4 bg-(--color-primary) p-6">
                    <div class="flex items-center justify-between border-b border-(--color-secondary)/15 pb-3">
                        <div>
                            <h1 class="text-[26px]">Paste settings</h1>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase text-(--color-secondary)/60">
                            Naam / Titel
                            <span class="relative mt-2 block">
                                <input type="text" name="titel"
                                    class="h-11.5 w-full appearance-none rounded-lg border border-(--color-secondary)/15 bg-transparent px-3 text-[15px] font-medium normal-case text-(--color-secondary)">
                                </input>
                            </span>
                        </label>
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase text-(--color-secondary)/60">
                            Categorie
                            <span class="relative mt-2 block">
                                <select name="categorie"
                                    class="h-11.5 w-full appearance-none rounded-lg border border-(--color-secondary)/15 bg-transparent px-3 text-[15px] font-medium normal-case text-(--color-secondary)">
                                    <option value="1">Selecteer een Categorie</option>
                                    <?php if (!empty($categorien)) : ?>
                                        <?php foreach ($categorien as $category) : ?>
                                            <option value="<?= htmlspecialchars($category['id']) ?>">
                                                <?= htmlspecialchars($category['taal']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </span>
                        </label>
                        <img class="pointer-events-none absolute right-3 top-4 size-3.75" src="img/chevron-dark.svg"
                            alt="">
                        </span>
                        </label>
                    </div>

                    <div class="">
                        <label class="text-xs font-semibold uppercase text-(--color-secondary)/60">
                            Syntax Highlighting
                            <span class="relative mt-2 block">
                                <select
                                    class="h-11.5 w-full appearance-none rounded-lg border border-(--color-secondary)/15 bg-transparent px-3 text-[15px] font-medium normal-case text-(--color-secondary)">
                                    <option value=""></option>
                                </select>
                                <img class="pointer-events-none absolute right-3 top-4 size-3.75"
                                    src="img/chevron-dark.svg" alt="">
                            </span>
                        </label>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-(--color-secondary)/15 pt-3">
                        <label class="text-xs font-semibold uppercase text-(--color-secondary)/60">
                            Wachtwoord
                            <span class="relative mt-2 block">
                                <input type="password"
                                    class="h-11.5 w-full appearance-none rounded-lg border border-(--color-secondary)/15 bg-transparent px-3 text-[15px] font-medium normal-case text-(--color-secondary)"
                                    placeholder="Optioneel">
                                </input>
                            </span>
                        </label>
                    </div>

                    <div class="border-t border-(--color-secondary)/15 pt-3">
                        <button
                            class="flex h-12 w-full items-center justify-center gap-2 rounded-lg bg-(--color-accent) text-[15px] font-semibold text-(--color-primary) shadow-[0_8px_18px_rgba(0,112,255,0.2)]"
                            type="submit">
                            Paste
                            <img class="size-4" src="img/arrow-up-right.svg" alt="">
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </header>
    <main class="px-14 pb-12">
        <section class="mt-6 rounded-2xl border border-(--color-secondary)/15 p-8">
            <div class="mb-6 flex items-end justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-(--color-secondary)/60">Your activity</p>
                    <h2 class="mt-1 text-2xl font-semibold">Your BitBin library</h2>
                </div>
                <a href="" class="text-sm font-semibold text-(--color-accent)">View all</a>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <article class="rounded-xl border border-(--color-secondary)/15 p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">Likes</h3>
                        <span class="rounded-full bg-(--color-secondary)/10 px-2.5 py-1 text-xs">1</span>
                    </div>
                    <div class="mt-4 divide-y divide-(--color-secondary)/15 text-sm">
                        <a href="" class="block py-3"><span class="block font-medium">...</span><span
                                class="text-xs text-(--color-secondary)/60">...</span></a>
                        <a href="" class="block py-3"><span class="block font-medium">...</span><span
                                class="text-xs text-(--color-secondary)/60">...</span></a>
                    </div>
                </article>
                <article class="rounded-xl border border-(--color-secondary)/15 p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">Saves</h3>
                        <span class="rounded-full bg-(--color-secondary)/10 px-2.5 py-1 text-xs">1</span>
                    </div>
                    <div class="mt-4 divide-y divide-(--color-secondary)/15 text-sm">
                        <a href="" class="block py-3"><span class="block font-medium">...</span><span
                                class="text-xs text-(--color-secondary)/60">...</span></a>
                        <a href="" class="block py-3"><span class="block font-medium">...</span><span
                                class="text-xs text-(--color-secondary)/60">...</span></a>
                    </div>
                </article>
                <article class="rounded-xl bg-(--color-secondary) p-5 text-(--color-primary)">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">Recent pastes</h3>
                        <span class="rounded-full bg-(--color-primary)/10 px-2.5 py-1 text-xs">1</span>
                    </div>
                    <div class="mt-4 divide-y divide-(--color-primary)/15 text-sm">
                        <a href="" class="block py-3"><span class="block font-medium">...</span><span
                                class="text-xs text-(--color-primary)/60">...</span></a>
                        <a href="" class="block py-3"><span class="block font-medium">...</span><span
                                class="text-xs text-(--color-primary)/60">...</span></a>
                    </div>
                </article>
            </div>
        </section>
    </main>
    <footer class="flex h-20 items-center justify-between bg-(--color-secondary) px-14 text-(--color-primary)">
        <a href="index.php">
            <p class="">BitBin</p>
        </a>
        <button type="button" aria-label="Back to top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="group relative flex size-11.25 cursor-pointer items-center justify-center rounded-full border border-(--color-accent) bg-(--color-secondary)">
            <svg class="h-[1.2em] fill-white group-hover:invisible" viewBox="0 0 512 512" aria-hidden="true">
                <path
                    d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z">
                </path>
            </svg>
            <svg class="absolute h-[1.2em] translate-y-2.5 fill-white opacity-0 transition-[transform,opacity] duration-700 ease-[cubic-bezier(0.250,0.460,0.450,0.940)] group-hover:translate-y-0 group-hover:opacity-100"
                viewBox="0 0 512 512" aria-hidden="true">
                <path
                    d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z">
                </path>
            </svg>
            <p
                class="absolute -bottom-4.5 flex w-25 items-center justify-center text-[0.7em] text-white opacity-0 duration-700 group-hover:opacity-100">
                Back to Top</p>
        </button>
    </footer>
    <script src="../src/js/editor.js"></script>
</body>

</html>