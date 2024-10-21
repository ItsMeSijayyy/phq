document.getElementById("submitBtn").addEventListener("click", function (e) {
    e.preventDefault();  // Prevent the default form submission to calculate first

    // Gather answers from the form
    const answers = [];
    for (let i = 1; i <= 10; i++) {
        const selectedOption = document.querySelector(`input[name="response_${i}"]:checked`);
        if (selectedOption) {
            answers.push(parseInt(selectedOption.value));
        }
    }

    if (answers.length === 10) {
        // Calculate the results
        calculateResults(answers);

        // Add the totalScore and depressionLevel as hidden fields to the form
        const form = document.querySelector('form');

        // Remove any existing hidden fields to avoid duplication
        const existingTotalScore = document.querySelector('input[name="total_score"]');
        const existingDepressionLevel = document.querySelector('input[name="depression_level"]');
        if (existingTotalScore) form.removeChild(existingTotalScore);
        if (existingDepressionLevel) form.removeChild(existingDepressionLevel);

        // Append new hidden fields with calculated values
        form.innerHTML += `<input type="hidden" name="total_score" value="${totalScore}">`;
        form.innerHTML += `<input type="hidden" name="depression_level" value="${depressionLevel}">`;

        // Submit the form after appending the hidden values
        form.submit();
    } else {
        alert("Please answer all questions.");
    }
});

// Function to calculate PHQ-9 results
let totalScore, depressionLevel;
function calculateResults(answers) {
    // Calculate total score
    totalScore = answers.reduce((a, b) => a + b, 0);

    // Determine depression level based on total score
    switch (true) {
        case (totalScore <= 4):
            depressionLevel = 'Minimal depression';
            break;
        case (totalScore >= 5 && totalScore <= 9):
            depressionLevel = 'Mild depression';
            break;
        case (totalScore >= 10 && totalScore <= 14):
            depressionLevel = 'Moderate depression';
            break;
        case (totalScore >= 15 && totalScore <= 19):
            depressionLevel = 'Moderately severe depression';
            break;
        default:
            depressionLevel = 'Severe depression';
            break;
    }
}

// Optional: Modal close functionality
const modal = document.getElementById("resultModal");
const span = document.getElementsByClassName("close")[0];
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
