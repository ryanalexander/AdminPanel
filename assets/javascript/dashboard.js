key = "";
init = (access_token)=> {
    key=access_token;
    to_resolve="";
    $.get("https://api.mcg.gg/v1/data/stats/recent", {key: key,limit: 5}, (reply, err) => {
        reply.players.forEach(player => {

            let container = document.createElement("tr");
            let id = document.createElement("td");
            let username = document.createElement("td");
            let lookup = document.createElement("td");

            id.innerText = player.id;
            username.innerText = player.username;
            lookup.innerHTML = "<a href='./lookup.php#"+player.uuid+"' style='text-align:center;'><span class='material-icons orange-text'>info</span></a>";
            container.append(id);
            container.append(username);
            container.append(lookup);

            document.getElementById("recent_players").append(container);
        });
    }).fail((e)=>{
        if(e.status===403)window.location="./logout.php";
    });
    $.get("https://api.mcg.gg/v1/data/stats/current", {key: key}, (reply, err) => {
        data = reply['data'];
        $("#players-current").html(data['players']['cur']);
        $("#players-max").html(data['players']['max']);
        $("#proxies-current").html(data['servers']['proxy']);
        $("#minecraft-current").html(data['servers']['minecraft']);
        $("#dedicated-current").html(data['servers']['dedicated']);
    }).fail((e)=>{
        if(e.status===403)window.location="./logout.php";
    });
    $.get("https://api.mcg.gg/v1/data/stats/punishments", {key: key,limit: 5}, (reply, err) => {
        reply.punishments.forEach(punishment => {

            let container = document.createElement("tr");
            let id = document.createElement("td");
            let type = document.createElement("td");
            let player = document.createElement("td");
            let lookup = document.createElement("td");

            if(to_resolve.indexOf(punishment.player)<=-1&&punishment.player!=="null")
                to_resolve+=(punishment.player)+",";

            id.innerText = punishment.id;
            type.innerText = punishment.punishment;
            player.innerText = "?"+punishment.player;

            lookup.innerHTML = "<a href='./lookup.php#"+punishment.player+"' style='text-align:center;'><span class='material-icons orange-text'>info</span></a>";
            container.append(id);
            container.append(type);
            container.append(player);
            container.append(lookup);

            document.getElementById("recent_punishments").append(container);
        });
        lookupIds(to_resolve.substr(0,to_resolve.length-1),(resolved)=>{
            resolved.forEach(player=>{
                replaceText("*","(\\?"+player.uuid+")",player.username,"g")
            })
        });
    }).fail((e)=>{
        if(e.status===403)window.location="./logout.php";
    });
};

google.charts.load('current', {
    'packages':['geochart'],
    // Note: you will need to get a mapsApiKey for your project.
    // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
    'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
});
google.charts.setOnLoadCallback(drawRegionsMap);

function drawRegionsMap() {
    var data = google.visualization.arrayToDataTable([
        ['Country', 'Popularity'],
        ['Country', 'Popularity'],
        ['United States', 2],
        ['Australia',9999],
        ['UK', 1]
    ]);

    var options = {
        tooltip: {textStyle: {color: '#144003'}, showColorCode: true},
        backgroundColor: 'transparent',
        datalessRegionColor: '#eaeaea',
        defaultColor: '#9cff9c'
    };

    var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

    chart.draw(data, options);
}
lookupIds = (uuids,cb)=>{

    $.get("https://api.mcg.gg/v1/bulk_uuid", {key: key, players: uuids}, (reply, err) => {
        cb(reply.data);
    }).fail((msg)=>{
        if(msg.status===403)window.location="./logout.php";
    });
}
function replaceText(selector, text, newText, flags) {
    var matcher = new RegExp(text, flags);
    $(selector).each(function () {
        var $this = $(this);
        if (!$this.children().length)
            $this.text($this.text().replace(matcher, newText));
    });
}
