using System;
using System.Configuration;
using System.IO;
using System.Text;
using System.Collections;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Web;
using System.Web.SessionState;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.HtmlControls;
using System.Xml;
using System.Net;
using System.Collections.Specialized;

namespace JSAPIProxyPage
{
   /// <summary>
   ///   This class is used to get the xml data and add the clientid and password values from config file 
   ///   to the Authentication node in the xml and pass the xml string to the server and then get the response.
   /// </summary>
   public partial class proxy : System.Web.UI.Page
   {
      protected void Page_Load(object sender, System.EventArgs e)
      {
      
              String method = null;
              String strPostData = "";
              String server = null;
              Boolean hasAuthNode = false;
               // Getting the ClientId and Password from the WebConfig.xml
               String  ClientId = ConfigurationSettings.AppSettings["ClientId"];
               String  Password = ConfigurationSettings.AppSettings["Password"];
               bool isError = false;
               string errorMessage = "";
               bool isXml = true;
               String MyStr = null;
               StringBuilder queryString = new StringBuilder();
               if (ClientId.Length <= 0)
               {
                   isError = true;
                   errorMessage = "ClientId is not set";
               }
                // Getting the query parameters
               
               String sname = Request.QueryString["sname"];
               if (sname ==null || sname.Length <= 0)
               {
                   isError = true;
                   errorMessage = "No server name details passed.";                   
               }
               String sport = Request.QueryString["sport"];
               if (sport == null || sport.Length <= 0)
               {
                   isError = true;
                   errorMessage = "No server port details passed.";                   
               }

               String spath = Request.QueryString["spath"];
                
               //get the post data from the inputstream
               method = Request.RequestType;
               if (method.Equals("POST"))
               {
                   StreamReader reader = new StreamReader(Request.InputStream);
                   strPostData = reader.ReadToEnd();
               }
               else
               {
                   isXml = false;

                   String name = null;
                   String[] value = null;
                   NameValueCollection coll = Request.QueryString; 
                    // Get names of all keys into a string array.
                    String[] arr1 = coll.AllKeys;
                    int loop1 = 0;
                    for (loop1 = 0; loop1 < arr1.Length; loop1++)
                    {
                        name = arr1[loop1];
                        value = coll.GetValues(name);
                        if (name.Equals("sname") || name.Equals("spath") || name.Equals("sport"))
                        {
                        }
                        else
                        {
                            queryString.Append("&");
                            queryString.Append(name);
                            queryString.Append("=");
                            queryString.Append(value[0]);
                        }
                    }
               }
           
               if (strPostData.Length <= 0)
               {
                   isXml = false;
               }
             
              if (isError == true)
               {
                   Response.ContentType = "text/plain";
                   Response.StatusCode = 500;
                   Response.StatusDescription = errorMessage;
                   Response.Write(errorMessage);
                   Response.End();
               } 
                    
               XmlDocument objDoc = new XmlDocument();
         
               // Getting the post xml and loading it the xmldoc
               try
               {
                  objDoc.LoadXml(strPostData);
               }
               catch (XmlException ex)
               {
                   isXml = false;
               }
               if (isXml)
               {
                  try
                  {
                     XmlNodeList authNodeList = objDoc.GetElementsByTagName("Authentication");

                     XmlNode authNode = authNodeList.Item(0);
                     if (authNode != null)
                     {
                        hasAuthNode = true;
                        XmlNode clientIdNode = objDoc.CreateNode(XmlNodeType.Element, "ClientId", "");
                        clientIdNode.InnerText = ClientId;
                        authNode.AppendChild(clientIdNode);
                        XmlNode passwordNode = objDoc.CreateNode(XmlNodeType.Element, "Password", "");
                        passwordNode.InnerText = Password;
                        authNode.AppendChild(passwordNode);
                      }
                   }
                   catch (XmlException xmlexception)
                   {
                      Response.ContentType = "text/plain";
                      Response.StatusCode = 500;
                      Response.StatusDescription = "Please verify the xml passed to the proxy page.";
                      Response.Write("Please verify the xml passed to the proxy page.");
                      Response.End();
                   }
               
               StringWriter sw = new StringWriter();
               XmlTextWriter writer = new XmlTextWriter(sw);
               writer.Formatting = Formatting.None;
               objDoc.WriteTo(writer);
               MyStr = sw.ToString();
               writer.Flush();
               }
               else
               {
                  MyStr = strPostData;
               }
               byte[] byData = null;
               if (hasAuthNode == true)
               {
                   server = "http://" + sname + ":" + sport + "/" + spath + "/mqserver.dll?e=5";                   
               }
               else
               {
                   if (spath !=null)
                       server = "http://" + sname + ":" + sport + "/" + spath;
                   else
                       server = "http://" + sname + ":" + sport;                   
               }
               if (method.Equals("GET"))
               {
                   server = server + "?"+ queryString.Replace("&","",0,1);                   
               }
        
               //send data to the server
               string result = "";
               Stream newStream = null;
               System.Net.HttpWebRequest wreq = null;
               try
               {
                   wreq = (System.Net.HttpWebRequest)System.Net.WebRequest.Create(server);
                   if (method.Equals("POST"))
                   {
                       wreq.Method = "POST";
                   }
                   else
                   {
                       wreq.Method = "GET";
                   }
               wreq.ContentType="application/x-www-form-urlencoded";
               }
               catch (System.Net.WebException exception)
               {
                   Response.ContentType = "text/plain";
                   Response.StatusCode = 404;
                   Response.StatusDescription = "Connection could not be established.";
                   Response.Write("Connection could not be established.");
                   Response.End();
               }
               catch (System.UriFormatException uri)
               {
                   Response.ContentType = "text/plain";
                   Response.StatusCode = 404;
                   Response.StatusDescription = "The server url passed is not correct.";
                   Response.Write("The server url passed is not correct.");
                   Response.End();
               }
               if (method.Equals("POST"))
               {
                   // Send the data.
                   ASCIIEncoding encoding = new ASCIIEncoding();
                   byData = encoding.GetBytes(MyStr);
                   wreq.ContentLength = byData.Length;
                   newStream = wreq.GetRequestStream();
                   newStream.Write(byData, 0, byData.Length);
                   newStream.Close();
               }
               System.Net.HttpWebResponse wr = null;
               System.IO.Stream stream = null;
               try
               {
                   wr = (System.Net.HttpWebResponse)wreq.GetResponse();
               }
               catch (System.Net.WebException ex)
               {
                   try
                   {
                       HttpWebResponse r = (HttpWebResponse)ex.Response;
                       Response.ContentType = "text/plain";
                       Response.ContentEncoding = System.Text.Encoding.GetEncoding("ISO-8859-1");
                       if (r.StatusCode != null)
                           Response.StatusCode = (int)r.StatusCode;
                       else
                           Response.StatusCode = 500;
                       Response.StatusDescription = ex.Message;
                       stream = ex.Response.GetResponseStream();
                       System.Text.Encoding enc1 = System.Text.Encoding.GetEncoding("ISO-8859-1");
                       System.IO.StreamReader readStream1 = new System.IO.StreamReader(stream, enc1);
                       result = readStream1.ReadToEnd();
                       Response.Write(result);
                       Response.End();
                   }
                   catch (Exception ex1)
                   {
                       Response.ContentType = "text/plain";
                       Response.StatusDescription = ex1.Message;
                       Response.Write(result);
                       Response.End();
                   }
               }
               
               if (wr.StatusCode == System.Net.HttpStatusCode.OK)
               {
                   stream = wr.GetResponseStream();
                   System.Text.Encoding enc = System.Text.Encoding.GetEncoding("ISO-8859-1");
                   System.IO.StreamReader readStream = new System.IO.StreamReader(stream, enc);
                   result = readStream.ReadToEnd();
                   Response.ContentType = wr.ContentType;
                   Response.ContentEncoding = System.Text.Encoding.GetEncoding("ISO-8859-1");
                   Response.StatusCode = (int)wr.StatusCode;
                   Response.StatusDescription = wr.StatusDescription;
                   Response.Write(result);
                   Response.End();
               }

      }  
   }
}
