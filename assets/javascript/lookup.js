key = "";
let player;
let online = false;
let rate_limit = 0;
init = (access_token)=> {
    if(key==="")key=access_token;
    $("#punishment-history").html("");
    $("#report-history").html("");

    $("#rank-select").unbind().on("change",(e)=>{
        if(rate_limit-(new Date().getSeconds())&&rate_limit!==0){
            // Rate limit
            dash.alert.new("Wow slow down","You are being rate limited!",{color:"red"});

        }else {
            rate_limit=(new Date().getSeconds()+5000);
            $.ajax({
                method: 'PUT',
                url: `https://api.mcg.gg/v1/players/${player.uuid}/rank?key=${key}`,
                contentType: 'application/json',
                data: JSON.stringify({rank: $("#rank-select").val()}),
                dataType: 'json'
            }).done(() => {
                dash.alert.new("Rank set", `${player.username}'s new rank is ${$("#rank-select").val()}`);
                init();
            }).fail((msg) => {
                if (msg.status === 403) window.location = "./logout.php";
            });
        }
    });

    $("#ban_submit").unbind().click(()=>{
        $.ajax({
            method: 'PUT',
            url: `https://api.mcg.gg/v1/players/${player.uuid}/punishments?key=${key}`,
            contentType: 'application/json',
            data: JSON.stringify({type:"BAN",reason:$("#ban_reason").val(),notes:$("#ban_notes").val()}),
            dataType: 'json'
        }).done(()=>{
            dash.alert.new("Banned Player",`${player.username} has been banned for ${$("#ban_reason").val()}`);
            init();
        }).fail((msg)=>{
            if(msg.status===403)window.location="./logout.php";
            dash.alert.new(`Failed to ban ${player.username}`,msg.responseJSON.error,{color:"red"});
        });
    });
    $("#mute_submit").unbind().click(()=>{
        $.ajax({
            method: 'PUT',
            url: `https://api.mcg.gg/v1/players/${player.uuid}/punishments?key=${key}`,
            contentType: 'application/json',
            data: JSON.stringify({type:"MUTE",reason:$("#mute_reason").val(),notes:$("#mute_notes").val()}),
            dataType: 'json'
        }).done(()=>{
            dash.alert.new("Muted Player",`${player.username} has been muted for ${$("#mute_reason").val()}`);
            init();
        }).fail((msg)=>{
            if(msg.status===403)window.location="./logout.php";
            dash.alert.new(`Failed to mute ${player.username}`,msg.responseJSON.error,{color:"red"});
        });
    });
    $("#warn_submit").unbind().click(()=>{
        $.ajax({
            method: 'PUT',
            url: `https://api.mcg.gg/v1/players/${player.uuid}/punishments?key=${key}`,
            contentType: 'application/json',
            data: JSON.stringify({type:"WARN",reason:$("#warn_reason").val(),notes:$("#warn_notes").val()}),
            dataType: 'json'
        }).done(()=>{
            dash.alert.new("Warned Player",`${player.username} has been warned for ${$("#warn_reason").val()}`);
            init();
        }).fail((msg)=>{
            if(msg.status===403)window.location="./logout.php";
            dash.alert.new(`Failed to warn ${player.username}`,msg.responseJSON.error,{color:"red"});
        });
    });
    $("#kick_submit").unbind().click(()=>{
        if(!online){
            dash.alert.new("Failed to kick player","The specified player is not online!",{color:"red"});
            return;
        }
        $.ajax({
            method: 'PUT',
            url: `https://api.mcg.gg/v1/players/${player.uuid}/punishments?key=${key}`,
            contentType: 'application/json',
            data: JSON.stringify({type:"KICK",reason:$("#kick_reason").val(),notes:""}),
            dataType: 'json'
        }).done(()=>{
            dash.alert.new("Kicked Player",`${player.username} has been kicked for ${$("#kick_reason").val()}`);
            init();
        }).fail((msg)=>{
            if(msg.status===403)window.location="./logout.php";
            dash.alert.new(`Failed to Kick ${player.username}`,msg.responseJSON.error,{color:"red"});
        });
    });

    if(window.location.hash.replace("#","").length<2)return;
    $.get("https://api.mcg.gg/v1/players/"+window.location.hash.replace("#",""), {key: key}, (reply, err) => {
        player = reply.player;

        if(player===undefined){
            dash.alert.new("Error!","That player does not exist!",{color:"red"});
        }

        $("#username").html('<img src="https://crafatar.com/avatars/'+player.uuid+'" style="\n' +
            '    vertical-align: middle;\n' +
            '    width: 1.5em;\n' +
            '"> '+player.username)
        $("#uuid").val(player.uuid);
        $("#nickname").val("Coming soon");

        if(reply.connection!=null) {
            $("#online-status").text(`${reply.connection.server != null ? "Online - " + reply.connection.server + " for " + translateTime(reply.connection.session) : "Offline"}`)
            online=true;
        }else {
            online=false;
            $("#kick_submit").disable();
        }
        $("#last-ip").html(player.last_ip+" (<a href='https://check-host.net/ip-info?host="+player.last_ip+"' target='_blank'>INFO</a>)");

        $("#last-seen").text((new Date(parseInt(player.last_seen)).toLocaleDateString("en-US", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })));
        $("#first-seen").text((new Date(parseInt(player.first_joined)).toLocaleDateString("en-US", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })));

        $("#rank-select").val(player.ranks)
        M.FormSelect.getInstance($("#rank-select")).input.value = player.ranks;
        for(var rank in player.ranks)
            $("#rank-select[name='" + player.ranks[rank] + "']").select();

        $.get("https://api.mcg.gg/v1/players/"+player.uuid+"/punishments", {key: key, limit: 5}, (reply, err) => {
            let to_resolve = "";

            if(reply.punishments.length===0){
                let container = document.createElement("p");
                container.innerText="No history to show";

                document.getElementById("punishment-history").append(container);
            }
            reply.punishments.forEach(punishment => {

                if(to_resolve.indexOf(punishment.admin)<=-1&&punishment.admin!=="null")
                    to_resolve+=(punishment.admin)+",";

                let container = document.createElement("li");
                let type = document.createElement("i");
                let admin = document.createElement("span");
                let reason = document.createElement("p");
                let info = document.createElement("a");
                let info_icon = document.createElement("i");

                container.classList.add("collection-item","avatar")
                type.classList.add("material-icons","circle");
                admin.classList.add("title");
                info.classList.add("secondary-content");
                info_icon.classList.add("fa","fa-info-circle");

                switch (punishment.punishment) {
                    case "KICK":
                        type.innerText="meeting_room";
                        type.classList.add("blue");
                        break;
                    case "WARN":
                        type.innerText="note";
                        type.classList.add("orange");
                        break;
                    case "BAN":
                        type.innerText="gavel";
                        type.classList.add("red");
                        break;
                    case "MUTE":
                        type.innerText="subtitles_off";
                        type.classList.add("indigo");
                        break;
                }

                admin.innerText=punishment.admin==="null"?"Console":"?"+punishment.admin;
                reason.innerText=punishment.reason;

                container.append(type);
                container.append(admin);
                container.append(reason);
                info.append(info_icon);
                container.append(info);

                container.onclick=()=>viewPunishment(player.uuid,punishment.id);
                container.style.cursor="pointer";

                document.getElementById("punishment-history").append(container);
            });

            // Player Reports

            $.get("https://api.mcg.gg/v1/players/"+player.uuid+"/reports", {key: key, limit: 5}, (reply, err) => {

                if(reply.reports.length===0){
                    let container = document.createElement("p");
                    container.innerText="No history to show";

                    document.getElementById("report-history").append(container);
                }
                reply.reports.forEach(report => {

                    if(to_resolve.indexOf(report.reportee)<=-1&&report.reportee!=="null")
                        to_resolve+=(report.reportee)+",";
                    if(to_resolve.indexOf(report.reported)<=-1&&report.reported!=="null")
                        to_resolve+=(report.reported)+",";

                    let container = document.createElement("li");
                    let type = document.createElement("i");
                    let admin = document.createElement("span");
                    let reason = document.createElement("p");
                    let info = document.createElement("a");
                    let info_icon = document.createElement("i");

                    container.classList.add("collection-item","avatar")
                    type.classList.add("material-icons","circle");
                    admin.classList.add("title");
                    info.classList.add("secondary-content");
                    info_icon.classList.add("fa","fa-info-circle");

                    type.innerText="warning";
                    type.classList.add("orange");

                    admin.innerText="?"+report.reportee;
                    reason.innerText=report.reason;

                    container.append(type);
                    container.append(admin);
                    container.append(reason);
                    info.append(info_icon);
                    container.append(info);

                    document.getElementById("report-history").append(container);
                });
                lookupIds(to_resolve.substr(0,to_resolve.length-1),(resolved)=>{
                    resolved.forEach(admin=>{
                        replaceText("*","(\\?"+admin.uuid+")",admin.username,"g")
                    })
                });
            }).fail((msg)=>{
                if(msg.status===403)window.location="./logout.php";
            });
        }).fail((msg)=>{
            if(msg.status===403)window.location="./logout.php";
        });
    });
};

