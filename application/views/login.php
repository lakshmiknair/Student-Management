<?php include_once('header.php'); ?>
<div class="row">   
    <h4 class="text-center">ADMIN LOGIN</h4>     
    <div class="col-sm-6 col-md-offset-3 well">
        <?php if ($this->session->flashdata('success_message') != '') { ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success_message'); ?> </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error_message') != '') { ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error_message'); ?> </div>
        <?php } ?>
        <form action="<?php echo base_url('index.php/user/validate/'); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email ID:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="" required>
                <?php echo form_error('email'); ?>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" value="" required>   
                <?php echo form_error('password'); ?> 
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-primary">LOGIN</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.alert-success').fadeIn().delay(5000).fadeOut();
        $('.alert-danger').fadeIn().delay(5000).fadeOut();
    });
</script>
<?php
include_once('footer.php');
?>