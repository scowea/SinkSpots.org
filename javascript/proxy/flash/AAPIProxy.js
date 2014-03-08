var _mqAAPISwf = null;
var _mqAAPIConfig = null;
var _mqAAPIReady = false;
var _mqAAPICount = 0;
var _mqAAPIQueue = null;
var _mqAAPICallbacks = {};


//-------------------------------------------------------------------------------------
function mqInitAAPIProxy() {
  _mqAAPISwf = null;

  div = document.getElementById('AAPIProxyDiv');
  if (div == null) {
    var body = document.getElementsByTagName("body")[0];
    div = document.createElement('div');
    div.id = 'AAPIProxyDiv';
    div.style.width = "0px";
    div.style.height = "0px";
    div.style.position = "absolute";
    body.appendChild(div);
  }
  
  var _aapiSwf = new SWFObject("AAPIProxy.swf", "aapiProxySwfObject", "1", "1", "9", "#ffffff");
  _aapiSwf.addVariable("aapiDiv", 'AAPIProxyDiv');
  _aapiSwf.addVariable("initCompleteFunction", "onAAPIProxyInit");
  _aapiSwf.addVariable("clientConfigURL", _mqAAPIConfig);
  //_aapiSwf.addParam("allowScriptAccess", "always");
  _aapiSwf.write(div);

  _mqAAPISwf = document.getElementById("aapiProxySwfObject");
}
  

//------------------------------------------------------------------------------------
function onAAPIProxyInit(status) {
  if (status != 0) {
    alert("Unable to initialize AAPIProxy");
  } else {
    _mqAAPIReady = true;
    emptyAAPIProxyQueue();
  }
}


//------------------------------------------------------------------------------------
function emptyAAPIProxyQueue() {
	if (_mqAAPIQueue != null) {
		for (var i = 0; i < _mqAAPIQueue.length; i++) {
			_mqAAPIQueue[i].proxy.send(_mqAAPIQueue[i].body);
		}
	  _mqAAPIQueue = null;
	}
}
  
  
//================Proxy class that closely matches XMLHTTPRequest==========================
//=========================================================================================
var AAPIProxy = function(configURL) {
  if (configURL != _mqAAPIConfig) {
  	_mqAAPIConfig = configURL;
  	mqInitAAPIProxy();
  }

  var self = this;
  var _url = null;
  var id = _mqAAPICount++;  	
   
  _mqAAPICallbacks[id] = this; 
  
  
  //---------------------------------------------------------
  this.open = function(method, url, async, user, password) { 
    if (method == null || method.toLowerCase() != "post") {
      alert("AAPIProxy requires method of 'POST'");
    }
    if (async != null && async != true) {
      alert("AAPIProxy must be asynchronous");
    }
    _url = url;
  }
    
  
  //-------------------------------------------------------
  this.send = function(body) {
  	if (_mqAAPIReady) {
  		_mqAAPISwf.sendRequest(_url, body, "_mqAAPICallbacks["+id+"].onSuccess", "_mqAAPICallbacks["+id+"].onFail");
  	} else {
  		if (_mqAAPIQueue == null) {
  			_mqAAPIQueue = new Array();
  		}
			_mqAAPIQueue.push({proxy:this, body:body});
  	}
  }

  
  //-------------------------------------------------------
  this.onSuccess = function (response) {
    self.responseText = response;
            
    if (self.onload) {
      self.onload();
    }
    _mqAAPICallbacks[id] = null;
    
  };
  
  
  //--------------------------------------------------------
  this.onFail = function (error) {
    self.responseError = error;
            
    if (self.onerror) {
      self.onerror();
    }
    _mqAAPICallbacks[id] = null;
  };
    
  this.setRequestHeader = function() { alert("not supported"); }
  this.getRequestHeader = function() { alert("not supported"); }
  this.getResponseHeader = function(a) { alert("not supported"); }
  this.getAllResponseHeaders = function() { alert("not supported"); }
  this.abort = function() { alert("not supported"); }
  this.addEventListener = function(a, b, c) { alert("not supported"); }
  this.dispatchEvent = function(e) { alert("not supported"); }
  this.openRequest = function(a, b, c, d, e) { this.open(a, b, c, d, e); }
  this.overrideMimeType = function(e) { alert("not supported"); }
  this.removeEventListener = function(a, b, c) { alert("not supported"); }
}