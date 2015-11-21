
$('.keypad').keypad({
    showOn: 'button',
    keypadOnly: false,
    layout: ['÷±∓≠≤≥≈~','π√∑∫f∮∞Δ∇','αβγδεφχψω∂','∀∈∉∌⊆⊂∪⊆∩','ℝℚℤn','½⅓⅔¼¾','∣&¬˜','⇔⇒→','(){},.:',$.keypad.SHIFT],
    toUpper: function(ch) {
        return {'÷': 'º', '±': '¹', '∓': '²', '≠': '³', '≤': '┴','≥':'┬','≈':'├' ,'~':'ⁿ',
                '⅓': '⅛', '⅔': '⅜', '¼': '⅝', '¾': '⅞'}[ch] || ch;
    },
    prompt: 'Símbolos Matemáticos'});

$('#buttonKeypad').toggle(function() {
    $(this).text('Enable').siblings('input').keypad('disable');
}, function() {
    $(this).text('Disable').siblings('input').keypad('enable');
});