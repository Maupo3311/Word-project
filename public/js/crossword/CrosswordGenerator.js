class CrosswordGenerator {
    /******************************************
     *               Selectors
     *****************************************/
    selectorFormLvl = '#crossword_lvl';
    selectorFormWidth = '#crossword_width';
    selectorFormHeight = '#crossword_height';
    selectorFormChars = '#crossword_chars';
    selectorCrosswordWidget = '#crossword_widget';
    selectorForm = '#crossword_generator_form';
    selectorCrosswordOptions = '#crossword_form';
    selectorCrosswordWordOptions = '#crossword_word_form';
    selectorWordForGenerate = '.word_for_generate';
    selectorCellWord = '.cell';
    selectorPlaceForCell = '.place_for_cell';
    selectorFlipButton = '.flip-word';
    selectorButtonOpenWordOptions = '#open_word_menu';
    selectorButtonOpenCrosswordOptions = '#open_crossword_menu';

    /******************************************
     *               Options
     *****************************************/
    width = 1;
    height = 1;
    lvl = 0;
    chars = '';
    placeForCells = [];
    placeQuantity = 1;

    /******************************************
     *             Word options
     *****************************************/
    selectedCell;
    selectedWord;
    errors = [];

    constructor() {
        this.init();
    }

    init = () => {
        $(document).on('dblclick', '.used', e => {
            var cell = e.target;
            var wordName = cell.getAttribute('data-cell-word');
            console.log(wordName);
            this.clearWordFromCrossword(wordName);
        });

        $(document).on('click', this.selectorButtonOpenWordOptions, e => {
            this.openMenu('word');
        });

        $(document).on('click', this.selectorButtonOpenCrosswordOptions, e => {
            this.openMenu('');
        });

        $(document).on('click', this.selectorFlipButton, e => {
             var wordName = e.target.parentNode.getAttribute('data-flip-word');
             if (wordName === null) {
                 wordName = e.target.getAttribute('data-flip-word');
             }
             var word = this.getWordByName(wordName);
             this.flipWord(word);
        });

        $(document).on('click', this.selectorPlaceForCell, e => {
            var placeForCell = e.target;
            this.insertWord(placeForCell);
        });

        $(document).on('change', this.selectorFormHeight, e => {
            this.height = $(this.selectorFormHeight).val();
            this.getMarkup();
        });

        $(document).on('change', this.selectorFormWidth, e => {
            this.width = $(this.selectorFormWidth).val();
            this.getMarkup();
        });

        $(document).on('submit', this.selectorForm, e => {
            e.preventDefault();
            this.height = $(this.selectorFormHeight).val();
            this.width = $(this.selectorFormWidth).val();
            this.lvl = $(this.selectorFormLvl).val();
            this.chars = $(this.selectorFormChars).val();

            this.getWordForGenerate();
        });

        $(document).on('click', this.selectorCellWord, e => {
            this.selectCell(e.target);
        });
    };

    getMarkup = () => {
        var query = '?width=' + this.width + '&height=' + this.height;

        $.get(Routing.generate('crossword_generator_get_markup') + query)
            .done(response => {
                $(this.selectorCrosswordWidget).html(response);
                this.cells = $(this.selectorPlaceForCell);
                this.placeQuantity = this.cells.length;
            });
    };

    openMenu = menu => {
        if (menu === 'word') {
            $(this.selectorCrosswordWordOptions).css('display', 'block');
            $(this.selectorCrosswordOptions).css('display', 'none');
        } else {
            $(this.selectorCrosswordWordOptions).css('display', 'none');
            $(this.selectorCrosswordOptions).css('display', 'block');
        }
    };

    getWordForGenerate = () => {
        var query = '?chars=' + this.chars;

        $.get(Routing.generate('crossword_generator_get_word') + query)
            .done(response => {
                $(this.selectorCrosswordWordOptions).html(response);
                this.openMenu('word');
            });
    };

    deselectCurrentCell = () => {
        $(this.selectedCell).css('background', 'rgba(64, 255, 50, 0.15)');
        $(this.selectedWord).css('border-left', 'none');
    };

    selectCell = cell => {
        this.deselectCurrentCell();

        this.selectedCell = cell;
        this.selectedWord = this.selectedCell.parentNode;

        $(this.selectedCell).css('background', 'yellow');
        $(this.selectedWord).css('border-left', '4px solid black');
    };

    saveCrossword = () => {
        
    };

    /******************************************
     *             Word methods
     *****************************************/

    getWordByName = name => {
        return $('[data-word=' + name + ']')[0];
    };

    flipWord = word => {
        var currentPosition = word.getAttribute('data-position');

        if (currentPosition === 'h') {
            word.setAttribute('data-position', 'v');
            $(word).css('width', '40px');
        } else {
            word.setAttribute('data-position', 'h');
            $(word).css('width', '90%');
        }
    };

    /******************************************
     *         Word crossword methods
     *****************************************/

    searchError = (cell, charForCell = null) => {
        if (cell === null || cell === undefined) {
            return 'Cell not found';
        } else if (charForCell === null) {
            return null;
        }

        if (this.getCellContent(cell) != '') {
            console.log(charForCell);
            console.log(this.getCellContent(cell));
            if (this.getCellContent(cell) !== charForCell) {
                return 'You can\'t put that word in here';
            }
        } else {
            var position = this.selectedWord.getAttribute('data-position');

            if (position === 'h') {
                if (
                    this.getCellContent(this.getTopCell(cell)) != '' ||
                    this.getCellContent(this.getBottomCell(cell)) != ''
                ) {
                    return 'You can\'t put that word in here';
                }
            } else {
                if (
                    this.getCellContent(this.getLeftCell(cell)) != '' ||
                    this.getCellContent(this.getRightCell(cell)) != ''
                ) {
                    return 'You can\'t put that word in here';
                }
            }
        }

        return null;
    };

    getCellsForWord = placeForCell => {
        var numberCellInWord = this.selectedCell.getAttribute('data-number');
        var position = this.selectedWord.getAttribute('data-position');
        var selectedWordName = this.selectedWord.getAttribute('data-word');
        var selectedWordLength = selectedWordName.length;

        var cells  = [placeForCell];
        var currentCell = placeForCell;

        if (position === 'h') {
            var goLeft = numberCellInWord;
            var goRight = selectedWordLength - numberCellInWord - 1;

            currentCell = placeForCell;
            for (var left = 0; left < goLeft; ++left) {
                var cell = this.getLeftCell(currentCell);
                currentCell = cell;
                if (this.searchError(currentCell) !== null) {
                    this.errors.push('error');
                }
                cells.push(cell);
            }

            currentCell = placeForCell;
            for (var right = 0; right < goRight; ++right) {
                cell = this.getRightCell(currentCell);
                currentCell = cell;
                if (this.searchError(currentCell) !== null) {
                    this.errors.push('error');
                }
                cells.push(cell);
            }
        } else {
            var goTop = numberCellInWord;
            var goBottom = selectedWordLength - numberCellInWord - 1;

            currentCell = placeForCell;
            for (var top = 0; top < goTop; ++top) {
                console.log('top');
                var cell = this.getTopCell(currentCell);
                currentCell = cell;
                if (this.searchError(currentCell) !== null) {
                    this.errors.push('error');
                }
                cells.push(cell);
            }

            currentCell = placeForCell;
            for (var bottom = 0; bottom < goBottom; ++bottom) {
                console.log('bottom');
                cell = this.getBottomCell(currentCell);
                currentCell = cell;
                if (this.searchError(currentCell) !== null) {
                    this.errors.push('error');
                }
                cells.push(cell);
            }
        }

        return cells;
    };

    sortCellsForWord = cells => {
        return cells.sort((a, b) => {
            return this.getCellNumber(a) - this.getCellNumber(b);
        })
    };

    deleteWord = word => {
        word.parentNode.style.display = 'none';
    };

    clearWordFromCrossword = wordName => {
          var cellsInCrossword = $('[data-cell-word=' + wordName + ']');
          for (var number = 0; number < cellsInCrossword.length; ++number) {
              this.clearCellFromCrossword(cellsInCrossword[number]);
          }

          var wordRow = this.getWordByName(wordName).parentNode;
          $(wordRow).css('display', '');
    };

    clearCellFromCrossword = cell => {
        cell.classList.remove('used');
        $(cell).html('');
    };

    spreadTheWordOnCells = cells => {
        var wordName = this.selectedWord.getAttribute('data-word');

        var error;
        for (var number = 0; number < cells.length; ++number) {
            var cell = cells[number];
            if (this.searchError(cell, wordName[number]) !== null) {
                return null;
            }
        }

        for (number = 0; number < cells.length; ++number) {
            cell = cells[number];
            cell.innerHTML = wordName[number];
            cell.classList.add('used');
            $(cell).attr('data-cell-word', wordName);
            this.deleteWord(this.selectedWord);
        }
    };

    insertWord = placeForCell => {
        if (this.selectedWord === null) {
            return null;
        }

        var cells = this.getCellsForWord(placeForCell);
        cells = this.sortCellsForWord(cells);
        this.spreadTheWordOnCells(cells);
        this.deselectCell(this.selectedCell);

        this.selectedWord = null;
        this.selectedCell = null;
    };

    /******************************************
     *          Navigation methods
     *****************************************/
    getCellContent = cell => {
        if (cell === undefined || cell === null) {
            return null;
        }

        return $(cell).html();
    };

    getCellNumber = cell => {
        return +$(cell).attr('data-number');
    };

    getRowNumber = cell => {
        return cell.parentNode.getAttribute('data-row');
    };

    getCell = number => {
        return $('[data-number=' + number + ']')[0];
    };

    getLeftCell = cell => {
        var leftCellNumber = this.getCellNumber(cell) - 1;
        var leftCell = this.getCell(leftCellNumber);

        if (leftCell === null || leftCellNumber < 0 || this.getRowNumber(cell) !== this.getRowNumber(leftCell)) {
            return null;
        }

        return leftCell;
    };

    getRightCell = cell => {
        var rightCellNumber = this.getCellNumber(cell) + 1;
        var rightCell = this.getCell(rightCellNumber);

        if (rightCell === null|| rightCellNumber > this.placeQuantity || this.getRowNumber(cell) !== this.getRowNumber(rightCell)) {
            return null;
        }

        return rightCell;
    };

    getTopCell = cell => {
        var topCellNumber = this.getCellNumber(cell) - +this.width;
        var topCell = this.getCell(topCellNumber);

        if (topCell === null || topCellNumber < 0 ) {
            return null;
        }

        return topCell;
    };

    getBottomCell = cell => {
        var BottomCellNumber = this.getCellNumber(cell) + +this.width;
        var BottomCell = this.getCell(BottomCellNumber);

        if (BottomCell === null || BottomCellNumber > this.placeQuantity ) {
            return null;
        }

        return BottomCell;
    };
}

var crosswordGenerator = new CrosswordGenerator();