package com.mapquest.utils;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.ProtocolException;
import java.net.URL;
import java.net.URLConnection;
import java.util.Enumeration;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.transform.Source;
import javax.xml.transform.dom.DOMSource;

import org.w3c.dom.DOMImplementation;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.w3c.dom.Text;
import org.xml.sax.SAXException;

import com.mapquest.exception.JSAPIException;

/**
 * This is a helper class, which has various methods for processing the request
 * coming from the javascript side,framing the xml to be send to the server and
 * also send method to send the xml to the server.
 *
 * @author
 *
 */
public class Helper {
   private DocumentBuilder parser;


   private DOMImplementation impl;

   private int responseCode;
   private String responseMessage = "";
   private String serverUrl = "";
   private int serverPort;
   private String serverPath = "";
   private boolean authNodePresent = false;
   private String contentType = "";
   private String sendMethod = "";

   private void setResponseContentType(String sContentType){
      contentType = sContentType;
   }
   public String getResponseContentType(){
      return contentType;
   }
   public String getResponseMessage(){
      return responseMessage;
   }
   private void setResponseMessage(String respMessg){
      responseMessage = respMessg;
   }
    public int getResponseCode(){
      return responseCode;
   }

   private void setResponseCode(int respCode){
      responseCode = respCode;
   }

   /**
    * Constructor of Helper class
    *
    * @throws ServletException
    */
   public Helper() throws ServletException {
      try {
         DocumentBuilderFactory factory = DocumentBuilderFactory
               .newInstance();
         factory.setNamespaceAware(true);

         parser = factory.newDocumentBuilder();
         impl = parser.getDOMImplementation();
      } catch (Exception e) {
         throw new ServletException("JAXP Exception", e);
      }
   }

   /**
    * This method will frame the xml to be send to the server adding the
    * clientid and password information to the Authentication node of the xml.
    *
    * @param requestDoc:
    *            Document
    * @param ClientId:
    *            String
    * @param Password:
    *            String
    * @return Document
    * @throws JSAPIException
    * @throws SAXException
    * @throws IOException
    * @throws JSAPIException
    */
   private Source frameXMLRequest(Document requestDoc, String clientId,
         String password, String faultString) throws JSAPIException {
      Document responseDoc = null;
      if (requestDoc != null) {
         responseDoc = requestDoc;
         NodeList authChildList = responseDoc
               .getElementsByTagName("Authentication");
         Node authChild = authChildList.item(0);
         if(authChild ==null){
             return (new DOMSource(requestDoc));
         } else {
             authNodePresent = true;
         }
         if (password != null) {
            // Adding Password Child
            Element passwordNode = responseDoc.createElement("Password");
            Text passwordTxt = responseDoc.createTextNode(password);
            passwordNode.appendChild(passwordTxt);
            authChild.appendChild(passwordNode);
         }

         if (clientId != null) {
            // Adding clientId child
            Element clientIdNode = responseDoc.createElement("ClientId");
            Text clientIdTxt = responseDoc.createTextNode(clientId);
            clientIdNode.appendChild(clientIdTxt);
            authChild.appendChild(clientIdNode);
         }
      } else {
         throw new JSAPIException("No XML passed to proxy page.");
      }
      return (new DOMSource(responseDoc));
   }


   /**
    * This method is used to get the server details from the input xml and set
    * it to a hashtable.
    *
    * @param requestDoc:
    *            Document
    * @throws JSAPIException
    */
   private void setServerDetails(HttpServletRequest req) throws JSAPIException {

      String errorString = null;
     try{


     if(req.getParameter("sname")!=null)
         serverUrl = req.getParameter("sname").toString();
      else
        errorString = "No server url passed.";

      if(req.getParameter("sport")!=null)
         serverPort = Integer.parseInt(req.getParameter("sport").toString());
      else
        errorString = "No server port passed.";

      if(req.getParameter("spath")!=null)
         serverPath = req.getParameter("spath").toString();
      else
        errorString = "No server path passed.";
     }catch (Exception e) {
      if(errorString == null)
         throw new JSAPIException(e.getMessage());
      else
         throw new JSAPIException(errorString);
   }
   }

