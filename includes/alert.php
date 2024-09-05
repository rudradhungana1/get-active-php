<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-error">
        <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
<?php endif; ?>

<style>
    .alert {
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 5px;
        position: relative;
        width: 100%;
        margin: 0 auto;
        margin-top: 50px;
        text-align: center;
        box-sizing: border-box;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-error {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .closebtn {
        position: absolute;
        top: 0;
        right: 10px;
        font-size: 20px;
        font-weight: bold;
        line-height: 20px;
        cursor: pointer;
    }
</style>
