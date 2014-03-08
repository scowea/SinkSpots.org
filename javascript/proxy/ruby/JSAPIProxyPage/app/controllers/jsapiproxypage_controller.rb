 require 'rexml/document'
 require 'net/http'
 require 'uri'
 include REXML

class JsapiproxypageController < ApplicationController

# This method is used to parse the query parameters and form a single string removing 
# sname,spath and sport

def mq_generate_reqString(paramsPassed) #:nodoc:
   queryString = ""
   paramsPassed.each do |paramkey|
      strArray = paramkey.split('=')      
      key = strArray[0]
      if(key == 'sname' || key == 'sport' || key == 'spath') then
      else
         if(strArray[1] != nil) then
            value = strArray[1]
            queryString = queryString + "&" + key + "=" + value
         else
            queryString = queryString + "&" + key + "=";
         end
      end
   end
   length = queryString.length
   return(queryString[1,length])
end
def render_xml(xml, contentType , status = nil) #:nodoc:
   @response.headers['Content-Type'] = contentType
   render_text(xml, status)
end
def jsapiproxypage
 
 # this begin is the begin for rescue in the last which will handle all raise 
 begin  
 
 query = request.query_string
 
 method = @request.env['REQUEST_METHOD']

 isXml = 1
 hasAuth = 0
 xmlString = ''
 
 
 @params = query.split('&')
 
 snameArray = @params[0].split('=')
 sname = snameArray[1]
 
 spathArray = @params[1].split('=')
 spath = spathArray[1]
 
 sportArray = @params[2].split('=')
 sport = sportArray[1]
 
 # CLIENTID and PASSWORD (change to your clientId and password).
 clientId = "Your_ClientId"
 password1 = "Your_Password"
 
 if(method == "POST") then
   xmlInputString = request.raw_post
 else
   xmlInputString = mq_generate_reqString(@params)
   isXml = 0
 end
 
 errorString = ""
 statusCode = ""
 
 
 if(clientId == "") then
   errorString = "No clientid set in the proxy page"
   statusCode = "500"
   raise errorString
 end

 if(xmlInputString == "") then
    isXml = 0
 end
 
 begin
 
 doc = Document.new(xmlInputString)
 
 rescue REXML::ParseException => ex
   isXml = 0
 end
 
 if(isXml == 1 && xmlInputString != "") then
    root = doc.root
 
 begin
 
 authentication = root.elements["Authentication"]
 
 rescue Exception => msg1
 end 
 if(authentication != nil) then

   clientid = Element.new("ClientId")
   password = Element.new("Password")
   clientid.text = clientId
   password.text = password1 #"x9Z7A6z5" #password
   authentication.add_element(clientid)
   authentication.add_element(password)
   hasAuth = 1
 else
   hasAuth = 0
 end
 
 doc.write( output=xmlString, indent=-1, transitive=false, ie_hack=false )   

 else 
  xmlString = xmlInputString
  
 end
 
 if(hasAuth == 1) then
     url = "http://"+sname+":"+sport+"/"+spath+"/mqserver.dll?e=5"
 else
     if(spath != nil) then
        url = "http://"+sname+":"+sport+"/"+spath
     else
        url = "http://"+sname+":"+sport
     end
 end
 
 if(method == 'POST') then
 
 Net::HTTP.start(sname, sport) { |http|  
  http.request_post(url, xmlString) {|response|
   strResp = ""
   response.read_body do |str|   # read body now
      strResp = strResp + str           
   end
   render_xml strResp,response['content-type'],"#{response.code} #{response.message}"   
  } 
}
 
 else
 # for GET
 url = url + "?"+xmlString
 
  Net::HTTP.start(sname, sport) {|http|
       http.request_get(url) {|response|
             strResp = ""
             response.read_body do |str|   # read body now
               strResp = strResp + str     
             end
         render_xml strResp,response['content-type'],"#{response.code} #{response.message}"      
         
       }
       
    }
 
 end
 rescue Exception => msg
   if(errorString == "") then
      errorString = "Connection cannot be established."
      statusCode = "404"
   else
      errorString = msg      
   end
   render_text errorString,statusCode
 end 
 
# end of def
end

# end of class
end
