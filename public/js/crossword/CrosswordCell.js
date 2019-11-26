import Word from "./CrosswordWord.js";
import Selector from "./CrosswordSelectors.js";
import Char from "./CrosswordChar.js";

class CrosswordCell {

    getByNumber = number => {
        return $('[data-number=' + number + ']')[0]
    };
}

var Cell = new CrosswordCell();
export default Cell;