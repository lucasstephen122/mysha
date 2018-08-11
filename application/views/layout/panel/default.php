<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Shaghaf - Control Panel</title>
    <!-- Custom CSS -->
    <link href="<?php echo $base_url; ?>assets/panel/admin/dist/css/style.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>assets/panel/admin/dist/css/custom.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/tablesaw-master/dist/tablesaw.css" rel="stylesheet">
    <script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/jquery-validation/js/additional-methods.min.js"></script>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/popper/popper.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo $base_url; ?>assets/panel/admin/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo $base_url; ?>assets/panel/admin/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo $base_url; ?>assets/panel/admin/dist/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo $base_url; ?>assets/panel/admin/dist/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/tablesaw-master/dist/tablesaw.js"></script>
    <script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/tablesaw-master/dist/tablesaw-init.js"></script>
    
     <script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    
    <script src="<?php echo $base_url; ?>assets/plugins/uploader/js/vendor/jquery.ui.widget.js"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/uploader/js/jquery.iframe-transport.js"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/uploader/js/jquery.fileupload.js"></script>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/uploader/css/jquery.fileupload-ui.css" rel="stylesheet"/>
    
    <script src="<?php echo $base_url; ?>assets/js/ib-functions.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/ib-global.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/ib-ui.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/util.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/uploader.js"></script>
        
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="skin-default-dark fixed-layout lock-nav">
    <script type="text/javascript" language="javascript">

    var g = {
        base_url : '<?php echo $base_url; ?>'
    };

    </script>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label"> Admin dashboard </p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include(dirname(__FILE__).'/header.php'); ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include(dirname(__FILE__).'/menu.php'); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

        <?php echo $layout_content; ?>
        

        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->        
</body>

</html>