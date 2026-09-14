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

window.dateFormat = function(dt) {
    const date = new Date(dt);
    const fmt = new Intl.DateTimeFormat('en-US', { 
        year: 'numeric', month: 'long', day: 'numeric' 
    });
    return fmt.format(date);
    // const options = { year: 'numeric', month: 'long', day: 'numeric' };
    // return date.toLocaleDateString('en-US', options);
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

window.getCurrentDate = function(dt) {
    const cd = new Date();
    if(dt == 'y') {
        return cd.getFullYear(); // returns e.g. 2026
    } else if(dt == 'm') {
        return cd.getMonth() + 1; // returns 0 - 11
    } else if(dt == 'd') {
        return cd.getDate(); // returns between 1 and 31
    } else if(dt == 'h') {
        return cd.getHours(); // returns 0 - 23
    } else if(dt == 'i') {
        return cd.getMinutes(); // returns 0 - 59
    } else if(dt == 's') {
        return cd.getSeconds(); // returns 0 - 59
    }
};

window.initYearSelection = function(arr, from, to) {
    for(let i = to; i >= from; i--) {
        arr.push(i);
    }   
    return arr;
};

window.getFullDateByYearMonth = function(year, month) {
    if(month == "Jan" || month == "January") {
        return `${year}-01-01 08:00:00`;
    } else if(month == "Feb" || month == "February") {
        return `${year}-02-01 08:00:00`;
    } else if(month == "Mar" || month == "March") {
        return `${year}-03-01 08:00:00`;
    } else if(month == "Apr" || month == "April") {
        return `${year}-04-01 08:00:00`;
    } else if(month == "May" || month == "May") {
        return `${year}-05-01 08:00:00`;
    } else if(month == "Jun" || month == "June") {
        return `${year}-06-01 08:00:00`;
    } else if(month == "Jul" || month == "July") {
        return `${year}-07-01 08:00:00`;
    } else if(month == "Aug" || month == "August") {
        return `${year}-08-01 08:00:00`;
    } else if(month == "Sep" || month == "September") {
        return `${year}-09-01 08:00:00`;
    } else if(month == "Oct" || month == "October") {
        return `${year}-10-01 08:00:00`;
    } else if(month == "Nov" || month == "November") {
        return `${year}-11-01 08:00:00`;
    } else if(month == "Dec" || month == "December") {
        return `${year}-12-01 08:00:00`;
    } else {
        return dateTimeNowFormatter('datetime', false, false);
    }
};

window.getFullMonthWord = function(month) {
    if(month == "Jan") {
        return "January";
    } else if(month == "Feb") {
        return "February";
    } else if(month == "Mar") {
        return "March";
    } else if(month == "Apr") {
        return "April";
    } else if(month == "May") {
        return month;
    } else if(month == "Jun") {
        return "June";
    } else if(month == "Jul") {
        return "July";
    } else if(month == "Aug") {
        return "August";
    } else if(month == "Sep") {
        return "September";
    } else if(month == "Oct") {
        return "October";
    } else if(month == "Nov") {
        return "November";
    } else if(month == "Dec") {
        return "December";
    } 
};

window.array_sum = function(numbers) {
    return numbers.reduce((total, num) => total + num, 0);
};