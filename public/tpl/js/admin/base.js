
    $(function() {
        if ($('input[type=file]').length > 0) {
            $('input[type=file]').bootstrapFileInput();
        }

        $('.url-title').keyup(function(e) {
            var url = transliterate($(this).val());

            $('input[name=url]').val(url);
        });

        /*$('.is-number').keydown(function(e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     return;
            }

            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });*/

        $(document).on('keydown', '.is-number', function(e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     return;
            }

            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    });

    function transliterate(word){
        var answer = "", a = {};

        a["Ё"]="YO";a["Й"]="I";a["Ц"]="Z";a["У"]="U";a["К"]="K";a["Е"]="E";a["Н"]="N";a["Г"]="G";a["Ш"]="SH";a["Щ"]="SCH";a["З"]="Z";a["Х"]="H";a["Ъ"]="";
        a["ё"]="yo";a["й"]="i";a["ц"]="z";a["у"]="u";a["к"]="k";a["е"]="e";a["н"]="n";a["г"]="g";a["ш"]="sh";a["щ"]="sch";a["з"]="z";a["х"]="h";a["ъ"]="";
        a["Ф"]="F";a["Ы"]="I";a["В"]="V";a["А"]="a";a["П"]="P";a["Р"]="R";a["О"]="O";a["Л"]="L";a["Д"]="D";a["Ж"]="ZH";a["Э"]="E";
        a["ф"]="f";a["ы"]="i";a["в"]="v";a["а"]="a";a["п"]="p";a["р"]="r";a["о"]="o";a["л"]="l";a["д"]="d";a["ж"]="zh";a["э"]="e";
        a["Я"]="Ya";a["Ч"]="CH";a["С"]="S";a["М"]="M";a["И"]="I";a["Т"]="T";a["Ь"]="";a["Б"]="B";a["Ю"]="U";
        a["я"]="ya";a["ч"]="ch";a["с"]="s";a["м"]="m";a["и"]="i";a["т"]="t";a["ь"]="";a["б"]="b";a["ю"]="u";

        for (i in word) {
            if (word.hasOwnProperty(i)) {
                if (a[word[i]] === undefined) {
                    answer += word[i];
                } 
                else {
                    answer += a[word[i]];
                }
            }
        }

        answer = answer.trim();
        answer = answer.replace(/[^a-zA-Z ]/g, "");
        answer = answer.replace(/  +/g, ' ');
        answer = answer.replace(/ /g,"-").toLowerCase();

        return answer;
    }