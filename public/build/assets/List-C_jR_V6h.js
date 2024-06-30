import{o as i,f as n,t as c,a as m,u as x,w as b,F as h,Z as k,b as o,n as y,g,i as w,C as B,D as _,d as f}from"./app-Bu3FlJml.js";import{_ as S}from"./AuthenticatedLayout-ChBReSi7.js";import"./ApplicationLogo-Byx69XoI.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const I={class:"material-symbols-outlined mr-1"},v={__name:"Icon",props:{icon:{required:!0,default:""}},setup(s){return(e,a)=>(i(),n("span",I,c(s.icon),1))}};console.log(window.stream,"window.stream");const T={data(){return{text:"Hello Vue.js!"}}},M={class:"font-semibold text-xl text-gray-800 leading-tight"},R={class:"py-12"},D={class:"text-gray-600 body-font"},U={class:"container px-5 mx-auto"},P={class:"grid px-5 grid-cols-1"},C={class:"font-semibold mr-2 text-left flex-auto"},H=o("path",{d:"M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"},null,-1),A=[H],E={class:"grid grid-cols-4 gap-4"},V={class:"p-6"},L=o("option",{value:"",selected:""},"Mute",-1),j=["value"],O={class:"p-6 rounded-lg"},F={key:0,type:"button",class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center"},G={class:"container px-5 py-0 mx-auto"},z={class:"text-gray-600 body-font"},N={class:"container px-5 py-24 mx-auto"},Y={class:"flex flex-wrap -m-4"},$={class:"lg:w-1/4 md:w-1/2 p-4 w-full"},q={class:"bg-gray-100 p-6 rounded-lg block bg-white border border-gray-200"},Z={class:"block relative h-48 rounded overflow-hidden"},J={key:0,style:{position:"absolute"},class:"bg-red-500 text-white text-uppercase text-xs px-2.5 py-0.5"},K={style:{position:"absolute",bottom:"5px",right:"5px","background-color":"black"},class:"rounded-full bg-red-500 text-white text-uppercase text-xs px-2.5 py-0.5"},Q=["src"],W=["src"],X={class:"mt-4"},ee={class:"tracking-widest text-indigo-500 text-xs font-medium title-font"},te=["onClick"],se=o("h2",{class:"text-gray-900 title-font text-lg font-medium"},"File Name ",-1);let p,d=null,l=null;const oe={mixins:[T],data(){return{message:{state:"",message:""},videoUploadProgress:0,videoUploadInProgress:!1,recordButton:{micId:"",disabled:!1,inProgress:!1,text:"Start recording",error:"",success:"",mimeType:"video/mp4"},options:{mimeTypes:["video/mp4"],audioInputs:[]},recordedBlobs:[],list:[]}},computed:{recordIcon(){return this.recordButton.inProgress?"stop_circle":"radio_button_checked"}},methods:{playHere(s,e){this.list.forEach((a,t)=>{a.playHere!=null&&delete a.playHere}),this.list[e].playHere=!0},async uploadRecording(s,e){const a=new FormData;a.append("recording",s),a.append("blob_url",e);const t=await axios.post("/recordings/upload",a,{onUploadProgress:r=>{this.videoUploadProgress=r.loaded/r.total*100}});if(t.status==200){if(t.data.success){let r=t.data.recording;r.latest=!0,this.list.unshift(r),this.setMessage("success","Your video was successfully saved. You can download from below grid.")}}else this.setMessage("error","Somehow your video was failed to save although you can download from below grid first one is your recording");this.videoUploadInProgress=!1},stopRecording(){p.stop()},async startRecording(){let s=new MediaStream;if(this.recordButton.micId==""?s=await navigator.mediaDevices.getDisplayMedia({video:!0,audio:!0}):l=await navigator.mediaDevices.getDisplayMedia({video:!0,audio:!0}),this.recordButton.micId!=""){d=await navigator.mediaDevices.getUserMedia({audio:{deviceId:{exact:this.recordButton.micId}}}),s=new MediaStream,l.getVideoTracks().forEach(function(t){s.addTrack(t)});var e=new AudioContext,a=e.createMediaStreamDestination();if(l&&l.getAudioTracks().length>0){const t=e.createMediaStreamSource(l),r=e.createGain();r.gain.value=1,t.connect(r).connect(a)}if(d&&d.getAudioTracks().length>0){const t=e.createMediaStreamSource(d),r=e.createGain();r.gain.value=1,t.connect(r).connect(a)}a.stream.getAudioTracks().forEach(function(t){s.addTrack(t)})}if(console.log(s,"composedStream"),s!=null){const r={mimeType:this.recordButton.mimeType};p=new MediaRecorder(s,r),p.onstop=u=>this.handleOnStop(u),p.ondataavailable=u=>this.handleDataAvailable(u),p.start(),this.recordButton.inProgress=!0,this.recordButton.text="Stop Recording"}},handleDataAvailable(s){s.data&&s.data.size>0&&this.recordedBlobs.push(s.data)},handleOnStop(){this.videoUploadInProgress=!0,this.recordButton.inProgress=!1,this.recordButton.text="Start Recording",d!=null&&(this.clearTracks(d),d=null),l!=null&&(this.clearTracks(l),l=null),setTimeout(()=>{const s=new Blob(this.recordedBlobs,{type:this.recordButton.mimeType});this.uploadRecording(s,URL.createObjectURL(s))},1e3)},clickRecord(){this.recordButton.inProgress?this.stopRecording():(l=null,d=null,this.recordedBlobs=[],this.startRecording())},clearMessage(){this.message={state:"",message:""}},setMessage(s,e,a=!1){this.message={state:s,message:e},a&&setTimeout(()=>{this.clearMessage()},5e3)},clearTracks(s){s.getTracks().forEach(e=>{e.stop()})},async getMicrophones(){d=await navigator.mediaDevices.getUserMedia({audio:!0});let s=await navigator.mediaDevices.enumerateDevices();s.length>0&&s.forEach(e=>{e.kind=="audioinput"&&(e.deviceId=="default"&&(this.recordButton.micId=e.deviceId),this.options.audioInputs.push({id:e.deviceId,label:e.label}))}),this.clearTracks(d),d=null}},mounted(){this.getMicrophones(),this.list=this.recordings}},de=Object.assign(oe,{__name:"List",props:{recordings:{type:Array,default:[]}},setup(s){return(e,a)=>(i(),n(h,null,[m(x(k),{title:"Recordings"}),m(S,null,{header:b(()=>[o("h2",M,"Recordings "+c(e.text),1)]),default:b(()=>[o("div",R,[o("section",D,[o("div",U,[o("div",P,[e.message.message!=""?(i(),n("div",{key:0,class:y([{"bg-green-700 text-green-100":e.message.state=="success","bg-red-700 text-red-100":e.message.state=="error"},"p-2 items-center flex lg:inline-flex"]),role:"alert"},[o("span",{class:y([{"bg-green-600":e.message.state=="success","bg-red-600":e.message.state=="error"},"flex uppercase px-2 py-1 text-xs font-bold mr-3"])},c(e.message.state=="success"?"SUCCESSS":"ERROR"),3),o("span",C,c(e.message.message),1),(i(),n("svg",{class:"fill-current opacity-700 cursor-pointer h-4 w-4",onClick:a[0]||(a[0]=(...t)=>e.clearMessage&&e.clearMessage(...t)),xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20"},A))],2)):g("",!0)]),o("div",E,[o("div",null,[o("div",V,[w(o("select",{"onUpdate:modelValue":a[1]||(a[1]=t=>e.recordButton.micId=t),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"},[L,e.options.audioInputs.length>0?(i(!0),n(h,{key:0},_(e.options.audioInputs,t=>(i(),n("option",{value:t.id},c(t.label),9,j))),256)):g("",!0)],512),[[B,e.recordButton.micId]])])]),o("div",null,[o("div",O,[e.videoUploadInProgress?(i(),n("button",F,[m(v,{icon:"cloud_upload"}),f(" Uploading Your Video ")])):(i(),n("button",{key:1,type:"button",onClick:a[2]||(a[2]=(...t)=>e.clickRecord&&e.clickRecord(...t)),class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center"},[m(v,{icon:e.recordIcon},null,8,["icon"]),f(" "+c(e.recordButton.text),1)]))])])])]),o("div",G,[o("section",z,[o("div",N,[o("div",Y,[(i(!0),n(h,null,_(e.list,(t,r)=>(i(),n("div",$,[o("div",q,[o("a",Z,[t.latest!=null?(i(),n("span",J,"LATEST")):g("",!0),o("span",K,c(t.duration_text),1),t.playHere!=null?(i(),n("video",{key:1,src:t.link,controls:""},null,8,Q)):g("",!0),t.playHere==null?(i(),n("img",{key:2,alt:"ecommerce",class:"object-cover object-center w-full h-full block",src:t.thumb_path},null,8,W)):g("",!0)]),o("div",X,[o("h3",ee,[f(c(t.days_passed)+" ",1),o("span",{onClick:u=>e.playHere(u,r),class:"bg-red-500 text-white text-uppercase text-xs px-2.5 cursor-pointer py-0.5"},"Play Here",8,te)]),se])])]))),256))])])])])])])]),_:1})],64))}});export{de as default};
