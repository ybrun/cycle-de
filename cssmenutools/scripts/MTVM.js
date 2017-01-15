// Copyright (C) 2009-2013 CSSMenuTools Ltd. All rights reserved.
// http://www.cssmenutools.com
// ProductID:VerticalMenu
// VERSION:2.0.3.0
// Trial copy.

/*
COMMON_STYLE:[Default Style,0,0,1,0,'Verdana,Arial,Helvetica,sans-serif',12,0,0,0,1,0,0,1,0,0,#0494F2,#FFFFFF,#0494F2,#FFFFFF,#0494F2,#0494F2,#B5EF49,#000000,#B5EF49,150,30,1,15,15,0,0,0,,,,0,1,0],[]
*/
var TeNIBWA = {
dummy:0,
MENU_NAME:'MTVM0',
TOPLEVEL_SPACING:1,
TOPLEVEL_PADDING:4,
TOPLEVEL_BORDER_WIDTH:1,
TOPLEVEL_BORDER_COLOR:'#026493',
TOPLEVEL_BG_COLOR:'#A0FFFF',
DROPDOWN_SPACING:1,
DROPDOWN_PADDING:5,
DROPDOWN_OFFSET_X:0,
DROPDOWN_OFFSET_Y:0,
DROPDOWN_OPEN_EFFECT:0,
DROPDOWN_OPEN_SPEED:10,
DROPDOWN_CLOSE_EFFECT:0,
DROPDOWN_CLOSE_SPEED:10,
DROPDOWN_DELAY:300,
DROPDOWN_SHADOW:true,
DROPDOWN_BG_COLOR:'#0494F2',
DROPDOWN_BORDER_COLOR:'#026493',
DROPDOWN_BORDER_WIDTH:1,
DROPDOWN_OPACITY:100,
USE_ABSOLUTE_POS:false,
X:0,
Y:0,
Z_INDEX:1000,
SEO_LINKS:0,
KEYBOARD:false,
LANGUAGE_RTL:false,
PREVIEW_BACKGROUND_COLOR:'#FFFFFF',
STREAM:[0,1,0,"Default Style","Unnamed","",0,'',''],
END_PARAMETERS:1,
browser:function(){var ua=navigator.userAgent.toLowerCase()
var ind=ua.indexOf('gecko')
this.mozilla=ind>0&&ua.substr(ind).length<17
this.opera=ua.indexOf('opera')>=0
this.safari=ua.indexOf('safari')>=0
this.ie=document.all&&!this.opera
this.ie6=this.ie&&ua.indexOf('msie 6')>0
this.ie7=this.ie&&ua.indexOf('msie 7')>0
this.ie8=this.ie&&ua.indexOf('msie 8')>0
this.macie=this.ie&&ua.indexOf('mac')>=0
this.winie=this.ie&&!this.macie
this.compatMode=document.compatMode=="CSS1Compat"
this.ieCanvas=this.compatMode?document.documentElement:document.body
return this},
setPathAdjustment:function(ID){var sl=''
var sc=document.getElementsByTagName('script')
for(var i=0;i<sc.length;i++){if(sc[i].innerHTML.search(ID)>-1)sl=sc[i].src}this.SCRIPT_LOCATION=sl.substr(0, sl.lastIndexOf('/')+1)},
adjustPath:function(path){var idf=path.charAt(0)
if(idf=='*'||idf=='&')return this.SCRIPT_LOCATION+path.substr(1)
return path},
isCurrent:function(r){if(!r)return false
var l=location.href.replace(/ /g,'%20')
if(r.search('//')==-1){if(r.charAt(0)=='/')
r=l.replace(/(.*\/\/[^\/]*).*/,'$1')+r
else
r=l.replace(/[^\/]*$/,'')+r}do{var r1=r
r=r1.replace(/[^\/]*\/\.\.\//,'')}while(r!=r1)
return r==l},
addLoadEvent:function(f){var done=0
function w(){if(!done){done=1
f()}}if(document.addEventListener){document.addEventListener('DOMContentLoaded', w, false)}if(this.br.ie&&window==top)(function(){try{document.documentElement.doScroll('left')}catch(e){setTimeout(arguments.callee, 0)
return}w()})()
var oldf=window.onload
if(typeof oldf!='function'){window.onload=w}else{window.onload=function(){try{oldf()}catch(e){}w()}}},
init:function(){var m=this
m.br=new m.browser
m.ID='MTVMTeNIBWA'
m.setPathAdjustment('MTVMMenu script ID:'+m.ID+' ')
m.addLoadEvent(m.onload)},
onload:function(){setTimeout('TeNIBWA.start()',0)},
start:function(){var m=this
m.currentItem=null
m.items=new Array()
m.dropdowns=new Array()
m.styles=new Array()
m.lastFoid=0
m.timeout=null
m.interval=null
m.opacity=!m.br.ie8 ? 100:100
m.filter=
m.wrapper=document.getElementById(m.ID+'Div')
m.styles["Default Style"]=1
var sPreloadTags="<ul>"
sPreloadTags+="<li class=\""+m.ID+"item1\"><a>text</a></li>"
sPreloadTags+="<li class=\""+m.ID+"item1Cur\"><a>text</a></li>"
sPreloadTags+="<li class=\""+m.ID+"item1Over\"><a>text</a></li>"
sPreloadTags+="</ul>"
var e=document.createElement('div')
e.className=m.ID+'Preload'
e.innerHTML=sPreloadTags
document.getElementsByTagName('body')[0].appendChild(e)
if(m.br.ie6)m.wrapper.getElementsByTagName('UL')[0].style.styleFloat='none'
m.dropdowns[0]=new m.dropdown(m, null, 0, 0)
var i=0, st=m.STREAM
while(i<st.length){var index=st[i++]
var n=st[i++]
var foo=m.dropdowns[index]
var fo=foo.div
if(n==0){foo.isEmpty=true
continue}fo.onmouseover=m.onmouseover
fo.onmouseout=m.onmouseout
var typeNrm=0
var typeSrv=1
var btID=m.ID+'Bt_'+index+'_'
var linkID=m.ID+'Link_'+index+'_'
var fos='<ul>'
for(var j=0;j<n;j++){var it=m.items[linkID+j]=new Object
it.btID=btID+j
it.linkID=linkID+j
it.level=foo.level
it.childOpen=0
it.foid=index
it.cfoid=st[i++]
if(it.cfoid>0)m.dropdowns[it.cfoid]=new m.dropdown(m, it, it.cfoid, foo.level+1)
var clInd=m.styles[st[i++]]
var txt=st[i++]
var title=st[i++]
it.type=st[i++]
if(it.type==typeNrm){it.cls=m.ID+'item'+clInd
var href=m.adjustPath(st[i++])
it.sel=m.isCurrent(href)
if(href)it.href='http://www.cssmenutools.com/component/content/article/98.html'
it.target=st[i++]
if(it.target.substr(0,3)=='_MT'){it.func=st[i++]
it.params=st[i++]}if(foo.level>0){txt='<a id="'+it.linkID+'" href="'+(it.href?it.href:'#')+'" target="'+it.target+'" title="'+title+'">'+txt+'</a>'
fos+='<li id="'+it.btID+'" class="'+it.cls+'">'+txt+'</li>'}}else if(it.type==typeSrv){if(foo.level>0){fos+='<li class="'+m.ID+'serv'+clInd+'" title="'+title+'"><div>'+txt+'</div></li>'}}}fos+="</ul>"
if(foo.level>0){fo.innerHTML=fos
var SBWidth=0
var items=fo.getElementsByTagName('LI')
var len=items.length
for(var j=0;j<len;j++){SBWidth=Math.max(SBWidth, items[j].offsetWidth)
if(j>0)items[j].style.marginTop=1+'px'}fo.style.width=SBWidth+'px'
fo.style.display='none'
if(m.br.ie6){fo.style.paddingTop=0
fo.children[0].style.marginTop=5+'px'}}var items=fo.getElementsByTagName('LI')
var len=items.length
for(var j=0;j<len;j++){var it=m.items[linkID+j]
if(it.type==typeSrv)continue
var btn=items[j]
var a=btn.getElementsByTagName('A')[0]
if(foo.level==0){a.id=linkID+j
btn.id=btID+j}if(it.sel){a.style.cursor='default'
while(it){var foCur=m.dropdowns[it.foid]
if(!it.selSet){it.selSet=true
if(!it.sel){it.selPar=true
btn=document.getElementById(it.btID)}btn.className=it.cls+' '+it.cls+'Cur'}it=foCur.itPar}}else{a.onmouseup=m.onmouseup}a.onfocus=function(){this.blur()};a.onclick=m.onclick}}m.updateDropdowns()},
onmouseover:function(evt){var m=TeNIBWA
m.cancelDropdownsUpdating()
var e=m.getSource(evt)
if(e)m.over(e)
else if(this!=m.wrapper){var f=this.obj
m.lastFoid=f&&f.itPar ? f.itPar.cfoid:0
m.updateDropdownsTimeLagged()}},
over:function(e){var m=this
var it=m.items[e.id]
if(it){m.currentItem=e
if(!it.sel)e.parentNode.className=it.cls+' '+it.cls+'Over'
m.lastFoid=it.cfoid?it.cfoid:it.foid
m.updateDropdownsTimeLagged()}},
onmouseout:function(evt){var m=TeNIBWA
m.cancelDropdownsUpdating()
var e=m.getSource(evt)
if(e)m.out(e)
else{m.lastFoid=0
m.updateDropdownsTimeLagged()}},
out:function(e){var m=this
var it=m.items[e.id]
if(it&&!it.sel&&!it.childOpen){if(it.selPar)e.parentNode.className=it.cls+' '+it.cls+'Cur'
else e.parentNode.className=it.cls}m.lastFoid=0
m.updateDropdownsTimeLagged()},
onmouseup:function(evt){var m=TeNIBWA
m.isdown=false
var e=m.getSource(evt)
if(e)m.clicked(e)},
clicked:function(e){var m=TeNIBWA
var it=m.items[e.id]
if(it&&it.href){m.cancelDropdownsUpdating()
m.lastFoid=0
m.updateDropdowns()
if(it.target)window.open(it.href,it.target)
else location=it.href}},
onclick:function(){return false},
updateDropdownsTimeLagged:function(){this.timeout=window.setTimeout('TeNIBWA.updateDropdowns()',300)},
cancelDropdownsUpdating:function(){window.clearTimeout(this.timeout)},
updateDropdowns:function(){var m=this
for(var i=1;i<m.dropdowns.length;i++)m.dropdowns[i].show=false
if(m.lastFoid){var f=m.dropdowns[m.lastFoid]
while(f.itPar){f.show=true
f=m.dropdowns[f.itPar.foid]}}var l=m.dropdowns.length
for(var i=1;i<l;i++){var f=m.dropdowns[i]
if(!f.show&&f.shown)f.removeDropdown()}for(var i=1;i<l;i++){var f=m.dropdowns[i]
if(f.show&&!f.shown)f.showDropdown()}},
getSource:function(evt){var e=this.br.ie?event.srcElement:evt.target
while(e&&e.tagName!='A')e=e.parentNode
return e},
getOpacity:function(i){var op=this.opacity
if(i>0)op=op*5*(6-i)/ 100
return op},
getBGColor:function(col){return col?col:'transparent'},
getTop:function(e, base){var m=this
var top=0
while(e&&((base==0&&e!=m.wrapper)||(base==1&&((e.style.position!='absolute'&&e.style.position!='relative')||e==m.wrapper))||(base==2))){top+=e.offsetTop
e=e.offsetParent
if(e&&!m.br.opera){var bw=parseInt(e.style.borderTopWidth)
if(!bw)bw=0
top+=bw}}return top},
getLeft:function(e, base, objPar){var m=this
var left=0
while(e&&((base==0&&e!=objPar&&e!=m.wrapper)||(base==1&&((e.style.position!='absolute'&&e.style.position!='relative')||e==m.wrapper))||(base==2))){left+=e.offsetLeft
e=e.offsetParent}return left},
dummy:null};TeNIBWA.dropdown=function(m, itPar, index, level){var f=this
if(level==0){f.div=m.wrapper
f.baseLeft=0
f.baseTop=1}else{f.div=document.createElement('div')
f.div.className=m.ID+'_DD'
f.div.style.position='absolute'
f.div.style.left='-10000px'
f.clip=f.div.style.clip
m.wrapper.appendChild(f.div)
f.shadows=new Array
for(var s=1;s<=4;s++){f.shadows[s]=document.createElement('div')
f.shadows[s].style.display='none'
m.wrapper.appendChild(f.shadows[s])}f.intr=false}f.m=m
f.itPar=itPar
f.show=false
f.shown=!index
f.level=level
f.div.obj=f
f.obj='TeNIBWA.fo'+index
eval(f.obj+'=f')};TeNIBWA.dropdown.prototype={showDropdown:function(){var f=this
var it=f.itPar
var fo=f.div
if(!fo||f.intr||f.isEmpty)return
var m=f.m
var e=document.getElementById(it.btID)
it.childOpen=1
f.intr=true
f.pfoid=it.foid
var docTop=(m.br.ie?m.br.ieCanvas.scrollTop:window.pageYOffset)-m.getTop(m.wrapper,2)
var docLeft=(m.br.ie?m.br.ieCanvas.scrollLeft:window.pageXOffset)-m.getLeft(m.wrapper,2)
var docHeight=m.br.ie?m.br.ieCanvas.clientHeight:window.innerHeight
var docWidth=m.br.ie?m.br.ieCanvas.clientWidth:window.innerWidth
var topLimit=docTop+2
var bottomLimit=docTop+docHeight-6
fo.style.top='-10000px'
fo.style.display='block'
f.baseWidth=fo.offsetWidth
f.baseHeight=fo.offsetHeight
var pfo=m.dropdowns[it.foid]
var offsetX=0
var offsetY=0
f.baseLeft=pfo.baseLeft+pfo.div.offsetWidth+offsetX
f.baseTop=pfo.baseTop+e.offsetTop+offsetY
if(f.baseLeft+f.baseWidth+22-docLeft>docWidth){var l=pfo.baseLeft-f.baseWidth-offsetX
if(l>=0)f.baseLeft=l}if(f.baseHeight+f.baseTop>bottomLimit){var t=bottomLimit-f.baseHeight
f.baseTop=t<topLimit ? topLimit:t}for(var i=1;i<=4;i++){var s=f.shadows[i]
s.innerHTML='.'
var ss=s.style
ss.display='none'
ss.position='absolute'
ss.left=(f.baseLeft+i)+'px'
ss.top=(f.baseTop+i)+'px'
ss.width=f.baseWidth+'px'
ss.height=f.baseHeight+'px'
ss.backgroundColor='#000000'
ss.zIndex=1000-i
var opacity=m.getOpacity(i)
ss.filter='alpha(opacity='+opacity+')'
ss.opacity=opacity/100}fo.style.display='none'
fo.style.top=f.baseTop+'px'
fo.style.left=f.baseLeft+'px'
f.animate=f.snap
f.openAnimated(0)},
removeDropdown:function(){var f=this
var it=f.itPar
it.childOpen=0
var e=document.getElementById(it.linkID)
if(e){if(it.selPar)e.parentNode.className=it.cls+' '+it.cls+'Cur'
else if(!it.sel)e.parentNode.className=it.cls}if(f.intr)return
f.intr=true
f.animate=f.snap
f.closeAnimated(100)},
hideDropdown:function(){var f=this
f.div.style.display='none'
for(var i=1;i<=4;i++){f.shadows[i].style.display='none'}},
clear:function(){var f=this},
clearClip:function(o){if(o.style.display!='none')o.style.display='block'
o.style.clip=this.m.br.ie?'rect(auto auto auto auto)':this.clip},
openAnimated:function(p){var f=this
if(p>100)p=100
var t=f.animate(f.div,p,0)
if(p==0)f.div.style.display=''
for(var i=1;i<=4;i++){var s=f.shadows[i]
f.animate(s,p,i)
if(p==0)s.style.display=''}if(p==100)f.finishAnimation(true)
else if(t)window.setTimeout(f.obj+'.openAnimated('+(p+10)+')',10)},
closeAnimated:function(p){var f=this
if(p<0)p=0
var t=f.animate(f.div,p,0)
for(var i=1;i<=4;i++){var s=f.shadows[i]
f.animate(s,p,i)}if(p==0){f.finishAnimation(false)}else if(t){window.setTimeout(f.obj+'.closeAnimated('+(p-10)+')',10)}},
finishAnimation:function(open){var f=this
if(!open)f.hideDropdown()
f.shown=open
f.intr=false
if(f.show){if(f.shown)f.clear()
else f.showDropdown()}if(!f.show&&f.shown)f.removeDropdown()},
snap:function(o,p,i){if(!p)this.div.style.display=''
this.finishAnimation(p?false:true)
return false},
dummy:null};TeNIBWA.init()
