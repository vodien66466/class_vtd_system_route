<?php $img_colder="#757575"; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>
        <meta name="robots" content="noindex, nofollow" />
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }
            a {text-decoration: none; color: <?=$img_colder?>;}

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: <?=$img_colder?>;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            hr {
                margin-top: 20px;
                margin-bottom: 20px;
                border: 0;
                border-top: 1px solid <?=$img_colder?>;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
            <table>
                <tr>
                    <td><img style="width: 200px" src="<?php echo $s->asset(null,"public/images/logo/757575.png"); ?>"></td>
                    <td>
                        <div class="title">404 not found.</div>
                        <hr>
                        <h1><a href="#" target="_blank">VTD System Route</a></h1>
                    </td>
                </tr>
            </table>
                
            </div>
        </div>
    </body>
</html>
