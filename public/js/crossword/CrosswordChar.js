import Cell from "./CrosswordCell.js";
import Word from "./CrosswordWord.js";
import Selector from "./CrosswordSelectors.js";

class CrosswordChar {

    CrosswordObject = {};

    chars = [];

    syncButtons = chars => {
        var charsInArray = chars.split('');
        for (var i = 0; i < charsInArray.length; ++i) {
            var char = charsInArray[i];
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
        var charObject = this.getCharObject(char, false);
        if (charObject === null) {
            return;
        }
        charObject.used = true;
        charObject.element.style.display = 'none';
        this.addCharInDisplay(char);
    };

    clearDisplay = () => {
        $(Selector.chars).css('display', 'block');
        $(Selector.display).html('');
        for (var i = 0; i < this.chars.length; ++i) {
            this.chars[i].used = false;
        }
    };

    addCharInDisplay = char => {
        var display = $(Selector.display);
        var html = $(display).html();
        $(display).html(html + char);
    };

    backspaceDisplay = () => {
        var content = $(Selector.display).html();
        var lastChar = content[content.length - 1];
        var charsObject = this.getCharObject(lastChar, true);
        if (charsObject === null) {
            return;
        }
        charsObject.used = false;
        $(charsObject.element).css('display', 'block');
        $(Selector.display).html(content.substring(0, content.length - 1));
    };
}

var Char = new CrosswordChar();
export default Char;