if(typeof (MQA)=="undefined"){
MQA=new Object();
}
if(typeof (MQA.Common)=="undefined"){
MQA.Common=new Object();
}
MQA.createXMLDoc=function(_1){
var _2;
if(document.implementation.createDocument){
var _3=new window.DOMParser();
if(MQA.BrowserInfo.isSafari){
_1=_1.replace(/&/g,"&amp;");
}
_2=_3.parseFromString(_1,"text/xml");
}else{
if(window.ActiveXObject){
_2=new window.ActiveXObject("Microsoft.XMLDOM");
_2.async="false";
_2.loadXML(_1);
}
}
return _2;
};
mqCreateXMLDoc=MQA.createXMLDoc;
MQA.createXMLDocFromNode=function(_4){
var _5;
_4=_4.documentElement;
if(document.implementation.createDocument){
var _5=document.implementation.createDocument("","",null);
try{
_5.appendChild(_5.importNode(_4,true));
}
catch(error){
alert(error);
alert(_4.nodeName);
}
}else{
if(window.ActiveXObject){
_5=new ActiveXObject("Microsoft.XMLDOM");
_5.async="false";
_5.loadXML(_4.xml);
}
}
return _5;
};
mqCreateXMLDocFromNode=MQA.createXMLDocFromNode;
MQA.Browser=function(){
this.name=null;
this.version=null;
this.os=null;
this.appname=null;
this.appVersion=null;
this.vMajor=null;
this.isNS=null;
this.isNS4=null;
this.isNS6=null;
this.isIE=null;
this.isIE4=null;
this.isIE5=null;
this.isDOM=null;
this.isSafari=null;
this.platform=null;
};
MQBrowser=MQA.Browser;
MQA.getBrowserInfo=function(){
var _6=new MQA.Browser();
_6.name=_6.version=_6.os="unknown";
var _7=window.navigator.userAgent.toLowerCase();
var _8=window.navigator.appName;
var _9=window.navigator.appVersion;
var _a=new Array("firefox","msie","netscape","opera","safari");
var _b=new Array("linux","mac","windows","x11");
var _c=_a.length;
var _d="";
for(var i=0,n=_c;i<n;i++){
_d=_7.indexOf(_a[i])+1;
if(_d>0){
_6.name=_a[i];
var _10=_d+_6.name.length;
var _11=((_6.name=="safari")||(_7.charAt(_10+4)>0&&_7.charAt(_10+4)<9))?5:3;
_6.version=_7.substring(_10,_10+_11);
}
}
var _12=_b.length;
for(var j=0,m=_12;j<m;j++){
_d=_7.indexOf(_b[j])+1;
if(_d>0){
_6.os=_b[j];
}
}
if(_8=="Netscape"){
_6.appname="ns";
}else{
if(_8=="Microsoft Internet Explorer"){
_6.appname="ie";
}
}
_6.appVersion=_9;
_6.vMajor=parseInt(_6.appVersion);
_6.isNS=(_6.appname=="ns"&&_6.vMajor>=4);
_6.isNS4=(_6.appname=="ns"&&_6.vMajor==4);
_6.isNS6=(_6.appname=="ns"&&_6.vMajor==5);
_6.isIE=(_6.appname=="ie"&&_6.vMajor>=4);
_6.isIE4=(_6.appVersion.indexOf("MSIE 4")>0);
_6.isIE5=(_6.appVersion.indexOf("MSIE 5")>0);
_6.isDOM=(document.createElement&&document.appendChild&&document.getElementsByTagName)?true:false;
_6.isSafari=(_6.name=="safari");
if(_7.indexOf("win")>-1){
_6.platform="win";
}else{
if(_7.indexOf("mac")>-1){
_6.platform="mac";
}else{
_6.platform="other";
}
}
return _6;
};
mqGetBrowserInfo=MQA.getBrowserInfo;
MQA.BrowserInfo=MQA.getBrowserInfo();
MQA.Object=function(){
var _15=null;
this.getM_XmlDoc=function(){
return _15;
};
this.setM_XmlDoc=function(_16){
_15=_16;
};
var _17=null;
this.getM_Xpath=function(){
return _17;
};
this.setM_Xpath=function(_18){
_17=_18;
};
};
MQA.Object.prototype.getClassName=function(){
return "MQObject";
};
MQA.Object.prototype.getObjectVersion=function(){
return 0;
};
MQA.Object.prototype.setProperty=function(_19,_1a){
var _1b;
if(_19!==null){
_1b="/"+this.getM_Xpath()+"/"+_19;
}else{
_1b="/"+this.getM_Xpath();
}
var _1c=mqSetNodeText(this.getM_XmlDoc(),_1b,_1a);
if(_1c===null){
var _1d=this.getM_XmlDoc().createElement(_19);
var _1e=this.getM_XmlDoc().documentElement.appendChild(_1d);
_1c=mqSetNodeText(this.getM_XmlDoc(),_1b,_1a);
}
return _1c;
};
MQA.Object.prototype.getProperty=function(_1f){
var _20;
if(_1f!==null){
_20="/"+this.getM_Xpath()+"/"+_1f;
}else{
_20="/"+this.getM_Xpath();
}
return mqGetXPathNodeText(this.getM_XmlDoc(),_20);
};
MQA.Object.prototype.copy=function(){
var cp=new this.constructor;
cp.loadXml(this.saveXml());
return cp;
};
MQA.Object.prototype.internalCopy=function(obj){
var _23="<"+obj.getM_Xpath();
if(this.getObjectVersion()>0){
_23=_23+" Version=\""+this.getObjectVersion()+"\"";
}
_23=_23+">";
var _24=this.getM_XmlDoc().documentElement;
var _25=_24.childNodes;
var _26=_25.length;
for(var _27=0;_27<_26;_27++){
_23=_23+mqXmlToStr(_25[_27]);
}
_23=_23+"</"+obj.getM_Xpath()+">";
var cp=new this.constructor;
cp.loadXml(_23);
return cp;
};
MQObject=MQA.Object;
MQA.Point=function(_29,_2a){
this.x=0;
this.y=0;
this.setM_Xpath("Point");
if(arguments.length==1){
this.setM_Xpath(_29);
}else{
if(arguments.length==2){
this.x=parseInt(_29);
this.y=parseInt(_2a);
if(isNaN(this.x)||isNaN(this.y)){
throw new Error("1MQPoint constructor called with invalid parameter");
}
}else{
if(arguments.length>2){
throw new Error("MQPoint constructor called with "+arguments.length+" arguments, but it expects 0, 1, or 2 arguments");
}
}
}
};
MQA.Point.prototype=new MQA.Object();
MQA.Point.prototype.constructor=MQA.Point;
MQA.Point.prototype.getClassName=function(){
return "MQPoint";
};
MQA.Point.prototype.getObjectVersion=function(){
return 0;
};
MQA.Point.prototype.loadXml=function(_2b){
if("undefined"!==typeof (mqutils)){
this.setM_XmlDoc(MQA.createXMLDoc(_2b));
this.x=this.getProperty("X");
this.y=this.getProperty("Y");
}
};
MQA.Point.prototype.saveXml=function(){
return "<"+this.getM_Xpath()+"><X>"+this.x+"</X><Y>"+this.y+"</Y></"+this.getM_Xpath()+">";
};
MQA.Point.prototype.setX=function(x){
this.x=parseInt(x);
if(isNaN(this.x)){
throw new Error("MQPoint.setX called with invalid parameter");
}
};
MQA.Point.prototype.getX=function(){
return this.x;
};
MQA.Point.prototype.setY=function(y){
this.y=parseInt(y);
if(isNaN(this.y)){
throw new Error("MQPoint.setY called with invalid parameter");
}
};
MQA.Point.prototype.getY=function(){
return this.y;
};
MQA.Point.prototype.setXY=function(x,y){
this.x=parseInt(x);
this.y=parseInt(y);
if(isNaN(this.x)||isNaN(this.y)){
throw new Error("MQPoint.setXY called with invalid parameter");
}
};
MQA.Point.prototype.valid=function(){
if("undefined"!==typeof (mqutils)){
return (Math.abs(this.x!=MQCONSTANT.MQPOINT_INVALID)&&Math.abs(this.y!=MQCONSTANT.MQPOINT_INVALID));
}
return false;
};
MQA.Point.prototype.equals=function(pt){
if(pt){
return (this.x===pt.x&&this.y===pt.y);
}
return false;
};
MQA.Point.prototype.toString=function(){
return this.x+","+this.y;
};
MQPoint=MQA.Point;
MQA.LatLng=function(_31,_32){
MQA.Object.call(this);
this.lat=0;
this.lng=0;
this.setM_Xpath("LatLng");
if(arguments.length==1){
this.setM_Xpath(_31);
}else{
if(arguments.length==2){
this.lat=parseFloat(_31);
this.lng=parseFloat(_32);
if(isNaN(this.lat)||isNaN(this.lng)){
throw new Error("MQA.LatLng constructor called with invalid parameter");
}
}else{
if(arguments.length>2){
throw new Error("MQA.LatLng constructor called with "+arguments.length+" arguments, but it expects 0, 1, or 2 arguments.");
}
}
}
};
MQA.LatLng.prototype=new MQA.Object();
MQA.LatLng.prototype.constructor=MQA.LatLng;
MQA.LatLng.prototype.getClassName=function(){
return "MQLatLng";
};
MQA.LatLng.prototype.getObjectVersion=function(){
return 0;
};
MQA.LatLng.prototype.loadXml=function(_33){
if("undefined"!==typeof (mqutils)){
this.setM_XmlDoc(MQA.createXMLDoc(_33));
this.lat=this.getProperty("Lat");
this.lng=this.getProperty("Lng");
}
};
MQA.LatLng.prototype.saveXml=function(){
return "<"+this.getM_Xpath()+"><Lat>"+this.lat+"</Lat><Lng>"+this.lng+"</Lng></"+this.getM_Xpath()+">";
};
MQA.LatLng.prototype.setLatitude=function(_34){
this.lat=parseFloat(_34);
if(isNaN(this.lat)){
throw new Error("MQA.LatLng.setLatitude called with invalid parameter");
}
};
MQA.LatLng.prototype.getLatitude=function(){
return this.lat;
};
MQA.LatLng.prototype.setLongitude=function(_35){
this.lng=parseFloat(_35);
if(isNaN(this.lng)){
throw new Error("MQA.LatLng.setLongitude called with invalid parameter");
}
};
MQA.LatLng.prototype.getLongitude=function(){
return this.lng;
};
MQA.LatLng.prototype.setLatLng=function(_36,_37){
this.lat=parseFloat(_36);
this.lng=parseFloat(_37);
if(isNaN(this.lat)||isNaN(this.lng)){
throw new Error("MQA.LatLng.setLatLng called with invalid parameter");
}
};
MQA.LatLng.prototype.arcDistance=function(ll2,_39){
if("undefined"!==typeof (mqutils)){
if(ll2){
if(ll2.getClassName()!=="MQLatLng"){
alert("failure in arcDistance");
throw "failure in arcDistance";
}
}else{
alert("failure in arcDistance");
throw "failure in arcDistance";
}
if(_39){
mqIsClass("MQDistanceUnits",_39,false);
}else{
_39=new MQDistanceUnits(MQCONSTANT.MQDISTANCEUNITS_MILES);
}
if(this.getLatitude()==ll2.getLatitude()&&this.getLongitude()==ll2.getLongitude()){
return 0;
}
var _3a=ll2.getLongitude()-this.getLongitude();
var a=MQCONSTANT.MQLATLNG_RADIANS*(90-this.getLatitude());
var c=MQCONSTANT.MQLATLNG_RADIANS*(90-ll2.getLatitude());
var _3d=(Math.cos(a)*Math.cos(c))+(Math.sin(a)*Math.sin(c)*Math.cos(MQCONSTANT.MQLATLNG_RADIANS*(_3a)));
var _3e=(_39.getValue()===MQCONSTANT.MQDISTANCEUNITS_MILES)?3963.205:6378.160187;
if(_3d<-1){
return MQCONSTANT.PI*_3e;
}else{
if(_3d>=1){
return 0;
}else{
return Math.acos(_3d)*_3e;
}
}
}
return -1;
};
MQA.LatLng.prototype.valid=function(){
if("undefined"!==typeof (mqutils)){
return (Math.abs(this.getLatitude()-MQCONSTANT.MQLATLNG_INVALID)>MQCONSTANT.MQLATLNG_TOLERANCE&&Math.abs(this.getLongitude()-MQCONSTANT.MQLATLNG_INVALID)>MQCONSTANT.MQLATLNG_TOLERANCE);
}
return false;
};
MQA.LatLng.prototype.equals=function(ll){
if(ll!==null){
return (this.getLongitude()===ll.getLongitude()&&this.getLatitude()===ll.getLatitude());
}
return false;
};
MQA.LatLng.prototype.toString=function(){
return this.lat+","+this.lng;
};
MQLatLng=MQA.LatLng;
MQA.XMLDOC=function(){
this.AUTOGEOCODECOVSWITCH=null;
this.AUTOROUTECOVSWITCH=null;
this.AUTOMAPCOVSWITCH=null;
this.DBLAYERQUERY=null;
this.LINEPRIMITIVE=null;
this.POLYGONPRIMITIVE=null;
this.RECTANGLEPRIMITIVE=null;
this.ELLIPSEPRIMITIVE=null;
this.TEXTPRIMITIVE=null;
this.SYMBOLPRIMITIVE=null;
this.LATLNG=null;
this.POINT=null;
this.POINTFEATURE=null;
this.LINEFEATURE=null;
this.POLYGONFEATURE=null;
this.LOCATION=null;
this.ADDRESS=null;
this.SINGLELINEADDRESS=null;
this.GEOADDRESS=null;
this.GEOCODEOPTIONS=null;
this.MANEUVER=null;
this.ROUTEOPTIONS=null;
this.ROUTERESULTS=null;
this.ROUTEMATRIXRESULTS=null;
this.RADIUSSEARCHCRITERIA=null;
this.RECTSEARCHCRITERIA=null;
this.POLYSEARCHCRITERIA=null;
this.CORRIDORSEARCHCRITERIA=null;
this.SIGN=null;
this.TREKROUTE=null;
this.INTCOLLECTION=null;
this.DTCOLLECTION=null;
this.LATLNGCOLLECTION=null;
this.LOCATIONCOLLECTION=null;
this.LOCATIONCOLLECTIONCOLLECTION=null;
this.MANEUVERCOLLECTION=null;
this.SIGNCOLLECTION=null;
this.STRINGCOLLECTION=null;
this.STRCOLCOLLECTION=null;
this.FEATURECOLLECTION=null;
this.PRIMITIVECOLLECTION=null;
this.POINTCOLLECTION=null;
this.TREKROUTECOLLECTION=null;
this.FEATURESPECIFIERCOLLECTION=null;
this.GEOCODEOPTIONSCOLLECTION=null;
this.COVERAGESTYLE=null;
this.RECORDSET=null;
this.MAPSTATE=null;
this.SESSION=null;
this.SESSIONID=null;
this.DTSTYLE=null;
this.DTSTYLEEX=null;
this.DTFEATURESTYLEEX=null;
this.FEATURESPECIFIER=null;
this.BESTFIT=null;
this.BESTFITLL=null;
this.CENTER=null;
this.CENTERLATLNG=null;
this.PAN=null;
this.ZOOMIN=null;
this.ZOOMOUT=null;
this.ZOOMTO=null;
this.ZOOMTORECT=null;
this.ZOOMTORECTLATLNG=null;
this.getAUTOGEOCODECOVSWITCH=function(){
if(this.AUTOGEOCODECOVSWITCH===null){
this.AUTOGEOCODECOVSWITCH=MQA.createXMLDoc("<AutoGeocodeCovSwitch/>");
}
return this.AUTOGEOCODECOVSWITCH;
};
this.getAUTOROUTECOVSWITCH=function(){
if(this.AUTOROUTECOVSWITCH===null){
this.AUTOROUTECOVSWITCH=MQA.createXMLDoc("<AutoRouteCovSwitch><Name/><DataVendorCodeUsage>0</DataVendorCodeUsage><DataVendorCodes Count=\"0\"/></AutoRouteCovSwitch>");
}
return this.AUTOROUTECOVSWITCH;
};
this.getAUTOMAPCOVSWITCH=function(){
if(this.AUTOMAPCOVSWITCH===null){
this.AUTOMAPCOVSWITCH=MQA.createXMLDoc("<AutoMapCovSwitch><Name/><Style/><DataVendorCodeUsage>0</DataVendorCodeUsage><DataVendorCodes Count=\"0\"/><ZoomLevels Count=\"14\"><Item>6000</Item><Item>12000</Item><Item>24000</Item><Item>48000</Item><Item>96000</Item><Item>192000</Item><Item>400000</Item><Item>800000</Item><Item>1600000</Item><Item>3000000</Item><Item>6000000</Item><Item>12000000</Item><Item>24000000</Item><Item>48000000</Item></ZoomLevels></AutoMapCovSwitch>");
}
return this.AUTOMAPCOVSWITCH;
};
this.getDBLAYERQUERY=function(){
if(this.DBLAYERQUERY===null){
this.DBLAYERQUERY=MQA.createXMLDoc("<DBLayerQuery/>");
}
return this.DBLAYERQUERY;
};
this.getLINEPRIMITIVE=function(){
if(this.LINEPRIMITIVE===null){
this.LINEPRIMITIVE=MQA.createXMLDoc("<LinePrimitive Version=\"2\"/>");
}
return this.LINEPRIMITIVE;
};
this.getPOLYGONPRIMITIVE=function(){
if(this.POLYGONPRIMITIVE===null){
this.POLYGONPRIMITIVE=MQA.createXMLDoc("<PolygonPrimitive Version=\"2\"/>");
}
return this.POLYGONPRIMITIVE;
};
this.getRECTANGLEPRIMITIVE=function(){
if(this.RECTANGLEPRIMITIVE===null){
this.RECTANGLEPRIMITIVE=MQA.createXMLDoc("<RectanglePrimitive Version=\"2\"/>");
}
return this.RECTANGLEPRIMITIVE;
};
this.getELLIPSEPRIMITIVE=function(){
if(this.ELLIPSEPRIMITIVE===null){
this.ELLIPSEPRIMITIVE=MQA.createXMLDoc("<EllipsePrimitive Version=\"2\"/>");
}
return this.ELLIPSEPRIMITIVE;
};
this.getTEXTPRIMITIVE=function(){
if(this.TEXTPRIMITIVE===null){
this.TEXTPRIMITIVE=MQA.createXMLDoc("<TextPrimitive Version=\"2\"/>");
}
return this.TEXTPRIMITIVE;
};
this.getSYMBOLPRIMITIVE=function(){
if(this.SYMBOLPRIMITIVE===null){
this.SYMBOLPRIMITIVE=MQA.createXMLDoc("<SymbolPrimitive Version=\"2\"/>");
}
return this.SYMBOLPRIMITIVE;
};
this.getLATLNG=function(){
if(this.LATLNG===null){
this.LATLNG=MQA.createXMLDoc("<LatLng/>");
}
return this.LATLNG;
};
this.getPOINT=function(){
if(this.POINT===null){
this.POINT=MQA.createXMLDoc("<Point/>");
}
return this.POINT;
};
this.getPOINTFEATURE=function(){
if(this.POINTFEATURE===null){
this.POINTFEATURE=MQA.createXMLDoc("<PointFeature/>");
}
return this.POINTFEATURE;
};
this.getLINEFEATURE=function(){
if(this.LINEFEATURE===null){
this.LINEFEATURE=MQA.createXMLDoc("<LineFeature/>");
}
return this.LINEFEATURE;
};
this.getPOLYGONFEATURE=function(){
if(this.POLYGONFEATURE===null){
this.POLYGONFEATURE=MQA.createXMLDoc("<PolygonFeature/>");
}
return this.POLYGONFEATURE;
};
this.getLOCATION=function(){
if(this.LOCATION===null){
this.LOCATION=MQA.createXMLDoc("<Location/>");
}
return this.LOCATION;
};
this.getADDRESS=function(){
if(this.ADDRESS===null){
this.ADDRESS=MQA.createXMLDoc("<Address/>");
}
return this.ADDRESS;
};
this.getSINGLELINEADDRESS=function(){
if(this.SINGLELINEADDRESS===null){
this.SINGLELINEADDRESS=MQA.createXMLDoc("<SingleLineAddress/>");
}
return this.SINGLELINEADDRESS;
};
this.getGEOADDRESS=function(){
if(this.GEOADDRESS===null){
this.GEOADDRESS=MQA.createXMLDoc("<GeoAddress/>");
}
return this.GEOADDRESS;
};
this.getGEOCODEOPTIONS=function(){
if(this.GEOCODEOPTIONS===null){
this.GEOCODEOPTIONS=MQA.createXMLDoc("<GeocodeOptions/>");
}
return this.GEOCODEOPTIONS;
};
this.getMANEUVER=function(){
if(this.MANEUVER===null){
this.MANEUVER=MQA.createXMLDoc("<Maneuver Version=\"1\"><Narrative/><Streets Count=\"0\"/><TurnType>-1</TurnType><Distance>0.0</Distance><Time>-1</Time><Direction>0</Direction><ShapePoints Count=\"0\"/><GEFIDs Count=\"0\"/><Signs  Count=\"0\"/></Maneuver>");
}
return this.MANEUVER;
};
this.getROUTEOPTIONS=function(){
if(this.ROUTEOPTIONS===null){
this.ROUTEOPTIONS=MQA.createXMLDoc("<RouteOptions Version=\"3\"><RouteType>0</RouteType><NarrativeType>1</NarrativeType><NarrativeDistanceUnitType>0</NarrativeDistanceUnitType><MaxShape>0</MaxShape><MaxGEFID>0</MaxGEFID><Language>English</Language><CoverageName></CoverageName><CovSwitcher><Name></Name><DataVendorCodeUsage>0</DataVendorCodeUsage><DataVendorCodes Count=\"0\"/></CovSwitcher><AvoidAttributeList Count=\"0\"/><AvoidGefIdList Count=\"0\"/><AvoidAbsoluteGefIdList Count=\"0\"/><StateBoundaryDisplay>1</StateBoundaryDisplay><CountryBoundaryDisplay>1</CountryBoundaryDisplay></RouteOptions>");
}
return this.ROUTEOPTIONS;
};
this.getROUTERESULTS=function(){
if(this.ROUTERESULTS===null){
this.ROUTERESULTS=MQA.createXMLDoc("<RouteResults Version=\"1\"><Locations Count=\"0\"/><CoverageName/><ResultMessages Count=\"0\"/><TrekRoutes Count=\"0\"/></RouteResults>");
}
return this.ROUTERESULTS;
};
this.getROUTEMATRIXRESULTS=function(){
if(this.ROUTEMATRIXRESULTS===null){
this.ROUTEMATRIXRESULTS=MQA.createXMLDoc("<RouteMatrixResults/>");
}
return this.ROUTEMATRIXRESULTS;
};
this.getRADIUSSEARCHCRITERIA=function(){
if(this.RADIUSSEARCHCRITERIA===null){
this.RADIUSSEARCHCRITERIA=MQA.createXMLDoc("<RadiusSearchCriteria/>");
}
return this.RADIUSSEARCHCRITERIA;
};
this.getRECTSEARCHCRITERIA=function(){
if(this.RECTSEARCHCRITERIA===null){
this.RECTSEARCHCRITERIA=MQA.createXMLDoc("<RectSearchCriteria/>");
}
return this.RECTSEARCHCRITERIA;
};
this.getPOLYSEARCHCRITERIA=function(){
if(this.POLYSEARCHCRITERIA===null){
this.POLYSEARCHCRITERIA=MQA.createXMLDoc("<PolySearchCriteria/>");
}
return this.POLYSEARCHCRITERIA;
};
this.getCORRIDORSEARCHCRITERIA=function(){
if(this.CORRIDORSEARCHCRITERIA===null){
this.CORRIDORSEARCHCRITERIA=MQA.createXMLDoc("<CorridorSearchCriteria/>");
}
return this.CORRIDORSEARCHCRITERIA;
};
this.getSIGN=function(){
if(this.SIGN===null){
this.SIGN=MQA.createXMLDoc("<Sign><Type>0</Type><Text></Text><ExtraText></ExtraText><Direction>0</Direction></Sign>");
}
return this.SIGN;
};
this.getTREKROUTE=function(){
if(this.TREKROUTE===null){
this.TREKROUTE=MQA.createXMLDoc("<TrekRoute><Maneuvers Count=\"0\"/></TrekRoute>");
}
return this.TREKROUTE;
};
this.getINTCOLLECTION=function(){
if(this.INTCOLLECTION===null){
this.INTCOLLECTION=MQA.createXMLDoc("<IntCollection Count=\"0\"/>");
}
return this.INTCOLLECTION;
};
this.getDTCOLLECTION=function(){
if(this.DTCOLLECTION===null){
this.DTCOLLECTION=MQA.createXMLDoc("<DTCollection Version=\"1\" Count=\"0\"/>");
}
return this.DTCOLLECTION;
};
this.getLATLNGCOLLECTION=function(){
if(this.LATLNGCOLLECTION===null){
this.LATLNGCOLLECTION=MQA.createXMLDoc("<LatLngCollection Version=\"1\" Count=\"0\"/>");
}
return this.LATLNGCOLLECTION;
};
this.getLOCATIONCOLLECTION=function(){
if(this.LOCATIONCOLLECTION===null){
this.LOCATIONCOLLECTION=MQA.createXMLDoc("<LocationCollection Count=\"0\"/>");
}
return this.LOCATIONCOLLECTION;
};
this.getLOCATIONCOLLECTIONCOLLECTION=function(){
if(this.LOCATIONCOLLECTIONCOLLECTION===null){
this.LOCATIONCOLLECTIONCOLLECTION=MQA.createXMLDoc("<LocationCollectionCollection Count=\"0\"/>");
}
return this.LOCATIONCOLLECTIONCOLLECTION;
};
this.getMANEUVERCOLLECTION=function(){
if(this.MANEUVERCOLLECTION===null){
this.MANEUVERCOLLECTION=MQA.createXMLDoc("<ManeuverCollection Count=\"0\"/>");
}
return this.MANEUVERCOLLECTION;
};
this.getSIGNCOLLECTION=function(){
if(this.SIGNCOLLECTION===null){
this.SIGNCOLLECTION=MQA.createXMLDoc("<SignCollection Count=\"0\"/>");
}
return this.SIGNCOLLECTION;
};
this.getSTRINGCOLLECTION=function(){
if(this.STRINGCOLLECTION===null){
this.STRINGCOLLECTION=MQA.createXMLDoc("<StringCollection Count=\"0\"/>");
}
return this.STRINGCOLLECTION;
};
this.getSTRCOLCOLLECTION=function(){
if(this.STRCOLCOLLECTION===null){
this.STRCOLCOLLECTION=MQA.createXMLDoc("<StrColCollectin/>");
}
return this.STRCOLCOLLECTION;
};
this.getFEATURECOLLECTION=function(){
if(this.FEATURECOLLECTION===null){
this.FEATURECOLLECTION=MQA.createXMLDoc("<FeatureCollection Count=\"0\"/>");
}
return this.FEATURECOLLECTION;
};
this.getPRIMITIVECOLLECTION=function(){
if(this.PRIMITIVECOLLECTION===null){
this.PRIMITIVECOLLECTION=MQA.createXMLDoc("<PrimitiveCollection Count=\"0\"/>");
}
return this.PRIMITIVECOLLECTION;
};
this.getPOINTCOLLECTION=function(){
if(this.POINTCOLLECTION===null){
this.POINTCOLLECTION=MQA.createXMLDoc("<PointCollection Count=\"0\"/>");
}
return this.POINTCOLLECTION;
};
this.getTREKROUTECOLLECTION=function(){
if(this.TREKROUTECOLLECTION===null){
this.TREKROUTECOLLECTION=MQA.createXMLDoc("<TrekRouteCollection Count=\"0\"/>");
}
return this.TREKROUTECOLLECTION;
};
this.getFEATURESPECIFIERCOLLECTION=function(){
if(this.FEATURESPECIFIERCOLLECTION===null){
this.FEATURESPECIFIERCOLLECTION=MQA.createXMLDoc("<FeatureSpecifierCollection Count=\"0\"/>");
}
return this.FEATURESPECIFIERCOLLECTION;
};
this.getGEOCODEOPTIONSCOLLECTION=function(){
if(this.GEOCODEOPTIONSCOLLECTION===null){
this.GEOCODEOPTIONSCOLLECTION=MQA.createXMLDoc("<GeocodeOptionsCollection Count=\"0\"/>");
}
return this.GEOCODEOPTIONSCOLLECTION;
};
this.getCOVERAGESTYLE=function(){
if(this.COVERAGESTYLE===null){
this.COVERAGESTYLE=MQA.createXMLDoc("<CoverageStyle/>");
}
return this.COVERAGESTYLE;
};
this.getRECORDSET=function(){
if(this.RECORDSET===null){
this.RECORDSET=MQA.createXMLDoc("<RecordSet/>");
}
return this.RECORDSET;
};
this.getMAPSTATE=function(){
if(this.MAPSTATE===null){
this.MAPSTATE=MQA.createXMLDoc("<MapState/>");
}
return this.MAPSTATE;
};
this.getSESSION=function(){
if(this.SESSION===null){
this.SESSION=MQA.createXMLDoc("<Session Count=\"0\"/>");
}
return this.SESSION;
};
this.getSESSIONID=function(){
if(this.SESSIONID===null){
this.SESSIONID=MQA.createXMLDoc("<SessionID/>");
}
return this.SESSIONID;
};
this.getDTSTYLE=function(){
if(this.DTSTYLE===null){
this.DTSTYLE=MQA.createXMLDoc("<DTStyle/>");
}
return this.DTSTYLE;
};
this.getDTSTYLEEX=function(){
if(this.DTSTYLEEX===null){
this.DTSTYLEEX=MQA.createXMLDoc("<DTStyleEx/>");
}
return this.DTSTYLEEX;
};
this.getDTFEATURESTYLEEX=function(){
if(this.DTFEATURESTYLEEX===null){
this.DTFEATURESTYLEEX=MQA.createXMLDoc("<DTFeatureStyleEx/>");
}
return this.DTFEATURESTYLEEX;
};
this.getFEATURESPECIFIER=function(){
if(this.FEATURESPECIFIER===null){
this.FEATURESPECIFIER=MQA.createXMLDoc("<FeatureSpecifier/>");
}
return this.FEATURESPECIFIER;
};
this.getBESTFIT=function(){
if(this.BESTFIT===null){
this.BESTFIT=MQA.createXMLDoc("<BestFit Version=\"2\"/>");
}
return this.BESTFIT;
};
this.getBESTFITLL=function(){
if(this.BESTFITLL===null){
this.BESTFITLL=MQA.createXMLDoc("<BestFitLL Version=\"2\"/>");
}
return this.BESTFITLL;
};
this.getCENTER=function(){
if(this.CENTER===null){
this.CENTER=MQA.createXMLDoc("<Center/>");
}
return this.CENTER;
};
this.getCENTERLATLNG=function(){
if(this.CENTERLATLNG===null){
this.CENTERLATLNG=MQA.createXMLDoc("<CenterLatLng/>");
}
return this.CENTERLATLNG;
};
this.getPAN=function(){
if(this.PAN===null){
this.PAN=MQA.createXMLDoc("<Pan/>");
}
return this.PAN;
};
this.getZOOMIN=function(){
if(this.ZOOMIN===null){
this.ZOOMIN=MQA.createXMLDoc("<ZoomIn/>");
}
return this.ZOOMIN;
};
this.getZOOMOUT=function(){
if(this.ZOOMOUT===null){
this.ZOOMOUT=MQA.createXMLDoc("<ZoomOut/>");
}
return this.ZOOMOUT;
};
this.getZOOMTO=function(){
if(this.ZOOMTO===null){
this.ZOOMTO=MQA.createXMLDoc("<ZoomTo/>");
}
return this.ZOOMTO;
};
this.getZOOMTORECT=function(){
if(this.ZOOMTORECT===null){
this.ZOOMTORECT=MQA.createXMLDoc("<ZoomToRect/>");
}
return this.ZOOMTORECT;
};
this.getZOOMTORECTLATLNG=function(){
if(this.ZOOMTORECTLATLNG===null){
this.ZOOMTORECTLATLNG=MQA.createXMLDoc("<ZoomToRectLatLng/>");
}
return this.ZOOMTORECTLATLNG;
};
};
MQXMLDOC=MQA.XMLDOC;
MQA.MQXML=new MQA.XMLDOC();
MQXML=MQA.MQXML;
MQA.ObjectCollection=function(max){
MQA.Object.call(this);
var _41=new Array();
this.getM_Items=function(){
return _41;
};
var _42=(max!==null)?max:-1;
var _43="MQObject";
this.getValidClassName=function(){
return _43;
};
this.setValidClassName=function(_44){
_43=_44;
};
this.add=function(obj){
if(this.isValidObject(obj)){
if(_42!==-1&&_41.length===max){
return;
}
_41.push(obj);
return _41.length;
}
return;
};
this.getSize=function(){
return _41.length;
};
this.get=function(i){
return _41[i];
};
this.remove=function(_47){
return _41.splice(_47,1);
};
this.removeAll=function(){
_41=null;
_41=new Array();
};
this.contains=function(_48){
var _49=this.getSize();
for(var _4a=0;_4a<_49;_4a++){
if(_41[_4a]===_48){
return true;
}
}
return false;
};
this.append=function(_4b){
if(this.getClassName()===_4b.getClassName()){
_41=_41.concat(_4b.getM_Items());
}else{
alert("Invalid attempt to append "+this.getClassName()+" to "+_4b.getClassName()+"!");
throw "Invalid attempt to append "+this.getClassName()+" to "+_4b.getClassName()+"!";
}
};
this.set=function(i,_4d){
var _4e=get(i);
_41[i]=_4d;
return _4e;
};
this.isValidObject=function(obj){
if(obj!==null){
if(_43==="ALL"){
return true;
}else{
if(_43==="MQObject"){
return true;
}else{
if(_43==="String"){
return true;
}else{
if(_43==="int"){
if(isNaN(obj)){
return false;
}else{
if(obj===Math.floor(obj)){
return true;
}
}
}else{
if(obj.getClassName()===_43){
return true;
}
}
}
}
}
}
return false;
};
var _50="Item";
this.getM_itemXpath=function(){
return _50;
};
this.setM_itemXpath=function(_51){
_50=_51;
};
this.getById=function(_52){
try{
for(var _53=0;_53<this.getSize();_53++){
if(_41[_53].getId()==_52){
return _41[_53];
}
}
}
catch(Error){
}
return null;
};
this.removeItem=function(_54){
for(var i=0;i<_41.length;i++){
if(_41[i]==_54){
this.remove(i);
i=_41.length;
}
}
};
};
MQA.ObjectCollection.prototype=new MQA.Object();
MQA.ObjectCollection.prototype.constructor=MQA.ObjectCollection;
MQA.ObjectCollection.prototype.getClassName=function(){
return "MQObjectCollection";
};
MQA.ObjectCollection.prototype.getObjectVersion=function(){
return 0;
};
MQA.ObjectCollection.prototype.getAt=function(i){
return this.get(i);
};
MQObjectCollection=MQA.ObjectCollection;
MQA.LatLngCollection=function(){
MQA.ObjectCollection.call(this,32678);
this.setValidClassName("MQLatLng");
this.setM_Xpath("LatLngCollection");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getLATLNGCOLLECTION()));
};
MQA.LatLngCollection.prototype=new MQA.ObjectCollection(32678);
MQA.LatLngCollection.prototype.constructor=MQA.LatLngCollection;
MQA.LatLngCollection.prototype.getClassName=function(){
return "MQLatLngCollection";
};
MQA.LatLngCollection.prototype.getObjectVersion=function(){
return 1;
};
MQA.LatLngCollection.prototype.loadXml=function(_57){
this.removeAll();
var _58=MQA.createXMLDoc(_57);
this.setM_XmlDoc(_58);
if(_58!==null){
this._loadCollection(_58);
}
};
MQA.LatLngCollection.prototype.loadXmlFromNode=function(_59){
this.removeAll();
var _5a=mqCreateXMLDocImportNode(_59);
this.setM_XmlDoc(_5a);
if(_5a!==null){
this._loadCollection(_5a);
}
};
MQA.LatLngCollection.prototype._loadCollection=function(_5b){
var _5c=_5b.documentElement;
var _5d=_5c.childNodes;
var _5e=_5d.length;
_5e=(_5e<32678)?_5e:32678;
var _5f=0;
var _60=0;
var _61=0;
var _62=0;
var _63=null;
if(this.getValidClassName()==="MQLatLng"){
for(var _64=0;_64<_5e;_64++){
if(_64==0){
if(_5d[_64].firstChild!==null){
_61=_5d[_64].firstChild.nodeValue/1000000;
}
_64++;
if(_5d[_64].firstChild!==null){
_62=_5d[_64].firstChild.nodeValue/1000000;
}
}else{
if(_5d[_64].firstChild!==null){
_61=_5f+(_5d[_64].firstChild.nodeValue/1000000);
}
_64++;
if(_5d[_64].firstChild!==null){
_62=_60+(_5d[_64].firstChild.nodeValue/1000000);
}
}
_5f=_61;
_60=_62;
_63=new MQA.LatLng(_61,_62);
this.add(_63);
}
}
};
MQA.LatLngCollection.prototype.saveXml=function(){
var _65="<"+this.getM_Xpath()+" Version=\""+this.getObjectVersion()+"\" Count=\""+this.getSize()+"\">";
var _66=parseInt(this.getSize());
if(_66>=1){
var _67=nLng=nPrevLat=nPrevLng=nDeltaLat=nDeltaLng=0;
var _68=null;
for(var i=0;i<_66;i++){
_68=this.getAt(i);
_67=parseInt(_68.getLatitude()*1000000);
nLng=parseInt(_68.getLongitude()*1000000);
nDeltaLat=_67-nPrevLat;
nDeltaLng=nLng-nPrevLng;
_65+="<Lat>"+nDeltaLat+"</Lat>";
_65+="<Lng>"+nDeltaLng+"</Lng>";
nPrevLat=_67;
nPrevLng=nLng;
}
}
_65=_65+"</"+this.getM_Xpath()+">";
return _65;
};
MQA.LatLngCollection.prototype.generalize=function(_6a){
var _6b=function(){
this.pLL=null;
this.dSegmentLength=0;
this.dPriorLength=0;
};
var _6c=function(){
this.pLL=null;
this.ulOriginalPoint=0;
};
mqllAnchor=null;
var _6d;
var i;
var _6f=0;
var _70=this.getSize();
var _71=new Array(_70);
var _72=new Array(_70);
var _73=0;
if(_70<2){
return;
}
for(i=0;i<_70;i++){
_71[i]=new _6b();
_72[i]=new _6c();
_71[i].pLL=this.getAt(i);
}
for(i=0;i<_70-1;i++){
_71[i].dSegmentLength=_71[i].pLL.arcDistance(_71[(i+1)].pLL);
if(i==0){
_71[i].dPriorLength=0;
}else{
_71[i].dPriorLength=_6f;
}
_6f+=_71[i].dSegmentLength;
}
mqllAnchor=_71[0].pLL;
_6d=0;
_72[0].pLL=mqllAnchor;
_72[0].ulOriginalPoint=0;
_73=1;
for(i=2;i<_70;i++){
if(!this.isEverybodyWithinDeviation(_71,_6d,i,_6a)){
mqllAnchor=_71[(i-1)].pLL;
_6d=(i-1);
_72[_73].pLL=mqllAnchor;
_72[_73].ulOriginalPoint=(i-1);
_73++;
}
}
_72[_73].pLL=_71[_70-1].pLL;
_72[_73].ulOriginalPoint=_70-1;
_73++;
var _74=_70;
var _75;
for(_75=(_73-1);_75>=0;_75--){
if((_74-1)!=_72[_75].ulOriginalPoint){
for(var x=(_74-1);x>_72[_75].ulOriginalPoint;x--){
try{
this.remove(x);
}
catch(e){
}
}
_74=_72[_75].ulOriginalPoint;
}else{
_74--;
}
}
_71=null;
_72=null;
};
MQA.LatLngCollection.prototype.isEverybodyWithinDeviation=function(_77,_78,_79,_7a){
var _7b=0;
var _7c=0;
var _7d=null;
var _7e=null;
var _7f=0;
var _80=0;
var _81=0;
var i;
var _83=null;
var _84=0;
var _85=0;
var _86=0;
var _87=0;
var _88=0;
var _89=0;
var _8a=0;
var _8b=0;
_7b=MQA.DistanceApproximation.getMilesPerLngDeg(_77[_78].pLL.getLatitude());
_7c=_7a*_7a;
_7d=_77[_78].pLL;
_7e=_77[_79].pLL;
_7f=(_7e.getLatitude()-_7d.getLatitude())*MQA.DistanceApproximation.MILES_PER_LATITUDE;
_80=(_7e.getLongitude()-_7d.getLongitude())*_7b;
_81=_7f*_7f+_80*_80;
for(i=_78+1;i<_79;i++){
_83=_77[i].pLL;
_84=(_83.getLatitude()-_7d.getLatitude())*MQA.DistanceApproximation.MILES_PER_LATITUDE;
_85=(_83.getLongitude()-_7d.getLongitude())*_7b;
_86=_84*_84+_85*_85;
_88=_7f*_84+_80*_85;
_89=_7f*_7f+_80*_80;
if(_89==0){
_87=0;
}else{
_87=_88/_89;
}
_8a=_87*_87*_81;
_8b=_86-_8a;
if(_8b>_7c){
return false;
}
}
return true;
};
MQLatLngCollection=MQA.LatLngCollection;
MQA.DistanceApproximation=new function(){
this.m_testLat;
this.m_testLng;
this.m_mpd;
this.m_milesPerLngDeg=new Array(69.170976,69.160441,69.128838,69.076177,69.002475,68.907753,68.792041,68.655373,68.497792,68.319345,68.120088,67.900079,67.659387,67.398085,67.116253,66.813976,66.491346,66.148462,65.785428,65.402355,64.999359,64.576564,64.134098,63.672096,63.190698,62.690052,62.17031,61.63163,61.074176,60.498118,59.903632,59.290899,58.660106,58.011443,57.345111,56.66131,55.96025,55.242144,54.507211,53.755675,52.987764,52.203713,51.403761,50.588151,49.757131,48.910956,48.049882,47.174172,46.284093,45.379915,44.461915,43.530372,42.58557,41.627796,40.657342,39.674504,38.679582,37.672877,36.654698,35.625354,34.585159,33.534429,32.473485,31.40265,30.322249,29.232613,28.134073,27.026963,25.911621,24.788387,23.657602,22.519612,21.374762,20.223401,19.065881,17.902554,16.733774,15.559897,14.38128,13.198283,12.011266,10.820591,9.626619,8.429716,7.230245,6.028572,4.825062,3.620083,2.414002,1.207185,1);
this.MILES_PER_LATITUDE=69.170976;
this.KILOMETERS_PER_MILE=1.609347;
this.getMilesPerLngDeg=function(lat){
return (Math.abs(lat)<=90)?this.m_milesPerLngDeg[parseInt(Math.abs(lat)+0.5)]:69.170976;
};
};
DistanceApproximation=MQA.DistanceApproximation;

