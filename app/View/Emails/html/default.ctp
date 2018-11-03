<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Canbii</title>
</head>
<?php $url = "http://" . $_SERVER['HTTP_HOST'] . $this->webroot; ?>
<body>
<style>
    .btn {
        -webkit-border-radius: 28;
        -moz-border-radius: 28;
        border-radius: 28px;
        font-family: Arial;
        color: #ffffff;
        font-size: 20px;
        background: #243466;
        padding: 10px 20px 10px 20px;
        text-decoration: none;
    }

    .btn:hover {
        background: #3cb0fd;
        background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
        background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
        text-decoration: none;
    }
</style>

<table width="100%" align="center">
    <tr>

        <td style="text-align:left;font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, 'sans-serif'; "
            valign="middle">
            <A href="<?= $url ?>"><img src="http://canbii.com/HiResLogoMedium1.png"
                                       width="200px"><span style="text-align: right;"></A>

            <div style="float: right;color:#dadada;"><h1>Your Personalized Medical Cannabis Database</h1></div>
        </td>
    </tr>
    <tr>
        <td style="padding: 45px; color: black; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif'; text-align:left; font-size:16px; valign: top;">
            <?php
                $content = explode("\n", $content);
                foreach ($content as $line):
                    echo '<p> ' . $line . "</p>\n";
                endforeach;
            ?>
        </td>
    </tr>
    <tr>
        <td align="center"
            style="padding-left: 45px; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif'; text-align:left; font-size:16px; ">
            <p>
                <a href="<?= $url . "" ?>"
                   style="text-decoration: none; color: #243466; font-weight: 500;">Home</a> |
                <a href="<?= $url . "users/register" ?>"
                   style="text-decoration: none; color: #243466; font-weight: 500;">Login</a> |
                <a href="<?= $url . "users/settings" ?>"
                   style="text-decoration: none; color: #243466; font-weight: 500;">Settings</a>

            <p>© Canbii <?php echo date("Y"); ?></p>
        </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>
</table>
</body>
</html>
