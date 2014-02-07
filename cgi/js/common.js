/**
 * Project : Limba
 * File : common.js
 * Created by Ludovic Reenaers
 * Created on 20 janv. 2011
 * Project site : http://code.google.com/p/limba
 */
/**
 * Google maps additional JS
 */
var pois = new Array();
var geocoder;
var map;
var addedIds = new Array();
var maxi = 0;
var currentPos = 0;
var directionDisplay;
var directionsService = new google.maps.DirectionsService();

pois[0] = new Array();
pois[0]["addr"] = "Parc du Cinquantenaire 10, Bruxelles ";
pois[0]["name"] = "Mus es royaux d'art et d'histoire";
pois[0]["phone"] = "02 741 72 11";
pois[0]["type"] = "musee";
pois[0]["id"] = "1";

pois[1] = new Array();
pois[1]["addr"] = "Rue de la Gare 19, Lustin";
pois[1]["name"] = "Mus e Bi res Belges asbl";
pois[1]["phone"] = " 081 41 11 02";
pois[1]["type"] = "musee";
pois[1]["id"] = "356";

pois[2] = new Array();
pois[2]["addr"] = "Rue de Fer 24, Namur";
pois[2]["name"] = "Mus e arch ologique de Namur";
pois[2]["phone"] = " 081 77 67 54";
pois[2]["type"] = "musee";
pois[2]["id"] = "3";

pois[3] = new Array();
pois[3]["addr"] = "8 Quai de Maestricht, Li ge";
pois[3]["name"] = "Le Grand Curtius";
pois[3]["phone"] = "04 221 94 04";
pois[3]["type"] = "musee b";
pois[3]["id"] = "36";

pois[4] = new Array();
pois[4]["addr"] = " Avenue Paul Pastur 11, Charleroi";
pois[4]["name"] = "Mus e de la photographie";
pois[4]["phone"] = "071 43 58 10";
pois[4]["type"] = "musee b";
pois[4]["id"] = "44";

pois[5] = new Array();
pois[5]["addr"] = "Rue de Nimy 76, Mons";
pois[5]["name"] = "Mundaneum asbl";
pois[5]["phone"] = "065 31 53 43";
pois[5]["type"] = "musee b";
pois[5]["id"] = "38";

function remItem(itemid) {
        listObj = document.getElementById("waypoints");
        Obj = document.getElementById(itemid);
        listObj.removeChild(Obj);
        j = 0;
        while (j < addedIds.length) {
                if (addedIds[j] == itemid) {
                        addedIds.splice(j, 1);
                } else {
                        j++;
                }
        }
}
function getElementPos(itemid) {
        for ( var i = 0; i < addedIds.length; i++) {
                if (addedIds[i] == itemid) {
                        tmp = i;
                }
        }
        return tmp;
}
function invertTabElement(obj1, obj2) {
        pos1 = getElementPos(obj1);
        pos2 = getElementPos(obj2);
        tmp = addedIds[pos2];
        addedIds[pos2] = addedIds[pos1];
        addedIds[pos1] = tmp;
}
function upItem(itemid) {
        currentPos = getElementPos(itemid);
        Obj = document.getElementById(itemid);
        if (currentPos - 1 <= 0) {
                previousintvalue = 0;
        } else {
                previousintvalue = currentPos - 1;
        }
        previousObj = document.getElementById(addedIds[previousintvalue]);
        listObj = document.getElementById("waypoints");
        listObj.insertBefore(Obj, previousObj);
        invertTabElement(Obj.id, previousObj.id);
}
function downItem(itemid) {
        currentPos = getElementPos(itemid);
        Obj = document.getElementById(itemid);
        if (currentPos < (addedIds.length - 1)) {
                listObj = document.getElementById("waypoints");
                if (currentPos == addedIds.length - 2) {
                        listObj.appendChild(Obj);
                        invertTabElement(addedIds[currentPos + 1], itemid);
                } else {
                        nextObj = document.getElementById(addedIds[currentPos + 2]);
                        listObj.insertBefore(Obj, nextObj);
                        invertTabElement(addedIds[currentPos + 1], itemid);
                }

        }
}

