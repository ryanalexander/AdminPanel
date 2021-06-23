key = "";
init = (access_token)=> {
    key=access_token;
    let to_resolve = "";
    $.get("https://api.mcg.gg/v1/data/audit", {key: key, limit: 10, page:2}, (reply, err) => {
        reply.actions.forEach(log_entry => {

            if(to_resolve.indexOf(log_entry.staff)<=-1&&log_entry.staff!=="null"&&log_entry.staff.length===36)
                to_resolve+=(log_entry.staff)+",";
            if(to_resolve.indexOf(log_entry.target)<=-1&&log_entry.target!=="null"&&log_entry.target.length===36)
                to_resolve+=(log_entry.target)+",";

            let container = document.createElement("tr");
            let time = document.createElement("td");
            let staff = document.createElement("td");
            let action = document.createElement("td");
            let target = document.createElement("td");
            let args = document.createElement("td");

            staff.innerText = "?"+log_entry.staff;
            target.innerText = "?"+log_entry.target;

            time.innerText = log_entry.timestamp;

            action.innerText = log_entry.action;

            args.innerText = log_entry.args;

            container.append(time);
            container.append(staff);
            container.append(action);
            container.append(target);
            container.append(args);

            document.getElementById("logs").append(container);
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
