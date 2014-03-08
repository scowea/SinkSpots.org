package {
	import flash.display.Sprite;
	import flash.net.URLRequest;
	import flash.display.Loader;
	import flash.events.Event;
	import flash.events.ErrorEvent;
	import flash.events.IOErrorEvent;
	import flash.events.SecurityErrorEvent;
	import flash.external.ExternalInterface;
	import com.mapquest.JSLoader;
	import flash.utils.Timer;
	import flash.events.TimerEvent;
      
	public class AAPIProxy extends Sprite
	{    
		// Client Configuration file values. 
		private var _clientConfigURL:String = null; 
		private var _initCompleteFunction:String = null;
	    private var _clientConfigId:String = null;
	    private var _clientConfigPassword:String = null;
		
		public function AAPIProxy():void 
		{
			var parameters:Object = this.stage.loaderInfo.parameters;
			
			ExternalInterface.addCallback("sendRequest", sendRequest);
			ExternalInterface.addCallback("getClientConfigURL", getClientConfigURL);

			// Set Config URL if one was passed 
			if ( parameters.hasOwnProperty("clientConfigURL") ) { 
				_clientConfigURL = parameters.clientConfigURL; 
			}   
			
			// Set InitCompleteFunction if one was passed 
			if ( parameters.hasOwnProperty("initCompleteFunction") ) { 
				_initCompleteFunction = parameters.initCompleteFunction; 
			}   
			
			// Get config data - if a URL is present
			if (_clientConfigURL) { 
				var loader:JSLoader = new JSLoader();
				loader.addEventListener(Event.COMPLETE, onLoadConfigCompelete), 
		        loader.addEventListener(IOErrorEvent.IO_ERROR, onLoadConfigError);
		        loader.addEventListener(SecurityErrorEvent.SECURITY_ERROR, onLoadConfigError);
		        
		        loader.callbackSuccess = _initCompleteFunction;
		        loader.callbackFailure = _initCompleteFunction;
		        
				loader.load(new URLRequest(_clientConfigURL)); 
			}
			else {
    		_clientConfigId = "YOUR_ID";		
				_clientConfigPassword = "YOUR_PASSWORD";	
				
				// If no config call was made then status must be ok.
				initComplete(_initCompleteFunction, 0);
			}
		} 

		/**
		* Return Config Url
		**/
		private function getClientConfigURL():String {
			return _clientConfigURL;
		}
	
		private function initComplete(callback:String, status:Number):void {
			if(ExternalInterface.available && callback) {
				ExternalInterface.call(callback, status); 
			}			
		}

		/**
		 * onLoadConfigCompelete 
		 */
		private function onLoadConfigCompelete(evt:Event):void{
			var configXML:XML = new XML(JSLoader(evt.currentTarget).data);
		
			if ( configXML.hasOwnProperty("ClientConfigId") ) {
			    _clientConfigId = configXML.ClientConfigId;
			}
			else {
			    _clientConfigId = null;
			}
			
			if ( configXML.hasOwnProperty("ClientConfigPassword") ) {
			    _clientConfigPassword = configXML.ClientConfigPassword;
			}
			else {
			    _clientConfigPassword = null;
			}

			// Call back with success 
			initComplete(JSLoader(evt.currentTarget).callbackSuccess, 0);
		}
	
		
		/**
		 * Error loading the configuration file - Clear all variables.
		 */
		private function onLoadConfigError(evt:ErrorEvent):void{
		    _clientConfigId = null;
		    _clientConfigPassword = null;
			
			// Call back with failure
			initComplete(JSLoader(evt.currentTarget).callbackFailure, -1);

		}
		
		/**
		 * Send request 
		 */
		private function sendRequest(url:String, xmlString:String, 
									callbackSuccess:String,
									callbackFailure:String):void {

			// Convert XML to string. 
			var reqXML:XML = new XML(xmlString);
 
			// Add password and client id.
			reqXML.Authentication.appendChild(<ClientId>{_clientConfigId}</ClientId>);
			reqXML.Authentication.appendChild(<Password>{_clientConfigPassword}</Password>);
			  
			// Create request.
			var req:URLRequest = new URLRequest(url);
			req.method = "POST";
			req.data = reqXML;
  
			// Create loader object with all the requesting data so that the 
			// resulting event can figure out who called it.
			var loader:JSLoader = new JSLoader();
			loader.callbackSuccess = callbackSuccess;
			loader.callbackFailure = callbackFailure;
			
			// Add listeners.
			loader.addEventListener(Event.COMPLETE, onRequestSuccess);
			loader.addEventListener(SecurityErrorEvent.SECURITY_ERROR, onRequestError);
			loader.addEventListener(IOErrorEvent.IO_ERROR, onRequestError);
			loader.addEventListener(IOErrorEvent.NETWORK_ERROR, onRequestError);
			loader.addEventListener(IOErrorEvent.VERIFY_ERROR, onRequestError);
			loader.addEventListener(IOErrorEvent.DISK_ERROR, onRequestError);

			// Load
			loader.load(req);
		}
		
		// Handle successful request.
		private function onRequestSuccess(evt:Event):void {
			ExternalInterface.call(JSLoader(evt.currentTarget).callbackSuccess, JSLoader(evt.currentTarget).data);			
		}
		
		// Handle failed request.
		private function onRequestError(evt:ErrorEvent):void {
			ExternalInterface.call(JSLoader(evt.currentTarget).callbackFailure, evt.text);			
		}
	}
}
