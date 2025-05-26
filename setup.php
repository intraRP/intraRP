<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup &rsaquo; intraRP</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #0f1828;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
            overflow-y: hidden;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 140px;
            flex-shrink: 0;
        }

        .content {
            background: #1d2e4e;
            border: 2px solid #395b9a;
            width: 85%;
            margin: 0 auto;
            padding: 20px;
            height: 100vh;
        }

        .content>form {
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
        }

        .content>form>input {
            width: 400px;
            border-radius: 0;
            background: rgba(57, 91, 154, .4);
            border-color: #0f1828;
            color: lightgray;
            margin: 15px auto;
            padding: 8px;
        }

        .content button {
            width: 400px;
            border-radius: 0;
            background: #fff;
            color: #000;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 20px;
        }

        .content button:hover {
            background: #395b9a;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="/assets/img/defaultLogo.webp" height="128px" width="auto" alt="intraRP">
    </div>
    <div class="content">
        <h1 style="text-align:center">Setup</h1>
        <h3>Datenbank</h3>
        <form action="setup.php" method="post">
            <label for="db_host">Datenbank Host:</label>
            <input type="text" id="db_host" name="db_host" placeholder="localhost oder IP" required>

            <label for="db_user">Datenbank Benutzer:</label>
            <input type="text" id="db_user" name="db_user" placeholder="root" required>

            <label for="db_pass">Datenbank Passwort:</label>
            <input type="password" id="db_pass" name="db_pass" placeholder="***" required>

            <label for="db_name">Datenbank Name:</label>
            <input type="text" id="db_name" name="db_name" placeholder="intrarp" required>

            <button type="submit">Setup starten</button>
        </form>
    </div>
</body>

</html>