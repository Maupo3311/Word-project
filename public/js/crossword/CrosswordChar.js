import Cell from "./CrosswordCell.js";
import Word from "./CrosswordWord.js";
import Selector from "./CrosswordSelectors.js";

class CrosswordChar {

    CrosswordObject = {};

    chars = [];
    enteredChars = [];
    notEnteredChars = [];

    syncButtons = chars => {
        this.notEnteredChars = chars.split('');
        for (var i = 0; i < this.notEnteredChars.length; ++i) {
            var char = this.notEnteredChars[i];
            var charElement;
            for (var x = 0; x < 5; ++x) {
                charElement = this.getCharElement(char, x);
                if (charElement !== null && +charElement.getAttribute('data-sync') !== 1) {
                    this.chars.push({
                        'char': char,
                        'element': charElement,
                        'used': false,
                    });
                    charElement.setAttribute('data-sync', 1);
                    break;
                }
            }
        }
    };

    getCharObject = (char, used = false) => {
        for (var i = 0; i < this.chars.length; ++i) {
            if (this.chars[i].char === char && this.chars[i].used === used) {
                return this.chars[i];
            }
        }  

        return null;
    };

    getCharElement = (char, index = 0) => {
        return $('[data-char=' + char + ']')[index];
    };

    selectChar = char => {
        var charIndex = this.notEnteredChars.indexOf(char);
        if (charIndex === -1) {
            return null
        }
        var charElement = this.getCharElement(char, this.getQuantityChars(this.enteredChars, char));
        delete this.notEnteredChars[charIndex];
        this.enteredChars.push(char);
        charElement.style.display = 'none';
        this.addCharInDisplay(char);
    };

    clearDisplay = () => {
        $(Selector.chars).css('display', 'block');
        $(Selector.display).html('');
        this.enteredChars = [];
        this.notEnteredChars = this.CrosswordObject.crossword.chars.split('');
    };

    addCharInDisplay = char => {
        var display = $(Selector.display);
        var html = $(display).html();
        $(display).html(html + char);
    };

    backspaceDisplay = () => {
        var content = $(Selector.display).html();
        var lastChar = content[content.length - 1];
        var index = this.getQuantityChars(this.notEnteredChars, lastChar);
        console.log(index);
        var lastCharElement = this.getCharElement(lastChar, index);
        $(lastCharElement).css('display', 'block');
        $(Selector.display).html(content.substring(0, content.length - 1));
        this.notEnteredChars.push(lastChar);
        delete this.enteredChars[this.enteredChars.indexOf(lastChar)];
    };

    getQuantityChars = (array, char) => {
        var quantity = 0;
        var index = 0;
        for (var i = 0; i < 10; ++i) {
            index = array.indexOf(char, index);
            if (index !== -1) {
                ++quantity;
                ++index;
            } else {
                return quantity;
            }
        }

        return quantity;
    };
}

var Char = new CrosswordChar();
export default Char;