viewPunishment = (uuid,id) => {
    $.get("https://api.mcg.gg/v1/players/"+uuid+"/punishments/"+id,{key:key},(reply)=>{
        let punishment = reply['punishments'][0];
        $("#punishment_admin").val(punishment.admin);
        $("#punishment_duration").val(punishment.expires)
        $("#punishment_reason").val(punishment.reason);
        date = new Date();
        date.setTime(punishment.issued);
        $("#punishment_time").val(date.toLocaleString());

        $("#punishment_type").val(punishment.punishment)
        M.FormSelect.getInstance($("#punishment_type")).input.value = punishment.punishment
        $("#rank-punishment_type[name='" + punishment.punishment + "']").select();

        $("#delete_punishment").unbind().click(e=>{
            deletePunishment(id)
        });
        $("#punishment_modal").modal('open');
    });
};
deletePunishment = (id) => {
    $.ajax({
        method: 'DELETE',
        url: `https://api.mcg.gg/v1/players/${player.uuid}/punishments?key=${key}`,
        contentType: 'application/json',
        data: JSON.stringify({id:id}),
        dataType: 'json'
    }).done(()=>{
        dash.alert.new("Punishment Deleted",`${id} has been removed`);
        init();
    }).fail((msg)=>{
        if(msg.status===403)window.location="./logout.php";
        dash.alert.new(`Failed to warn ${player.username}`,msg.responseJSON.error,{color:"red"});
    });
}

$("#search").keydown(e=>{
    if(e.keyCode===13){
        // Enter button
        window.location.hash=$("#search").val();
    }
});
$("#search_icon").unbind().click(e=>{
    window.location.hash=$("#search").val();
});

lookupIds = (uuids,cb)=>{

    $.get("https://api.mcg.gg/v1/bulk_uuid", {key: key, players: uuids}, (reply, err) => {
        cb(reply.data);
    }).fail((msg)=>{
        if(msg.status===403)window.location="./logout.php";
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
