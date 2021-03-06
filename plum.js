	try
	{
		function getParameterByName(name, url) {
			if (!url) url = window.location.href;
			name = name.replace(/[\[\]]/g, "\\$&");
			var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
				results = regex.exec(url);
			if (!results) return null;
			if (!results[2]) return '';
			return decodeURIComponent(results[2].replace(/\+/g, " "));
		}
	
		function getCustIDFooter() {
			custID="";
			
			var s=jQuery(".ehostfooter",window.parent.document).html();
			if (s == null) {
				return "";
			}
			var n1 = s.indexOf("user:");
			var n2=s.indexOf("-->",n1);
			s=s.substring(n1+5,n2).trim();
			n1=s.indexOf(".");
			s=s.substring(0,n1);
			
			custID=s;
			return custID;
		}
	
		function getCustomerID() {
			custID="";
			if (jQuery('.find-field-controls',window.parent.document).data('auto-complete')!=undefined) {
				if (jQuery('.find-field-controls',window.parent.document).data('auto-complete')!="") {
					custID=jQuery('.find-field-controls',window.parent.document).data('auto-complete')['queryParams']['filters']['0']['values'][0];
				}
				else
				{
					custID=getCustIDFooter();
				}
			}
			else
			{
				custID=getCustIDFooter();
			}
			return custID;
		}
		
		
		var myVar=setInterval("loadPlumXwidget()",500);
	
		function loadPlumXwidget(){
			if (!window.jQuery) {
				return;
			}
			clearInterval(myVar); //clean interval
			var insertedWidgetsCount = 0;
			//document.domain="ebscohost.com";
			
			//hide widget
			jQuery.support.cors = true;
			jQuery('.related-info-area:contains("plumx")',window.parent.document).css('display','none');
			// process as soon as main doc is loaded
			jQuery(window.parent.document).ready(function(){
				// process the customer id from autocomplete
				var custid=getCustomerID();
							
				jQuery('a[id^="link"]',window.parent.document).each(function(index) {
					//get the url of the link
					// check if it's a plumx custom link
					var objPlumX=jQuery(this);
					// console.log(objPlumX.attr('href'));
					var url='';
					try {
					    url=decodeURIComponent(objPlumX.attr('href'));
					}
					catch (e) {
					    console.log(e); // 把例外物件傳給錯誤處理器
					    console.log(`failed URL: ${objPlumX.attr('href')}`);
					}
					
					var l=jQuery(this).html();
					
						if (l.indexOf("plumx")>0) {
							
							var params=url.substring(url.lastIndexOf("doi"));
							
							// parse doi or/and isbn
							var paramsObj=JSON.parse('{"' + decodeURI(params).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}');
							var doi= getParameterByName("doi", url);
							var isbn=getParameterByName("isbn", url);
							var pmid=getParameterByName("PMID", url);
							var db_an=getParameterByName("ebsco_db_an_match_id", url);

							var urlPlumX="https://plu.mx/a/";

							//add customer id
							urlPlumX=urlPlumX+"?ebsco-client="+custid;
							
							//generate the link based on the doi/isbn
							if (doi!="")
							{
								//urlPlumX=urlPlumX+"?"+doi 
								urlPlumX=urlPlumX+"&doi="+doi;
							}
							if (pmid!="")
							{
								//urlPlumX=urlPlumX+"?"+isbn ;
								urlPlumX=urlPlumX+"&pmid="+pmid ;
							}
							if (isbn!="")
							{
								//urlPlumX=urlPlumX+"?"+isbn ;
								urlPlumX=urlPlumX+"&isbn="+isbn ;
							}
							
							// only send ebsco_db_an_match_id if none of the other parameters exists
							if ((doi=="") && (pmid=="") && (isbn=="")) {
								urlPlumX=urlPlumX+"&ebsco_db_an_match_id="+db_an ;
							}

							insertedWidgetsCount++;
							// insert hover				
							objPlumX.attr("href",urlPlumX);
							objPlumX.attr("data-badge","true"); // text added
							objPlumX.attr("data-hide-when-empty","true"); // hide if no metrics exist
							objPlumX.attr("class","plumx-plum-print-popup");

							// 2017-05-26 
							// define if it will show on the left or right of the link - RTL support
							if (parent.ep.isPageRTL()==undefined ) 
							{
								objPlumX.attr("data-popup","right");
							}
							else
							{
								// change RTL only in result list
								if ((parent.ep.isPageRTL()!=false) && (parent.ep.relativeRequestPath=="results")) 
								{
									objPlumX.attr("data-popup","left");
								}
								else
								{
									objPlumX.attr("data-popup","right");
								}
							}
							
						}
					});
					if (insertedWidgetsCount > 0) {
						// insert plumx popup js file 
						var pluJS="http://120.55.89.193/eds/plumx/widget-popup.js"; // no cache busting needed, caching is actually desirable here
						window.parent.document.getElementsByTagName('body')[0].appendChild(document.createElement('script')).setAttribute('src',pluJS);
					}
					//
					// change few rules on the css

					var cssPlumx='<style>\
							.PlumX-Popup { margin-top: -17px  !important; }\
							.PlumX-Popup .ppp-container > a {height: 50px !important;}\
							.plx-print {width:50px !important; height: 50px !important;}\
							.plx-wrapping-print-link {margin: 0px !important; } \
							.PlumX-Popup .ppp-pop-right {left: 60px !important; top: -38px !important;}\
							.record-icon ~ div {overflow: visible !important;}\
							</style>';
							
					jQuery('.resultList',window.parent.document).append(cssPlumx);
					
			});

		};
	}
	catch (err)
	{
	//	console.log(err.Message);
	}