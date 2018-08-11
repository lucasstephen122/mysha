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
                <h1 class="text-themecolor">Add Administrator</h1>
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        
        
        <form id="frm_admin" name="frm_admin" action="<?php echo $base_url ?>panel/admin/save" method="POST">
        <?php show_success_message(); ?>

        <div class="row">
            <div class="col-md-12" style="overflow-x: scroll">
               <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>First name</label>
                            <input class="form-control" type="text" id="first_name" name="first_name" value="<?php echo $user['first_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Last name</label>
                            <input class="form-control" type="text" id="last_name" name="last_name" value="<?php echo $user['last_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" id="email" name="email" value="<?php echo $user['email'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input class="form-control" type="text" id="phone" name="phone" value="<?php echo $user['phone'] ?>">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input class="form-control" type="text" id="city" name="city" value="<?php echo $user['city'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" id="role" name="role">
                                <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="reviewer" <?php echo $user['role'] == 'reviewer' ? 'selected' : '' ?>>Reviewer</option>
                                <option value="approver" <?php echo $user['role'] == 'approver' ? 'selected' : '' ?>>Approver</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['user_id'] ?>">
                            <input type="submit" class="btn btn-primary" value="Submit">
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
     
    $(function()
    {
        var $frm_admin = $('#frm_admin');

        $(document).ready(function() 
        {
            init_admin();
        });

        function init_admin()
        {
            $frm_admin.validate(
            {
                submitHandler: function(form)
                {
                    form.submit();
                },

                rules:
                {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    role: {
                        required: true
                    },
                },

                messages : 
                {
                    first_name: {
                        required: "This field is required"
                    },
                    last_name: {
                        required: "This field is required"
                    },
                    email: {
                        required: "This field is required",
                        email: "This field should be valid email"
                    },
                    phone: {
                        required: "This field is required"
                    },
                    city: {
                        required: "This field is required"
                    },
                    role: {
                        required: "This field is required"
                    },
                },
            });

            var settings = $frm_admin.validate().settings;
            var required_fields = [];
            for (var i in settings.rules)
            {
                if(settings.rules[i].required)
                {
                    required_fields.push(i);
                    $('[name="'+ i +'"]').closest('.form-group').find('label').append('<span class="astk">*</span>');
                }
            }
        }
    }(jQuery));

</script>