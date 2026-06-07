<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz en cours</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .quiz-header {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .progress-info {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }
        .timer {
            font-size: 24px;
            font-weight: 700;
            color: #8b5cf6;
        }
        .question-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .question-number {
            color: #8b5cf6;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .question-text {
            font-size: 20px;
            color: #1f2937;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .options {
            display: grid;
            gap: 15px;
        }
        .option {
            background: #f9fafb;
            padding: 18px 24px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .option:hover {
            border-color: #8b5cf6;
            background: #f3f0ff;
        }
        .option input[type="radio"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .option label {
            flex: 1;
            cursor: pointer;
            font-size: 16px;
            color: #374151;
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 16px 40px;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
        }
        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="quiz-header">
            <div class="progress-info">
                <i class="fas fa-clipboard-list"></i>
                Quiz Code de la Route
            </div>
            <div class="timer" id="timer">00:00</div>
        </div>

        <form method="POST" action="index.php?page=quiz-soumettre" id="quizForm">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question-card">
                    <div class="question-number">Question <?= $index + 1 ?>/<?= count($questions) ?></div>
                    <div class="question-text"><?= htmlspecialchars($question['question']) ?></div>
                    
                    <div class="options">
                        <div class="option">
                            <input type="radio" name="question_<?= $index ?>" value="A" id="q<?= $index ?>_a" required>
                            <label for="q<?= $index ?>_a">
                                <strong>A.</strong> <?= htmlspecialchars($question['option_a']) ?>
                            </label>
                        </div>
                        
                        <div class="option">
                            <input type="radio" name="question_<?= $index ?>" value="B" id="q<?= $index ?>_b">
                            <label for="q<?= $index ?>_b">
                                <strong>B.</strong> <?= htmlspecialchars($question['option_b']) ?>
                            </label>
                        </div>
                        
                        <div class="option">
                            <input type="radio" name="question_<?= $index ?>" value="C" id="q<?= $index ?>_c">
                            <label for="q<?= $index ?>_c">
                                <strong>C.</strong> <?= htmlspecialchars($question['option_c']) ?>
                            </label>
                        </div>
                        
                        <div class="option">
                            <input type="radio" name="question_<?= $index ?>" value="D" id="q<?= $index ?>_d">
                            <label for="q<?= $index ?>_d">
                                <strong>D.</strong> <?= htmlspecialchars($question['option_d']) ?>
                            </label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Soumettre mes réponses
            </button>
        </form>
    </div>

    <script>
        // Chronomètre
        let seconds = 0;
        const timerElement = document.getElementById('timer');
        
        setInterval(() => {
            seconds++;
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;
            timerElement.textContent = 
                String(minutes).padStart(2, '0') + ':' + 
                String(secs).padStart(2, '0');
        }, 1000);

        // Confirmation avant soumission
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            const totalQuestions = <?= count($questions) ?>;
            let answeredCount = 0;
            
            for (let i = 0; i < totalQuestions; i++) {
                if (document.querySelector(`input[name="question_${i}"]:checked`)) {
                    answeredCount++;
                }
            }
            
            if (answeredCount < totalQuestions) {
                if (!confirm(`Vous avez répondu à ${answeredCount}/${totalQuestions} questions. Voulez-vous vraiment soumettre ?`)) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>