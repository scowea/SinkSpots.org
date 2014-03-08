package com.mapquest.exception;


/**
 * This class provides methods to provide customised error messages.
 * @author        
 * @version 0.1
 */

public class JSAPIException extends Exception {
  
	   private static final long serialVersionUID = 1L;
	   private String errorDescription;
	    
	    public JSAPIException(String errorDescription) {
	        this.errorDescription = errorDescription;
	    }
	    
	    public String getErrorDescription() {
	        return errorDescription;
	    }

	    public void setErrorDescription(String errorDescription) {
	        this.errorDescription = errorDescription;
	    }
}

