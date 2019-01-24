/*
 * функция смены окончаний
 * на вход принимает число и объект со значениями слова в различных склонениях:
 * {'nom': 'слово', 'gen':'слова', 'plu':'слов'}
 * {0: 'слово', 1:'слова', 2:'слов'}
 * ['слово', 'слова', 'слов']
 */
window.HELPER = {
    units(num, cases) {
        num = Math.abs(num);

        let word = '';

        if (num.toString().indexOf('.') > -1) {
            word = cases[1];
        } else {
            word = (
                num % 10 == 1 && num % 100 != 11
                    ? cases[0]
                    : num % 10 >= 2 && num % 10 <= 4 && (num % 100 < 10 || num % 100 >= 20)
                    ? cases[1]
                    : cases[2]
            );
        }
        return word;
    }
};
