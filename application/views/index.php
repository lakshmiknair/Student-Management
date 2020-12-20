<?php include_once('header.php'); ?>
<div class="row" >
    <h3 class="text-center">STUDENTS LIST</h3>
    <div class="col-sm-10 col-md-offset-1">
        <?php if ($this->session->flashdata('success_message') != '') { ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success_message'); ?> </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error_message') != '') { ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error_message'); ?> </div>
        <?php } ?>
        <div id='notice'></div>
        <form action="<?php echo base_url('index.php/student/index/'); ?>" method="POST">            
            <div class="pull-left" style="margin-bottom: 20px;">
                <select class="form-control" id="class_id" name="class_id" onchange="this.form.submit()">
                    <option value="0">Select Class</option>
                    <?php foreach ($classes as $class) { ?>
                        <option value="<?php echo $class->class_id; ?>" <?php if ($class->class_id == $class_id) { ?> selected="selected" <?php } ?> ><?php echo $class->class_name; ?></option>
                    <?php } ?>
                </select>
                <?php echo form_error('class_id'); ?> 

            </div>
        </form>
        <div class="pull-right" style="margin-bottom: 20px;">
            <a class="btn btn-default" href="<?php echo base_url('index.php/student/create'); ?>" role="button">Add Student</a>
            <a class="btn btn-default" href="<?php echo base_url('index.php/student/export'); ?>" role="button">Export</a>
        </div>
        <div class="student-table">
            <table class="table table-bordered " id="table" >
                <thead class="well">
                    <tr>                        
                        <th>Firstname</th>
                        <th>Lastname</th>

                        <th>Email</th>
                        <th>Emergency No.</th>
                        <th>Class</th>
                        <th>Update Class</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)) { ?>

                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo $student->firstname; ?></td>
                                <td><?php echo $student->lastname; ?></td>

                                <td><?php echo $student->email; ?></td>
                                <td><?php echo $student->emergency_number; ?></td>
                                <td data-id="<?php echo $student->student_id; ?>"><?php echo $student->class_name; ?></td>
                                <td><a class="btn btn-default class-update" data-id="<?php echo $student->student_id; ?>" role="button">Update</a></td>
                                <td><a class="btn btn-default edit-student"  href="<?php echo base_url('index.php/student/edit/' . $student->student_id); ?>" role="button">Edit</a></td>
                                <td><a class="btn btn-default delete" data-id="<?php echo $student->student_id; ?>" role="button">Delete</a></td>

                            <?php endforeach; ?>
                        </tr>
                    <?php } else { ?>
                        <tr><td colspan="8" class="text-center">NO RECORDS</td></tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if (!empty($students)) { ?>
                <div class="pagination_links text-center" > 
                    <?php echo $links; ?>
                </div> 
            <?php } ?>

        </div>


        <?php foreach ($students as $student): ?>

            <!-- Jquery popup box-->
            <div id="dialog_<?php echo $student->student_id; ?>" class="div-update" title="UPDATA CLASS">
                <div class="form-group"><?php echo $student->firstname . " " . $student->lastname; ?></div>
                <select class="form-control" id="class_id_<?php echo $student->student_id; ?>" name="class_id">
                    <option value="0">Select Class</option>
                    <?php foreach ($classes as $class) { ?>
                        <option value="<?php echo $class->class_id; ?>" <?php if ($class->class_id == $student->class_id) { ?> selected="selected" <?php } ?> ><?php echo $class->class_name; ?></option>
                    <?php } ?>
                </select>
                <button type="button" data-id="<?php echo $student->student_id; ?>" class="btn btn-dark button-update" style="margin-top: 20px;">UPDATE</button>
            </div>
            <!-- Popup end here-->

        <?php endforeach; ?>

    </div> 
    <script>
        $(document).ready(function () {
            $('.alert-success').fadeIn().delay(5000).fadeOut();
            $('.alert-danger').fadeIn().delay(5000).fadeOut();

        });
        function ajaxStudentList()
        {
            $.ajax({
                url: "<?php echo base_url("index.php/student/ajaxStudentList"); ?>",
                type: "POST",
                cache: false,
                data: {
                },
                success: function (data) {
                    $('.student-table').html(data);
                }
            });
        }
        $(document).on('click', '.class-update', function (e) {
            var i = $(this).attr("data-id");
            //     alert(i);
            $('#dialog_' + i).dialog("open");
        });
        $(".div-update").find("button").on("click", function (event) {
            event.preventDefault();
            var student_id = $(this).attr("data-id")
            var class_id = $("#class_id_" + student_id).val();
            updateClass(student_id, class_id);
        });

        $(".div-update").dialog({
            autoOpen: false
        });

        function updateClass(student_id, class_id)
        {

            $.ajax({
                url: "<?php echo base_url("index.php/student/update"); ?>",
                type: "POST",
                cache: false,
                data: {
                    student_id: student_id,
                    class_id: class_id
                },
                success: function (data) {
                    var dataResult = JSON.parse(data);
                    if (dataResult.statusCode == 200) {
                        $('#table').find("td[data-id='" + student_id + "']").html(dataResult.class_name);
                    }
                }
            });
            $('#dialog_' + student_id).dialog("close");

        }
        $(document).on("click", ".delete", function () {
            var tr = $(this).closest('tr');
            if (confirm("Are you sure you want to delete this?"))
            {
                $.ajax({
                    url: "<?php echo base_url("index.php/student/delete"); ?>",
                    type: "POST",
                    cache: false,
                    data: {
                        id: $(this).attr("data-id")
                    },
                    success: function (data) {
                        if (data == true) {
                            ajaxStudentList();
                            $('#notice').show().html('<div class="alert alert-success" >Class Deleted Successfully </div>').fadeOut(5000);
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
    include('footer.php');
    ?>