function arrayHasValue(arr, val) {
        bool = false;

        for ( var i = 0; i < arr.length; i++) {
                if (arr[i] == val) {
                        bool = true;
                }
        }
        return bool;
}

function addIt(id) {
        if (!arrayHasValue(addedIds, id)) {
                myul = document.getElementById("waypoints");
                myli = document.createElement("li");
                myli.id = id;

                if (addedIds.length % 2 == 0) {

                        myli.className = "lipair";
                } else {

                        myli.className = "liimpair";
                }

                myli.title = pois[id]["addr"];
                myli.innerHTML = pois[id]["name"]
                + ' <img src="up.gif" onclick="upItem(this.parentNode.id);" alt="up" title="up"/> &nbsp<img src="down.gif" onclick="downItem(this.parentNode.id);" alt="down" title="down"/> &nbsp <img src="remove.gif" onclick="remItem(this.parentNode.id);" alt="remove" title="remove"/>';
                myul.appendChild(myli);
                addedIds.push(id);
        }
}
function codeAddress(id, poitab) {
        var address = poitab["addr"];
        geocoder.geocode({
                'address' : address
        }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                                map : map,
                                position : results[0].geometry.location
                        });
                        marker.setTitle(poitab["name"]);
                        var addlnk = '<span class="addlnk" onclick="addIt(' + id
                        + ')"><u>Ajouter   l\'itin raire</u></span>';
                        var msg = "<b>" + poitab["name"] + "</b><br/>" + poitab["addr"]
                        + "<br/>" + poitab["phone"] + "<br/>" + addlnk;
                        var infowindow = new google.maps.InfoWindow({
                                content : msg
                        });
                        google.maps.event.addListener(marker, 'click', function() {
                                infowindow.open(map, marker);
                        });
                        poitab["marker"] = marker;
                } else {
                        alert("Geocode was not successful for the following reason: "
                                        + status + " For " + address);
                }
        });
}
function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
        geocoder = new google.maps.Geocoder();
        var myLatlng = new google.maps.LatLng(50.501199, 4.76944);
        var myOptions = {
                        zoom : 9,
                        center : myLatlng,
                        mapTypeControl : true,
                        mapTypeControlOptions : {
                                style : google.maps.MapTypeControlStyle.DROPDOWN_MENU
                        },
                        zoomControl : true,
                        zoomControlOptions : {
                                style : google.maps.ZoomControlStyle.SMALL
                        },
                        mapTypeId : google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById("routePanel"));
        var ctaLayer = new google.maps.KmlLayer(
        'http://stagiaires.ressource-toi.org/~lreenaers/road_fr.kml');
        ctaLayer.setMap(map);
        for ( var i = 0; i < pois.length; i++) {
                codeAddress(i, pois[i]);
        }
}
function calcRoute() {
        var selec = document.getElementById("selector");
        var li_elements = selec.getElementsByTagName("li");
        var start;
        var end;
        var waypts = [];

        for ( var i = 0; i < li_elements.length; i++) {
                if (i == 0) {
                        start = li_elements[i].title;
                } else if (i == (li_elements.length - 1)) {
                        end = li_elements[i].title;
                } else {
                        waypts.push({
                                location : li_elements[i].title,
                                stopover : true
                        });
                }
        }
        var optimized = document.getElementById("optim").checked;
        var request = {
                        origin : start,
                        destination : end,
                        waypoints : waypts,
                        optimizeWaypoints : optimized,
                        travelMode : google.maps.DirectionsTravelMode.DRIVING
        };

        directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {

                        directionsDisplay.setDirections(response);
                }
        });

        var toolsdiv = document.getElementById("maptools");

        toolsdiv.innerHTML = '<img src="/img/internals/print.png" class="print" alt="Imprimer" title="Imprimer" onclick="print();" width="18px" height="18px"/>';

}
function print() {
        window.open('/html/templates/PRINT.html');
}
function validateMarker(chk) {
        var visible = chk.checked;
        var typ = chk.value;
        for ( var i = 0; i < pois.length; i++) {
                if (pois[i]["type"] == typ) {
                        var mrk = pois[i]["marker"];
                        mrk.setVisible(visible);
                }
        }
}
/**
 * Modal Window JS
 */
