<?php
include '../functions/google_fonts.php';
require_once '../functions/functions.php';
require_once '../databases/connect.php';
require_once '../databases/database.class.php';
session_start();

$db = new Database();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date_absent = clean_input(($_POST['date_absent']));
    $comment = clean_input($_POST['comment']);
    $prof_id = clean_input($_POST['Professor']);
    $excuse_letter = clean_input($_POST['excuse_letter']);
    $course_id = clean_input($_POST['course']);
    $user_id = clean_input($_POST['user_id']);
    $section_id = clean_input($_SESSION['section_id']);

    $user->excuse($date_absent, $comment, $prof_id, $excuse_letter, $course_id, $user_id, $section_id);
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
    <link rel="stylesheet" href="hp.css">
   
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
            <a href="#">
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
            <a href="#" class="site-title">Home Page.</a>
        </div>
        <div class="navbar-icons">
          <img src="/excuse-site/images/pacman.jpg" alt="Profile Icon" class="icon-image">
        </div>
    </nav>

     <!-- MAIN/LAMAN NG CONTAINER -->
     <div class="user-p-cont"> 
              <div class="user-profile">
    <img src="/excuse-site/images/pacman.jpg" alt="User Image" class="profile-image">
    <div class="profile-info">
        <h4 class="profile-name" name="name"><?=$_SESSION['last_name'] . ', ' . $_SESSION['first_name'] . ' ' . (!empty($_SESSION['middle_name']) ? $_SESSION['middle_name'] : '') ?></h4>
        <span class="profile-class" name="course"><?=$_SESSION['name']?></span>
    </div>
  </div>

  <div class="subject-container">
    <a class="subject-title">Subjects</a>
    <?php
        $array = $user->get_course();
        $list = $user->get_prof();
        if(empty($array)) { ?>
        <div>
        <h1>No Subjects</h1>
        </div>
    <?php
        }
    ?>
    <?php foreach($array as $arr) { ?>
    <div class="subject-area">
    <i class="fa-solid fa-caret-right"></i>
    <div class="subject-code">
        <?=$arr['acronym']?> | 
    </div>
    <div class="subject-name">
        <?=$arr['name']?>
    </div>
    <button class="letter-button" type="button" data-subject="<?=$arr['acronym']?>">Send a Letter</button>
    </div>
 <!-- Excuse Letter -->
 <div class="modal fade" id="excuseLetterModal" tabindex="-1" aria-labelledby="excuseLetterModalLabel" aria-hidden="true" enctype="multipart/form-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excuseLetterModalLabel">Subject | Excuse Letter Form</h5>
                <button type="button" class="fa-regular fa-circle-xmark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="excuseLetterForm" method="post">
                    <div class="mb-3">
                        <label for="dateOfAbsent" class="form-label">Date of absent:</label>
                        <input type="date" class="form-control scroll-course" id="dateOfAbsent" name='date_absent' required> 
                    </div>

                    <div class="mb-3">
                     <label for="Professor" class="form-label">Professor:</label>
                     <select class="form-select scrollable-dropdown" id="Professor" name="Professor" required>
                        <option value="" disabled selected>Submit to:</option>
                        <?php foreach($list as $li) {?>
                        <option value="<?=$li['ID']?>"><?=$li['last_name']. ', ' . $li['first_name'] . ' ' . (!empty($li['middle_name']) ? $li['middle_name'] : '')?></option>
                        <?php
                        }
                        ?>
                     </select>
                 </div>


                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment:</label>
                        <textarea class="form-control" id="comment" rows="3" name=comment></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="proof" class="form-label">Insert photo of any reliable documents/proof:</label>
                        <input type="file" class="form-control" id="proof" name="excuse_letter" accept="image/*">
                    </div>
                        <input type="hidden" class="course" id="course" name="course" value="<?=$arr['id'];?>">

                        <input type="hidden" class="user_id" id="user_id" name="user_id" value="<?=$_SESSION['ids'];?>">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<!-- JS BANDA -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
     const btn = document.querySelector("#sbtn");
     const sidebar = document.querySelector(".sidebar");
     btn.addEventListener("click", () => {
     sidebar.classList.toggle("active");
    });

    document.querySelectorAll('.letter-button').forEach(button => {
    button.addEventListener('click', (event) => {
        const subjectName = event.currentTarget.getAttribute('data-subject');

        // Update the modal title dynamically without the subject code
        const modalTitle = document.getElementById('excuseLetterModalLabel');
        modalTitle.textContent = `${subjectName} | Excuse Letter Form`;

        // Initialize and show the modal
        const excuseLetterModal = new bootstrap.Modal(document.getElementById('excuseLetterModal'));
        excuseLetterModal.show();
    });
});

    </script>
</body>
</html>
