<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <p class="mb-6">
            <a href="/notes" class="text-blue-500 underline">go back...</a>
        </p>

        <p><?= htmlspecialchars($note['body']) ?></p>

        <a 
            class="inline-flex justify-center rounded-md border border-transparent bg-orange-500  py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
            href="/note/edit/<?= $note['id'] ?>"
        >
            Edit
        </a>
        <button 
            class="inline-flex justify-center rounded-md border border-transparent bg-red-500  py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            onclick="document.getElementById('form').submit();"
        >
            Delete
        </button>

        <form class="mt-6" method="POST" id="form">
            <input type="hidden" name="_method" value="DELETE">
        </form>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>
