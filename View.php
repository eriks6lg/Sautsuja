<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Säutsuja | Mida täna meile säutsud? </title>
        <link rel="stylesheet" type="text/css" href="Style.css">
    </head>
    <body>
        <div id="header">

            <?php
            if (!isset($_SESSION['user'])): ?>

                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" id="login-form">
                    <div id="loginbox">
                        <input type="hidden" name="posttype" value="login">
                        <input class="text" type="text" placeholder="Kasutajanimi" name="username" id="login-user">
                        <input class="text" type="password" placeholder="Salasõna" name="password" id="login-pass">
                        <button type="submit" id="login-button">Logi sisse</button>
                        <span>või</span>
                        <a href="Sautsuja.php?page=register">Registreeri</a>
                    </div>
                </form>

                <?php
            else: ?>

                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <div id="logoutbox">Sisseloginud: <?= $_SESSION['user'] ?>
                        <input type="hidden" name="posttype" value="logout">
                        <button type="submit">Logi välja</button>
                    </div>
                </form>

                <?php
            endif; ?>

        </div>
        <div id="menubox">
            <div id="buttonbox">
                <form method="GET" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <button type="submit" class="menubutton">Säutsuja</button>
                    <button type="submit" class="menubutton" name="page" value="toptoday" id="topbutton">TOP täna</button>
                    <button type="submit" class="menubutton" name="page" value="topalltime">TOP kõigi aegade</button>
                    <button type="submit" class="menubutton" name="page" value="profile">Profiil</button>
                    <button type="submit" class="menubutton" name="page" value="contacts">Kontakt</button>
                </form>

            </div>
        </div>

        <?php
        if(isset($_SESSION['page'])):
            switch($_SESSION['page']):
                case 'toptoday': ?>
            <?php endswitch; endif; ?>

        <div id="body">

            <div id="maininfo">

                <?php
                if (isset($_GET['page'])):

                    switch ($_GET['page']):
                        case 'toptoday': ?> <span class="header">Tänase päeva TOP</span> <?php break;
                        case 'topalltime': ?> <span class="header"> Kõigi aegade TOP</span> <?php break;
                        case 'register': ?>
                            <span class="header"> Registreeri konto</span>
                            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                                <input type="hidden" name="posttype" value="register">
                                <?php
                                if (isset($_GET['inuse'])):
                                if($_GET['inuse'] == true): ?>
                                    <span style="font-size = 20px;">Vigane kasutajanimi või parool</span>
                                <?php endif; endif;?>
                                <table border="1">
                                    <tr>
                                        <td>Kasutajanimi</td>
                                        <td><input type="text" name="username" maxlength="16"></td>
                                    </tr>
                                    <tr>
                                        <td>Salasõna</td>
                                        <td><input type="password" name="password1" maxlength="16"></td>
                                    </tr>
                                    <tr>
                                        <td>Korda salasõna</td>
                                        <td><input type="password" name="password2" maxlength="16"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit">Registreeri</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <?php break;
                        case 'profile': ?> <span class="header"> Profiil </span> <?php break;
                        case 'contacts': ?> <span class="header"> Kontaktinfo </span> <?php break;
                    endswitch;
                else: ?> <span class="header">Kuumimad säutsud</span> <?php
                endif;
                if (!isset($_GET['page']) || $_GET['page'] == 'toptoday' || $_GET['page'] == 'topalltime'):?>

                    <table border="1" id="table" width="100%">
                        <thead>
                            <th>Kasutaja</th>
                            <th>Säuts</th>
                            <th>Punkte</th>
                            <th>Lisatud</th>
                        </thead>
                        <tdata>
                            <?php global $data;
                            for ($i = 0; $i <= 21; $i += 5):
                                if (count($data) > $i):?>
                                    <tr>
                                        <td width="10%"><?= $data[$i]; ?></td>
                                        <td width="60%"><?= $data[$i + 1]; ?></td>
                                        <td width="10%"><?= $data[$i + 2]; ?></td>
                                        <td width="15%"><?= $data[$i + 3]; ?></td>
                                        <td width="5%">
                                            <?php
                                            if(isset($_SESSION['user'])):
                                                if(!($data[$i] == $_SESSION['user'])): ?>
                                                    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                                                        <input type="hidden" name="posttype" value="addpoint">
                                                        <input type="hidden" name="index" value="<?= $data[$i + 4]; ?>">
                                                        <button type="submit">+1</button>
                                                    </form>
                                                    <?php
                                                endif;
                                            endif;?>
                                        </td>
                                     </tr>
                            <?php
                                endif;
                            endfor; ?>
                        </tdata>
                    </table>
                    <?php
                endif;

                if(isset($_GET['page']) && $_GET['page'] == 'profile'):
                    if(isset($_SESSION['user'])): ?>

                        <table border="1" id="profiletable">
                            <tr>
                                <td>Kasutajanimi</td>
                                <td><?= $_SESSION['user']; ?></td>
                            </tr>
                            <tr>
                                <td>Säutsude arv</td>
                                <td><?= controller_numberofposts_get($_SESSION['user']); ?></td>
                            </tr>
                            <tr>
                                <td>Populaarseim säuts (<?= controller_maxpoints_get($_SESSION['user']) ?>)</td>
                                <td>
                                    <?php
                                    if(controller_numberofposts_get($_SESSION['user']) == 0): ?>

                                        Pole ühtegi säutsu

                                    <?php
                                    else:
                                        echo controller_highestsauts_get($_SESSION['user']);
                                    endif; ?>
                                </td>
                            </tr>

                        </table>

                        <?php
                    else: ?>

                        <div style="font-size: 20px;">Palun logi sisse!</div>

                        <?php
                    endif;
                endif;
                if(isset($_GET['page']) && $_GET['page'] == 'contacts'): ?>

                    <h1>Arendaja: Erik Sõlg</h1>
                    <h1>Meiliaadress: eriks1995@gmail.com</h1>
                    <h1>Tel: +372 536 173 68</h1>
                <?php
                endif; ?>
            </div>
            <?php
            if (!(isset($_GET['page'])) && isset($_SESSION['user'])): ?>
                <div id="insertsauts">
                    <span class="header">Lisa säuts</span>
                    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <input type="hidden" name="posttype" value="sauts">
                        <table border="1">
                            <tbody>
                            <tr>
                                <td>
                                    <textarea maxlength="34" cols=100 rows=4 name="sauts" id="sauts"></textarea>

                                </td>
                                <td>
                                    <button type="submit">Lisa säuts</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            <?php
            endif; ?>
        </div>
        <?php
        if(isset($_GET['wrongpass'])):
            if ($_GET['wrongpass'] == true): ?>
                <input type="hidden" id="if-wrong-pass">
            <?php
            endif;
        endif; ?>
            <script src="Script.js"></script>
    </body>

</html>