$(document)
.ready(
                function() {
                        // When you click on a link with class of poplight and the
                        // href starts with a #
                        $('a.poplight[href^=#]')
                        .click(
                                        function() {
                                                var popID = $(this).attr('rel'); // Get
                                                // Popup
                                                // Name
                                                var popURL = $(this).attr('href'); // Get
                                                // Popup
                                                // href
                                                // to
                                                // define
                                                // size

                                                // Pull Query & Variables from href URL
                                                var query = popURL.split('?');
                                                var dim = query[1].split('&');
                                                var popWidth = dim[0].split('=')[1];
                                                var popHeight = dim[1].split('=')[1];
                                                // Fade in the Popup and add close
                                                // button
                                                $('#' + popID).fadeIn().css({
                                                        'height' : popHeight + '%'
                                                });
                                                $('#' + popID)
                                                .fadeIn()
                                                .css({
                                                        'width' : popWidth + '%'
                                                })
                                                .prepend(
                                                '<a href="#" class="close"><img src="/img/internals/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>');

                                                // Define margin for center alignment
                                                // (vertical horizontal) - we add 80px
                                                // to the height/width to accomodate for
                                                // the padding and border width defined
                                                // in the css
                                                var popMargTop = ($('#' + popID)
                                                                .height() + 80) / 2;
                                                var popMargLeft = ($('#' + popID)
                                                                .width() + 80) / 2;

                                                // Apply Margin to Popup
                                                $('#' + popID).css({
                                                        'margin-top' : -popMargTop,
                                                        'margin-left' : -popMargLeft
                                                });

                                                // Fade in Background
                                                $('body').append(
                                                '<div id="fade"></div>'); // Add
                                                // the
                                                // fade
                                                // layer
                                                // to
                                                // bottom
                                                // of
                                                // the
                                                // body
                                                // tag.
                                                $('#fade').css({
                                                        'filter' : 'alpha(opacity=80)'
                                                }).fadeIn(); // Fade in the fade
                                                // layer -
                                                // .css({'filter' :
                                                // 'alpha(opacity=80)'})
                                                // is used to fix the IE
                                                // Bug on fading
                                                // transparencies
                                                initialize();
                                                return false;
                                        });
                        $('img.poplight[alt^=#]')
                        .click(
                                        function() {

                                                var popID = $(this).attr('name'); // Get
                                                // Popup
                                                // Name
                                                var popURL = $(this).attr('alt'); // Get
                                                // Popup
                                                // href
                                                // to
                                                // define
                                                // size

                                                // Pull Query & Variables from href URL
                                                var query = popURL.split('?');
                                                var dim = query[1].split('&');
                                                var popWidth = dim[0].split('=')[1];
                                                var popHeight = dim[1].split('=')[1];
                                                // Fade in the Popup and add close
                                                // button
                                                $('#' + popID).fadeIn().css({
                                                        'height' : popHeight + '%'
                                                });
                                                $('#' + popID)
                                                .fadeIn()
                                                .css({
                                                        'width' : popWidth + '%'
                                                })
                                                .prepend(
                                                '<a href="#" class="close"><img src="/img/internals/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>');

                                                // Define margin for center alignment
                                                // (vertical horizontal) - we add 80px
                                                // to the height/width to accomodate for
                                                // the padding and border width defined
                                                // in the css
                                                var popMargTop = ($('#' + popID)
                                                                .height() + 80) / 2;
                                                var popMargLeft = ($('#' + popID)
                                                                .width() + 80) / 2;

                                                // Apply Margin to Popup
                                                $('#' + popID).css({
                                                        'margin-top' : -popMargTop,
                                                        'margin-left' : -popMargLeft
                                                });

                                                // Fade in Background
                                                $('body').append(
                                                '<div id="fade"></div>'); // Add
                                                // the
                                                // fade
                                                // layer
                                                // to
                                                // bottom
                                                // of
                                                // the
                                                // body
                                                // tag.
                                                $('#fade').css({
                                                        'filter' : 'alpha(opacity=80)'
                                                }).fadeIn(); // Fade in the fade
                                                // layer -
                                                // .css({'filter' :
                                                // 'alpha(opacity=80)'})
                                                // is used to fix the IE
                                                // Bug on fading
                                                // transparencies
                                                initialize();
                                                return false;
                                        });
                        // Close Popups and Fade Layer
                        $('a.close, #fade').live('click', function() { // When
                                // clicking
                                // on the
                                // close or
                                // fade
                                // layer...
                                $('#fade , .popup_block').fadeOut(function() {
                                        $('#fade, a.close').remove(); // fade them both
                                        // out
                                });
                                return false;
                        });
                });
