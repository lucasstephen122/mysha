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
                <h1 class="text-themecolor">Broadcast Message </h1>
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        
        
        <form id="frm_broadcast" name="frm_broadcast" action="<?php echo $base_url ?>panel/admin/do_broadcast" method="POST">
        <?php show_success_message(); ?>

        <div class="card">
            <div class="card-header">
                Prefrences
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    
                </div>
            </div>
            <div class="card-body collapse show">
                 
                           
                             
                            <div class="form-group row">
                                <label for="example-email-input" class="col-2 col-form-label">Specific Emails</label>
                                <div class="col-10">
                                    <input class="form-control" type="email" placeholder="email1@somemail.com, email2@somemail.com" id="emails" name="emails">
                                </div>
                            </div>
                           
                          
                            <div class="form-group row">
                                <label for="example-month-input" class="col-2 col-form-label">Channels</label>
                                <div class="col-10">
                                    <select class="custom-select col-12" id="channel" name="channel">
                                        <option value="email">Email</option>
                                        <option value="phone">SMS</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>
                            </div>
					 
					  <div class="form-group row">
                                <label for="example-month-input" class="col-2 col-form-label">Application Status </label>
                                <div class="col-10">
                                    <select class="custom-select col-12" id="status" name="status">
                                        <option value="">Choose Segment</option>
                                        <option value="draft">Draft</option>
                                        <option value="submitted">Submitted</option>
                                        <option value="reviewed">Reviewed</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
					 
					  <div class="form-group row">
                                <label for="example-month-input" class="col-2 col-form-label">Completion Status</label>
                                <div class="col-10">
                                    <select class="custom-select col-12" id="progress" name="progress">
                                        <option value="">Choose Segment</option>
                                        <option value="incomplete">Un-Completed</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                            
                         
                        
            </div>
        </div>
        
      
        <div class="row">
            <div class="col-md-12" style="overflow-x: scroll">
               <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Message Body</h4>
                        <h6 class="card-subtitle">Enter the message body below and it will be sent using the pre-made email template </h6>
                         <div class="form-group">
                            <label>Subject</label>
                            <input class="form-control" type="text" id="subject" name="subject">
                        </div>
                         <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" rows="5" id="message" name="message"></textarea>
                            <button type="submit" class="btn btn-primary waves-effect waves-light m-t-10">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
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
     
    $( document ).ready(function() {
        $('#demo-foo-accordion').footable().on('footable_row_expanded', function(e) {
            $('#demo-foo-accordion tbody tr.footable-detail-show').not(e.row).each(function() {
                $('#demo-foo-accordion').data('footable').toggleDetail(this);
            });
        });
    });

    $(function()
    {
        var $frm_broadcast = $('#frm_broadcast');

        $(document).ready(function() 
        {
            init_broadcast();
        });

        function init_broadcast()
        {
            $frm_broadcast.validate(
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