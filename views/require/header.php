<header>
    <div class="navbar">
        <div class="logo">
            <a href="<?= URL ?>home">Super reminder</a>
        </div>
        <ul class="links">
            <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 1) : ?>
                <li><a href="<?= URL ?>home">Accueil</a></li>
            <?php else: ?>
                <li><a href="<?= URL ?>home">Accueil</a></li>
            <?php endif; ?>
        </ul>
        <div class="buttons">
            <?php if(isset($_SESSION['id_user'])): ?>
                <a href="<?= URL ?>user/p" class="action-button">Mes Projets</a>
                <a href="<?= URL ?>user/lo" class="action-button red">Déconnexion</a>
            <?php else :?>
                <a href="<?= URL ?>user/r" class="action-button pro">Inscription</a>
                <a href="<?= URL ?>user/l" class="action-button">Connexion</a>
            <?php endif; ?>
        </div>
        <div class="burger-menu-button">
            <i class="fa-solid fa-bars"></i>
        </div>
    </div>
    <div class="burger-menu">
        <ul class="links">
            <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 1) : ?>
                <li><a href="<?= URL ?>home">Accueil</a></li>
            <?php else: ?>
                <li><a href="<?= URL ?>home">Accueil</a></li>
            <?php endif; ?>
            <div class="divider"></div>
            <div class="buttons-burger-menu">
            <?php if(isset($_SESSION['id_user'])): ?>
                <a href="<?= URL ?>user/lo" class="action-button red">Déconnexion</a>
            <?php else :?>
                <a href="<?= URL ?>user/r" class="action-button pro">Inscription</a>
                <a href="login.php" class="action-button">Connexion</a>
            <?php endif; ?>
            </div>
        </ul>
    </div>
</header>