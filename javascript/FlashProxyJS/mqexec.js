try{
var testCommons=new MQObject();
testCommons=null;
}
catch(error){
throw "You must include mqcommon.js or toolkit api script prior to mqexec.js.";
}
function MQExec(_1,_2,_3,_4,_5,_6){
var _7;
var _8;
var _9;
var _a;
var _b;
var _c;
var _d;
var _e="";
var _f;
this.flashEnabled=false;
try{
_f=new AAPIProxy("ClientConfig.xml");
this.flashEnabled=true;
_7=_1||"localhost";
_8=_2||"mq";
_9=_3||80;
_f=null;
}
catch(e){
if(typeof _1=="string"){
_7=_1||"localhost";
_8=_2||"mq";
_9=_3||80;
_a=_5||"";
_b=_4||"";
_c=_6||0;
_d=0;
}else{
if(_1.getClassName()&&_1.getClassName()=="MQExec"){
_7=_1.getServerName();
_8=_1.getServerPath();
_9=_1.getServerPort();
_b=_1.getProxyServerName();
_c=_1.getProxyServerPort();
_a=_1.getProxyServerPath();
_d=_1.m_lSocketTimeout;
}
}
}
this.setServerName=function(_10){
_7=_10;
};
this.getServerName=function(){
return _7;
};
this.setServerPath=function(_11){
_8=_11;
};
this.getServerPath=function(){
return _8;
};
this.setServerPort=function(_12){
_9=_12;
};
this.getServerPort=function(){
return _9;
};
this.setProxyServerName=function(_13){
_b=_13;
};
this.getProxyServerName=function(){
return _b;
};
this.setProxyServerPath=function(_14){
_a=_14;
};
this.getProxyServerPath=function(){
return _a;
};
this.setProxyServerPort=function(_15){
_c=_15;
};
this.getProxyServerPort=function(){
return _c;
};
this.setTransactionInfo=function(_16){
if(_16.length>32){
_e=_16.substring(0,32);
}else{
_e=_16;
}
};
this.getTransactionInfo=function(){
return _e;
};
}
MQExec.prototype.ROUTE_VERSION="2";
MQExec.prototype.SEARCH_VERSION="0";
MQExec.prototype.GEOCODE_VERSION="1";
MQExec.prototype.ROUTEMATRIX_VERSION="0";
MQExec.prototype.GETRECORDINFO_VERSION="0";
MQExec.prototype.REVERSEGEOCODE_VERSION="0";
MQExec.prototype.GETSESSION_VERSION="1";
MQExec.prototype.CREATESESSION_VERSION="0";
MQExec.prototype.GRBBFROMSESSION_VERSION="0";
MQExec.prototype.getRequestXml=function(_17,_18,_19){
var _1a=new Array();
var _1b=_19||"0";
_1a.push("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n");
_1a.push("<"+_17+" Version=\""+_1b+"\">\n");
for(var i=0;i<_18.length;i++){
_1a.push(_18[i].saveXml());
_1a.push("\n");
}
_1a.push("</"+_17+">");
return _1a.join("");
};
MQExec.prototype.doTransaction=function(_1d,_1e,_1f,_20){
var _21;
var _22;
var _23=mqXMLHttpRequest();
var _24="";
_1e.push(new MQAuthentication(this.getTransactionInfo()));
var _25=this.getRequestXml(_1d,_1e,_1f);
if(this.flashEnabled){
_23=new AAPIProxy("ClientConfig.xml");
_24+="http://"+this.getServerName();
if(this.getServerPort()!=80){
_24+=":"+this.getServerPort();
}
_24+="/"+this.getServerPath();
_24+="/?e=5";
}else{
if(this.getProxyServerName()!=""){
_24+="http://"+this.getProxyServerName();
if(this.getProxyServerPort()!=0){
_24+=":"+this.getProxyServerPort();
}
_24+="/";
}
_24+=this.getProxyServerPath();
_24+="?sname="+this.getServerName();
_24+="&spath="+this.getServerPath();
_24+="&sport="+this.getServerPort();
}
display("mqXmlLogs","Request URL: ",_24,"rURL","mqDisplay");
display("mqXmlLogs","Request XML: ",_25,"","mqDisplay");
if(this.flashEnabled){
_23.onload=function(){
MQExec.prototype.flashcallback(_1d,_20,mqCreateXMLDoc(this.responseText),this.responseText);
};
_23.onerror=function(){
alert("Flash Proxy Request failed.");
};
_23.open("POST",_24,true);
_23.send(_25);
}else{
_23.open("POST",_24,false);
_23.send(_25);
if(_23.status==200){
_21=_23.responseXML;
}else{
alert("HTTP Status: "+_23.status+" ("+_23.statusText+")\n"+"Details: \n"+_23.responseText);
_21=null;
}
display("mqXmlLogs","Response XML: ",mqXmlToStr(_21),"resXML","mqDisplay");
return _21;
}
};
MQExec.prototype.geocode=function(_26,_27,_28,_29){
var _2a;
var _2b;
var _2c=new Array();
var _2d=new Array();
_2d.push(_29);
if(_26==null||(_26.getClassName()!="MQAddress"&&_26.getClassName()!="MQSingleLineAddress")){
throw "Null or Illegal Argument passed for MQAddress";
}else{
_2c.push(_26);
}
if(_27==null||_27.getClassName()!="MQLocationCollection"){
throw "Null or Illegal Argument passed for MQLocationCollection";
}else{
_2d.push(_27);
}
if(_28!=null){
if(_28.getClassName()!="MQAutoGeocodeCovSwitch"&&_28.getClassName()!="MQGeocodeOptionsCollection"){
throw "Illegal Argument passed for Geocode Options";
}else{
_2c.push(_28);
}
}
mqLogTime("MQExec.geocode: Transaction Start");
_2a=this.doTransaction("Geocode",_2c,this.GEOCODE_VERSION,_2d);
mqLogTime("MQExec.geocode: Transaction End");
if(!this.flashEnabled){
mqLogTime("MQExec.geocode: Loading of GeocodeResponse Start");
_2b=mqXmlToStr(mqGetNode(_2a,"/GeocodeResponse/LocationCollection"));
_27.loadXml(_2b);
mqLogTime("MQExec.geocode: Loading of GeocodeResponse End");
}
};
MQExec.prototype.batchGeocode=function(_2e,_2f,_30,_31){
var _32;
var _33;
var _34=new Array();
var _35=new Array();
_35.push(_31);
if(_2e==null||_2e.getClassName()!="MQLocationCollection"){
throw "Null or Illegal Argument passed for MQLocationCollection";
}else{
_34.push(_2e);
}
if(_2f==null||_2f.getClassName()!="MQLocationCollectionCollection"){
throw "Null or Illegal Argument passed for MQLocationCollectionCollection";
}else{
_35.push(_2f);
}
if(_30!=null){
if(_30.getClassName()!="MQAutoGeocodeCovSwitch"&&_30.getClassName()!="MQGeocodeOptionsCollection"){
throw "Illegal Argument passed for Geocode Options";
}else{
_34.push(_30);
}
}
mqLogTime("MQExec.batchGeocode: Transaction Start");
_32=this.doTransaction("BatchGeocode",_34,this.GEOCODE_VERSION,_35);
mqLogTime("MQExec.batchGeocode: Transaction End");
if(!this.flashEnabled){
mqLogTime("MQExec.batchGeocode: Loading of GeocodeResponse Start");
_33=mqXmlToStr(mqGetNode(_32,"/BatchGeocodeResponse/LocationCollectionCollection"));
_2f.loadXml(_33);
mqLogTime("MQExec.batchGeocode: Loading of GeocodeResponse End");
}
};
MQExec.prototype.doRoute=function(_36,_37,_38,_39,_3a,_3b){
var _3c;
var _3d;
var _3e=new Array();
var _3f=new Array();
_3f.push(_3b);
if(_36==null||_36.getClassName()!="MQLocationCollection"){
throw "Null or Illegal Argument passed for MQLocationCollection";
}else{
_3e.push(_36);
}
if(_37==null||_37.getClassName()!="MQRouteOptions"){
throw "Null or Illegal Argument passed for MQRouteOptions";
}else{
_3e.push(_37);
}
if(_38==null||_38.getClassName()!="MQRouteResults"){
throw "Null or Illegal Argument passed for MQRouteResults";
}else{
var _40=_39||"";
_3e.push(new MQXmlNodeObject("SessionID",_40));
_3f.push(_38);
_3f.push(_3a);
_3f.push(_40);
_3f.push(this);
mqLogTime("MQExec.doRoute: Transaction Start");
_3c=this.doTransaction("DoRoute",_3e,this.ROUTE_VERSION,_3f);
mqLogTime("MQExec.doRoute: Transaction End");
}
if(!this.flashEnabled){
mqLogTime("MQExec.doRoute: Loading of RouteResults Start");
_3d=mqXmlToStr(mqGetNode(_3c,"/DoRouteResponse/RouteResults"));
_38.loadXml(_3d);
mqLogTime("MQExec.doRoute: Loading of RouteResults End");
if(_3a!=null&&_40!=""){
this.getRouteBoundingBoxFromSessionResponse(_40,_3a);
}
}
};
MQExec.prototype.createSessionEx=function(_41,_42){
var _43;
var _44=0;
var _45=new Array();
var _46=new Array();
_46.push(_42);
if(_41==null||_41.getClassName()!="MQSession"){
throw "Null or Illegal Argument passed for MQSession";
}else{
_45.push(_41);
}
_43=this.doTransaction("CreateSession",_45,this.CREATESESSION_VERSION,_46);
if(!this.flashEnabled){
_44=mqGetNodeText(mqGetNode(_43,"/CreateSessionResponse/SessionID"));
return _44;
}
};
MQExec.prototype.getSession=function(_47,_48,_49){
var _4a;
var _4b;
var _4c=_47||"";
var _4d=new Array();
var _4e=new Array();
_4e.push(_49);
if(_48==null||(_48.getClassName()!="MQSession"&&_48.getClassName()!="MQMapState")){
throw "Null or Illegal Argument passed for MQSession";
}else{
_4e.push(_48);
}
_4d.push(new MQXmlNodeObject("SessionID",_4c));
_4a=this.doTransaction("GetSession",_4d,this.GETSESSION_VERSION,_4e);
if(!this.flashEnabled){
if(_48.getClassName()==="MQMapState"){
_4b=mqXmlToStr(mqGetNode(_4a,"/GetSessionResponse/Session/MapState"));
_48.loadXml(_4b);
}else{
if(_48.getClassName()==="MQSession"){
_4b=mqXmlToStr(mqGetNode(_4a,"/GetSessionResponse/Session"));
_48.loadXml(_4b);
}
}
}
};
MQExec.prototype.doRouteMatrix=function(_4f,_50,_51,_52,_53){
var _54;
var _55;
var _56=new Array();
var _57=new Array();
_57.push(_53);
if(_4f==null||_4f.getClassName()!="MQLocationCollection"){
throw "Null or Illegal Argument passed for MQLocationCollection";
}else{
_56.push(_4f);
}
if(_50==null||typeof _50!="boolean"){
throw "Null or Illegal Argument passed for bAllToAll";
}else{
var _58=_50?1:0;
_56.push(new MQXmlNodeObject("AllToAll",_58));
}
if(_51==null||_51.getClassName()!="MQRouteOptions"){
throw "Null or Illegal Argument passed for MQRouteOptions";
}else{
_56.push(_51);
}
if(_52==null||_52.getClassName()!="MQRouteMatrixResults"){
throw "Null or Illegal Argument passed for MQRouteMatrixResults";
}
_57.push(_52);
mqLogTime("MQExec.doRoute: Transaction Start");
_54=this.doTransaction("DoRouteMatrix",_56,this.ROUTEMATRIX_VERSION,_57);
mqLogTime("MQExec.doRoute: Transaction End");
if(!this.flashEnabled){
mqLogTime("MQExec.doRoute: Loading of RouteResults Start");
_55=mqXmlToStr(mqGetNode(_54,"/DoRouteMatrixResponse/RouteMatrixResults"));
_52.loadXml(_55);
mqLogTime("MQExec.doRoute: Loading of RouteResults End");
}
};
MQExec.prototype.getRecordInfo=function(_59,_5a,_5b,_5c,_5d){
var _5e;
var _5f;
var _60=new Array();
var _61=new Array();
_61.push(_5d);
if(_59==null||_59.getClassName()!="MQStringCollection"){
throw "Null or Illegal Argument passed for MQStringCollection";
}else{
var _62=new MQStringCollection();
_62.setM_Xpath("Fields");
_62.append(_59);
_60.push(_62);
}
if(_5a==null||_5a.getClassName()!="MQDBLayerQuery"){
throw "Null or Illegal Argument passed for MQDBLayerQuery";
}else{
_60.push(_5a);
}
if(_5b==null||_5b.getClassName()!="MQRecordSet"){
throw "Null or Illegal Argument passed for MQRecordSet";
}else{
_61.push(_5b);
}
if(_5c==null||_5c.getClassName()!="MQStringCollection"){
throw "Null or Illegal Argument passed for MQStringCollection";
}else{
var _63=new MQStringCollection();
_63.setM_Xpath("RecordIds");
_63.append(_5c);
_60.push(_63);
}
mqLogTime("MQExec.getRecordInfo: Transaction Start");
_5e=this.doTransaction("GetRecordInfo",_60,this.GETRECORDINFO_VERSION,_61);
mqLogTime("MQExec.getRecordInfo: Transaction End");
if(!this.flashEnabled){
mqLogTime("MQExec.getRecordInfo: Loading of RecordSet Start");
_5f=mqXmlToStr(mqGetNode(_5e,"/GetRecordInfoResponse/RecordSet"));
_5b.loadXml(_5f);
mqLogTime("MQExec.getRecordInfo: Loading of RecordSet End");
}
};
MQExec.prototype.reverseGeocode=function(_64,_65,_66,_67,_68){
var _69;
var _6a;
var _6b=new Array();
var _6c=new Array();
_6c.push(_68);
if(_64==null||_64.getClassName()!="MQLatLng"){
throw "Null or Illegal Argument passed for MQLatLng";
}else{
_6b.push(_64);
}
if(_65==null||_65.getClassName()!="MQLocationCollection"){
throw "Null or Illegal Argument passed for MQLocationCollection";
}else{
var _6d=_66||"";
_6b.push(new MQXmlNodeObject("MapPool",_6d));
var _6e=_67||"";
_6b.push(new MQXmlNodeObject("GeocodePool",_6e));
_6c.push(_65);
mqLogTime("MQExec.reverseGeocode: Transaction Start");
_69=this.doTransaction("ReverseGeocode",_6b,this.REVERSEGEOCODE_VERSION,_6c);
mqLogTime("MQExec.reverseGeocode: Transaction End");
}
if(!this.flashEnabled){
mqLogTime("MQExec.reverseGeocode: Loading of Response Start");
_6a=mqXmlToStr(mqGetNode(_69,"/ReverseGeocodeResponse/LocationCollection"));
_65.loadXml(_6a);
mqLogTime("MQExec.reverseGeocode: Loading of Response End");
}
};
MQExec.prototype.search=function(_6f,_70,_71,_72,_73,_74,_75){
var _76;
var _77;
var _78=new Array();
var _79=new Array();
var _7a=_6f?_6f.getClassName():null;
_79.push(_75);
if(_7a==null||(_7a!="MQSearchCriteria"&&_7a!="MQRadiusSearchCriteria"&&_7a!="MQRectSearchCriteria"&&_7a!="MQPolySearchCriteria"&&_7a!="MQCorridorSearchCriteria")){
throw "Null or Illegal Argument passed for Search Criteria";
}else{
_78.push(_6f);
}
if(_70==null||_70.getClassName()!="MQFeatureCollection"){
throw "Null or Illegal Argument passed for MQFeatureCollection";
}else{
_79.push(_70);
}
if(typeof _71!="string"){
throw "Illegal Argument passed for strCoverageName";
}else{
_78.push(new MQXmlNodeObject("CoverageName",_71));
}
if(_72!=null&&_72.getClassName()!="MQDBLayerQueryCollection"){
throw "Illegal Argument passed for MQRouteOptions";
}else{
if(_72==null){
_72=new MQDBLayerQueryCollection();
}
}
_78.push(_72);
if(_73!=null&&_73.getClassName()!="MQFeatureCollection"){
throw "Illegal Argument passed for MQFeatureCollection";
}else{
if(_73==null){
_73=new MQFeatureCollection();
}
}
_78.push(_73);
if(_74!=null&&_74.getClassName()!="MQDTCollection"){
throw "Illegal Argument passed for MQDTCollection";
}else{
if(_74==null){
_74=new MQDTCollection();
}
}
_78.push(_74);
mqLogTime("MQExec.Search: Transaction Start");
_76=this.doTransaction("Search",_78,this.SEARCH_VERSION,_79);
mqLogTime("MQExec.Search: Transaction End");
if(!this.flashEnabled){
mqLogTime("MQExec.Search: Loading of Search results Start");
_77=mqXmlToStr(mqGetNode(_76,"/SearchResponse/FeatureCollection"));
_70.loadXml(_77);
mqLogTime("MQExec.Search: Loading of Search results End");
}
};
MQExec.prototype.getRouteBoundingBoxFromSessionResponse=function(_7b,_7c,_7d){
var _7e;
var _7f;
var _80=new Array();
if(_7c==null){
throw "Null or Illegal Argument passed for MQRectLL";
}
_80.push(new MQXmlNodeObject("SessionID",_7b));
_7e=this.doTransaction("GetRouteBoundingBoxFromSession",_80,this.GRBBFROMSESSION_VERSION,_7d);
if(!this.flashEnabled){
mqLogTime("MQExec.doRoute: Loading of MQRectLL Start");
var _81=_7e.documentElement.childNodes;
var ul=new MQLatLng();
ul.loadXml(mqXmlToStr(_81[0]));
var lr=new MQLatLng();
lr.loadXml(mqXmlToStr(_81[1]));
_7c.setUpperLeft(ul);
_7c.setLowerRight(lr);
mqLogTime("MQExec.doRoute: Loading of MQRectLL End");
}
};
MQExec.prototype.isAlive=function(){
if(this.getServerPort()==-1||this.getServerName()==""){
return false;
}
return true;
};
MQExec.prototype.getServerInfo=function(_84,_85){
if(!this.isAlive()){
return null;
}
var _86;
var _87;
var _88;
var _89=_84||0;
var _8a=new Array();
var _8b=new Array();
_8b.push(_85);
if(typeof _89!="number"){
throw "Illegal Argument passed for lType";
}else{
_8a.push(new MQXmlNodeObject("Type",_89));
mqLogTime("MQExec.GetServerInfo: Transaction Start");
_87=this.doTransaction("GetServerInfo",_8a,null,_8b);
mqLogTime("MQExec.GetServerInfo: Transaction End");
}
if(!this.flashEnabled){
return _87;
}
};
MQExec.prototype.flashcallback=function(fxn,_8d,_8e,_8f){
switch(fxn){
case "Geocode":
var _90=_8d.pop();
mqLogTime("MQExec.geocode: Loading of GeocodeResponse Start");
_90.loadXml(mqXmlToStr(mqGetNode(_8e,"/GeocodeResponse/LocationCollection")));
mqLogTime("MQExec.geocode: Loading of GeocodeResponse End");
_8d.pop().call(this,_90);
break;
case "DoRoute":
var _91=_8d.pop();
var _92=_8d.pop();
var _93=_8d.pop();
var _94=_8d.pop();
var _95=_8d.pop();
mqLogTime("MQExec.doRoute: Loading of RouteResults Start");
_94.loadXml(mqXmlToStr(mqGetNode(_8e,"/DoRouteResponse/RouteResults")));
mqLogTime("MQExec.doRoute: Loading of RouteResults End");
if(_93!=null&&_92!=""){
var _96=new Array();
_96.push(_94);
_96.push(_95);
_96.push(_91);
_96.push(new MQRectLL());
_91.getRouteBoundingBoxFromSessionResponse(_92,_93,_96);
}else{
_95.call(this,_94);
}
break;
case "CreateSession":
strSessId=mqGetNodeText(mqGetNode(_8e,"/CreateSessionResponse/SessionID"));
_8d.pop().call(this,strSessId);
break;
case "GetSession":
var _97=_8d.pop();
if(_97.getClassName()==="MQMapState"){
_97.loadXml(mqXmlToStr(mqGetNode(_8e,"/GetSessionResponse/Session/MapState")));
}else{
if(_97.getClassName()==="MQSession"){
_97.loadXml(mqXmlToStr(mqGetNode(_8e,"/GetSessionResponse/Session")));
}
}
_8d.pop().call(this,_97);
break;
case "BatchGeocode":
var _98=_8d.pop();
mqLogTime("MQExec.batchGeocode: Loading of GeocodeResponse Start");
_98.loadXml(mqXmlToStr(mqGetNode(_8e,"/BatchGeocodeResponse/LocationCollectionCollection")));
mqLogTime("MQExec.batchGeocode: Loading of GeocodeResponse End");
_8d.pop().call(this,_98);
break;
case "DoRouteMatrix":
var _99=_8d.pop();
mqLogTime("MQExec.doRoute: Loading of RouteResults Start");
_99.loadXml(mqXmlToStr(mqGetNode(_8e,"/DoRouteMatrixResponse/RouteMatrixResults")));
mqLogTime("MQExec.doRoute: Loading of RouteResults End");
_8d.pop().call(this,_99);
break;
case "GetRecordInfo":
var _9a=_8d.pop();
mqLogTime("MQExec.getRecordInfo: Loading of RecordSet Start");
_9a.loadXml(mqXmlToStr(mqGetNode(_8e,"/GetRecordInfoResponse/RecordSet")));
mqLogTime("MQExec.getRecordInfo: Loading of RecordSet End");
_8d.pop().call(this,_9a);
break;
case "ReverseGeocode":
var _9b=_8d.pop();
mqLogTime("MQExec.reverseGeocode: Loading of Response Start");
_9b.loadXml(mqXmlToStr(mqGetNode(_8e,"/ReverseGeocodeResponse/LocationCollection")));
mqLogTime("MQExec.reverseGeocode: Loading of Response End");
_8d.pop().call(this,_9b);
break;
case "Search":
var _9c=_8d.pop();
mqLogTime("MQExec.Search: Loading of Search results Start");
_9c.loadXml(mqXmlToStr(mqGetNode(_8e,"/SearchResponse/FeatureCollection")));
mqLogTime("MQExec.Search: Loading of Search results End");
_8d.pop().call(this,_9c);
break;
case "GetServerInfo":
_8d.pop().call(this,_8e);
break;
case "GetRouteBoundingBoxFromSession":
var _9d=_8d.pop();
var _9e=_8e.documentElement.childNodes;
var ul=new MQLatLng();
ul.loadXml(mqXmlToStr(_9e[0]));
var lr=new MQLatLng();
lr.loadXml(mqXmlToStr(_9e[1]));
_9d.setUpperLeft(ul);
_9d.setLowerRight(lr);
var _91=_8d.pop();
var _95=_8d.pop();
var _a1=_8d.pop();
var _a2=new Array();
_a2.push(_a1);
_a2.push(_9d);
_95.call(_91,_a2);
break;
}
};

