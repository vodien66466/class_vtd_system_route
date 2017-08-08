<?php
define('VTD_System_Route',1);
include '../../VTD_system/VTD_load.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DEMO IMG</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=system::asset(null,"public/assets/fancybox/jquery.fancybox-1.3.4.css")?>" media="screen" />
    <style type="text/css">
        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        img {
            width: 98%;
        }
        .container {
            max-width: 730px;
        }
    </style>
</head>

<body data-spy="scroll" data-target=".scroller-spy" data-twttr-rendered="true">
    <div class="container">
        <div class="col-md-12">
            <center>
                <img src="<?=system::asset(null,$GLOBALS['vtd_config']['image_error'])?>" class="img-thumbnail" id="show_img">
                <hr>
                <input id="fieldID" class="form-control" type="text" value="<?=system::asset(null,$GLOBALS['vtd_config']['image_error'])?>"> 
                <hr>
            </center>
        </div>
        <div class="row">
            <div class="col-md-6">
                <center><a href="<?=system::base_url()?>/filemanager/dialog.php?type=1&field_id=fieldID&relative_url=2" class="btn btn-info iframe-btn" type="button">ADD IMG</a></center>
            </div>
            <div class="col-md-6">
                <center><button class="btn btn-danger" onclick="del_img()">Del IMG</button></center>
            </div>
        </div>
    </div>
    
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script src="<?=system::asset(null,"public/assets/js/img_filemanager.js")?>"></script>
    <!-- PAGE CUSTOM SCROLLER -->
    <script type="text/javascript" src="<?=system::asset(null,"public/assets/js/jquery.nicescroll.js")?>"></script>
    <script>
        eval(mod_pagespeed_YKp7BcUjUD);
    </script>
    <script>
        eval(mod_pagespeed_jGYSiN$6dX);
    </script>
    <script>
        eval(mod_pagespeed_jrITpHcW9P);
    </script>
    <script>
        eval(mod_pagespeed_GlPRu9P44m);
    </script>
    <script>
        eval(mod_pagespeed_H2I6UFTxcC);
    </script>
    <script>
        eval(mod_pagespeed_O7hvsFin9b);
    </script>
    <script>
        eval(mod_pagespeed_csb4b9kF7D);
    </script>
    <script>
        eval(mod_pagespeed_3dkA$MKnSq);
    </script>
    <script>
        eval(mod_pagespeed_abMBv3RvOX);
    </script>
    <script>
        eval(mod_pagespeed_H2I6UFTxcC);
    </script>
    <script>
        /*
        function responsive_filemanager_callback(field_id) {
            if (field_id) {
                console.log(field_id);
                var url = jQuery('#' + field_id).val();
            }
        }
        */
        function responsive_filemanager_callback(field_id) {
            if (field_id) {
                console.log(field_id);
                var url = jQuery('#' + field_id).val();
                $('#show_img').attr('src',url);
            }
        }
        function del_img() {
            var url = '<?=system::asset(null,$GLOBALS['vtd_config']['image_error'])?>';
            $('#show_img').attr('src',url);
            $('#fieldID').attr('value',url);
        }
        jQuery(document).ready(function($) {
            $('.iframe-btn').fancybox({
                'width': 880,
                'height': 570,
                'type': 'iframe',
                'autoScale': true
            });

            function OnMessage(e) {
                var event = e.originalEvent;
                if (event.data.sender === 'responsivefilemanager') {
                    if (event.data.field_id) {
                        var fieldID = event.data.field_id;
                        var url = event.data.url;
                        $('#' + fieldID).val(url).trigger('change');
                        $.fancybox.close();
                        $(window).off('message', OnMessage);
                    }
                }
            }
            $('.iframe-btn').on('click', function() {
                $(window).on('message', OnMessage);
            });
            
        });

        
    </script>
</body>

</html>