init = (key,is_dedicated)=>{
    console.log("Authenticated with "+key);
    let icons = {
        API:"api",
        DAEMON:"dns",
        SQL:"disc_full"
    };

    let checkStatus = function (key, is_dedicated) {
        $.get("https://api.mcg.gg/v1/data/status", {key: key}, (reply, err) => {
            processData(is_dedicated, reply.data);
        }).fail((e) => {
            if (e.status === 403) window.location = "./logout.php";
            if (e.statusText === "error")
                processData(is_dedicated, {API: false});
        });
    }

    let processData = function (dedicated, data) {
        var service_offline = false;
        if (dedicated) {
            console.log("Following dedicated");
            document.getElementById("status-list").innerHTML="";
            for (let service in data){
                console.log("Appending "+service+" with state "+(data[service]?"online":"offline"));
                let container = document.createElement("li");
                let header = document.createElement("div");
                let body = document.createElement("div");
                let icon = document.createElement("span");

                let badge = document.createElement("span");
                let badge_span = document.createElement("span");

                badge.classList.add("badge")

                badge_span.classList.add("btn-floating","badge", "material-icons");
                badge_span.style.verticalAlign="text-bottom";
                badge_span.innerText="warning";

                badge.append(badge_span);

                icon.classList.add("material-icons");
                header.classList.add("collapsible-header");
                body.classList.add("collapsible-body");

                header.style.width="100%";
                icon.style.verticalAlign="middle";
                icon.style.paddingRight="1em";

                icon.innerText=icons[service.toUpperCase()];
                header.append(icon)
                header.append(service+"");

                header.append(badge);

                container.append(header);

                if(!data[service]){
                    body.innerText="Shit is down";
                    badge_span.classList.add("red","pulse","white-text");
                    container.append(body);
                }else {
                    badge_span.innerText="info"
                    badge_span.classList.add("blue","white-text");
                }

                document.getElementById("status-list").append(container);
            }

            // Show all
        }
        for (let service in data)
            if (data[service] === false)
                service_offline = true;
        if (service_offline) $("#critical_offline").show();
        if (!service_offline) $("#critical_offline").hide();
    }
    checkStatus(key,is_dedicated);
    setInterval(()=>checkStatus(key,is_dedicated),15000);

}