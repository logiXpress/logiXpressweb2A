<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_utilisateur'])) {
    require_once '../../../config/config.php';

    try {
        $pdo = config::getConnexion();
        $id_utilisateur = trim($_POST['id_utilisateur'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
        $confirmation_checked = isset($_POST['confirmation']) ? true : false;

        if (!empty($id_utilisateur) && !empty($password) && !empty($recaptcha_response) && $confirmation_checked) {
            $secret_key = '6Lcq3SQrAAAAAG6PGHpnztnDT-XJynfhz9-PagUH';
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$recaptcha_response");
            $response_keys = json_decode($response, true);

            if (intval($response_keys["success"]) === 1) {
                $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur");
                $stmt->execute([':id_utilisateur' => $id_utilisateur]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['Mot_de_passe'])) {
                    $_SESSION['user'] = $user;
                    $_SESSION['id_utilisateur'] = $user['id_utilisateur'];

                    if ($user['Type'] === 'Admin') {
                        header("Location: /Project/View/Back_Office/livraison/dashboard.php");
                        exit();
                    } elseif ($user['Type'] === 'Client') {
                        header("Location: /Project/View/Acceuil/clientpage.php");
                        exit();
                    }
                } else {
                    $error_message = "ID utilisateur ou mot de passe incorrect.";
                }
            } else {
                $error_message = "La vérification reCAPTCHA a échoué.";
            }
        } else {
            $error_message = "Veuillez remplir tous les champs, valider le reCAPTCHA et confirmer votre accord.";
        }
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .login-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            height: 110vh;
            background-image: url('/Project/logixpress.sign.in.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding-left: 50px;
        }
        .login-form {
            background: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
        }
        .login-form h4 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        .input-group input[type="text"],
        .input-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            position: absolute;
            bottom: -18px;
            left: 0;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #fff;
            font-size: 14px;
        }
        .footer a {
            color: #f1f1f1;
            text-decoration: none;
        }
        .footer a:hover {
            color: #fff;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            font-size: 14px;
            margin-top: -10px;
        }
        .checkbox-label input {
            margin-right: 10px;
        }
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 60%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #4CAF50;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h4>Connexion</h4>

            <?php if (!empty($error_message)): ?>
                <div style="background-color: #f44336; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 20px;">
                    <?= htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form id="login-form" method="POST" action="">
                <div class="input-group">
                    <label for="id_utilisateur">ID Utilisateur</label>
                    <input type="text" name="id_utilisateur" id="id_utilisateur">
                    <div id="id-error" class="error-message"></div>
                </div>

                <div class="input-group">
                    <label for="password">Mot de Passe</label>
                    <input type="password" name="password" id="password">
                    <i class="fa fa-eye-slash eye-icon" id="eye-icon"></i>
                    <div id="password-error" class="error-message"></div>
                </div>

                <div style="text-align: right; margin-bottom: 20px;">
                    <a href="reset_password.php" style="color: #4CAF50;">Mot de passe oublié ?</a>
                </div>

                <div class="input-group">
                    <div class="g-recaptcha" data-sitekey="6Lcq3SQrAAAAANERTeLnLsb9aTtu4mze-z4V7BQR"></div>
                    <div id="captcha-error" class="error-message" style="position: static; margin-top: 10px; text-align: center;"></div>
                </div>

                <div class="input-group checkbox-label">
                    <input type="checkbox" name="confirmation" id="confirmation">
                    <label for="confirmation">Je confirme que les informations saisies sont correctes.</label>
                    <div id="confirmation-error" class="error-message" style="position: static; margin-left: 10px;"></div>
                </div>

                <div class="input-group">
                    <button type="submit" class="btn">Se connecter</button>
                </div>

                <p style="text-align:center;">
                    Vous n'avez pas de compte ? <a href="../signup/signup.php">Inscrivez-vous</a>
                </p>
            </form>

            <!-- Google Sign In Button -->
            <div id="g_id_onload"
                data-client_id="28161300147-a0flkk17jvalr7e8m8gmm8ctnntb28jf.apps.googleusercontent.com"
                data-callback="handleCredentialResponse"
                data-auto_prompt="false">
            </div>
            <div class="g_id_signin" data-type="standard" data-theme="outline" data-text="sign_in_with"
                data-shape="pill" data-size="large"></div>
        </div>
    </div>

    <footer class="footer">
        <p>© <span id="year"></span>, réalisé avec <i class="fas fa-heart"></i> par <a href="https://www.creative-tim.com/" target="_blank">Creative Tim</a>.</p>
    </footer>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();

        document.getElementById("login-form").addEventListener("submit", function(event) {
            var valid = true;
            var idUtilisateur = document.getElementById("id_utilisateur").value.trim();
            var password = document.getElementById("password").value.trim();
            var recaptcha = grecaptcha.getResponse();
            var confirmation = document.getElementById("confirmation").checked;

            document.getElementById("id-error").textContent = "";
            document.getElementById("password-error").textContent = "";
            document.getElementById("captcha-error").textContent = "";
            document.getElementById("confirmation-error").textContent = "";

            if (idUtilisateur === "") {
                document.getElementById("id-error").textContent = "Veuillez saisir votre ID.";
                valid = false;
            } else if (isNaN(idUtilisateur)) {
                document.getElementById("id-error").textContent = "L'ID doit être un nombre.";
                valid = false;
            }

            if (password === "") {
                document.getElementById("password-error").textContent = "Veuillez saisir votre mot de passe.";
                valid = false;
            }

            if (recaptcha === "") {
                document.getElementById("captcha-error").textContent = "Veuillez valider le reCAPTCHA.";
                valid = false;
            }

            if (!confirmation) {
                document.getElementById("confirmation-error").textContent = "Veuillez confirmer que les informations sont correctes.";
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });

        // Toggle password visibility
        document.getElementById("eye-icon").addEventListener("click", function() {
            var passwordField = document.getElementById("password");
            var icon = document.getElementById("eye-icon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        });
    </script>
</body>
</html>
