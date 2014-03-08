try{
var testCommons=new MQObject();
testCommons=null;
}
catch(error){
throw "You must include mqcommon.js or toolkit api script prior to mqobjects.js.";
}
function mqIsClass(_1,_2,_3){
if(_2!==null){
try{
_2.getClassName();
}
catch(error){
throw "InvalidClassException";
}
if(_2.getClassName()===_1){
return true;
}else{
throw "InvalidClassException";
}
}else{
if(_3){
return true;
}
}
throw "NullPointerException";
}
function MQConstants(){
this.MQDISTANCEUNITS_MILES=0;
this.MQDISTANCEUNITS_KILOMETERS=1;
this.MQLATLNG_RADIANS=0.01745329251994;
this.MQLATLNG_INVALID=314159.265358;
this.MQLATLNG_TOLERANCE=0.000001;
this.MQPOINT_INVALID=32767;
this.PI=3.141592653589793;
this.MQSEARCHCRITERIA_MILES_PER_DEGREE_LAT=68.9;
this.MQSEARCHCRITERIA_DEGREES_LAT_PER_MILE=(1/this.MQSEARCHCRITERIA_MILES_PER_DEGREE_LAT);
this.DISTANCEAPPROX_MILES_PER_LATITUDE=69.170976;
this.DISTANCEAPPROX_KILOMETERS_PER_MILE=1.609347;
this.MQROUTETYPE_FASTEST=0;
this.MQROUTETYPE_SHORTEST=1;
this.MQROUTETYPE_PEDESTRIAN=2;
this.MQROUTETYPE_OPTIMIZED=3;
this.MQROUTETYPE_SELECT_DATASET_ONLY=4;
this.MQNARRATIVETYPE_DEFAULT=0;
this.MQNARRATIVETYPE_HTML=1;
this.MQNARRATIVETYPE_NONE=-1;
this.MQROUTEOPTIONS_AVOID_ATTRIBUTE_LIMITED_ACCESS="Limited Access";
this.MQROUTEOPTIONS_AVOID_ATTRIBUTE_TOLL_ROAD="Toll Road";
this.MQROUTEOPTIONS_AVOID_ATTRIBUTE_FERRY="Ferry";
this.MQROUTEOPTIONS_AVOID_ATTRIBUTE_UNPAVED_ROAD="Unpaved";
this.MQROUTEOPTIONS_AVOID_ATTRIBUTE_SEASONAL="Approximate seasonal closure";
this.MQROUTEOPTIONS_LANGUAGE_ENGLISH="English";
this.MQROUTEOPTIONS_LANGUAGE_FRENCH="French";
this.MQROUTEOPTIONS_LANGUAGE_GERMAN="German";
this.MQROUTEOPTIONS_LANGUAGE_ITALIAN="Italian";
this.MQROUTEOPTIONS_LANGUAGE_SPANISH="Spanish";
this.MQROUTEOPTIONS_LANGUAGE_DANISH="Danish";
this.MQROUTEOPTIONS_LANGUAGE_DUTCH="Dutch";
this.MQROUTEOPTIONS_LANGUAGE_NORWEGIAN="Norwegian";
this.MQROUTEOPTIONS_LANGUAGE_SWEDISH="Swedish";
this.MQROUTEOPTIONS_LANGUAGE_IBERIAN_SPANISH="Iberian Spanish";
this.MQROUTEOPTIONS_LANGUAGE_BRITISH_ENGLISH="British English";
this.MQROUTEOPTIONS_LANGUAGE_IBERIAN_PORTUGUESE="Iberian Portuguese";
this.MQROUTERESULTSCODE_NOT_SPECIFIED=-1;
this.MQROUTERESULTSCODE_SUCCESS=0;
this.MQROUTERESULTSCODE_INVALID_LOCATION=1;
this.MQROUTERESULTSCODE_ROUTE_FAILURE=2;
this.MQROUTERESULTSCODE_NO_DATASET_FOUND=3;
this.MQROUTEMATRIXRESULTSCODE_NOT_SPECIFIED=-1;
this.MQROUTEMATRIXRESULTSCODE_SUCCESS=0;
this.MQROUTEMATRIXRESULTSCODE_INVALID_LOCATION=1;
this.MQROUTEMATRIXRESULTSCODE_ROUTE_FAILURE=2;
this.MQROUTEMATRIXRESULTSCODE_NO_DATASET_FOUND=3;
this.MQROUTEMATRIXRESULTSCODE_INVALID_OPTION=4;
this.MQROUTEMATRIXRESULTSCODE_PARTIAL_SUCCESS=5;
this.MQROUTEMATRIXRESULTSCODE_EXCEEDED_MAX_LOCATIONS=6;
this.MQMANEUVER_HEADING_NULL=0;
this.MQMANEUVER_HEADING_NORTH=1;
this.MQMANEUVER_HEADING_NORTH_WEST=2;
this.MQMANEUVER_HEADING_NORTH_EAST=3;
this.MQMANEUVER_HEADING_SOUTH=4;
this.MQMANEUVER_HEADING_SOUTH_EAST=5;
this.MQMANEUVER_HEADING_SOUTH_WEST=6;
this.MQMANEUVER_HEADING_WEST=7;
this.MQMANEUVER_HEADING_EAST=8;
this.MQMANEUVER_TURN_TYPE_STRAIGHT=0;
this.MQMANEUVER_TURN_TYPE_SLIGHT_RIGHT=1;
this.MQMANEUVER_TURN_TYPE_RIGHT=2;
this.MQMANEUVER_TURN_TYPE_SHARP_RIGHT=3;
this.MQMANEUVER_TURN_TYPE_REVERSE=4;
this.MQMANEUVER_TURN_TYPE_SHARP_LEFT=5;
this.MQMANEUVER_TURN_TYPE_LEFT=6;
this.MQMANEUVER_TURN_TYPE_SLIGHT_LEFT=7;
this.MQMANEUVER_TURN_TYPE_RIGHT_UTURN=8;
this.MQMANEUVER_TURN_TYPE_LEFT_UTURN=9;
this.MQMANEUVER_TURN_TYPE_RIGHT_MERGE=10;
this.MQMANEUVER_TURN_TYPE_LEFT_MERGE=11;
this.MQMANEUVER_TURN_TYPE_RIGHT_ON_RAMP=12;
this.MQMANEUVER_TURN_TYPE_LEFT_ON_RAMP=13;
this.MQMANEUVER_TURN_TYPE_RIGHT_OFF_RAMP=14;
this.MQMANEUVER_TURN_TYPE_LEFT_OFF_RAMP=15;
this.MQMANEUVER_TURN_TYPE_RIGHT_FORK=16;
this.MQMANEUVER_TURN_TYPE_LEFT_FORK=17;
this.MQMANEUVER_TURN_TYPE_STRAIGHT_FORK=18;
this.MQMANEUVER_ATTRIBUTE_PORTIONS_TOLL=1;
this.MQMANEUVER_ATTRIBUTE_PORTIONS_UNPAVED=2;
this.MQMANEUVER_ATTRIBUTE_POSSIBLE_SEASONAL_ROAD_CLOSURE=4;
this.MQMANEUVER_ATTRIBUTE_GATE=8;
this.MQMANEUVER_ATTRIBUTE_FERRY=16;
this.MQCOORDINATETYPE_GEOGRAPHIC=1;
this.MQCOORDINATETYPE_DISPLAY=2;
this.MQDRAWTRIGGER_BEFORE_POLYGONS=3585;
this.MQDRAWTRIGGER_AFTER_POLYGONS=3586;
this.MQDRAWTRIGGER_BEFORE_TEXT=3588;
this.MQDRAWTRIGGER_AFTER_TEXT=3618;
this.MQDRAWTRIGGER_BEFORE_ROUTE_HIGHLIGHT=3616;
this.MQDRAWTRIGGER_AFTER_ROUTE_HIGHLIGHT=3617;
this.MQPENSTYLE_SOLID=0;
this.MQPENSTYLE_DASH=1;
this.MQPENSTYLE_DOT=2;
this.MQPENSTYLE_DASH_DOT=3;
this.MQPENSTYLE_DASH_DOT_DOT=4;
this.MQPENSTYLE_NONE=5;
this.MQCOLORSTYLE_INVALID=4294967295;
this.MQCOLORSTYLE_BLACK=0;
this.MQCOLORSTYLE_BLUE=16711680;
this.MQCOLORSTYLE_CYAN=16776960;
this.MQCOLORSTYLE_DARK_GRAY=4210752;
this.MQCOLORSTYLE_GRAY=8421504;
this.MQCOLORSTYLE_GREEN=65280;
this.MQCOLORSTYLE_LIGHT_GRAY=12632256;
this.MQCOLORSTYLE_MAGENTA=16711935;
this.MQCOLORSTYLE_ORANGE=51455;
this.MQCOLORSTYLE_PINK=11513855;
this.MQCOLORSTYLE_RED=255;
this.MQCOLORSTYLE_WHITE=16777215;
this.MQCOLORSTYLE_YELLOW=65535;
this.MQFILLSTYLE_SOLID=0;
this.MQFILLSTYLE_BDIAGONAL=1;
this.MQFILLSTYLE_CROSS=2;
this.MQFILLSTYLE_DIAG_CROSS=3;
this.MQFILLSTYLE_FDIAGONAL=4;
this.MQFILLSTYLE_HORIZONTAL=5;
this.MQFILLSTYLE_VERTICAL=6;
this.MQFILLSTYLE_NONE=7;
this.MQSYMBOLTYPE_RASTER=0;
this.MQSYMBOLTYPE_VECTOR=1;
this.MQTEXTALIGNMENT_CENTER=1;
this.MQTEXTALIGNMENT_LEFT=2;
this.MQTEXTALIGNMENT_RIGHT=4;
this.MQTEXTALIGNMENT_BASELINE=8;
this.MQTEXTALIGNMENT_BOTTOM=16;
this.MQTEXTALIGNMENT_TOP=32;
this.MQFONTSTYLE_INVALID=-1;
this.MQFONTSTYLE_NORMAL=0;
this.MQFONTSTYLE_BOLD=1;
this.MQFONTSTYLE_BOXED=2;
this.MQFONTSTYLE_OUTLINED=4;
this.MQFONTSTYLE_ITALICS=8;
this.MQFONTSTYLE_UNDERLINE=16;
this.MQFONTSTYLE_STRIKEOUT=32;
this.MQFONTSTYLE_THIN=64;
this.MQFONTSTYLE_SEMIBOLD=128;
this.MQFONTSTYLE_MAX_VALUE=256;
this.MQBASEDTSTYLE_DT_NULL=65532;
this.MQBASEDTSTYLE_CT_ROAD=0;
this.MQBASEDTSTYLE_CT_LINE=1;
this.MQBASEDTSTYLE_CT_POLYGON=2;
this.MQBASEDTSTYLE_CT_POINT=3;
this.MQBASEDTSTYLE_CT_POI=4;
this.MQBASEDTSTYLE_CT_SEED=5;
this.MQBASEDTSTYLE_CT_DISPLAYLIST=6;
this.MQBASEDTSTYLE_CT_APP=7;
this.MQBASEDTSTYLE_CT_XA=8;
this.MQBASEDTSTYLE_BT_LINE=0;
this.MQBASEDTSTYLE_BT_POLYGON=1;
this.MQBASEDTSTYLE_BT_POINT=2;
this.MQBASEDTSTYLE_BT_OTHER=3;
this.MQBASEDTSTYLE_BT_XA=4;
this.MQFEATURESPECIFERATTRIBUTETYPE_GEFID=0;
this.MQFEATURESPECIFERATTRIBUTETYPE_NAME=1;
this.MQMATCHTYPE_LOC=0;
this.MQMATCHTYPE_INTR=1;
this.MQMATCHTYPE_NEARBLK=2;
this.MQMATCHTYPE_REPBLK=3;
this.MQMATCHTYPE_BLOCK=4;
this.MQMATCHTYPE_AA1=5;
this.MQMATCHTYPE_AA2=6;
this.MQMATCHTYPE_AA3=7;
this.MQMATCHTYPE_AA4=8;
this.MQMATCHTYPE_AA5=9;
this.MQMATCHTYPE_AA6=10;
this.MQMATCHTYPE_AA7=11;
this.MQMATCHTYPE_PC1=12;
this.MQMATCHTYPE_PC2=13;
this.MQMATCHTYPE_PC3=14;
this.MQMATCHTYPE_PC4=15;
this.MQMATCHTYPE_POI=16;
this.MQQUALITYTYPE_EXACT=0;
this.MQQUALITYTYPE_GOOD=1;
this.MQQUALITYTYPE_APPROX=2;
}
var MQCONSTANT=new MQConstants();
function MQErrors(){
this.RECORDSET_GETFIELD_1="failure in getField -- m_curRec is not Pointing to an existing Record";
this.RECORDSET_GETFIELD_2="failure in getField -- could not find strFieldName";
this.RECORDSET_MOVEFIRST_1="failure in moveFirst -- Error Moving Cursor, RecordSet is Empty.";
this.RECORDSET_MOVELAST_1="Error Moving Cursor, RecordSet is Empty.";
this.RECORDSET_MOVENEXT_1="Error Moving Cursor, EOF was true.";
this.RECORDSET_MOVENEXT_2="Error Moving Cursor, Unknown Error.";
this.RECORDSET_MOVENEXT_3="Error Moving Cursor, RecordSet is Empty.";
}
var MQERROR=new MQErrors();
MQSign.prototype=new MQObject();
MQSign.prototype.constructor=MQSign;
function MQSign(){
MQObject.call(this);
this.setM_Xpath("Sign");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getSIGN()));
}
MQSign.prototype.getClassName=function(){
return "MQSign";
};
MQSign.prototype.getObjectVersion=function(){
return 0;
};
MQSign.prototype.loadXml=function(_4){
this.setM_XmlDoc(MQA.createXMLDoc(_4));
};
MQSign.prototype.loadXmlFromNode=function(_5){
this.setM_XmlDoc(mqCreateXMLDocImportNode(_5));
};
MQSign.prototype.saveXml=function(){
return mqXmlToStr(this.getM_XmlDoc());
};
MQSign.prototype.clear=function(){
this.setType(0);
this.setText("");
this.setExtraText("");
this.setDirection(MQCONSTANT.MQMANEUVER_HEADING_NULL);
};
MQSign.prototype.setType=function(_6){
this.setProperty("Type",_6);
};
MQSign.prototype.getType=function(){
return this.getProperty("Type");
};
MQSign.prototype.setText=function(_7){
this.setProperty("Text",_7);
};
MQSign.prototype.getText=function(){
return this.getProperty("Text");
};
MQSign.prototype.setExtraText=function(_8){
this.setProperty("ExtraText",_8);
};
MQSign.prototype.getExtraText=function(){
return this.getProperty("ExtraText");
};
MQSign.prototype.setDirection=function(_9){
this.setProperty("Direction",_9);
};
MQSign.prototype.getDirection=function(){
return this.getProperty("Direction");
};
MQFeature.prototype=new MQObject();
MQFeature.prototype.constructor=MQFeature;
function MQFeature(){
MQObject.call(this);
}
MQFeature.prototype.getClassName=function(){
return "MQFeature";
};
MQFeature.prototype.getObjectVersion=function(){
return 0;
};
MQFeature.prototype.getDistance=function(){
return this.getProperty("Distance");
};
MQFeature.prototype.setDistance=function(_a){
this.setProperty("Distance",_a);
};
MQFeature.prototype.getName=function(){
return this.getProperty("Name");
};
MQFeature.prototype.setName=function(_b){
this.setProperty("Name",_b);
};
MQFeature.prototype.getSourceLayerName=function(){
return this.getProperty("SourceLayerName");
};
MQFeature.prototype.setSourceLayerName=function(_c){
this.setProperty("SourceLayerName",_c);
};
MQFeature.prototype.getKey=function(){
return this.getProperty("Key");
};
MQFeature.prototype.setKey=function(_d){
this.setProperty("Key",_d);
};
MQFeature.prototype.setGEFID=function(_e){
this.setProperty("GEFID",_e);
};
MQFeature.prototype.getGEFID=function(){
return this.getProperty("GEFID");
};
MQFeature.prototype.setDT=function(_f){
this.setProperty("DT",_f);
};
MQFeature.prototype.getDT=function(){
return this.getProperty("DT");
};
MQPointFeature.prototype=new MQFeature();
MQPointFeature.prototype.constructor=MQPointFeature;
function MQPointFeature(){
MQObject.call(this);
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getPOINTFEATURE()));
this.setM_Xpath("PointFeature");
this.m_CenterLatLng=new MQLatLng("CenterLatLng");
this.m_CenterPoint=new MQPoint("CenterPoint");
}
MQPointFeature.prototype.getClassName=function(){
return "MQPointFeature";
};
MQPointFeature.prototype.getObjectVersion=function(){
return 0;
};
MQPointFeature.prototype.loadXml=function(_10){
this.setM_XmlDoc(MQA.createXMLDoc(_10));
var _11=this.getCenterLatLng();
var _12=this.getCenterPoint();
var _13=mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterLatLng");
var _14=mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint");
if(_13!==null){
_11.loadXmlFromNode(_13);
}
if(_14!==null){
_12.loadXmlFromNode(_14);
}
};
MQPointFeature.prototype.loadXmlFromNode=function(_15){
this.setM_XmlDoc(mqCreateXMLDocImportNode(_15));
this.getCenterLatLng().setLatLng(this.getProperty("CenterLatLng/Lat"),this.getProperty("CenterLatLng/Lng"));
var x=this.getProperty("CenterPoint/X");
if(x!==""){
this.getCenterPoint().setXY(x,this.getProperty("CenterPoint/Y"));
}
};
MQPointFeature.prototype.saveXml=function(){
var _17=MQA.createXMLDoc(this.getCenterLatLng().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_17,"CenterLatLng"));
_17=MQA.createXMLDoc(this.getCenterPoint().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_17,"CenterPoint"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQPointFeature.prototype.getCenterLatLng=function(){
return this.m_CenterLatLng;
};
MQPointFeature.prototype.setCenterLatLng=function(_18){
this.m_CenterLatLng.setLatLng(_18.getLatitude(),_18.getLongitude());
};
MQPointFeature.prototype.getCenterPoint=function(){
return this.m_CenterPoint;
};
MQPointFeature.prototype.setCenterPoint=function(_19){
this.m_CenterPoint.setXY(_19.getX(),_19.getY());
};
MQPolygonFeature.prototype=new MQPointFeature();
MQPolygonFeature.prototype.constructor=MQPolygonFeature;
function MQPolygonFeature(){
MQPointFeature.call(this);
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getPOLYGONFEATURE()));
this.setM_Xpath("PolygonFeature");
var _1a=new MQLatLngCollection();
_1a.setM_Xpath("LatLngs");
this.getLatLngs=function(){
return _1a;
};
this.setLatLngs=function(_1b){
if(_1b.getClassName()==="MQLatLngCollection"){
_1a.removeAll();
_1a.append(_1b);
}else{
alert("failure in setLatLngs");
throw "failure in setLatLngs";
}
};
var _1c=new MQPointCollection();
_1c.setM_Xpath("Points");
this.getPoints=function(){
return _1c;
};
this.setPoints=function(pts){
_1c.removeAll();
_1c.append(pts);
};
}
MQPolygonFeature.prototype.getClassName=function(){
return "MQPolygonFeature";
};
MQPolygonFeature.prototype.getObjectVersion=function(){
return 0;
};
MQPolygonFeature.prototype.loadXml=function(_1e){
this.setM_XmlDoc(MQA.createXMLDoc(_1e));
var _1f=this.getCenterLatLng();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterLatLng")!==null){
_1f.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterLatLng")));
}
var _20=this.getCenterPoint();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")!==null){
_20.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")));
}
var _21=this.getLatLngs();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")!==null){
_21.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")));
}
var _22=this.getPoints();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Points")!==null){
_22.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Points")));
}
};
MQPolygonFeature.prototype.saveXml=function(){
var _23=MQA.createXMLDoc(this.getCenterLatLng().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_23,"CenterLatLng"));
_23=MQA.createXMLDoc(this.getCenterPoint().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_23,"CenterPoint"));
_23=MQA.createXMLDoc(this.getLatLngs().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_23,"LatLngs"));
_23=MQA.createXMLDoc(this.getPoints().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_23,"Points"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQLineFeature.prototype=new MQPolygonFeature();
MQLineFeature.prototype.constructor=MQLineFeature;
function MQLineFeature(){
MQPolygonFeature.call(this);
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getLINEFEATURE()));
this.setM_Xpath("LineFeature");
}
MQLineFeature.prototype.getClassName=function(){
return "MQLineFeature";
};
MQLineFeature.prototype.getObjectVersion=function(){
return 0;
};
MQLineFeature.prototype.loadXml=function(_24){
this.setM_XmlDoc(MQA.createXMLDoc(_24));
var _25=this.getCenterLatLng();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterLatLng")!==null){
_25.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterLatLng")));
}
var _26=this.getCenterPoint();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")!==null){
_26.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")));
}
var _27=this.getLatLngs();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")!==null){
_27.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")));
}
var _28=this.getPoints();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Points")!==null){
_28.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Points")));
}
};
MQLineFeature.prototype.saveXml=function(){
var _29=MQA.createXMLDoc(this.getCenterLatLng().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_29,"CenterLatLng"));
_29=MQA.createXMLDoc(this.getCenterPoint().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_29,"CenterPoint"));
_29=MQA.createXMLDoc(this.getLatLngs().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_29,"LatLngs"));
_29=MQA.createXMLDoc(this.getPoints().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_29,"Points"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQLineFeature.prototype.getLeftPostalCode=function(){
return this.getProperty("LeftPostalCode");
};
MQLineFeature.prototype.setLeftPostalCode=function(_2a){
this.setProperty("LeftPostalCode",_2a);
};
MQLineFeature.prototype.getRightPostalCode=function(){
return this.getProperty("RightPostalCode");
};
MQLineFeature.prototype.setRightPostalCode=function(_2b){
this.setProperty("RightPostalCode",_2b);
};
MQLineFeature.prototype.getLeftAddressHi=function(){
return this.getProperty("LeftAddressHi");
};
MQLineFeature.prototype.setLeftAddressHi=function(_2c){
this.setProperty("LeftAddressHi",_2c);
};
MQLineFeature.prototype.getRightAddressHi=function(){
return this.getProperty("RightAddressHi");
};
MQLineFeature.prototype.setRightAddressHi=function(_2d){
this.setProperty("RightAddressHi",_2d);
};
MQLineFeature.prototype.getLeftAddressLo=function(){
return this.getProperty("LeftAddressLo");
};
MQLineFeature.prototype.setLeftAddressLo=function(_2e){
this.setProperty("LeftAddressLo",_2e);
};
MQLineFeature.prototype.getRightAddressLo=function(){
return this.getProperty("RightAddressLo");
};
MQLineFeature.prototype.setRightAddressLo=function(_2f){
this.setProperty("RightAddressLo",_2f);
};
MQLocation.prototype=new MQObject();
MQLocation.prototype.constructor=MQLocation;
function MQLocation(){
MQObject.call(this);
this.setM_Xpath("Location");
}
MQLocation.prototype.getClassName=function(){
return "MQLocation";
};
MQLocation.prototype.getObjectVersion=function(){
return 0;
};
MQLocation.prototype.loadXml=function(_30){
this.setM_XmlDoc(MQA.createXMLDoc(_30));
};
MQLocation.prototype.saveXml=function(){
return mqXmlToStr(this.getM_XmlDoc());
};
MQAddress.prototype=new MQLocation();
MQAddress.prototype.constructor=MQAddress;
function MQAddress(){
MQLocation.call(this);
this.setM_Xpath("Address");
if(this.getClassName()==="MQAddress"){
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getADDRESS()));
}
}
MQAddress.prototype.getClassName=function(){
return "MQAddress";
};
MQAddress.prototype.getObjectVersion=function(){
return 0;
};
MQAddress.prototype.loadXml=function(_31){
this.setM_XmlDoc(MQA.createXMLDoc(_31));
};
MQAddress.prototype.saveXml=function(){
return mqXmlToStr(this.getM_XmlDoc());
};
MQAddress.prototype.getAdminArea=function(_32){
return this.getProperty("AdminArea"+_32);
};
MQAddress.prototype.setAdminArea=function(_33,_34){
this.setProperty("AdminArea"+_33,_34);
};
MQAddress.prototype.getCountry=function(){
return this.getProperty("AdminArea1");
};
MQAddress.prototype.setCountry=function(_35){
this.setProperty("AdminArea1",_35);
};
MQAddress.prototype.getCounty=function(){
return this.getProperty("AdminArea4");
};
MQAddress.prototype.setCounty=function(_36){
this.setProperty("AdminArea4",_36);
};
MQAddress.prototype.getCity=function(){
return this.getProperty("AdminArea5");
};
MQAddress.prototype.setCity=function(_37){
this.setProperty("AdminArea5",_37);
};
MQAddress.prototype.getPostalCode=function(){
return this.getProperty("PostalCode");
};
MQAddress.prototype.setPostalCode=function(_38){
this.setProperty("PostalCode",_38);
};
MQAddress.prototype.getState=function(){
return this.getProperty("AdminArea3");
};
MQAddress.prototype.setState=function(_39){
this.setProperty("AdminArea3",_39);
};
MQAddress.prototype.setStreet=function(_3a){
this.setProperty("Street",_3a);
};
MQAddress.prototype.getStreet=function(){
return this.getProperty("Street");
};
MQSingleLineAddress.prototype=new MQLocation();
MQSingleLineAddress.prototype.constructor=MQSingleLineAddress;
function MQSingleLineAddress(){
MQLocation.call(this);
this.setM_Xpath("SingleLineAddress");
if(this.getClassName()==="MQSingleLineAddress"){
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getSINGLELINEADDRESS()));
}
}
MQSingleLineAddress.prototype.getClassName=function(){
return "MQSingleLineAddress";
};
MQSingleLineAddress.prototype.getObjectVersion=function(){
return 0;
};
MQSingleLineAddress.prototype.loadXml=function(_3b){
this.setM_XmlDoc(MQA.createXMLDoc(_3b));
};
MQSingleLineAddress.prototype.saveXml=function(){
return mqXmlToStr(this.getM_XmlDoc());
};
MQSingleLineAddress.prototype.setAddress=function(_3c){
this.setProperty("Address",_3c);
};
MQSingleLineAddress.prototype.getAddress=function(){
return this.getProperty("Address");
};
MQSingleLineAddress.prototype.setCountry=function(_3d){
this.setProperty("Country",_3d);
};
MQSingleLineAddress.prototype.getCountry=function(){
return this.getProperty("Country");
};
MQGeoAddress.prototype=new MQAddress();
MQGeoAddress.prototype.constructor=MQGeoAddress;
function MQGeoAddress(){
MQAddress.call(this);
this.setM_Xpath("GeoAddress");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getGEOADDRESS()));
var _3e=new MQLatLng();
this.getMQLatLng=function(){
return _3e;
};
this.setMQLatLng=function(_3f){
_3e=_3f;
};
}
MQGeoAddress.prototype.getClassName=function(){
return "MQGeoAddress";
};
MQGeoAddress.prototype.getObjectVersion=function(){
return 0;
};
MQGeoAddress.prototype.loadXml=function(_40){
this.setM_XmlDoc(MQA.createXMLDoc(_40));
var lat=this.getProperty("LatLng/Lat");
var lng=this.getProperty("LatLng/Lng");
this.getMQLatLng().setLatLng(lat,lng);
};
MQGeoAddress.prototype.saveXml=function(){
var _43=MQA.createXMLDoc(this.getMQLatLng().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_43,"LatLng"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQGeoAddress.prototype.setDistAlong=function(_44){
this.setProperty("DistAlong",_44);
};
MQGeoAddress.prototype.getDistAlong=function(){
return this.getProperty("DistAlong");
};
MQGeoAddress.prototype.setGEFID=function(_45){
this.setProperty("GEFID",_45);
};
MQGeoAddress.prototype.getGEFID=function(){
return this.getProperty("GEFID");
};
MQGeoAddress.prototype.setResultCode=function(_46){
this.setProperty("ResultCode",_46);
};
MQGeoAddress.prototype.getResultCode=function(){
return this.getProperty("ResultCode");
};
MQGeoAddress.prototype.setSourceId=function(_47){
this.setProperty("SourceId",_47);
};
MQGeoAddress.prototype.getSourceId=function(){
return this.getProperty("SourceId");
};
MQManeuver.prototype=new MQObject();
MQManeuver.prototype.constructor=MQManeuver;
function MQManeuver(){
MQObject.call(this);
this.setM_Xpath("Maneuver");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getMANEUVER()));
var _48=new MQStringCollection("Item");
_48.setM_Xpath("Streets");
this.getStreets=function(){
return _48;
};
this.setStreets=function(_49){
_48.removeAll();
_48.append(_49);
};
var _4a=new MQLatLngCollection();
_4a.setM_Xpath("ShapePoints");
this.getShapePoints=function(){
return _4a;
};
this.setShapePoints=function(_4b){
if(_4b.getClassName()==="MQLatLngCollection"){
_4a.removeAll();
_4a.append(_4b);
}else{
alert("failure in setShapePoints");
throw "failure in setShapePoints";
}
};
var _4c=new MQIntCollection("Item");
_4c.setM_Xpath("GEFIDs");
this.getGEFIDs=function(){
return _4c;
};
this.setGEFIDs=function(_4d){
_4c.removeAll();
_4c.append(_4d);
};
var _4e=new MQSignCollection("Sign");
_4e.setM_Xpath("Signs");
this.getSigns=function(){
return _4e;
};
this.setSigns=function(_4f){
_4e.removeAll();
_4e.append(_4f);
};
}
MQManeuver.prototype.getClassName=function(){
return "MQManeuver";
};
MQManeuver.prototype.getObjectVersion=function(){
return 1;
};
MQManeuver.prototype.loadXml=function(_50){
this.setM_XmlDoc(MQA.createXMLDoc(_50));
var _51=this.getStreets();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Streets")!==null){
_51.loadXmlFromNode(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Streets"));
}
var _52=this.getShapePoints();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/ShapePoints")!==null){
_52.loadXmlFromNode(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/ShapePoints"));
}
var _53=this.getGEFIDs();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/GEFIDs")!==null){
_53.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/GEFIDs")));
}
var _54=this.getSigns();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Signs")!==null){
_54.loadXmlFromNode(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Signs"));
}
};
MQManeuver.prototype.saveXml=function(){
var _55=MQA.createXMLDoc(this.getStreets().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_55,"Streets"));
_55=MQA.createXMLDoc(this.getShapePoints().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_55,"ShapePoints"));
_55=MQA.createXMLDoc(this.getGEFIDs().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_55,"GEFIDs"));
_55=MQA.createXMLDoc(this.getSigns().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_55,"Signs"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQManeuver.prototype.setTurnType=function(_56){
this.setProperty("TurnType",_56);
};
MQManeuver.prototype.getTurnType=function(){
return this.getProperty("TurnType");
};
MQManeuver.prototype.setDistance=function(_57){
this.setProperty("Distance",_57);
};
MQManeuver.prototype.getDistance=function(){
return this.getProperty("Distance");
};
MQManeuver.prototype.setTime=function(_58){
this.setProperty("Time",_58);
};
MQManeuver.prototype.getTime=function(){
return this.getProperty("Time");
};
MQManeuver.prototype.setDirection=function(_59){
this.setProperty("Direction",_59);
};
MQManeuver.prototype.getDirection=function(){
return this.getProperty("Direction");
};
MQManeuver.prototype.getDirectionName=function(){
switch(parseInt(this.getDirection())){
case MQCONSTANT.MQMANEUVER_HEADING_NORTH:
return "North";
case MQCONSTANT.MQMANEUVER_HEADING_NORTH_WEST:
return "Northwest";
case MQCONSTANT.MQMANEUVER_HEADING_NORTH_EAST:
return "Northeast";
case MQCONSTANT.MQMANEUVER_HEADING_SOUTH:
return "South";
case MQCONSTANT.MQMANEUVER_HEADING_SOUTH_EAST:
return "Southeast";
case MQCONSTANT.MQMANEUVER_HEADING_SOUTH_WEST:
return "Southwest";
case MQCONSTANT.MQMANEUVER_HEADING_WEST:
return "West";
case MQCONSTANT.MQMANEUVER_HEADING_EAST:
return "East";
default:
return "";
}
};
MQManeuver.prototype.setAttributes=function(_5a){
this.setProperty("Attributes",_5a);
};
MQManeuver.prototype.getAttributes=function(){
return this.getProperty("Attributes");
};
MQManeuver.prototype.setNarrative=function(_5b){
this.setProperty("Narrative",_5b);
};
MQManeuver.prototype.getNarrative=function(){
return this.getProperty("Narrative");
};
MQTrekRoute.prototype=new MQObject();
MQTrekRoute.prototype.constructor=MQTrekRoute;
function MQTrekRoute(){
MQObject.call(this);
this.setM_Xpath("TrekRoute");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getTREKROUTE()));
var _5c=new MQManeuverCollection("Maneuver");
_5c.setM_Xpath("Maneuvers");
this.getManeuvers=function(){
return _5c;
};
var _5d=null;
this.getShapePoints=function(){
if(_5d===null){
_5e=0;
_5f=0;
_5d=new MQLatLngCollection();
_5d.setM_Xpath("ShapePoints");
for(var man=0;man<this.getManeuvers().getSize();man++){
_5d.append(this.getManeuvers().get(man).getShapePoints());
_5e+=parseFloat(this.getManeuvers().get(man).getDistance());
_5f+=parseInt(this.getManeuvers().get(man).getTime());
}
}
return _5d;
};
var _5e=null;
this.getDistance=function(){
if(_5e===null){
_5e=0;
_5f=0;
_5d=new MQLatLngCollection();
_5d.setM_Xpath("ShapePoints");
for(var man=0;man<this.getManeuvers().getSize();man++){
_5d.append(this.getManeuvers().get(man).getShapePoints());
_5e+=parseFloat(this.getManeuvers().get(man).getDistance());
_5f+=parseInt(this.getManeuvers().get(man).getTime());
}
}
return _5e;
};
var _5f=null;
this.getTime=function(){
if(_5f===null){
_5e=0;
_5f=0;
_5d=new MQLatLngCollection();
_5d.setM_Xpath("ShapePoints");
for(var man=0;man<this.getManeuvers().getSize();man++){
_5d.append(this.getManeuvers().get(man).getShapePoints());
_5e+=parseFloat(this.getManeuvers().get(man).getDistance());
_5f+=parseInt(this.getManeuvers().get(man).getTime());
}
}
return _5f;
};
}
MQTrekRoute.prototype.getClassName=function(){
return "MQTrekRoute";
};
MQTrekRoute.prototype.getObjectVersion=function(){
return 0;
};
MQTrekRoute.prototype.loadXml=function(_63){
this.setM_XmlDoc(MQA.createXMLDoc(_63));
var _64=this.getManeuvers();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Maneuvers")!==null){
_64.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Maneuvers")));
}
};
MQTrekRoute.prototype.saveXml=function(){
var _65=MQA.createXMLDoc(this.getManeuvers().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_65,"Maneuvers"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQGeocodeOptions.prototype=new MQObject();
MQGeocodeOptions.prototype.constructor=MQGeocodeOptions;
function MQGeocodeOptions(){
MQObject.call(this);
this.setM_Xpath("GeocodeOptions");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getGEOCODEOPTIONS()));
var _66=new MQMatchType(0);
this.getMatchType=function(){
return _66;
};
this.setMatchType=function(_67){
_66=_67;
};
var _68=new MQQualityType(0);
this.getQualityType=function(){
return _68;
};
this.setQualityType=function(_69){
_68=_69;
};
}
MQGeocodeOptions.prototype.getClassName=function(){
return "MQGeocodeOptions";
};
MQGeocodeOptions.prototype.getObjectVersion=function(){
return 0;
};
MQGeocodeOptions.prototype.loadXml=function(_6a){
this.setM_XmlDoc(MQA.createXMLDoc(_6a));
this.setMatchType(new MQMatchType(Math.floor(this.getProperty("MatchType"))));
this.getQualityType(new MQQualityType(Math.floor(this.getProperty("QualityType"))));
};
MQGeocodeOptions.prototype.saveXml=function(){
this.setProperty("MatchType",this.getMatchType().intValue());
this.setProperty("QualityType",this.getQualityType().intValue());
return mqXmlToStr(this.getM_XmlDoc());
};
MQGeocodeOptions.prototype.setCoverageName=function(_6b){
this.setProperty("CoverageName",_6b);
};
MQGeocodeOptions.prototype.getCoverageName=function(){
return this.getProperty("CoverageName");
};
MQGeocodeOptions.prototype.setMaxMatches=function(_6c){
this.setProperty("MaxMatches",_6c);
};
MQGeocodeOptions.prototype.getMaxMatches=function(){
return this.getProperty("MaxMatches");
};
MQRouteOptions.prototype=new MQObject();
MQRouteOptions.prototype.constructor=MQRouteOptions;
function MQRouteOptions(){
MQObject.call(this);
this.setM_Xpath("RouteOptions");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getROUTEOPTIONS()));
var _6d=new MQStringCollection();
_6d.setM_Xpath("AvoidAttributeList");
this.getAvoidAttrList=function(){
return _6d;
};
this.setAvoidAttrList=function(_6e){
_6d.removeAll();
_6d.append(_6e);
};
var _6f=new MQIntCollection();
_6f.setM_Xpath("AvoidGefIdList");
this.getAvoidGefIdList=function(){
return _6f;
};
this.setAvoidGefIdList=function(_70){
_6f.removeAll();
_6f.append(_70);
};
var _71=new MQIntCollection();
_71.setM_Xpath("AvoidAbsoluteGefIdList");
this.getAvoidAbsGefIdList=function(){
return _71;
};
this.setAvoidAbsGefIdList=function(_72){
_71.removeAll();
_71.append(_72);
};
var _73=new MQAutoRouteCovSwitch("CovSwitcher");
this.getAutoRouteCovSwitch=function(){
return _73;
};
this.setAutoRouteCovSwitch=function(_74){
_73=_74;
};
var _75=new MQRouteType(0);
this.getRouteType=function(){
return _75;
};
this.setRouteType=function(_76){
_75=_76;
};
var _77=new MQNarrativeType(0);
this.getNarrativeType=function(){
return _77;
};
this.setNarrativeType=function(_78){
_77=_78;
};
var _79=new MQDistanceUnits(0);
this.getDistanceUnits=function(){
return _79;
};
this.setDistanceUnits=function(_7a){
_79=_7a;
};
}
MQRouteOptions.prototype.getClassName=function(){
return "MQRouteOptions";
};
MQRouteOptions.prototype.getObjectVersion=function(){
return 3;
};
MQRouteOptions.prototype.loadXml=function(_7b){
this.setM_XmlDoc(MQA.createXMLDoc(_7b));
var _7c=this.getAvoidAttrList();
_7c.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/AvoidAttributeList")));
var _7d=this.getAvoidGefIdList();
_7d.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/AvoidGefIdList")));
var _7e=this.getAvoidAbsGefIdList();
_7e.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/AvoidAbsoluteGefIdList")));
var _7f=this.getAutoRouteCovSwitch();
_7f.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CovSwitcher")));
this.setRouteType(new MQRouteType(Math.floor(this.getProperty("RouteType"))));
this.getNarrativeType(new MQNarrativeType(Math.floor(this.getProperty("NarrativeType"))));
this.getDistanceUnits(new MQDistanceUnits(Math.floor(this.getProperty("NarrativeDistanceUnitType"))));
};
MQRouteOptions.prototype.saveXml=function(){
var _80=null;
this.setProperty("RouteType",this.getRouteType().intValue());
this.setProperty("NarrativeType",this.getNarrativeType().intValue());
this.setProperty("NarrativeDistanceUnitType",this.getDistanceUnits().getValue());
_80=MQA.createXMLDoc(this.getAutoRouteCovSwitch().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_80,"CovSwitcher"));
_80=MQA.createXMLDoc(this.getAvoidAttrList().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_80,"AvoidAttributeList"));
_80=MQA.createXMLDoc(this.getAvoidGefIdList().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_80,"AvoidGefIdList"));
_80=MQA.createXMLDoc(this.getAvoidAbsGefIdList().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_80,"AvoidAbsoluteGefIdList"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQRouteOptions.prototype.setMaxShapePointsPerManeuver=function(_81){
this.setProperty("MaxShape",_81);
};
MQRouteOptions.prototype.getMaxShapePointsPerManeuver=function(){
return this.getProperty("MaxShape");
};
MQRouteOptions.prototype.setMaxGEFIDsPerManeuver=function(_82){
this.setProperty("MaxGEFID",_82);
};
MQRouteOptions.prototype.getMaxGEFIDsPerManeuver=function(){
return this.getProperty("MaxGEFID");
};
MQRouteOptions.prototype.setLanguage=function(_83){
this.setProperty("Language",_83);
};
MQRouteOptions.prototype.getLanguage=function(){
return this.getProperty("Language");
};
MQRouteOptions.prototype.setCoverageName=function(_84){
this.setProperty("CoverageName",_84);
};
MQRouteOptions.prototype.getCoverageName=function(){
return this.getProperty("CoverageName");
};
MQRouteOptions.prototype.setStateBoundaryDisplay=function(_85){
this.setProperty("StateBoundaryDisplay",(_85===true)?1:0);
};
MQRouteOptions.prototype.getStateBoundaryDisplay=function(){
return (this.getProperty("StateBoundaryDisplay")==1)?true:false;
};
MQRouteOptions.prototype.setCountryBoundaryDisplay=function(_86){
this.setProperty("CountryBoundaryDisplay",(_86===true)?1:0);
};
MQRouteOptions.prototype.getCountryBoundaryDisplay=function(){
return (this.getProperty("CountryBoundaryDisplay")==1)?true:false;
};
MQRouteResults.prototype=new MQObject();
MQRouteResults.prototype.constructor=MQRouteResults;
function MQRouteResults(){
MQObject.call(this);
this.setM_Xpath("RouteResults");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getROUTERESULTS()));
var _87=new MQLocationCollection();
_87.setM_Xpath("Locations");
this.getLocations=function(){
return _87;
};
var _88=new MQTrekRouteCollection("TrekRoute");
_88.setM_Xpath("TrekRoutes");
this.getTrekRoutes=function(){
return _88;
};
var _89=new MQRouteResultsCode(MQCONSTANT.MQROUTERESULTSCODE_NOT_SPECIFIED);
this.getResultCode=function(){
return _89;
};
this.setResultCode=function(_8a){
_89=_8a;
};
var _8b=new MQStringCollection("Item");
_8b.setM_Xpath("ResultMessages");
this.getResultMessages=function(){
return _8b;
};
var _8c=null;
this.getShapePoints=function(){
if(_8c===null){
_8d=0;
_8e=0;
_8c=new MQLatLngCollection();
_8c.setM_Xpath("ShapePoints");
for(var tr=0;tr<this.getTrekRoutes().getSize();tr++){
var _90=this.getTrekRoutes().get(tr);
for(var man=0;man<_90.getManeuvers().getSize();man++){
_8c.append(_90.getManeuvers().get(man).getShapePoints());
_8d+=parseFloat(_90.getManeuvers().get(man).getDistance());
_8e+=parseInt(_90.getManeuvers().get(man).getTime());
}
}
}
return _8c;
};
var _8d=-1;
this.getDistance=function(){
if(_8d===-1){
_8d=0;
_8e=0;
_8c=new MQLatLngCollection();
_8c.setM_Xpath("ShapePoints");
for(var tr=0;tr<this.getTrekRoutes().getSize();tr++){
var _93=this.getTrekRoutes().get(tr);
for(var man=0;man<_93.getManeuvers().getSize();man++){
_8c.append(_93.getManeuvers().get(man).getShapePoints());
_8d+=parseFloat(_93.getManeuvers().get(man).getDistance());
_8e+=parseInt(_93.getManeuvers().get(man).getTime());
}
}
}
return _8d;
};
var _8e=-1;
this.getTime=function(){
if(_8e===-1){
_8d=0;
_8e=0;
_8c=new MQLatLngCollection();
_8c.setM_Xpath("ShapePoints");
for(var tr=0;tr<this.getTrekRoutes().getSize();tr++){
var _96=this.getTrekRoutes().get(tr);
for(var man=0;man<_96.getManeuvers().getSize();man++){
_8c.append(_96.getManeuvers().get(man).getShapePoints());
_8d+=parseFloat(_96.getManeuvers().get(man).getDistance());
_8e+=parseInt(_96.getManeuvers().get(man).getTime());
}
}
}
return _8e;
};
}
MQRouteResults.prototype.getClassName=function(){
return "MQRouteResults";
};
MQRouteResults.prototype.getObjectVersion=function(){
return 1;
};
MQRouteResults.prototype.loadXml=function(_98){
this.setM_XmlDoc(MQA.createXMLDoc(_98));
var _99=this.getLocations();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Locations")!==null){
_99.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Locations")));
}
var _9a=this.getTrekRoutes();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/TrekRoutes")!==null){
_9a.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/TrekRoutes")));
}
var _9b=this.getResultMessages();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/ResultMessages")!==null){
_9b.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/ResultMessages")));
}
this.setResultCode(new MQRouteResultsCode(Math.floor(this.getProperty("ResultCode"))));
};
MQRouteResults.prototype.saveXml=function(){
this.setProperty("ResultCode",this.getResultCode().intValue());
return mqXmlToStr(this.getM_XmlDoc());
};
MQRouteResults.prototype.setCoverageName=function(_9c){
this.setProperty("CoverageName",_9c);
};
MQRouteResults.prototype.getCoverageName=function(){
return this.getProperty("CoverageName");
};
MQRouteMatrixResults.prototype=new MQObject();
MQRouteMatrixResults.prototype.constructor=MQRouteMatrixResults;
function MQRouteMatrixResults(){
MQObject.call(this);
this.setM_Xpath("RouteMatrixResults");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getROUTEMATRIXRESULTS()));
var _9d=-1;
var _9e=null;
this.setDistance=function(col){
if(col){
if(col.getClassName()==="MQIntCollection"){
if(_9e!==null){
_9e.removeAll();
_9e.append(col);
}else{
_9e=col;
}
}else{
alert("failure in setDistance -- col is not MQIntCollection type");
throw "failure in setDistance -- col is not MQIntCollection type";
}
}else{
alert("failure in setDistance -- col is null");
throw "failure in setDistance -- col is null";
}
};
this.getDistance=function(_a0,to){
if(_9d===-1){
_9d=this.getProperty("LocationCount");
}
var pos=((_a0*_9d)+to);
return (_9e.get(pos)/1000).toFixed(6);
};
var _a3=null;
this.setTime=function(col){
if(col){
if(col.getClassName()==="MQIntCollection"){
if(_a3!==null){
_a3.removeAll();
_a3.append(col);
}else{
_a3=col;
}
}else{
alert("failure in setTime -- col is not MQIntCollection type");
throw "failure in setTime -- col is not MQIntCollection type";
}
}else{
alert("failure in setTime -- col is null");
throw "failure in setTime -- col is null";
}
};
this.getTime=function(_a5,to){
if(_9d===-1){
_9d=this.getProperty("LocationCount");
}
var pos=((_a5*_9d)+to);
return _a3.get(pos);
};
var _a8=new MQRouteMatrixResultsCode(MQCONSTANT.MQROUTEMATRIXRESULTSCODE_NOT_SPECIFIED);
this.getResultCode=function(){
return _a8;
};
this.setResultCode=function(rc){
if(rc){
if(rc.getClassName()==="MQRouteMatrixResultsCode"){
_a8=rc;
}else{
alert("failure in setResultsCode -- rc is not MQRouteMatrixResultsCode type");
throw "failure in setResultsCode -- rc is not MQRouteMatrixResultsCode type";
}
}else{
alert("failure in setResultsCode -- rc is null");
throw "failure in setResultsCode -- rc is null";
}
};
var _aa=null;
this.setResultMessages=function(col){
if(col){
if(col.getClassName()==="MQStringCollection"){
if(_aa!==null){
_aa.removeAll();
_aa.append(col);
}else{
_aa=col;
}
}else{
alert("failure in setResultMessages -- col is not MQStringCollection type");
throw "failure in setResultMessages -- col is not MQStringCollection type";
}
}else{
alert("failure in setResultMessages -- col is null");
throw "failure in setResultMessages -- col is null";
}
};
this.getResultsMessages=function(){
return _aa;
};
}
MQRouteMatrixResults.prototype.getClassName=function(){
return "MQRouteMatrixResults";
};
MQRouteMatrixResults.prototype.getObjectVersion=function(){
return 0;
};
MQRouteMatrixResults.prototype.loadXml=function(_ac){
this.setM_XmlDoc(MQA.createXMLDoc(_ac));
var dis=new MQIntCollection();
dis.setM_Xpath("DistanceMatrix");
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DistanceMatrix")!==null){
dis.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DistanceMatrix")));
}
this.setDistance(dis);
var tim=new MQIntCollection();
tim.setM_Xpath("TimeMatrix");
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/TimeMatrix")!==null){
tim.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/TimeMatrix")));
}
this.setTime(tim);
var mes=new MQStringCollection();
mes.setM_Xpath("ResultMessages");
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/ResultMessages")!==null){
mes.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/ResultMessages")));
}
this.setResultMessages(mes);
this.setResultCode(new MQRouteMatrixResultsCode(Math.floor(this.getProperty("ResultCode"))));
};
MQRouteMatrixResults.prototype.saveXml=function(){
this.setProperty("ResultCode",this.getResultCode().intValue());
return mqXmlToStr(this.getM_XmlDoc());
};
MQRouteMatrixResults.prototype.setCoverageName=function(_b0){
this.setProperty("CoverageName",_b0);
};
MQRouteMatrixResults.prototype.getCoverageName=function(){
return this.getProperty("CoverageName");
};
MQRouteMatrixResults.prototype.getAllToAllFlag=function(){
return (this.getProperty("AllToAll")==1)?true:false;
};
MQRecordSet.prototype=new MQObject();
MQRecordSet.prototype.constructor=MQRecordSet;
function MQRecordSet(){
MQObject.call(this);
this.setM_Xpath("RecordSet");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getRECORDSET()));
var _b1=true;
var _b2=true;
var _b3=0;
var _b4=-1;
var _b5=new MQStringCollection();
_b5.setM_Xpath("Fields");
var _b6=new MQStrColCollection("Record");
_b6.setM_Xpath("Records");
_b6.setValidClassName("MQStringCollection");
this.moveFirst=function(){
if(_b6.getSize()!==0){
_b1=false;
_b2=false;
_b4=0;
}else{
alert(MQERROR.RECORDSET_MOVEFIRST_1);
throw MQERROR.RECORDSET_MOVEFIRST_1;
}
};
this.moveLast=function(){
if(_b6.getSize()!==0){
_b1=false;
_b2=false;
_b4=_b6.getSize()-1;
}else{
alert(MQERROR.RECORDSET_MOVELAST_1);
throw MQERROR.RECORDSET_MOVELAST_1;
}
};
this.moveNext=function(){
var _b7=_b6.getSize();
if(_b7!==0){
if(_b4<_b7-1){
_b4++;
_b2=false;
_b1=false;
}else{
if(_b4===_b7-1){
_b4++;
_b2=false;
_b1=true;
}else{
if(_b1){
alert(MQERROR.RECORDSET_MOVENEXT_1);
throw MQERROR.RECORDSET_MOVENEXT_1;
}else{
alert(MQERROR.RECORDSET_MOVENEXT_2);
throw MQERROR.RECORDSET_MOVENEXT_2;
}
}
}
}else{
alert(MQERROR.RECORDSET_MOVENEXT_3);
throw MQERROR.RECORDSET_MOVENEXT_3;
}
};
this.isBOF=function(){
return _b2;
};
this.isEOF=function(){
return _b1;
};
this.getFieldNames=function(){
return _b5;
};
this.getField=function(_b8){
if(!(0<=_b4&&_b4<_b3)){
alert(MQERROR.RECORDSET_GETFIELD_1);
throw MQERROR.RECORDSET_GETFIELD_1;
}
var pos=-1;
for(var i=0;i<_b5.getSize();i++){
if(_b5.get(i)===_b8){
pos=i;
break;
}
}
if(pos===-1){
alert(MQERROR.RECORDSET_GETFIELD_2);
throw MQERROR.RECORDSET_GETFIELD_2;
}
return _b6.get(_b4).get(pos);
};
this.loadXml=function(_bb){
var _bc=MQA.createXMLDoc(_bb);
this.setM_XmlDoc(_bc);
_b5.loadXml(mqXmlToStr(mqGetNode(_bc,"/"+this.getM_Xpath()+"/Fields")));
if(_bc!==null){
var _bd=_bc.documentElement;
var _be=_bd.childNodes;
var _bf=_be.length;
_bf=(_bf<32678)?_bf:32678;
var _c0=0;
var col=null;
_b6.removeAll();
for(var _c2=_c0;_c2<_bf;_c2++){
if(_be[_c2].nodeName==="Record"){
col=new MQStringCollection();
col.setM_Xpath("Record");
col.loadXml(mqXmlToStr(_be[_c2]));
_b6.add(col);
}
}
}
_b3=this.getProperty("RecordCount");
if(_b3>0){
_b4=0;
_b2=false;
_b1=false;
}
};
}
MQRecordSet.prototype.getClassName=function(){
return "MQRecordSet";
};
MQRecordSet.prototype.getObjectVersion=function(){
return 0;
};
MQRecordSet.prototype.saveXml=function(){
return mqXmlToStr(this.getM_XmlDoc());
};
MQMapState.prototype=new MQObject();
MQMapState.prototype.constructor=MQMapState;
function MQMapState(){
MQObject.call(this);
this.setM_Xpath("MapState");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getMAPSTATE()));
var _c3=new MQLatLng("Center");
this.getCenter=function(){
return _c3;
};
this.setCenter=function(_c4){
_c3.setLatLng(_c4.getLatitude(),_c4.getLongitude());
};
}
MQMapState.prototype.getClassName=function(){
return "MQMapState";
};
MQMapState.prototype.getObjectVersion=function(){
return 0;
};
MQMapState.prototype.initObject=function(){
this.setProperty("Scale",0);
this.setCenter(new MQLatLng(0,0));
this.setProperty("Width",-1);
this.setProperty("Height",-1);
this.setProperty("MapName","");
this.setProperty("CoverageName","");
};
MQMapState.prototype.equals=function(_c5){
if(_c5){
try{
if(_c5.getClassName()==="MQMapState"){
return m_nScale==other.m_nScale&&m_strMapName===other.m_strMapName&&m_strCoverageName===other.m_strCoverageName&&m_llCenter.equals(other.m_llCenter)&&m_dMapWidth===other.m_dMapWidth&&m_dMapHeight===other.m_dMapHeight;
}
}
catch(error){
}
}
return false;
};
MQMapState.prototype.setMapName=function(_c6){
this.setProperty("MapName",_c6);
};
MQMapState.prototype.getMapName=function(){
this.getProperty("MapName");
};
MQMapState.prototype.setCoverageName=function(_c7){
this.setProperty("CoverageName",_c7);
};
MQMapState.prototype.getCoverageName=function(){
this.getProperty("CoverageName");
};
MQMapState.prototype.setWidthInches=function(_c8){
this.setProperty("Width",_c8);
};
MQMapState.prototype.getWidthInches=function(){
return this.getProperty("Width");
};
MQMapState.prototype.setHeightInches=function(_c9){
this.setProperty("Height",_c9);
};
MQMapState.prototype.getHeightInches=function(){
return this.getProperty("Height");
};
MQMapState.prototype.setWidthPixels=function(_ca,dpi){
if(dpi){
this.setProperty("Width",parseFloat(_ca)/parseFloat(dpi));
}else{
this.setProperty("Width",parseFloat(_ca)/parseFloat(72));
}
};
MQMapState.prototype.getWidthPixels=function(dpi){
if(dpi){
return Math.ceil(this.getProperty("Width")*dpi);
}else{
return Math.ceil(this.getProperty("Width")*72);
}
};
MQMapState.prototype.setHeightPixels=function(_cd,dpi){
if(dpi){
this.setProperty("Height",parseFloat(_cd)/parseFloat(dpi));
}else{
this.setProperty("Height",parseFloat(_cd)/parseFloat(72));
}
};
MQMapState.prototype.getHeightPixels=function(dpi){
if(dpi){
return Math.ceil(this.getProperty("Height")*dpi);
}else{
return Math.ceil(this.getProperty("Height")*72);
}
};
MQMapState.prototype.setMapScale=function(_d0){
this.setProperty("Scale",_d0);
};
MQMapState.prototype.getMapScale=function(){
return this.getProperty("Scale");
};
MQMapState.prototype.loadXml=function(_d1){
this.setM_XmlDoc(MQA.createXMLDoc(_d1));
var lat=this.getProperty("Center/Lat");
var lng=this.getProperty("Center/Lng");
this.getCenter().setLatLng(lat,lng);
};
MQMapState.prototype.saveXml=function(){
var _d4=MQA.createXMLDoc(this.getCenter().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_d4,"Center"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQSearchCriteria.prototype=new MQObject();
MQSearchCriteria.prototype.constructor=MQSearchCriteria;
function MQSearchCriteria(){
MQObject.call(this);
}
MQSearchCriteria.prototype.getClassName=function(){
return "MQSearchCriteria";
};
MQSearchCriteria.prototype.getObjectVersion=function(){
return 0;
};
MQSearchCriteria.prototype.setMaxMatches=function(_d5){
this.setProperty("MaxMatches",_d5);
};
MQSearchCriteria.prototype.getMaxMatches=function(){
return this.getProperty("MaxMatches");
};
MQRadiusSearchCriteria.prototype=new MQSearchCriteria();
MQRadiusSearchCriteria.prototype.constructor=MQRadiusSearchCriteria;
function MQRadiusSearchCriteria(){
MQObject.call(this);
this.setM_Xpath("RadiusSearchCriteria");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getRADIUSSEARCHCRITERIA()));
var _d6=new MQLatLng("CenterLatLng");
this.getCenter=function(){
return _d6;
};
this.setCenter=function(_d7){
_d6.setLatLng(_d7.getLatitude(),_d7.getLongitude());
};
}
MQRadiusSearchCriteria.prototype.getClassName=function(){
return "MQRadiusSearchCriteria";
};
MQRadiusSearchCriteria.prototype.getObjectVersion=function(){
return 0;
};
MQRadiusSearchCriteria.prototype.loadXml=function(_d8){
this.setM_XmlDoc(MQA.createXMLDoc(_d8));
var lat=this.getProperty("CenterLatLng/Lat");
var lng=this.getProperty("CenterLatLng/Lng");
this.getCenter().setLatLng(lat,lng);
};
MQRadiusSearchCriteria.prototype.saveXml=function(){
var _db=MQA.createXMLDoc(this.getCenter().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_db,"CenterLatLng"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQRadiusSearchCriteria.prototype.setRadius=function(_dc,_dd){
if(_dd){
mqIsClass("MQDistanceUnits",_dd,false);
}else{
_dd=new MQDistanceUnits(MQCONSTANT.MQDISTANCEUNITS_MILES);
}
if(_dd.getValue()===MQCONSTANT.MQDISTANCEUNITS_KILOMETERS){
_dc=_dc/MQCONSTANT.DISTANCEAPPROX_KILOMETERS_PER_MILE;
}
this.setProperty("Radius",_dc);
};
MQRadiusSearchCriteria.prototype.getRadius=function(_de){
if(_de){
mqIsClass("MQDistanceUnits",_de,false);
}else{
_de=new MQDistanceUnits(MQCONSTANT.MQDISTANCEUNITS_MILES);
}
var _df=this.getProperty("Radius");
if(_de.getValue()===MQCONSTANT.MQDISTANCEUNITS_KILOMETERS){
_df=_df*MQCONSTANT.DISTANCEAPPROX_KILOMETERS_PER_MILE;
}
return _df;
};
MQRectSearchCriteria.prototype=new MQSearchCriteria();
MQRectSearchCriteria.prototype.constructor=MQRectSearchCriteria;
function MQRectSearchCriteria(_e0){
MQObject.call(this);
this.setM_Xpath("RectSearchCriteria");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getRECTSEARCHCRITERIA()));
var _e1=new MQLatLng("UpperLeftLatLng");
this.getUpperLeft=function(){
return _e1;
};
this.setUpperLeft=function(_e2){
_e1.setLatLng(_e2.getLatitude(),_e2.getLongitude());
};
var _e3=new MQLatLng("LowerRightLatLng");
this.getLowerRight=function(){
return _e3;
};
this.setLowerRight=function(_e4){
_e3.setLatLng(_e4.getLatitude(),_e4.getLongitude());
};
if(_e0){
_e1.setLatLng(_e0.getUpperLeft().getLat(),_e0.getUpperLeft().getLng());
_e3.setLatLng(_e0.getLowerRight().getLat(),_e0.getLowerRight().getLng());
}
}
MQRectSearchCriteria.prototype.getClassName=function(){
return "MQRectSearchCriteria";
};
MQRectSearchCriteria.prototype.getObjectVersion=function(){
return 0;
};
MQRectSearchCriteria.prototype.loadXml=function(_e5){
this.setM_XmlDoc(MQA.createXMLDoc(_e5));
var lat=this.getProperty("UpperLeftLatLng/Lat");
var lng=this.getProperty("UpperLeftLatLng/Lng");
this.getUpperLeft().setLatLng(lat,lng);
lat=this.getProperty("LowerRightLatLng/Lat");
lng=this.getProperty("LowerRightLatLng/Lng");
this.getLowerRight().setLatLng(lat,lng);
};
MQRectSearchCriteria.prototype.saveXml=function(){
var _e8=MQA.createXMLDoc(this.getUpperLeft().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_e8,"UpperLeftLatLng"));
_e8=MQA.createXMLDoc(this.getLowerRight().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_e8,"LowerRightLatLng"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQPolySearchCriteria.prototype=new MQSearchCriteria();
MQPolySearchCriteria.prototype.constructor=MQPolySearchCriteria;
function MQPolySearchCriteria(){
MQObject.call(this);
this.setM_Xpath("PolySearchCriteria");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getPOLYSEARCHCRITERIA()));
var _e9=new MQLatLngCollection();
_e9.setM_Xpath("LatLngs");
this.getShapePoints=function(){
return _e9;
};
this.setShapePoints=function(_ea){
if(_ea.getClassName()==="MQLatLngCollection"){
_e9.removeAll();
_e9.append(_ea);
}else{
alert("failure in setShapePoints");
throw "failure in setShapePoints";
}
};
}
MQPolySearchCriteria.prototype.getClassName=function(){
return "MQPolySearchCriteria";
};
MQPolySearchCriteria.prototype.getObjectVersion=function(){
return 0;
};
MQPolySearchCriteria.prototype.loadXml=function(_eb){
this.setM_XmlDoc(MQA.createXMLDoc(_eb));
var _ec=this.getShapePoints();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")!==null){
_ec.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")));
}
};
MQPolySearchCriteria.prototype.saveXml=function(){
var _ed=MQA.createXMLDoc(this.getShapePoints().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_ed,"LatLngs"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQCorridorSearchCriteria.prototype=new MQPolySearchCriteria();
MQCorridorSearchCriteria.prototype.constructor=MQCorridorSearchCriteria;
function MQCorridorSearchCriteria(){
MQPolySearchCriteria.call(this);
this.setM_Xpath("CorridorSearchCriteria");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getCORRIDORSEARCHCRITERIA()));
}
MQCorridorSearchCriteria.prototype.getClassName=function(){
return "MQCorridorSearchCriteria";
};
MQCorridorSearchCriteria.prototype.getObjectVersion=function(){
return 0;
};
MQCorridorSearchCriteria.prototype.setCorrExactLinks=function(_ee){
this.setProperty("ExactLinks",(_ee===true)?1:0);
};
MQCorridorSearchCriteria.prototype.getCorrExactLinks=function(){
return (this.getProperty("ExactLinks")==1)?true:false;
};
MQCorridorSearchCriteria.prototype.setCorridorWidth=function(_ef,_f0){
if(_f0){
mqIsClass("MQDistanceUnits",_f0,false);
}else{
_f0=new MQDistanceUnits(MQCONSTANT.MQDISTANCEUNITS_MILES);
}
if(_f0.getValue()===MQCONSTANT.MQDISTANCEUNITS_KILOMETERS){
_ef=_ef/MQCONSTANT.DISTANCEAPPROX_KILOMETERS_PER_MILE;
}
this.setProperty("CorridorWidth",_ef);
};
MQCorridorSearchCriteria.prototype.getCorridorWidth=function(_f1){
if(_f1){
mqIsClass("MQDistanceUnits",_f1,false);
}else{
_f1=new MQDistanceUnits(MQCONSTANT.MQDISTANCEUNITS_MILES);
}
var _f2=this.getProperty("CorridorWidth");
if(_f1.getValue()===MQCONSTANT.MQDISTANCEUNITS_KILOMETERS){
_f2=_f2*MQCONSTANT.DISTANCEAPPROX_KILOMETERS_PER_MILE;
}
return _f2;
};
MQCorridorSearchCriteria.prototype.setCorridorBufferWidth=function(_f3,_f4){
if(_f4){
mqIsClass("MQDistanceUnits",_f4,false);
}else{
_f4=new MQDistanceUnits(MQCONSTANT.MQDISTANCEUNITS_MILES);
}
if(_f4.getValue()===MQCONSTANT.MQDISTANCEUNITS_KILOMETERS){
_f3=_f3/MQCONSTANT.DISTANCEAPPROX_KILOMETERS_PER_MILE;
}
this.setProperty("CorridorBufferWidth",_f3);
};
MQCorridorSearchCriteria.prototype.getCorridorBufferWidth=function(_f5){
if(_f5){
mqIsClass("MQDistanceUnits",_f5,false);
}else{
_f5=new MQDistanceUnits(MQCONSTANT.MQDISTANCEUNITS_MILES);
}
var _f6=this.getProperty("CorridorBufferWidth");
if(_f5.getValue()===MQCONSTANT.MQDISTANCEUNITS_KILOMETERS){
_f6=_f6*MQCONSTANT.DISTANCEAPPROX_KILOMETERS_PER_MILE;
}
return _f6;
};
MQDBLayerQuery.prototype=new MQObject();
MQDBLayerQuery.prototype.constructor=MQDBLayerQuery;
function MQDBLayerQuery(){
MQObject.call(this);
this.setM_Xpath("DBLayerQuery");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getDBLAYERQUERY()));
}
MQDBLayerQuery.prototype.getClassName=function(){
return "MQDBLayerQuery";
};
MQDBLayerQuery.prototype.getObjectVersion=function(){
return 0;
};
MQDBLayerQuery.prototype.loadXml=function(_f7){
this.setM_XmlDoc(MQA.createXMLDoc(_f7));
};
MQDBLayerQuery.prototype.saveXml=function(){
return mqXmlToStr(this.getM_XmlDoc());
};
MQDBLayerQuery.prototype.setDBLayerName=function(_f8){
this.setProperty("LayerName",_f8);
};
MQDBLayerQuery.prototype.getDBLayerName=function(){
return this.getProperty("LayerName");
};
MQDBLayerQuery.prototype.setExtraCriteria=function(_f9){
this.setProperty("ExtraCriteria",_f9);
};
MQDBLayerQuery.prototype.getExtraCriteria=function(){
return this.getProperty("ExtraCriteria");
};
MQPrimitive.prototype=new MQObject();
MQPrimitive.prototype.constructor=MQPrimitive;
function MQPrimitive(){
MQObject.call(this);
var _fa=new MQDrawTrigger(MQCONSTANT.MQDRAWTRIGGER_AFTER_TEXT);
this.getDrawTrigger=function(){
return _fa;
};
this.setDrawTrigger=function(dt){
if(dt){
if(dt.getClassName()==="MQDrawTrigger"){
_fa=dt;
}
}
};
var _fc=new MQCoordinateType(MQCONSTANT.MQCOORDINATETYPE_GEOGRAPHIC);
this.getCoordinateType=function(){
return _fc;
};
this.setCoordinateType=function(dt){
if(dt){
if(dt.getClassName()==="MQCoordinateType"){
_fc=dt;
}
}
};
}
MQPrimitive.prototype.getClassName=function(){
return "MQPrimitive";
};
MQPrimitive.prototype.getObjectVersion=function(){
return 2;
};
MQPrimitive.prototype.setKey=function(_fe){
this.setProperty("Key",_fe);
};
MQPrimitive.prototype.getKey=function(){
return this.getProperty("Key");
};
MQPrimitive.prototype.setOpacity=function(_ff){
this.setProperty("Opacity",_ff);
};
MQPrimitive.prototype.getOpacity=function(){
return this.getProperty("Opacity");
};
MQLinePrimitive.prototype=new MQPrimitive();
MQLinePrimitive.prototype.constructor=MQLinePrimitive;
function MQLinePrimitive(){
MQPrimitive.call(this);
this.setM_Xpath("LinePrimitive");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getLINEPRIMITIVE()));
var _100=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_BLACK);
this.getColor=function(){
return _100;
};
this.setColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_100=obj;
}
}
};
var _102=new MQPenStyle(MQCONSTANT.MQPENSTYLE_SOLID);
this.getStyle=function(){
return _102;
};
this.setStyle=function(obj){
if(obj){
if(obj.getClassName()==="MQPenStyle"){
_102=obj;
}
}
};
var _104=new MQPointCollection();
_104.setM_Xpath("Points");
this.getPoints=function(){
return _104;
};
var _105=new MQLatLngCollection();
_105.setM_Xpath("LatLngs");
this.getLatLngs=function(){
return _105;
};
this.setLatLngs=function(obj){
if(obj){
if(obj.getClassName()==="MQLatLngCollection"){
_105.removeAll();
_105.append(obj);
}
}
};
}
MQLinePrimitive.prototype.getClassName=function(){
return "MQLinePrimitive";
};
MQLinePrimitive.prototype.getObjectVersion=function(){
return 0;
};
MQLinePrimitive.prototype.loadXml=function(_107){
this.setM_XmlDoc(MQA.createXMLDoc(_107));
var ll=new MQLatLngCollection();
ll.setM_Xpath("LatLngs");
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")!==null){
ll.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")));
}
this.setLatLngs(ll);
var pt=new MQPointCollection();
pt.setM_Xpath("Points");
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Points")!==null){
pt.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Points")));
}
this.setPoints(ll);
this.setDrawTrigger(new MQDrawTrigger(Math.floor(this.getProperty("DrawTrigger"))));
this.setCoordinateType(new MQCoordinateType(Math.floor(this.getProperty("CoordinateType"))));
this.setColor(new MQColorStyle(Math.floor(this.getProperty("Color"))));
this.setStyle(new MQPenStyle(Math.floor(this.getProperty("Style"))));
};
MQLinePrimitive.prototype.saveXml=function(){
var _10a=MQA.createXMLDoc(this.getLatLngs().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_10a,"LatLngs"));
_10a=MQA.createXMLDoc(this.getPoints().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_10a,"Points"));
this.setProperty("DrawTrigger",this.getDrawTrigger().intValue());
this.setProperty("CoordinateType",this.getCoordinateType().intValue());
this.setProperty("Color",this.getColor().intValue());
this.setProperty("Style",this.getStyle().intValue());
return mqXmlToStr(this.getM_XmlDoc());
};
MQLinePrimitive.prototype.setWidth=function(_10b){
this.setProperty("Width",_10b);
};
MQLinePrimitive.prototype.getWidth=function(){
return this.getProperty("Width");
};
MQPolygonPrimitive.prototype=new MQLinePrimitive();
MQPolygonPrimitive.prototype.constructor=MQPolygonPrimitive;
function MQPolygonPrimitive(){
MQLinePrimitive.call(this);
this.setM_Xpath("LinePrimitive");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getPOLYGONPRIMITIVE()));
var _10c=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_RED);
this.getFillColor=function(){
return _10c;
};
this.setFillColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_10c=obj;
}
}
};
var _10e=new MQFillStyle(MQCONSTANT.MQFILLSTYLE_SOLID);
this.getFillStyle=function(){
return _10e;
};
this.setFillStyle=function(obj){
if(obj){
if(obj.getClassName()==="MQFillStyle"){
_10e=obj;
}
}
};
}
MQPolygonPrimitive.prototype.getClassName=function(){
return "MQPolygonPrimitive";
};
MQPolygonPrimitive.prototype.getObjectVersion=function(){
return 0;
};
MQPolygonPrimitive.prototype.loadXml=function(_110){
this.setM_XmlDoc(MQA.createXMLDoc(_110));
var ll=new MQLatLngCollection();
ll.setM_Xpath("LatLngs");
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")!==null){
ll.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")));
}
this.setLatLngs(ll);
var pt=new MQPointCollection();
pt.setM_Xpath("Points");
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Points")!==null){
pt.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/Points")));
}
this.setPoints(ll);
this.setDrawTrigger(new MQDrawTrigger(Math.floor(this.getProperty("DrawTrigger"))));
this.setCoordinateType(new MQCoordinateType(Math.floor(this.getProperty("CoordinateType"))));
this.setColor(new MQColorStyle(Math.floor(this.getProperty("Color"))));
this.setStyle(new MQPenStyle(Math.floor(this.getProperty("Style"))));
this.setFillColor(new MQColorStyle(Math.floor(this.getProperty("FillColor"))));
this.setFillStyle(new MQFillStyle(Math.floor(this.getProperty("FillStyle"))));
};
MQPolygonPrimitive.prototype.saveXml=function(){
var _113=MQA.createXMLDoc(this.getLatLngs().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_113,"LatLngs"));
_113=MQA.createXMLDoc(this.getPoints().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_113,"Points"));
this.setProperty("DrawTrigger",this.getDrawTrigger().intValue());
this.setProperty("CoordinateType",this.getCoordinateType().intValue());
this.setProperty("Color",this.getColor().intValue());
this.setProperty("Style",this.getStyle().intValue());
this.setProperty("FillColor",this.getFillColor().intValue());
this.setProperty("FillStyle",this.getFillStyle().intValue());
return mqXmlToStr(this.getM_XmlDoc());
};
MQRectanglePrimitive.prototype=new MQPrimitive();
MQRectanglePrimitive.prototype.constructor=MQRectanglePrimitive;
function MQRectanglePrimitive(){
MQPrimitive.call(this);
this.setM_Xpath("RectanglePrimitive");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getRECTANGLEPRIMITIVE()));
var _114=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_BLACK);
this.getColor=function(){
return _114;
};
this.setColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_114=obj;
}
}
};
var _116=new MQPenStyle(MQCONSTANT.MQPENSTYLE_SOLID);
this.getStyle=function(){
return _116;
};
this.setStyle=function(obj){
if(obj){
if(obj.getClassName()==="MQPenStyle"){
_116=obj;
}
}
};
var _118=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_RED);
this.getFillColor=function(){
return _118;
};
this.setFillColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_118=obj;
}
}
};
var _11a=new MQFillStyle(MQCONSTANT.MQFILLSTYLE_SOLID);
this.getFillStyle=function(){
return _11a;
};
this.setFillStyle=function(obj){
if(obj){
if(obj.getClassName()==="MQFillStyle"){
_11a=obj;
}
}
};
var _11c=new MQLatLng("UpperLeftLatLng");
this.getUpperLeftLatLng=function(){
return _11c;
};
this.setUpperLeftLatLng=function(_11d){
_11c.setLatLng(_11d.getLatitude(),_11d.getLongitude());
};
var _11e=new MQLatLng("LowerRightLatLng");
this.getLowerRightLatLng=function(){
return _11e;
};
this.setLowerRightLatLng=function(_11f){
_11e.setLatLng(_11f.getLatitude(),_11f.getLongitude());
};
var _120=new MQPoint("UpperLeftPoint");
this.getUpperLeftPoint=function(){
return _120;
};
this.setUpperLeftPoint=function(_121){
_120.setXY(_121.getX(),_121.getY());
};
var _122=new MQPoint("LowerRightPoint");
this.getLowerRightPoint=function(){
return _122;
};
this.setLowerRightPoint=function(_123){
_122.setXY(_123.getX(),_123.getY());
};
}
MQRectanglePrimitive.prototype.getClassName=function(){
return "MQRectanglePrimitive";
};
MQRectanglePrimitive.prototype.getObjectVersion=function(){
return 0;
};
MQRectanglePrimitive.prototype.loadXml=function(_124){
this.setM_XmlDoc(MQA.createXMLDoc(_124));
var _125=this.getUpperLeftLatLng();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftLatLng")!==null){
_125.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftLatLng")));
}
_125=this.getLowerRightLatLng();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LowerRightLatLng")!==null){
_125.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LowerRightLatLng")));
}
var _126=this.getUpperLeftPoint();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftPoint")!==null){
_126.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftPoint")));
}
_126=this.getLowerRightPoint();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LowerRightPoint")!==null){
_126.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LowerRightPoint")));
}
this.setDrawTrigger(new MQDrawTrigger(Math.floor(this.getProperty("DrawTrigger"))));
this.setCoordinateType(new MQCoordinateType(Math.floor(this.getProperty("CoordinateType"))));
this.setColor(new MQColorStyle(Math.floor(this.getProperty("Color"))));
this.setStyle(new MQPenStyle(Math.floor(this.getProperty("Style"))));
this.setFillColor(new MQColorStyle(Math.floor(this.getProperty("FillColor"))));
this.setFillStyle(new MQFillStyle(Math.floor(this.getProperty("FillStyle"))));
};
MQRectanglePrimitive.prototype.saveXml=function(){
var _127=MQA.createXMLDoc(this.getUpperLeftLatLng().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_127,"UpperLeftLatLng"));
_127=MQA.createXMLDoc(this.getLowerRightLatLng().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_127,"LowerRightLatLng"));
_127=MQA.createXMLDoc(this.getUpperLeftPoint().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_127,"UpperLeftPoint"));
_127=MQA.createXMLDoc(this.getLowerRightPoint().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_127,"LowerRightPoint"));
this.setProperty("DrawTrigger",this.getDrawTrigger().intValue());
this.setProperty("CoordinateType",this.getCoordinateType().intValue());
this.setProperty("Color",this.getColor().intValue());
this.setProperty("Style",this.getStyle().intValue());
this.setProperty("FillColor",this.getFillColor().intValue());
this.setProperty("FillStyle",this.getFillStyle().intValue());
return mqXmlToStr(this.getM_XmlDoc());
};
MQRectanglePrimitive.prototype.setWidth=function(_128){
this.setProperty("Width",_128);
};
MQRectanglePrimitive.prototype.getWidth=function(){
return this.getProperty("Width");
};
MQEllipsePrimitive.prototype=new MQRectanglePrimitive();
MQEllipsePrimitive.prototype.constructor=MQEllipsePrimitive;
function MQEllipsePrimitive(){
MQRectanglePrimitive.call(this);
this.setM_Xpath("EllipsePrimitive");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getELLIPSEPRIMITIVE()));
}
MQEllipsePrimitive.prototype.getClassName=function(){
return "MQEllipsePrimitive";
};
MQEllipsePrimitive.prototype.getObjectVersion=function(){
return 0;
};
MQSymbolPrimitive.prototype=new MQPrimitive();
MQSymbolPrimitive.prototype.constructor=MQSymbolPrimitive;
function MQSymbolPrimitive(){
MQPrimitive.call(this);
this.setM_Xpath("SymbolPrimitive");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getSYMBOLPRIMITIVE()));
var m_pt=new MQPoint("CenterPoint");
this.getCenterPoint=function(){
return m_pt;
};
this.setCenterPoint=function(_12a){
m_pt.setXY(_12a.getX(),_12a.getY());
};
var m_ll=new MQLatLng("CenterLatLng");
this.getCenterLatLng=function(){
return m_ll;
};
this.setCenterLatLng=function(_12c){
m_ll.setLatLng(_12c.getLatitude(),_12c.getLongitude());
};
var _12d=new MQSymbolType(MQCONSTANT.MQSYMBOLTYPE_RASTER);
this.getSymbolType=function(){
return _12d;
};
this.setSymbolType=function(obj){
if(obj){
if(obj.getClassName()==="MQSymbolType"){
_12d=obj;
}
}
};
}
MQSymbolPrimitive.prototype.getClassName=function(){
return "MQSymbolPrimitive";
};
MQSymbolPrimitive.prototype.getObjectVersion=function(){
return 0;
};
MQSymbolPrimitive.prototype.loadXml=function(_12f){
this.setM_XmlDoc(MQA.createXMLDoc(_12f));
var _130=this.getCenterLatLng();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterLatLng")!==null){
_130.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterLatLng")));
}
var _131=this.getCenterPoint();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")!==null){
_131.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")));
}
this.setDrawTrigger(new MQDrawTrigger(Math.floor(this.getProperty("DrawTrigger"))));
this.setCoordinateType(new MQCoordinateType(Math.floor(this.getProperty("CoordinateType"))));
this.setSymbolType(new MQSymbolType(Math.floor(this.getProperty("SymbolType"))));
};
MQSymbolPrimitive.prototype.saveXml=function(){
var _132=MQA.createXMLDoc(this.getCenterLatLng().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_132,"CenterLatLng"));
_132=MQA.createXMLDoc(this.getCenterPoint().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_132,"CenterPoint"));
this.setProperty("DrawTrigger",this.getDrawTrigger().intValue());
this.setProperty("CoordinateType",this.getCoordinateType().intValue());
this.setProperty("SymbolType",this.getSymbolType().intValue());
return mqXmlToStr(this.getM_XmlDoc());
};
MQSymbolPrimitive.prototype.setSymbolName=function(_133){
this.setProperty("SymbolName",_133);
};
MQSymbolPrimitive.prototype.getSymbolName=function(){
return this.getProperty("SymbolName");
};
MQTextPrimitive.prototype=new MQPrimitive();
MQTextPrimitive.prototype.constructor=MQTextPrimitive;
function MQTextPrimitive(){
MQPrimitive.call(this);
this.setM_Xpath("TextPrimitive");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getTEXTPRIMITIVE()));
var m_pt=new MQPoint("UpperLeftPoint");
this.getUpperLeftPoint=function(){
return m_pt;
};
this.setUpperLeftPoint=function(_135){
m_pt.setXY(_135.getX(),_135.getY());
};
var m_ll=new MQLatLng("UpperLeftLatLng");
this.getUpperLeftLatLng=function(){
return m_ll;
};
this.setUpperLeftLatLng=function(_137){
m_ll.setLatLng(_137.getLatitude(),_137.getLongitude());
};
var _138=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_BLACK);
this.getColor=function(){
return _138;
};
this.setColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_138=obj;
}
}
};
var _13a=new MQFontStyle(MQCONSTANT.MQFONTSTYLE_BOXED);
this.getStyle=function(){
return _13a;
};
this.setStyle=function(obj){
if(obj){
if(obj.getClassName()==="MQFontStyle"){
_13a=obj;
}
}
};
var _13c=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_WHITE);
this.getBkgdColor=function(){
return _13c;
};
this.setBkgdColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_13c=obj;
}
}
};
var _13e=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_INVALID);
this.getBoxOutlineColor=function(){
return _13e;
};
this.setBoxOutlineColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_13e=obj;
}
}
};
var _140=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_INVALID);
this.getOutlineColor=function(){
return _140;
};
this.setOutlineColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_140=obj;
}
}
};
}
MQTextPrimitive.prototype.getClassName=function(){
return "MQTextPrimitive";
};
MQTextPrimitive.prototype.getObjectVersion=function(){
return 0;
};
MQTextPrimitive.prototype.loadXml=function(_142){
this.setM_XmlDoc(MQA.createXMLDoc(_142));
var _143=this.getUpperLeftLatLng();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftLatLng")!==null){
_143.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftLatLng")));
}
var _144=this.getUpperLeftPoint();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftPoint")!==null){
_144.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftPoint")));
}
this.setDrawTrigger(new MQDrawTrigger(Math.floor(this.getProperty("DrawTrigger"))));
this.setCoordinateType(new MQCoordinateType(Math.floor(this.getProperty("CoordinateType"))));
this.setColor(new MQColorStyle(Math.floor(this.getProperty("Color"))));
this.setStyle(new MQFontStyle(Math.floor(this.getProperty("Style"))));
this.setBkgdColor(new MQColorStyle(Math.floor(this.getProperty("BkgdColor"))));
this.setBoxOutlineColor(new MQColorStyle(Math.floor(this.getProperty("BoxOutlineColor"))));
this.setOutlineColor(new MQColorStyle(Math.floor(this.getProperty("OutlineColor"))));
};
MQTextPrimitive.prototype.saveXml=function(){
var _145=MQA.createXMLDoc(this.getUpperLeftLatLng().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_145,"UpperLeftLatLng"));
_145=MQA.createXMLDoc(this.getUpperLeftPoint().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_145,"UpperLeftPoint"));
this.setProperty("DrawTrigger",this.getDrawTrigger().intValue());
this.setProperty("CoordinateType",this.getCoordinateType().intValue());
this.setProperty("Color",this.getColor().intValue());
this.setProperty("Style",this.getStyle().intValue());
this.setProperty("BkgdColor",this.getBkgdColor().intValue());
this.setProperty("BoxOutlineColor",this.getBoxOutlineColor().intValue());
this.setProperty("OutlineColor",this.getOutlineColor().intValue());
return mqXmlToStr(this.getM_XmlDoc());
};
MQTextPrimitive.prototype.setText=function(str){
this.setProperty("Text",str);
};
MQTextPrimitive.prototype.getText=function(){
return this.getProperty("Text");
};
MQTextPrimitive.prototype.setFontName=function(str){
this.setProperty("FontName",str);
};
MQTextPrimitive.prototype.getFontName=function(){
return this.getProperty("FontName");
};
MQTextPrimitive.prototype.setWidth=function(val){
this.setProperty("Width",val);
};
MQTextPrimitive.prototype.getWidth=function(){
return this.getProperty("Width");
};
MQTextPrimitive.prototype.setFontSize=function(val){
this.setProperty("FontSize",val);
};
MQTextPrimitive.prototype.getFontSize=function(){
return this.getProperty("FontSize");
};
MQTextPrimitive.prototype.setMargin=function(val){
this.setProperty("Margin",val);
};
MQTextPrimitive.prototype.getMargin=function(){
return this.getProperty("Margin");
};
MQTextPrimitive.prototype.setTextAlignment=function(val){
this.setProperty("TextAlignment",val);
};
MQTextPrimitive.prototype.getTextAlignment=function(){
return this.getProperty("TextAlignment");
};
MQFeatureSpecifier.prototype=new MQObject();
MQFeatureSpecifier.prototype.constructor=MQFeatureSpecifier;
function MQFeatureSpecifier(){
MQObject.call(this);
this.setM_Xpath("FeatureSpecifier");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getFEATURESPECIFIER()));
var _14c=new MQFeatureSpeciferAttributeType(MQCONSTANT.MQFEATURESPECIFERATTRIBUTETYPE_GEFID);
this.getAttributeType=function(){
return _14c;
};
this.setAttributeType=function(obj){
if(obj){
if(obj.getClassName()==="MQFeatureSpeciferAttributeType"){
_14c=obj;
}
}
};
}
MQFeatureSpecifier.prototype.getClassName=function(){
return "MQFeatureSpecifier";
};
MQFeatureSpecifier.prototype.getObjectVersion=function(){
return 0;
};
MQFeatureSpecifier.prototype.setAttributeValue=function(val){
this.setProperty("AttributeValue",val);
};
MQFeatureSpecifier.prototype.getAttributeValue=function(){
return this.getProperty("AttributeValue");
};
MQBaseDTStyle.prototype=new MQObject();
MQBaseDTStyle.prototype.constructor=MQBaseDTStyle;
function MQBaseDTStyle(){
MQObject.call(this);
}
MQBaseDTStyle.prototype.getClassName=function(){
return "MQBaseDTStyle";
};
MQBaseDTStyle.prototype.getObjectVersion=function(){
return 0;
};
MQBaseDTStyle.prototype.setDT=function(val){
this.setProperty("DT",val);
};
MQBaseDTStyle.prototype.getDT=function(){
return this.getProperty("DT");
};
MQBaseDTStyle.prototype.setHighScale=function(val){
this.setProperty("HighScale",val);
};
MQBaseDTStyle.prototype.getHighScale=function(){
return this.getProperty("HighScale");
};
MQBaseDTStyle.prototype.setLowScale=function(val){
this.setProperty("LowScale",val);
};
MQBaseDTStyle.prototype.getLowScale=function(){
return this.getProperty("LowScale");
};
MQBaseDTStyle.prototype.equals=function(type){
if(type){
try{
var _153=type.getClassName();
}
catch(error){
alert("Invalid type for this function!");
throw "Invalid type for this function!";
}
if(_153===this.getClassName()){
return (this.getDT()===type.getDT()&&this.getHighScale()===type.getHighScale()&&this.getLowScale()===type.getLowScale());
}else{
alert("Invalid type for this function!");
throw "Invalid type for this function!";
}
}else{
alert("An MQBaseDTStyle parameter must be provided for this function!");
throw "An MQBaseDTStyle parameter must be provided for this function!";
}
};
MQDTStyle.prototype=new MQBaseDTStyle();
MQDTStyle.prototype.constructor=MQDTStyle;
function MQDTStyle(){
MQBaseDTStyle.call(this);
this.setM_Xpath("DTStyle");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getDTSTYLE()));
var _154=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_INVALID);
this.getFontColor=function(){
return _154;
};
this.setFontColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_154=obj;
}
}
};
var _156=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_INVALID);
this.getFontOutlineColor=function(){
return _156;
};
this.setFontOutlineColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_156=obj;
}
}
};
var _158=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_INVALID);
this.getFontBoxBkgdColor=function(){
return _158;
};
this.setFontBoxBkgdColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_158=obj;
}
}
};
var _15a=new MQColorStyle(MQCONSTANT.MQCOLORSTYLE_INVALID);
this.getFontBoxOutlineColor=function(){
return _15a;
};
this.setFontBoxOutlineColor=function(obj){
if(obj){
if(obj.getClassName()==="MQColorStyle"){
_15a=obj;
}
}
};
var _15c=new MQFontStyle(MQCONSTANT.MQFONTSTYLE_INVALID);
this.getFontStyle=function(){
return _15c;
};
this.setFontStyle=function(obj){
if(obj){
if(obj.getClassName()==="MQFontStyle"){
_15c=obj;
}
}
};
var _15e=new MQSymbolType(MQCONSTANT.MQSYMBOLTYPE_RASTER);
this.getSymbolType=function(){
return _15e;
};
this.setSymbolType=function(obj){
if(obj){
if(obj.getClassName()==="MQSymbolType"){
_15e=obj;
}
}
};
}
MQDTStyle.prototype.getClassName=function(){
return "MQDTStyle";
};
MQDTStyle.prototype.getObjectVersion=function(){
return 0;
};
MQDTStyle.prototype.loadXml=function(_160){
this.setM_XmlDoc(MQA.createXMLDoc(_160));
this.setFontColor(new MQColorStyle(Math.floor(this.getProperty("FontColor"))));
this.setFontOutlineColor(new MQColorStyle(Math.floor(this.getProperty("FontOutlineColor"))));
this.setFontBoxBkgdColor(new MQColorStyle(Math.floor(this.getProperty("FontBoxBkgdColor"))));
this.setFontBoxOutlineColor(new MQColorStyle(Math.floor(this.getProperty("FontBoxOutlineColor"))));
this.setFontStyle(new MQFontStyle(Math.floor(this.getProperty("FeatureSpeciferAttributeType"))));
this.setSymbolType(new MQSymbolType(Math.floor(this.getProperty("SymbolType"))));
};
MQDTStyle.prototype.saveXml=function(){
this.setProperty("FontColor",this.getFontColor().intValue());
this.setProperty("FontOutlineColor",this.getFontOutlineColor().intValue());
this.setProperty("FontBoxBkgdColor",this.getFontBoxBkgdColor().intValue());
this.setProperty("FontBoxOutlineColor",this.getFontBoxOutlineColor().intValue());
this.setProperty("FontStyle",this.getFontStyle().intValue());
this.setProperty("SymbolType",this.getSymbolType().intValue());
return mqXmlToStr(this.getM_XmlDoc());
};
MQDTStyle.prototype.setSymbolName=function(val){
this.setProperty("SymbolName",val);
};
MQDTStyle.prototype.getSymbolName=function(){
return this.getProperty("SymbolName");
};
MQDTStyle.prototype.setFontName=function(val){
this.setProperty("FontName",val);
};
MQDTStyle.prototype.getFontName=function(){
return this.getProperty("FontName");
};
MQDTStyle.prototype.setVisible=function(_163){
this.setProperty("Visible",(_163===true)?1:0);
};
MQDTStyle.prototype.getVisible=function(){
return (this.getProperty("Visible")==1)?true:false;
};
MQDTStyle.prototype.setLabelVisible=function(_164){
this.setProperty("LabelVisible",(_164===true)?1:0);
};
MQDTStyle.prototype.getLabelVisible=function(){
return (this.getProperty("LabelVisible")==1)?true:false;
};
MQDTStyle.prototype.setFontSize=function(val){
this.setProperty("FontSize",val);
};
MQDTStyle.prototype.getFontSize=function(){
return this.getProperty("FontSize");
};
MQDTStyle.prototype.setFontBoxMargin=function(val){
this.setProperty("FontBoxMargin",val);
};
MQDTStyle.prototype.getFontBoxMargin=function(){
return this.getProperty("FontBoxMargin");
};
MQDTStyleEx.prototype=new MQBaseDTStyle();
MQDTStyleEx.prototype.constructor=MQDTStyleEx;
function MQDTStyleEx(){
MQBaseDTStyle.call(this);
this.setM_Xpath("DTStyleEx");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getDTSTYLEEX()));
}
MQDTStyleEx.prototype.getClassName=function(){
return "MQDTStyleEx";
};
MQDTStyleEx.prototype.getObjectVersion=function(){
return 0;
};
MQDTStyleEx.prototype.loadXml=function(_167){
this.setM_XmlDoc(MQA.createXMLDoc(_167));
};
MQDTStyleEx.prototype.saveXml=function(){
return mqXmlToStr(this.getM_XmlDoc());
};
MQDTStyleEx.prototype.setStyleString=function(val){
this.setProperty("StyleString",val);
};
MQDTStyleEx.prototype.getStyleString=function(){
return this.getProperty("StyleString");
};
MQDTFeatureStyleEx.prototype=new MQDTStyleEx();
MQDTFeatureStyleEx.prototype.constructor=MQDTFeatureStyleEx;
function MQDTFeatureStyleEx(){
MQBaseDTStyle.call(this);
this.setM_Xpath("DTStyleEx");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getDTFEATURESTYLEEX()));
var _169=new MQFeatureSpecifierCollection("FeatureSpecifier");
_169.setM_Xpath("FeatureSpecifierCollection");
this.getFeatureSpecifiers=function(){
return _169;
};
this.setFeatureSpecifiers=function(col){
if(mqIsClass(_169.getClassName(),col,false)){
_169.removeAll();
_169.append(col);
}
};
}
MQDTFeatureStyleEx.prototype.getClassName=function(){
return "MQDTFeatureStyleEx";
};
MQDTFeatureStyleEx.prototype.getObjectVersion=function(){
return 0;
};
MQDTFeatureStyleEx.prototype.loadXml=function(_16b){
this.setM_XmlDoc(MQA.createXMLDoc(_16b));
};
MQDTFeatureStyleEx.prototype.saveXml=function(){
return mqXmlToStr(this.getM_XmlDoc());
};
MQMapCommand.prototype=new MQObject();
MQMapCommand.prototype.constructor=MQMapCommand;
function MQMapCommand(){
MQObject.call(this);
this.setM_Xpath("DTStyleEx");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getDTFEATURESTYLEEX()));
var _16c=new MQFeatureSpecifierCollection("FeatureSpecifier");
_16c.setM_Xpath("FeatureSpecifierCollection");
this.getFeatureSpecifiers=function(){
return _16c;
};
this.setFeatureSpecifiers=function(col){
if(col.getClassName()==="MQFeatureSpecifierCollection"){
_16c=col;
}else{
alert("failure in setFeatureSpecifiers");
throw "failure in setFeatureSpecifiers";
}
};
}
MQMapCommand.prototype.getClassName=function(){
return "MQMapCommand";
};
MQMapCommand.prototype.getObjectVersion=function(){
return 0;
};
MQBestFit.prototype=new MQMapCommand();
MQBestFit.prototype.constructor=MQBestFit;
function MQBestFit(){
MQMapCommand.call(this);
this.setM_Xpath("BestFit");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getBESTFIT()));
var _16e=new MQDTCollection();
_16e.setM_Xpath("DisplayTypes");
this.getDisplayTypes=function(){
return _16e;
};
this.setDisplayTypes=function(col){
_16e.removeAll();
_16e.append(col);
};
}
MQBestFit.prototype.getClassName=function(){
return "MQBestFit";
};
MQBestFit.prototype.getObjectVersion=function(){
return 2;
};
MQBestFit.prototype.loadXml=function(_170){
this.setM_XmlDoc(MQA.createXMLDoc(_170));
var obj=this.getDisplayTypes();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DisplayTypes")!==null){
obj.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DisplayTypes")));
}
};
MQBestFit.prototype.saveXml=function(){
var _172=MQA.createXMLDoc(this.getDisplayTypes().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_172,"DisplayTypes"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQBestFit.prototype.setIncludePrimitives=function(_173){
this.setProperty("IncludePrimitives",(_173===true)?1:0);
};
MQBestFit.prototype.getIncludePrimitives=function(){
return (this.getProperty("IncludePrimitives")==1)?true:false;
};
MQBestFit.prototype.setKeepCenter=function(_174){
this.setProperty("KeepCenter",(_174===true)?1:0);
};
MQBestFit.prototype.getKeepCenter=function(){
return (this.getProperty("KeepCenter")==1)?true:false;
};
MQBestFit.prototype.setSnapToZoomLevel=function(_175){
this.setProperty("SnapToZoomLevel",(_175===true)?1:0);
};
MQBestFit.prototype.getSnapToZoomLevel=function(){
return (this.getProperty("SnapToZoomLevel")==1)?true:false;
};
MQBestFit.prototype.setScaleAdjustmentFactor=function(val){
this.setProperty("ScaleAdjFactor",val);
};
MQBestFit.prototype.getScaleAdjustmentFactor=function(){
return this.getProperty("ScaleAdjFactor");
};
MQBestFitLL.prototype=new MQMapCommand();
MQBestFitLL.prototype.constructor=MQBestFitLL;
function MQBestFitLL(){
MQMapCommand.call(this);
this.setM_Xpath("BestFitLL");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getBESTFITLL()));
var _177=new MQLatLngCollection();
_177.setM_Xpath("LatLngs");
this.getLatLngs=function(){
return _177;
};
this.setLatLngs=function(col){
_177.removeAll();
_177.append(col);
};
}
MQBestFitLL.prototype.getClassName=function(){
return "MQBestFitLL";
};
MQBestFitLL.prototype.getObjectVersion=function(){
return 0;
};
MQBestFitLL.prototype.loadXml=function(_179){
this.setM_XmlDoc(MQA.createXMLDoc(_179));
var obj=this.getLatLngs();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")!==null){
obj.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LatLngs")));
}
};
MQBestFitLL.prototype.saveXml=function(){
var _17b=MQA.createXMLDoc(this.getLatLngs().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_17b,"LatLngs"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQBestFitLL.prototype.setKeepCenter=function(_17c){
this.setProperty("KeepCenter",(_17c===true)?1:0);
};
MQBestFitLL.prototype.getKeepCenter=function(){
return (this.getProperty("KeepCenter")==1)?true:false;
};
MQBestFitLL.prototype.setSnapToZoomLevel=function(_17d){
this.setProperty("SnapToZoomLevel",(_17d===true)?1:0);
};
MQBestFitLL.prototype.getSnapToZoomLevel=function(){
return (this.getProperty("SnapToZoomLevel")==1)?true:false;
};
MQBestFitLL.prototype.setScaleAdjustmentFactor=function(val){
this.setProperty("ScaleAdjFactor",val);
};
MQBestFitLL.prototype.getScaleAdjustmentFactor=function(){
return this.getProperty("ScaleAdjFactor");
};
MQCenter.prototype=new MQMapCommand();
MQCenter.prototype.constructor=MQCenter;
function MQCenter(){
MQMapCommand.call(this);
this.setM_Xpath("Center");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getCENTER()));
var _17f=new MQPoint("CenterPoint");
this.getCenter=function(){
return _17f;
};
this.setCenter=function(pt){
if(mqIsClass(_17f.getClassName(),pt,false)){
_17f=pt.internalCopy(_17f);
}
};
}
MQCenter.prototype.getClassName=function(){
return "MQCenter";
};
MQCenter.prototype.getObjectVersion=function(){
return 0;
};
MQCenter.prototype.loadXml=function(_181){
this.setM_XmlDoc(MQA.createXMLDoc(_181));
var obj=this.getCenter();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")!==null){
obj.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")));
}
};
MQCenter.prototype.saveXml=function(){
var _183=MQA.createXMLDoc(this.getCenter().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_183,"CenterPoint"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQCenterLatLng.prototype=new MQMapCommand();
MQCenterLatLng.prototype.constructor=MQCenterLatLng;
function MQCenterLatLng(){
MQMapCommand.call(this);
this.setM_Xpath("CenterLatLng");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getCENTERLATLNG()));
var _184=new MQLatLng("CenterLatLng");
this.getCenter=function(){
return _184;
};
this.setCenter=function(ll){
if(mqIsClass(_184.getClassName(),ll,false)){
_184=ll.internalCopy(_184);
}
};
}
MQCenterLatLng.prototype.getClassName=function(){
return "MQCenterLatLng";
};
MQCenterLatLng.prototype.getObjectVersion=function(){
return 0;
};
MQCenterLatLng.prototype.loadXml=function(_186){
this.setM_XmlDoc(MQA.createXMLDoc(_186));
var obj=this.getCenter();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterLatLng")!==null){
obj.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterLatLng")));
}
};
MQCenterLatLng.prototype.saveXml=function(){
var _188=MQA.createXMLDoc(this.getCenter().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_188,"CenterLatLng"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQPan.prototype=new MQMapCommand();
MQPan.prototype.constructor=MQPan;
function MQPan(){
MQMapCommand.call(this);
this.setM_Xpath("Pan");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getPAN()));
var _189=new MQPoint("DeltaPoint");
this.getPoint=function(){
return _189;
};
this.setDeltaXY=function(dblX,dblY){
_189.setXY(dblX,dblY);
};
this.setDeltaY=function(dblY){
_189.setY(dblY);
};
this.setDeltaX=function(dblX){
_189.setX(dblX);
};
}
MQPan.prototype.getClassName=function(){
return "MQPan";
};
MQPan.prototype.getObjectVersion=function(){
return 0;
};
MQPan.prototype.loadXml=function(_18e){
this.setM_XmlDoc(MQA.createXMLDoc(_18e));
var obj=this.getPoint();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DeltaPoint")!==null){
obj.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DeltaPoint")));
}
};
MQPan.prototype.saveXml=function(){
var _190=MQA.createXMLDoc(this.getPoint().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_190,"DeltaPoint"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQZoomIn.prototype=new MQMapCommand();
MQZoomIn.prototype.constructor=MQZoomIn;
function MQZoomIn(){
MQMapCommand.call(this);
this.setM_Xpath("ZoomIn");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getZOOMIN()));
var _191=new MQPoint("CenterPoint");
this.getCenter=function(){
return _191;
};
this.setCenter=function(pt){
_191=pt;
};
}
MQZoomIn.prototype.getClassName=function(){
return "MQZoomIn";
};
MQZoomIn.prototype.getObjectVersion=function(){
return 0;
};
MQZoomIn.prototype.loadXml=function(_193){
this.setM_XmlDoc(MQA.createXMLDoc(_193));
var obj=this.getCenter();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")!==null){
obj.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")));
}
};
MQZoomIn.prototype.saveXml=function(){
var _195=MQA.createXMLDoc(this.getCenter().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_195,"CenterPoint"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQZoomOut.prototype=new MQMapCommand();
MQZoomOut.prototype.constructor=MQZoomOut;
function MQZoomOut(){
MQMapCommand.call(this);
this.setM_Xpath("ZoomOut");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getZOOMOUT()));
var _196=new MQPoint("CenterPoint");
this.getCenter=function(){
return _196;
};
this.setCenter=function(pt){
_196=pt;
};
}
MQZoomOut.prototype.getClassName=function(){
return "MQZoomOut";
};
MQZoomOut.prototype.getObjectVersion=function(){
return 0;
};
MQZoomOut.prototype.loadXml=function(_198){
this.setM_XmlDoc(MQA.createXMLDoc(_198));
var obj=this.getCenter();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")!==null){
obj.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")));
}
};
MQZoomOut.prototype.saveXml=function(){
var _19a=MQA.createXMLDoc(this.getCenter().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_19a,"CenterPoint"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQZoomTo.prototype=new MQMapCommand();
MQZoomTo.prototype.constructor=MQZoomTo;
function MQZoomTo(){
MQMapCommand.call(this);
this.setM_Xpath("ZoomTo");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getZOOMTO()));
var _19b=new MQPoint("CenterPoint");
this.getCenter=function(){
return _19b;
};
this.setCenter=function(pt){
_19b=pt;
};
}
MQZoomTo.prototype.getClassName=function(){
return "MQZoomTo";
};
MQZoomTo.prototype.getObjectVersion=function(){
return 0;
};
MQZoomTo.prototype.loadXml=function(_19d){
this.setM_XmlDoc(MQA.createXMLDoc(_19d));
var obj=this.getCenter();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")!==null){
obj.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/CenterPoint")));
}
};
MQZoomTo.prototype.saveXml=function(){
var _19f=MQA.createXMLDoc(this.getCenter().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_19f,"CenterPoint"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQZoomTo.prototype.getZoomLevel=function(){
return this.getProperty("ZoomLevel");
};
MQZoomTo.prototype.setZoomLevel=function(val){
this.setProperty("ZoomLevel",val);
};
MQZoomToRect.prototype=new MQMapCommand();
MQZoomToRect.prototype.constructor=MQZoomToRect;
function MQZoomToRect(){
MQMapCommand.call(this);
this.setM_Xpath("ZoomToRect");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getZOOMTORECT()));
var _1a1=new MQPoint("UpperLeftPoint");
var _1a2=new MQPoint("LowerRightPoint");
this.getRect=function(ulpt,lrpt){
ulpt.loadXml(_1a1.copy().saveXml());
lrpt.loadXml(_1a2.copy().saveXml());
};
this.setRect=function(ulpt,lrpt){
if(mqIsClass(_1a1.getClassName(),ulpt,false)&&mqIsClass(_1a2.getClassName(),lrpt,false)){
_1a1=ulpt.internalCopy(_1a1);
_1a2=lrpt.internalCopy(_1a2);
}
};
}
MQZoomToRect.prototype.getClassName=function(){
return "MQZoomToRect";
};
MQZoomToRect.prototype.getObjectVersion=function(){
return 0;
};
MQZoomToRect.prototype.loadXml=function(_1a7){
this.setM_XmlDoc(MQA.createXMLDoc(_1a7));
var ul=new MQPoint("UpperLeftPoint"),lr=new MQPoint("LowerRightPoint");
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftPoint")!==null){
ul.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftPoint")));
}
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LowerRightPoint")!==null){
lr.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LowerRightPoint")));
}
this.setRect(ul,lr);
};
MQZoomToRect.prototype.saveXml=function(){
var ul=new MQPoint("UpperLeftPoint"),lr=new MQPoint("LowerRightPoint");
this.getRect(ul,lr);
var _1ac=MQA.createXMLDoc(ul.saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_1ac,"UpperLeftPoint"));
_1ac=MQA.createXMLDoc(lr.saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_1ac,"LowerRightPoint"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQZoomToRectLatLng.prototype=new MQMapCommand();
MQZoomToRectLatLng.prototype.constructor=MQZoomToRectLatLng;
function MQZoomToRectLatLng(){
MQMapCommand.call(this);
this.setM_Xpath("ZoomToRectLatLng");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getZOOMTORECTLATLNG()));
var _1ad=new MQLatLng("UpperLeftLatLng");
var _1ae=new MQLatLng("LowerRightLatLng");
this.getRect=function(ulll,lrll){
ulll.loadXml(_1ad.copy().saveXml());
lrll.loadXml(_1ae.copy().saveXml());
};
this.setRect=function(ulll,lrll){
if(mqIsClass(_1ad.getClassName(),ulll,false)&&mqIsClass(_1ae.getClassName(),lrll,false)){
_1ad=ulll.internalCopy(_1ad);
_1ae=lrll.internalCopy(_1ae);
}
};
}
MQZoomToRectLatLng.prototype.getClassName=function(){
return "MQZoomToRectLatLng";
};
MQZoomToRectLatLng.prototype.getObjectVersion=function(){
return 0;
};
MQZoomToRectLatLng.prototype.loadXml=function(_1b3){
this.setM_XmlDoc(MQA.createXMLDoc(_1b3));
var ul=new MQLatLng("UpperLeftLatLng"),lr=new MQLatLng("LowerRightLatLng");
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftLatLng")!==null){
ul.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/UpperLeftLatLng")));
}
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LowerRightLatLng")!==null){
lr.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/LowerRightLatLng")));
}
this.setRect(ul,lr);
};
MQZoomToRectLatLng.prototype.saveXml=function(){
var ul=new MQLatLng("UpperLeftLatLng"),lr=new MQLatLng("LowerRightLatLng");
this.getRect(ul,lr);
var _1b8=MQA.createXMLDoc(ul.saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_1b8,"UpperLeftLatLng"));
_1b8=MQA.createXMLDoc(lr.saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_1b8,"LowerRightLatLng"));
return mqXmlToStr(this.getM_XmlDoc());
};
function MQType(){
}
MQType.prototype.equals=function(type){
if(type){
try{
var _1ba=type.getClassName();
}
catch(error){
alert("Invalid type for this function!");
throw "Invalid type for this function!";
}
if(_1ba===this.getClassName()){
return (this.intValue()===type.intValue());
}else{
alert("Invalid type for this function!");
throw "Invalid type for this function!";
}
}else{
alert("An MQType parameter must be provided for this function!");
throw "An MQType parameter must be provided for this function!";
}
};
MQRouteType.prototype=new MQType();
MQRouteType.prototype.constructor=MQRouteType;
function MQRouteType(val){
var _1bc=-1;
switch(val){
case MQCONSTANT.MQROUTETYPE_FASTEST:
_1bc=val;
break;
case MQCONSTANT.MQROUTETYPE_SHORTEST:
_1bc=val;
break;
case MQCONSTANT.MQROUTETYPE_PEDESTRIAN:
_1bc=val;
break;
case MQCONSTANT.MQROUTETYPE_OPTIMIZED:
_1bc=val;
break;
case MQCONSTANT.MQROUTETYPE_SELECT_DATASET_ONLY:
_1bc=val;
break;
default:
alert(val+" is an invalid value for MQRouteType!");
throw val+" invalid value for MQRouteType!";
}
this.intValue=function(){
return _1bc;
};
}
MQRouteType.prototype.getClassName=function(){
return "MQRouteType";
};
MQRouteType.prototype.getObjectVersion=function(){
return 0;
};
MQNarrativeType.prototype=new MQType();
MQNarrativeType.prototype.constructor=MQNarrativeType;
function MQNarrativeType(val){
var _1be=-2;
switch(val){
case MQCONSTANT.MQNARRATIVETYPE_DEFAULT:
_1be=val;
break;
case MQCONSTANT.MQNARRATIVETYPE_HTML:
_1be=val;
break;
case MQCONSTANT.MQNARRATIVETYPE_NONE:
_1be=val;
break;
default:
alert(val+" is an invalid value for MQNarrativeType!");
throw val+" invalid value for MQNarrativeType!";
}
this.intValue=function(){
return _1be;
};
}
MQNarrativeType.prototype.getClassName=function(){
return "MQNarrativeType";
};
MQNarrativeType.prototype.getObjectVersion=function(){
return 0;
};
MQCoordinateType.prototype=new MQType();
MQCoordinateType.prototype.constructor=MQCoordinateType;
function MQCoordinateType(val){
var _1c0=-2;
switch(val){
case MQCONSTANT.MQCOORDINATETYPE_DISPLAY:
_1c0=val;
break;
case MQCONSTANT.MQCOORDINATETYPE_GEOGRAPHIC:
_1c0=val;
break;
default:
alert(val+" is an invalid value for MQCoordinateType!");
throw val+" invalid value for MQCoordinateType!";
}
this.intValue=function(){
return _1c0;
};
}
MQCoordinateType.prototype.getClassName=function(){
return "MQCoordinateType";
};
MQCoordinateType.prototype.getObjectVersion=function(){
return 0;
};
MQFeatureSpeciferAttributeType.prototype=new MQType();
MQFeatureSpeciferAttributeType.prototype.constructor=MQFeatureSpeciferAttributeType;
function MQFeatureSpeciferAttributeType(val){
var _1c2=-1;
switch(val){
case MQCONSTANT.MQFEATURESPECIFERATTRIBUTETYPE_GEFID:
_1c2=val;
break;
case MQCONSTANT.MQFEATURESPECIFERATTRIBUTETYPE_NAME:
_1c2=val;
break;
default:
alert(val+" is an invalid value for MQFeatureSpeciferAttributeType!");
throw val+" invalid value for MQFeatureSpeciferAttributeType!";
}
this.intValue=function(){
return _1c2;
};
}
MQFeatureSpeciferAttributeType.prototype.getClassName=function(){
return "MQFeatureSpeciferAttributeType";
};
MQFeatureSpeciferAttributeType.prototype.getObjectVersion=function(){
return 0;
};
MQSymbolType.prototype=new MQType();
MQSymbolType.prototype.constructor=MQSymbolType;
function MQSymbolType(val){
var _1c4=-1;
switch(val){
case MQCONSTANT.MQSYMBOLTYPE_RASTER:
_1c4=val;
break;
case MQCONSTANT.MQSYMBOLTYPE_VECTOR:
_1c4=val;
break;
default:
alert(val+" is an invalid value for MQSymbolType!");
throw val+" invalid value for MQSymbolType!";
}
this.intValue=function(){
return _1c4;
};
}
MQSymbolType.prototype.getClassName=function(){
return "MQSymbolType";
};
MQSymbolType.prototype.getObjectVersion=function(){
return 0;
};
MQMatchType.prototype=new MQType();
MQMatchType.prototype.constructor=MQMatchType;
function MQMatchType(val){
var _1c6=-1;
switch(val){
case MQCONSTANT.MQMATCHTYPE_LOC:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_INTR:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_NEARBLK:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_REPBLK:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_BLOCK:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_AA1:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_AA2:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_AA3:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_AA4:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_AA5:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_AA6:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_AA7:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_PC1:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_PC2:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_PC3:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_PC4:
_1c6=val;
break;
case MQCONSTANT.MQMATCHTYPE_POI:
_1c6=val;
break;
default:
alert(val+" is an invalid value for MQMatchType!");
throw val+" invalid value for MQMatchType!";
}
this.intValue=function(){
return _1c6;
};
}
MQMatchType.prototype.getClassName=function(){
return "MQMatchType";
};
MQMatchType.prototype.getObjectVersion=function(){
return 0;
};
MQQualityType.prototype=new MQType();
MQQualityType.prototype.constructor=MQQualityType;
function MQQualityType(val){
var _1c8=-1;
switch(val){
case MQCONSTANT.MQQUALITYTYPE_EXACT:
_1c8=val;
break;
case MQCONSTANT.MQQUALITYTYPE_GOOD:
_1c8=val;
break;
case MQCONSTANT.MQQUALITYTYPE_APPROX:
_1c8=val;
break;
default:
alert(val+" is an invalid value for MQQualityType!");
throw val+" invalid value for MQQualityType!";
}
this.intValue=function(){
return _1c8;
};
}
MQQualityType.prototype.getClassName=function(){
return "MQQualityType";
};
MQQualityType.prototype.getObjectVersion=function(){
return 0;
};
MQDrawTrigger.prototype=new MQType();
MQDrawTrigger.prototype.constructor=MQDrawTrigger;
function MQDrawTrigger(val){
var _1ca=-1;
switch(val){
case MQCONSTANT.MQDRAWTRIGGER_AFTER_POLYGONS:
_1ca=val;
break;
case MQCONSTANT.MQDRAWTRIGGER_AFTER_ROUTE_HIGHLIGHT:
_1ca=val;
break;
case MQCONSTANT.MQDRAWTRIGGER_AFTER_TEXT:
_1ca=val;
break;
case MQCONSTANT.MQDRAWTRIGGER_BEFORE_POLYGONS:
_1ca=val;
break;
case MQCONSTANT.MQDRAWTRIGGER_BEFORE_ROUTE_HIGHLIGHT:
_1ca=val;
break;
case MQCONSTANT.MQDRAWTRIGGER_BEFORE_TEXT:
_1ca=val;
break;
default:
alert(val+" is an invalid value for MQDrawTrigger!");
throw val+" invalid value for MQDrawTrigger!";
}
this.intValue=function(){
return _1ca;
};
}
MQDrawTrigger.prototype.getClassName=function(){
return "MQDrawTrigger";
};
MQDrawTrigger.prototype.getObjectVersion=function(){
return 0;
};
MQPenStyle.prototype=new MQType();
MQPenStyle.prototype.constructor=MQPenStyle;
function MQPenStyle(val){
var _1cc=-1;
switch(val){
case MQCONSTANT.MQPENSTYLE_DASH:
_1cc=val;
break;
case MQCONSTANT.MQPENSTYLE_DASH_DOT:
_1cc=val;
break;
case MQCONSTANT.MQPENSTYLE_DASH_DOT_DOT:
_1cc=val;
break;
case MQCONSTANT.MQPENSTYLE_SOLID:
_1cc=val;
break;
case MQCONSTANT.MQPENSTYLE_DOT:
_1cc=val;
break;
case MQCONSTANT.MQPENSTYLE_NONE:
_1cc=val;
break;
default:
alert(val+" is an invalid value for MQPenStyle!");
throw val+" invalid value for MQPenStyle!";
}
this.intValue=function(){
return _1cc;
};
}
MQPenStyle.prototype.getClassName=function(){
return "MQPenStyle";
};
MQPenStyle.prototype.getObjectVersion=function(){
return 0;
};
MQFontStyle.prototype=new MQType();
MQFontStyle.prototype.constructor=MQFontStyle;
function MQFontStyle(val){
var _1ce=-2;
switch(val){
case MQCONSTANT.MQFONTSTYLE_BOLD:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_BOXED:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_DOT:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_ITALICS:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_MAX_VALUE:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_NORMAL:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_OUTLINED:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_SEMIBOLD:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_STRIKEOUT:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_THIN:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_UNDERLINE:
_1ce=val;
break;
case MQCONSTANT.MQFONTSTYLE_INVALID:
_1ce=val;
break;
default:
alert(val+" is an invalid value for MQFontStyle!");
throw val+" invalid value for MQFontStyle!";
}
this.intValue=function(){
return _1ce;
};
}
MQFontStyle.prototype.getClassName=function(){
return "MQFontStyle";
};
MQFontStyle.prototype.getObjectVersion=function(){
return 0;
};
MQColorStyle.prototype=new MQType();
MQColorStyle.prototype.constructor=MQColorStyle;
function MQColorStyle(val){
var _1d0=MQCONSTANT.MQCOLORSTYLE_INVALID;
if(val!==null){
_1d0=val;
}
this.intValue=function(){
return _1d0;
};
}
MQColorStyle.prototype.getClassName=function(){
return "MQColorStyle";
};
MQColorStyle.prototype.getObjectVersion=function(){
return 0;
};
MQColorStyle.prototype.getRGB=function(){
var rgb=-16777216;
var a=parseInt(parseInt(this.intValue()/65536)%256);
var b=parseInt(parseInt(parseInt(this.intValue()/256)%256)*256);
var c=parseInt(parseInt(this.intValue()%256)*65536);
return rgb+a+b+c;
};
MQFillStyle.prototype=new MQType();
MQFillStyle.prototype.constructor=MQFillStyle;
function MQFillStyle(val){
var _1d6=-1;
switch(val){
case MQCONSTANT.MQFILLSTYLE_SOLID:
_1d6=val;
break;
case MQCONSTANT.MQFILLSTYLE_BDIAGONAL:
_1d6=val;
break;
case MQCONSTANT.MQFILLSTYLE_CROSS:
_1d6=val;
break;
case MQCONSTANT.MQFILLSTYLE_DIAG_CROSS:
_1d6=val;
break;
case MQCONSTANT.MQFILLSTYLE_FDIAGONAL:
_1d6=val;
break;
case MQCONSTANT.MQFILLSTYLE_HORIZONTAL:
_1d6=val;
break;
case MQCONSTANT.MQFILLSTYLE_VERTICAL:
_1d6=val;
break;
case MQCONSTANT.MQFILLSTYLE_NONE:
_1d6=val;
break;
default:
alert(val+" is an invalid value for MQFillStyle!");
throw val+" invalid value for MQFillStyle!";
}
this.intValue=function(){
return _1d6;
};
}
MQFillStyle.prototype.getClassName=function(){
return "MQFillStyle";
};
MQFillStyle.prototype.getObjectVersion=function(){
return 0;
};
MQDistanceUnits.prototype=new MQType();
MQDistanceUnits.prototype.constructor=MQDistanceUnits;
function MQDistanceUnits(val){
var _1d8=0;
val=val||0;
switch(val){
case MQCONSTANT.MQDISTANCEUNITS_MILES:
_1d8=val;
break;
case MQCONSTANT.MQDISTANCEUNITS_KILOMETERS:
_1d8=val;
break;
default:
alert(val+" is an invalid value for MQDistanceUnits!");
throw val+" invalid value for MQDistanceUnist!";
}
this.getValue=function(){
return _1d8;
};
}
MQDistanceUnits.prototype.getClassName=function(){
return "MQDistanceUnits";
};
MQDistanceUnits.prototype.getObjectVersion=function(){
return 0;
};
MQRouteResultsCode.prototype=new MQType();
MQRouteResultsCode.prototype.constructor=MQRouteResultsCode;
function MQRouteResultsCode(val){
var _1da=-2;
switch(val){
case MQCONSTANT.MQROUTERESULTSCODE_NOT_SPECIFIED:
_1da=val;
break;
case MQCONSTANT.MQROUTERESULTSCODE_SUCCESS:
_1da=val;
break;
case MQCONSTANT.MQROUTERESULTSCODE_INVALID_LOCATION:
_1da=val;
break;
case MQCONSTANT.MQROUTERESULTSCODE_ROUTE_FAILURE:
_1da=val;
break;
case MQCONSTANT.MQROUTERESULTSCODE_NO_DATASET_FOUND:
_1da=val;
break;
default:
alert(val+" is an invalid value for MQRouteResultsCode!");
throw val+" invalid value for MQRouteResultsCode!";
}
this.intValue=function(){
return _1da;
};
}
MQRouteResultsCode.prototype.getClassName=function(){
return "MQRouteResultsCode";
};
MQRouteResultsCode.prototype.getObjectVersion=function(){
return 0;
};
MQRouteMatrixResultsCode.prototype=new MQType();
MQRouteMatrixResultsCode.prototype.constructor=MQRouteMatrixResultsCode;
function MQRouteMatrixResultsCode(val){
var _1dc=-2;
switch(val){
case MQCONSTANT.MQROUTEMATRIXRESULTSCODE_NOT_SPECIFIED:
_1dc=val;
break;
case MQCONSTANT.MQROUTEMATRIXRESULTSCODE_SUCCESS:
_1dc=val;
break;
case MQCONSTANT.MQROUTEMATRIXRESULTSCODE_INVALID_LOCATION:
_1dc=val;
break;
case MQCONSTANT.MQROUTEMATRIXRESULTSCODE_ROUTE_FAILURE:
_1dc=val;
break;
case MQCONSTANT.MQROUTEMATRIXRESULTSCODE_NO_DATASET_FOUND:
_1dc=val;
break;
case MQCONSTANT.MQROUTEMATRIXRESULTSCODE_INVALID_OPTION:
_1dc=val;
break;
case MQCONSTANT.MQROUTEMATRIXRESULTSCODE_PARTIAL_SUCCESS:
_1dc=val;
break;
case MQCONSTANT.MQROUTEMATRIXRESULTSCODE_EXCEEDED_MAX_LOCATIONS:
_1dc=val;
break;
default:
alert(val+" is an invalid value for MQRouteMatrixResultsCode!");
throw val+" invalid value for MQRouteMatrixResultsCode!";
}
this.intValue=function(){
return _1dc;
};
}
MQRouteMatrixResultsCode.prototype.getClassName=function(){
return "MQRouteMatrixResultsCode";
};
MQRouteMatrixResultsCode.prototype.getObjectVersion=function(){
return 0;
};
MQLocationCollection.prototype=new MQObjectCollection(32678);
MQLocationCollection.prototype.constructor=MQLocationCollection;
function MQLocationCollection(){
MQObjectCollection.call(this,32678);
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getLOCATIONCOLLECTION()));
this.setM_Xpath("LocationCollection");
}
MQLocationCollection.prototype.getClassName=function(){
return "MQLocationCollection";
};
MQLocationCollection.prototype.getObjectVersion=function(){
return 0;
};
MQLocationCollection.prototype.loadXml=function(_1dd){
this.removeAll();
var _1de=MQA.createXMLDoc(_1dd);
this.setM_XmlDoc(_1de);
if(_1de!==null){
var root=_1de.documentElement;
var _1e0=root.childNodes;
var _1e1=_1e0.length;
_1e1=(_1e1<32678)?_1e1:32678;
var _1e2=0;
var loc=null;
for(var _1e4=_1e2;_1e4<_1e1;_1e4++){
if(_1e0[_1e4].nodeName==="Address"){
loc=new MQAddress();
loc.loadXml(mqXmlToStr(_1e0[_1e4]));
}else{
if(_1e0[_1e4].nodeName==="GeoAddress"){
loc=new MQGeoAddress();
loc.loadXml(mqXmlToStr(_1e0[_1e4]));
}else{
if(_1e0[_1e4].nodeName==="SingleLineAddress"){
loc=new MQSingleLineAddress();
loc.loadXml(mqXmlToStr(_1e0[_1e4]));
}
}
}
this.add(loc);
}
}
};
MQLocationCollection.prototype.saveXml=function(){
var _1e5=new Array();
_1e5[_1e5.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_1e5[_1e5.length]=this.get(i).saveXml();
}
_1e5[_1e5.length]="</"+this.getM_Xpath()+">";
var _1e8=_1e5.join("");
return _1e8;
};
MQLocationCollection.prototype.isValidObject=function(obj){
if(obj){
if(obj.getClassName()==="MQGeoAddress"||obj.getClassName()==="MQAddress"||obj.getClassName()==="MQSingleLineAddress"){
return true;
}
}
return false;
};
MQLocationCollectionCollection.prototype=new MQObjectCollection(32678);
MQLocationCollectionCollection.prototype.constructor=MQLocationCollectionCollection;
function MQLocationCollectionCollection(){
MQObjectCollection.call(this,32678);
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getLOCATIONCOLLECTIONCOLLECTION()));
this.setM_Xpath("LocationCollectionCollection");
}
MQLocationCollectionCollection.prototype.getClassName=function(){
return "MQLocationCollectionCollection";
};
MQLocationCollectionCollection.prototype.getObjectVersion=function(){
return 0;
};
MQLocationCollectionCollection.prototype.loadXml=function(_1ea){
this.removeAll();
var _1eb=MQA.createXMLDoc(_1ea);
this.setM_XmlDoc(_1eb);
if(_1eb!==null){
var root=_1eb.documentElement;
var _1ed=root.childNodes;
var _1ee=_1ed.length;
_1ee=(_1ee<32678)?_1ee:32678;
var _1ef=0;
var loc=null;
for(var _1f1=_1ef;_1f1<_1ee;_1f1++){
loc=new MQLocationCollection();
loc.loadXml(mqXmlToStr(_1ed[_1f1]));
this.add(loc);
}
}
};
MQLocationCollectionCollection.prototype.saveXml=function(){
var _1f2=new Array();
_1f2[_1f2.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_1f2[_1f2.length]=this.get(i).saveXml();
}
_1f2[_1f2.length]="</"+this.getM_Xpath()+">";
var _1f5=_1f2.join("");
return _1f5;
};
MQLocationCollectionCollection.prototype.isValidObject=function(obj){
if(obj){
if(obj.getClassName()==="MQLocationCollection"){
return true;
}
}
return false;
};
MQSignCollection.prototype=new MQObjectCollection(32678);
MQSignCollection.prototype.constructor=MQSignCollection;
function MQSignCollection(_1f7){
MQObjectCollection.call(this,32678);
if(_1f7){
this.setM_itemXpath(_1f7);
}
this.setValidClassName("MQSign");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getSIGNCOLLECTION()));
this.setM_Xpath("SignCollection");
}
MQSignCollection.prototype.getClassName=function(){
return "MQSignCollection";
};
MQSignCollection.prototype.getObjectVersion=function(){
return 0;
};
MQSignCollection.prototype.loadXml=function(_1f8){
this.removeAll();
var _1f9=MQA.createXMLDoc(_1f8);
this.setM_XmlDoc(_1f9);
if(_1f9!==null){
var root=_1f9.documentElement;
var _1fb=root.childNodes;
var _1fc=_1fb.length;
_1fc=(_1fc<32678)?_1fc:32678;
var _1fd=0;
var sign=null;
if(this.getValidClassName()==="MQSign"){
for(var _1ff=_1fd;_1ff<_1fc;_1ff++){
sign=new MQSign();
sign.setM_Xpath(this.getM_itemXpath());
sign.loadXml(mqXmlToStr(_1fb[_1ff]));
this.add(sign);
}
}
}
};
MQSignCollection.prototype.loadXmlFromNode=function(node){
var _201=mqCreateXMLDocImportNode(node);
this.setM_XmlDoc(_201);
if(_201!==null){
var root=_201.documentElement;
var _203=root.childNodes;
var _204=_203.length;
_204=(_204<32678)?_204:32678;
var _205=0;
var sign=null;
if(this.getValidClassName()==="MQSign"){
for(var _207=_205;_207<_204;_207++){
sign=new MQSign();
sign.setM_Xpath(this.getM_itemXpath());
sign.loadXmlFromNode(_203[_207]);
this.add(sign);
}
}
}
};
MQSignCollection.prototype.saveXml=function(){
var _208=new Array();
_208[_208.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_208[_208.length]=this.get(i).saveXml();
}
_208[_208.length]="</"+this.getM_Xpath()+">";
var _20b=_208.join("");
return _20b;
};
MQPointCollection.prototype=new MQObjectCollection(32678);
MQPointCollection.prototype.constructor=MQPointCollection;
function MQPointCollection(_20c){
MQObjectCollection.call(this,32678);
if(_20c){
this.setM_itemXpath(_20c);
}
this.setValidClassName("MQPoint");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getPOINTCOLLECTION()));
this.setM_Xpath("PointCollection");
}
MQPointCollection.prototype.getClassName=function(){
return "MQPointCollection";
};
MQPointCollection.prototype.getObjectVersion=function(){
return 0;
};
MQPointCollection.prototype.loadXml=function(_20d){
this.removeAll();
var _20e=MQA.createXMLDoc(_20d);
this.setM_XmlDoc(_20e);
if(_20e!==null){
var root=_20e.documentElement;
var _210=root.childNodes;
var _211=_210.length;
_211=(_211<32678)?_211:32678;
var _212=0;
var pnt=null;
if(this.getValidClassName()==="MQPoint"){
for(var _214=_212;_214<_211;_214++){
var x;
var y;
if(_210[_214].firstChild!==null){
x=_210[_214].firstChild.nodeValue;
}
_214++;
if(_210[_214].firstChild!==null){
y=_210[_214].firstChild.nodeValue;
}
pnt=new MQPoint(x,y);
this.add(pnt);
}
}
}
};
MQPointCollection.prototype.saveXml=function(){
var _217=new Array();
_217[_217.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_217[_217.length]=this.get(i).saveXml();
}
_217[_217.length]="</"+this.getM_Xpath()+">";
var _21a=_217.join("");
return _21a;
};
MQDBLayerQueryCollection.prototype=new MQObjectCollection(32678);
MQDBLayerQueryCollection.prototype.constructor=MQDBLayerQueryCollection;
function MQDBLayerQueryCollection(_21b){
MQObjectCollection.call(this,32678);
if(_21b){
this.setM_itemXpath(_21b);
}
this.setValidClassName("MQDBLayerQuery");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getSIGNCOLLECTION()));
this.setM_Xpath("DBLayerQueryCollection");
}
MQDBLayerQueryCollection.prototype.getClassName=function(){
return "MQDBLayerQueryCollection";
};
MQDBLayerQueryCollection.prototype.getObjectVersion=function(){
return 0;
};
MQDBLayerQueryCollection.prototype.loadXml=function(_21c){
this.removeAll();
var _21d=MQA.createXMLDoc(_21c);
this.setM_XmlDoc(_21d);
if(_21d!==null){
var root=_21d.documentElement;
var _21f=root.childNodes;
var _220=_21f.length;
_220=(_220<32678)?_220:32678;
var _221=0;
var sign=null;
if(this.getValidClassName()==="MQDBLayerQuery"){
for(var _223=_221;_223<_220;_223++){
sign=new MQDBLayerQuery();
sign.setM_Xpath(this.getM_itemXpath());
sign.loadXml(mqXmlToStr(_21f[_223]));
this.add(sign);
}
}
}
};
MQDBLayerQueryCollection.prototype.saveXml=function(){
var _224=new Array();
_224[_224.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_224[_224.length]=this.get(i).saveXml();
}
_224[_224.length]="</"+this.getM_Xpath()+">";
var _227=_224.join("");
return _227;
};
MQManeuverCollection.prototype=new MQObjectCollection(32678);
MQManeuverCollection.prototype.constructor=MQManeuverCollection;
function MQManeuverCollection(_228){
MQObjectCollection.call(this,32678);
if(_228){
this.setM_itemXpath(_228);
}
this.setValidClassName("MQManeuver");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getMANEUVERCOLLECTION()));
this.setM_Xpath("ManeuverCollection");
}
MQManeuverCollection.prototype.getClassName=function(){
return "MQManeuverCollection";
};
MQManeuverCollection.prototype.getObjectVersion=function(){
return 0;
};
MQManeuverCollection.prototype.loadXml=function(_229){
this.removeAll();
var _22a=MQA.createXMLDoc(_229);
this.setM_XmlDoc(_22a);
if(_22a!==null){
var root=_22a.documentElement;
var _22c=root.childNodes;
var _22d=_22c.length;
_22d=(_22d<32678)?_22d:32678;
var _22e=0;
var _22f=null;
if(this.getValidClassName()==="MQManeuver"){
for(var _230=_22e;_230<_22d;_230++){
_22f=new MQManeuver();
_22f.setM_Xpath(this.getM_itemXpath());
_22f.loadXml(mqXmlToStr(_22c[_230]));
this.add(_22f);
}
}
}
};
MQManeuverCollection.prototype.saveXml=function(){
var _231=new Array();
_231[_231.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_231[_231.length]=this.get(i).saveXml();
}
_231[_231.length]="</"+this.getM_Xpath()+">";
var _234=_231.join("");
return _234;
};
MQTrekRouteCollection.prototype=new MQObjectCollection(32678);
MQTrekRouteCollection.prototype.constructor=MQTrekRouteCollection;
function MQTrekRouteCollection(_235){
MQObjectCollection.call(this,32678);
if(_235){
this.setM_itemXpath(_235);
}
this.setValidClassName("MQTrekRoute");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getTREKROUTECOLLECTION()));
this.setM_Xpath("TrekRouteCollection");
}
MQTrekRouteCollection.prototype.getClassName=function(){
return "MQTrekRouteCollection";
};
MQTrekRouteCollection.prototype.getObjectVersion=function(){
return 0;
};
MQTrekRouteCollection.prototype.loadXml=function(_236){
this.removeAll();
var _237=MQA.createXMLDoc(_236);
this.setM_XmlDoc(_237);
if(_237!==null){
var root=_237.documentElement;
var _239=root.childNodes;
var _23a=_239.length;
_23a=(_23a<32678)?_23a:32678;
var _23b=0;
var trek=null;
if(this.getValidClassName()==="MQTrekRoute"){
for(var _23d=_23b;_23d<_23a;_23d++){
trek=new MQTrekRoute();
trek.setM_Xpath(this.getM_itemXpath());
trek.loadXml(mqXmlToStr(_239[_23d]));
this.add(trek);
}
}
}
};
MQTrekRouteCollection.prototype.saveXml=function(){
var _23e=new Array();
_23e[_23e.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_23e[_23e.length]=this.get(i).saveXml();
}
_23e[_23e.length]="</"+this.getM_Xpath()+">";
var _241=_23e.join("");
return _241;
};
MQIntCollection.prototype=new MQObjectCollection(32678);
MQIntCollection.prototype.constructor=MQIntCollection;
function MQIntCollection(_242){
MQObjectCollection.call(this,32678);
this.setValidClassName("int");
if(_242){
this.setM_itemXpath(_242);
}
if(this.getClassName()==="MQIntCollection"){
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getINTCOLLECTION()));
this.setM_Xpath("IntCollection");
}
}
MQIntCollection.prototype.getClassName=function(){
return "MQIntCollection";
};
MQIntCollection.prototype.getObjectVersion=function(){
return 0;
};
MQIntCollection.prototype.loadXml=function(_243){
this.removeAll();
var _244=MQA.createXMLDoc(_243);
this.setM_XmlDoc(_244);
if(_244!==null){
var root=_244.documentElement;
var _246=root.childNodes;
var _247=_246.length;
_247=(_247<32678)?_247:32678;
var _248=0;
var str=null;
for(var _24a=_248;_24a<_247;_24a++){
if(_246[_24a].firstChild!==null){
str=parseInt(_246[_24a].firstChild.nodeValue);
}else{
str=0;
}
this.add(str);
}
}
};
MQIntCollection.prototype.saveXml=function(){
var _24b=new Array();
_24b[_24b.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_24b[_24b.length]="<"+this.getM_itemXpath()+">"+this.get(i)+"</"+this.getM_itemXpath()+">";
}
_24b[_24b.length]="</"+this.getM_Xpath()+">";
var _24e=_24b.join("");
return _24e;
};
MQDTCollection.prototype=new MQIntCollection("Item");
MQDTCollection.prototype.constructor=MQDTCollection;
function MQDTCollection(_24f){
MQIntCollection.call(this,_24f);
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getDTCOLLECTION()));
this.setM_Xpath("DTCollection");
}
MQDTCollection.prototype.getClassName=function(){
return "MQDTCollection";
};
MQDTCollection.prototype.getObjectVersion=function(){
return 1;
};
MQFeatureCollection.prototype=new MQObjectCollection(32678);
MQFeatureCollection.prototype.constructor=MQFeatureCollection;
function MQFeatureCollection(){
MQObjectCollection.call(this,32678);
this.setValidClassName("ALL");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getFEATURECOLLECTION()));
this.setM_Xpath("FeatureCollection");
}
MQFeatureCollection.prototype.getClassName=function(){
return "MQFeatureCollection";
};
MQFeatureCollection.prototype.getObjectVersion=function(){
return 0;
};
MQFeatureCollection.prototype.loadXml=function(_250){
this.removeAll();
var _251=MQA.createXMLDoc(_250);
this.setM_XmlDoc(_251);
if(_251!==null){
var root=_251.documentElement;
var _253=root.childNodes;
var _254=_253.length;
_254=(_254<32678)?_254:32678;
var _255=0;
var feat=null;
var _257="";
for(var _258=_255;_258<_254;_258++){
_257=_253[_258].nodeName;
if(_257==="LineFeature"){
feat=new MQLineFeature();
feat.loadXml(mqXmlToStr(_253[_258]));
}else{
if(_257==="PointFeature"){
feat=new MQPointFeature();
feat.loadXmlFromNode(_253[_258]);
}else{
if(_257==="PolygonFeature"){
feat=new MQPolygonFeature();
feat.loadXml(mqXmlToStr(_253[_258]));
}
}
}
this.add(feat);
}
}
};
MQFeatureCollection.prototype.saveXml=function(){
var _259=new Array();
_259[_259.length]="<"+this.getM_Xpath()+" Version=\""+this.getObjectVersion()+"\" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_259[_259.length]=this.get(i).saveXml();
}
_259[_259.length]="</"+this.getM_Xpath()+">";
var _25c=_259.join("");
return _25c;
};
MQFeatureSpecifierCollection.prototype=new MQObjectCollection(32678);
MQFeatureSpecifierCollection.prototype.constructor=MQFeatureSpecifierCollection;
function MQFeatureSpecifierCollection(){
MQObjectCollection.call(this,32678);
this.setValidClassName("MQFeatureSpecifier");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getFEATURESPECIFIERCOLLECTION()));
this.setM_Xpath("FeatureCollection");
}
MQFeatureSpecifierCollection.prototype.getClassName=function(){
return "MQFeatureSpecifierCollection";
};
MQFeatureSpecifierCollection.prototype.getObjectVersion=function(){
return 0;
};
MQFeatureSpecifierCollection.prototype.loadXml=function(_25d){
this.removeAll();
var _25e=MQA.createXMLDoc(_25d);
this.setM_XmlDoc(_25e);
if(_25e!==null){
var root=_25e.documentElement;
var _260=root.childNodes;
var _261=_260.length;
_261=(_261<32678)?_261:32678;
var _262=0;
var feat=null;
for(var _264=_262;_264<_261;_264++){
if(_260[_264].nodeName==="FeatureSpecifier"){
feat=new MQFeatureSpecifier();
feat.loadXml(mqXmlToStr(_260[_264]));
}
this.add(feat);
}
}
};
MQFeatureSpecifierCollection.prototype.saveXml=function(){
var _265=new Array();
_265[_265.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_265[_265.length]=this.get(i).saveXml();
}
_265[_265.length]="</"+this.getM_Xpath()+">";
var _268=_265.join("");
return _268;
};
MQGeocodeOptionsCollection.prototype=new MQObjectCollection(32678);
MQGeocodeOptionsCollection.prototype.constructor=MQGeocodeOptionsCollection;
function MQGeocodeOptionsCollection(){
MQObjectCollection.call(this,32678);
this.setValidClassName("MQGeocodeOptions");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getGEOCODEOPTIONSCOLLECTION()));
this.setM_Xpath("GeocodeOptionsCollection");
}
MQGeocodeOptionsCollection.prototype.getClassName=function(){
return "MQGeocodeOptionsCollection";
};
MQGeocodeOptionsCollection.prototype.getObjectVersion=function(){
return 0;
};
MQGeocodeOptionsCollection.prototype.loadXml=function(_269){
this.removeAll();
var _26a=MQA.createXMLDoc(_269);
this.setM_XmlDoc(_26a);
if(_26a!==null){
var root=_26a.documentElement;
var _26c=root.childNodes;
var _26d=_26c.length;
_26d=(_26d<32678)?_26d:32678;
var _26e=0;
var geoO=null;
for(var _270=_26e;_270<_26d;_270++){
if(_26c[_270].nodeName==="GeocodeOptions"){
geoO=new MQGeocodeOptions();
geoO.loadXml(mqXmlToStr(_26c[_270]));
}
this.add(geoO);
}
}
};
MQGeocodeOptionsCollection.prototype.saveXml=function(){
var _271=new Array();
_271[_271.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_271[_271.length]=this.get(i).saveXml();
}
_271[_271.length]="</"+this.getM_Xpath()+">";
var _274=_271.join("");
return _274;
};
MQCoverageStyle.prototype=new MQObjectCollection(32678);
MQCoverageStyle.prototype.constructor=MQCoverageStyle;
function MQCoverageStyle(){
MQObjectCollection.call(this,32678);
this.setValidClassName("ALL");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getCOVERAGESTYLE()));
this.setM_Xpath("CoverageStyle");
}
MQCoverageStyle.prototype.getClassName=function(){
return "MQCoverageStyle";
};
MQCoverageStyle.prototype.getObjectVersion=function(){
return 0;
};
MQCoverageStyle.prototype.loadXml=function(_275){
this.removeAll();
var _276=MQA.createXMLDoc(_275);
this.setM_XmlDoc(_276);
if(_276!==null){
var root=_276.documentElement;
var _278=root.childNodes;
var _279=_278.length;
_279=(_279<32678)?_279:32678;
var _27a=0;
var dt=null;
for(var _27c=_27a;_27c<_279;_27c++){
if(_278[_27c].nodeName==="DTStyle"){
dt=new MQDTStyle();
dt.loadXml(mqXmlToStr(_278[_27c]));
}else{
if(_278[_27c].nodeName==="DTStyleEx"){
dt=new MQDTStyleEx();
dt.loadXml(mqXmlToStr(_278[_27c]));
}else{
if(_278[_27c].nodeName==="DTFeatureStyleEx"){
dt=new MQDTFeatureStyleEx();
dt.loadXml(mqXmlToStr(_278[_27c]));
}
}
}
if(dt!==null){
this.add(dt);
}
dt=null;
}
}
};
MQCoverageStyle.prototype.saveXml=function(){
var _27d=new Array();
_27d[_27d.length]="<CoverageStyle Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_27d[_27d.length]=this.get(i).saveXml();
}
_27d[_27d.length]="<Name>"+this.getProperty("Name")+"</Name>";
_27d[_27d.length]="</CoverageStyle>";
var _280=_27d.join("");
return _280;
};
MQCoverageStyle.prototype.setName=function(_281){
this.setProperty("Name",_281);
};
MQCoverageStyle.prototype.getName=function(){
return this.getProperty("Name");
};
MQPrimitiveCollection.prototype=new MQObjectCollection(32678);
MQPrimitiveCollection.prototype.constructor=MQPrimitiveCollection;
function MQPrimitiveCollection(){
MQObjectCollection.call(this,32678);
this.setValidClassName("ALL");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getPRIMITIVECOLLECTION()));
this.setM_Xpath("PrimitiveCollection");
}
MQPrimitiveCollection.prototype.getClassName=function(){
return "MQPrimitiveCollection";
};
MQPrimitiveCollection.prototype.getObjectVersion=function(){
return 0;
};
MQPrimitiveCollection.prototype.loadXml=function(_282){
this.removeAll();
var _283=MQA.createXMLDoc(_282);
this.setM_XmlDoc(_283);
if(_283!==null){
var root=_283.documentElement;
var _285=root.childNodes;
var _286=_285.length;
_286=(_286<32678)?_286:32678;
var _287=0;
var prim=null;
for(var _289=_287;_289<_286;_289++){
if(_285[_289].nodeName==="EllipsePrimitive"){
prim=new MQEllipsePrimitive();
prim.loadXml(mqXmlToStr(_285[_289]));
}else{
if(_285[_289].nodeName==="LinePrimitive"){
prim=new MQLinePrimitive();
prim.loadXml(mqXmlToStr(_285[_289]));
}else{
if(_285[_289].nodeName==="PolygonPrimitive"){
prim=new MQPolygonPrimitive();
prim.loadXml(mqXmlToStr(_285[_289]));
}else{
if(_285[_289].nodeName==="RectanglePrimitive"){
prim=new MQRectanglePrimitive();
prim.loadXml(mqXmlToStr(_285[_289]));
}else{
if(_285[_289].nodeName==="TextPrimitive"){
prim=new MQTextPrimitive();
prim.loadXml(mqXmlToStr(_285[_289]));
}else{
if(_285[_289].nodeName==="SymbolPrimitive"){
prim=new MQSymbolPrimitive();
prim.loadXml(mqXmlToStr(_285[_289]));
}
}
}
}
}
}
this.add(prim);
}
}
};
MQPrimitiveCollection.prototype.saveXml=function(){
var _28a=new Array();
_28a[_28a.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_28a[_28a.length]=this.get(i).saveXml();
}
_28a[_28a.length]="</"+this.getM_Xpath()+">";
var _28d=_28a.join("");
return _28d;
};
MQStringCollection.prototype=new MQObjectCollection(32678);
MQStringCollection.prototype.constructor=MQStringCollection;
function MQStringCollection(_28e){
MQObjectCollection.call(this,32678);
this.setValidClassName("String");
if(_28e){
this.setM_itemXpath(_28e);
}
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getSTRINGCOLLECTION()));
this.setM_Xpath("StringCollection");
}
MQStringCollection.prototype.getClassName=function(){
return "MQStringCollection";
};
MQStringCollection.prototype.getObjectVersion=function(){
return 0;
};
MQStringCollection.prototype.loadXml=function(_28f){
this.removeAll();
var _290=MQA.createXMLDoc(_28f);
this.setM_XmlDoc(_290);
if(_290!==null){
var root=_290.documentElement;
var _292=root.childNodes;
var _293=_292.length;
_293=(_293<32678)?_293:32678;
var _294=0;
var str=null;
for(var _296=_294;_296<_293;_296++){
if(_292[_296].firstChild!==null){
str=_292[_296].firstChild.nodeValue;
}else{
str="";
}
this.add(str);
}
}
};
MQStringCollection.prototype.loadXmlFromNode=function(node){
this.setM_XmlDoc(mqCreateXMLDocImportNode(node));
var _298=this.getM_XmlDoc();
if(_298!==null){
var root=_298.documentElement;
var _29a=root.childNodes;
var _29b=_29a.length;
_29b=(_29b<32678)?_29b:32678;
var _29c=0;
var str=null;
for(var _29e=_29c;_29e<_29b;_29e++){
if(_29a[_29e].firstChild!==null){
str=_29a[_29e].firstChild.nodeValue;
}else{
str="";
}
this.add(str);
}
}
};
MQStringCollection.prototype.saveXml=function(){
var _29f=new Array();
_29f[_29f.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_29f[_29f.length]="<"+this.getM_itemXpath()+">"+this.get(i)+"</"+this.getM_itemXpath()+">";
}
_29f[_29f.length]="</"+this.getM_Xpath()+">";
var _2a2=_29f.join("");
return _2a2;
};
MQStrColCollection.prototype=new MQObjectCollection(32678);
MQStrColCollection.prototype.constructor=MQStrColCollection;
function MQStrColCollection(){
MQObjectCollection.call(this,32678);
this.setValidClassName("MQStringCollection");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getSTRCOLCOLLECTION()));
}
MQStrColCollection.prototype.getClassName=function(){
return "MQStrColCollection";
};
MQStrColCollection.prototype.getObjectVersion=function(){
return 0;
};
MQStrColCollection.prototype.saveXml=function(){
var _2a3=new Array();
var size=this.getSize();
for(var i=0;i<size;i++){
_2a3[_2a3.length]=this.get(i).saveXml();
}
strRet=_2a3.join("");
return strRet;
};
MQAutoGeocodeCovSwitch.prototype=new MQObject();
MQAutoGeocodeCovSwitch.prototype.constructor=MQAutoGeocodeCovSwitch;
function MQAutoGeocodeCovSwitch(){
MQObject.call(this);
this.setM_Xpath("AutoGeocodeCovSwitch");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getAUTOGEOCODECOVSWITCH()));
}
MQAutoGeocodeCovSwitch.prototype.getClassName=function(){
return "MQAutoGeocodeCovSwitch";
};
MQAutoGeocodeCovSwitch.prototype.getObjectVersion=function(){
return 0;
};
MQAutoGeocodeCovSwitch.prototype.loadXml=function(_2a6){
this.setM_XmlDoc(MQA.createXMLDoc(_2a6));
};
MQAutoGeocodeCovSwitch.prototype.saveXml=function(){
return mqXmlToStr(this.getM_XmlDoc());
};
MQAutoGeocodeCovSwitch.prototype.setName=function(_2a7){
this.setProperty("Name",_2a7);
};
MQAutoGeocodeCovSwitch.prototype.getName=function(){
return this.getProperty("Name");
};
MQAutoGeocodeCovSwitch.prototype.setMaxMatches=function(_2a8){
this.setProperty("MaxMatches",_2a8);
};
MQAutoGeocodeCovSwitch.prototype.getMaxMatches=function(){
return this.getProperty("MaxMatches");
};
MQAutoRouteCovSwitch.prototype=new MQObject();
MQAutoRouteCovSwitch.prototype.constructor=MQAutoRouteCovSwitch;
function MQAutoRouteCovSwitch(_2a9){
MQObject.call(this);
if(this.getClassName()==="MQAutoRouteCovSwitch"){
if(_2a9){
this.setM_Xpath(_2a9);
this.setM_XmlDoc(MQA.createXMLDoc("<"+_2a9+"><Name/><DataVendorCodeUsage>0</DataVendorCodeUsage><DataVendorCodes Count=\"0\"/></"+_2a9+">"));
}else{
this.setM_Xpath("AutoRouteCovSwitch");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getAUTOROUTECOVSWITCH()));
}
}
var _2aa=new MQIntCollection();
_2aa.setM_Xpath("DataVendorCodes");
this.getDataVendorCodes=function(){
return _2aa;
};
}
MQAutoRouteCovSwitch.prototype.getClassName=function(){
return "MQAutoRouteCovSwitch";
};
MQAutoRouteCovSwitch.prototype.getObjectVersion=function(){
return 0;
};
MQAutoRouteCovSwitch.prototype.loadXml=function(_2ab){
this.setM_XmlDoc(MQA.createXMLDoc(_2ab));
var _2ac=this.getDataVendorCodes();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DataVendorCodes")!==null){
_2ac.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DataVendorCodes")));
}
};
MQAutoRouteCovSwitch.prototype.saveXml=function(){
var _2ad=MQA.createXMLDoc(this.getDataVendorCodes().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_2ad,"DataVendorCodes"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQAutoRouteCovSwitch.prototype.setName=function(_2ae){
this.setProperty("Name",_2ae);
};
MQAutoRouteCovSwitch.prototype.getName=function(){
return this.getProperty("Name");
};
MQAutoRouteCovSwitch.prototype.setDataVendorCodeUsage=function(_2af){
this.setProperty("DataVendorCodeUsage",_2af);
};
MQAutoRouteCovSwitch.prototype.getDataVendorCodeUsage=function(){
return this.getProperty("DataVendorCodeUsage");
};
MQAutoMapCovSwitch.prototype=new MQAutoRouteCovSwitch();
MQAutoMapCovSwitch.prototype.constructor=MQAutoMapCovSwitch;
function MQAutoMapCovSwitch(_2b0){
MQAutoRouteCovSwitch.call(this);
if(_2b0){
this.setM_Xpath(_2b0);
this.setM_XmlDoc(MQA.createXMLDoc("<"+_2b0+"><Name/><Style/><DataVendorCodeUsage>0</DataVendorCodeUsage><DataVendorCodes Count=\"0\"/><ZoomLevels Count=\"14\"><Item>6000</Item><Item>12000</Item><Item>24000</Item><Item>48000</Item><Item>96000</Item><Item>192000</Item><Item>400000</Item><Item>800000</Item><Item>1600000</Item><Item>3000000</Item><Item>6000000</Item><Item>12000000</Item><Item>24000000</Item><Item>48000000</Item></ZoomLevels></"+_2b0+">"));
}else{
this.setM_Xpath("AutoMapCovSwitch");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getAUTOMAPCOVSWITCH()));
}
var _2b1=new MQIntCollection();
_2b1.setM_Xpath("ZoomLevels");
_2b1.add(6000);
_2b1.add(12000);
_2b1.add(24000);
_2b1.add(48000);
_2b1.add(96000);
_2b1.add(192000);
_2b1.add(400000);
_2b1.add(800000);
_2b1.add(1600000);
_2b1.add(3000000);
_2b1.add(6000000);
_2b1.add(12000000);
_2b1.add(24000000);
_2b1.add(48000000);
this.getZoomLevels=function(){
return _2b1;
};
}
MQAutoMapCovSwitch.prototype.getClassName=function(){
return "MQAutoMapCovSwitch";
};
MQAutoMapCovSwitch.prototype.getObjectVersion=function(){
return 0;
};
MQAutoMapCovSwitch.prototype.loadXml=function(_2b2){
this.setM_XmlDoc(MQA.createXMLDoc(_2b2));
var _2b3=this.getDataVendorCodes();
if(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DataVendorCodes")!==null){
_2b3.loadXml(mqXmlToStr(mqGetNode(this.getM_XmlDoc(),"/"+this.getM_Xpath()+"/DataVendorCodes")));
}
};
MQAutoMapCovSwitch.prototype.saveXml=function(){
var _2b4=MQA.createXMLDoc(this.getDataVendorCodes().saveXml());
this.setM_XmlDoc(mqReplaceElementNode(this.getM_XmlDoc(),_2b4,"DataVendorCodes"));
return mqXmlToStr(this.getM_XmlDoc());
};
MQAutoMapCovSwitch.prototype.setStyle=function(_2b5){
this.setProperty("Style",_2b5);
};
MQAutoMapCovSwitch.prototype.getStyle=function(){
return this.getProperty("Style");
};
MQSession.prototype=new MQObjectCollection(32678);
MQSession.prototype.constructor=MQSession;
function MQSession(){
MQObjectCollection.call(this,32678);
this.setM_Xpath("Session");
this.setM_XmlDoc(MQA.createXMLDocFromNode(MQA.MQXML.getSESSION()));
}
MQSession.prototype.getClassName=function(){
return "MQSession";
};
MQSession.prototype.getObjectVersion=function(){
return 0;
};
MQSession.prototype.loadXml=function(_2b6){
var _2b7=MQA.createXMLDoc(_2b6);
this.setM_XmlDoc(_2b7);
if(_2b7!==null){
var root=_2b7.documentElement;
var _2b9=root.childNodes;
var _2ba=_2b9.length;
_2ba=(_2ba<32678)?_2ba:32678;
var _2bb=0;
var obj=null;
for(var _2bd=_2bb;_2bd<_2ba;_2bd++){
obj=null;
if(_2b9[_2bd].nodeName==="MapState"){
obj=new MQMapState();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="CoverageStyle"){
obj=new MQCoverageStyle();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="AutoMapCovSwitch"){
obj=new MQAutoMapCovSwitch();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="DBLayerQueryCollection"){
obj=new MQDBLayerQueryCollection();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="FeatureCollection"){
obj=new MQFeatureCollection();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="PrimitiveCollection"){
obj=new MQPrimitiveCollection();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="Center"){
obj=new MQCenter();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="CenterLL"){
obj=new MQCenterLL();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="ZoomIn"){
obj=new MQZoomIn();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="ZoomOut"){
obj=new MQZoomOut();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="ZoomTo"){
obj=new MQZoomTo();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="ZoomToRect"){
obj=new MQZoomToRect();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="ZoomToRectLL"){
obj=new MQZoomToRectLL();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="Pan"){
obj=new MQPan();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="BestFit"){
obj=new MQBestFit();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}else{
if(_2b9[_2bd].nodeName==="BestFitLL"){
obj=new MQBestFitLL();
obj.loadXml(mqXmlToStr(_2b9[_2bd]));
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
if(obj!==null){
this.add(obj);
}
}
}
};
MQSession.prototype.saveXml=function(){
var _2be=new Array();
_2be[_2be.length]="<"+this.getM_Xpath()+" Count=\""+this.getSize()+"\">";
var size=this.getSize();
for(var i=0;i<size;i++){
_2be[_2be.length]=this.get(i).saveXml();
}
_2be[_2be.length]="</"+this.getM_Xpath()+">";
var _2c1=_2be.join("");
return _2c1;
};
MQSession.prototype.add=function(obj){
return this.addOne(obj,null);
};
MQSession.prototype.isMapCommandObject=function(obj){
if(obj){
var cls=obj.getClassName();
if(cls==="MQCenter"||cls==="MQCenterLatLng"||cls==="MQZoomIn"||cls==="MQZoomOut"||cls==="MQZoomTo"||cls==="MQZoomToRect"||cls==="MQZoomToRectLatLng"||cls==="MQPan"||cls==="MQBestFit"||cls==="MQBestFitLL"){
return true;
}else{
return false;
}
}
};
MQSession.prototype.addOne=function(_2c5,_2c6){
var _2c7=this.getSize();
var _2c8=_2c5.getClassName();
var _2c9=0;
if(this.isValidObject(_2c5)){
if(this.isMapCommandObject(_2c5)){
for(_2c9=0;_2c9<_2c7;_2c9++){
if(isMapCommandObject(get(_2c9))){
break;
}
}
}else{
for(_2c9=0;_2c9<_2c7;_2c9++){
if(get(_2c9).getClassId()==_2c8){
break;
}
}
}
}else{
alert("Invalid object for this collection.");
throw ("Invalid object for this collection.");
}
if(_2c9<_2c7){
_2c6=this.set(_2c9,_2c5);
}else{
m_collection.add(_2c5);
}
return _2c9;
};
MQSession.prototype.isValidObject=function(obj){
if(obj){
var cls=obj.getClassName();
if(cls==="MQCenter"||cls==="MQCenterLatLng"||cls==="MQZoomIn"||cls==="MQZoomOut"||cls==="MQZoomTo"||cls==="MQZoomToRect"||cls==="MQZoomToRectLatLng"||cls==="MQPan"||cls==="MQBestFit"||cls==="MQBestFitLL"||cls==="MQDBLayerQueryCollection"||cls==="MQCoverageStyle"||cls==="MQFeatureCollection"||cls==="MQAutoMapCovSwitch"||cls==="MQPrimitiveCollection"||cls==="MQMapState"){
return true;
}else{
return false;
}
}
};
function MQAuthentication(_2cc){
var _2cd=(_2cc!=null)?_2cc:"";
this.getInfo=function(){
return _2cd;
};
}
MQAuthentication.prototype.saveXml=function(){
return "<Authentication Version=\""+this.getObjectVersion()+"\">"+"<TransactionInfo>"+this.getInfo()+"</TransactionInfo>"+"</Authentication>";
};
MQAuthentication.prototype.getClassName=function(){
return "MQAuthentication";
};
MQAuthentication.prototype.getObjectVersion=function(){
return 2;
};
function MQXmlNodeObject(_2ce,_2cf){
var _2d0=_2ce;
var _2d1=_2cf;
this.saveXml=function(){
return "<"+_2d0+">"+_2d1+"</"+_2d0+">";
};
}