   /**
    * This method is used as a wrapper for the frameXMLRequest which will frame
    * the xml to be send to the server with clientid and password added to the
    * Authentication node in the xml.
    *
    * @param requestDoc:
    *            Document
    * @param ClientId:
    *            String
    * @param Password:
    *            String
    * @return: Source
    * @throws JSAPIException
    */
   private Source frameXMLRequest(HttpServletRequest req,Document requestDoc, String clientId,
         String password) throws JSAPIException {

          setServerDetails(req);
          return frameXMLRequest(requestDoc, clientId, password, "");

   }
   /*
    *  This method will read the bytes from stream and return the bytes array
    */

   private byte[] getByteArray(InputStream ins) throws IOException{
      
       int len;
       byte[] buffer = new byte[1024];
       ByteArrayOutputStream bout = new ByteArrayOutputStream();
       while((len = ins.read(buffer)) > 0){
          bout.write(buffer,0,len);
       }
       bout.flush();                              
       return bout.toByteArray();

   }
   
   /**
    * This method is used to accept the xml to be send to the server and get
    * back the xml response and pass it to the servlet where it is transformed.
    *
    * @param xmlReq:
    *            Object
    * @return: Source
    */
   public Object sendRequestToServer(Object xmlReq,boolean isReqXml) {
      String server = null;
      Document respDoc = null;
      DOMSource response = null;
      if(authNodePresent)
        server = "http://"+serverUrl+":"+serverPort+"/"+serverPath+"/mqserver.dll?e=5";
      else if (serverPort == 0){
		server = "http://"+serverUrl +"/"+serverPath;
   	  } else {
        server = (serverPath !="")?"http://"+serverUrl+":"+serverPort+"/"+serverPath :"http://"+serverUrl+":"+serverPort;
      }
      if(sendMethod.equalsIgnoreCase("GET")){
        server = server +"?"+ xmlReq.toString();
      }
      URL u = null;
      try {
         u = new URL(server);
      } catch (MalformedURLException e) {
         setResponseCode(404);
         setResponseMessage(e.getMessage());
         return e.getMessage();
      }
      URLConnection uc = null;
      try {
         uc = u.openConnection();
      } catch (IOException e) {
         setResponseCode(404);
         setResponseMessage(e.getMessage());
         return e.getMessage();
      }
      HttpURLConnection connection = null;
      connection = (HttpURLConnection) uc;
      connection.setDoOutput(true);
      connection.setDoInput(true);
      try {
         connection.setRequestMethod(sendMethod);
      } catch (ProtocolException e) {
         setResponseCode(404);
         setResponseMessage(e.getMessage());
         return e.getMessage();
      }
      connection.setAllowUserInteraction(false);
      connection.setRequestProperty("Content-type", "text/xml");
      connection.setRequestProperty("Content-Encoding", "ISO-8859-1");

      OutputStream out = null;
      InputStream in = null;
      InputStream temp = null;
      int respCode =0;
      String respMessage = null;
      try {
         if(sendMethod.equalsIgnoreCase("POST")){
            out = connection.getOutputStream();
            out.flush();
         if(isReqXml) {
            out.write((byte[])xmlReq);
         } else {
            out.write(xmlReq.toString().getBytes());
         }
         }
         connection.connect();
         respCode = connection.getResponseCode();
         respMessage = connection.getResponseMessage();
         // setting the response code and message
         setResponseCode(respCode);
         setResponseMessage(respMessage);
         setResponseContentType(connection.getContentType());
         int nBytes = 0;
         if(connection.getContentLength() > 0){
            nBytes = connection.getContentLength();
         }
         byte b[] = new byte[nBytes];
         if(nBytes > 0){
            temp = connection.getInputStream();
            b = getByteArray(temp);
            in = new ByteArrayInputStream(b);
         } else
         {
            in = connection.getInputStream();
         }
         String respString = new String(b,"ISO-8859-1");
         if(!getResponseContentType().equalsIgnoreCase("text/html")) {
            respDoc = parser.parse(in);
            response = new DOMSource(respDoc);
         } else {
            return respString;
         }
      } catch (IOException e) {
         try {
               if(connection !=null){
               if(connection.getResponseCode()>0)
                 respCode = connection.getResponseCode();
             } else {
                 respCode = 400;
             }
             respMessage = e.getMessage();

             // setting the response code, response message and contenttype

             setResponseCode(respCode);
             setResponseMessage(respMessage);
             setResponseContentType(connection.getContentType());

            if(connection.getErrorStream() !=null){
              in = connection.getErrorStream();
            } else {
               return e.getMessage();
            }

            int ch;
            StringBuffer buf = new StringBuffer();
            temp = in;
            while ((ch = temp.read()) > -1) {
               buf.append((char) ch);
            }
            temp.close();

            String responseString = buf.toString();
            return responseString;

         }catch(Exception ee){
            setResponseCode(404);
            setResponseMessage(ee.getMessage());
            return ee.getMessage();
         }
      } catch (SAXException sax) {
            setResponseCode(500);
            setResponseMessage(sax.getMessage());
            return sax.getMessage();
      }catch (IllegalArgumentException illegalArgumentException){
            setResponseCode(500);
            setResponseMessage(illegalArgumentException.getMessage());
            return illegalArgumentException.getMessage();
      }
       finally {
         connection.disconnect();
      }
      return response;
   }

