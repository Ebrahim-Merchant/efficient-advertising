<?php
/**
 * Single Product Template — Wooden Backdrop (Merged V10)
 * Best of single-product.php (dark hero, Gotham, PHP data)
 * + single-product-wooden-backdrop.php (features, tabs, accordion, CTA)
 * Efficient Advertising LLC, Dubai, UAE | Merged: 2026-03-17
 *
 * @package Efficient_Dev
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>
<style>
:root {
  --bg:#F7F5F0; --bg-dark:#EDE9DF; --bg-card:#FFFFFF;
  --bg-dark1:#1A1A2E; --bg-dark2:#0F0F1E; --bg-dark3:#0A0A14;
  --amber:#FFBA09; --amber-dk:#E5A800; --amber-pale:#FFF8E1;
  --amber-ring:rgba(255,186,9,0.40);
  --tx:#1A1A2E; --tx-2:#374151; --tx-muted:#64748B;
  --tx-light:rgba(255,255,255,0.85);
  --green:#25D366; --border:rgba(26,26,46,0.10);
  --shadow-sm:0 2px 14px rgba(26,26,46,0.07);
  --shadow-md:0 6px 32px rgba(26,26,46,0.12);
  --r-sm:10px; --r-md:20px; --r-lg:28px; --r-pill:100px;
  --cream:#F7F5F0; --navy:#1A1A2E;
}
/* Base */
.sp-page { font-family:'Gotham',sans-serif; background:var(--bg); color:var(--tx); line-height:1.65; overflow-x:hidden; margin-top:100px; }
.sp-page h1,.sp-page h2,.sp-page h3,.sp-page h4 { font-family:'Gotham',sans-serif; }
.container { max-width:1200px; margin:0 auto; padding:0 20px; width:100%; box-sizing:border-box; }
/* Reveal */
.reveal { opacity:0; transform:translateY(28px); transition:opacity .55s ease,transform .55s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
/* Labels */
.sec-label { font-family:'Gotham',sans-serif; font-size:10px; font-weight:600; letter-spacing:2px; text-transform:uppercase; color:var(--tx); background:var(--amber-pale); border:1.5px solid var(--amber-ring); padding:7px 18px; border-radius:var(--r-pill); display:inline-block; margin-bottom:22px; }
.sec-label-dark { font-family:'Gotham',sans-serif; font-size:10px; font-weight:600; letter-spacing:2px; text-transform:uppercase; color:var(--amber); background:rgba(255,186,9,0.10); border:1.5px solid rgba(255,186,9,0.28); padding:7px 18px; border-radius:var(--r-pill); display:inline-block; margin-bottom:22px; }
/* Buttons */
.btn-amber-solid { display:inline-flex; align-items:center; justify-content:center; gap:10px; background:var(--amber); color:var(--tx); font-family:'Gotham',sans-serif; font-size:15px; font-weight:700; padding:0 24px; height:52px; border-radius:var(--r-sm); border:none; cursor:pointer; transition:background .2s,transform .2s; text-decoration:none; white-space:nowrap; }
.btn-amber-solid:hover { background:var(--amber-dk); transform:translateY(-2px); color:var(--tx); }
.btn-outline-amber { display:inline-flex; align-items:center; justify-content:center; gap:10px; background:transparent; color:var(--amber); font-family:'Gotham',sans-serif; font-size:15px; font-weight:600; padding:0 24px; height:52px; border-radius:var(--r-sm); border:1.5px solid rgba(255,186,9,0.50); cursor:pointer; transition:background .2s,border-color .2s,transform .2s; text-decoration:none; white-space:nowrap; }
.btn-outline-amber:hover { background:rgba(255,186,9,0.10); border-color:var(--amber); transform:translateY(-2px); color:var(--amber); }
.btn-outline-white { display:inline-flex; align-items:center; justify-content:center; gap:10px; background:transparent; color:rgba(255,255,255,0.80); font-family:'Gotham',sans-serif; font-size:13px; font-weight:600; padding:9px 22px; border-radius:var(--r-sm); border:1.5px solid rgba(255,255,255,0.18); cursor:pointer; transition:background .2s,border-color .2s,transform .2s; text-decoration:none; white-space:nowrap; }
.btn-outline-white:hover { background:rgba(255,255,255,0.06); border-color:rgba(255,255,255,0.40); transform:translateY(-2px); color:#fff; }
/* Breadcrumb */
#ea-pg-breadcrumb { background:#0A0A14; border-bottom:1px solid rgba(255,255,255,0.06); padding:13px 0; position:relative; z-index:1; }
.ea-breadcrumb { display:flex; align-items:center; flex-wrap:wrap; list-style:none; margin:0; padding:0; }
.ea-breadcrumb li { display:flex; align-items:center; font-family:'Gotham',sans-serif; font-size:13px; color:rgba(255,255,255,0.40); }
.ea-breadcrumb li a { color:rgba(255,255,255,0.50); text-decoration:none; transition:color .2s; }
.ea-breadcrumb li a:hover { color:var(--amber); }
.ea-breadcrumb li.active { color:rgba(255,255,255,0.82); font-weight:500; }
.ea-breadcrumb .sep { margin:0 8px; color:rgba(255,255,255,0.18); font-size:11px; }
/* Dark Hero */
#ea-pg-hero { background:#0F0F1E; padding:clamp(36px,4vw,72px) 0 clamp(48px,5vw,90px); position:relative; overflow:hidden; }
#ea-pg-hero::before { content:''; position:absolute; inset:0; pointer-events:none; z-index:0; background:radial-gradient(ellipse at 0% 50%,rgba(255,186,9,0.05) 0%,transparent 50%),radial-gradient(ellipse at 100% 20%,rgba(255,186,9,0.04) 0%,transparent 45%); }
.ea-pg-hero-grid { display:grid; grid-template-columns:1fr 1fr; gap:clamp(28px,4vw,60px); align-items:start; position:relative; z-index:1; }
@media(max-width:991px){.ea-pg-hero-grid{grid-template-columns:1fr;}}
.ea-pg-main-img { width:100%; aspect-ratio:4/3; border-radius:var(--r-md); overflow:hidden; border:1px solid rgba(255,255,255,0.08); background:#0A0A14; position:relative; cursor:zoom-in; }
.ea-pg-main-img img { width:100%; height:100%; object-fit:cover; transition:transform 0.6s cubic-bezier(0.25,0.46,0.45,0.94); display:block; }
.ea-pg-main-img:hover img { transform:scale(1.04); }
.ea-pg-zoom-btn { position:absolute; top:14px; right:14px; width:34px; height:34px; border-radius:50%; background:rgba(10,10,20,0.70); backdrop-filter:blur(6px); display:flex; align-items:center; justify-content:center; border:1px solid rgba(255,255,255,0.14); cursor:pointer; transition:background .2s; }
.ea-pg-zoom-btn:hover { background:rgba(255,186,9,0.25); }
.ea-pg-thumbs { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-top:12px; }
.ea-pg-thumb { aspect-ratio:1; border-radius:var(--r-sm); overflow:hidden; border:2px solid transparent; background:#0A0A14; cursor:pointer; transition:border-color .2s,transform .2s; }
.ea-pg-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
.ea-pg-thumb:hover { border-color:rgba(255,186,9,0.50); transform:translateY(-2px); }
.ea-pg-thumb.active { border-color:var(--amber); }
.ea-pg-category-pill { display:inline-block; font-family:'Gotham',sans-serif; font-size:9px; font-weight:600; letter-spacing:2px; text-transform:uppercase; color:var(--amber); background:rgba(255,186,9,0.10); border:1px solid rgba(255,186,9,0.25); padding:5px 14px; border-radius:var(--r-pill); margin-bottom:14px; }
.ea-pg-title { font-family:'Gotham',sans-serif; font-size:clamp(26px,2.8vw,44px); font-weight:800; line-height:1.2; color:#fff; margin:0 0 14px; letter-spacing:-0.5px; }
.ea-pg-short-desc { font-family:'Gotham',sans-serif; font-size:clamp(14px,1.1vw,16px); color:rgba(255,255,255,0.68); line-height:1.75; margin:0 0 24px; }
.ea-pg-spec-badges { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:28px; }
.ea-pg-badge { display:flex; align-items:center; gap:6px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.10); border-radius:var(--r-sm); padding:7px 12px; font-family:'Gotham',sans-serif; }
.ea-pg-badge-label { font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:var(--amber); opacity:0.75; display:block; line-height:1; }
.ea-pg-badge-value { font-size:13px; font-weight:600; color:rgba(255,255,255,0.88); display:block; line-height:1.3; margin-top:2px; }
/* Config panel (dark) */
.ea-pg-config { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:var(--r-md); padding:clamp(18px,2vw,26px); margin-bottom:24px; }
.ea-pg-config-title { font-family:'Gotham',sans-serif; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:rgba(255,255,255,0.50); margin-bottom:20px; display:flex; align-items:center; gap:8px; }
.ea-pg-config-title::after { content:''; flex:1; height:1px; background:rgba(255,255,255,0.08); }
.ea-pg-option-group { margin-bottom:20px; }
.ea-pg-option-label { font-family:'Gotham',sans-serif; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:rgba(255,255,255,0.42); margin-bottom:10px; display:flex; align-items:center; gap:8px; }
.ea-pg-option-label span { font-family:'Gotham',sans-serif; font-size:13px; font-weight:600; text-transform:none; letter-spacing:0; color:rgba(255,255,255,0.82); }
.ea-pg-option-btns { display:flex; flex-wrap:wrap; gap:8px; }
.ea-pg-opt-btn { padding:10px 18px; background:rgba(255,255,255,0.04); border:1.5px solid rgba(255,255,255,0.14); border-radius:var(--r-sm); font-family:'Gotham',sans-serif; font-size:13px; font-weight:500; color:rgba(255,255,255,0.72); cursor:pointer; transition:border-color .18s,background .18s,color .18s,box-shadow .18s; text-align:center; }
.ea-pg-opt-btn:hover { border-color:var(--amber); background:rgba(255,186,9,0.10); color:#fff; box-shadow:0 0 0 3px rgba(255,186,9,0.15); }
.ea-pg-opt-btn.selected,.ea-pg-opt-btn.active { border-color:var(--amber); background:rgba(255,186,9,0.18); color:#fff; font-weight:700; box-shadow:0 0 0 3px rgba(255,186,9,0.20); }
.ea-pg-qty-row { display:flex; align-items:center; gap:10px; margin-bottom:20px; }
.ea-pg-qty-label { font-family:'Gotham',sans-serif; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:rgba(255,255,255,0.42); flex-shrink:0; }
.ea-pg-qty-wrap { display:flex; align-items:center; background:rgba(255,255,255,0.04); border:1.5px solid rgba(255,255,255,0.12); border-radius:var(--r-sm); overflow:hidden; }
.ea-pg-qty-btn { width:38px; height:38px; background:none; border:none; color:rgba(255,255,255,0.60); font-size:18px; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .15s,color .15s; }
.ea-pg-qty-btn:hover { background:rgba(255,186,9,0.12); color:var(--amber); }
.ea-pg-qty-num { width:52px; text-align:center; background:none; border:none; border-left:1px solid rgba(255,255,255,0.08); border-right:1px solid rgba(255,255,255,0.08); font-family:'Gotham',sans-serif; font-size:15px; font-weight:700; color:#fff; padding:8px 0; outline:none; -moz-appearance:textfield; }
.ea-pg-qty-num::-webkit-outer-spin-button,.ea-pg-qty-num::-webkit-inner-spin-button{-webkit-appearance:none;}
.ea-pg-cta-row { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:28px; align-items:stretch; }
.ea-pg-cta-row > * { flex:1; min-width:140px; height:52px; }
.ea-pg-wa-link { display:inline-flex; align-items:center; justify-content:center; gap:9px; background:var(--green); color:#fff; font-family:'Gotham',sans-serif; font-size:14px; font-weight:700; height:52px; border-radius:var(--r-sm); text-decoration:none; transition:background .2s,transform .2s; }
.ea-pg-wa-link:hover { background:#1ebe57; transform:translateY(-2px); color:#fff; }
/* CTA section buttons */
.btn-cta-primary { display:inline-flex; align-items:center; justify-content:center; gap:9px; background:var(--amber); color:var(--tx); font-family:'Gotham',sans-serif; font-size:15px; font-weight:700; padding:0 28px; height:52px; border-radius:var(--r-sm); border:none; cursor:pointer; transition:background .2s,transform .2s; text-decoration:none; white-space:nowrap; }
.btn-cta-primary:hover { background:var(--amber-dk); transform:translateY(-2px); }
.btn-cta-wa { display:inline-flex; align-items:center; justify-content:center; gap:9px; background:var(--green); color:#fff; font-family:'Gotham',sans-serif; font-size:15px; font-weight:700; padding:0 28px; height:52px; border-radius:var(--r-sm); border:none; text-decoration:none; transition:background .2s,transform .2s; white-space:nowrap; }
.btn-cta-wa:hover { background:#1ebe57; transform:translateY(-2px); color:#fff; }
/* Related grid */
.ea-pg-rel-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
@media(max-width:767px){.ea-pg-rel-grid{grid-template-columns:1fr;}}
@media(max-width:991px) and (min-width:768px){.ea-pg-rel-grid{grid-template-columns:repeat(2,1fr);}}
.ea-pg-rel-card { display:flex; flex-direction:column; background:var(--surface); border:1px solid var(--border); border-radius:var(--r-md); overflow:hidden; text-decoration:none; transition:transform .25s,box-shadow .25s; }
.ea-pg-rel-card:hover { transform:translateY(-6px); box-shadow:0 16px 40px rgba(0,0,0,0.25); }
.ea-pg-rel-img { position:relative; aspect-ratio:4/3; overflow:hidden; background:#0A0A14; }
.ea-pg-rel-img img { width:100%; height:100%; object-fit:cover; transition:transform .4s; display:block; }
.ea-pg-rel-card:hover .ea-pg-rel-img img { transform:scale(1.06); }
.ea-pg-rel-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.45); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity .25s; }
.ea-pg-rel-card:hover .ea-pg-rel-overlay { opacity:1; }
.ea-pg-rel-overlay span { color:#fff; font-family:'Gotham',sans-serif; font-size:13px; font-weight:700; letter-spacing:1px; text-transform:uppercase; border:1.5px solid #fff; padding:8px 18px; border-radius:20px; }
.ea-pg-rel-body { padding:18px 20px 20px; flex:1; display:flex; flex-direction:column; }
.ea-pg-rel-body h4 { font-family:'Gotham',sans-serif; font-size:15px; font-weight:700; color:#fff; margin:0 0 6px; }
.ea-pg-rel-cat { font-family:'Gotham',sans-serif; font-size:12px; color:rgba(255,255,255,0.45); margin:0 0 14px; flex:1; }
.ea-pg-rel-cta { display:inline-flex; align-items:center; gap:6px; font-family:'Gotham',sans-serif; font-size:12px; font-weight:700; color:var(--amber); text-transform:uppercase; letter-spacing:0.8px; }
.ea-pg-rel-placeholder { width:100%; height:100%; background:linear-gradient(135deg,#1a1a2e,#2a2a4e); }
.sp-see-all-wrap { text-align:center; margin-top:40px; }
.sp-see-all { display:inline-flex; align-items:center; gap:8px; font-family:'Gotham',sans-serif; font-size:14px; font-weight:700; color:var(--amber); border:1.5px solid rgba(255,186,9,0.40); padding:12px 28px; border-radius:var(--r-sm); text-decoration:none; transition:background .2s,border-color .2s; }
.sp-see-all:hover { background:rgba(255,186,9,0.08); border-color:var(--amber); }
.ea-pg-trust { display:none; }
.ea-pg-trust-item { display:flex; align-items:center; gap:8px; font-family:'Gotham',sans-serif; font-size:12px; font-weight:600; color:rgba(255,255,255,0.55); }
.ea-pg-trust-item .trust-ico { width:28px; height:28px; border-radius:50%; background:rgba(255,186,9,0.10); border:1px solid rgba(255,186,9,0.20); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.ea-pg-trust-item .trust-ico svg { fill:var(--amber); width:13px; height:13px; }
/* Trust bar */
#ea-pg-trust-bar { background:#161628; border-top:2px solid rgba(255,186,9,0.25); border-bottom:1px solid rgba(255,255,255,0.08); padding:48px 0; }
#ea-pg-trust-bar > .container { max-width:100%; padding:0 clamp(24px,5vw,80px); }
#ea-pg-trust-bar .trust-bar-inner { display:flex; flex-wrap:wrap; justify-content:space-around; align-items:center; gap:32px 0; }
#ea-pg-trust-bar .ea-pg-trust-item { color:#ffffff; font-size:clamp(16px,1.4vw,20px); font-weight:800; gap:16px; letter-spacing:0.2px; }
#ea-pg-trust-bar .trust-ico { width:54px; height:54px; border-radius:50%; background:rgba(255,186,9,0.15); border:2px solid rgba(255,186,9,0.40); flex-shrink:0; }
#ea-pg-trust-bar .trust-ico svg { width:22px; height:22px; }
/* Features */
#ea-pg-features { background:var(--bg); padding:clamp(56px,6vw,100px) 0; }
.ea-pg-features-header { text-align:center; margin-bottom:clamp(36px,4vw,56px); }
.ea-pg-features-header h2 { font-family:'Gotham',sans-serif; font-size:clamp(22px,2.4vw,38px); font-weight:800; color:#1A1A2E; margin:0 0 12px; }
.ea-pg-features-header p { font-family:'Gotham',sans-serif; font-size:clamp(14px,1vw,16px); color:rgba(26,26,46,0.58); max-width:520px; margin:0 auto; }
.ea-pg-features-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:clamp(14px,2vw,24px); }
@media(max-width:991px){.ea-pg-features-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:575px){.ea-pg-features-grid{grid-template-columns:1fr;}}
.ea-pg-feature-card { background:#fff; border:1px solid rgba(26,26,46,0.08); border-radius:var(--r-md); padding:clamp(20px,2vw,30px); text-align:center; box-shadow:var(--shadow-sm); transition:border-color .25s,background .25s,transform .25s; }
.ea-pg-feature-card:hover { border-color:rgba(255,186,9,0.30); background:rgba(255,186,9,0.04); transform:translateY(-4px); }
.ea-pg-feature-ico { width:52px; height:52px; border-radius:var(--r-sm); background:rgba(255,186,9,0.10); border:1px solid rgba(255,186,9,0.20); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.ea-pg-feature-ico svg { fill:var(--amber); width:24px; height:24px; }
.ea-pg-feature-card h4 { font-family:'Gotham',sans-serif; font-size:clamp(14px,1.1vw,17px); font-weight:700; color:#1A1A2E; margin:0 0 8px; }
.ea-pg-feature-card p { font-family:'Gotham',sans-serif; font-size:clamp(13px,0.95vw,15px); color:rgba(26,26,46,0.60); line-height:1.65; margin:0; }
/* Specs tabbed */
#ea-pg-specs { background:#fff; padding:clamp(56px,6vw,100px) 0; }
.ea-pg-specs-inner { max-width:1100px; margin:0 auto; }
.ea-pg-specs-header { margin-bottom:clamp(32px,3.5vw,52px); }
.ea-pg-specs-header h2 { font-family:'Gotham',sans-serif; font-size:clamp(26px,2.6vw,42px); font-weight:800; color:#1A1A2E; margin:0 0 12px; }
.ea-pg-specs-header p { font-family:'Gotham',sans-serif; font-size:clamp(15px,1.1vw,18px); color:rgba(26,26,46,0.65); }
.ea-pg-tabs { display:flex; gap:4px; flex-wrap:wrap; margin-bottom:28px; border-bottom:2px solid rgba(26,26,46,0.10); padding-bottom:0; }
.ea-pg-tab { font-family:'Gotham',sans-serif; font-size:15px; font-weight:600; color:rgba(26,26,46,0.55); padding:12px 24px; background:none; border:none; border-bottom:3px solid transparent; cursor:pointer; transition:color .2s,border-color .2s; margin-bottom:-2px; }
.ea-pg-tab:hover { color:rgba(26,26,46,0.85); }
.ea-pg-tab.active { color:var(--amber-dk); border-bottom-color:var(--amber); font-weight:700; }
.ea-pg-tab-panel { display:none; }
.ea-pg-tab-panel.active { display:block; }
.ea-pg-spec-table { width:100%; border-collapse:collapse; }
.ea-pg-spec-table tr { border-bottom:1px solid rgba(26,26,46,0.08); }
.ea-pg-spec-table tr:last-child { border-bottom:none; }
.ea-pg-spec-table td { font-family:'Gotham',sans-serif; font-size:clamp(15px,1.1vw,17px); padding:18px 20px; vertical-align:top; line-height:1.7; }
.ea-pg-spec-table td:first-child { color:var(--amber-dk); font-weight:700; width:36%; white-space:nowrap; }
.ea-pg-spec-table td:last-child { color:rgba(26,26,46,0.80); }
.ea-pg-spec-table tr:nth-child(odd) td { background:rgba(26,26,46,0.025); }
/* Artwork / HTO */
#ea-pg-artwork { background:var(--bg); padding:clamp(56px,6vw,100px) 0; }
.ea-pg-hto-grid { display:grid; grid-template-columns:1fr 1fr; gap:clamp(36px,5vw,80px); align-items:start; }
@media(max-width:767px){.ea-pg-hto-grid{grid-template-columns:1fr;}}
.ea-pg-hto-left h2 { font-family:'Gotham',sans-serif; font-size:clamp(22px,2.4vw,38px); font-weight:800; color:#1A1A2E; margin:0 0 12px; }
.ea-pg-hto-left>p { font-family:'Gotham',sans-serif; font-size:clamp(14px,1vw,16px); color:rgba(26,26,46,0.58); margin:0 0 38px; }
.ea-pg-steps { display:flex; flex-direction:column; gap:24px; }
.ea-pg-step { display:flex; gap:18px; align-items:flex-start; }
.ea-pg-step-num { font-family:'Gotham',sans-serif; font-size:11px; font-weight:700; color:var(--tx); background:rgba(255,186,9,0.14); border:1px solid rgba(255,186,9,0.30); border-radius:8px; min-width:36px; height:36px; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:2px; }
.ea-pg-step-body h4 { font-family:'Gotham',sans-serif; font-size:16px; font-weight:700; color:#1A1A2E; margin:0 0 4px; }
.ea-pg-step-body p { font-family:'Gotham',sans-serif; font-size:14px; color:rgba(26,26,46,0.60); line-height:1.65; margin:0; }
.ea-pg-artwork-card { background:#fff; border:1.5px dashed rgba(255,186,9,0.30); border-radius:var(--r-md); padding:clamp(28px,3vw,44px); }
.ea-pg-artwork-card h3 { font-family:'Gotham',sans-serif; font-size:clamp(18px,1.6vw,26px); font-weight:800; color:#1A1A2E; margin:0 0 10px; }
.ea-pg-artwork-card>p { font-family:'Gotham',sans-serif; font-size:14px; color:rgba(26,26,46,0.60); line-height:1.65; margin:0 0 28px; }
.ea-pg-file-specs { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:28px; }
.ea-pg-file-spec { background:rgba(26,26,46,0.04); border:1px solid rgba(26,26,46,0.08); border-radius:8px; padding:9px 14px; font-family:'Gotham',sans-serif; }
.ea-pg-file-spec .fs-label { font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:var(--amber-dk); display:block; margin-bottom:3px; }
.ea-pg-file-spec .fs-val { font-size:13px; font-weight:600; color:#1A1A2E; }
.ea-pg-artwork-actions { display:flex; gap:12px; margin-top:10px; }
.ea-pg-artwork-actions .btn-wa-art { background:var(--green) !important; color:#fff !important; flex:1; display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:13px 22px; border-radius:var(--r-sm); font-family:'Gotham',sans-serif; font-size:13px; font-weight:700; text-decoration:none; }
.ea-pg-artwork-actions .btn-email-art { flex:1; border:1.5px solid #1A1A2E; color:#1A1A2E; display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:13px 22px; border-radius:var(--r-sm); font-family:'Gotham',sans-serif; font-size:13px; font-weight:700; text-decoration:none; transition:background .2s; }
.ea-pg-artwork-actions .btn-email-art:hover { background:rgba(26,26,46,0.06); }
@media(max-width:575px){.ea-pg-artwork-actions{flex-direction:column;}}
/* Pricing */
.sp-pricing-section { padding:80px 0; background:#fff; }
.sp-sec-hdr { text-align:center; margin-bottom:50px; }
.sp-sec-hdr h2 { font-family:'Gotham',sans-serif; font-size:32px; color:var(--tx); margin-bottom:15px; }
.sp-sec-hdr p { font-family:'Gotham',sans-serif; color:var(--tx-muted); }
.sp-pricing-wrap { overflow-x:auto; }
.sp-pricing-tbl { width:100%; border-collapse:collapse; background:#fff; border:1px solid var(--border); }
.sp-pricing-tbl th { background:var(--tx); color:#fff; padding:15px; text-align:left; font-family:'Gotham',sans-serif; font-size:14px; }
.sp-pricing-tbl td { padding:15px; border-bottom:1px solid var(--border); font-family:'Gotham',sans-serif; font-size:14px; }
.sp-pricing-tbl tr:hover td { background:var(--bg); }
.sp-rq-badge { background:var(--amber-pale); color:var(--amber-dk); padding:4px 10px; border-radius:4px; font-size:12px; font-weight:700; }
.sp-price-wa { background:var(--green); color:#fff; padding:8px 15px; border-radius:5px; text-decoration:none; font-family:'Gotham',sans-serif; font-weight:700; font-size:13px; }
.sp-pricing-note { margin-top:16px; font-family:'Gotham',sans-serif; font-size:13px; color:var(--tx-muted); }
.sp-pricing-note a { color:var(--amber-dk); }
/* Related */
#ea-pg-related { background:var(--cream); padding:clamp(56px,6vw,100px) 0; }
.ea-pg-related-header { display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:clamp(32px,3.5vw,52px); }
.ea-pg-related-header h2 { font-family:'Gotham',sans-serif; font-size:clamp(22px,2.4vw,38px); font-weight:800; color:#1A1A2E; margin:0; }
.ea-pg-related-see-all { font-family:'Gotham',sans-serif; font-size:13px; font-weight:700; color:var(--amber-dk); text-decoration:none; display:flex; align-items:center; gap:5px; transition:gap .2s; }
.ea-pg-related-see-all:hover { gap:8px; }
.ea-pg-related-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:clamp(14px,2vw,24px); }
@media(max-width:767px){.ea-pg-related-grid{grid-template-columns:1fr;}}
@media(max-width:991px) and (min-width:768px){.ea-pg-related-grid{grid-template-columns:repeat(2,1fr);}}
.ea-pg-rel-card { background:#fff; border:1px solid rgba(26,26,46,0.08); border-radius:var(--r-md); overflow:hidden; transition:border-color .25s,transform .25s,box-shadow .25s; text-decoration:none; display:block; }
.ea-pg-rel-card:hover { border-color:rgba(255,186,9,0.30); transform:translateY(-4px); box-shadow:0 16px 48px rgba(0,0,0,0.12); }
.ea-pg-rel-img { aspect-ratio:16/9; overflow:hidden; background:#F0EEE8; }
.ea-pg-rel-img img { width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.55s cubic-bezier(0.25,0.46,0.45,0.94); }
.ea-pg-rel-card:hover .ea-pg-rel-img img { transform:scale(1.05); }
.ea-pg-rel-body { padding:clamp(16px,1.5vw,22px); }
.ea-pg-rel-cat { font-family:'Gotham',sans-serif; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:var(--amber-dk); display:block; margin-bottom:8px; }
.ea-pg-rel-body h4 { font-family:'Gotham',sans-serif; font-size:clamp(14px,1.1vw,17px); font-weight:700; color:#1A1A2E; margin:0 0 6px; }
.ea-pg-rel-body p { font-family:'Gotham',sans-serif; font-size:13px; color:rgba(26,26,46,0.60); line-height:1.65; margin:0 0 16px; }
.ea-pg-rel-link { display:inline-flex; align-items:center; gap:6px; font-family:'Gotham',sans-serif; font-size:13px; font-weight:700; color:rgba(26,26,46,0.55); text-decoration:none; transition:color .2s,gap .2s; }
.ea-pg-rel-link:hover { color:var(--amber); gap:9px; }
/* Reviews */
.reviews { padding:clamp(80px,8vw,140px) 0; background:#0A0A14; border-top:1px solid rgba(255,255,255,0.08); }
.reviewshadow { max-width:1400px; margin:0 auto; padding:0 clamp(20px,4vw,60px); }
.reviews .creative_heading h2 { color:#fff; font-family:'Gotham',sans-serif; font-size:clamp(24px,2.8vw,42px); font-weight:800; margin-bottom:40px; text-align:center; }
/* Force trustindex widget full-width, remove Bootstrap row/col constraints */
.reviews .row { display:block; margin:0; width:100%; max-width:100%; }
.reviews .col { padding:0; width:100%; max-width:100%; flex:none; }
.reviews [class*="ti-widget"] { width:100% !important; max-width:100% !important; }
.reviews [class*="ti-review-item"] { min-height:220px !important; }
.reviews [class*="ti-stars"] svg, .reviews [class*="ti-stars"] i { width:20px !important; height:20px !important; font-size:20px !important; }
.reviews [class*="ti-review-body"] { font-size:15px !important; line-height:1.7 !important; }
.reviews [class*="ti-review-header"] { font-size:15px !important; }
/* FAQ */
#ea-pg-faq { background:var(--amber); padding:clamp(56px,6vw,100px) 0; position:relative; overflow:hidden; }
#ea-pg-faq::before { content:''; position:absolute; inset:0; z-index:0; pointer-events:none; background:radial-gradient(ellipse at 5% 50%,rgba(255,255,255,0.10) 0%,transparent 55%),radial-gradient(ellipse at 95% 20%,rgba(0,0,0,0.06) 0%,transparent 45%); }
#ea-pg-faq .container { position:relative; z-index:1; }
.ea-pg-faq-grid { display:grid; grid-template-columns:1fr 2fr; gap:clamp(36px,5vw,80px); align-items:start; }
@media(max-width:767px){.ea-pg-faq-grid{grid-template-columns:1fr;}}
.ea-pg-faq-left h2 { font-family:'Gotham',sans-serif; font-size:clamp(24px,2.8vw,44px); font-weight:800; color:var(--tx); margin:0 0 14px; line-height:1.2; }
.ea-pg-faq-left p { font-family:'Gotham',sans-serif; font-size:clamp(14px,1vw,16px); color:rgba(26,26,46,0.65); line-height:1.7; margin:0 0 28px; }
.btn-wa-faq { display:inline-flex; align-items:center; gap:9px; background:var(--green); color:#fff; font-family:'Gotham',sans-serif; font-size:14px; font-weight:700; padding:13px 26px; border-radius:var(--r-sm); text-decoration:none; transition:background .2s,transform .2s; margin-top:4px; }
.btn-wa-faq:hover { background:#1ebe57; color:#fff; transform:translateY(-2px); }
.ea-pg-acc-item { border-bottom:1px solid rgba(26,26,46,0.14); }
.ea-pg-acc-item:first-child { border-top:1px solid rgba(26,26,46,0.14); }
.ea-pg-acc-trigger { width:100%; background:none; border:none; cursor:pointer; display:flex; align-items:center; justify-content:space-between; gap:16px; padding:20px 0; text-align:left; }
.ea-pg-acc-q { font-family:'Gotham',sans-serif; font-size:clamp(14px,1.1vw,17px); font-weight:700; color:var(--tx); flex:1; }
.ea-pg-acc-icon { width:28px; height:28px; border-radius:50%; background:#1A1A2E; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all .3s; }
.ea-pg-acc-icon svg { stroke:#fff; fill:none; width:14px; height:14px; transition:transform .3s; }
.ea-pg-acc-item.open .ea-pg-acc-icon { background:var(--amber); }
.ea-pg-acc-item.open .ea-pg-acc-icon svg { stroke:#1A1A2E; transform:rotate(45deg); }
.ea-pg-acc-body { max-height:0; overflow:hidden; transition:max-height .35s cubic-bezier(0.4,0,0.2,1),padding .35s; padding:0; }
.ea-pg-acc-item.open .ea-pg-acc-body { max-height:400px; padding-bottom:20px; }
.ea-pg-acc-answer { font-family:'Gotham',sans-serif; font-size:clamp(13px,0.95vw,15px); color:rgba(26,26,46,0.72); line-height:1.75; margin:0; }
/* CTA */
#ea-pg-cta { background:var(--bg-dark1); padding:clamp(52px,5.5vw,90px) 0; position:relative; overflow:hidden; }
#ea-pg-cta::before { content:''; position:absolute; inset:0; z-index:0; pointer-events:none; background:radial-gradient(ellipse at 50% 50%,rgba(255,186,9,0.08) 0%,transparent 60%); }
.ea-pg-cta-inner { position:relative; z-index:1; text-align:center; max-width:760px; margin:0 auto; }
.ea-pg-cta-inner h2 { font-family:'Gotham',sans-serif; font-size:clamp(24px,2.8vw,44px); font-weight:800; color:#fff; margin:0 0 14px; line-height:1.2; }
.ea-pg-cta-inner p { font-family:'Gotham',sans-serif; font-size:clamp(14px,1.1vw,17px); color:rgba(255,255,255,0.58); line-height:1.7; margin:0 0 36px; }
.ea-pg-cta-btns { display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:14px; }
.ea-pg-cta-note { margin-top:20px; font-family:'Gotham',sans-serif; font-size:12px; color:rgba(255,255,255,0.30); letter-spacing:0.3px; }
/* Sticky bar */
.ea-sticky-bar { display:none; position:fixed; bottom:0; left:0; right:0; z-index:9999; background:#0A0A14; box-shadow:0 -2px 16px rgba(0,0,0,0.4); border-top:1px solid rgba(255,186,9,0.22); }
.ea-sticky-btn { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:3px; padding:10px 4px 8px; font-family:'Gotham',sans-serif; font-size:10px; font-weight:700; text-decoration:none; text-transform:uppercase; letter-spacing:0.4px; transition:background 0.15s; }
.ea-sticky-call { color:#60a5fa; border-right:1px solid rgba(255,255,255,0.08); }
.ea-sticky-wa   { color:#4ade80; border-right:1px solid rgba(255,255,255,0.08); }
.ea-sticky-quote{ color:var(--amber); }
@media(max-width:767px){.ea-sticky-bar{display:flex;}body{padding-bottom:62px;}}
/* Modal */
.ea-modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.65); backdrop-filter:blur(6px); z-index:99998; display:none; align-items:center; justify-content:center; padding:20px; }
.ea-modal-overlay.active { display:flex; }
.ea-modal-box { background:#1A1A2E; border:1px solid rgba(255,255,255,0.10); border-radius:var(--r-md); width:100%; max-width:520px; box-shadow:0 24px 80px rgba(0,0,0,0.60); overflow:hidden; animation:modalIn .25s ease; }
@keyframes modalIn { from{transform:translateY(20px);opacity:0;} to{transform:translateY(0);opacity:1;} }
.ea-modal-hdr { background:rgba(255,186,9,0.08); border-bottom:1px solid rgba(255,255,255,0.08); padding:18px 22px; display:flex; align-items:center; justify-content:space-between; }
.ea-modal-hdr h3 { font-family:'Gotham',sans-serif; font-size:16px; font-weight:700; color:#fff; margin:0; display:flex; align-items:center; gap:10px; }
.ea-modal-close { background:none; border:none; color:rgba(255,255,255,0.50); font-size:22px; cursor:pointer; padding:0; line-height:1; transition:color .2s; }
.ea-modal-close:hover { color:#fff; }
.ea-modal-body { padding:24px; }
.ea-modal-sub { font-family:'Gotham',sans-serif; font-size:13px; color:rgba(255,255,255,0.85); margin:0 0 20px; }
.ea-mf-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px; }
@media(max-width:540px){.ea-mf-row{grid-template-columns:1fr;}}
.ea-mf-group { display:flex; flex-direction:column; gap:6px; margin-bottom:14px; }
.ea-mf-label { font-family:'Gotham',sans-serif; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#fff; }
.ea-mf-group input,.ea-mf-group textarea { background:rgba(255,255,255,0.05); border:1.5px solid rgba(255,255,255,0.18); border-radius:var(--r-sm); padding:11px 14px; font-family:'Gotham',sans-serif; font-size:14px; color:#fff; outline:none; transition:border-color .2s,background .2s; width:100%; box-sizing:border-box; }
.ea-mf-group input::placeholder,.ea-mf-group textarea::placeholder { color:rgba(255,255,255,0.45); }
.ea-mf-group input:focus,.ea-mf-group textarea:focus { border-color:var(--amber); background:rgba(255,186,9,0.06); }
.ea-mf-group textarea { resize:vertical; min-height:90px; }
.ea-mf-submit { display:flex; align-items:center; justify-content:center; gap:9px; background:var(--amber); color:var(--tx); font-family:'Gotham',sans-serif; font-size:15px; font-weight:700; padding:0 24px; height:52px; border-radius:var(--r-sm); border:none; cursor:pointer; width:100%; transition:background .2s,transform .2s; margin-top:4px; }
.ea-mf-submit:hover { background:var(--amber-dk); transform:translateY(-1px); }
/* Lightbox */
.sp-lightbox { position:fixed; inset:0; background:rgba(0,0,0,0.92); z-index:99999; display:none; align-items:center; justify-content:center; }
.sp-lightbox.active { display:flex; }
.ea-lightbox { position:fixed; inset:0; background:rgba(0,0,0,0.92); z-index:99999; display:none; align-items:center; justify-content:center; }
.ea-lightbox.active { display:flex; }
.sp-lb-close { position:absolute; top:20px; right:20px; background:none; border:none; color:#fff; font-size:24px; cursor:pointer; }
.sp-lightbox img { max-width:90vw; max-height:90vh; border-radius:8px; object-fit:contain; }
/* Preloader */
#v9-pre { position:fixed; inset:0; z-index:99999; background:#1A1A2E; display:flex; align-items:center; justify-content:center; transition:opacity .5s ease,visibility .5s ease; }
#v9-pre.gone { opacity:0; visibility:hidden; pointer-events:none; }
.pre-inner { text-align:center; }
.pre-ring { width:44px; height:44px; border-radius:50%; border:3px solid rgba(255,186,9,0.20); border-top-color:#FFBA09; animation:sp-spin .7s linear infinite; margin:0 auto 18px; }
@keyframes sp-spin{to{transform:rotate(360deg);}}
.pre-name { font-family:'Gotham',sans-serif; font-size:10px; font-weight:500; letter-spacing:3px; color:rgba(255,255,255,0.32); text-transform:uppercase; }
@media(max-width:900px){.sp-pricing-section .container,.sp-why-section .container,.sp-related-section .container{padding:0 16px;}}
@media(max-width:600px){.ea-form-row{grid-template-columns:1fr;}}
</style>
<?php
/* =========================================================
   PER-CATEGORY CONFIG (key = product_category slug)
   ========================================================= */
$_ea_cats = [
  'backdrop-display-dubai' => [
    'tagline' => 'Custom backdrops, pop-up stands, step-and-repeat & fabric displays — designed, printed & installed across Dubai & the UAE.',
    'specs'   => [['icon'=>'fa-ruler-combined','label'=>'Sizes','val'=>'Any size — A0 to 5x10m+'],['icon'=>'fa-layer-group','label'=>'Materials','val'=>'Fabric, PVC, canvas, flex'],['icon'=>'fa-palette','label'=>'Print','val'=>'Full-colour digital'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'Same-day / next-day'],['icon'=>'fa-screwdriver-wrench','label'=>'Finish','val'=>'Hemmed, eyelets, frame kit'],['icon'=>'fa-truck-fast','label'=>'Delivery','val'=>'Dubai & all UAE']],
    'pricing' => [['size'=>'1x2m Pop-up Backdrop','mat'=>'PVC Vinyl','price'=>'AED 55 - 85'],['size'=>'2x3m Step-and-Repeat','mat'=>'Fabric / Flex','price'=>'AED 120 - 180'],['size'=>'3x6m Backdrop + Frame','mat'=>'Fabric + Aluminium Frame','price'=>'AED 380 - 600'],['size'=>'Custom Large Format','mat'=>'Canvas / Vinyl','price'=>'Request Quote']],
    'faq' => [['q'=>'What is the minimum order for custom backdrops in Dubai?','a'=>'We print from 1 piece with no minimum order. Custom sizes are always welcome.'],['q'=>'Do you supply the frame with the backdrop?','a'=>'Yes - we offer complete kits with aluminium pop-up or straight frames plus a carry bag.'],['q'=>'Can I get same-day backdrop printing in Dubai?','a'=>'Yes. Order before 10am for same-day collection from our Dubai production facility.'],['q'=>'What file format do you need for backdrop printing?','a'=>'AI, PDF or high-resolution JPG/PNG at 150 dpi at actual size. Free artwork support included.']],
  ],
  'flex-banner-printing-dubai' => [
    'tagline' => 'Roll-up banners, X-banners, flex banners & fence banners — vibrant print quality, fast turnaround, competitive prices across Dubai & UAE.',
    'specs'   => [['icon'=>'fa-ruler-combined','label'=>'Sizes','val'=>'0.6m - 3m wide, any length'],['icon'=>'fa-layer-group','label'=>'Materials','val'=>'Flex, mesh, vinyl, banner cloth'],['icon'=>'fa-palette','label'=>'Print','val'=>'UV / solvent / latex digital'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'4 - 24 hrs, same-day available'],['icon'=>'fa-screwdriver-wrench','label'=>'Finish','val'=>'Hemmed edges, eyelets, pole pockets'],['icon'=>'fa-truck-fast','label'=>'Delivery','val'=>'Free Dubai delivery, all UAE']],
    'pricing' => [['size'=>'Roll-up Banner 85x200cm','mat'=>'Premium vinyl + stand','price'=>'AED 65 - 110'],['size'=>'X-Banner 60x160cm','mat'=>'Polyester + X-frame','price'=>'AED 45 - 75'],['size'=>'Flex Banner 1x3m','mat'=>'500gsm blockout flex','price'=>'AED 45 - 75'],['size'=>'Fence Banner 1x5m (mesh)','mat'=>'PVC mesh','price'=>'AED 75 - 120']],
    'faq' => [['q'=>'What is flex banner printing?','a'=>'Flex banners are large-format prints on durable PVC or mesh, ideal for outdoor events, scaffolding, and fencing.'],['q'=>'How fast can you print a roll-up banner in Dubai?','a'=>'Same-day if ordered before 10am.'],['q'=>'Do roll-up banner prices include the stand?','a'=>'Yes - our price includes a premium retractable aluminium stand with carry bag.'],['q'=>'Can flex banners be used outdoors in Dubai?','a'=>'Absolutely - our flex and mesh banners are UV-resistant and weatherproof for 2-3 years outdoor use.']],
  ],
  'flags-printing-dubai' => [
    'tagline' => 'Teardrop flags, feather flags, car flags, table flags & event flags — full colour dye sublimation, fast delivery across Dubai & UAE.',
    'specs'   => [['icon'=>'fa-flag','label'=>'Types','val'=>'Teardrop, feather, car, table, event'],['icon'=>'fa-layer-group','label'=>'Materials','val'=>'Polyester, knitted polyester, satin'],['icon'=>'fa-palette','label'=>'Print','val'=>'Dye sublimation, full colour'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'3-5 working days, express available'],['icon'=>'fa-screwdriver-wrench','label'=>'Includes','val'=>'Pole, ground spike / base options'],['icon'=>'fa-truck-fast','label'=>'Delivery','val'=>'Dubai, Abu Dhabi, Sharjah & UAE']],
    'pricing' => [['size'=>'Teardrop Flag 2m','mat'=>'Knitted polyester + pole','price'=>'AED 85 - 140'],['size'=>'Feather Flag 4.5m','mat'=>'Knitted polyester + pole + base','price'=>'AED 140 - 220'],['size'=>'Table Flag A5','mat'=>'Satin polyester','price'=>'AED 25 - 40'],['size'=>'Car Flags 30x45cm','mat'=>'Polyester pair','price'=>'AED 40 - 70']],
    'faq' => [['q'=>'What types of flag printing do you offer in Dubai?','a'=>'We print teardrop, feather, rectangular, car, hand, table and custom-shaped event flags.'],['q'=>'Are your promotional flags suitable for outdoor use?','a'=>'Yes - all flags are printed on UV-treated polyester, colourfast and weatherproof.'],['q'=>'Can I get custom-shaped flags?','a'=>'Yes - teardrop and feather shapes are standard; completely custom-cut shapes are available.'],['q'=>'What is the minimum quantity for flag printing?','a'=>'From 1 piece. Bulk pricing applies from 10 units onwards.']],
  ],
  'stationery-printing-dubai' => [
    'tagline' => 'Business cards, letterheads, NCR books, envelopes & corporate stationery printing in Dubai — premium quality, same-day available.',
    'specs'   => [['icon'=>'fa-id-card','label'=>'Products','val'=>'Cards, letterheads, NCR, envelopes'],['icon'=>'fa-layer-group','label'=>'Materials','val'=>'350gsm silk, uncoated, recycled'],['icon'=>'fa-palette','label'=>'Finish','val'=>'Matt, gloss, soft-touch, spot UV'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'Same-day to 3 working days'],['icon'=>'fa-hashtag','label'=>'Quantity','val'=>'From 50 to 100,000+ copies'],['icon'=>'fa-truck-fast','label'=>'Delivery','val'=>'Door-to-door, all UAE']],
    'pricing' => [['size'=>'Business Cards 85x55mm','mat'=>'350gsm gloss / matt (250 pcs)','price'=>'AED 45 - 85'],['size'=>'Letterhead A4','mat'=>'100gsm uncoated (500 pcs)','price'=>'AED 65 - 120'],['size'=>'NCR Books 2-part A5','mat'=>'Self-copy paper (25 sets)','price'=>'AED 55 - 95'],['size'=>'DL Envelopes','mat'=>'80gsm (box of 500)','price'=>'AED 95 - 160']],
    'faq' => [['q'=>'Can I get same-day business card printing in Dubai?','a'=>'Yes - single-sided or double-sided cards available same-day if artwork submitted before 10am.'],['q'=>'Do you print NCR (carbonless copy) books?','a'=>'Yes - 2-part, 3-part and 4-part NCR books in A4/A5/A6 with sequential numbering.'],['q'=>'What is the minimum for stationery printing?','a'=>'Business cards from 50 pcs, letterheads from 100 sheets, NCR books from 10 books.'],['q'=>'Can you match our brand colours exactly?','a'=>'Yes - we use Pantone matching and CMYK proofing.']],
  ],
  'sticker-printing-dubai' => [
    'tagline' => 'Custom sticker printing in Dubai — vinyl, PVC, die-cut, wall, floor & glass stickers. Waterproof, UV-resistant, fast turnaround.',
    'specs'   => [['icon'=>'fa-tag','label'=>'Types','val'=>'Vinyl, die-cut, wall, glass, floor'],['icon'=>'fa-layer-group','label'=>'Materials','val'=>'Vinyl, polyester, PVC, clear'],['icon'=>'fa-palette','label'=>'Finish','val'=>'Gloss, matt, clear, white'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'Same-day to 2 working days'],['icon'=>'fa-hashtag','label'=>'Quantity','val'=>'From 1 to 100,000+ pieces'],['icon'=>'fa-truck-fast','label'=>'Delivery','val'=>'All UAE, express available']],
    'pricing' => [['size'=>'A4 Sheet Stickers','mat'=>'Gloss vinyl (50 sheets)','price'=>'AED 75 - 130'],['size'=>'Round Stickers 50mm','mat'=>'Matt vinyl (200 pcs)','price'=>'AED 55 - 95'],['size'=>'Wall Sticker A1','mat'=>'Removable vinyl','price'=>'AED 65 - 120'],['size'=>'Floor Sticker 50x50cm','mat'=>'Anti-slip laminate','price'=>'AED 45 - 90']],
    'faq' => [['q'=>'Are your vinyl stickers waterproof?','a'=>'Yes - all vinyl stickers are waterproof and UV-resistant.'],['q'=>'Can you cut stickers to custom shapes?','a'=>'Yes - die-cut and contour-cut in any shape.'],['q'=>'How long do outdoor stickers last in Dubai?','a'=>'Outdoor vinyl with UV lamination last 3-5 years in Dubai s climate.'],['q'=>'What is the smallest quantity I can order?','a'=>'From 1 piece for large-format stickers.']],
  ],
  'signage-dubai' => [
    'tagline' => '3D letters, acrylic signs, backlit LED channel letters, reception signs & outdoor signage — design, fabrication & full installation Dubai & UAE.',
    'specs'   => [['icon'=>'fa-building','label'=>'Types','val'=>'3D letters, acrylic, LED, backlit'],['icon'=>'fa-layer-group','label'=>'Materials','val'=>'Acrylic, aluminium, stainless steel'],['icon'=>'fa-lightbulb','label'=>'Lighting','val'=>'LED backlit, halo-lit, edge-lit'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'5-10 working days (rush available)'],['icon'=>'fa-screwdriver-wrench','label'=>'Service','val'=>'Design + fabrication + installation'],['icon'=>'fa-truck-fast','label'=>'Coverage','val'=>'Dubai, Abu Dhabi, Sharjah & UAE']],
    'pricing' => [['size'=>'Acrylic Reception Sign 60x90cm','mat'=>'10mm acrylic on standoffs','price'=>'AED 350 - 650'],['size'=>'3D Logo Letters (1m wide)','mat'=>'Acrylic / aluminium','price'=>'AED 550 - 1,200'],['size'=>'Backlit Channel Letters','mat'=>'Aluminium + LED (per letter)','price'=>'AED 200 - 500/letter'],['size'=>'Outdoor Signboard','mat'=>'Aluminium composite panel','price'=>'Request Quote']],
    'faq' => [['q'=>'Do you supply and install signage in Dubai?','a'=>'Yes - full process: design, fabrication, delivery and installation anywhere in Dubai and the UAE.'],['q'=>'What materials are best for outdoor signage in Dubai?','a'=>'Aluminium composite panels and UV-stabilised acrylic perform best in UAE outdoor conditions.'],['q'=>'How long does custom 3D signage take?','a'=>'Standard 3D letter signs take 5-7 working days. Rush orders in 3 days with an express surcharge.'],['q'=>'Do you make backlit LED signs?','a'=>'Yes - LED backlit channel letters, halo-lit signs and lightboxes of all sizes.']],
  ],
  'promotional-gifts-dubai' => [
    'tagline' => 'Branded USB drives, pens, mugs, notebooks & corporate gift sets — custom logo printing & engraving for businesses Dubai & UAE.',
    'specs'   => [['icon'=>'fa-gift','label'=>'Products','val'=>'USB, pens, mugs, notebooks, bags'],['icon'=>'fa-palette','label'=>'Branding','val'=>'Print, emboss, engrave, embroidery'],['icon'=>'fa-hashtag','label'=>'MOQ','val'=>'From 25 pieces per item'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'3-7 working days (stock items)'],['icon'=>'fa-box-open','label'=>'Packaging','val'=>'Custom gift box / retail packaging'],['icon'=>'fa-truck-fast','label'=>'Delivery','val'=>'All UAE + export available']],
    'pricing' => [['size'=>'Branded Metal Pen','mat'=>'Laser engraved (50 pcs)','price'=>'AED 8 - 18/pc'],['size'=>'Ceramic Mug 11oz','mat'=>'Full colour print (50 pcs)','price'=>'AED 15 - 28/pc'],['size'=>'USB Flash Drive 16GB','mat'=>'Branded metal body (50 pcs)','price'=>'AED 22 - 40/pc'],['size'=>'Corporate Gift Set','mat'=>'Pen + notebook + USB + box','price'=>'AED 75 - 150/set']],
    'faq' => [['q'=>'What is the minimum order for promotional gifts in Dubai?','a'=>'Minimum 25 pieces for most branded gifts.'],['q'=>'Can you brand gifts with our logo?','a'=>'Yes - we print, engrave, emboss or embroider your logo on all promotional items.'],['q'=>'Do you do custom corporate gift packaging?','a'=>'Yes - custom-printed gift boxes, tissue paper, sleeves and bags available.'],['q'=>'How fast can you deliver promotional gifts in Dubai?','a'=>'Stock items with branding: 3-5 working days.']],
  ],
  'vehicle-branding' => [
    'tagline' => 'Full vehicle wraps, partial wraps & fleet graphics — premium 3M / Avery vinyl, expert application, mobile advertising across Dubai & UAE.',
    'specs'   => [['icon'=>'fa-car','label'=>'Services','val'=>'Full wrap, partial, spot graphics'],['icon'=>'fa-layer-group','label'=>'Materials','val'=>'3M, Avery, KPMF cast vinyl'],['icon'=>'fa-palette','label'=>'Finish','val'=>'Gloss, matt, satin, chrome, metallic'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'1-3 days per vehicle'],['icon'=>'fa-car-side','label'=>'Vehicles','val'=>'Cars, vans, trucks, buses, boats'],['icon'=>'fa-truck-fast','label'=>'Coverage','val'=>'Dubai, Sharjah, Abu Dhabi']],
    'pricing' => [['size'=>'Sedan Full Wrap','mat'=>'Premium cast vinyl','price'=>'AED 1,800 - 3,500'],['size'=>'Van / SUV Full Wrap','mat'=>'Premium cast vinyl','price'=>'AED 2,500 - 5,000'],['size'=>'Partial Wrap (one side)','mat'=>'Cast vinyl','price'=>'AED 600 - 1,400'],['size'=>'Fleet Graphics (van)','mat'=>'Cut vinyl / digital','price'=>'AED 400 - 900/vehicle']],
    'faq' => [['q'=>'How long does a vehicle wrap last in Dubai?','a'=>'Premium cast vinyl wraps last 5-7 years in Dubai s climate.'],['q'=>'Will vehicle wrapping damage my car s paintwork?','a'=>'No - premium cast vinyl protects the paint.'],['q'=>'How long does it take to wrap a car in Dubai?','a'=>'A standard sedan full wrap takes 1-2 days.'],['q'=>'Do you wrap fleet vehicles for companies?','a'=>'Yes - we specialise in fleet branding across all vehicles.']],
  ],
  'plastic-bags-printing' => [
    'tagline' => 'Custom printed plastic bags in Dubai — HDPE, LDPE, non-woven PP and biodegradable bags with logo printing for retail & corporate use.',
    'specs'   => [['icon'=>'fa-shopping-bag','label'=>'Types','val'=>'HDPE, LDPE, non-woven, biodegradable'],['icon'=>'fa-ruler-combined','label'=>'Sizes','val'=>'S, M, L, XL or custom dimensions'],['icon'=>'fa-palette','label'=>'Print','val'=>'1-6 colour flexo / full digital'],['icon'=>'fa-hashtag','label'=>'MOQ','val'=>'From 500 pieces'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'7-14 working days'],['icon'=>'fa-truck-fast','label'=>'Delivery','val'=>'All UAE - factory direct pricing']],
    'pricing' => [['size'=>'HDPE T-Shirt Bag Medium','mat'=>'25 micron (1,000 pcs)','price'=>'AED 65 - 120'],['size'=>'LDPE Carry Bag Large','mat'=>'50 micron (500 pcs)','price'=>'AED 95 - 160'],['size'=>'Non-Woven PP Bag','mat'=>'80gsm with print (500)','price'=>'AED 180 - 350'],['size'=>'Biodegradable Bags','mat'=>'D2W oxo-degradable (500)','price'=>'Request Quote']],
    'faq' => [['q'=>'What types of plastic bags do you print in Dubai?','a'=>'We print HDPE T-shirt bags, LDPE carrier bags, non-woven PP bags, and compostable bags.'],['q'=>'What is the minimum order for printed plastic bags?','a'=>'Minimum 500 pieces for most bag types.'],['q'=>'Can printed bags be biodegradable?','a'=>'Yes - D2W oxo-biodegradable and fully compostable bags available.'],['q'=>'Do your bags comply with UAE plastic regulations?','a'=>'Yes - all bags comply with UAE packaging regulations.']],
  ],
  'exhibition-event-management' => [
    'tagline' => 'Exhibition stand design, build & management in Dubai — shell scheme, modular & bespoke custom stands for trade shows & events UAE-wide.',
    'specs'   => [['icon'=>'fa-store','label'=>'Stand Types','val'=>'Shell scheme, modular, bespoke'],['icon'=>'fa-ruler-combined','label'=>'Stand Sizes','val'=>'9m2 to 200m2+'],['icon'=>'fa-layer-group','label'=>'Materials','val'=>'Aluminium, fabric, acrylic, LED'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'Design 48hrs, build 5-10 days'],['icon'=>'fa-screwdriver-wrench','label'=>'Service','val'=>'Design + build + install + dismantle'],['icon'=>'fa-truck-fast','label'=>'Venues','val'=>'DWTC, ADNEC, Expo City & all UAE']],
    'pricing' => [['size'=>'Shell Scheme Upgrade 9m2','mat'=>'Graphics + furniture','price'=>'AED 1,800 - 4,000'],['size'=>'Modular Stand 18m2','mat'=>'Aluminium + fabric walls','price'=>'AED 6,000 - 12,000'],['size'=>'Bespoke Stand 36m2','mat'=>'Fully custom fabrication','price'=>'AED 18,000 - 45,000'],['size'=>'Pop-up Display 3m','mat'=>'Fabric + frame','price'=>'AED 900 - 1,800']],
    'faq' => [['q'=>'Do you design and build exhibition stands in Dubai?','a'=>'Yes - complete solutions from 3D design through to build, installation and dismantling.'],['q'=>'Which exhibition venues in Dubai do you service?','a'=>'We build at DWTC, ADNEC, Dubai Expo City, Sharjah Expo Centre and all UAE venues.'],['q'=>'How far in advance should I book an exhibition stand?','a'=>'4-6 weeks for bespoke stands; 2-3 weeks for modular.'],['q'=>'Do you handle logistics and post-show storage?','a'=>'Yes - we deliver, install, dismantle, and store stand components for your next show.']],
  ],
  'banners-printing' => [
    'tagline' => 'PVC vinyl banners, mesh banners & same-day banner printing in Dubai — outdoor, indoor, custom size, fast turnaround for events & advertising.',
    'specs'   => [['icon'=>'fa-scroll','label'=>'Types','val'=>'PVC vinyl, mesh, scrim, blockout'],['icon'=>'fa-ruler-combined','label'=>'Sizes','val'=>'Custom - 0.5m to 50m wide'],['icon'=>'fa-palette','label'=>'Print','val'=>'UV / solvent digital, 1440 dpi'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'Same-day / 24-hour available'],['icon'=>'fa-screwdriver-wrench','label'=>'Finish','val'=>'Eyelets, hemmed, pole pockets, rope'],['icon'=>'fa-truck-fast','label'=>'Delivery','val'=>'Free delivery in Dubai, all UAE']],
    'pricing' => [['size'=>'PVC Banner 1x3m','mat'=>'440gsm blockout vinyl','price'=>'AED 55 - 90'],['size'=>'Mesh Banner 2x4m','mat'=>'PVC mesh (outdoor)','price'=>'AED 85 - 145'],['size'=>'Premium Scrim 1x5m','mat'=>'550gsm scrim vinyl','price'=>'AED 95 - 165'],['size'=>'Event Banner 1x10m','mat'=>'440gsm, hemmed + eyelets','price'=>'AED 175 - 280']],
    'faq' => [['q'=>'What is the difference between PVC vinyl and mesh banners?','a'=>'PVC vinyl banners are solid and block wind. Mesh banners are perforated, allowing wind through, best for fencing.'],['q'=>'Can I get same-day banner printing in Dubai?','a'=>'Yes - standard PVC banners available for same-day collection if artwork submitted before 10am.'],['q'=>'What is the maximum banner size you can print?','a'=>'We print up to 5 metres wide in one piece.'],['q'=>'Do your banners include eyelets and hemming?','a'=>'Yes - welded hems and brass eyelets every 50cm as standard.']],
  ],
];
$_ea_default = [
  'tagline' => 'Professional printing & advertising solutions in Dubai, UAE — quality in-house production, fast turnaround, free design support.',
  'specs'   => [['icon'=>'fa-print','label'=>'Service','val'=>'In-house digital printing'],['icon'=>'fa-ruler-combined','label'=>'Sizes','val'=>'Standard & custom sizes'],['icon'=>'fa-palette','label'=>'Print','val'=>'Full colour CMYK digital'],['icon'=>'fa-bolt','label'=>'Turnaround','val'=>'Same-day to 5 working days'],['icon'=>'fa-screwdriver-wrench','label'=>'Finish','val'=>'Varies by product'],['icon'=>'fa-truck-fast','label'=>'Delivery','val'=>'All UAE emirates']],
  'pricing' => [['size'=>'Small Format','mat'=>'Standard material','price'=>'From AED 25'],['size'=>'Medium Format','mat'=>'Standard material','price'=>'From AED 55'],['size'=>'Large Format','mat'=>'Standard material','price'=>'From AED 95'],['size'=>'Custom / Bulk','mat'=>'Any material','price'=>'Request Quote']],
  'faq' => [['q'=>'How quickly can you print my order in Dubai?','a'=>'Most orders ready in 1-3 working days. Same-day and next-day options available.'],['q'=>'Do you provide free design or artwork support?','a'=>'Yes - our in-house design team prepares and adjusts artwork at no extra charge.'],['q'=>'What is the minimum order quantity?','a'=>'Minimums vary by product. Many items print from 1 piece.'],['q'=>'Do you deliver across the UAE?','a'=>'Yes - Dubai, Abu Dhabi, Sharjah, Ajman, Fujairah, Ras Al Khaimah and all UAE.']],
];
?>
<!-- PRELOADER -->
<div id="v9-pre"><div class="pre-inner"><div class="pre-ring"></div><span class="pre-name">Efficient Advertising</span></div></div>
<script>window.addEventListener('load',function(){var p=document.getElementById('v9-pre');if(p)setTimeout(function(){p.classList.add('gone');},200);});</script>

<main class="sp-page">
<?php
while ( have_posts() ) : the_post();
  $sp_id    = get_the_ID();
  $sp_title = get_the_title();
  $sp_url   = get_permalink();
  $wa_num   = '971527966265';
  $sp_terms    = get_the_terms( $sp_id, 'product_category' );
  $sp_cat_slug = '';
  $sp_cat_name = 'Products';
  $sp_cat_url  = home_url( '/shop/' );
  if ( $sp_terms && ! is_wp_error( $sp_terms ) ) {
    $sp_cat      = reset( $sp_terms );
    $sp_cat_slug = $sp_cat->slug;
    $sp_cat_name = $sp_cat->name;
    $sp_cat_url  = get_term_link( $sp_cat );
  }
  $cfg     = isset( $_ea_cats[ $sp_cat_slug ] ) ? $_ea_cats[ $sp_cat_slug ] : $_ea_default;
  $tagline = $cfg['tagline'];
  $specs   = $cfg['specs'];
  $pricing = $cfg['pricing'];
  $faqs    = $cfg['faq'];
  $gallery  = [];
  $thumb_id = get_post_thumbnail_id( $sp_id );
  if ( $thumb_id ) { $s = wp_get_attachment_image_src( $thumb_id, 'large' ); if ( $s ) $gallery[] = [ 'url' => $s[0], 'alt' => esc_attr( $sp_title . ' - Efficient Advertising Dubai' ) ]; }
  foreach ( [ 'product_image_one', 'product_image_two', 'product_image_three' ] as $fi => $fld ) {
    $val = get_post_meta( $sp_id, $fld, true );
    if ( ! $val ) continue;
    if ( is_numeric( $val ) ) { $s = wp_get_attachment_image_src( (int) $val, 'large' ); if ( $s ) $gallery[] = [ 'url' => $s[0], 'alt' => esc_attr( $sp_title . ' view ' . ( $fi + 2 ) ) ]; }
    elseif ( filter_var( $val, FILTER_VALIDATE_URL ) ) { $gallery[] = [ 'url' => esc_url( $val ), 'alt' => esc_attr( $sp_title . ' view ' . ( $fi + 2 ) ) ]; }
  }
  $sp_cat_ids    = wp_get_object_terms( $sp_id, 'product_category', [ 'fields' => 'ids' ] );
  $related_query = new WP_Query( [ 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 3, 'orderby' => 'rand', 'tax_query' => [ [ 'taxonomy' => 'product_category', 'field' => 'id', 'terms' => $sp_cat_ids ] ], 'post__not_in' => [ $sp_id ] ] );
?>
<script type="application/ld+json">
[{"@context":"https://schema.org","@type":"Product",
  "name":"<?php echo esc_js( $sp_title ); ?> Dubai",
  "url":"<?php echo esc_url( $sp_url ); ?>",
  <?php if ( ! empty( $gallery ) ) : ?>"image":"<?php echo esc_url( $gallery[0]['url'] ); ?>",<?php endif; ?>
  "description":"<?php echo esc_js( substr( wp_strip_all_tags( get_the_excerpt() ?: $tagline ), 0, 300 ) ); ?>",
  "brand":{"@type":"Brand","name":"Efficient Advertising LLC"},
  "offers":{"@type":"Offer","priceCurrency":"AED","availability":"https://schema.org/InStock","url":"<?php echo esc_url( $sp_url ); ?>","seller":{"@type":"Organization","name":"Efficient Advertising LLC"}}
},
{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[
  {"@type":"ListItem","position":1,"name":"Home","item":"<?php echo esc_url( home_url( '/' ) ); ?>"},
  {"@type":"ListItem","position":2,"name":"<?php echo esc_js( $sp_cat_name ); ?>","item":"<?php echo esc_url( $sp_cat_url ); ?>"},
  {"@type":"ListItem","position":3,"name":"<?php echo esc_js( $sp_title ); ?>"}
]},
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
  <?php foreach ( $faqs as $fi => $faq ) : ?>
  {"@type":"Question","name":"<?php echo esc_js( $faq['q'] ); ?>","acceptedAnswer":{"@type":"Answer","text":"<?php echo esc_js( wp_strip_all_tags( $faq['a'] ) ); ?>"}}<?php echo ( $fi < count( $faqs ) - 1 ) ? ',' : ''; ?>
  <?php endforeach; ?>
]}]
</script>

<!-- BREADCRUMB BAR -->
<section id="ea-pg-breadcrumb">
  <div class="container">
    <ol class="ea-breadcrumb" aria-label="Breadcrumb">
      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">›</span></li>
      <li><a href="<?php echo esc_url( $sp_cat_url ); ?>"><?php echo esc_html( $sp_cat_name ); ?></a><span class="sep">›</span></li>
      <li class="active" aria-current="page"><?php echo esc_html( $sp_title ); ?></li>
    </ol>
  </div>
</section>

<!-- PRODUCT HERO (Dark) -->
<section id="ea-pg-hero">
  <div class="container">
    <div class="ea-pg-hero-grid">

      <!-- LEFT: Image Gallery -->
      <div class="ea-pg-gallery">
        <div class="ea-pg-main-img" id="eaPgMainImg">
          <?php if ( ! empty( $gallery ) ) : ?>
          <img src="<?php echo esc_url( $gallery[0]['url'] ); ?>" alt="<?php echo esc_attr( $sp_title . ' - Efficient Advertising Dubai' ); ?>" id="eaPgMainImgEl" loading="eager">
          <?php else : ?>
          <img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.jpg" alt="<?php echo esc_attr( $sp_title ); ?>" id="eaPgMainImgEl" loading="eager">
          <?php endif; ?>
          <button class="ea-pg-zoom-btn" id="eaZoomBtn" aria-label="Zoom image">
            <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.72)" stroke-width="2" width="16" height="16"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><path d="M8 11h6M11 8v6" stroke-linecap="round"/></svg>
          </button>
        </div>
        <?php if ( count( $gallery ) > 1 ) : ?>
        <div class="ea-pg-thumbs">
          <?php foreach ( $gallery as $gi => $img ) : ?>
          <div class="ea-pg-thumb<?php echo $gi === 0 ? ' active' : ''; ?>" data-src="<?php echo esc_url( $img['url'] ); ?>">
            <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" loading="lazy">
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- RIGHT: Product Info + Config -->
      <div class="ea-pg-info">
        <span class="ea-pg-category-pill"><?php echo esc_html( $sp_cat_name ); ?></span>
        <h1 class="ea-pg-title"><?php echo esc_html( $sp_title ); ?> Dubai, UAE</h1>
        <p class="ea-pg-short-desc"><?php echo esc_html( $tagline ); ?></p>

        <!-- Quick spec badge pills -->
        <div class="ea-pg-spec-badges">
          <?php foreach ( array_slice( $specs, 0, 4 ) as $badge ) : ?>
          <div class="ea-pg-badge">
            <div>
              <span class="ea-pg-badge-label"><?php echo esc_html( $badge['label'] ); ?></span>
              <span class="ea-pg-badge-value"><?php echo esc_html( $badge['val'] ); ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Variant Config Panel (dark glass) -->
        <div class="ea-pg-config">
          <div class="ea-pg-config-title">Configure Your Order</div>
          <div class="ea-pg-option-group">
            <div class="ea-pg-option-label">Size / Format &nbsp;<span id="eaSelectedSize"><?php echo esc_html( $pricing[0]['size'] ); ?></span></div>
            <div class="ea-pg-option-btns" id="eaSizeGroup">
              <?php foreach ( $pricing as $pi => $row ) : ?>
              <button class="ea-pg-opt-btn<?php echo $pi === 0 ? ' selected' : ''; ?>" data-group="size" data-val="<?php echo esc_attr( $row['size'] ); ?>"><?php echo esc_html( $row['size'] ); ?></button>
              <?php endforeach; ?>
            </div>
          </div>
          <?php
            $finishes = [];
            foreach ( $specs as $s ) {
              if ( strtolower($s['label']) === 'finish' || strtolower($s['label']) === 'materials' ) {
                $parts = preg_split('/[,\/]/', $s['val']);
                foreach ($parts as $p) { $f = trim($p); if ($f) $finishes[] = $f; }
                break;
              }
            }
            if ( empty($finishes) ) $finishes = ['Standard', 'Custom'];
          ?>
          <div class="ea-pg-option-group">
            <div class="ea-pg-option-label">Finish &nbsp;<span id="eaSelectedFinish"><?php echo esc_html( $finishes[0] ); ?></span></div>
            <div class="ea-pg-option-btns" id="eaFinishGroup">
              <?php foreach ( $finishes as $fi => $f ) : ?>
              <button class="ea-pg-opt-btn<?php echo $fi === 0 ? ' selected' : ''; ?>" data-group="finish" data-val="<?php echo esc_attr( $f ); ?>"><?php echo esc_html( $f ); ?></button>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="ea-pg-qty-row">
            <span class="ea-pg-qty-label">Qty</span>
            <div class="ea-pg-qty-wrap">
              <button class="ea-pg-qty-btn" id="eaQtyDown" aria-label="Decrease quantity">−</button>
              <input type="number" class="ea-pg-qty-num" id="eaQtyNum" value="1" min="1" max="9999" aria-label="Quantity">
              <button class="ea-pg-qty-btn" id="eaQtyUp" aria-label="Increase quantity">+</button>
            </div>
          </div>
        </div>

        <!-- CTA Buttons -->
        <div class="ea-pg-cta-row">
          <button type="button" class="btn-amber-solid" data-modal="orderModal">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            Get a Quote
          </button>
          <a href="#ea-pg-artwork" class="btn-outline-amber">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/></svg>
            Upload Artwork
          </a>
          <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title . ' in Dubai' ); ?>" target="_blank" rel="noopener" class="ea-pg-wa-link">
            <svg width="17" height="17" viewBox="0 0 32 32" fill="currentColor"><path d="M16 0C7.164 0 0 7.163 0 16c0 2.822.736 5.463 2.018 7.761L0 32l8.533-2.236A15.93 15.93 0 0 0 16 32c8.836 0 16-7.163 16-16S24.836 0 16 0zm8.293 22.293c-.343.963-1.998 1.84-2.733 1.957-.698.11-1.58.157-2.547-.16-.587-.193-1.34-.45-2.297-.882-4.047-1.748-6.688-5.818-6.888-6.087-.197-.27-1.613-2.145-1.613-4.09 0-1.944 1.02-2.9 1.38-3.297.343-.38.748-.476 1-.476.25 0 .499.003.717.013.23.01.54-.088.844.644.314.75 1.066 2.598 1.16 2.786.094.19.156.41.03.66-.125.25-.188.406-.375.625-.188.22-.395.49-.563.658-.188.188-.383.39-.165.766.22.375.977 1.613 2.098 2.61 1.44 1.285 2.656 1.685 3.031 1.875.375.188.594.157.813-.094.22-.25.938-1.094 1.188-1.469.25-.375.5-.312.844-.187.344.125 2.188 1.031 2.563 1.219.375.188.625.281.719.438.094.156.094.906-.25 1.87z"/></svg>
            WhatsApp
          </a>
        </div>

        <!-- Trust badges -->
        <div class="ea-pg-trust">
          <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>Same-Day Available</div>
          <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24"><path d="M1 3h15v13H1zM16 8l4 2v6h-4m-12 0a2 2 0 104 0 2 2 0 00-4 0m10 0a2 2 0 104 0 2 2 0 00-4 0"/></svg></div>Free UAE Delivery</div>
          <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>18+ Years Experience</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TRUST BAR -->
<section id="ea-pg-trust-bar">
  <div class="container">
    <div class="trust-bar-inner">
      <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="var(--amber)"><path d="M12 1l3.09 6.26L22 8.27l-5 4.87 1.18 6.88L12 16.77l-6.18 3.25L7 13.14 2 8.27l6.91-1.01L12 1z"/></svg></div>18+ Years Experience</div>
      <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="var(--amber)"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div>500+ Events Served</div>
      <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--amber)" stroke-width="2.5"><path d="M5 12l5 5L20 7"/></svg></div>Free Design Support</div>
      <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--amber)" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>UAE-Wide Coverage</div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section id="ea-pg-features">
  <div class="container">
    <div class="ea-pg-features-header reveal">
      <div class="sec-label">Why Choose Us</div>
      <h2>Built for Brands, Events &amp; Exhibitions</h2>
      <p>In-house production, expert team, fast turnaround — delivered and installed across the UAE.</p>
    </div>
    <div class="ea-pg-features-grid">
      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico"><svg viewBox="0 0 24 24" width="24" height="24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
        <h4>In-House Production</h4>
        <p>We own and operate our Dubai facility — no outsourcing, full quality control, faster turnaround on every order.</p>
      </div>
      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico"><svg viewBox="0 0 24 24" width="24" height="24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></div>
        <h4>Same-Day Available</h4>
        <p>Urgent print needed? WhatsApp before 10am for same-day collection or next-day delivery across Dubai.</p>
      </div>
      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico"><svg viewBox="0 0 24 24" width="24" height="24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg></div>
        <h4>Any Size, Any Shape</h4>
        <p>Standard or fully custom — from A0 prints to giant 10m installations, we produce every format.</p>
      </div>
      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico"><svg viewBox="0 0 24 24" width="24" height="24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
        <h4>Brand Activations</h4>
        <p>Red carpet press walls, product launches, corporate events — your brand perfectly positioned every time.</p>
      </div>
      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico"><svg viewBox="0 0 24 24" width="24" height="24"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg></div>
        <h4>Free Design Support</h4>
        <p>Our in-house design team prepares, adjusts and finalises your artwork at no extra charge — every print looks right.</p>
      </div>
      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico"><svg viewBox="0 0 24 24" width="24" height="24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
        <h4>Delivery &amp; Installation</h4>
        <p>We deliver and install across Dubai, Abu Dhabi, Sharjah, and all UAE emirates. Dismantling included.</p>
      </div>
      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico"><svg viewBox="0 0 24 24" width="24" height="24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
        <h4>Premium Materials</h4>
        <p>Only certified substrates — 3M, Avery, UV-stable inks and moisture-resistant frames built to last.</p>
      </div>
      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico"><svg viewBox="0 0 24 24" width="24" height="24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
        <h4>18 Years of Excellence</h4>
        <p>Since 2006, Efficient Advertising has produced thousands of print jobs for Fortune 500 brands and local businesses.</p>
      </div>
    </div>
  </div>
</section>

<!-- SPECS (Tabbed) -->
<section id="ea-pg-specs">
  <div class="container">
    <div class="ea-pg-specs-inner">
      <div class="ea-pg-specs-header reveal">
        <div class="sec-label">Technical Specifications</div>
        <h2><?php echo esc_html( $sp_title ); ?> — Full Specifications</h2>
        <p>Materials, print options, use cases and artwork requirements for your <?php echo esc_html( strtolower( $sp_title ) ); ?> order.</p>
      </div>
      <div class="ea-pg-tabs reveal" role="tablist">
        <button class="ea-pg-tab active" role="tab" data-tab="materials" aria-selected="true">Materials &amp; Print</button>
        <button class="ea-pg-tab" role="tab" data-tab="sizes" aria-selected="false">Sizes &amp; Finish</button>
        <button class="ea-pg-tab" role="tab" data-tab="uses" aria-selected="false">Use Cases</button>
        <button class="ea-pg-tab" role="tab" data-tab="files" aria-selected="false">File Specs</button>
      </div>
      <div class="ea-pg-tab-panel active reveal" id="tab-materials" role="tabpanel">
        <table class="ea-pg-spec-table"><tbody>
          <?php foreach ( $specs as $spec ) : ?>
          <tr><td><?php echo esc_html( $spec['label'] ); ?></td><td><?php echo esc_html( $spec['val'] ); ?></td></tr>
          <?php endforeach; ?>
        </tbody></table>
      </div>
      <div class="ea-pg-tab-panel reveal" id="tab-sizes" role="tabpanel">
        <table class="ea-pg-spec-table"><tbody>
          <?php foreach ( $pricing as $row ) : ?>
          <tr><td><?php echo esc_html( $row['size'] ); ?></td><td><?php echo esc_html( $row['mat'] ); ?></td></tr>
          <?php endforeach; ?>
        </tbody></table>
      </div>
      <div class="ea-pg-tab-panel reveal" id="tab-uses" role="tabpanel">
        <table class="ea-pg-spec-table"><tbody>
          <tr><td>Indoor Displays</td><td>Events, exhibitions, retail, receptions, conferences, pop-ups</td></tr>
          <tr><td>Outdoor Advertising</td><td>Scaffolding, hoardings, fencing, vehicle displays, road-side banners</td></tr>
          <tr><td>Brand Activations</td><td>Product launches, press walls, photo booths, experiential campaigns</td></tr>
          <tr><td>Corporate Events</td><td>Stage backdrops, podium surrounds, directional signage, step-and-repeat</td></tr>
          <tr><td>Retail &amp; F&amp;B</td><td>Window graphics, seasonal campaigns, floor graphics, table displays</td></tr>
          <tr><td>Social &amp; Weddings</td><td>Photo-booth backdrops, flower-wall surrounds, birthday/wedding moments</td></tr>
        </tbody></table>
      </div>
      <div class="ea-pg-tab-panel reveal" id="tab-files" role="tabpanel">
        <table class="ea-pg-spec-table"><tbody>
          <tr><td>Preferred Format</td><td>PDF (print-ready) or AI / EPS with outlined fonts and embedded links</td></tr>
          <tr><td>Accepted Formats</td><td>PDF, AI, EPS, PSD, TIFF, high-res JPEG (300 dpi minimum at final size)</td></tr>
          <tr><td>Colour Mode</td><td>CMYK preferred; we convert RGB — expect slight shift on very saturated hues</td></tr>
          <tr><td>Bleed</td><td>30 mm on all sides; keep logos and text 40 mm from finished edge</td></tr>
          <tr><td>Resolution</td><td>150 dpi at final print size (300 dpi ideal); vector sources at any resolution</td></tr>
          <tr><td>File Delivery</td><td>WeTransfer, Google Drive, or WhatsApp for files under 50 MB</td></tr>
        </tbody></table>
      </div>
    </div>
  </div>
</section>

<!-- HOW TO ORDER / ARTWORK -->
<section id="ea-pg-artwork">
  <div class="container">
    <div class="ea-pg-hto-grid">
      <div class="ea-pg-hto-left reveal">
        <div class="sec-label">Simple Process</div>
        <h2>How to Order Your <?php echo esc_html( $sp_title ); ?></h2>
        <p>From artwork to delivered-and-installed — here is exactly what happens after you reach out.</p>
        <div class="ea-pg-steps">
          <div class="ea-pg-step">
            <div class="ea-pg-step-num">01</div>
            <div class="ea-pg-step-body">
              <h4>Send Us Your Brief</h4>
              <p>Share your size, material, and deadline. WhatsApp or email — whichever you prefer.</p>
            </div>
          </div>
          <div class="ea-pg-step">
            <div class="ea-pg-step-num">02</div>
            <div class="ea-pg-step-body">
              <h4>Receive a Quotation</h4>
              <p>We respond within 2 hours with a detailed quote including delivery costs.</p>
            </div>
          </div>
          <div class="ea-pg-step">
            <div class="ea-pg-step-num">03</div>
            <div class="ea-pg-step-body">
              <h4>Approve Artwork Proof</h4>
              <p>Upload your print file or send your logo — we create a free layout proof for your sign-off.</p>
            </div>
          </div>
          <div class="ea-pg-step">
            <div class="ea-pg-step-num">04</div>
            <div class="ea-pg-step-body">
              <h4>We Print, Deliver &amp; Install</h4>
              <p>Fast production, delivery to your door, installation where needed — all across the UAE.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="reveal">
        <div class="ea-pg-artwork-card">
          <div class="sec-label">Artwork Upload</div>
          <h3>Send Your Print File</h3>
          <p>Share your artwork via WhatsApp or email. Not ready? Send your logo and we will create a layout for you at no extra charge.</p>
          <div class="ea-pg-file-specs">
            <div class="ea-pg-file-spec"><span class="fs-label">Format</span><span class="fs-val">PDF / AI / PSD</span></div>
            <div class="ea-pg-file-spec"><span class="fs-label">Resolution</span><span class="fs-val">150 dpi min</span></div>
            <div class="ea-pg-file-spec"><span class="fs-label">Colour Mode</span><span class="fs-val">CMYK</span></div>
            <div class="ea-pg-file-spec"><span class="fs-label">Bleed</span><span class="fs-val">30 mm</span></div>
          </div>
          <div class="ea-pg-artwork-actions">
            <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I want to send artwork for: ' . $sp_title ); ?>" class="btn-wa-art" target="_blank" rel="noopener">
              <svg viewBox="0 0 32 32" fill="currentColor" width="17" height="17"><path d="M16 0C7.164 0 0 7.163 0 16c0 2.822.736 5.463 2.018 7.761L0 32l8.533-2.236A15.93 15.93 0 0 0 16 32c8.836 0 16-7.163 16-16S24.836 0 16 0zm8.293 22.293c-.343.963-1.998 1.84-2.733 1.957-.698.11-1.58.157-2.547-.16-.587-.193-1.34-.45-2.297-.882-4.047-1.748-6.688-5.818-6.888-6.087-.197-.27-1.613-2.145-1.613-4.09 0-1.944 1.02-2.9 1.38-3.297.343-.38.748-.476 1-.476.25 0 .499.003.717.013.23.01.54-.088.844.644.314.75 1.066 2.598 1.16 2.786.094.19.156.41.03.66-.125.25-.188.406-.375.625-.188.22-.395.49-.563.658-.188.188-.383.39-.165.766.22.375.977 1.613 2.098 2.61 1.44 1.285 2.656 1.685 3.031 1.875.375.188.594.157.813-.094.22-.25.938-1.094 1.188-1.469.25-.375.5-.312.844-.187.344.125 2.188 1.031 2.563 1.219.375.188.625.281.719.438.094.156.094.906-.25 1.87z"/></svg>
              Send via WhatsApp
            </a>
            <a href="mailto:info@efficientadvt.com?subject=Artwork for <?php echo esc_attr( $sp_title ); ?>" class="btn-email-art">
              <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
              Email Artwork
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING TABLE -->
<section class="sp-pricing-section">
  <div class="container">
    <div class="sp-sec-hdr">
      <h2>Get a Quote — <?php echo esc_html( $sp_title ); ?> Dubai</h2>
      <p>Every job is custom. Send us your size, quantity &amp; material and we will reply within the hour.</p>
    </div>
    <div class="sp-pricing-wrap">
      <table class="sp-pricing-tbl">
        <thead><tr><th>Size / Product</th><th>Material / Spec</th><th>Pricing</th><th>Get Quote</th></tr></thead>
        <tbody>
          <?php foreach ( $pricing as $row ) : ?>
          <tr>
            <td><?php echo esc_html( $row['size'] ); ?></td>
            <td><?php echo esc_html( $row['mat'] ); ?></td>
            <td><span class="sp-rq-badge">Request Quote</span></td>
            <td><a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title . ' — ' . $row['size'] ); ?>" class="sp-price-wa" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> Get Quote</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="sp-pricing-note"><i class="fa-solid fa-circle-info"></i> All prices exclude 5% VAT. Bulk discounts available. Call <a href="tel:+97142711048">+971 4 271 1048</a> or <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>" target="_blank" rel="noopener">WhatsApp +971 52 796 6265</a> for a customised quote.</p>
  </div>
</section>

<!-- RELATED PRODUCTS -->
<section id="ea-pg-related">
  <div class="container">
    <div class="sp-sec-hdr reveal">
      <div class="sec-label">More Products</div>
      <h2>You May Also Like</h2>
    </div>
    <div class="ea-pg-rel-grid">
      <?php if ( $related_query->have_posts() ) : while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
      <a href="<?php the_permalink(); ?>" class="ea-pg-rel-card reveal">
        <div class="ea-pg-rel-img">
          <?php
          $rel_id  = get_the_ID();
          $rel_img = '';
          // Helper: build <img> from attachment ID
          $rel_img_from_id = function( $att_id, $alt ) {
            $s = wp_get_attachment_image_src( (int) $att_id, 'medium' );
            if ( ! $s ) $s = wp_get_attachment_image_src( (int) $att_id, 'full' );
            return $s ? '<img src="' . esc_url( $s[0] ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy">' : '';
          };
          $rel_alt = get_the_title( $rel_id );
          // 1. WP Featured image
          $tid = get_post_thumbnail_id( $rel_id );
          if ( $tid ) $rel_img = $rel_img_from_id( $tid, $rel_alt );
          // 2. WooCommerce _product_image_gallery
          if ( ! $rel_img ) {
            $woo_gal = get_post_meta( $rel_id, '_product_image_gallery', true );
            if ( $woo_gal ) {
              foreach ( array_filter( explode( ',', $woo_gal ) ) as $_gid ) {
                $rel_img = $rel_img_from_id( $_gid, $rel_alt );
                if ( $rel_img ) break;
              }
            }
          }
          // 3. ACF / custom meta image fields
          if ( ! $rel_img ) {
            foreach ( [ 'product_image_one', 'product_image_two', 'product_image_three' ] as $_rf ) {
              $rv = get_post_meta( $rel_id, $_rf, true );
              if ( ! $rv ) continue;
              if ( is_numeric( $rv ) ) {
                $rel_img = $rel_img_from_id( $rv, $rel_alt );
                if ( $rel_img ) break;
              } elseif ( filter_var( $rv, FILTER_VALIDATE_URL ) ) {
                $rel_img = '<img src="' . esc_url( $rv ) . '" alt="' . esc_attr( $rel_alt ) . '" loading="lazy">'; break;
              }
            }
          }
          // 4. Scan ALL attachment children of this post (last resort)
          if ( ! $rel_img ) {
            $att = get_children(['post_parent'=>$rel_id,'post_type'=>'attachment','post_mime_type'=>'image','numberposts'=>1,'orderby'=>'menu_order','order'=>'ASC']);
            if ( $att ) {
              $rel_img = $rel_img_from_id( array_key_first($att), $rel_alt );
            }
          }
          if ( $rel_img ) { echo $rel_img; } else { ?>
          <div class="ea-pg-rel-placeholder"></div>
          <?php } ?>
          <div class="ea-pg-rel-overlay"><span>View Product</span></div>
        </div>
        <div class="ea-pg-rel-body">
          <h4><?php the_title(); ?></h4>
          <p class="ea-pg-rel-cat"><?php the_terms( get_the_ID(), 'product_cat', '', ', ' ); ?></p>
          <span class="ea-pg-rel-cta">Get Quote <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
    <?php if ( ! empty( $sp_cat_url ) ) : ?>
    <div class="sp-see-all-wrap">
      <a href="<?php echo esc_url( $sp_cat_url ); ?>" class="sp-see-all">See All <?php echo esc_html( $sp_title ); ?> Products <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- GOOGLE REVIEWS -->
<section class="reviews">
  <div class="reviewshadow">
    <div class="creative_heading">
      <h2><?php echo get_field( 'Google Reviews' ); ?></h2>
    </div>
    <?php echo do_shortcode( '[trustindex no-registration=google]' ); ?>
  </div>
</section>

<!-- FAQ -->
<section id="ea-pg-faq">
  <div class="container">
    <div class="ea-pg-faq-grid">
      <div class="ea-pg-faq-left reveal">
        <div class="sec-label">Questions Answered</div>
        <h2>Frequently Asked Questions</h2>
        <p>Everything you need to know about ordering your <?php echo esc_html( $sp_title ); ?> in Dubai and the UAE.</p>
        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I have a question about: ' . $sp_title ); ?>" class="btn-wa-faq" target="_blank" rel="noopener">
          <svg viewBox="0 0 32 32" fill="currentColor" width="17" height="17"><path d="M16 0C7.164 0 0 7.163 0 16c0 2.822.736 5.463 2.018 7.761L0 32l8.533-2.236A15.93 15.93 0 0 0 16 32c8.836 0 16-7.163 16-16S24.836 0 16 0zm8.293 22.293c-.343.963-1.998 1.84-2.733 1.957-.698.11-1.58.157-2.547-.16-.587-.193-1.34-.45-2.297-.882-4.047-1.748-6.688-5.818-6.888-6.087-.197-.27-1.613-2.145-1.613-4.09 0-1.944 1.02-2.9 1.38-3.297.343-.38.748-.476 1-.476.25 0 .499.003.717.013.23.01.54-.088.844.644.314.75 1.066 2.598 1.16 2.786.094.19.156.41.03.66-.125.25-.188.406-.375.625-.188.22-.395.49-.563.658-.188.188-.383.39-.165.766.22.375.977 1.613 2.098 2.61 1.44 1.285 2.656 1.685 3.031 1.875.375.188.594.157.813-.094.22-.25.938-1.094 1.188-1.469.25-.375.5-.312.844-.187.344.125 2.188 1.031 2.563 1.219.375.188.625.281.719.438.094.156.094.906-.25 1.87z"/></svg>
          Ask on WhatsApp
        </a>
      </div>
      <div class="ea-pg-acc-list reveal">
        <?php foreach ( $faqs as $i => $fq ) : ?>
        <div class="ea-pg-acc-item">
          <button class="ea-pg-acc-trigger" aria-expanded="false">
            <?php echo esc_html( $fq['q'] ); ?>
            <svg class="ea-pg-acc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="18" height="18"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="ea-pg-acc-body">
            <p><?php echo esc_html( $fq['a'] ); ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- CTA STRIP -->
<section id="ea-pg-cta">
  <div class="container">
    <div class="ea-pg-cta-inner reveal">
      <div class="ea-pg-cta-text">
        <h2>Ready to Order Your <?php echo esc_html( $sp_title ); ?>?</h2>
        <p>Get a fast, no-obligation quote from our production team. Delivering across Dubai, Abu Dhabi and all UAE.</p>
      </div>
      <div class="ea-pg-cta-btns">
        <button class="btn-cta-primary" data-modal="orderModal">Get a Free Quote</button>
        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title ); ?>" class="btn-cta-wa" target="_blank" rel="noopener">
          <svg viewBox="0 0 32 32" fill="currentColor" width="17" height="17"><path d="M16 0C7.164 0 0 7.163 0 16c0 2.822.736 5.463 2.018 7.761L0 32l8.533-2.236A15.93 15.93 0 0 0 16 32c8.836 0 16-7.163 16-16S24.836 0 16 0zm8.293 22.293c-.343.963-1.998 1.84-2.733 1.957-.698.11-1.58.157-2.547-.16-.587-.193-1.34-.45-2.297-.882-4.047-1.748-6.688-5.818-6.888-6.087-.197-.27-1.613-2.145-1.613-4.09 0-1.944 1.02-2.9 1.38-3.297.343-.38.748-.476 1-.476.25 0 .499.003.717.013.23.01.54-.088.844.644.314.75 1.066 2.598 1.16 2.786.094.19.156.41.03.66-.125.25-.188.406-.375.625-.188.22-.395.49-.563.658-.188.188-.383.39-.165.766.22.375.977 1.613 2.098 2.61 1.44 1.285 2.656 1.685 3.031 1.875.375.188.594.157.813-.094.22-.25.938-1.094 1.188-1.469.25-.375.5-.312.844-.187.344.125 2.188 1.031 2.563 1.219.375.188.625.281.719.438.094.156.094.906-.25 1.87z"/></svg>
          WhatsApp Us
        </a>
      </div>
    </div>
  </div>
</section>

<!-- WA FLOAT -->
<a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title ); ?>" class="ea-wa-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <svg viewBox="0 0 32 32" fill="currentColor" width="28" height="28"><path d="M16 0C7.164 0 0 7.163 0 16c0 2.822.736 5.463 2.018 7.761L0 32l8.533-2.236A15.93 15.93 0 0 0 16 32c8.836 0 16-7.163 16-16S24.836 0 16 0zm8.293 22.293c-.343.963-1.998 1.84-2.733 1.957-.698.11-1.58.157-2.547-.16-.587-.193-1.34-.45-2.297-.882-4.047-1.748-6.688-5.818-6.888-6.087-.197-.27-1.613-2.145-1.613-4.09 0-1.944 1.02-2.9 1.38-3.297.343-.38.748-.476 1-.476.25 0 .499.003.717.013.23.01.54-.088.844.644.314.75 1.066 2.598 1.16 2.786.094.19.156.41.03.66-.125.25-.188.406-.375.625-.188.22-.395.49-.563.658-.188.188-.383.39-.165.766.22.375.977 1.613 2.098 2.61 1.44 1.285 2.656 1.685 3.031 1.875.375.188.594.157.813-.094.22-.25.938-1.094 1.188-1.469.25-.375.5-.312.844-.187.344.125 2.188 1.031 2.563 1.219.375.188.625.281.719.438.094.156.094.906-.25 1.87z"/></svg>
</a>

<!-- STICKY BAR -->
<div class="ea-sticky-bar" id="eaStickyBar">
  <div class="ea-sticky-inner">
    <div class="ea-sticky-title"><?php echo esc_html( $sp_title ); ?></div>
    <div class="ea-sticky-actions">
      <a href="tel:+97142711048" class="ea-sticky-btn ea-sticky-call"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 3.08 5.18 2 2 0 0 1 5.07 3h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.09 10.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 23 18v-.08z"/></svg> Call</a>
      <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title ); ?>" class="ea-sticky-btn ea-sticky-wa" target="_blank" rel="noopener"><svg viewBox="0 0 32 32" fill="currentColor" width="16" height="16"><path d="M16 0C7.164 0 0 7.163 0 16c0 2.822.736 5.463 2.018 7.761L0 32l8.533-2.236A15.93 15.93 0 0 0 16 32c8.836 0 16-7.163 16-16S24.836 0 16 0zm8.293 22.293c-.343.963-1.998 1.84-2.733 1.957-.698.11-1.58.157-2.547-.16-.587-.193-1.34-.45-2.297-.882-4.047-1.748-6.688-5.818-6.888-6.087-.197-.27-1.613-2.145-1.613-4.09 0-1.944 1.02-2.9 1.38-3.297.343-.38.748-.476 1-.476.25 0 .499.003.717.013.23.01.54-.088.844.644.314.75 1.066 2.598 1.16 2.786.094.19.156.41.03.66-.125.25-.188.406-.375.625-.188.22-.395.49-.563.658-.188.188-.383.39-.165.766.22.375.977 1.613 2.098 2.61 1.44 1.285 2.656 1.685 3.031 1.875.375.188.594.157.813-.094.22-.25.938-1.094 1.188-1.469.25-.375.5-.312.844-.187.344.125 2.188 1.031 2.563 1.219.375.188.625.281.719.438.094.156.094.906-.25 1.87z"/></svg> WhatsApp</a>
      <button class="ea-sticky-btn ea-sticky-quote" data-modal="orderModal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> Get Quote</button>
    </div>
  </div>
</div>

<!-- QUOTE MODAL -->
<div class="ea-modal-overlay" id="orderModal" role="dialog" aria-modal="true" aria-label="Request a Quote">
  <div class="ea-modal-box">
    <div class="ea-modal-hdr">
      <h3><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg> Request a Quote</h3>
      <button class="ea-modal-close" aria-label="Close modal">&times;</button>
    </div>
    <div class="ea-modal-body">
      <p class="ea-modal-sub"><?php echo esc_html( $sp_title ); ?> &mdash; we reply within 2 hours.</p>
      <form class="ea-modal-form" action="https://formspree.io/f/xdovkoje" method="POST">
        <input type="hidden" name="product" value="<?php echo esc_attr( $sp_title ); ?>">
        <div class="ea-mf-row">
          <div class="ea-mf-group">
            <label class="ea-mf-label">Your Name</label>
            <input type="text" name="name" placeholder="e.g. Ahmed Al Rashid" required>
          </div>
          <div class="ea-mf-group">
            <label class="ea-mf-label">Phone / WhatsApp</label>
            <input type="tel" name="phone" placeholder="+971 50 000 0000" required>
          </div>
        </div>
        <div class="ea-mf-group">
          <label class="ea-mf-label">Product Details</label>
          <textarea name="message" rows="4" placeholder="Size, quantity, material, deadline, artwork status..."></textarea>
        </div>
        <button type="submit" class="ea-mf-submit">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          Send Request
        </button>
      </form>
    </div>
  </div>
</div>

<!-- LIGHTBOX -->
<div class="ea-lightbox" id="spLightbox" role="dialog" aria-modal="true" aria-label="Image lightbox">
  <button class="ea-lb-close" aria-label="Close lightbox">&times;</button>
  <button class="ea-lb-prev" aria-label="Previous image">&#8592;</button>
  <img src="" alt="" class="ea-lb-img">
  <button class="ea-lb-next" aria-label="Next image">&#8594;</button>
</div>

<?php endwhile; ?>
</main>

<script>
(function(){
  var revEls = document.querySelectorAll('.reveal');
  if(revEls.length){
    var ro = new IntersectionObserver(function(entries){
      entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('visible'); ro.unobserve(e.target); } });
    },{threshold:0.12});
    revEls.forEach(function(el){ ro.observe(el); });
  }
  // Thumbnail swap
  var mainImgEl = document.getElementById('eaPgMainImgEl');
  var lbAllSrcs = Array.from(document.querySelectorAll('.ea-pg-thumb')).map(function(t){ return t.getAttribute('data-src'); });
  document.querySelectorAll('.ea-pg-thumb').forEach(function(t,idx){
    t.addEventListener('click',function(){
      document.querySelectorAll('.ea-pg-thumb').forEach(function(x){ x.classList.remove('active'); });
      t.classList.add('active');
      var src = t.getAttribute('data-src');
      if(mainImgEl && src){ mainImgEl.src = src; }
    });
  });
  // Main image click → lightbox
  var lbEl = document.getElementById('spLightbox');
  var lbImgEl = lbEl ? lbEl.querySelector('.ea-lb-img') : null;
  var lbCurIdx = 0;
  if(mainImgEl && lbEl){
    mainImgEl.style.cursor = 'zoom-in';
    document.getElementById('eaPgMainImg').addEventListener('click', function(e){
      if(e.target.closest('.ea-pg-zoom-btn')) return;
      lbCurIdx = Array.from(document.querySelectorAll('.ea-pg-thumb')).findIndex(function(t){ return t.classList.contains('active'); });
      if(lbCurIdx < 0) lbCurIdx = 0;
      if(lbImgEl){ lbImgEl.src = lbAllSrcs[lbCurIdx]; }
      lbEl.classList.add('active');
      document.body.style.overflow = 'hidden';
    });
    document.getElementById('eaZoomBtn').addEventListener('click', function(){
      lbCurIdx = Array.from(document.querySelectorAll('.ea-pg-thumb')).findIndex(function(t){ return t.classList.contains('active'); });
      if(lbCurIdx < 0) lbCurIdx = 0;
      if(lbImgEl){ lbImgEl.src = lbAllSrcs[lbCurIdx]; }
      lbEl.classList.add('active');
      document.body.style.overflow = 'hidden';
    });
    lbEl.querySelector('.ea-lb-close').addEventListener('click',function(){ lbEl.classList.remove('active'); document.body.style.overflow=''; });
    lbEl.querySelector('.ea-lb-prev').addEventListener('click',function(){ lbCurIdx=(lbCurIdx-1+lbAllSrcs.length)%lbAllSrcs.length; lbImgEl.src=lbAllSrcs[lbCurIdx]; var th=document.querySelectorAll('.ea-pg-thumb'); th.forEach(function(x){x.classList.remove('active');}); if(th[lbCurIdx]) th[lbCurIdx].classList.add('active'); });
    lbEl.querySelector('.ea-lb-next').addEventListener('click',function(){ lbCurIdx=(lbCurIdx+1)%lbAllSrcs.length; lbImgEl.src=lbAllSrcs[lbCurIdx]; var th=document.querySelectorAll('.ea-pg-thumb'); th.forEach(function(x){x.classList.remove('active');}); if(th[lbCurIdx]) th[lbCurIdx].classList.add('active'); });
    lbEl.addEventListener('click',function(e){ if(e.target===lbEl){ lbEl.classList.remove('active'); document.body.style.overflow=''; } });
  }
  document.querySelectorAll('.ea-pg-opt-btn').forEach(function(b){
    b.addEventListener('click',function(){
      var grp = b.closest('.ea-pg-option-btns');
      if(grp){grp.querySelectorAll('.ea-pg-opt-btn').forEach(function(x){x.classList.remove('active');x.classList.remove('selected');});}
      b.classList.add('selected');
    });
  });
  var qtyIn = document.querySelector('#qtyInput');
  if(qtyIn){
    document.querySelectorAll('.ea-qty-btn').forEach(function(b){
      b.addEventListener('click',function(){
        var v = parseInt(qtyIn.value)||1;
        if(b.dataset.dir === 'up'){ qtyIn.value = v+1; }
        else if(v > 1){ qtyIn.value = v-1; }
      });
    });
  }
  document.querySelectorAll('.ea-pg-tab').forEach(function(tb){
    tb.addEventListener('click',function(){
      var wrap = tb.closest('.ea-pg-tabs-wrap, .ea-pg-specs-inner, #ea-pg-specs');
      if(!wrap) wrap = document.getElementById('ea-pg-specs');
      wrap.querySelectorAll('.ea-pg-tab').forEach(function(x){x.classList.remove('active'); x.setAttribute('aria-selected','false');});
      wrap.querySelectorAll('.ea-pg-tab-panel').forEach(function(x){x.classList.remove('active');});
      tb.classList.add('active'); tb.setAttribute('aria-selected','true');
      var p = document.getElementById('tab-' + tb.dataset.tab);
      if(!p) p = document.getElementById(tb.dataset.tab);
      if(p) p.classList.add('active');
    });
  });
  document.querySelectorAll('.ea-pg-acc-trigger').forEach(function(tr){
    tr.addEventListener('click',function(){
      var item = tr.closest('.ea-pg-acc-item');
      var wasOpen = item.classList.contains('open');
      document.querySelectorAll('.ea-pg-acc-item').forEach(function(x){x.classList.remove('open'); x.querySelector('.ea-pg-acc-trigger').setAttribute('aria-expanded','false');});
      if(!wasOpen){ item.classList.add('open'); tr.setAttribute('aria-expanded','true'); }
    });
  });
  function openModal(id){ var m = document.getElementById(id); if(m){ m.classList.add('active'); document.body.style.overflow='hidden'; } }
  function closeModal(id){ var m = document.getElementById(id); if(m){ m.classList.remove('active'); document.body.style.overflow=''; } }
  document.querySelectorAll('[data-modal]').forEach(function(b){ b.addEventListener('click',function(){ openModal(b.dataset.modal); }); });
  document.querySelectorAll('.ea-modal-close').forEach(function(b){ b.addEventListener('click',function(){ var m=b.closest('.ea-modal-overlay'); if(m) closeModal(m.id); }); });
  document.querySelectorAll('.ea-modal-overlay').forEach(function(m){ m.addEventListener('click',function(e){ if(e.target===m) closeModal(m.id); }); });
  var sticky = document.getElementById('eaStickyBar');
  if(sticky){
    var hero = document.getElementById('ea-pg-hero');
    window.addEventListener('scroll',function(){
      if(hero){ var r=hero.getBoundingClientRect(); sticky.classList.toggle('visible', r.bottom < 0); }
    });
  }
})();
</script>

<?php get_footer(); ?>
