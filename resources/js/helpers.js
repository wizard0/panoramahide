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
    },
    phoneFormat: function (value) {
        let val = value;
        if (val.length === 5) {
            return val.replace(/(\d)(\d\d)(\d\d)/, "$1-$2-$3"); // #-##-##
        }
        if (val.length === 6) {
            return val.replace(/(\d\d)(\d\d)(\d\d)/, "$1-$2-$3"); // ##-##-##
        }
        if (val.length === 7) {
            return val.replace(/(\d\d\d)(\d\d)(\d\d)/, "$1-$2-$3"); // ###-##-##
        }
        if (val.length === 11) {
            if (parseInt(val.charAt(0)) === 8) {
                val.substring(1);
                val = '7' + val;
            }
            return val.replace(/(\d)(\d\d\d)(\d\d\d)(\d\d)(\d\d)/, "+$1 ($2) $3-$4-$5");
        }
        return val;
    }
};


