$(function () {
        var score = 0;
        $("#btn").click(function () {
            score++;
            $('#result').text(score);
        })

        $("#reset").click(function () {
            score = 0;
            $('#result').text(score);
        })
    }
    window.alert("tuk sme")
)

function test() {
    window.alert("tuk");
}
