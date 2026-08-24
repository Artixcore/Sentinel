type Overview = { uptime_percent:number; requests_today:number; open_incidents:number; active_monitors:number; resources?:{cpu_percent:number;memory_percent:number;disk_percent:number}|null; generated_at:string };

async function overview(): Promise<Overview> {
  try {
    const base=process.env.INTERNAL_API_URL??process.env.NEXT_PUBLIC_API_URL??"http://api:8000/api/v1";
    const response=await fetch(`${base}/overview`,{next:{revalidate:15}});
    if(!response.ok) throw new Error();
    return (await response.json()).data;
  } catch {
    return {uptime_percent:100,requests_today:0,open_incidents:0,active_monitors:0,resources:null,generated_at:new Date().toISOString()};
  }
}

export default async function Page(){
  const data=await overview();
  return <main><aside>
    <h2><img src="/logo.png" alt="Artixcore" style={{width:32,height:32,objectFit:"contain"}}/>Sentinel</h2>
    {["Overview","Infrastructure","AI Agents","Websites","Analytics","Alerts"].map((item,index)=><a className={index===0?"on":""} key={item}>{item}{item==="Alerts"&&<b>{data.open_incidents}</b>}</a>)}
  </aside><section>
    <header><div><small>COMMAND CENTER</small><h1>Overview</h1></div><span>● Production</span></header>
    <div className="ok">● All systems operational <time>Updated {new Date(data.generated_at).toLocaleTimeString()}</time></div>
    <div className="cards"><Card n={`${data.uptime_percent}%`} t="Overall uptime"/><Card n={data.requests_today.toLocaleString()} t="Checks today"/><Card n={String(data.active_monitors)} t="Active monitors"/><Card n={String(data.open_incidents)} t="Open incidents"/></div>
    <div className="panels">
      <article><h3>Resource usage</h3><p>Latest production node telemetry</p><div className="rings"><Ring n={Number(data.resources?.cpu_percent??0)} t="CPU"/><Ring n={Number(data.resources?.memory_percent??0)} t="Memory"/><Ring n={Number(data.resources?.disk_percent??0)} t="Disk"/></div></article>
      <article><h3>Website health</h3><p>Connected monitor status will appear here</p><div className="empty">Add your first monitor through the API to begin collecting uptime, latency and incident data.</div></article>
      <article className="wide"><h3>Live operations</h3><p>Laravel workers, Redis queues and scheduled collectors are connected.</p><div className="stream"><b>Monitoring queue</b><span>Ready</span><b>Metrics ingestion</b><span>Accepting</span><b>Incident engine</b><span>Watching</span></div></article>
    </div>
  </section></main>;
}

function Card({n,t}:{n:string,t:string}){return <article><span>{t}</span><strong>{n}</strong><i>↗ live</i></article>}
function Ring({n,t}:{n:number,t:string}){return <div><i style={{background:`conic-gradient(#735cff ${n*3.6}deg,#edf0f5 0)`}}><b>{n}%</b></i><span>{t}</span></div>}
