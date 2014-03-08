/**
 *
 */
package com.mapquest;

import java.io.BufferedWriter;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.io.PrintWriter;
import java.io.StringWriter;
import java.io.Writer;

import javax.servlet.ServletConfig;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.xml.transform.OutputKeys;
import javax.xml.transform.Result;
import javax.xml.transform.Source;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.stream.StreamResult;

import com.mapquest.exception.JSAPIException;
import com.mapquest.utils.Helper;

/**
 * @author
 *
 */
public class JSReqHandler extends HttpServlet {

   private static final long serialVersionUID = 1L;


   private static String Password = null;

   private static String ClientId = null;


   /**
    * init method
    *
    * @throws ServletException
    */
   public void init(ServletConfig config) throws ServletException {
      super.init(config);
      loadClientParameters();
   }

   /**
    * doGet method
    *
    * @param HttpServletRequest
    * @param HttpServletResponse
    *
    * @throws ServletException
    * @throws IOException
    */
   public void doGet(HttpServletRequest req, HttpServletResponse res)
         throws ServletException, IOException {
      doPost(req, res);
   }

   /**
    * doPost method
    *
    * @param HttpServletRequest
    * @param HttpServletResponse
    *
    * @throws ServletException
    * @throws IOException
    */
   public void doPost(HttpServletRequest req, HttpServletResponse res)
         throws ServletException, IOException {
      Helper helper = new Helper();
      Source input = null;
      boolean isJSAPIException = false;
      int responseCode =0;
      String respTxt = null;
      String strReq = null;
      String responseMessage =null;
      String responseContentType = null;
      Object obj1 = null;
      boolean isReqXml = false;
      try {
         obj1 =helper.processRequest(req, ClientId, Password);
      } catch (JSAPIException jsapiexception) {
         isJSAPIException = true;
         responseCode = 500;
         respTxt = jsapiexception.getErrorDescription();
         responseMessage = respTxt;
      }
      if(obj1 instanceof Source){

         input = (Source)obj1;
         isReqXml = true;
      } else{

         strReq = (String)obj1;
         isReqXml = false;
      }
      PrintWriter printWriter = res.getWriter();
      StringWriter stringWriter = new StringWriter();
      ByteArrayOutputStream byteArrayoutput = new ByteArrayOutputStream();
      PrintWriter out = new PrintWriter(byteArrayoutput);
      Writer writer = new BufferedWriter(new OutputStreamWriter(byteArrayoutput,"ISO-8859-1"));
      Result output = new StreamResult(writer);
      Result output1 = new StreamResult(printWriter);

      TransformerFactory tFactory = null;
      Transformer transformer = null;
      Source resOut =null;
      Object xmlReq1 = null;
      try {
         if(!isJSAPIException){
            tFactory = TransformerFactory.newInstance();
            transformer = tFactory.newTransformer();
            if(isReqXml){
               transformer.setOutputProperty( OutputKeys.ENCODING, "ISO-8859-1" );
               transformer.transform(input, output);
               byteArrayoutput.close();
               stringWriter.close();
               xmlReq1 = byteArrayoutput.toByteArray();

            } else {
               xmlReq1 = strReq.toString();
            }

            Object obj = helper.sendRequestToServer(xmlReq1,isReqXml);
            if(obj instanceof Source){
               resOut = (Source)obj;
            } else{
               respTxt = (String)obj;
            }

            responseCode = helper.getResponseCode();
            responseMessage = helper.getResponseMessage();
            responseContentType = helper.getResponseContentType();
         }
         if(responseCode>0){
            res.setStatus(responseCode,responseMessage);
         }
          if(resOut instanceof Source){
            res.setContentType(responseContentType);
            res.addHeader("Content-Encoding","ISO-8859-1");
            transformer.setOutputProperty(OutputKeys.ENCODING,"ISO-8859-1");
            transformer.transform(resOut, output1);
         } else {
            res.setContentType(responseContentType);
            printWriter.println(respTxt);

         }

      } catch (TransformerException e) {
         throw new ServletException(e);
      } catch (Exception ex){
         throw new ServletException(ex);
      }

      res.flushBuffer();
      out.flush();
   }
  /*
   * This method is used to get the ClientId and Password from the web.xml
  */
   private void loadClientParameters(){
      ClientId = getInitParameter("ClientId");
      Password = getInitParameter("Password");
   }

}
