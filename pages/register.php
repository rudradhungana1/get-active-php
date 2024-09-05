
<div class="container">
    <div class="box form-box">

        <style>
            .logo{
                height: 61px;
                width: 100px;
                object-fit: cover;
            }
            .container header {
                font-size: 24px;
                font-weight: bold;
                text-align: center;
                margin-bottom: 20px;
            }


            .form-box {
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
                width: 300px;
                margin: 0 auto;
            }

            .field {
                margin-bottom: 15px;
            }

            .input label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }

            .input select {
                width: 100%;
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            .input input {
                width: 100%;
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            .btn {
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                padding: 10px;
                cursor: pointer;
                width: 100%;
            }

            .btn:hover {
                background-color: #0056b3;
            }

            .links {
                margin-top: 15px;
                text-align: center;
            }

            .links a {
                color: #007bff;
                text-decoration: none;
            }

            .links a:hover {
                color: #0056b3;
            }
        </style>

        <div class="container">
            <div class="box form-box">
                <header>
                    <img src="../assets/images/logo.png" alt="Logo" class="logo">
                </header>

                <header>Sign Up</header>
                <form action="../controllers/signupController.php" method="post" onsubmit="return validateForm()">
                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="type">User Type</label>
                        <select name="type" id="type" required>
                            <option value="user">User</option>
                            <option value="client">Client</option>
                        </select>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Register" required>
                    </div>
                    <div class="links">
                        Already a member? <a href="login.php">Sign In</a>
                    </div>
                </form>
            </div>
        </div>


        <script>
            function validateForm() {
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;
                const address = document.getElementById('address').value;

                const usernameRegex = /^[a-zA-Z0-9]+$/;
                if (!usernameRegex.test(username)) {
                    alert('Username must be alphanumeric.');
                    return false;
                }

                if (password.length < 8) {
                    alert('Password must be at least 8 characters long.');
                    return false;
                }

                if (address.length > 150) {
                    alert('Address must be less than or equal to 150 characters.');
                    return false;
                }

                return true;
            }
        </script>