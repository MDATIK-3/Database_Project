<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            transition: background-color 0.3s, color 0.3s;
        }

        body.light-mode {
            background-color: #ffffff;
            color: #000000;
        }

        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
            width: 200px;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card img {
            height: 100px;
            object-fit: contain;
        }

        .card-body {
            text-align: center;
        }

        .dark-mode .card {
            background-color: #333333;
            color: #ffffff;
        }

        .toggle-button {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

             .toggle-button.dark {
            background-color: #6c757d;
        }
    </style>
</head>

<body class="light-mode">
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Student Management System</h1>
        <button class="toggle-button" onclick="toggleDarkMode()">
            <span id="toggle-icon">Dark Mode</span>
        </button>
        <div class="card-container">
            <!-- Cards with links -->
            <a href="administrators.php" class="card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS6-HMunelS1TEUpA8AB1IjvHkv6Kt-wJxJO-t0VBGw5yK3BrRhDwm3Uwpvv5jLAKNc3Dc&usqp=CAU" class="card-img-top"
                    alt="Administrators">
                <div class="card-body">Administrators</div>
            </a>
            <a href="students.php" class="card">
                <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/best-student-2766647-2298018.png?f=webp" class="card-img-top" alt="Students">
                <div class="card-body">Students</div>
            </a>
            <a href="courses.php" class="card">
                <img src="https://cdn-icons-png.flaticon.com/512/7688/7688675.png" class="card-img-top" alt="Courses">
                <div class="card-body">Courses</div>
            </a>
            <a href="show_student_data.php" class="card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTt6JC0xsPt_x9I1DNKkxLQT4_xi81cyP1EVwP1HrYaakF-eiFJug5AWLGvHSh9ergFA1E&usqp=CAU" class="card-img-top"
                    alt="Search any Student">
                <div class="card-body">Search Student</div>
            </a>
            <a href="schedule.php" class="card">
                <img src="https://cdn-icons-png.flaticon.com/512/9934/9934429.png" class="card-img-top"
                    alt="Class Schedule">
                <div class="card-body">Class Schedule</div>
            </a>
            <a href="departments.php" class="card">
                <img src="https://cdn.vectorstock.com/i/500p/64/36/online-education-line-icons-vector-30926436.jpg" class="card-img-top"
                    alt="Departments">
                <div class="card-body">Departments</div>
            </a>
            <a href="fees.php" class="card">
                <img src="https://cdn2.iconfinder.com/data/icons/school-education-set-3/1471/10-education-university-course-fee-admission-money-price-512.png" class="card-img-top" alt="Fees">
                <div class="card-body">Fees</div>
            </a>
            <a href="exams.php" class="card">
                <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/exam-3467501-2901473.png" class="card-img-top" alt="Exams">
                <div class="card-body">Exams</div>
            </a>
            <a href="exam_scores.php" class="card">
                <img src="https://w7.pngwing.com/pngs/438/270/png-transparent-computer-icons-grading-in-education-test-school-quiz-text-logo-university-thumbnail.png" class="card-img-top"
                    alt="Exams Scores">
                <div class="card-body">Exams Scores</div>
            </a>
            <a href="list_attendance.php" class="card">
                <img src="https://media.istockphoto.com/id/1371803904/vector/attendance-icon-students-in-classroom.jpg?s=612x612&w=0&k=20&c=gxaoB-rzMaDhbIljFG8HmV1fT2Ylv7xgWrf7fYY5fE0=" class="card-img-top"
                    alt="Attendance">
                <div class="card-body">Attendance</div>
            </a>
            <a href="list_books.php" class="card">
                <img src="https://cdn-icons-png.freepik.com/512/5351/5351724.png" class="card-img-top" alt="Library">
                <div class="card-body">Library</div>
            </a>
            <a href="borrow_book.php" class="card">
                <img src="https://img.freepik.com/premium-photo/woman-is-painting-picture-book-shelf_662214-120702.jpg" class="card-img-top"
                    alt="Borrowed Books">
                <div class="card-body">Borrowed Books</div>
            </a>
            <a href="return_book.php" class="card">
                <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/return-book-8116776-6636423.png" class="card-img-top"
                    alt="Return Books">
                <div class="card-body">Return Books</div>
            </a>
            <a href="list_enrollments.php" class="card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIp2RDTvsIaXAyP159iNzY5C7KkFRMakj9QQ&s" class="card-img-top"
                    alt="Enrollments">
                <div class="card-body">Enrollments</div>
            </a>
            <a href="list_conducts.php" class="card">
                <img src="data:image/jpeg;base64,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" class="card-img-top" alt="Conducts">
                <div class="card-body">Conducts</div>
            </a>
            <a href="list_adds.php" class="card">
                <img src="https://cdn-icons-png.flaticon.com/512/5065/5065148.png" class="card-img-top" alt="Adds">
                <div class="card-body">Adds</div>
            </a>
            <a href="manages.php" class="card">
                <img src="https://cdn-icons-png.freepik.com/256/8324/8324499.png?semt=ais_hybrid" class="card-img-top" alt="Manages">
                <div class="card-body">Manages</div>
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease-in-out, transform 0.5s ease-in-out';
                    card.style.opacity = 1;
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            const mode = localStorage.getItem('mode');
            const body = document.body;
            const toggleButton = document.querySelector('.toggle-button');
            const toggleIcon = document.getElementById('toggle-icon');
            const toggleText = toggleButton.querySelector('span');

            if (mode === 'dark') {
                body.classList.add('dark-mode');
                toggleButton.classList.add('dark');
                toggleIcon.src = 'https://cdn-icons-png.flaticon.com/512/169/169367.png';
                toggleText.textContent = 'Light Mode';
            }

            toggleButton.addEventListener('click', () => {
                body.classList.toggle('dark-mode');
                toggleButton.classList.toggle('dark');
                if (body.classList.contains('dark-mode')) {
                    localStorage.setItem('mode', 'dark');
                    toggleIcon.src = 'https://cdn-icons-png.flaticon.com/512/169/169367.png';
                    toggleText.textContent = 'Light Mode';
                } else {
                    localStorage.setItem('mode', 'light');
                    toggleIcon.src = 'https://cdn-icons-png.flaticon.com/512/169/169367.png';
                    toggleText.textContent = 'Dark Mode';
                }
            });
        });
    </script>
</body>

</html>