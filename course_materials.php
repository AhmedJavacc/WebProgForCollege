<!DOCTYPE html>
<?php

include_once 'service/MaterialsService.php';
include_once 'service/SectionsService.php';
include_once 'service/CoursesService.php';
include_once 'model/constantss.php';
include_once 'function.php';
session_start();

if (validate_session_time_out() == 0) {

    header("Location:login.php");
    exit();
}
if ($_SESSION['change_password'] == 0) {
    header("Location:change_password.php");
    exit();
}
if (un_hash_val($_SESSION['current_user_type']) == constantss::$user_type_admin) {
    header("Location:manage_courses.php");
    exit();
}
$course_id = un_hash_val($_GET['course']);
$hashed_course_id = $_GET['course'];

$MaterialsService = new MaterialsService($course_id);
$SectionsService = new SectionsService();
$CourseService = new CoursesService();

$_SESSION['material_service'] = serialize($MaterialsService);
$_SESSION['section_service'] = serialize($SectionsService);
$sections = $SectionsService->get_all_sections();
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
    </head>
    <body >
        <br>
        <?php include 'header.php'; ?>
        <br>
        <div class="container">
            <h1><p class="bg-primary"> <?php echo $CourseService->get_course($course_id)->get_course_name(); ?> </p></h1>
            <!-- Button trigger modal -->

            <p  class="text-primary"><span id="uploading_files_id" class="badge"></span></p>

            <?php foreach ($sections as $section): ?>
                <br>
                <?php if (un_hash_val($_SESSION['current_user_type']) == constantss::$user_type_instructor) { ?>
                    <button id=<?php echo '"' . $section->get_button_id() . '"'; ?> type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <?php echo $section->get_button_name(); ?> 
                    </button>
                <?php } ?> 
                <br>
                <div id=<?php echo '"' . $section->get_button_id() . '_container"'; ?>>
                    <div class="panel panel-primary"  id=<?php echo '"' . $section->get_button_id() . '_panel"'; ?>>

                        <div class="panel-heading">

                            <?php echo $section->get_section_name(); ?> </div>
                        <div class="panel-body">  
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Resource</th>
                                        <th>Upload Date</th>
                                        <?php if (un_hash_val($_SESSION['current_user_type']) == constantss::$user_type_instructor) { ?>
                                            <th>Operations</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $materials = $MaterialsService->get_materials_of_section($section->get_section_id()) ?>
                                    <?php foreach ($materials as $material): ?>
                                        <tr>

                                            <td><a href=<?php echo '"download.php?file=' . urlencode($material->get_full_path_file()) . '"'; ?>><?php print $material->get_file_name(); ?></a></td>
                                            <td><?php print htmlentities($material->get_add_date()); ?></td>
                                            <?php if (un_hash_val($_SESSION['current_user_type']) == constantss::$user_type_instructor) { ?>
                                                <td><a href=<?php echo '"delete.php?section_id=' . htmlentities($material->get_section_id()) . '&file=' . urlencode($material->get_file_name()) . '"'; ?> class ="btn btn-primary">delete</a></td>
                                            <?php } ?>
                                        </tr>


                                    <?php endforeach; ?>
                                </tbody>
                            </table>


                        </div>

                    </div>
                </div>               
            <?php endforeach; ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Add Data</h4>
                        </div>
                        <div class="modal-body">

                            <form name="ddd">

                                <input type="file" name="file" id="txt" />
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" id="save" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>    
            <div id="info"></div>
            <br/>
            <div id="viewdata"></div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script>
            $(function () {
                uploading_files = 0;
                section_ids = [];
                section_id = 0;
                function print_uploading_files() {
                    if (uploading_files > 1) {
                        return "uploading " + uploading_files + " files.";
                    } else if (uploading_files == 1) {
                        return "uploading " + uploading_files + " file.";

                    } else if (uploading_files == 0) {
                        return "";
                    }
                }
<?php foreach ($sections as $section): ?>
                    $(<?php echo '\'#' . $section->get_button_id() . '\''; ?>).click(function (e) {
                        section_id =<?php echo $section->get_section_id(); ?>;
                        section_ids.push(section_id);
                        document.getElementById("myModalLabel").innerHTML = <?php echo "\"" . $section->get_button_name() . "\""; ?>;
                        //                    alert("sss");
                    });
<?php endforeach; ?>

                $('#save').click(function (e) {

                    uploading_files++;

                    $("#uploading_files_id").html(print_uploading_files());

                    var fd = new FormData(document.querySelector('form'));
                    fd.append("section_id", section_id);

                    $.ajax({
                        url: "upload.php",
                        type: "POST",
                        data: fd,
                        processData: false, // tell jQuery not to process the data
                        contentType: false, // tell jQuery not to set contentType
                        complete: function (data) {
                            if (uploading_files > 1) {
                                uploading_files--;
                                $("#uploading_files_id").html(print_uploading_files());

                            } else {

                                uploading_files = 0;
                                $("#uploading_files_id").html(print_uploading_files());
                                for (index = 0; index < section_ids.length; index++) {
<?php foreach ($sections as $section): ?>

                                        if (section_ids[index] == <?php echo $section->get_section_id(); ?>) {

                                            $(<?php echo "\"#" . $section->get_button_id() . "_container\""; ?>).load(<?php echo "\"course_materials.php?course=$hashed_course_id #" . $section->get_button_id() . "_panel\""; ?>);
                                        }


<?php endforeach; ?>
                                }
                                section_ids = [];
                            }


                        }
                    });
                });
            });
        </script>
    </body>
</html> 