/**
 * Tabbed Navigation JS
 */

var activatables = (function() {

        var activeClass = 'active';
        var inactiveClass = 'inactive';

        var anchors = {}, activates = {};
        var regex = /#([A-Za-z][A-Za-z0-9:._-]*)$/;

        var temp = document.getElementsByTagName('a');
        for ( var i = 0; i < temp.length; i++) {
                var a = temp[i];

                if ((a.pathname != location.pathname && '/' + a.pathname != location.pathname)
                                || a.search != location.search)
                        continue;

                var match = regex.exec(a.href);
                if (!match)
                        continue;
                var id = match[1];

                if (id in anchors)
                        anchors[id].push(a);
                else
                        anchors[id] = [ a ];
        }

        function setClass(elem, active) {
                var classes = elem.className.split(/\s+/);
                var cls = active ? activeClass : inactiveClass, found = false;
                for ( var i = 0; i < classes.length; i++) {
                        if (classes[i] == activeClass || classes[i] == inactiveClass) {
                                if (!found) {
                                        classes[i] = cls;
                                        found = true;
                                } else {
                                        delete classes[i--];
                                }
                        }
                }

                if (!found)
                        classes.push(cls);
                elem.className = classes.join(' ');
        }

        function getParams() {
                var hash = location.hash || '#';
                var parts = hash.substring(1).split('&');

                var params = {};
                for ( var i = 0; i < parts.length; i++) {
                        var nv = parts[i].split('=');
                        if (!nv[0])
                                continue;
                        params[nv[0]] = nv[1] || null;
                }

                return params;
        }

        function setParams(params) {
                var parts = [];
                for ( var name in params) {
                        parts.push(params[name] ? name + '=' + params[name] : name);
                }

                location.hash = knownHash = '#' + parts.join('&');
        }

        var knownHash = location.hash;
        function pollHash() {
                var hash = location.hash;
                if (hash != knownHash) {
                        var params = getParams();
                        for ( var name in params) {
                                if (!(name in activates))
                                        continue;
                                activates[name](params[name]);
                        }
                        knownHash = hash;
                }
        }
        setInterval(pollHash, 250);

        function getParam(name) {
                var params = getParams();
                return params[name];
        }

        function setParam(name, value) {
                var params = getParams();
                params[name] = value;
                setParams(params);
        }

        var initialId = null;
        var match = regex.exec(knownHash);
        if (match) {
                initialId = match[1];

        }

        function makeActivatable(paramName, activatables) {
                var all = {}, first = initialId;
                function activate(id) {
                        if (!(id in all))
                                return false;

                        for ( var cur in all) {
                                if (cur == id)
                                        continue;
                                for ( var i = 0; i < all[cur].length; i++) {
                                        setClass(all[cur][i], false);
                                }
                        }

                        for ( var i = 0; i < all[id].length; i++) {
                                setClass(all[id][i], true);
                        }

                        setParam(paramName, id);

                        return true;
                }

                activates[paramName] = activate;

                function attach(item, basePath) {
                        if (item instanceof Array) {
                                for ( var i = 0; i < item.length; i++) {
                                        attach(item[i], basePath);
                                }
                        } else if (typeof item == 'object') {
                                for ( var p in item) {
                                        var path = attach(p, basePath);
                                        attach(item[p], path);
                                }
                        } else if (typeof item == 'string') {
                                var path = basePath ? basePath.slice(0) : [];
                                var e = document.getElementById(item);
                                if (!e)
                                        throw 'Could not find "' + item + '".';
                                        path.push(e);

                                if (!first)
                                        first = item;

                                all[item] = path;

                                if (item in anchors) {

                                        var func = (function(id) {
                                                return function(e) {
                                                        activate(id);

                                                        if (!e)
                                                                e = window.event;
                                                        if (e.preventDefault)
                                                                e.preventDefault();
                                                        e.returnValue = false;
                                                        return false;
                                                };
                                        })(item);

                                        for ( var i = 0; i < anchors[item].length; i++) {
                                                var a = anchors[item][i];

                                                if (a.addEventListener) {
                                                        a.addEventListener('click', func, false);
                                                } else if (a.attachEvent) {
                                                        a.attachEvent('onclick', func);
                                                } else {
                                                        throw 'Unsupported event model.';
                                                }

                                                all[item].push(a);
                                        }
                                }

                                return path;
                        } else {
                                throw 'Unexpected type.';
                        }

                        return basePath;
                }

                attach(activatables);

                if (first)
                        activate(getParam(paramName)) || activate(first);
        }

        return makeActivatable;
})();

