<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Security-Policy" content="default-src 'self'">
        <title>Säutsuja | Mida täna meile säutsud? </title>
        <link rel="stylesheet" type="text/css" href="Style.css">
    </head>
    <body>
        <div id="header">
            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                <div id="loginbox">
                    <input class="text" type="text" placeholder="Kasutajanimi" name="nimi">
                    <input class="text" type="password" placeholder="Salasõna" name="salasona">
                    <button type="submit">Logi sisse</button>
                </div>
            </form>
        </div>
        <div id="menubox">
            <div id="buttonbox">
                <form method="GET" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <button type="submit" class="menubutton" name="page" value="home">Säutsuja</button>
                    <button type="submit" class="menubutton" name="page" value="toptoday">TOP täna</button>
                    <button type="submit" class="menubutton" name="page" value="topalltime">TOP kõigi aegade</button>
                    <button type="submit" class="menubutton" name="page" value="profile">Profiil</button>
                    <button type="submit" class="menubutton" name="page" value="contacts">Kontakt</button>
                </form>

            </div>
        </div>
        <div id="body"></div>
        <script src="Script.js"></script>
    </body>
</html>