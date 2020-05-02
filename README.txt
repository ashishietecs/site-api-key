-- SUMMARY --

Site Api Key module allows you to set Site API key at Site information form. 
It will also provide URL ( http://localhost/page_json/{siteapikey}/{nid} ) that responds with a JSON representation of given node of only page type.
If stored site api doesn't match with URL's siteapikey or URL's nid is not valid nid of page type then it will give you "Access denied". 

Example URL to access JSON response - If you set your siteapikey = FOOBAR and page node id is 2 then to access JSONresponse, URL will be like below -

http://localhost/page_json/FOOBAR/2

-- LINKS --
GitHub link: https://github.com/ashishietecs/site-api-key
