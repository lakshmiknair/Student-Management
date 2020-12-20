<?php include_once('header.php'); ?>
<div class="row">  
    <h3 class="text-center">STUDENT REGISTRATION FORM</h3>
    <div class="col-sm-6 col-md-offset-3 well">

        <form action="<?php echo base_url('index.php/student/save/'); ?>" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
            <div class="form-group">
                <label for="firstname">First Name:</label>

                <input type="text" class="form-control" id="firstname" placeholder="Enter Firstname" name="firstname" value="<?php echo $firstname; ?>">   
                <?php echo form_error('firstname'); ?> 
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" class="form-control" id="lastname" placeholder="Enter Lastname" name="lastname" value="<?php echo $lastname; ?>">      
                <?php echo form_error('lastname'); ?> 
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address"  placeholder ="Enter Address" name="address"><?php echo $address; ?></textarea>   

            </div>
            <div class="form-group">
                <label for="contactnumber">Contact Number:</label>
                <input type="text" class="form-control" id="contact_number" placeholder="Enter Contact Number" name="contact_number" value="<?php echo $contact_number; ?>">                          
                <?php echo form_error('contact_number'); ?>
            </div>
            <div class="form-group">
                <label for="emergencynumber">Emergency Contact Number:</label>
                <input type="text" class="form-control" id="emergency_number" placeholder="Enter Emergency Number" name="emergency_number" value="<?php echo $emergency_number; ?>">                          
                <?php echo form_error('emergency_number'); ?> 
            </div>
            <div class="form-group">
                <label for="email">Email ID:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter Email ID" name="email" value="<?php echo $email; ?>">                         
                <?php echo form_error('email'); ?> 
            </div>

            <div class="form-group">
                <label for="class">Class:</label>
                <select class="form-control" id="class_id" name="class_id">
                    <option value="">Select Class</option>
                    <?php
                    foreach ($classes as $class) {
                        ?>
                        <option value="<?php echo $class->class_id; ?>" <?php if ($class_id == $class->class_id) { ?> selected="selected" <?php } ?> ><?php echo $class->class_name; ?></option>
                    <?php } ?>
                </select>
                <?php echo form_error('class_id'); ?> 
            </div>
            <?php if ($student_id != '') { ?>
                <div class="form-group">                        
                    <label for="status">Status</label>
                    <input type="checkbox" name="status" <?php if ($status == 1)  echo "checked"; ?> >
                </div>
<?php } ?>
            <div class="form-group">
                <label for="profileimage">Profile Image:</label>
                <input type="hidden" name="photo" value="<?php echo $profile_image; ?>"> 
                <input type="file" id="profile_image" name="profile_image"  accept=".png, .jpg, .jpeg, .gif" >
                <?php if ($profile_image != '') { ?>
                    <img src="<?php echo base_url('assets/images/students/thumb/' . $profile_image); ?>" />  
                <?php } ?>
                <?php
                echo form_error('profile_image');
                ?> 
            </div>
            <button type="submit" class="btn btn-primary"><?php if (!isset($student->student_id)) { ?> SUBMIT <?php } else { ?> Update <?php } ?></button>
            <button class="btn btn-danger" type="reset">RESET</button>
        </form>
    </div>
</div>
<?php
include_once('footer.php');
?>