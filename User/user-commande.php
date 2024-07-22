<?php
session_start();
include('../inc/connect.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: index.php");
    exit;
} else {
    $user = $_SESSION['user'];
}

// Définir le titre de la page
$title = "commande";
include 'inc-user/debut-user.php';
include 'inc-user/header-user.php';

// Récupérer les articles de blog depuis la base de données
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10; // Number of commands per page

// Calculate offset for the SQL query
$offset = ($page - 1) * $limit;

// Récupérer le nombre total de commandes
$queryTotal = "SELECT COUNT(*) AS total FROM commmandes";
$stmtTotal = $db->prepare($queryTotal);
$stmtTotal->execute();
$totalCommands = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

// Récupérer les commandes pour la page actuelle
$query = "SELECT * FROM commmandes  WHERE client_commande = :clientID ORDER BY id_commande DESC LIMIT :limit OFFSET :offset";
$stmt = $db->prepare($query);
$stmt->bindParam(':clientID', $user['id_user'], PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);




if (isset($_GET['commande'])) {
    $commande_id = $_GET['commande'];
    $queryCommande = "SELECT * FROM commmandes WHERE id_commande = :id_commande ";
    $stmtCommande = $db->prepare($queryCommande);
    $stmtCommande->bindParam(':id_commande', $commande_id, PDO::PARAM_INT);
    $stmtCommande->execute();
    $commande = $stmtCommande->fetch(PDO::FETCH_ASSOC);

    if ($commande) {
        $id_client = $commande['client_commande'];
        $queryClient = "SELECT * FROM users WHERE id_user = :id_client";
        $stmtClient = $db->prepare($queryClient);
        $stmtClient->bindParam(':id_client', $id_client, PDO::PARAM_INT);
        $stmtClient->execute();
        $client = $stmtClient->fetch(PDO::FETCH_ASSOC);

        $id_produit = $commande['st_commande'];
        $queryProduit = "SELECT * FROM products WHERE id_prod = :id_produit";
        $stmtProduit = $db->prepare($queryProduit);
        $stmtProduit->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
        $stmtProduit->execute();
        $produit = $stmtProduit->fetch(PDO::FETCH_ASSOC);
?>

        <style>
            .product-container {
                background-color: #f8f9fa;
                /* Light grey background */
                padding: 20px;
                border-radius: 10px;
            }

            .product-img {
                max-width: 100%;
                height: auto;
                border-radius: 10px;
            }
        </style>

        <div class="container mt-5">
            <div class="row">
                <div class="col">
                    <h2 class="mb-4 mt-5 text-center">Détails du commande</h2>
                    <a href="user-commande.php" class="btn btn-primary float-end m-2">
                        <i class="bi bi-arrow-return-left"></i>
                    </a>
                </div>
            </div>

            <div class="row d-flex justify-content-center align-items-center product-container">
                <div class="col-12 col-md-6 text-center">
                    <img src="../src/images/Images_Produits/<?php echo htmlspecialchars($produit['img_prod']); ?>" alt="<?php echo htmlspecialchars($produit['Nom_prod']); ?>" class="img-fluid product-img">
                </div>

                <div class="col-12 col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Client</th>
                                <td><?php echo htmlspecialchars($client['nom_user'] . " " . $client['prenom_user']); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($client['email_user']) ?></td>
                            </tr>
                            <tr>
                                <th>Tele</th>
                                <td><?php echo htmlspecialchars($client['num_user']) ?></td>
                            </tr>
                            <tr>
                                <th>Produit</th>
                                <td><?php echo htmlspecialchars($produit['Nom_prod']); ?></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td><?php echo htmlspecialchars($produit['Des_prod']); ?></td>
                            </tr>
                            <tr>
                                <th>Catégorie</th>
                                <td><?php echo htmlspecialchars($produit['catégorie_prod']); ?></td>
                            </tr>
                            <tr>
                                <th>Service</th>
                                <td><?php echo htmlspecialchars($commande['service_commande']); ?></td>
                            </tr>
                            <tr>
                                <th>Prix</th>
                                <td><?php echo htmlspecialchars($produit['Prix_prod']); ?> DH</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    <?php }
} else if (isset($_GET['action']) && $_GET['action'] == "annuler" && isset($_GET['id_cm'])) {
    $idCm = $_GET['id_cm'];
    $queryCommande = "SELECT * FROM commmandes WHERE id_commande = :id_commande";
    $stmtCommande = $db->prepare($queryCommande);
    $stmtCommande->bindParam(':id_commande', $idCm, PDO::PARAM_INT);
    $stmtCommande->execute();
    $cm = $stmtCommande->fetch(PDO::FETCH_ASSOC);

    if ($cm && ($cm['statut_commande'] == "pas encore" || $cm['statut_commande'] == "en Traitement")) {
        $annulerStatus = "Annuler"; // Replace with the desired new status
        $sqlAnnuler = "UPDATE commmandes SET statut_commande = :Annuler_status WHERE id_commande = :id_commande";
        $stmtAnnuler = $db->prepare($sqlAnnuler);
        $stmtAnnuler->execute([
            ':Annuler_status' => $annulerStatus,
            ':id_commande' => $cm['id_commande']
        ]);
        $_SESSION['succ'] = 'La commande est Annuler.';

        header("Location: user-commande.php");
        exit();
    } else {
        $_SESSION['err'] = 'La commande est déjà traitée, veuillez contacter le support de Rida Solution.';
        header("Location: user-commande.php");
        exit();
    }
} else {  ?>

    <div class="container h-75">
        <h1 class="mt-4">Mes commandes</h1>
        <?php if (isset($_SESSION['err'])) {
            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-triangle-exclamation text-danger" ></i></strong> ' . $_SESSION['err'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
            unset($_SESSION['err']);
        } ?>
        <?php if (isset($_SESSION['succ'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-triangle-exclamation text-danger" ></i></strong> ' . $_SESSION['succ'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
            unset($_SESSION['succ']);
        } ?>
        <div class="mt-4">
            <h2>Liste des Commandes</h2>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Img</th>
                            <th>Client</th>
                            <th>Produit</th>
                            <th>Catégorie</th>
                            <th>Service</th>
                            <th>Statut</th>
                            <th>informations</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandes as $commande) :


                            // Récupérer les informations du produit
                            $id_produit = $commande['st_commande'];
                            $queryProduit = "SELECT * FROM products WHERE id_prod = :id_produit";
                            $stmtProduit = $db->prepare($queryProduit);
                            $stmtProduit->bindParam(':id_produit', $id_produit);
                            $stmtProduit->execute();
                            $produit = $stmtProduit->fetch(PDO::FETCH_ASSOC);

                        ?>
                            <tr>
                                <td><?= htmlspecialchars($commande['id_commande']); ?></td>
                                <td><img src="../src/images/Images_Produits/<?php echo htmlspecialchars($produit['img_prod']); ?>" alt="" srcset="" height="70px"></td>

                                <td><?= htmlspecialchars($user['nom_user'] . " " . $user['prenom_user']); ?></td>
                                <td><?= htmlspecialchars($produit['Nom_prod']); ?></td>
                                <td><?= htmlspecialchars($produit['catégorie_prod']); ?></td>
                                <td><?= htmlspecialchars($commande['service_commande']); ?></td>
                                <td><?= htmlspecialchars($commande['statut_commande']); ?></td>
                                <td class="text-center"><a href="user-commande.php?commande=<?= htmlspecialchars($commande['id_commande']); ?>" class="btn btn-dark">plus</a></td>
                                <td>
                                    <a href="user-commande.php?action=annuler&id_cm=<?= $commande['id_commande'] ?>" class="btn btn-danger">Annuler</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <nav aria-label="Pagination">
                <ul class="pagination justify-content-center mt-4">
                    <?php
                    $totalPages = ceil($totalCommands / $limit);
                    $previousPage = ($page > 1) ? ($page - 1) : 1;
                    $nextPage = ($page < $totalPages) ? ($page + 1) : $totalPages;
                    ?>

                    <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $previousPage; ?>" tabindex="-1" aria-disabled="true">Précédent</a>
                    </li>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $nextPage; ?>">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?php }



?>

<?php
include 'inc-user/footer-user.php';
include 'inc-user/fin-user.php';
?>