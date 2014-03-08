    
Dot Net Proxy Page Installation Instructions
---------------------------------------------

Make sure that you have the following:

1. IIS 5.0.
2. .Net Framework installed.


Instructions:

1. Unzip the package JSAPIProxyPage.zip into wwwroot of Inetpub.
2. Configure it as an application.
3. Enter ClientId and Password in the end of Web.config in
   <appSettings>
      <add key="ClientId" value="Your_ClientId"/>
      <add key="Password" value="Your_Password"/>
   </appSettings>
4. TestXML.html is a test sample to show how the geocode transaction is working with the proxy page.
5. Access the TestXML.html with the following url
   http://<server-path>/JSAPIProxyPage/TestXML.html.
   

    
