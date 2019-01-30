var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
var is_android = navigator.userAgent.toLowerCase().indexOf('android') > -1;
var is_chrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
var is_firefox_for_android = is_firefox && is_android;
var fade_speed = 600;

function log(text){
    console.log(text);
}

String.prototype.isEqual = function (str) {
    if (isUndefined(str)) {
        return false;
    }
    if (isNumeric(str) || isNumeric(this)) {
        return this == str;
    }
    return this.toUpperCase().trim() == str.toUpperCase().trim();
};

function isUndefined(variable) {
    return typeof variable === 'undefined';
}

function isArray(variable) {
    return Array.isArray(variable);
}

//returns true if $variable appears to be a valid number
function isNumeric(variable) {
    return !isNaN(Number(variable));
}

function isJSON(text){
    try{
        var json = JSON.parse(text);
        return true;
    } catch(e) {
        return false;
    }
}

function removeExtension(filename){
    var lastDotPosition = filename.lastIndexOf(".");
    if (lastDotPosition === -1) return filename;
    else return filename.substr(0, lastDotPosition);
}

function getExtension(filename){
    return filename.substring(filename.lastIndexOf('.')+1, filename.length) || filename;
}

//returns true if $variable appears to be a valid object
//typename (optional): the $variable would also need to be of the same object type (case-sensitive)
function isObject(variable, typename) {
    if (typeof variable == "object") {
        if (isUndefined(typename)) {
            return true;
        }
        return variable.getName().toLowerCase() == typename.toLowerCase();
    }
    return false;
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

String.prototype.GetBetween = function (startingtext, endingtext) {
    var target = this;
    if(target.indexOf(startingtext) < 0 || target.indexOf(endingtext) < 0) return false;
    var SP = target.indexOf(startingtext)+startingtext.length;
    var string1 = target.substr(0,SP);
    var string2 = target.substr(SP);
    var TP = string1.length + string2.indexOf(endingtext);
    return target.substring(SP,TP);
};

String.prototype.SetSlice = function (Start, End, ReplaceText) {
    var target = this;
    return target.left(Start) + ReplaceText + target.right(target.length - End);
};

Number.prototype.pad = function (size, rightside) {
    var s = String(this);
    if (isUndefined(rightside)) {
        rightside = false;
    }
    while (s.length < (size || 2)) {
        if (rightside) {
            s = s + "0";
        } else {
            s = "0" + s;
        }
    }
    return s;
};

//returns the right $n characters of a string
String.prototype.right = function (n) {
    return this.substring(this.length - n);
};

function right(text, length) {
    return String(text).right(length);
}

//returns true if $variable appears to be a valid function
function isFunction(variable) {
    var getType = {};
    return variable && getType.toString.call(variable) === '[object Function]';
}

//replaces all instances of $search within a string with $replacement
String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    if (isArray(search)) {
        for (var i = 0; i < search.length; i++) {
            if (isArray(replacement)) {
                target = target.replaceAll(search[i], replacement[i]);
            } else {
                target = target.replaceAll(search[i], replacement);
            }
        }
        return target;
    }
    return target.replace(new RegExp(search, 'g'), replacement);
};

String.prototype.between = function (leftside, rightside) {
    var target = this;
    var start = target.indexOf(leftside);
    if (start > -1) {
        var finish = target.indexOf(rightside, start);
        if (finish > -1) {
            return target.substring(start + leftside.length, finish);
        }
    }
};

function storageAvailable(type) {
    try {//types: sessionStorage, localStorage
        var storage = window[type], x = '__storage_test__';
        storage.setItem(x, x);
        storage.removeItem(x);
        return true;
    } catch(e) {
        return false;
    }
}
var uselocalstorage = storageAvailable('localStorage');
console.log("Local storage is available: " + iif(uselocalstorage, "Yes", "No (use cookie instead)"));
function hasItem(c_name){
    if(uselocalstorage){
        return window['localStorage'].getItem(c_name) !== null;
    } else {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x == c_name) {
                return true;
            }
        }
    }
    return false;
}

