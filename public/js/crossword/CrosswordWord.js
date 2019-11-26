import Cell from "./CrosswordCell.js";
import Selector from "./CrosswordSelectors.js";
import Char from "./CrosswordChar.js";
import Animated from "./CrosswordAnimated.js";

class CrosswordWord {

    CrosswordObject = {};

    enteredWord = [];
    counterEnteredWordInCrossword = 0;
    counterEnteredWordNotInCrossword = 0;

    getWordObject = word => {
        for (var i = 0; i < this.CrosswordObject.crossword.words.length; ++i) {
            var wordObject = this.CrosswordObject.crossword.words[i];
            if (wordObject.wordName === word) {
                return wordObject;
            }
        }

        return null;
    };

    enterWord = word => {
        var wordObject = this.getWordObject(word);
        if (wordObject === null || wordObject.entered) {
            return;
        } else if (wordObject.inCrossword) {
            for (var i = 0; i < wordObject.cells.length; ++i) {
                var cell = wordObject.cells[i];
                cell.classList.remove('not_guessed');
            }

            this.counterEnteredWordInCrossword++;
            // Animated.animateInsertWord(wordObject);
            this.addLogAboutWord(wordObject);
            this.CrosswordObject.isWin();
        } else if (!wordObject.inCrossword) {
            this.counterEnteredWordNotInCrossword++;
            this.addAdditionalWords(wordObject);
        }
        wordObject.entered = true;
        this.CrosswordObject.updateCounters();
    };

    addAdditionalWords = wordObject => {
        var html = '' +
            '<div>' +
            '<b>' + wordObject.wordName + '</b> - ' + wordObject.description +
            '</div>';
        $(Selector.additionalWords).append(html);
    };

    addLogAboutWord = wordObject => {
        var logWindow = $(Selector.logWindow);
        var html = '' +
            '<div>' +
            '<b>' + wordObject.wordName + '</b> - ' + wordObject.description +
            '</div>';
        $(logWindow).append(html);
        logWindow.scrollTop(logWindow.prop('scrollHeight'));
    };
}

var Word = new CrosswordWord();
export default Word;