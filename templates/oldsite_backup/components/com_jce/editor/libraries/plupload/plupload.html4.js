(function(window,document,plupload,undef){function getById(id){return document.getElementById(id)}plupload.runtimes.Html4=plupload.addRuntime("html4",{getFeatures:function(){return{multipart:true,canOpenDialog:navigator.userAgent.indexOf('WebKit')!==-1}},init:function(uploader,callback){uploader.bind("Init",function(up){var container=document.body,iframe,url="javascript",currentFile,input,currentFileId,fileIds=[],IE=/MSIE/.test(navigator.userAgent),mimes=[],filters=up.settings.filters,i,ext,type,y;no_type_restriction:for(i=0;i<filters.length;i++){ext=filters[i].extensions.split(/,/);for(y=0;y<ext.length;y++){if(ext[y]==='*'){mimes=[];break no_type_restriction}type=plupload.mimeTypes[ext[y]];if(type){mimes.push(type)}}}mimes=mimes.join(',');function createForm(){var form,input,bgcolor,browseButton;currentFileId=plupload.guid();fileIds.push(currentFileId);form=document.createElement('form');form.setAttribute('id','form_'+currentFileId);form.setAttribute('method','post');form.setAttribute('enctype','multipart/form-data');form.setAttribute('encoding','multipart/form-data');form.setAttribute("target",up.id+'_iframe');form.style.position='absolute';input=document.createElement('input');input.setAttribute('id','input_'+currentFileId);input.setAttribute('type','file');input.setAttribute('accept',mimes);input.setAttribute('size',1);browseButton=getById(up.settings.browse_button);if(up.features.canOpenDialog&&browseButton){plupload.addEvent(getById(up.settings.browse_button),'click',function(e){input.click();e.preventDefault()},up.id)}plupload.extend(input.style,{width:'100%',height:'100%',opacity:0,fontSize:'99px'});plupload.extend(form.style,{overflow:'hidden'});bgcolor=up.settings.shim_bgcolor;if(bgcolor){form.style.background=bgcolor}if(IE){plupload.extend(input.style,{filter:"alpha(opacity=0)"})}plupload.addEvent(input,'change',function(e){var element=e.target,name,files=[],topElement;if(element.value){getById('form_'+currentFileId).style.top=-0xFFFFF+"px";name=element.value.replace(/\\/g,'/');name=name.substring(name.length,name.lastIndexOf('/')+1);files.push(new plupload.File(currentFileId,name));if(!up.features.canOpenDialog){plupload.removeAllEvents(form,up.id)}else{plupload.removeEvent(browseButton,'click',up.id)}plupload.removeEvent(input,'change',up.id);createForm();if(files.length){uploader.trigger("FilesAdded",files)}}},up.id);form.appendChild(input);container.appendChild(form);up.refresh()}function createIframe(){var temp=document.createElement('div');temp.innerHTML='<iframe id="'+up.id+'_iframe" name="'+up.id+'_iframe" src="'+url+':&quot;&quot;" style="display:none"></iframe>';iframe=temp.firstChild;container.appendChild(iframe);iframe.onload=function(e){if(!e){e=window.event;if(!e.target){e.target=e.srcElement}}var n=e.target,el,result;if(!currentFile){return}try{el=n.contentWindow.document||n.contentDocument||window.frames[n.id].document}catch(ex){up.trigger('Error',{code:plupload.SECURITY_ERROR,message:plupload.translate('Security error.'),file:currentFile});return}result=el.documentElement.innerText||el.documentElement.textContent;if(result){currentFile.status=plupload.DONE;currentFile.loaded=1025;currentFile.percent=100;up.trigger('UploadProgress',currentFile);up.trigger('FileUploaded',currentFile,{response:result})}}}if(up.settings.container){container=getById(up.settings.container);if(plupload.getStyle(container,'position')==='static'){container.style.position='relative'}}up.bind("UploadFile",function(up,file){var form,input;if(file.status==plupload.DONE||file.status==plupload.FAILED||up.state==plupload.STOPPED){return}form=getById('form_'+file.id);input=getById('input_'+file.id);input.setAttribute('name',up.settings.file_data_name);form.setAttribute("action",up.settings.url);plupload.each(plupload.extend({name:file.target_name||file.name},up.settings.multipart_params),function(value,name){var hidden=document.createElement('input');plupload.extend(hidden,{type:'hidden',name:name,value:value});form.insertBefore(hidden,form.firstChild)});currentFile=file;getById('form_'+currentFileId).style.top=-0xFFFFF+"px";form.submit();form.parentNode.removeChild(form)});up.bind('FileUploaded',function(up){up.refresh()});up.bind('StateChanged',function(up){if(up.state==plupload.STARTED){createIframe()}if(up.state==plupload.STOPPED){window.setTimeout(function(){plupload.removeEvent(iframe,'load',up.id);iframe.parentNode.removeChild(iframe)},0)}});up.bind("Refresh",function(up){var browseButton,topElement,hoverClass,activeClass,browsePos,browseSize,inputContainer,inputFile,pzIndex;browseButton=getById(up.settings.browse_button);if(browseButton){browsePos=plupload.getPos(browseButton,getById(up.settings.container));browseSize=plupload.getSize(browseButton);inputContainer=getById('form_'+currentFileId);inputFile=getById('input_'+currentFileId);plupload.extend(inputContainer.style,{top:browsePos.y+'px',left:browsePos.x+'px',width:browseSize.w+'px',height:browseSize.h+'px'});if(up.features.canOpenDialog){pzIndex=parseInt(browseButton.parentNode.style.zIndex,10);if(isNaN(pzIndex)){pzIndex=0}plupload.extend(browseButton.style,{zIndex:pzIndex});if(plupload.getStyle(browseButton,'position')==='static'){plupload.extend(browseButton.style,{position:'relative'})}plupload.extend(inputContainer.style,{zIndex:pzIndex-1})}hoverClass=up.settings.browse_button_hover;activeClass=up.settings.browse_button_active;topElement=up.features.canOpenDialog?browseButton:inputContainer;if(hoverClass){plupload.addEvent(topElement,'mouseover',function(){plupload.addClass(browseButton,hoverClass)},up.id);plupload.addEvent(topElement,'mouseout',function(){plupload.removeClass(browseButton,hoverClass)},up.id)}if(activeClass){plupload.addEvent(topElement,'mousedown',function(){plupload.addClass(browseButton,activeClass)},up.id);plupload.addEvent(document.body,'mouseup',function(){plupload.removeClass(browseButton,activeClass)},up.id)}}});uploader.bind("FilesRemoved",function(up,files){var i,n;for(i=0;i<files.length;i++){n=getById('form_'+files[i].id);if(n){n.parentNode.removeChild(n)}}});uploader.bind("Destroy",function(up){var name,element,form,elements={inputContainer:'form_'+currentFileId,inputFile:'input_'+currentFileId,browseButton:up.settings.browse_button};for(name in elements){element=getById(elements[name]);if(element){plupload.removeAllEvents(element,up.id)}}plupload.removeAllEvents(document.body,up.id);plupload.each(fileIds,function(id,i){form=getById('form_'+id);if(form){container.removeChild(form)}})});createForm()});callback({success:true})}})})(window,document,plupload);