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
    selectorCrosswordOptions = '#crossword_options';
    selectorWordForGenerate = '.word_for_generate';
    selectorCellWord = '.cell';

    /******************************************
     *               Options
     *****************************************/
    width = 1;
    height = 1;
    lvl = 0;
    chars = '';

    /******************************************
     *             Word options
     *****************************************/
    selectedCell;
    selectedWord;

    constructor() {
        this.init();
    }

    init = () => {
        $(document).on('change', this.selectorFormHeight, e => {
            this.height = $(this.selectorFormHeight).val();
            this.getMarkup();
        });

        $(document).on('change', this.selectorFormWidth, e => {
            this.width = $(this.selectorFormWidth).val();
            this.getMarkup();
        });

        $(document).on('submit', this.selectorForm, e => {
            console.log('');
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
            });
    };

    getWordForGenerate = () => {
        var query = '?chars=' + this.chars;

        $.get(Routing.generate('crossword_generator_get_word') + query)
            .done(response => {
                $(this.selectorCrosswordOptions).html(response);
                setTimeout(() => {

                }, 1000);
            });
    };

    selectCell = cell => {
        $(this.selectedCell).css('background', 'rgba(64, 255, 50, 0.15)');
        $(this.selectedWord).css('border-left', 'none');

        this.selectedCell = cell;
        this.selectedWord = this.selectedCell.parentNode;

        $(this.selectedCell).css('background', 'yellow');
        $(this.selectedWord).css('border-left', '4px solid black');
    }
}

var crosswordGenerator = new CrosswordGenerator();