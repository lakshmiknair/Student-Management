<?php include_once('header.php'); ?>
<h3 class="text-center">CLASS MANAGEMENT</h3> 
<div class="row" style="margin-top: 50px;">  
    <div class="col-sm-6 col-md-offset-3 well" >
        <?php if ($this->session->flashdata('success_message') != '') { ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success_message'); ?> </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error_message') != '') { ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error_message'); ?> </div>
        <?php } ?>
        <div id="notice"  ></div>
        <form action="<?php echo base_url('index.php/classes/save/'); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="class_id" value="<?php if (isset($standard->class_id)) echo $standard->class_id; ?>" >
            <div class="form-group">
                <label for="classname">Class Name</label>
                <input type="text" class="form-control" id="class_name" placeholder="Enter Class Name" name="class_name" required value="<?php if (isset($standard->class_name)) echo $standard->class_name ?>">   

            </div>
            <button type="submit" class="btn btn-primary"><?php if (!isset($standard->class_id)) { ?> ADD CLASS <?php } else { ?> UPDATE CLASS <?php } ?></button>
            <button class="btn btn-danger" type="reset">RESET</button>
        </form>
    </div>
</div>
<div class="row">  
    <div class="col-sm-6  col-md-offset-3">     
        <table class="table table-bordered well" id="table" >
            <thead>
                <tr><th>Class Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if (!empty($classes)) {
                        foreach ($classes as $class) {
                            ?>
                        <tr>                    
                            <td>
                                <?php echo $class->class_name ?></td>
                            <td><a class="btn btn-default" href="<?php echo base_url('index.php/classes/edit/' . $class->class_id); ?>" role="button">Edit</a></td>
                            <td><a class="btn btn-default delete" data-id="<?php echo $class->class_id; ?>" role="button">Delete</a></td>
                        </tr>                
                    <?php
                    }
                } else { 
                    ?>
                    <tr><td colspan="8" class="text-center">NO RECORDS</td></tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.alert-success').fadeIn().delay(5000).fadeOut();
        $('.alert-danger').fadeIn().delay(5000).fadeOut();
    });
    $(document).on("click", ".delete", function () {
        var tr = $(this).closest('tr');
        if (confirm("Are you sure you want to delete this?"))
        {
            $.ajax({
                url: "<?php echo base_url("index.php/classes/delete"); ?>",
                type: "POST",
                cache: false,
                data: {
                    id: $(this).attr("data-id")
                },
                success: function (data) {

                    if (data == true) {
                        tr.fadeOut(1000, function () {
                            $(this).remove();
                            $('#notice').show().html('<div class="alert alert-success" >Class Deleted Successfully </div>').fadeOut(5000);
                        });

                    } else
                        $('#notice').show().html('<div class="alert alert-danger" >Class Cannot Delete</div>').fadeOut(5000);
                }
            });
        } else
        {
            return false;
        }
    });
</script>
<?php
include_once('footer.php');
?>