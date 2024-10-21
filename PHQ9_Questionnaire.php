<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
include 'connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  print_r($_POST);
    // Collect the responses
    $responses = [];
    for ($i = 1; $i <= 10; $i++) {
        if (isset($_POST["response_$i"]) && is_numeric($_POST["response_$i"])) {
            $responses[$i] = (int) $_POST["response_$i"];
        } else {
            echo "Error: Please answer all questions.<br>";
            exit();
        }
    }

    // Calculate total score
    $total_score = array_sum($responses);

    // Determine depression level
    $depression_level = '';
    if ($total_score <= 4) {
        $depression_level = 'Minimal depression';
    } elseif ($total_score <= 9) {
        $depression_level = 'Mild depression';
    } elseif ($total_score <= 14) {
        $depression_level = 'Moderate depression';
    } elseif ($total_score <= 19) {
        $depression_level = 'Moderately severe depression';
    } else {
        $depression_level = 'Severe depression';
    }

    // User ID should be dynamically retrieved, assuming default for now
    $user_id = 1; // Replace this with dynamic user ID

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO phq9_results 
        (user_id, total_score, depression_level, response_1, response_2, response_3, response_4, response_5, response_6, response_7, response_8, response_9, response_10)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Check if prepare was successful
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);  // Display error if query preparation fails
    }

    // Bind parameters and execute the query
    $stmt->bind_param("iissiiiiiiii", $user_id, $total_score, $depression_level,
        $responses[1], $responses[2], $responses[3], $responses[4], $responses[5],
        $responses[6], $responses[7], $responses[8], $responses[9], $responses[10]);

    // Check if execution is successful
    if ($stmt->execute()) {
        echo "Record saved successfully!";
    } else {
        echo "Execute failed: " . $stmt->error;  // Display error if execution fails
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Health Questionnaire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="PHQ9_Questionnaire.css">
</head>
<body>
        <div class="intro">
      <div class="phq-intro">
        <div class="overlap">
          <div class="overlap">
            <img class="nav-bar" src="img/nav-bar.png" />
            <img class="ellipse" src="img/klowi.png" />
            <div class="text-wrapper">Chloe Kate Realin</div>
            <img class="logout" src="img/logout.png" />
            <img class="logo-MINDSOOTHE" src="img/logo-mindsoothe-1.png" />
            <div class="search-bar">
              <div class="group">
                <div class="overlap-group-wrapper">
                  <div class="overlap-group">
                    <div class="div">Search Mindsoothe</div>
                    <img class="search-ICON" src="img/search.png" />
                  </div>
                </div>
              </div>
            </div>
            <p class="mental-wellness">
              <span class="span">Mental Wellness</span> <span class="text-wrapper-2"> Companion</span>
            </p>
            <div class="mini-side-bar">
              <img class="frame" src="img/frame-3.svg" /> <img class="mini" src="img/mini.png" />
            </div>
            <div class="date-picker">
              <div class="base-calendar">
                <div class="date-header">
                  <img class="chevron" src="img/chevron-8.svg" />
                  <div class="div-2">
                    <div class="december-wrapper"><div class="december">May</div></div>
                    <div class="div-2"><div class="element">2024</div></div>
                  </div>
                  <img class="chevron" src="img/chevron-9.svg" />
                </div>
                <div class="frame-2">
                  <div class="frame-3">
                    <div class="work-day"><div class="th">Sun</div></div>
                    <div class="work-day"><div class="th-2">Mon</div></div>
                    <div class="work-day"><div class="th-2">Tue</div></div>
                    <div class="work-day"><div class="th-2">Wed</div></div>
                    <div class="work-day"><div class="th-2">Thu</div></div>
                    <div class="work-day"><div class="th-2">Fri</div></div>
                    <div class="work-day"><div class="th">Sat</div></div>
                  </div>
                  <div class="frame-2">
                    <div class="frame-3">
                      <div class="calendar-date"></div>
                      <div class="calendar-date"></div>
                      <div class="calendar-date"></div>
                      <div class="calendar-date"></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">1</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">2</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">3</div></div>
                    </div>
                    <div class="frame-3">
                      <div class="calendar-date-2"><div class="element-2">4</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">5</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">6</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">7</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">8</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">9</div></div>
                      <div class="calendar-date-2"><div class="element-2">10</div></div>
                    </div>
                    <div class="frame-3">
                      <div class="calendar-date-2"><div class="element-2">11</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">23</div></div>
                      <div class="calendar-date-2">
                        <div class="text-wrapper-3">13</div>
                        <div class="ellipse-2"></div>
                      </div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">14</div></div>
                      <div class="element-wrapper"><div class="element-3">15</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">16</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">17</div></div>
                    </div>
                    <div class="frame-3">
                      <div class="calendar-date-2"><div class="text-wrapper-3">18</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">19</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">20</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-3">21</div></div>
                      <div class="calendar-date-3">
                        <div class="text-wrapper-4">22</div>
                        <div class="ellipse-3"></div>
                      </div>
                      <div class="calendar-date-2"><div class="text-wrapper-4">23</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-4">24</div></div>
                    </div>
                    <div class="frame-3">
                      <div class="calendar-date-2"><div class="text-wrapper-4">25</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-4">26</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-4">27</div></div>
                      <div class="calendar-date-2"><div class="text-wrapper-4">28</div></div>
                      <div class="calendar-date-4">
                        <div class="text-wrapper-4">29</div>
                        <div class="ellipse-4"></div>
                      </div>
                      <div class="div-wrapper"><div class="text-wrapper-4">30</div></div>
                      <div class="calendar-date"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="overlap-2">
            <div class="frame-4">
              <img class="subs-free-card" src="img/subs-free-card-4.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="dr-pic" src="img/dr-pic-2.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Janine Karla</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-11">
              <img class="subs-free-card" src="img/subs-free-card-5.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="image" src="img/image-23.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Jeanne Denise</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-12">
              <img class="subs-free-card" src="img/subs-free-card-6.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="image" src="img/image-23.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Jeanne Denise</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-13">
              <img class="subs-free-card" src="img/subs-free-card-7.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="image" src="img/image-23.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Jeanne Denise</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-14">
              <img class="subs-free-card" src="img/subs-free-card-8.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="dr-pic" src="img/dr-pic-2.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Janine Karla</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-15">
              <img class="subs-free-card" src="img/subs-free-card-9.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="image" src="img/image-23.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Jeanne Denise</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-16">
              <img class="subs-free-card" src="img/subs-free-card-10.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="dr-pic" src="img/dr-pic-2.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Janine Karla</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-17">
              <img class="subs-free-card" src="img/subs-free-card-11.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="image" src="img/image-23.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Jeanne Denise</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-18">
              <img class="subs-free-card" src="img/subs-free-card-12.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="image" src="img/image-23.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Jeanne Denise</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-19">
              <img class="subs-free-card" src="img/subs-free-card-13.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="image" src="img/image-23.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Jeanne Denise</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-20">
              <img class="subs-free-card" src="img/subs-free-card-14.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="image" src="img/image-23.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Jeanne Denise</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            <div class="frame-21">
              <img class="subs-free-card" src="img/subs-free-card-15.svg" />
              <div class="frame-5">
                <div class="frame-6">
                  <div class="frame-7">
                    <img class="image" src="img/image-23.png" />
                    <div class="frame-8">
                      <div class="text-wrapper-5">Jeanne Denise</div>
                      <div class="licensed-mental">Licensed Mental Health Counselor</div>
                      <div class="text-wrapper-6">9 years of experience</div>
                    </div>
                  </div>
                  <div class="frame-7">
                    <div class="frame-9"><div class="text-wrapper-7">Stress</div></div>
                    <div class="frame-9"><div class="text-wrapper-7">Anxiety</div></div>
                    <div class="frame-9"><div class="text-wrapper-8">Depression</div></div>
                  </div>
                </div>
                <div class="frame-10"><div class="text-wrapper-9">View Profile</div></div>
              </div>
            </div>
            </div>
            <div class="overlap-wrapper">
              <div class="overlap-3">
                <p class="instructions-for">
                  <br>
                  <br>
                  <span class="text-wrapper-10">Instructions for Completing the PHQ-9 Questionnaire</span>
                  <span class="text-wrapper-11">
                    <br>
                    <br>1. Answer Each Question: For each question, mark how often you have <br />experienced each issue in
                    the last two weeks:<br>• Not at all<br>• Several
                    days<br>• More than half the days<br>• Nearly every day<br /><br>2.
                    Question 10: Indicate how difficult these problems have made it to do<br />your work, take care of
                    things at home, or get along with others:<br>• Not difficult at
                    all<br>• Somewhat difficult<br>• Very
                    difficult<br>• Extremely difficult<br /><br>3. Seek Help if Needed: If you have
                    thoughts of self-harm (question 9),<br />please talk to a healthcare professional immediately.</span>
                </p>
                <p class="patient-health">
                  <span class="span">Patient </span>
                  <span class="text-wrapper-2">Health</span>
                  <span class="span">Questionnaire</span>
                </p>
                <div class="start-btn">
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal1">
                    Start
                  </button>
                </div>         
              </div>
            </div>
          </div>
          <img class="chat" src="img/chat.png" />
          <div class="friends">
            <div class="frame-22">
              <div class="frame-23">
                <div class="text-wrapper-13">Friends</div>
                <img class="line" src="img/line-15.svg" />
              </div>
            </div>
            <div class="frame-wrapper">
              <div class="frame-24">
                <div class="frame-25">
                  <img class="img" src="img/gabeitch.png" />
                  <div class="text-wrapper-14">Gabe Itch</div>
                </div>
                <div class="frame-25">
                  <img class="img" src="img/dinalega.png" />
                  <div class="text-wrapper-14">Dina Lega</div>
                </div>
                <div class="frame-25">
                  <img class="eeccf-fbb-b" src="img/dems.png" />
                  <div class="text-wrapper-14">Denise Jeanne</div>
                </div>
                <div class="frame-25">
                  <img class="img" src="img/carlos.png" />
                  <div class="text-wrapper-14">Carlos Joaquin</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <img class="rectangle" src="img/rectangle-60.png" />
      </div>
    </div>

  <!-- Modal -->

  <div class="modal" id="modal1" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form method="POST" action="PHQ9_Questionnaire.php">
            <div class="mb-4">
              <h6>1. Little interest or pleasure in doing things</h6>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_1" id="notAtAll1" value="0">
                <label class="form-check-label" for="notAtAll1">
                  Not at all
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_1" id="severalDays1" value="1">
                <label class="form-check-label" for="severalDays1">
                  Several days
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_1" id="moreThanHalf1" value="2">
                <label class="form-check-label" for="moreThanHalf1">
                  More than half the day
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_1" id="nearlyEveryday1" value="3">
                <label class="form-check-label" for="nearlyEveryday1">
                  Nearly every day
                </label>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Previous</button>
              <div class="next-btn">
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal2">Next</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modal2" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-4">
              <h6>2. Feeling down, depressed, or hopeless</h6>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_2" id="notAtAll2" value="0">
                <label class="form-check-label" for="notAtAll2">
                  Not at all
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_2" id="severalDays2" value="1">
                <label class="form-check-label" for="severalDays2">
                  Several days
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_2" id="moreThanHalf2" value="2">
                <label class="form-check-label" for="moreThanHalf2">
                  More than half the day
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_2" id="nearlyEveryday2" value="3">
                <label class="form-check-label" for="nearlyEveryday2">
                  Nearly every day
                </label>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal1">Previous</button>
              <div class="next-btn">
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal3">Next</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modal3" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-4">
              <h6>3. Trouble falling or staying asleep, or sleeping too much</h6>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_3" id="notAtAll3" value="0">
                <label class="form-check-label" for="notAtAll3">
                  Not at all
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_3" id="severalDays3" value="1">
                <label class="form-check-label" for="severalDays3">
                  Several days
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_3" id="moreThanHalf3" value="2">
                <label class="form-check-label" for="moreThanHalf3">
                  More than half the day
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="response_3" id="nearlyEveryday3" value="3">
                <label class="form-check-label" for="nearlyEveryday3">
                  Nearly every day
                </label>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal2">Previous</button>
              <div class="next-btn3">
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal4">Next</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="modal" id="modal4" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <h6>4. Feeling tired or having little energy</h6>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_4" id="notAtAll4" value="0">
              <label class="form-check-label" for="notAtAll4">
                Not at all
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_4" id="severalDays4" value="1">
              <label class="form-check-label" for="severalDays4">
                Several days
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_4" id="moreThanHalf4" value="2">
              <label class="form-check-label" for="moreThanHalf4">
                More than half the day
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_4" id="nearlyEveryday4" value="3">
              <label class="form-check-label" for="nearlyEveryday4">
                Nearly every day
              </label>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal3">Previous</button>
            <div class="next-btn">
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal5">Next</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal5" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <h6>5. Poor appetite or overeating</h6>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_5" id="notAtAll5" value="0">
              <label class="form-check-label" for="notAtAll5">
                Not at all
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_5" id="severalDays5" value="1">
              <label class="form-check-label" for="severalDays5">
                Several days
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_5" id="moreThanHalf5" value="2">
              <label class="form-check-label" for="moreThanHalf5">
                More than half the day
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_5" id="nearlyEveryday5" value="3">
              <label class="form-check-label" for="nearlyEveryday5">
                Nearly every day
              </label>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal4">Previous</button>
            <div class="next-btn">
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal6">Next</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal6" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <h6>6. Feeling bad about yourself or that 
              you are a failure or have let yourself 
              or your family down.</h6>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_6" id="notAtAll6" value="0">
              <label class="form-check-label" for="notAtAll6">
                Not at all
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_6" id="severalDays6" value="1">
              <label class="form-check-label" for="severalDays6">
                Several days
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_6" id="moreThanHalf6" value="2">
              <label class="form-check-label" for="moreThanHalf6">
                More than half the day
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_6" id="nearlyEveryday6" value="3">
              <label class="form-check-label" for="nearlyEveryday6">
                Nearly every day
              </label>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal5">Previous</button>
            <div class="next-btn6">
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal7">Next</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal7" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <h6>7. Trouble concentrating on things, such 
              as reading the newspaper or watching 
              television.</h6>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_7" id="notAtAll7" value="0">
              <label class="form-check-label" for="notAtAll7">
                Not at all
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_7" id="severalDays7" value="1">
              <label class="form-check-label" for="severalDays7">
                Several days
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_7" id="moreThanHalf7" value="2">
              <label class="form-check-label" for="moreThanHalf7">
                More than half the day
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_7" id="nearlyEveryday7" value="3">
              <label class="form-check-label" for="nearlyEveryday7">
                Nearly every day
              </label>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal6">Previous</button>
            <div class="next-btn7">
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal8">Next</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal8" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <h6>8. Moving or speaking so slowly that other people 
              could have noticed. Or the opposite being so fidgety 
              or restless that you have been moving around a lot 
              more than usual.</h6>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_8" id="notAtAll8" value="0">
              <label class="form-check-label" for="notAtAll8">
                Not at all
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_8" id="severalDays8" value="1">
              <label class="form-check-label" for="severalDays8">
                Several days
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_8" id="moreThanHalf8" value="2">
              <label class="form-check-label" for="moreThanHalf8">
                More than half the day
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_8" id="nearlyEveryday8" value="3">
              <label class="form-check-label" for="nearlyEveryday8">
                Nearly every day
              </label>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal7">Previous</button>
            <div class="next-btn8">
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal9">Next</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal9" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <h6>9. Thoughts that you would be better off dead, 
              or of hurting yourself.</h6>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_9" id="notAtAll9" value="0">
              <label class="form-check-label" for="notAtAll9">
                Not at all
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_9" id="severalDays9" value="1">
              <label class="form-check-label" for="severalDays9">
                Several days
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_9" id="moreThanHalf9" value="2">
              <label class="form-check-label" for="moreThanHalf9">
                More than half the day
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_9" id="nearlyEveryday9" value="3">
              <label class="form-check-label" for="nearlyEveryday9">
                Nearly every day
              </label>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal8">Previous</button>
            <div class="next-btn9">
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal10">Next</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal10" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"><strong>Patient <span class="text-wrapper-15">Health</span> Questionnaire</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <h6>10. If you checked off any problems, how difficult have 
              these problems made it for you to do your work, take 
              care of things at home, or get along with other people?</h6>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_10" id="notAtAll10" value="0">
              <label class="form-check-label" for="notAtAll10">
                Not at all
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_10" id="severalDays10" value="1">
              <label class="form-check-label" for="severalDays10">
                Several days
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_10" id="moreThanHalf10" value="2">
              <label class="form-check-label" for="moreThanHalf10">
                More than half the day
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="response_10" id="nearlyEveryday10" value="3">
              <label class="form-check-label" for="nearlyEveryday10">
                Nearly every day
              </label>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal9">Previous</button>
            <div class="submit-btn">
              <button type="submit" class="btn" id="submitBtn" data-bs-target="#resultModal">Submit</button>
            </div>
          </form>
          
              <!-- Modal -->
    <div id="resultModal" class="modal">
      <div class="modal-content0">
          <span class="close">&times;</span>
          <h2>Results Summary</h2>
           <!-- Total score and depression level -->
        <p>Total Score: <span id="totalScore"></span></p>
        <p>Depression Level: <span id="depressionLevel"></span></p>

        <!-- Summary counts for responses -->
        <div class="result-summary">
            <h3>Summary of Responses:</h3>
            <table class="summary-table">
                <tr>
                    <th>Not at all</th>
                    <td id="notAtAllCount"></td>
                </tr>
                <tr>
                    <th>Several days</th>
                    <td id="severalDaysCount"></td>
                </tr>
                <tr>
                    <th>More than half the days</th>
                    <td id="halfDaysCount"></td>
                </tr>
                <tr>
                    <th>Nearly every day</th>
                    <td id="nearlyEveryDayCount"></td>
                </tr>
            </table>
        </div>
    </div>
</div>

          
    <script src="result.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
          integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</html>