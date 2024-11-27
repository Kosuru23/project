<?php
include '../functions/google_fonts.php';
require_once '../functions/functions.php';
require_once '../databases/connect.php';
require_once '../databases/database.class.php';
session_start();

$db = new Database();
$user = new User($db);

$id = $_SESSION['ids'];
$submissions = $user->excuse_letters($id);
$list = $user->get_prof();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $excuse_letter_id = clean_input($_POST['id']);
    $date_absent = clean_input($_POST['date_of_absent']);
    $comment = clean_input($_POST['comment']);
    $prof_id = clean_input($_POST['prof']);
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        // File was uploaded successfully, get the file content (binary data)
        $excuse_letter = file_get_contents($_FILES['photo']['tmp_name']);
    } else {
        // No file uploaded, set $excuse_letter to null
        $excuse_letter = null;
    }

    $user->edit($excuse_letter_id, $date_absent, $comment, $prof_id, $excuse_letter);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexuse</title>

    <?php 
    includeGoogleFont([
        'Josefin Sans:ital,wght@0,100..700;1,100..700', 
        'Poppins:wght@400;600'
    ]); 
    ?>

    <script src="https://kit.fontawesome.com/3c9d5fece1.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="submissionsStyle.css">

</head>
<body>
       <!-- SIDEBAR AREA -->
     <div class="sidebar">
        <div class="top">
            <div class="logo">
                <img src="/excuse-site/images/Nexuse.svg" class="cat">
                <span class="text-cat">Nexuse.</span>
            </div>
            <i class="fa-solid fa-bars" id="sbtn"></i>
        </div>
        <ul class="sidebar-icons">
    <li>
        <a href="../student-view/test.php">
            <i class="fa-solid fa-house-chimney-user"></i>
            <span class="nav-item">Home</span>
        </a>
    </li>
    <li>
        <a href="../student-view/submissions.php">
            <i class="fa-solid fa-inbox"></i>
            <span class="nav-item">Submissions</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fa-solid fa-book"></i>
            <span class="nav-item">Course</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fa-solid fa-gear"></i>
            <span class="nav-item">Settings</span>
        </a>
    </li>
    <li>
        <a href="../login/logout.php">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span class="nav-item">Logout</span>
        </a>
    </li>
</ul>
</div>
<!-- NAVBAR TO -->
<div class="main">
       <nav class="navbar">
        <div class="navbar-brand">
            <a href="#" class="site-title">Submissions</a>
        </div>
        <div class="navbar-icons">
          <img src="/excuse-site/images/pacman.jpg" alt="Profile Icon" class="icon-image">
        </div>
</nav>
<div class="user-p-cont"> 
              <div class="user-profile">
    <img src="/excuse-site/images/pacman.jpg" alt="User Image" class="profile-image">
    <div class="profile-info">
        <h4 class="profile-name" name="name"><?=$_SESSION['last_name'] . ', ' . $_SESSION['first_name'] . ' ' . (!empty($_SESSION['middle_name']) ? $_SESSION['middle_name'] : '') ?></h4>
        <span class="profile-class" name="course"><?=$_SESSION['name']?></span>
    </div>
  </div>