function setPermVal(permbin){
        document.getElementById("{perm}_ownread").selectedIndex = parseInt(permbin.substring(0,1)) ;
        document.getElementById("{perm}_ownwrite").selectedIndex = parseInt(permbin.substring(1,2)) ;
        document.getElementById("{perm}_ownupdt").selectedIndex = parseInt(permbin.substring(2,3)) ;
        document.getElementById("{perm}_owndel").selectedIndex = parseInt(permbin.substring(3,4)) ;

        document.getElementById("{perm}_grpread").selectedIndex = parseInt(permbin.substring(4,5)) ;
        document.getElementById("{perm}_grpwrite").selectedIndex = parseInt(permbin.substring(5,6)) ;
        document.getElementById("{perm}_grpupdt").selectedIndex = parseInt(permbin.substring(6,7)) ;
        document.getElementById("{perm}_grpdel").selectedIndex = parseInt(permbin.substring(7,8)) ;

        document.getElementById("{perm}_othread").selectedIndex = parseInt(permbin.substring(8,9)) ;
        document.getElementById("{perm}_othwrite").selectedIndex = parseInt(permbin.substring(9,10)) ;
        document.getElementById("{perm}_othupdt").selectedIndex = parseInt(permbin.substring(10,11)) ;
        document.getElementById("{perm}_othdel").selectedIndex = parseInt(permbin.substring(11,12)) ;
}

function resizeIframe(newHeight)
{
  document.getElementById('embeddede').style.height = parseInt(newHeight) +10 + 'px';
}
function selectValid(boxId){
        var Box = document.getElementById(boxId);
        var count = Box.options.length;
        for (i = 0; i < count; i++) {
                Box.options[i].selected=true;
        }
}
function moveSelected(from,to){
        var fromBox = document.getElementById(from);
        var toBox = document.getElementById(to);
        var count = fromBox.options.length;
        var tmp = new Array();
        for (i = 0; i < count; i++) {
                if (fromBox.options[i].selected) {
                        tmp.push(fromBox.options[i]);

                }
        }
        var cpt = tmp.length;
        var indx =0;
        for(i=0 ; i<cpt;i++){
                boxPush(toBox,tmp[i].text,tmp[i].value);
                fromBox.remove(tmp[i]);
        }
}

function boxPush(ListBox, text, value) {
        try {
                var option = document.createElement("OPTION");
                option.value = value;
                option.text = text;
                ListBox.options.add(option);
        } catch (er) {
                alert(er);
        }
}


