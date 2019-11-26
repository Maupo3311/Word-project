import Cell from "./CrosswordCell.js";
import Selector from "./CrosswordSelectors.js";
import Char from "./CrosswordChar.js";

class CrosswordWord {

    CrosswordObject = {};

    enteredWord = [];

    notInCrossword = word => {
        for (var i = 0; i < this.CrosswordObject.crossword['words_info']['not_in'].length; ++i) {
            var notInWord = this.CrosswordObject.crossword['words_info']['not_in'][i];
            if (notInWord['wordName'] === word && !notInWord.entered) {
                return notInWord;
            }
        }

        return null;
    };

    inCrossword = word => {
        for (var i = 0; i < this.CrosswordObject.crossword.words.length; ++i) {
            var crosswordWord = this.CrosswordObject.crossword.words[i];
            if (word === crosswordWord.wordName && !crosswordWord.entered) {
                this.enteredWord.push(word);
                this.CrosswordObject.crossword.words[i].entered = true;
                return crosswordWord;
            }
        }

        return null;
    };

    enterWord = word => {
        var crosswordWord = this.inCrossword(word);
        var notInCrosswordWord = this.notInCrossword(word);
        if (crosswordWord !== null) {
            for (var i = 0; i < crosswordWord.cells.length; ++i) {
                var cell = crosswordWord.cells[i];
                cell.classList.remove('not_guessed');
            }

            this.CrosswordObject.isWin();
        } else if (notInCrosswordWord !== null) {
            console.log(notInCrosswordWord);
        }
    };
}

var Word = new CrosswordWord();
export default Word;