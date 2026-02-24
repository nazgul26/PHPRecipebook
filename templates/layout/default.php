<?php
use Cake\Routing\Router;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
        <?= env('APP_NAME') ?>:
        <?= $this->fetch('title') ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		// Bootstrap 5 CSS
		echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">';
		// Bootstrap Icons
		echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">';

		echo $this->Html->css('theme');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

        $baseUrl = Router::url('/');
	?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-cookbook sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $baseUrl ?>recipes" onclick="ajaxNavigate('<?= $baseUrl ?>recipes', 'Recipes'); return false;">
                <i class="bi bi-book"></i> <?= env('APP_NAME') ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link ajaxLink" href="<?= $baseUrl ?>recipes"
                           title="<?= __('Browse your recipes') ?>"><?= __('Recipes') ?></a>
                    </li>
                    <?php if ($loggedIn) : ?>
                    <li class="nav-item">
                        <a class="nav-link ajaxLink" href="<?= $baseUrl ?>mealPlans"
                           title="<?= __('Manage your meal plans') ?>"><?= __('Meal Planner') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ajaxLink" href="<?= $baseUrl ?>shoppingLists"
                           title="<?= __('Create or Edit a shopping list') ?>"><?= __('Shopping List') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ajaxLink" href="<?= $baseUrl ?>ingredients"
                           title="<?= __('Ingredients used in recipes') ?>"><?= __('Ingredients') ?></a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link ajaxLink" href="<?= $baseUrl ?>restaurants"
                           title="<?= __('List of your restaurants') ?>"><?= __('Restaurants') ?></a>
                    </li>
                    <?php if ($loggedIn) : ?>
                    <li class="nav-item">
                        <a class="nav-link ajaxLink" href="<?= $baseUrl ?>users"
                           title="<?= __('Administer Users') ?>"><?= __('Users') ?></a>
                    </li>
                    <?php endif; ?>
                </ul>

                <!-- Search -->
                <form id="searchEverythingForm" class="navbar-search me-3" onsubmit="return false;">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="form-control searchTextBox" placeholder="<?= __('Search Recipes') ?>" aria-label="Search" />
                    <button type="button" class="search-clear cancelBtn" aria-label="Clear search">&times;</button>
                </form>

                <!-- Auth -->
                <ul class="navbar-nav navbar-auth">
                    <?php if (!$loggedIn) : ?>
                    <li class="nav-item">
                        <a class="nav-link btn-signin" href="<?= $baseUrl ?>users/login" id="signInButton"
                           title="<?= __('Sign in with your existing account') ?>"><?= __('Sign in') ?></a>
                    </li>
                    <?php if ($allowAccountCreation) :?>
                    <li class="nav-item ms-2">
                        <a class="nav-link" href="<?= $baseUrl ?>users/add"
                           title="<?= __('Create a new account') ?>"><?= __('Create Account') ?></a>
                    </li>
                    <?php endif;?>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link ajaxLink" href="<?= $baseUrl ?>users/edit/<?= $loggedInuserId ?>"
                           title="<?= __('Account settings') ?>">
                            <i class="bi bi-gear"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>users/logout"
                           title="<?= __('Logout') ?>">
                            <i class="bi bi-box-arrow-right"></i> <?= __('Logout') ?>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Toast container -->
    <div class="toast-container-cookbook" id="toastContainer"></div>

    <!-- Mobile filter button -->
    <button class="btn btn-primary sidebar-toggle d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas" aria-label="<?= __('Filter Recipes') ?>">
        <i class="bi bi-funnel"></i>
    </button>

    <!-- Offcanvas sidebar for mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarOffcanvasLabel"><i class="bi bi-book me-2"></i><?= __('Recipe Box') ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="recipeLinkBoxContainerMobile"></div>
    </div>

    <script>
        window.appScriptsReady = false;
        function onAppReady(fn) {
            if (window.appScriptsReady) { fn(); }
            else { document.addEventListener('app:ready', fn, { once: true }); }
        }
    </script>

    <!-- Main Layout -->
    <div class="container-fluid main-layout py-3">
        <div class="row g-3">
            <!-- Sidebar (desktop only) -->
            <div class="col-lg-3 col-xl-2 sidebar-column">
                <div class="sidebar-cookbook" id="recipeLinkBoxContainer"></div>
            </div>

            <!-- Content -->
            <div class="col-lg-9 col-xl-10">
                <div id="content">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal containers -->
    <?php
    $modals = [
        ['id' => 'editTagDialog', 'title' => __('Tag'), 'size' => ''],
        ['id' => 'editIngredientDialog', 'title' => __('Ingredient'), 'size' => 'modal-lg'],
        ['id' => 'editLocationDialog', 'title' => __('Location'), 'size' => ''],
        ['id' => 'editUnitDialog', 'title' => __('Unit'), 'size' => ''],
        ['id' => 'editRestaurantDialog', 'title' => __('Restaurant'), 'size' => 'modal-lg'],
        ['id' => 'editPriceRangesDialog', 'title' => __('Price Ranges'), 'size' => ''],
        ['id' => 'editEthnicityDialog', 'title' => __('Ethnicity'), 'size' => ''],
        ['id' => 'editBaseTypeDialog', 'title' => __('Base Type'), 'size' => ''],
        ['id' => 'editCourseDialog', 'title' => __('Course'), 'size' => ''],
        ['id' => 'editPrepTimeDialog', 'title' => __('Preparation Time'), 'size' => ''],
        ['id' => 'editPrepMethodDialog', 'title' => __('Preparation Method'), 'size' => ''],
        ['id' => 'editDifficultyDialog', 'title' => __('Difficulty'), 'size' => ''],
        ['id' => 'editSourceDialog', 'title' => __('Source'), 'size' => ''],
        ['id' => 'editMealDialog', 'title' => __('Meal'), 'size' => 'modal-lg'],
        ['id' => 'editProductDialog', 'title' => __('Product'), 'size' => ''],
    ];
    foreach ($modals as $modal) : ?>
    <div class="modal fade" id="<?= $modal['id'] ?>" tabindex="-1" aria-labelledby="<?= $modal['id'] ?>Label" aria-hidden="true">
        <div class="modal-dialog <?= $modal['size'] ?> modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?= $modal['id'] ?>Label"><?= $modal['title'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="<?= $modal['id'] ?>Content"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-secondary" data-bs-dismiss="modal"><?= __('Cancel') ?></button>
                    <button type="button" class="btn btn-primary modal-save-btn">
                        <i class="bi bi-check-lg me-1"></i><?= __('Save') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            initApplication();
        });
        
        // Global Variables
        var baseUrl = "<?= $baseUrl ?>";
        var applicationContext = "recipes";
    </script>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <!-- App JS -->
    <?= $this->Html->script('app') ?>
    <script>
        window.appScriptsReady = true;
        document.dispatchEvent(new Event('app:ready'));
    </script>
</body>
</html>
