<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h1 class="text-themecolor">Application Setting </h1>
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        
        
        
        <div class="card">
            <div class="card-header">
                Prefrences
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    
                </div>
            </div>
            <div class="card-body collapse show">
                 <form id="frm_setting" name="frm_setting" action="<?php echo $base_url ?>panel/admin/save_setting" method="POST">
                 <?php show_success_message(); ?>           
                             
                             
                           
                          
                            <div class="form-group row">
                                <label for="example-month-input" class="col-2 col-form-label">Application Status</label>
                                <div class="col-10">
                                    <select class="custom-select col-12" id="application" name="application">
                                        <option value="1" <?php echo $settings['application'] == 1 ? 'selected' : '' ?>>On</option>
                                        <option value="0" <?php echo $settings['application'] == 0 ? 'selected' : '' ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn waves-effect waves-light btn-block btn-primary">Update</button>
                            
                         
                        </form>
            </div>
        </div>
        
      
        
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->


<script>
     
    $(function()
    {
        var $frm_setting = $('#frm_setting');

        $(document).ready(function() 
        {
            init_setting();
        });

        function init_setting()
        {
            $frm_setting.validate(
            {
                submitHandler: function(form)
                {
                    form.submit();
                },

                rules:
                {

                },

                messages : 
                {
                    
                },
            });
        }
    }(jQuery));

</script>