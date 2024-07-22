<?php
// Get the full path of the current script file
$current_script = $_SERVER['SCRIPT_FILENAME'];

// Check if we are in index.php
if (basename($current_script) === 'index.php') {
    include('../inc/connect.php');
} 
// Check if we are in Boutique.php
elseif (basename($current_script) === 'Boutique.php') {
    include('inc/connect.php');
}
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}else {
    $user = $_SESSION['user'];

}
$logo = (basename($current_script) === 'Boutique.php') ? "src/images/brand2.png" : "../src/images/brand2.png";
$pro = (basename($current_script) === 'Boutique.php') ? "src/images/profils/" : "../src/images/profils/";
$pageprofil =(basename($current_script) === 'Boutique.php') ? "User/index.php" : "index.php";
$pageBoutique =(basename($current_script) === 'Boutique.php') ? "Boutique.php" : "../Boutique.php";
$pageCommande =(basename($current_script) === 'Boutique.php') ? "User/user-commande.php" : "user-commande.php";
$pageDec =(basename($current_script) === 'Boutique.php') ? "User/index.php?action=logout" : "index.php?action=logout";

// Vérifier si l'utilisateur a cliqué sur le lien de déconnexion
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Détruire la session
    session_destroy();

    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}
?>
<style>
    .navbar-brand {
        margin-right: 15px;
        /* Adjust as needed */
    }


    @media (max-width: 991.98px) {
        .dropdown-menu {
            right: auto !important;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
    <div class="container-fluid">
        <!-- Logo / Brand -->
        <a class="navbar-brand" href="#">
            <img src="<?= $logo ?>" height="40" alt="Logo de RidaSolutions" loading="lazy" />
        </a>

        <!-- Navbar Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $pageprofil?>">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $pageBoutique?>">Boutique</a>
                </li>
             <!--    <li class="nav-item">
                    <a class="nav-link" href="user-blog.php">blog</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= $pageCommande?>">Commande</a>
                </li>


            </ul>
     <!-- Right-aligned items -->
     <div class="d-flex align-items-center ms-auto">
    <!-- Profile Dropdown -->
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= $pro . $user['profil_user']; ?>" class="rounded-circle" height="25" alt="Profile Picture" loading="lazy" />
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
            <li>
                <a class="dropdown-item" href="<?= $pageDec ?>">Déconnexion</a>
            </li>
        </ul>
    </div>
</div>

        </div>
    </div>
</nav>