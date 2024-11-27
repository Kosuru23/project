<?php
include '../functions/google_fonts.php';
session_start();
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
    <link rel="stylesheet" href="facultyStyle.css">
</head>

<body>
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
            <a href="#">
                <i class="fa-solid fa-window-maximize"></i>
                <span class="nav-item">Board</span>
            </a>
        </li>
        <li>
            <a href="../faculty_view/submission.php">
                <i class="fa-solid fa-inbox"></i>
                <span class="nav-item">Submissions</span>
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

<div class="main">
    <nav class="navbar">
        <div class="navbar-brand">
            <a href="#" class="site-title">Home Page.</a>
        </div>
        <div class="navbar-icons">
            <img src="/excuse-site/images/lebron.jpg" alt="Profile Icon" class="icon-image">
        </div>
    </nav>
    <div class="user-p-cont">
        <div class="user-profile">
            <img src="/excuse-site/images/lebron.jpg" alt="User Image" class="profile-image">
            <div class="profile-info">
                <h4 class="profile-name">LeBron James</h4>
                <span class="profile-class">Faculty</span>
            </div>
        </div>

        <div class="subject-container">
            <a class="subject-title">Classes</a>

            <div class="subject-area">
                <i class="fa-solid fa-caret-right"></i>
                <div class="subject-code">Department of</div>
                <div class="subject-name">Computer Science</div>
                <button class="open-button" type="button" onclick="navigateToClass(this)" data-subject="Computer Science">Open</button>
                <span class="pending-badge">
                    <i class="fa-solid fa-clock-rotate-left" title="Pending"></i>
                    <span class="pending-count">0</span>
                </span>
            </div>

            <div class="subject-area">
                <i class="fa-solid fa-caret-right"></i>
                <div class="subject-code">Department of</div>
                <div class="subject-name">Information Technology</div>
                <button class="open-button" type="button" onclick="navigateToClass(this)" data-subject="Information Technology">Open</button>
                <span class="pending-badge">
                    <i class="fa-solid fa-clock-rotate-left" title="Pending"></i>
                    <span class="pending-count">7</span>
                </span>
            </div>

            <div class="subject-area">
                <i class="fa-solid fa-caret-right"></i>
                <div class="subject-code">Department of</div>
                <div class="subject-name">Assistive Computer Tech</div>
                <button class="open-button" type="button" onclick="navigateToClass(this)" data-subject="Assistive Computer Tech">Open</button>
                <span class="pending-badge">
                    <i class="fa-solid fa-clock-rotate-left" title="Pending"></i>
                    <span class="pending-count">2</span>
                </span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    const btn = document.querySelector("#sbtn");
    const sidebar = document.querySelector(".sidebar");
    btn.addEventListener("click", () => {
        sidebar.classList.toggle("active");
    });

    function navigateToClass(button) {
        const subject = button.getAttribute('data-subject');
        window.location.href = `faculty-classes.php?subject=${subject}`;
    }

     document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.letter-button');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const subjectName = this.getAttribute('data-subject');
                // Redirect to faculty-classes.php with the subject name as a query parameter
                window.location.href = `faculty-classes.php?subject=${encodeURIComponent(subjectName)}`;
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.pending-count').forEach(function (pendingCountElement) {
        const pendingCount = parseInt(pendingCountElement.textContent);
        const subjectArea = pendingCountElement.closest('.subject-area');
        if (!subjectArea) return;

        const caretIcon = subjectArea.querySelector('.fa-caret-right');
        if (!caretIcon) return;

        if (pendingCount === 0) {
            pendingCountElement.classList.add('pending-black');
            pendingCountElement.classList.remove('pending-red');
            caretIcon.classList.add('arrow-black');
            caretIcon.classList.remove('arrow-red');
        } else if (pendingCount > 1) {
            pendingCountElement.classList.add('pending-red');
            pendingCountElement.classList.remove('pending-black');
            caretIcon.classList.add('arrow-red');
            caretIcon.classList.remove('arrow-black');
        }
    });
});
</script>
</body>
</html>
