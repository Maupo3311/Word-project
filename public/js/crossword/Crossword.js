import Cell from "./CrosswordCell.js";
import Word from "./CrosswordWord.js";
import Selector from "./CrosswordSelectors.js";
import Char from "./CrosswordChar.js";

export default class Crossword {

    constructor(crosswordInArray) {
        this.toExpandTheModules();

        this.crossword = crosswordInArray;
        Char.syncButtons(crosswordInArray.chars);
        this.loadCrossword();
        this.init();
    }

    init = () => {
        $(document).on('click', Selector.chars, e => {
            var charElement = e.target;
            var char = charElement.getAttribute('data-char');
            Char.selectChar(char);
        });

        document.addEventListener('keydown', e => {
            switch (e.keyCode) {
                case 13:
                    var word = $(Selector.display).html();
                    Word.enterWord(word);
                    Char.clearDisplay();
                    return;
                case 8:
                    Char.backspaceDisplay();
                    return;
            }

            var key = e.key.toLowerCase();
            Char.selectChar(key);
        });
    };

    loadCrossword = () => {
        for (var i = 0; i < this.crossword.words.length; ++i) {
            var word = this.crossword.words[i];

            for (var x = 0; x < word.cells.length; ++x) {
                var cellNumber = word.cells[x];
                var cell = Cell.getByNumber(cellNumber);
                word.cells[x] = cell;
                cell.classList.add('used');
                cell.classList.add('not_guessed');
                cell.innerHTML = word.wordName[x];
                cell.setAttribute('data-cell-word', word.wordName);
            }
        }
    };

    isWin = () => {
        console.log(Word.enteredWord.length + ' / ' + this.crossword.words.length);
        if (Word.enteredWord.length === this.crossword.words.length) {
            return true;
        }

        return false;
    };

    toExpandTheModules = () => {
        Word.CrosswordObject = this;
        Char.CrosswordObject = this;
    };
}