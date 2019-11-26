import Cell from "./CrosswordCell.js";
import Word from "./CrosswordWord.js";
import Selector from "./CrosswordSelectors.js";
import Char from "./CrosswordChar.js";

class CrosswordAnimated {

    animateInsertWord = wordObject => {
        let display = $(Selector.display)[0];
        let displayCoords = this.getCoordsByElement(display);
        for (var i = 0; i < wordObject.cells.length; ++i) {
            let cell = wordObject.cells[i];
            let cellCords = this.getCoordsByElement(cell);
            let cellForAnimate = document.createElement('div');
            document.body.appendChild(cellForAnimate);
            cellForAnimate.classList.add('cell_for_animate');
            $(cellForAnimate).css('left', displayCoords.left).css('top', displayCoords.right).html(wordObject.wordName[i]);
            $(cellForAnimate).css('transition-duration', '.5s').css('transition-property', 'all');
            setTimeout(() => {
                $(cellForAnimate).css('left', cellCords.left).css('top', cellCords.top);
            }, 1000)
        }
    };

    getCoordsByElement = element => {
        let elementCoords = element.getBoundingClientRect();

        console.log(element);
        console.log(elementCoords);

        return {
            'left': elementCoords.left + pageXOffset,
            'right': elementCoords.right + pageXOffset,
            'top': elementCoords.top + pageYOffset,
            'bottom': elementCoords.bottom + pageYOffset
        }
    }
}

var Animated = new CrosswordAnimated();
export default Animated;