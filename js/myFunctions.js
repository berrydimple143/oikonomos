window.currencyFormatter = function(value, curr) {
    let currFormat = "en-PH";
    if(curr == "USD") {
        currFormat = "en-US";
    } else if(curr == "EUR") {
        currFormat = "de-DE";
    }
    const formatter = new Intl.NumberFormat(currFormat, {
        style: 'currency',
        currency: curr
    });
    return formatter.format(value);
};

window.currencyFormatterWithChecking = function(value, curr, label) {
    if(label == "Attendance") {
        return value + " people";
    } else {
        return currencyFormatter(value, curr);
    }
};

window.dateTimeNowFormatter = function(tp) {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    if(tp == "datetime") {
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    } else if(tp == "date") {
        return `${year}-${month}-${day}`;
    } else if(tp == "year") {
        return `${year}`;
    } else if(tp == "month") {
        return `${month}`;
    } else if(tp == "day") {
        return `${day}`;
    } else if(tp == "hour") {
        return `${hours}`;
    } else if(tp == "minute") {
        return `${minutes}`;
    } else if(tp == "second") {
        return `${seconds}`;
    }    
};