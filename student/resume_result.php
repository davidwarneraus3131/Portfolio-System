<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit;
}

include('../includes/header.php');

if (!isset($_SESSION['ats_score'], $_SESSION['selected_role'], $_SESSION['missing_skills'])) {
    die("No analysis data available.");
}

$role = $_SESSION['selected_role'];
$score = $_SESSION['ats_score'];
$missingSkills = $_SESSION['missing_skills'];
$optimizedSkills = 100 - $score;

// Skill improvement suggestions based on role
$skillRecommendations = [
    "Web Developer" => [
        "JavaScript" => "Learn ES6+, work on React/Node.js projects.",
        "CSS" => "Master Flexbox & Grid, practice UI animations.",
        "SQL" => "Understand indexing, normalization & JOIN queries."
    ],
    "Software Engineer" => [
        "Data Structures" => "Study algorithms, solve LeetCode problems.",
        "OOP Principles" => "Practice SOLID principles & design patterns.",
        "System Design" => "Learn microservices, caching & API scalability."
    ],
    "Data Analyst" => [
        "Python" => "Practice Pandas, NumPy & Matplotlib.",
        "SQL" => "Master window functions & complex queries.",
        "Data Visualization" => "Improve Tableau & Power BI skills."
    ],
    "PHP Developer" => [
        "Laravel" => "Learn MVC architecture & Eloquent ORM.",
        "Security" => "Implement SQL injection & XSS protection.",
        "API Development" => "Build RESTful APIs & integrate third-party APIs."
    ]
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATS Resume Score</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container_res {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            text-align: center;
        }
        canvas {
            margin-top: 20px;
        }
        .retry-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .retry-btn:hover {
            background-color: #0056b3;
        }
        .skills-box {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body class="bg-gray-100">

<br><br>
<div class="container_res">
    <h2 class="text-xl font-semibold text-gray-800">Your ATS Resume Score for <b><?php echo htmlspecialchars($role); ?></b></h2>
    <h3 class="text-2xl font-bold text-blue-600"><?php echo round($score, 2); ?>%</h3>

    <canvas id="resumeChart"></canvas>

   

    <?php if (!empty($missingSkills)) : ?>
        <h3 class="text-lg font-semibold text-red-600 mt-4">🔹 Missing Skills:</h3>
        <ul class="text-gray-700">
            <?php foreach ($missingSkills as $skill) : ?>
                <li class="skills-box">
                    <b><?php echo htmlspecialchars($skill); ?></b>
                    <?php 
                        if (isset($skillRecommendations[$role][$skill])) {
                            echo "<br>💡 Suggestion: " . $skillRecommendations[$role][$skill];
                        }
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="text-green-600 font-semibold">✅ Your resume is well-optimized for the role!</p>
    <?php endif; ?>

    <a href="ats_checker.php" class="retry-btn">Try Another Resume</a>
</div>

<script>
    var ctx = document.getElementById('resumeChart').getContext('2d');
    var resumeChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Optimized Skills', 'Missing Skills'],
            datasets: [{
                data: [<?php echo $score; ?>, <?php echo $optimizedSkills; ?>],
                backgroundColor: ['#28a745', '#dc3545'],
                hoverOffset: 6,
                borderWidth: 2
            }]
        },
        options: {
            animation: {
                duration: 2500,
                easing: 'easeInOutQuad'
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
</script>

</body>
</html>