   /**
    * This method is used to process the request coming to the servlet from the
    * javascript and then frame the xml request to be send to the server
    * calling the frameXMLRequest method.
    *
    * @param req:
    *            HttpServletRequest
    * @param ClientId:
    *            String
    * @param Password:
    *            String
    * @return: Source
    * @throws JSAPIException
    */
   public Object processRequest(HttpServletRequest req, String clientId,
         String password) throws JSAPIException {

      Document requestDoc = null;
      InputStream in = null;
      InputStream temp = null;
      Source source = null;
      String buf = new String();
      int nBytes = 0;

      sendMethod = req.getMethod();
      if(sendMethod.equalsIgnoreCase("GET")){
        setServerDetails(req);
        Enumeration queryNames = req.getParameterNames();
        String name = null;
        StringBuffer queryStringPassed = new StringBuffer();
        while(queryNames.hasMoreElements()){
           name = queryNames.nextElement().toString().trim();
           if(name.equalsIgnoreCase("sname") || name.equalsIgnoreCase("spath") || name.equalsIgnoreCase("sport")){
           } else {
              queryStringPassed.append("&");
              queryStringPassed.append(name);
              queryStringPassed.append("=");
              queryStringPassed.append(req.getParameter(name).toString());
           }
        }
        return queryStringPassed.toString().replaceFirst("&","");
      }
      else
      {
        byte b[] = null;
         try {

          if(req.getContentLength() > 0){
              nBytes = req.getContentLength();
             }
              b = new byte[nBytes];

          if(nBytes > 0){
             temp = req.getInputStream();
             b = getByteArray(temp);
             in = new ByteArrayInputStream(b);
          } else
          {
             in = req.getInputStream();
          }
          requestDoc = parser.parse(in);

         } catch (IOException ioException) {
            throw new JSAPIException(ioException.getMessage());
         } catch (SAXException saxException) {
             try {
               setServerDetails(req);
               buf = new String(b,"ISO-8859-1");
            } catch(JSAPIException jsAPIException){
               throw new JSAPIException(jsAPIException.getErrorDescription());
            } catch(Exception exc){
               throw new JSAPIException(exc.getMessage());
            }

         return buf;
         }
         source = frameXMLRequest(req,requestDoc, clientId, password);

      return source;
   }
   }
}
