try{
var testCommons=new MQObject();
testCommons=null;
}
catch(error){
throw "You must include mqcommon.js or toolkit api script prior to mqutils.js.";
}
var mqutils=1;
if(!Array.prototype.push){
Array.prototype.push=function(){
var _1=Array.push.arguments.length;
for(var i=0;i<_1;i++){
this[this.length]=Array.push.arguments[i];
}
return this.length;
};
}
function mq_ParamExists(_3){
var _4;
return (_3!==_4);
}
function mqGetElementById(_5){
if(document.getElementById(_5)){
return document.getElementById(_5);
}
return null;
}
function mqBuildUrl(_6){
var _7=_mqServerPort.replace(/mapquest.com:?\d*/,"mapquest.com");
return (_reqPrefix+_7+"/oapi/transaction?"+_6+"&key="+_mqKey);
}
function mqUrlLimit(){
var _8=2048;
if(MQA.BrowserInfo.isNS){
_8=7168;
}
return _8;
}
function mqLimitDisplay(){
var _9=2;
if(MQA.BrowserInfo.isNS){
_9=7;
}
return _9;
}
function mqDoRemote(_a,_b,_c,_d){
var _e=document.getElementsByTagName(_c).item(0);
var _f=mqGetElementById(_b);
if(_f){
_e.removeChild(_f);
}
_f=document.createElement("script");
var _10=mqBuildUrl(_a);
if(_a.substring(0,4)=="http"){
_10=_a;
}
if(_10.length>mqUrlLimit()){
alert("The request query exceeds the limit ("+mqLimitDisplay()+" Kb) allowed for your browser type. Please reduce the amount of data in the request query!");
return;
}
_f.src=_10;
_f.type="text/javascript";
_f.id=_b;
_e.appendChild(_f);
}
function mqCreateXMLDocImportNode(_11){
var _12;
if(document.implementation.createDocument){
var _12=document.implementation.createDocument("","",null);
try{
_12.appendChild(_12.importNode(_11,true));
}
catch(error){
alert(error);
alert(_11.nodeName);
}
}else{
if(window.ActiveXObject){
_12=new ActiveXObject("Microsoft.XMLDOM");
_12.async="false";
_12.loadXML(_11.xml);
}
}
return _12;
}
function mqXmlToStr(_13){
var _14=new String;
var _15=null;
if(_13==null){
return "";
}
if(MQA.BrowserInfo.isNS){
_15=new window.XMLSerializer();
_14=_15.serializeToString(_13);
}else{
if(MQA.BrowserInfo.isIE){
_14=_13.xml;
}
}
if(MQA.BrowserInfo.isSafari){
_15=new window.XMLSerializer();
_14=_15.serializeToString(_13);
_14=_14||"";
_14=_14.replace(/#38;/g,"&");
}
return _14;
}
function mqCreateNSManager(_16){
var _17={normalResolver:xmlDoc.createNSResolver(xmlDoc.documentElement),lookupNamespaceURI:function(_18){
switch(_18){
case "_mq":
return _16;
default:
return this.normalResolver.lookupNamespaceURI(_18);
}
}};
return _17;
}
function mqGetNode(_19,_1a){
var _1b;
if(MQA.BrowserInfo.isSafari){
if(!_19.evaluate){
var _1c=new Array();
_1c=_1a.split("/");
if(_1c[_1c.length-1].indexOf("@")!=-1){
_1c.splice(_1c.length-1,1);
}
var _1d=_19.documentElement;
var _1e=false;
if(_1c.length==2&&_1d.tagName==_1c[1]){
_1e=true;
}else{
var _1f=_1c.length-1;
for(var i=1;i<_1f;i++){
_1e=false;
if(_1d.tagName==_1c[i]&&_1d.hasChildNodes()){
var _21=(_1d.hasChildNodes())?_1d.childNodes.length:0;
for(var j=0;j<_21;j++){
if(_1d.childNodes[j].tagName==_1c[i+1]){
_1d=_1d.childNodes[j];
_1e=true;
break;
}
}
}
if(_1c[i+1]&&_1c[i+1].indexOf("text()")!=-1){
_1e=true;
}
if(_1c[i+1].indexOf("[")!=-1){
var _23=parseInt(_1c[i+1].substr(_1c[i+1].indexOf("[")+1,_1c[i+1].indexOf("]")-1));
_1c[i+1]=_1c[i+1].substr(0,_1c[i+1].indexOf("["));
_1d=_19.getElementsByTagName(_1c[i+1]).item(_23-1);
_1e=true;
}
}
}
_1b=(_1e==true)?_1d:null;
return _1b;
}else{
_1b=_19.evaluate(_1a,_19,null,9,null);
return _1b.singleNodeValue;
}
}else{
if(MQA.BrowserInfo.isIE){
_1b=_19.selectSingleNode(_1a);
return _1b;
}else{
if(MQA.BrowserInfo.isNS){
_1b=_19.evaluate(_1a,_19,null,9,null);
return _1b.singleNodeValue;
}
}
}
return null;
}
function mqGetNodeText(_24){
var _25="";
if(MQA.BrowserInfo.isIE){
_25=_24.text;
}else{
if(MQA.BrowserInfo.isNS&&_24.firstChild){
_25=_24.firstChild.nodeValue;
}
}
if(MQA.BrowserInfo.isSafari&&_24.firstChild){
_25=_24.firstChild.nodeValue;
_25=(_25?_25:"");
_25=_25.replace(/#38;/g,"&");
}
return _25;
}
function mqGetXPathNodeText(_26,_27){
var _28;
if(MQA.BrowserInfo.isSafari){
_28=mqGetNode(_26,_27);
var _29="";
var _2a="";
if(_27.indexOf("@")!=-1){
_2a=_27.substr(_27.indexOf("@")+1,_27.length);
_29=_28.attributes.getNamedItem(_2a).nodeValue;
}else{
if(_28){
_29=mqGetNodeText(_28);
}
}
return _29;
}
if(MQA.BrowserInfo.isIE){
_28=_26.selectSingleNode(_27);
return (_28==null?"":_28.text);
}else{
if(MQA.BrowserInfo.isNS){
try{
_28=_26.evaluate(_27,_26,null,2,null);
}
catch(error){
alert(_27);
alert(error);
}
return _28.stringValue;
}
}
return "";
}
function mqReplaceNode(_2b,_2c,_2d){
var _2e=_2b.createTextNode(_2d);
if(_2c.firstChild){
return _2c.replaceChild(_2e,_2c.firstChild);
}else{
return _2c.appendChild(_2e);
}
}
function mqReplaceElementNode(_2f,_30,_31){
var _32=_2f.documentElement;
var _33=_30.documentElement;
var _34=_2f.getElementsByTagName(_31).item(0);
if(MQA.BrowserInfo.isIE){
node=_33;
}else{
node=_2f.importNode(_33,true);
}
if(_34){
_32.replaceChild(node,_34);
}else{
_32.appendChild(node);
}
return _2f;
}
function mqSetNodeText(_35,_36,_37){
var _38=mqGetNode(_35,_36);
if(_38==null){
return null;
}
return mqReplaceNode(_35,_38,_37);
}
function mqTransformXMLFromString(_39,_3a,_3b){
var _3c=MQA.createXMLDoc(_39);
var _3d=MQA.createXMLDoc(_3a);
var _3e;
if(MQA.BrowserInfo.isNS){
var _3f=new XSLTProcessor();
_3f.importStylesheet(_3d);
_3e=_3f.transformToFragment(_3c,document);
_3b.appendChild(_3e);
}else{
if(MQA.BrowserInfo.isIE){
var _3e=new ActiveXObject("Msxml2.DOMDocument.5.0");
_3e=_3c.transformNode(_3d);
_3b.innerHTML+=_3e;
}
}
}
function mqTransformXMLFromNode(_40,_41,_42){
var _43=MQA.createXMLDoc(_41);
var _44;
if(MQA.BrowserInfo.isNS){
var _45=new XSLTProcessor();
_45.importStylesheet(_43);
_44=_45.transformToFragment(_40,document);
_42.appendChild(_44);
}else{
if(MQA.BrowserInfo.isIE){
var _44=new ActiveXObject("Msxml2.DOMDocument.5.0");
_44=_40.transformNode(_43);
_42.innerHTML+=_44;
}
}
}
mqAddEvent(window,"load",alphaBackgrounds);
function alphaBackgrounds(){
if(navigator.platform=="Win32"&&navigator.appName=="Microsoft Internet Explorer"&&window.attachEvent){
var _46=navigator.appVersion.match(/MSIE (\d+\.\d+)/,"");
var _47=(_46!=null&&Number(_46[1])>=5.5);
for(i=0;i<document.all.length;i++){
var bg=document.all[i].currentStyle.backgroundImage;
if(_47&&bg){
if(bg.match(/\.png/i)!=null){
var _49=bg.substring(5,bg.length-2);
document.all[i].style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+_49+"', sizingMethod='scale')";
document.all[i].style.backgroundImage="url(/images/background-form-button.gif)";
}
}
}
}
}
function mqFormatNumber(num,dec){
return Math.floor(num*Math.pow(10,dec))/Math.pow(10,dec);
}
function mq_display_time(_4c){
var _4d;
if(_4c>3600){
_4d=_4c/3600;
var _4e=(" "+Math.floor(_4d)+" hours,");
_4d=(_4c/60)%60;
_4e+=(" "+mqFormatNumber(_4d,2)+" minutes");
return _4e;
}
if(_4c>60){
_4d=_4c/60;
return (" "+mqFormatNumber(_4d,2)+" minutes");
}
}
function mq_display_distance(_4f){
return (" "+mqFormatNumber(_4f.value,2)+(_4f.units=="mi"?" miles":" kilometers"));
}
var isIE5Mac=(navigator.userAgent.indexOf("MSIE 5")!=-1&&navigator.userAgent.indexOf("Mac")!=-1);
function mqCreateFormInput(_50,id,_52,_53,_54,_55,_56,_57,_58){
var div=_50.appendChild(document.createElement("div"));
div.className="row";
var _5a=div.appendChild(document.createElement("label"));
_5a.htmlFor=id;
_5a.appendChild(document.createTextNode(_53));
div.appendChild(document.createElement("br"));
var _5b=document.createElement("input");
_5b.id=id;
_5b.type=_54;
_5b.name=_55;
if(_57!=""){
_5b.size=_57;
}
if(!isNaN(parseInt(_58))){
_5b.maxLength=parseInt(_58);
}
if(_56!=""){
_5b.value=_56;
}
if(_52!=""){
var _5c=div.appendChild(document.createElement("span"));
_5c.className=_52;
_5c.appendChild(_5b);
}else{
div.appendChild(_5b);
}
}
function mqCreateInput(_5d,id,_5f,_60,_61,_62,_63){
var _64=document.createElement("input");
_64.id=id;
_64.type=_5f;
_64.name=_60;
if(_62!=""){
_64.size=_62;
}
if(!isNaN(parseInt(_63))){
_64.maxLength=parseInt(_63);
}
if(_61!=""){
_64.value=_61;
}
_5d.appendChild(_64);
}
function mqCreateHiddenInput(_65,id,_67,_68){
var _69;
if(isIE5Mac){
_69=document.createElement("input type=hidden");
}else{
_69=document.createElement("input");
_69.type="hidden";
}
_69.name=_67;
if(id!=""){
_69.id=id;
}
if(_68!=""){
_69.value=_68;
}
_65.appendChild(_69);
}
function mqCreateFormSelect(_6a,id,_6c,_6d,_6e,_6f,_70){
var div=_6a.appendChild(document.createElement("div"));
div.className="row";
var _72=div.appendChild(document.createElement("label"));
_72.htmlFor=id;
_72.appendChild(document.createTextNode(_6d));
div.appendChild(document.createElement("br"));
if(_6c!=""){
var _73=div.appendChild(document.createElement("span"));
_73.className=_6c;
var _74=_73.appendChild(document.createElement("select"));
}else{
var _74=div.appendChild(document.createElement("select"));
}
_74.id=id;
_74.name=_6e;
length=_6f.length;
for(x=0;x<length;x++){
var _75=_74.appendChild(document.createElement("option"));
eval("option.value = elements[x]."+_70);
eval("option.appendChild (document.createTextNode (elements[x]."+_70+"))");
}
return _74;
}
function mqCreateDiv(_76,_77,id){
var div=_76.appendChild(document.createElement("div"));
if(_77!=""){
div.className=_77;
}
if(id!=""){
div.id=id;
}
return div;
}
function mqCreateA(_7a,_7b,_7c){
var a=_7a.appendChild(document.createElement("a"));
a.href=_7b;
if(_7c!=""){
a.title=_7c;
}
return a;
}
function mqCreateSpan(_7e,_7f,id){
var _81=_7e.appendChild(document.createElement("span"));
if(_7f!=""){
_81.className=_7f;
}
if(id!=""){
_81.id=id;
}
return _81;
}
function mqCreateImg(_82,src,_84,_85,id,_87,alt){
var img=_82.appendChild(document.createElement("img"));
if(src!=""){
img.src=src;
}
if(!isNaN(parseInt(_84))){
img.width=parseInt(_84);
}
if(!isNaN(parseInt(_85))){
img.height=parseInt(_85);
}
if(id!=""){
img.id=id;
}
if(_87!=""){
img.name=_87;
}
if(alt!=""){
img.alt=alt;
}
return img;
}
function mqCreateImgDiv(_8a,src,_8c,_8d,id,_8f,alt){
var div=_8a.appendChild(document.createElement("div"));
if(id!=""){
div.id=id;
}
if(!isNaN(parseInt(_8c))){
div.style.width=parseInt(_8c)+"px";
}
if(!isNaN(parseInt(_8d))){
div.style.height=parseInt(_8d)+"px";
}
if(_8f!=""){
div.name=_8f;
}
if(alt!=""){
div.alt=alt;
}
return div;
}
function mqXMLHttpRequest(){
var _92=null;
if(window.XMLHttpRequest){
try{
_92=new XMLHttpRequest();
}
catch(e){
_92=null;
}
}else{
if(window.ActiveXObject){
try{
_92=new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e){
try{
_92=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(e){
_92=null;
}
}
}
}
return _92;
}
function mqAddEvent(_93,_94,fn){
if(window.opera&&MQA.BrowserInfo.version<8){
var r=_93.attachEvent("on"+_94,fn);
return r;
}else{
if(_93.addEventListener){
((window.opera)&&(MQA.BrowserInfo.version>=8))?_93.addEventListener(_94,fn,false):_93.addEventListener(_94,fn,true);
return true;
}else{
if(_93.attachEvent){
var r=_93.attachEvent("on"+_94,fn);
return r;
}else{
_93["on"+_94]=fn;
}
}
}
}
function mqRemoveEvent(_97,_98,fn){
if(window.opera){
eval("fObj.on"+_98+" = null");
}
if(_97.removeEventListener){
((window.opera)&&(MQA.BrowserInfo.version>=8))?_97.removeEventListener(_98,fn,false):_97.removeEventListener(_98,fn,true);
}else{
if(_97.detachEvent){
_97.detachEvent("on"+_98,fn);
}else{
_97["on"+_98]=null;
}
}
}
function mqGetEventData(evt){
fEventData=new Object();
if(document.addEventListener){
fEventData.id=evt.target.id;
fEventData.type=evt.type;
fEventData.element=evt.target;
}else{
if(window.event){
fEventData.id=window.event.srcElement.id;
fEventData.type=window.event.type;
fEventData.element=window.event.srcElement;
}else{
return null;
}
}
return fEventData;
}
function mqGetXY(evt){
xyData=new Object();
if(!document.createElement||!document.getElementsByTagName){
return;
}
if(!document.createElementNS){
document.createElementNS=function(ns,elt){
return document.createElement(elt);
};
}
if(document.addEventListener&&typeof evt.pageX=="number"){
var _9e=evt.target;
var _9f=CalculatedTotalOffsetTop=0;
while(_9e.offsetParent){
_9f+=_9e.offsetLeft;
CalculatedTotalOffsetTop+=_9e.offsetTop;
_9e=_9e.offsetParent;
}
var _a0=evt.pageX-_9f;
var _a1=evt.pageY-CalculatedTotalOffsetTop;
xyData.elementId=evt.target.id;
xyData.elementX=_a0;
xyData.elementY=_a1;
xyData.pageX=evt.pageX;
xyData.pageY=evt.pageY;
}else{
if(window.event&&typeof window.event.offsetX=="number"){
xyData.elementId=window.event.srcElement.id;
xyData.elementX=event.offsetX;
xyData.elementY=event.offsetY;
xyData.pageX=0;
xyData.pageY=0;
var _a2=mqGetElementById(xyData.elementId);
while(_a2){
xyData.pageX+=_a2.offsetLeft;
xyData.pageY+=_a2.offsetTop;
_a2=_a2.offsetParent;
}
xyData.pageX+=xyData.elementX;
xyData.pageY+=xyData.elementY;
}
}
return xyData;
}
function mqGetPDivSize(_a3){
size=new MQSize();
if(_a3.parent.style.width.length==0){
_a3.parent.style.width="800px";
}
if(_a3.parent.style.height.length==0){
_a3.parent.style.height="600px";
}
size.setWidth(parseInt(_a3.parent.style.width)-4);
size.setHeight(parseInt(_a3.parent.style.height)-4);
return size;
}
function mqSetPDivSize(_a4,_a5){
_a4.parent.style.width=_a5.getWidth()+"px";
_a4.parent.style.height=_a5.getHeight()+"px";
}
function mqurlencode(_a6){
var _a7;
_a7=_a6.replace(/%/g,"%25");
_a7=_a7.replace(/&/g,"%26");
_a7=_a7.replace(/#/g,"%23");
_a7=_a7.replace(/\//g,"%2F");
_a7=_a7.replace(/:/g,"%3A");
_a7=_a7.replace(/;/g,"%3B");
_a7=_a7.replace(/=/g,"%3D");
_a7=_a7.replace(/\?/g,"%3F");
_a7=_a7.replace(/@/g,"%40");
_a7=_a7.replace(/\$/g,"%24");
_a7=_a7.replace(/,/g,"%2C");
_a7=_a7.replace(/\+/g,"%2B");
return _a7;
}
function mqGetGuid(){
var org=new Date(2006,0,1);
var now=new Date();
do{
var cur=new Date();
}while(cur-now<1);
var _ab=cur.getTime()-org.getTime();
return (Math.ceil(_ab));
}
function mqPause(_ac){
var now=new Date();
var _ae=now.getTime()+_ac;
while(true){
now=new Date();
if(now.getTime()>_ae){
return;
}
}
}
var _mqLogStartTime=null;
var _mqLogCurTime=null;
var _mqLogprevTime=null;
function mqLogTime(str){
if(mqGetElementById("mqTimeLogs")){
var _b0=mqGetElementById("mqTimeLogs");
var _b1=new Date();
if(_mqLogStartTime==null){
_b0.value="Time(ms) Difference\t Message\n";
_mqLogStartTime=_b1.getTime();
_mqLogprevTime=_mqLogStartTime;
}
_mqLogCurTime=_b1.getTime();
var _b2=_mqLogCurTime-_mqLogStartTime;
var del=_mqLogCurTime-_mqLogprevTime;
_b0.value=_b0.value+_b2+"\t "+del+"\t\t "+str+"\n";
_mqLogprevTime=_mqLogCurTime;
}
}
function mqResetTimeLogs(){
if(mqGetElementById("mqTimeLogs")){
var _b4=mqGetElementById("mqTimeLogs");
var _b5=new Date();
_b4.value="Time(ms) Difference\t Message\n";
_mqLogStartTime=_b5.getTime();
_mqLogprevTime=_mqLogStartTime;
}
}
function mqGetAdvantageResultPath(_b6){
var _b7;
if(_b6=="poiMap"){
_b7="poiResults";
}else{
if(_b6=="locMap"){
_b7="locations";
}else{
if(_b6=="search"){
_b7="searchResults";
}
}
}
return _b7;
}
function mqGetAdvantageMapPath(_b8){
var _b9;
if(_b8=="locMap"){
_b9="/advantage/"+_b8+"/locations/location/map";
}else{
_b9="/advantage/"+_b8+"/map";
}
return _b9;
}
function mqPrepareMapUrl(_ba){
var _bb="";
_bb=_ba.replace(/https?:\/\//,_reqPrefix);
_bb=_bb.replace(/mapquest.com:?\d*/,"mapquest.com");
_bb=_bb.replace(/iwebsys.aol.com:?\d*/,"iwebsys.aol.com");
return _bb;
}
function display(pid,_bd,_be,id,_c0){
if(mqGetElementById(pid)){
var div=mqGetElementById(pid);
var _c2=div.appendChild(document.createElement("label"));
var bb=_c2.appendChild(document.createElement("b"));
bb.appendChild(document.createTextNode(_bd));
div.appendChild(document.createElement("br"));
var _c4=div.appendChild(document.createElement("textarea"));
_c4.className=_c0;
_c4.style.overflow="auto";
if(id!=null){
_c4.id=id;
}
_c4.appendChild(document.createTextNode(_be));
div.appendChild(document.createElement("br"));
div.appendChild(document.createElement("br"));
}
}