<div class="container mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subject</th> 
                    <th>Professor</th>
                    <th>Date of Absent</th>
                    <th>Date of Submission</th>
                    <th>Comment</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
               <?php

                    
                    if(empty($submissions)) { ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No Excuse Letter Submitted</td>
                    </tr>
                <?php  }
                    foreach ($submissions as $submission) { ?>
                       <tr>
                           <td><?= clean_input($submission['acronym']) ?></td>
                           <td><?= clean_input($submission['professors_name']) ?></td>
                           <td><?= clean_input($submission['date_absent']) ?></td>
                           <td><?= clean_input($submission['date_submitted']) ?></td>
                           <td><?= clean_input($submission['comment']) ?></td>
                           <td>
                               <img src='<?=clean_input($submission['excuse_letter'])?>' alt='Photo' class='img-thumbnail' style='width:50px;' cursor:pointer; data-bs-toggle='modal' data-bs-target='#photoModal' data-photo='<?=$submission['excuse_letter']?>'>
                           </td>
                           <td>
                               <button class='edit-button' 
                                       data-bs-toggle='modal' 
                                       data-bs-target='#excuseLetterModal' 
                                       data-id='<?=$submission['id']?>' 
                                       data-course='<?=$submission['professors_name']?>' 
                                       data-date-absent='<?=$submission['date_absent']?>' 
                                       data-comment='<?=$submission['comment']?>'>
                                   <i class='fa-regular fa-pen-to-square'></i>
                               </button>
                             <button class='delete-button' 
                                     data-bs-toggle='modal' 
                                     data-bs-target='#deleteModal' 
                                     data-id='<?=$submission['id']?>' 
                                     data-course='<?=$submission['professors_name']?>' 
                                     data-date-absent='<?=$submission['date_absent']?>' 
                                     data-comment='<?=$submission['comment']?>'>
                                 <i class='fa-regular fa-trash-can'></i>
                              </button>
                           </td>
                       </tr>
                <?php   
                  }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Edit Modal -->
  <div class="modal fade" id="excuseLetterModal" tabindex="-1" aria-labelledby="excuseLetterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excuseLetterModalLabel">Edit Submission ✎</h5>
                <button type="button" class="fa-regular fa-circle-xmark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSubmissionForm" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="editId" name="id">
                        <label for="professor" class="form-label">Professor:</label>
                        <select class="form-select" id="professor" name="prof" required>
                        <option value="" disabled selected>Submit to:</option>
                            <?php foreach($list as $li) {?>
                                <option value="<?=$li['ID']?>"><?=$li['last_name']. ', ' . $li['first_name'] . ' ' . (!empty($li['middle_name']) ? $li['middle_name'] : '')?></option>
                            <?php
                            }
                        ?>
                        </select>
                    </div>

                    <!-- Date of Absence -->
                    <div class="mb-3">
                        <label for="editDateOfAbsent" class="form-label">Date of Absent:</label>
                        <input type="date" class="form-control" id="editDateOfAbsent" name="date_of_absent" required>
                    </div>

                    <!-- Comment Textarea -->
                    <div class="mb-3">
                        <label for="editComment" class="form-label">Comment:</label>
                        <textarea class="form-control" id="editComment" name="comment" rows="3"></textarea>
                    </div>
                    
                    <!-- Photo -->
                    <div class="mb-3">
                        <label for="editPhoto" class="form-label">Photo:</label>
                        <small class="form-text text-muted">Upload a new photo to change (optional).</small>
                        <input type="file" class="form-control" id="editPhoto" name="photo" accept="image/*">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Pop up yung -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Photo of a documents/proof</h5>
                <button type="button" class="fa-regular fa-circle-xmark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img id="modalPhoto" src="" alt="Full Image" class="img-fluid w-100 h-100" style="object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion 🗑</h5>
                <button type="button" class="fa-regular fa-circle-xmark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this submission?</p>
                <ul>
                    <li><strong>Course and Year Level:</strong> <span id="deleteCourse"></span></li>
                    <li><strong>Date of Absent:</strong> <span id="deleteDateAbsent"></span></li>
                    <li><strong>Comment:</strong> <span id="deleteComment"></span></li>
                    <div class="text-center mt-3">
                    <img id="deletePhoto" src="" alt="Photo Preview" class="img-thumbnail" style="max-width: 150px;">
                    </div>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

     <script>
    // sidebar burger button
    const btn = document.querySelector("#sbtn");
     const sidebar = document.querySelector(".sidebar");
     btn.addEventListener("click", () => {
     sidebar.classList.toggle("active");
    });
 
    // modal para sa edit submission (not working properly)
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('excuseLetterModal'));

        const editButtons = document.querySelectorAll('.edit-button');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const professor = this.getAttribute('professor');
                const dateAbsent = this.getAttribute('data-date-absent');
                const comment = this.getAttribute('data-comment');

                document.getElementById('professor').value = professor;
                document.getElementById('editDateOfAbsent').value = dateAbsent;
                document.getElementById('editComment').value = comment;
                document.getElementById('editId').value = id;
            });
        });

        const form = document.getElementById('editSubmissionForm');
        form.addEventListener('submit', function (event) {
            // event.preventDefault();
            this.submit();
            
            // Get updated data from the form
            const updatedId = document.getElementById('editId').value;
            const updatedCourse = document.getElementById('professor').value;
            const updatedDateAbsent = document.getElementById('editDateOfAbsent').value;
            const updatedComment = document.getElementById('editComment').value;
            const updatedPhoto = document.getElementById('editPhoto').files[0]; // di ko na alam pag iupdate photo 

            console.log('Updated Data:', {
                id: updatedId,
                course: updatedCourse,
                date_absent: updatedDateAbsent,
                comment: updatedComment ,

            });

            // modal.hide();
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const photoModal = document.getElementById('photoModal');
        const modalPhoto = document.getElementById('modalPhoto');

        // Add event listeners to all thumbnails
        document.querySelectorAll('.photo-thumbnail').forEach(thumbnail => {
            thumbnail.addEventListener('click', function () {
                const photoSrc = this.getAttribute('data-photo');
                modalPhoto.setAttribute('src', photoSrc);
            });
        });
    });

    // delete confimation 
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const deleteButtons = document.querySelectorAll('.delete-button');

        const deleteCourseElement = document.getElementById('deleteCourse');
        const deleteDateAbsentElement = document.getElementById('deleteDateAbsent');
        const deleteCommentElement = document.getElementById('deleteComment');
        const deletePhotoElement = document.getElementById('deletePhoto');
        const confirmDeleteButton = document.getElementById('confirmDelete');

        let rowToDelete = null;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const course = this.getAttribute('data-course');
                const dateAbsent = this.getAttribute('data-date-absent');
                const comment = this.getAttribute('data-comment');
                
                // Fetch the photo URL from the 'img' element in the same <tr>
                const photo = this.closest('tr').querySelector('.photo-thumbnail').getAttribute('src');

                // Populate the modal with the data
                deleteCourseElement.textContent = course;
                deleteDateAbsentElement.textContent = dateAbsent;
                deleteCommentElement.textContent = comment;
                deletePhotoElement.setAttribute('src', photo);

                // Store the row for deletion
                rowToDelete = this.closest('tr');
            });
        });

        confirmDeleteButton.addEventListener('click', function () {
            if (rowToDelete) {
                // Remove the row from the table
                rowToDelete.remove();

                // Hide the modal
                deleteModal.hide();

                // Perform additional actions here (e.g., send a request to the server to delete from the database)
                console.log('Deleted entry with details:', {
                    course: deleteCourseElement.textContent,
                    date_absent: deleteDateAbsentElement.textContent,
                    comment: deleteCommentElement.textContent,
                    photo: deletePhotoElement.getAttribute('src')
                });
            }
        });
    });

    </script>
</body>
</html>