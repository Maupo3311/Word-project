class Crossword {
    selectorCells = '.cell';
    selectorChars = '.char_for_enter';
    selectorDisplay = '#display';

    enteredWord = [];
    enteredChars = [];
    notEnteredChars = [];

    constructor(crosswordInArray) {
        this.crossword = crosswordInArray;
        this.notEnteredChars = crosswordInArray.chars.split('');
        this.loadCrossword();
        this.init();
    }

    init = () => {
        $(document).on('click', this.selectorChars, e => {
            var charElement = e.target;
            var char = charElement.getAttribute('data-char');
            this.selectChar(char);
        });

        document.addEventListener('keydown', e => {
            switch (e.keyCode) {
                case 13:
                    var word = $(this.selectorDisplay).html();
                    this.enterWord(word);
                    this.clearDisplay();
                    return;
                case 8:
                    this.backspaceDisplay();
                    return;
            }

            var key = e.key.toLowerCase();
            this.selectChar(key);
        });
    };

    loadCrossword = () => {
        for (var i = 0; i < this.crossword.words.length; ++i) {
            var word = this.crossword.words[i];

            for (var x = 0; x < word.cells.length; ++x) {
                var cellNumber = word.cells[x];
                var cell = this.getCellByNumber(cellNumber);
                word.cells[x] = cell;
                cell.classList.add('used');
                cell.classList.add('not_guessed');
                cell.innerHTML = word.wordName[x];
                cell.setAttribute('data-cell-word', word.wordName);
            }
        }
    };

    enterWord = word => {
        var crosswordWord = this.inCrossword(word);
        var notInCrosswordWord = this.notInCrossword(word);
        if (crosswordWord !== null) {
            for (var i = 0; i < crosswordWord.cells.length; ++i) {
                var cell = crosswordWord.cells[i];
                cell.classList.remove('not_guessed');
            }

            this.isWin();
        } else if (notInCrosswordWord !== null) {
            console.log(notInCrosswordWord);
        }
    };

    /***********************************************
     *
     **********************************************/

    notInCrossword = word => {
        for (var i = 0; i < this.crossword['words_info']['not_in'].length; ++i) {
            var notInWord = this.crossword['words_info']['not_in'][i];
            if (notInWord['wordName'] === word && !notInWord.entered) {
                return notInWord;
            }
        }

        return null;
    };

    inCrossword = word => {
        for (var i = 0; i < this.crossword.words.length; ++i) {
            var crosswordWord = this.crossword.words[i];
            if (word === crosswordWord.wordName && !crosswordWord.entered) {
                this.enteredWord.push(word);
                this.crossword.words[i].entered = true;
                return crosswordWord;
            }
        }

        return null;
    };

    getCellByNumber = number => {
        return $('[data-number=' + number + ']')[0]
    };

    getCharElement = char => {
        return $('[data-char=' + char + ']')[0];
    };

    selectChar = char => {
        var charIndex = this.notEnteredChars.indexOf(char);
        if (charIndex === -1) {
            return null
        }
        var charElement = this.getCharElement(char);
        delete this.notEnteredChars[charIndex];
        this.enteredChars.push(char);
        charElement.style.display = 'none';
        this.addCharInDisplay(char);
    };

    addCharInDisplay = char => {
        var display = $(this.selectorDisplay);
        var html = $(display).html();
        $(display).html(html + char);
    };

    clearDisplay = () => {
        $(this.selectorChars).css('display', 'block');
        $(this.selectorDisplay).html('');
        this.enteredChars = [];
        this.notEnteredChars = this.crossword.chars.split('');
    };

    backspaceDisplay = () => {
        var content = $(this.selectorDisplay).html();
        var lastChar = content[content.length - 1];
        var lastCharElement = this.getCharElement(lastChar);
        $(lastCharElement).css('display', 'block');
        $(this.selectorDisplay).html(content.substring(0, content.length - 1));
        this.notEnteredChars.push(lastChar);
        delete this.enteredChars[this.enteredChars.indexOf(lastChar)];
    };

    isWin = () => {
        console.log(this.enteredWord.length + ' / ' + this.crossword.words.length);
        if (this.enteredWord.length === this.crossword.words.length) {
            return true;
        }

        return false;
    }
}