class WordGenerator {
    /******************************************
     *               Selectors
     *****************************************/
    selectorGeneratorForm = '#generator_form';
    selectorGeneratorFormChars = '#generator_form_chars';
    selectorGeneratorResponse = '#generator_response';

    constructor() {
        this.init();
    }

    init = () => {
        $(document).on('submit', this.selectorGeneratorForm, e => {
            e.preventDefault();
            var chars = $(this.selectorGeneratorFormChars).val();
            this.getWordWithTemplateByChars(chars);
        })
    };

    /******************************************
     *               Functions
     *****************************************/

    getWordWithTemplateByChars = chars => {
        var query = '?chars=' + chars;

        $.get(Routing.generate('word_get_by_chars_template') + query)
            .done(response => {
                $(this.selectorGeneratorResponse).html(response);
        });
    };
}

var wordGenerator = new WordGenerator();