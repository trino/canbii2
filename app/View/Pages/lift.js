var TAB = "	";
var NEWLINE = "\r\n";

function PHP_stringify(data){
    var HTML = JSON.stringify(data);
    HTML = "[" + NEWLINE + TAB + HTML.mid(1, HTML.length-2) + NEWLINE + "]";
    HTML = HTML.replaceAll('","', '",' + NEWLINE + TAB + '"');
    HTML = HTML.replaceAll2('],"', '],' + NEWLINE + TAB + '"');
    HTML = HTML.replaceAll('":"', '" => "');
    HTML = HTML.replaceAll(':{', ' => [');
    HTML = HTML.replaceAll2(':[', ' => [');
    HTML = HTML.replaceAll('}', ']');
    HTML = HTML.replaceAll(':false', ' => ""');
    HTML = HTML.replaceAll('":', '" => ');
    HTML = HTML.replaceAll(',"', ',' + NEWLINE + TAB + '"');
    HTML = HTML.replaceAll('],{', '],' + NEWLINE + NEWLINE + TAB + '[');
    HTML = HTML.replaceAll('{', '[');
    HTML = HTML.replaceAll('}', ']');
    return HTML;
}

String.prototype.contains = function (str) {
    return this.toLowerCase().indexOf(str.toLowerCase()) > -1;
};

//returns true if the string starts with str
String.prototype.startswith = function (str) {
    return this.substring(0, str.length).isEqual(str);
};
String.prototype.endswith = function (str) {
    return this.right(str.length).isEqual(str);
};
//returns the left $n characters of a string

String.prototype.left = function (n) {
    return this.substring(0, n);
};

String.prototype.mid = function (start, length) {
    return this.substring(start, start + length);
};

//returns the right $n characters of a string
String.prototype.right = function (n) {
    return this.substring(this.length - n);
};

//replaces all instances of $search within a string with $replacement
String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

String.prototype.replaceAll2 = function (search, replacement) {
    var target = this;
    while(target.indexOf(search) > -1){
        target = target.replace(search, replacement);
    }
    return target;
};

String.prototype.TrimStart = function (startingtext){
    var target = this;
    var start = target.indexOf(startingtext);
    if(target.indexOf(startingtext) < 0) return target;
    return target.right(target.length - start - startingtext.length);
}

String.prototype.GetBetween = function (startingtext, endingtext) {
    var target = this;
    if(target.indexOf(startingtext) < 0 || target.indexOf(endingtext) < 0) return "";
    var SP = target.indexOf(startingtext)+startingtext.length;
    var string1 = target.substr(0,SP);
    var string2 = target.substr(SP);
    var TP = string1.length + string2.indexOf(endingtext);
    return target.substring(SP,TP).trim();
};

function copy(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    var bodyRect = document.body.getBoundingClientRect().top;
    textArea.focus();
    textArea.select();
    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        var ret = true;
    } catch (err) {
        var ret = false;
    }

    document.body.removeChild(textArea);
    window.scrollTo(0, -bodyRect);
    return ret;
}

var jq = document.createElement('script');
jq.src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js";
document.getElementsByTagName('head')[0].appendChild(jq);

function getreviews(){
    if($(".container").length > 1){
        $(".container.header, .container.mt-md, .productMeta .container").remove();
        $("body").html( $(".container").html() );
    }
    var reviews = [];
    $(".cannabisProductReview").each(function(index){
        var review = {
            username: $(this).find(".cannabisProductReview__username").text(),
            rating: 0,
            text: $(this).find(".cannabisProductReview__description").text(),
            date: $(this).find(".cannabisProductReview__purchasedOn").text(),
        };
        $(this).find(".starRating span span").each(function(){
            review.rating += parseInt($(this).css("width").replace("px", ""));
        });
        if(review.text.length > 0){
            reviews.push(review);
        }
    });
    return reviews;
}

function reviews(){
    var HTML = PHP_stringify({reviews: getreviews()});
    var start = "[" + NEWLINE;
    start = start.length;
    HTML = "," + NEWLINE + HTML.mid(start, HTML.length - start * 2);
    copy(HTML);
}