function setCookie(c_name, value, exdays) {
    if(uselocalstorage){
        window['localStorage'].setItem(c_name, value);
    } else {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = value + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
        c_value = c_name + "=" + c_value + ";path=/;";
        document.cookie = c_value;
    }
}

//gets a cookie value
function getCookie(c_name) {
    if(hasItem(c_name)){
        return window['localStorage'].getItem(c_name);
    }
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return unescape(y);
        }
    }
}

//deletes a cookie value
function removeCookie(cname, forcecookie) {
    if(isUndefined(forcecookie)){forcecookie = false;}
    if (isUndefined(cname)) {//erase all cookies
        var cookies = document.cookie.split(";");
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            removeCookie(name, true);
        }
        if(uselocalstorage) {
            cookies = Object.keys(window['localStorage']);
            for (var i = 0; i < cookies.length; i++) {
                removeCookie(cookies[i]);
            }
        }
    } else if(hasItem(cname) && !forcecookie){
        window['localStorage'].removeItem(cname);
    } else {
        document.cookie = cname + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;";
    }
}

function focuson(selector){
    $(selector).focus();
    //$('html, body').animate({scrollTop: $(selector).offset().top}, 1000);
}

//creates a cookie value that expires in 1 year
function createCookieValue(cname, cvalue) {
    //log("Creating cookie value: '" + cname + "' with: " + cvalue);
    setCookie(cname, cvalue, 365);
}

function getform(Selector, IncludeType) {
    var data = $(Selector).serializeArray();
    var ret = {};
    for (var i = 0; i < data.length; i++) {
        if(!data[i].name.startswith("omit_")) {
            ret[data[i].name] = data[i].value.trim();
        }
    }
    $(Selector + " input:checkbox:not(:checked)").each(function (index) {
        if($(this).hasAttr("name")){
            ret[$(this).attr("name")] = "off";
        }
    });
    if(!isUndefined(IncludeType) && IncludeType){
        for (var key in ret) {
            ret[key] = {value: ret[key], type: inputtype(Selector, key)};
        }
    }
    return ret;
}

function inputtype(FormSelector, InputName){
    var element = $(FormSelector + " [name=" + InputName + "]");
    if(element.length == 0){return;}
    var ret = element.get(0).tagName.toLowerCase();
    if(ret == "input"){
        if (element.hasAttr("type")){
            ret = element.attr("type").toLowerCase();
        }
    }
    return ret;
}

function visible(selector, status) {
    if (isUndefined(status)) {status = false;}
    if (status) {
        $(selector).show();
    } else {
        $(selector).hide();
    }
}

$.fn.hasAttr = function (name) {
    return this.attr(name) !== undefined;
};

function isphonenumber(Data){
    Data = Data.replace(/\D/g, "");
    if (Data.substr(0, 1) == "0") {
        return false;
    }
    return Data.length == 10;
}

function findwhere(data, key, value) {
    for (var i = 0; i < data.length; i++) {
        if (data[i][key].isEqual(value)) {
            return i;
        }
    }
    return -1
}

function fadetext(selector, newtext){
    $(selector).fadeOut(fade_speed, function () {
        $(selector).html(newtext).fadeIn(fade_speed);
    });
}

function filternumeric(text){
    return text.replace(/[0-9]/g, '');
}
function filternonnumeric(text){
    return text.replace(/\D/g,'');
}

function getIterator(arr, key, value) {
    for (var i = 0; i < arr.length; i++) {
        if (arr[i][key] == value) {
            return i;
        }
    }
    return -1;
}

function rnd(min, max) {
    return Math.round(Math.random() * (max - min) + min);
}

function now() {
    if(testing){return newtime;}
    var now = new Date();
    return now.getHours() * 100 + now.getMinutes();
}

