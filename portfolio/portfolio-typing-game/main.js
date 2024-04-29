// ランダムな文章を取得するAPI
const RANDOM_SENTENCE_URL_API = "https://api.quotable.io/random";
const typeDisplay = document.getElementById('typeDisplay');
const typeInput = document.getElementById('typeInput');
const timer = document.getElementById('timer');
const countDownText =document.getElementById('countDown');
const againBtn = document.getElementById('againBtn');
const container = document.getElementById('container');

let windowSize = window.innerWidth;
let interval;
let timeLeft;
let countDownTimer;
let gameActive = false;

againBtn.style.display ='none';

// autofucusの切り替え
typeInput.autofocus = false;

// SPは画面をタップしてゲーム開始
container.ontouchstart = function touch() {
    StartGame();
};

if (windowSize <= 768) {
    countDownText.classList.add('countDown');
    countDownText.innerHTML = 'Tap to Start';
    // console.log('SP');
} else if(windowSize >= 768)  {
    countDownText.classList.add('countDown');
    countDownText.innerHTML = 'Press Space';
    // console.log('PC');
}

// キーボードイベントリスナーを設定（スペースキーでゲーム開始）
document.addEventListener('keypress', function (e) {
    if (e.key === ' ') {
        typeInput.autofocus =true;
        StartGame();
    }
});
// ゲーム開始の関数
function StartGame() {
    if (!gameActive) {
        gameActive = true;
        typeInput.value = '';
        typeInput.disabled = false;
        countDownText.classList.add('countDown');
        // againボタンの日表示切替
        againBtn.style.display = 'none';
        typeInput.style.display = '';
        // タイマー開始前のカウントダウン
        countDownTimer = 4;
        // ゲーム中のタイマー
        timeLeft = 20;
        timer.innerText = timeLeft;
        RanderNextSentence();
        StartGameCount();
        typeDisplay.classList.remove('result');
    }
}
// ランダムな文章を取得して、表示する
//　非同期通信のため待たないと取れない async とawaitを使う
async function RanderNextSentence() {
    const sentence = await GetRandomSentence();
    // console.log(sentence);
    typeDisplay.innerText = '';
    // 文章を取得する1文字ずつ分解してspanタグを生成する
    let oneText = sentence.split('');
    oneText.forEach((character) => {
        const characterSpan = document.createElement('span');
        characterSpan.innerText = character;
        // 一文字ずつ分解してspanタグと生成
        // console.log(characterSpan);
        // divの子要素としてspanタグを追加s
        typeDisplay.appendChild(characterSpan);
        // characterSpan.classList.add('correct');
    });
}
// 非同期でランダムな文章を取得する
async function GetRandomSentence() {
    // return fetch(RANDOM_SENTENCE_URL_API)
    //     .then((response) => response.json())
    //     .then((data) => data.content);
    const response = await fetch(RANDOM_SENTENCE_URL_API);
    const data = await response.json();
    return data.content;

}
// タイマー開始前に3秒間のカウントダウン
function StartGameCount() {
    countDown = setInterval(() => {
        countDownTimer--;
        countDownText.innerHTML = countDownTimer;
        
        if (countDownTimer === 0) {
            clearInterval(countDown);
            StartTimer();
            countDownText.classList.remove('countDown');
            countDownText.innerHTML = '';
        }
    },1000);
}
// タイマーを開始する関数
function StartTimer() {
    typeInput.value = '';
    interval = setInterval(() => {
        timeLeft--;
        // return Math.floor((timer))
        timer.innerText = timeLeft;
        if (timeLeft === 0) {
            endGame();
        }
    }, 1000);
}
// ゲームを終了する関数
function endGame() {
    clearInterval(interval);
    gameActive = false;
    typeInput.value = '';
    // alert('時間切れです！');
    timer.innerText = 'Time up!';
    againBtn.style.display = '';
    typeInput.style.display = 'none';
    const lengthSpan = document.querySelectorAll('span').length;
    let lengthCorrect = document.querySelectorAll('.correct').length;
    //正答率をパーセントで表示する
    const score = lengthCorrect * 100 / lengthSpan;
    // 小数第二位まで出力
    const result = score.toFixed(2)
    // リザルトを出すためクラスをつける
    typeDisplay.classList.add('result');
    // 正解なしの場合のエラー対処
    if (!lengthCorrect==0) {
        typeDisplay.innerHTML = '正答率' + result + '%'; 
    } else {
        typeDisplay.innerHTML = '正答なし...'; 
    }
}

// inputテキスト入力。あっているかどうかの判定
typeInput.addEventListener('input', () => {
    // querySelectorAllでspanタグをすべて配列として取得
    const sentenceArray = typeDisplay.querySelectorAll('span');
    // console.log(sentenceArray);
    // inputするたび配列に追加する
    const arrayValue = typeInput.value.split('');
    // console.log(arrayValue);
    // sentenceArrayとarrayValueをひとつずつ比較する
    let correct = true;
    sentenceArray.forEach((characterSpan, index) => {
        if ((arrayValue[index] == null)) {
            // 何も入力していない場合は色を付けない
            characterSpan.classList.remove('correct');
            characterSpan.classList.remove('incorrect');
            correct = false;
        } else if (characterSpan.innerText == arrayValue[index]) {
            // ランダムな文章と入力した文字が一致した場合文字色を変化させるためクラスを追加
            characterSpan.classList.add('correct');
            characterSpan.classList.remove('incorrect');
        } else {
            characterSpan.classList.add('incorrect');
            characterSpan.classList.remove('correct');
            correct = false;
        }
    });
});