function sortList(boxId) {
        var lb = document.getElementById(boxId);
        arrTexts = new Array();
        arrValues = new Array();
        arrOldTexts = new Array();

        for (i = 0; i < lb.length; i++) {
                arrTexts[i] = lb.options[i].text;
                arrValues[i] = lb.options[i].value;
                arrOldTexts[i] = lb.options[i].text;
        }

        arrTexts.sort();

        for (i = 0; i < lb.length; i++) {
                lb.options[i].text = arrTexts[i];
                for (j = 0; j < lb.length; j++) {
                        if (arrTexts[i] == arrOldTexts[j]) {
                                lb.options[i].value = arrValues[j];
                                j = lb.length;
                        }
                }
        }
}
function redirectToAddDocument(controler,targetcatid,boxId){
        var typid;
        var lb = document.getElementById(boxId);
        var url=controler+'?/document/add/'+targetcatid+"/";
        var count = lb.options.length;
        for (i = 0; i < count; i++) {
                if (lb.options[i].selected) {
                        typid=lb.options[i].value;
                }
        }
        url = url+typid+"/";
        document.location.href=url;
}
function write_external_content(url,divid) { 
	if (document.getElementById(divid)) { 
		var element = document.getElementById(divid); 
		element.innerHTML = '<em>Loading Content ...</em>'; 
		xmlHttp=GetXmlHttpObject(); 
		xmlHttp.open("GET", url); 
		xmlHttp.onreadystatechange = function() { 
			if (xmlHttp.readyState == 4 && xmlHttp.status == 200) { 
				element.innerHTML = xmlHttp.responseText; 
			} else { 
				element.innerHTML = 'Oops. Request failed.'; 
			} 
		};
		xmlHttp.send(null); 
	} 
} 
function GetXmlHttpObject() { 
	var xmlHttp=null; 
	try { 
	//Firefox, Opera 8.0+, Safari 
	xmlHttp=new XMLHttpRequest(); 
	} 
	catch (e) { 
	//Internet Explorer 
	try { 
	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	} 
	catch (e) { 
	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	} 
	return xmlHttp; 
	} 
function dynadd(divid,elemTag,fieldstr,counter,cssid,optFunct){
	   var newdiv = document.createElement('div');
	   counter++;
	   newdiv.className = "field";
	   var reg=new RegExp("({{cpt}})", "g");
	   var tmpTag = fieldstr;
	   
	   fieldstr = fieldstr.replace(reg,counter);
	   var elem = document.createElement(elemTag);
	   elem.id = fieldstr;
	   elem.className = fieldstr;
	   elem.setAttribute('name', fieldstr);
	   if(elemTag == 'input'){
		   elem.setAttribute('type', 'text');
	   }
	   //newdiv.innerHTML = fieldstr ;
	   newdiv.appendChild(elem);
	   document.getElementById(divid).appendChild(newdiv);
	   var plus= document.getElementById(divid+'plus');
	   var fragment= document.createDocumentFragment();
	   var newplus = document.createElement('a');
	   newplus.innerHTML = '+';
	   newplus.onclick= function(){dynadd(divid,elemTag,tmpTag,counter,cssid,optFunct);};
	   newplus.id=divid+"plus";
	   newplus.href="javascript:void();";
	   //fragment.appendChild(newplus);
	   parentnd = plus.parentNode;
	   //plus.parentNode.replaceChild(fragment, plus);
	   if(typeof(optFunct != 'undefined')){
		   //optFunct(cssid+'_'+counter);
		   optFunct(fieldstr);
	   }
	   parentnd.removeChild(plus);
	   parentnd.appendChild(newplus);
	}

function loadContent(elementSelector, sourceUrl) {
	$(""+elementSelector+"").load(""+sourceUrl+"");
	}
function ShowFileInfo( fileUrl, data )
{
	var msg = 'The selected URL is: ' + fileUrl + '\n\n';
	if ( fileUrl != data['fileUrl'] )
		msg += 'File url: ' + data['fileUrl'] + '\n';
	msg += 'File size: ' + data['fileSize'] + 'KB\n';
	msg += 'Last modifed: ' + data['fileDate'];

	alert( msg );
}
function ajaxLoad(url,divId, funct){
	jQuery.ajaxSetup ({cache: false});
	var ajax_load = "loading";
	var loadUrl = url;
	jQuery("#"+divId).ready(
			function(){
				jQuery("#"+divId).html(ajax_load).load(loadUrl, funct)});
}
