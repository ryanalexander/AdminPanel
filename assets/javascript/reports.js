key = "";
init = (access_token)=> {
    key=access_token;
    let to_resolve = "";
    $.get("https://api.mcg.gg/v1/data/reports", {key: key}, (reply, err) => {
        reply.reports.forEach(report => {

            if(to_resolve.indexOf(report.reportee)<=-1&&report.reportee!=="null")
                to_resolve+=(report.reportee)+",";
            if(to_resolve.indexOf(report.reported)<=-1&&report.reported!=="null")
                to_resolve+=(report.reported)+",";

            let container = document.createElement("tr");
            let reportee = document.createElement("td");
            let reported = document.createElement("td");
            let reason = document.createElement("td");

            reportee.innerText = "?"+report.reportee;
            reported.innerText = "?"+report.reported;
            reason.innerText = report.reason;
            container.append(reportee);
            container.append(reported);
            container.append(reason);

            document.getElementById("reports").append(container);
        });
        lookupIds(to_resolve.substr(0,to_resolve.length-1),(resolved)=>{
            resolved.forEach(admin=>{
                replaceText("*","(\\?"+admin.uuid+")",admin.username,"g")
            })
        });
    }).fail((e)=>{
        if(e.status===403)window.location="./logout.php";
    });
};

lookupIds = (uuids,cb)=>{

    $.get("https://api.mcg.gg/v1/bulk_uuid", {key: key, players: uuids}, (reply, err) => {
        cb(reply.data);
    }).fail((e)=>{
        if(e.status===403)window.location="./logout.php";
    });
}

window.onhashchange = ()=>{
    init();
}

function translateTime(time){
    var x = time/1000;
    var seconds = Math.round(x % 60);
    x/=60;
    var minutes = Math.round(x % 60);
    x/=60;
    var hours = Math.round(x % 24);
    x/=24;
    var days = Math.round(x % 365);
    x/=365
    var years = Math.round(x);

    return (years>0?years+"Y ":"")+(days>0?days+"D ":"")+(hours>0?hours+"H ":"")+(minutes>0?minutes+"M ":"")+(seconds>0?seconds+"S ":"");
}
function replaceText(selector, text, newText, flags) {
    var matcher = new RegExp(text, flags);
    $(selector).each(function () {
        var $this = $(this);
        if (!$this.children().length)
            $this.text($this.text().replace(matcher, newText));
    });
}
