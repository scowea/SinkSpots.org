
Java Proxy Page Installation Instructions
---------------------------------------------

Make sure that you have the following:

1. jdk 1.4 or above

Instructions:

1. Unzip the package JSAPIProxyPage.zip and compile the java source file.
   From command prompt go to the directory where you unzipped the package.
   
   i)   make a folder named classes
   ii)  execute the following command with <path to servlet> entered
        
        javac -classpath <path to servlet.jar>/servlet.jar;. -d classes src/com/mapquest/*.java src/com/mapquest/utils/*.java src/com/mapquest/exception/*.java
   
   This will generate the compiled code inside the classes folder.
   
2. Enter the ClientId and Password in the web.xml.
    <init-param>
         <param-name>ClientId</param-name>
         <param-value>Your_ClientId</param-value>
    </init-param>
    <init-param>
         <param-name>Password</param-name>
         <param-value>Your_Password</param-value>
    </init-param>
    
3. Create an Application in your application server.

   /<ApplicationName>/ will contain the TestXML.html and utils.js
   /<ApplicationName>/WEB-INF/ contains the web.xml file.
   /<ApplicationName>/WEB-INF/classes contains the class files.
   
3. TestXML.html is a test sample to show how the geocode transaction is working with the proxy page.
4. Run the html page 
