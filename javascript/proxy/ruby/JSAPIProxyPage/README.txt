    
Ruby Proxy Page Installation Instructions
---------------------------------------------

Make sure that you have the following:

1. ruby-1.8.5 version or more
2. rails-1.1.6 version or more 

Instructions:

1. Unzip the package JSAPIProxyPage.zip into a folder.
2. Follow the steps from the folder where you have ruby installed.

   1. rails <ApplicationName> 
   2. cd <ApplicationName>
   3. ruby script/generate controller jsapiproxypage
   4. ruby script/generate model jsapiproxypage
2. Enter ClientId and Password in the jsapiproxypage_controller.rb in app\controllers folder
      clientId = "Your_ClientId"
      password1 = "Your_Password"
3. Copy app\controllers\jsapiproxypage_controller.rb from the package into app\controllers folder 
   of your application.
4. Copy views\jsapiproxypage\jsapiproxypage.html and views\jsapiproxypage\mqutils.js from the package 
   into views\jsapiproxypage folder of your application
5. jsapiproxypage.html is a test sample to show how the geocode transaction works
   with the proxy page.
6. Start the server using command "ruby script/server"
7. Access the jsapiproxypage.html using the following url
   http://<server_name>:<port>/jsapiproxypage/jsapiproxypage.html   
   ( By default the server_name is localhost and port is 3000).
 

    
