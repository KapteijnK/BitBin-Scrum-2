<?php

require_once '../src/database/connection.php';

$id = '%' . $_GET['code'];
if (strlen($id) < 2) {
    header('Location: to-home.php');
    die();
}
$query = $conn->prepare("SELECT * FROM posts WHERE link LIKE :id");
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$query->setFetchMode(PDO::FETCH_ASSOC);
$code = $query->fetch();

?>
<!DOCTYPE html>
<html lang="nl" class="bg-(--color-secondary)">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/output.css">
    <title>Bitbin</title>
    <link rel="icon" type="image/x-icon" href="img/Brand mark.png">
    <script src="../src/js/favorites.js"></script>
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
            class="grid min-h-139 overflow-hidden rounded-2xl border border-(--color-secondary)/15 shadow-[0_8px_12px_rgba(6,13,12,0.06)]">
            <form class="flex min-h-139 max-h-139 flex-col bg-(--color-secondary) text-(--color-primary)">
                <div class="flex h-13 items-center justify-between border-b border-(--color-primary)/15 px-4">
                    <div class="flex items-center gap-3">
                        <img class="size-4.25" src="img/file-code-2.svg" alt="">
                        <p id="titel" class="text-[15px] font-semibold" data-paste-title><?= $code['titel'] ?></p>
                        <p class="text-xs text-(--color-primary)/70"><?php echo date("m-d-Y", strtotime($code['gepost_op'])) ?></p>
                    </div>
                </div>

                <div class="relative flex-1 overflow-hidden py-4">
                    <ol id="line-numbers" class="text-xs leading-5.75 text-(--color-primary)/70"></ol>
                    <textarea id="code-editor"
                        class="absolute inset-y-4 left-16 right-4 resize-none bg-transparent text-sm leading-5.75 text-(--color-primary) outline-none"
                        aria-label="Code bekijken" spellcheck="false" wrap="off" readonly><?= $code['inhoud'] ?></textarea>
                </div>
            </form>
        </section>
        <div class="flex mt-5 gap-5">
            <div class="flex">
                <label class="">
                    <input type="checkbox" class="peer hidden" />
                    <div
                        class="group flex w-fit cursor-pointer items-center gap-2 overflow-hidden rounded-full border border-gray-950 fill-none p-2 px-3 font-extrabold text-gray-950 transition-all active:scale-90 peer-checked:fill-gray-950 peer-checked:hover:text-(--color-primary)">
                        <div class="z-10 transition group-hover:translate-x-4">SAVE</div>
                        <svg class="size-6 transition group-hover:-translate-x-6 group-hover:-translate-y-3 group-hover:scale-[750%] duration-500"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z">
                            </path>
                        </svg>
                    </div>
                </label>

            </div>
            <div class="flex">
                <label class="">
                    <input type="checkbox" class="peer hidden" />
                    <div
                        class="group flex w-fit cursor-pointer items-center gap-2 overflow-hidden rounded-full border border-(--color-accent) fill-none p-2 px-3 font-extrabold text-(--color-accent) transition-all peer-checked:fill-(--color-accent) peer-checked:hover:text-(--color-primary) active:scale-90">
                        <div class="z-10 transition group-hover:translate-x-4" onclick="addfavorite()">FAVORITE</div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="size-6 transition duration-500 group-hover:scale-[1500%] group-hover:-translate-x-10">
                            <path
                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
                                stroke-linejoin="round" stroke-linecap="round"></path>
                        </svg>
                    </div>
                </label>

            </div>
        </div>
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
                        <h3 class="font-semibold">Favorites</h3>
                        <span id="likes-list-count"
                            class="rounded-full bg-(--color-secondary)/10 px-2.5 py-1 text-xs">0</span>
                    </div>
                    <div id="likes-list" class="mt-4 divide-y divide-(--color-secondary)/15 text-sm">
                    </div>
                </article>
                <article class="rounded-xl border border-(--color-secondary)/15 p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">Saves</h3>
                        <span id="favorites-list-count"
                            class="rounded-full bg-(--color-secondary)/10 px-2.5 py-1 text-xs">0</span>
                    </div>
                    <div id="favorites-list" class="mt-4 divide-y divide-(--color-secondary)/15 text-sm"></div>
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