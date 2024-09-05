<?php include '../includes/header.php'; ?>

    <main class="w3-content">
        <section class="hero">
            <div class="hero-content">
                <h1>Get active, get connected!</h1>
                <p>Join sports activities in the Southwark borough and connect with your community.</p>
                <div class="buttons">
<?php if (is_logged_in()): ?>
    <a href="facilities.php"><button class="btn btn-active">Get Active</button></a>
<?php endif; ?>

<?php if (!is_logged_in()): ?>
    <a href="register.php"><button class="btn btn-signup">Sign Up</button></a>
<?php endif; ?>

                </div>
            </div>
        </section>
    </main>

<?php include '../includes/footer.php'; ?>