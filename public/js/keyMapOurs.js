$('.keypad').keypad({keypadOnly: false,
    layout: ['÷±∓≠≤≥≈~','π√∑∫f∮∞Δ∇','αβγδεφχψω∂','∀∈∉∌⊆⊂∪⊆∩','ℝℚℤn','½⅓⅔¼¾','∣&¬˜','⇔⇒→','(){},.:',$.keypad.SHIFT],
    toUpper: function(ch) {
        return {'÷': 'º', '±': '¹', '∓': '²', '≠': '³', '≤': '┴','≥':'┬','≈':'├' ,'~':'ⁿ',
                '⅓': '⅛', '⅔': '⅜', '¼': '⅝', '¾': '⅞'}[ch] || ch;
    },
    prompt: 'Símbolos Matemáticos'});