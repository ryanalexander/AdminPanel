document.addEventListener('DOMContentLoaded', function() {
    M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'), {
        alignment: "right",
        coverTrigger: false,
        constrainWidth: false
    });
    M.FormSelect.init( document.querySelectorAll('select'), {});
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, {});
});
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.timepicker');
    var instances = M.Timepicker.init(elems, {});
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems, {});
});
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems, {});
});

dash = {
    alert:{
        queue:[],
        new:function(title,message,metadata){
            var id = dash.alert.queue.length;
            metadata={
                color:((metadata&&!!metadata.color)?metadata.color:'#67c7ff'),
                time:((metadata&&!!metadata.time)?metadata.time:null)
            };
            dash.alert.queue[id]=({
                "id":id,
                "title":title,
                "message":message,
                "initiator":['manual']
            });
            if(document.getElementById("dash_alert")===null){
                document.getElementsByTagName("body")[0].appendChild(function(){
                    var abox = document.createElement("div");
                    abox.id="dash_alert";
                    abox.style.overflowY="scroll";
                    abox.style.msOverflowStyle="none";
                    abox.style.scrollbarWidth="none";
                    abox.style.display="block";
                    abox.style.position="fixed";
                    abox.style.width="15%";
                    abox.style.height="100%";
                    abox.style.right="0%";
                    abox.style.top="0";
                    abox.style.pointerEvents="none";
                    return abox;
                }());
                push();
            }else{push();}
            function push(){
                document.getElementById("dash_alert").appendChild(function(){
                    var abox = document.createElement("div");
                    abox.id="alert_"+id;
                    abox.style.marginTop="5%";
                    abox.style.marginRight="-100%";
                    abox.style.top="0";
                    abox.style.boxShadow="1px 1px 4px #0000003d";
                    abox.style.display="block";
                    abox.style.width="90%";
                    abox.style.float="right";
                    abox.style.right="0%";
                    abox.style.fontFamily="sans-serif";
                    abox.style.background="rgb(255, 255, 255)";
                    abox.style.color="#000";
                    abox.style.borderRight=`4px solid ${metadata.color}`;
                    abox.style.padding="4%";
                    abox.style.transition="0.5s ease";
                    abox.style.pointerEvents="auto";
                    setTimeout(()=>{
                        abox.style.marginRight="5%";
                        abox.style.marginTop="5%";
                    },50);
                    if(metadata.time!==null){
                        setTimeout(()=>{
                            if(dash.alert.queue[id]!==-1){
                                dash.alert.dismiss(id);
                            }
                        },metadata.time);
                    }
                    abox.onclick=()=>{
                        dash.alert.dismiss(id);
                    };
                    abox.innerHTML="<span class='title' style='display:block;font-weight:bold;font-size:25px;padding:4% 4% 0;'>"+title+"</span><span class='message' style='display:block;font-weight:normal;font-size:15px;padding:2% 4% 4%;'>"+message+"</span>";
                    return abox;
                }());
            }
            return false;},
        list:function(){return dash.alert.queue},
        dismiss:function(id){
            dash.alert.queue[id]=-1;
            var abox = document.getElementById("alert_"+id);
            abox.style.marginRight="-100%";
            setTimeout(function(){
                abox.parentNode.removeChild(abox);
            },1000);
            return false;}
    }
}