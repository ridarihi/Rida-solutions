<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: ../home.php");
    exit;
}

// Inclure les fichiers nécessaires
include '../inc/fonctions.php';
include '../inc/connect.php';

// Récupérer les informations de l'utilisateur connecté
$user = $_SESSION['user'];

// Gérer la déconnexion
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Détruire la session
    session_destroy();
  
    setcookie('user_cookie', '', time() - 3600, '/'); // 
    // Rediriger vers la page de connexion
    header("Location: ../home.php?action=seConnecter");  
    $_SESSION['succ'] = 'Vous avez été déconnecté de votre compte.';
    exit;
}
if (isset($user['id_user'])) {
    $cookie_name = 'user_cookie';
    $cookie_value = $user['prenom_user'];
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/'); // Cookie valable 30 jours
}

// Définir le titre de la page
$title = "User Dashboard";
include 'inc-user/debut-user.php';
include 'inc-user/header-user.php';
// Traitement de la modification du profil utilisateur
if (isset($_GET["action"]) && $_GET["action"] == "edit" && isset($_GET["id_user"])) {
    $id = $_GET["id_user"];

    // Fetch existing user details
    $sql = "SELECT * FROM users WHERE id_user = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userDetails) {
        // Handle the case where the user is not found
        echo "User not found.";
        exit();
    }

    // Process form submission for profile update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if new profile image is uploaded
        $profil_up = !empty($_FILES['profil_up']['name']) ? $_FILES['profil_up']['name'] : $userDetails['profil_user'];
        $nom_up = $_POST['nom_up'] ?? $userDetails['nom_user'];
        $prenom_up = $_POST['prenom_up'] ?? $userDetails['prenom_user'];
        $genre_up = $_POST['genre_up'] ?? $userDetails['genre_user'];
        $email_up = $_POST['email_up'] ?? $userDetails['email_user'];
        $password_up = !empty($_POST['password_up']) ? $_POST['password_up'] : $userDetails['password_user'];
        $date_up = $_POST['date_up'] ?? $userDetails['daten_user'];

        // Move uploaded file if exists
        if (!empty($_FILES['profil_up']['name'])) {
            $target_dir = "../src/images/profils/";
            $target_file = $target_dir . basename($_FILES["profil_up"]["name"]);
            move_uploaded_file($_FILES["profil_up"]["tmp_name"], $target_file);
        }

        // Update user details
        $sql_update = "UPDATE users SET profil_user = :profil, nom_user = :nom, prenom_user = :prenom, genre_user = :genre, email_user = :email, password_user = :password, daten_user = :date WHERE id_user = :id";
        $stmt_update = $db->prepare($sql_update);
        $stmt_update->execute([
            ':profil' => $profil_up,
            ':nom' => $nom_up,
            ':prenom' => $prenom_up,
            ':genre' => $genre_up,
            ':email' => $email_up,
            ':password' => $password_up,
            ':date' => $date_up,
            ':id' => $id
        ]);
        if ($stmt_update) {
            $_SESSION['user']['profil_user'] = $profil_up;
            $_SESSION['user']['nom_user'] = $nom_up;
            $_SESSION['user']['prenom_user'] = $prenom_up;
            $_SESSION['user']['genre_user'] = $genre_up;
            $_SESSION['user']['email_user'] = $email_up;
            $_SESSION['user']['password_user'] = $password_up;
            $_SESSION['user']['daten_user'] = $date_up;
            $_SESSION['succ'] = 'Les informations bien mises à jour';


            // Redirection vers la page de tableau de bord
            header("Location: index.php");
            exit();
        }
        // Redirect back to dashboard after update
        header('Location: index.php');
        exit();
    }
} else  if (isset($_GET['action']) && $_GET['action'] == "update") {

    // Handle user registration form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle file upload for profile picture

        $userId = $_SESSION['user']['id_user'];
        $genderUser = $_POST['genderUser']; // Validate and sanitize this value
        $datenUser = $_POST['datenUser']; // Validate and sanitize this value
        $passwordUser = $_POST['passwordUser']; // Validate and sanitize this value

        // Prepare the SQL update statement
        $req = "UPDATE users SET genre_user = :genre, password_user = :password, daten_user = :date WHERE id_user = :id";

        // Assuming $db is your PDO object or database connection handle
        $stmt = $db->prepare($req);
        $stmt->execute([

            ':genre' => $genderUser,
            ':password' => $passwordUser,
            ':date' => $datenUser,
            ':id' => $userId
        ]);
        if ($stmt) {
            // Mettre à jour les valeurs dans $_SESSION['user']     
            $_SESSION['user']['genre_user'] = $genderUser;
            $_SESSION['user']['password_user'] = $passwordUser;
            $_SESSION['user']['daten_user'] = $datenUser;

            // Redirection vers la page de tableau de bord
            header("Location: index.php");
            exit();
        }

        // Redirect after successful update
        header("Location: index.php");
        exit();
    }
} else if (!isset($_GET['u'])) {
?>

    <div class="container vh-75">
        <div class="row">
            <div class="col">
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
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
            <h3 class="text-center">Bienvenue, <?php echo htmlspecialchars($user['prenom_user']); ?>!</h3>

            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <!-- Afficher l'image de profil -->
                <div class="mb-4 text-center">
                    <img src="../src/images/profils/<?php echo htmlspecialchars($user['profil_user']); ?>" alt="Image de profil" class="img-fluid rounded-circle monProfil" style="height: 250px; width: 250px">
                </div>
            </div>
            <div class="col-md-9 p-5">
                <!-- Afficher les détails de l'utilisateur -->
                <table class="table table-bordered">
                    <tr>
                        <th>Nom:</th>
                        <td><?php echo htmlspecialchars($user['nom_user']); ?></td>
                    </tr>
                    <tr>
                        <th>Prénom:</th>
                        <td><?php echo htmlspecialchars($user['prenom_user']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($user['email_user']); ?></td>
                    </tr>
                    <tr>
                        <th>Date de naissance:</th>
                        <td><?php echo htmlspecialchars($user['daten_user']); ?></td>
                    </tr>
                    <tr>
                        <th>Genre:</th>
                        <td><?php echo htmlspecialchars($user['genre_user']); ?></td>
                    </tr>
                    <!-- Ajouter d'autres champs si nécessaire -->
                </table>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-pencil m-2"></i> Modifier
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modification des informations</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="index.php?action=edit&id_user=<?= htmlspecialchars($user['id_user']) ?>" method="POST" enctype="multipart/form-data">
                                    <div class="col mb-2 text-center">
                                        <img src="../src/images/profils/<?= htmlspecialchars($user['profil_user']) ?>" alt="Photo de profil actuelle" class="rounded-circle" width="50" height="50" style="object-fit: cover; object-position: center;">
                                    </div>
                                    <div class="col mb-2">
                                        <input type="file" name="profil_up" id="profil_up" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="nom_up" id="nom_up" class="form-control" placeholder="Nom" value="<?= htmlspecialchars($user['nom_user']) ?>">
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="prenom_up" id="prenom_up" class="form-control" placeholder="Prénom" value="<?= htmlspecialchars($user['prenom_user']) ?>">
                                    </div>
                                    <div class="mb-2">
                                        <input type="date" name="date_up" id="date_up" class="form-control" placeholder="Date de naissance" value="<?= htmlspecialchars($user['daten_user']) ?>">
                                    </div>
                                    <div class="mb-2">
                                        <select name="genre_up" id="genre_up" class="form-control">
                                            <option selected disabled value="">Sélectionnez votre genre</option>
                                            <option value="homme" <?= ($user['genre_user'] == 'homme') ? 'selected' : '' ?>>Homme</option>
                                            <option value="femme" <?= ($user['genre_user'] == 'femme') ? 'selected' : '' ?>>Femme</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <input type="email" name="email_up" id="email_up" class="form-control" placeholder="Email" value="<?= htmlspecialchars($user['email_user']) ?>">
                                    </div>
                                    <div class="mb-2">
                                        <input type="password" name="password_up" id="password_up" class="form-control" placeholder="Nouveau mot de passe" minlength="7">
                                    </div>
                                    <div class="mb-2">
                                        <input type="password" name="passwordCnf_up" id="passwordCnf_up" class="form-control" placeholder="Confirmation mot de passe" minlength="7">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
} else if (isset($_GET['u']) && $_GET['u'] == "otp") {
    $user_email = $user['email_user'];
    $req = "SELECT * FROM users WHERE email_user = :email_user";
    $userDB = $db->prepare($req);
    $userDB->bindParam(':email_user', $user_email, PDO::PARAM_STR);
    $userDB->execute();
    $userArr = $userDB->fetch(PDO::FETCH_ASSOC);
    if ($userArr && $user['password_user'] == $userArr['password_user']) {
    ?>
        <div class="container">
            <div class="row">
                <div class="col">
                <?php if (isset($_SESSION['succ'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-triangle-exclamation text-danger" ></i></strong> ' . $_SESSION['succ'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
            unset($_SESSION['succ']);
        } ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h2 class="text-center text-primary m-2">Inscription Utilisateur</h2>
                    <form action="index.php?action=update" method="POST" enctype="multipart/form-data" class="container mt-4">
                        <div class="row mb-3">

                            <label for="NomUser" class="col-sm-2 col-form-label">Nom:</label>
                            <div class="col-sm-10">
                                <input type="text" id="NomUser" name="NomUser" class="form-control" disabled value="<?= htmlspecialchars($userArr['nom_user']) ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="prenomUser" class="col-sm-2 col-form-label">Prénom:</label>
                            <div class="col-sm-10">
                                <input type="text" id="prenomUser" name="prenomUser" class="form-control" disabled value="<?= htmlspecialchars($userArr['prenom_user']) ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="emailUser" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-10">
                                <input type="email" id="emailUser" name="emailUser" class="form-control" disabled value="<?= htmlspecialchars($userArr['email_user']) ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="numUser" class="col-sm-2 col-form-label">Tel:</label>
                            <div class="col-sm-10">
                                <input type="text" id="numUser" name="numUser" class="form-control" disabled value="<?= htmlspecialchars($userArr['num_user']) ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gender" class="col-sm-2 col-form-label">Genre:</label>
                            <div class="col-sm-10">
                                <select id="gender" name="genderUser" class="form-select" required>
                                    <option value="" disabled <?= ($userArr['genre_user'] === "ancun") ? "selected" : "" ?>>Sélectionnez votre genre</option>
                                    <option value="homme" <?= ($userArr['genre_user'] === "homme") ? "selected" : "" ?>>Homme</option>
                                    <option value="femme" <?= ($userArr['genre_user'] === "femme") ? "selected" : "" ?>>Femme</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="datenUser" class="col-sm-2 col-form-label">Date de naissance:</label>
                            <div class="col-sm-10">
                                <input type="date" id="datenUser" name="datenUser" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="passwordUser" class="col-sm-2 col-form-label">password Actuel:</label>
                            <div class="col-sm-10">
                                <input type="text" id="passwordUser" name="passwordUser" class="form-control" disabled value="<?= htmlspecialchars($userArr['password_user']) ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="passwordUser" class="col-sm-2 col-form-label">Changer password:</label>
                            <div class="col-sm-10">
                                <input type="password" id="passwordUser" name="passwordUser" class="form-control" required>
                            </div>
                        </div>


                        <div class="row mb-3 float-end">
                            <div class="col-sm-10 offset-sm-2 ">
                                <input type="submit" value="S'inscrire" class="btn btn-primary">
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
<?php
    } else {
        header("Location: index.php");
    }
}
?>

<?php
include 'inc-user/footer-user.php';
include 'inc-user/fin-user.php';
?>