function validateEmail(value) {
    var input = document.createElement('input');
    input.type = 'email';
    input.required = true;
    input.value = value;
    return typeof input.checkValidity === 'function' ? input.checkValidity() : /\S+@\S+\.\S+/.test(value);
}

function toclassname(text) {
    return text.toLowerCase().replaceAll(" ", "_");
}

function makeplural(value, singular, plural){
    if(value == 1){return singular;}
    if(isUndefined(plural)){return singular + "s";}
    return plural;
}

function ucfirst(text) {
    return text.left(1).toUpperCase() + text.right(text.length - 1);
}

function iif(value, iftrue, iffalse) {
    if (value) {return iftrue;}
    if (isUndefined(iffalse)) {return "";}
    return iffalse;
}

function scrolltobottom() {
    $('html,body').animate({scrollTop: document.body.scrollHeight}, "slow");
}

function isReady(){
    return document.readyState === 'complete';
}

function fallbackCopyTextToClipboard(text) {
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

function getcontents(target){
    var vartype = typeof target;
    if(vartype == "object"){
        vartype = $(target).prop("tagName").toLowerCase();
        switch(vartype){
            case "input":
                vartype = $(target).attr("type").toLowerCase();
                switch(vartype){
                    case "checkbox": case "radio":
                    var value = $(target).prop('checked');
                    if(value){target = 1;} else {target = "";}
                    default: target = $(target).val();
                }
                break;
            default: target = $(target).text();
        }
    }
    return target;
}

function truncate(text, digits){
    if(text.length>digits){return text.left(digits) + "...";}
    return text;
}

function copy(target){
    target = getcontents(target);
    toast("Copied '" + truncate(target, 100) + "'");
    if(isphonenumber(target)){
        target = filternonnumeric(target);
    }
    fallbackCopyTextToClipboard(target);
}

function dateformat(format){
    if(isUndefined(format)){
        format = "Y-m-d";
    }
    var today = new Date();
    var daysinmonth = new Date(today.getFullYear(), today.getMonth()+1, 0).getDate();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    var dayofweek = today.getDay();
    format = format.replaceAll("j", dd);//day no leading 0
    format = format.replaceAll("n", dd);//month no leading 0
    format = format.replaceAll("Y", yyyy);//year
    format = format.replaceAll("y", yyyy % 100);//2 digit year
    format = format.replaceAll("M", month_names[mm-1]);//month name
    format = format.replaceAll("n", month_names[mm-1].left(3));//month name 3 digits
    format = format.replaceAll("t", daysinmonth);//days in month
    format = format.replaceAll("w", dayofweek);//day of week
    format = format.replaceAll("l", daysofweek[dayofweek]);//day of week name
    format = format.replaceAll("D", daysofweek[dayofweek].left(3));//day of week name 3 digits
    if(dayofweek == 0){dayofweek = 7;}
    format = format.replaceAll("N", dayofweek);//day of week ISO-8601
    format = format.replaceAll("d", dd.pad(2));//day leading 0
    format = format.replaceAll("m", mm.pad(2));//month leading 0
    var hours = today.getHours();
    var minutes = today.getMinutes();
    var seconds = today.getSeconds();
    var AMPM = "AM";
    format = format.replaceAll("i", minutes.pad(2));//minutes leading 0
    format = format.replaceAll("s", seconds.pad(2));//seconds leading 0
    format = format.replaceAll("G", hours);//hours (0-23) no leading 0
    format = format.replaceAll("H", hours.pad(2));//hours (0-23) leading 0
    if(hours > 11){
        AMPM = "PM";
        hours = hours - 12;
        if(hours == 0){
            hours = 12;
        }
    }
    format = format.replaceAll("g", hours);//hours (1-12) no leading 0
    format = format.replaceAll("h", hours.pad(2));//hours (01-12) leading 0
    format = format.replaceAll("A", AMPM);//AM/PM
    format = format.replaceAll("a", AMPM.toLowerCase());//am/pm
    return format;
}