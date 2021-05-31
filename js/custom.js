$(function () {
    'use strict';

    //Caching The Scroll Top Element
    $(window).scroll(function () {
        $(this).scrollTop() >= 1200 ? $("#scroll-top").show() : $("#scroll-top").hide();
    });
    //Click On Button To Scroll Top
    $("#scroll-top").click(function () {
        $("html , body").animate({
            scrollTop: 0
        }, 1000);
    });
});

// Select Elements
let countSpan = document.querySelector('.quiz-info .couNt'),
    bulletsSpan = document.querySelector('.bullets .spans-cont');
let currentIndex = 0;
let rightAnswers = 0;
let countDownInterval;
let quizArea = document.querySelector('.quiz-info .Quiz-area');
let answerArea = document.querySelector('.quiz-info .answrs-area');
let subButton = document.querySelector('.submit');
let bullets = document.querySelector('.bullets');
let theResulteCont = document.querySelector('.result');
let countDownElement = document.querySelector('.countDown');

// Quiz App JavaScript
function getQuiz() {
    let myRequest = new XMLHttpRequest();
    myRequest.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let quizObject = JSON.parse(this.responseText);
            let quizCount = quizObject.length;
            creatBullets(quizCount);
            addData(quizObject[currentIndex], quizCount);
            countDown(60, quizCount);
            subButton.onclick = () => {
                let theRightAnswer = quizObject[currentIndex].right_answer;
                currentIndex++;
                checkAnswer(theRightAnswer, quizCount);
                quizArea.innerHTML = "";
                answerArea.innerHTML = "";
                addData(quizObject[currentIndex], quizCount);
                handelBullets();
                clearInterval(countDownInterval);
                countDown(60, quizCount);
                showResulte(quizCount);
            };
        }
    }
    myRequest.open("GET", "Quiz.json", true);
    myRequest.send();
}
getQuiz();

function creatBullets(num) {
    countSpan.textContent = 'عدد الاسئله: ' + num;
    for (i = 0; i < num; i++) {
        let theBullets = document.createElement("span");
        if (i === 0) {
            theBullets.className = 'on';
        }
        bulletsSpan.appendChild(theBullets);
    }
}

function addData(obj, count) {
    if (currentIndex < count) {
        let questionTitle = document.createElement("h2");
        let questionText = document.createTextNode(obj['title']);
        questionTitle.appendChild(questionText);
        quizArea.appendChild(questionTitle);
        for (i = 1; i <= 3; i++) {
            let mainDiv = document.createElement("div");
            mainDiv.className = "answer";
            let radioInput = document.createElement("input");
            radioInput.name = "quiz";
            radioInput.type = "radio";
            radioInput.id = `answer_${i}`;
            radioInput.dataset.answer = obj[`answer_${i}`];
            if (i === 1) {
                radioInput.checked = true
            }
            let theLabel = document.createElement("label");
            theLabel.htmlFor = `answer_${i}`;
            theLabelText = document.createTextNode(obj[`answer_${i}`]);
            theLabel.appendChild(theLabelText);
            mainDiv.appendChild(radioInput);
            mainDiv.appendChild(theLabel);
            answerArea.appendChild(mainDiv);
        }

    }
}

function checkAnswer(rAnswer, count) {
    let answers = document.getElementsByName("quiz");
    let theChooseAnswer;
    for (i = 0; i < answers.length; i++) {
        if (answers[i].checked) {
            theChooseAnswer = answers[i].dataset.answer;
        }
    }
    if (rAnswer === theChooseAnswer) {
        rightAnswers++;
    }
}

function handelBullets() {
    let bulletsSpan = document.querySelectorAll('.bullets .spans-cont span');
    let arrayOfSpans = Array.from(bulletsSpan);
    arrayOfSpans.forEach((span, index) => {
        if (currentIndex === index) {
            span.className = "on";
        }
    });
}

function showResulte(count) {
    let theResulte;
    if (currentIndex === count) {
        quizArea.remove();
        answerArea.remove();
        subButton.remove();
        bullets.remove();
        if (rightAnswers > count / 2 && rightAnswers < count) {
            theResulte = `<span class="good">جيد إستمر فالتقدم لقد أنجزت ${rightAnswers} من ${count}</span>`;
        } else if (rightAnswers === count) {
            theResulte = `<span class="prefect">أحسنت عملا لقد تخطيت الإختبار بنجاح</span>`;
        } else {
            theResulte = `<span class="bad">لم تكن موفقا فى الاجابه حاول مره اخرى</span>`;
        }
        theResulteCont.innerHTML = theResulte;
    }
}

function countDown(duration, count) {
    if (currentIndex < count) {
        let minutes, seconds;
        countDownInterval = setInterval(function () {
            minutes = parseInt(duration / 60);
            seconds = parseInt(duration % 60);
            minutes = minutes < 10 ? `0${minutes}` : minutes;
            seconds = seconds < 10 ? `0${seconds}` : seconds;
            countDownElement.innerHTML = `${minutes} : ${seconds}`;
            if (--duration < 0) {
                clearInterval(countDownInterval);
                subButton.click();
            }
        }, 1000);
    }
}