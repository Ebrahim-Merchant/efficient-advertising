<?php
/**
 * Template Name: Wooden Backdrop Product Page (V10)
 * Template for: product/wooden-backdrop
 */
get_header();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Unbounded:wght@400;500;600;700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">

<style>
:root {
  --bg:#F7F5F0; --bg-dark:#EDE9DF; --bg-card:#FFFFFF;
  --bg-dark1:#1A1A2E; --bg-dark2:#0F0F1E; --bg-dark3:#0A0A14;
  --amber:#FFBA09; --amber-dk:#E5A800; --amber-pale:#FFF8E1;
  --amber-ring:rgba(255,186,9,0.40);
  --tx:#1A1A2E; --tx-2:#374151; --tx-muted:#64748B;
  --tx-light:rgba(255,255,255,0.85);
  --green:#16A34A; --border:rgba(26,26,46,0.10);
  --shadow-sm:0 2px 14px rgba(26,26,46,0.07);
  --shadow-md:0 6px 32px rgba(26,26,46,0.12);
  --r-sm:10px; --r-md:20px; --r-lg:28px; --r-pill:100px;
  --cream:#F7F5F0; --navy:#1A1A2E;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
.ea-wb body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--tx);line-height:1.65;overflow-x:hidden;}
.ea-wb img{max-width:100%;height:auto;display:block;}
.ea-wb a{text-decoration:none;color:inherit;}
.reveal{opacity:0;transform:translateY(28px);transition:opacity .55s ease,transform .55s ease;}
.reveal.visible{opacity:1;transform:translateY(0);}
.sec-label{font-family:'Unbounded',sans-serif;font-size:10px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--tx);background:var(--amber-pale);border:1.5px solid var(--amber-ring);padding:7px 18px;border-radius:var(--r-pill);display:inline-block;margin-bottom:22px;}
.sec-label-dark{font-family:'Unbounded',sans-serif;font-size:10px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--amber);background:rgba(255,186,9,0.10);border:1.5px solid rgba(255,186,9,0.28);padding:7px 18px;border-radius:var(--r-pill);display:inline-block;margin-bottom:22px;}
.btn-amber-solid{display:inline-flex;align-items:center;justify-content:center;gap:10px;background:var(--amber);color:var(--tx);font-family:'DM Sans',sans-serif;font-size:15px;font-weight:700;padding:14px 28px;border-radius:var(--r-sm);border:none;cursor:pointer;transition:background .2s,transform .2s;text-decoration:none;white-space:nowrap;}
.btn-amber-solid:hover{background:var(--amber-dk);transform:translateY(-2px);color:var(--tx);}
.btn-outline-amber{display:inline-flex;align-items:center;justify-content:center;gap:10px;background:transparent;color:var(--amber);font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;padding:13px 28px;border-radius:var(--r-sm);border:1.5px solid rgba(255,186,9,0.50);cursor:pointer;transition:background .2s,border-color .2s,transform .2s;text-decoration:none;white-space:nowrap;}
.btn-outline-amber:hover{background:rgba(255,186,9,0.10);border-color:var(--amber);transform:translateY(-2px);color:var(--amber);}
.btn-outline-white{display:inline-flex;align-items:center;justify-content:center;gap:10px;background:transparent;color:rgba(255,255,255,0.80);font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;padding:13px 28px;border-radius:var(--r-sm);border:1.5px solid rgba(255,255,255,0.18);cursor:pointer;transition:background .2s,border-color .2s,transform .2s;text-decoration:none;white-space:nowrap;}
.btn-outline-white:hover{background:rgba(255,255,255,0.06);border-color:rgba(255,255,255,0.40);transform:translateY(-2px);color:#fff;}
.btn-outline-dark{display:inline-flex;align-items:center;justify-content:center;gap:10px;background:transparent;color:rgba(26,26,46,0.72);font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;padding:13px 28px;border-radius:var(--r-sm);border:1.5px solid rgba(26,26,46,0.22);cursor:pointer;transition:background .2s,border-color .2s,transform .2s;text-decoration:none;white-space:nowrap;}
.btn-outline-dark:hover{background:rgba(26,26,46,0.06);border-color:rgba(26,26,46,0.42);transform:translateY(-2px);color:#1A1A2E;}

/* Push whole template below the fixed #header */
#ea-wb-wrap{margin-top:100px;}

/* Container override */
#ea-wb-wrap .container{width:100%!important;max-width:none!important;padding-left:clamp(16px,4vw,80px)!important;padding-right:clamp(16px,4vw,80px)!important;box-sizing:border-box!important;}

/* BREADCRUMB */
#ea-pg-breadcrumb{background:#fff;border-bottom:1px solid rgba(26,26,46,0.08);padding:13px 0;}
.ea-breadcrumb{display:flex;align-items:center;flex-wrap:wrap;list-style:none;margin:0;padding:0;}
.ea-breadcrumb li{display:flex;align-items:center;font-family:'DM Sans',sans-serif;font-size:13px;color:rgba(26,26,46,0.45);}
.ea-breadcrumb li a{color:rgba(26,26,46,0.55);text-decoration:none;transition:color .2s;}
.ea-breadcrumb li a:hover{color:var(--amber);}
.ea-breadcrumb li.active{color:#1A1A2E;font-weight:500;}
.ea-breadcrumb .sep{margin:0 8px;color:rgba(26,26,46,0.16);font-size:11px;}

/* HERO */
#ea-pg-hero{background:#F4F2ED;padding:clamp(36px,4vw,72px) 0 clamp(48px,5vw,90px);position:relative;overflow:hidden;z-index:1;}
#ea-pg-hero::before{content:'';position:absolute;inset:0;pointer-events:none;z-index:0;background:radial-gradient(ellipse at 0% 50%,rgba(255,186,9,0.05) 0%,transparent 50%),radial-gradient(ellipse at 100% 20%,rgba(255,186,9,0.04) 0%,transparent 45%);}
.ea-pg-hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:clamp(28px,4vw,60px);align-items:start;position:relative;z-index:1;}
@media(max-width:991px){.ea-pg-hero-grid{grid-template-columns:1fr;}}
.ea-pg-main-img{width:100%;aspect-ratio:4/3;border-radius:var(--r-md);overflow:hidden;border:1px solid rgba(26,26,46,0.10);background:#F0EEE8;position:relative;cursor:zoom-in;}
.ea-pg-main-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s cubic-bezier(0.25,0.46,0.45,0.94);display:block;}
.ea-pg-main-img:hover img{transform:scale(1.04);}
.ea-pg-zoom-btn{position:absolute;top:14px;right:14px;width:34px;height:34px;border-radius:50%;background:rgba(10,10,20,0.70);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,0.14);cursor:pointer;transition:background .2s;}
.ea-pg-zoom-btn:hover{background:rgba(255,186,9,0.25);}
.ea-pg-thumbs{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:12px;}
.ea-pg-thumb{aspect-ratio:1;border-radius:var(--r-sm);overflow:hidden;border:2px solid transparent;background:#F0EEE8;cursor:pointer;transition:border-color .2s,transform .2s;}
.ea-pg-thumb img{width:100%;height:100%;object-fit:cover;display:block;}
.ea-pg-thumb:hover{border-color:rgba(255,186,9,0.50);transform:translateY(-2px);}
.ea-pg-thumb.active{border-color:var(--amber);}
.ea-pg-category-pill{display:inline-block;font-family:'Unbounded',sans-serif;font-size:9px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--tx);background:rgba(255,186,9,0.10);border:1px solid rgba(255,186,9,0.30);padding:5px 14px;border-radius:var(--r-pill);margin-bottom:14px;}
.ea-pg-title{font-family:'Syne',sans-serif;font-size:clamp(26px,2.8vw,44px);font-weight:800;line-height:1.2;color:#1A1A2E;margin:0 0 14px;letter-spacing:-0.5px;}
.ea-pg-short-desc{font-family:'DM Sans',sans-serif;font-size:clamp(14px,1.1vw,16px);color:rgba(26,26,46,0.65);line-height:1.75;margin:0 0 24px;}
.ea-pg-spec-badges{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:28px;}
.ea-pg-badge{display:flex;align-items:center;gap:6px;background:rgba(26,26,46,0.04);border:1px solid rgba(26,26,46,0.10);border-radius:var(--r-sm);padding:7px 12px;font-family:'DM Sans',sans-serif;}
.ea-pg-badge-label{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:#8A5E00;display:block;line-height:1;}
.ea-pg-badge-value{font-size:13px;font-weight:600;color:#1A1A2E;display:block;line-height:1.3;margin-top:2px;}
.ea-pg-config{background:#fff;border:1px solid rgba(26,26,46,0.10);border-radius:var(--r-md);padding:clamp(18px,2vw,26px);margin-bottom:24px;box-shadow:var(--shadow-sm);}
.ea-pg-config-title{font-family:'Syne',sans-serif;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:rgba(26,26,46,0.55);margin-bottom:20px;display:flex;align-items:center;gap:8px;}
.ea-pg-config-title::after{content:'';flex:1;height:1px;background:rgba(26,26,46,0.10);}
.ea-pg-option-group{margin-bottom:20px;}
.ea-pg-option-label{font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:rgba(26,26,46,0.50);margin-bottom:10px;display:flex;align-items:center;gap:8px;}
.ea-pg-option-label span{font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;text-transform:none;letter-spacing:0;color:#1A1A2E;}
.ea-pg-option-btns{display:flex;flex-wrap:wrap;gap:8px;}
.ea-pg-opt-btn{padding:9px 16px;background:rgba(26,26,46,0.04);border:1.5px solid rgba(26,26,46,0.12);border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;color:rgba(26,26,46,0.72);cursor:pointer;transition:border-color .18s,background .18s,color .18s;text-align:center;}
.ea-pg-opt-btn:hover{border-color:rgba(255,186,9,0.50);background:rgba(255,186,9,0.06);color:#1A1A2E;}
.ea-pg-opt-btn.selected{border-color:var(--amber);background:rgba(255,186,9,0.12);color:#1A1A2E;font-weight:700;}
.ea-pg-qty-row{display:flex;align-items:center;gap:10px;margin-bottom:20px;}
.ea-pg-qty-label{font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:rgba(26,26,46,0.50);flex-shrink:0;}
.ea-pg-qty-wrap{display:flex;align-items:center;background:rgba(26,26,46,0.04);border:1.5px solid rgba(26,26,46,0.12);border-radius:var(--r-sm);overflow:hidden;}
.ea-pg-qty-btn{width:38px;height:38px;background:none;border:none;color:rgba(26,26,46,0.55);font-size:18px;cursor:pointer;transition:background .15s,color .15s;display:flex;align-items:center;justify-content:center;}
.ea-pg-qty-btn:hover{background:rgba(255,186,9,0.12);color:var(--amber);}
.ea-pg-qty-num{width:52px;text-align:center;background:none;border:none;border-left:1px solid rgba(26,26,46,0.10);border-right:1px solid rgba(26,26,46,0.10);font-family:'DM Sans',sans-serif;font-size:15px;font-weight:700;color:#1A1A2E;padding:8px 0;outline:none;-moz-appearance:textfield;}
.ea-pg-qty-num::-webkit-outer-spin-button,.ea-pg-qty-num::-webkit-inner-spin-button{-webkit-appearance:none;}
.ea-pg-cta-row{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px;}
.ea-pg-cta-row .btn-amber-solid,.ea-pg-cta-row .btn-outline-amber{flex:1;min-width:160px;}
.ea-pg-wa-link{display:flex;align-items:center;gap:8px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--green);text-decoration:none;transition:color .2s;margin-bottom:24px;}
.ea-pg-wa-link:hover{color:#15803d;}
.ea-pg-trust{display:flex;flex-wrap:wrap;gap:10px;padding-top:20px;border-top:1px solid rgba(26,26,46,0.08);}
.ea-pg-trust-item{display:flex;align-items:center;gap:8px;font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;color:rgba(26,26,46,0.60);}
.ea-pg-trust-item .trust-ico{width:28px;height:28px;border-radius:50%;background:rgba(255,186,9,0.10);border:1px solid rgba(255,186,9,0.20);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.ea-pg-trust-item .trust-ico svg{fill:var(--amber);width:13px;height:13px;}

/* FEATURES */
#ea-pg-features{background:#F7F5F0;padding:clamp(56px,6vw,100px) 0;}
.ea-pg-features-header{text-align:center;margin-bottom:clamp(36px,4vw,56px);}
.ea-pg-features-header h2{font-family:'Syne',sans-serif;font-size:clamp(22px,2.4vw,38px);font-weight:800;color:#1A1A2E;margin:0 0 12px;}
.ea-pg-features-header p{font-family:'DM Sans',sans-serif;font-size:clamp(14px,1vw,16px);color:rgba(26,26,46,0.58);max-width:520px;margin:0 auto;}
.ea-pg-features-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:clamp(14px,2vw,24px);}
@media(max-width:991px){.ea-pg-features-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:575px){.ea-pg-features-grid{grid-template-columns:1fr;}}
.ea-pg-feature-card{background:#fff;border:1px solid rgba(26,26,46,0.08);border-radius:var(--r-md);padding:clamp(20px,2vw,30px);text-align:center;box-shadow:var(--shadow-sm);transition:border-color .25s,background .25s,transform .25s;}
.ea-pg-feature-card:hover{border-color:rgba(255,186,9,0.30);background:rgba(255,186,9,0.04);transform:translateY(-4px);}
.ea-pg-feature-ico{width:52px;height:52px;border-radius:var(--r-sm);background:rgba(255,186,9,0.10);border:1px solid rgba(255,186,9,0.20);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;}
.ea-pg-feature-ico svg{fill:var(--amber);width:24px;height:24px;}
.ea-pg-feature-card h4{font-family:'Syne',sans-serif;font-size:clamp(14px,1.1vw,17px);font-weight:700;color:#1A1A2E;margin:0 0 8px;}
.ea-pg-feature-card p{font-family:'DM Sans',sans-serif;font-size:clamp(13px,0.95vw,15px);color:rgba(26,26,46,0.60);line-height:1.65;margin:0;}

/* SPECS */
#ea-pg-specs{background:#fff;padding:clamp(56px,6vw,100px) 0;}
.ea-pg-specs-inner{max-width:1020px;margin:0 auto;}
.ea-pg-specs-header{margin-bottom:clamp(32px,3.5vw,52px);}
.ea-pg-specs-header h2{font-family:'Syne',sans-serif;font-size:clamp(22px,2.4vw,38px);font-weight:800;color:#1A1A2E;margin:0 0 10px;}
.ea-pg-specs-header p{font-family:'DM Sans',sans-serif;font-size:clamp(14px,1vw,16px);color:rgba(26,26,46,0.58);}
.ea-pg-tabs{display:flex;gap:4px;flex-wrap:wrap;margin-bottom:28px;border-bottom:1px solid rgba(26,26,46,0.10);padding-bottom:0;}
.ea-pg-tab{font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;color:rgba(26,26,46,0.50);padding:10px 20px;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;transition:color .2s,border-color .2s;margin-bottom:-1px;}
.ea-pg-tab:hover{color:rgba(26,26,46,0.80);}
.ea-pg-tab.active{color:#8A5E00;border-bottom-color:var(--amber);}
.ea-pg-tab-panel{display:none;}
.ea-pg-tab-panel.active{display:block;}
.ea-pg-spec-table{width:100%;border-collapse:collapse;}
.ea-pg-spec-table tr{border-bottom:1px solid rgba(26,26,46,0.07);}
.ea-pg-spec-table tr:last-child{border-bottom:none;}
.ea-pg-spec-table td{font-family:'DM Sans',sans-serif;font-size:clamp(13px,0.95vw,15px);padding:14px 16px;vertical-align:top;line-height:1.6;}
.ea-pg-spec-table td:first-child{color:#8A5E00;font-weight:700;width:38%;white-space:nowrap;}
.ea-pg-spec-table td:last-child{color:rgba(26,26,46,0.72);}
.ea-pg-spec-table tr:nth-child(odd) td{background:rgba(26,26,46,0.02);}

/* HOW TO ORDER */
#ea-pg-artwork{background:#F7F5F0;padding:clamp(56px,6vw,100px) 0;}
.ea-pg-hto-grid{display:grid;grid-template-columns:1fr 1fr;gap:clamp(36px,5vw,80px);align-items:start;}
@media(max-width:767px){.ea-pg-hto-grid{grid-template-columns:1fr;}}
.ea-pg-hto-left h2{font-family:'Syne',sans-serif;font-size:clamp(22px,2.4vw,38px);font-weight:800;color:#1A1A2E;margin:0 0 12px;}
.ea-pg-hto-left>p{font-family:'DM Sans',sans-serif;font-size:clamp(14px,1vw,16px);color:rgba(26,26,46,0.58);margin:0 0 38px;}
.ea-pg-steps{display:flex;flex-direction:column;gap:24px;}
.ea-pg-step{display:flex;gap:18px;align-items:flex-start;}
.ea-pg-step-num{font-family:'Unbounded',sans-serif;font-size:11px;font-weight:700;color:var(--tx);background:rgba(255,186,9,0.14);border:1px solid rgba(255,186,9,0.30);border-radius:8px;min-width:36px;height:36px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;}
.ea-pg-step-body h4{font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#1A1A2E;margin:0 0 4px;}
.ea-pg-step-body p{font-family:'DM Sans',sans-serif;font-size:14px;color:rgba(26,26,46,0.60);line-height:1.65;margin:0;}
.ea-pg-artwork-card{background:#fff;border:1.5px dashed rgba(255,186,9,0.30);border-radius:var(--r-md);padding:clamp(28px,3vw,44px);}
.ea-pg-artwork-card h3{font-family:'Syne',sans-serif;font-size:clamp(18px,1.6vw,26px);font-weight:800;color:#1A1A2E;margin:0 0 10px;}
.ea-pg-artwork-card>p{font-family:'DM Sans',sans-serif;font-size:14px;color:rgba(26,26,46,0.60);line-height:1.65;margin:0 0 28px;}
.ea-pg-file-specs{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:28px;}
.ea-pg-file-spec{background:rgba(26,26,46,0.04);border:1px solid rgba(26,26,46,0.08);border-radius:8px;padding:9px 14px;font-family:'DM Sans',sans-serif;}
.ea-pg-file-spec .fs-label{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:#8A5E00;display:block;margin-bottom:3px;}
.ea-pg-file-spec .fs-val{font-size:13px;font-weight:600;color:#1A1A2E;}
.ea-pg-artwork-actions{display:flex;flex-direction:column;gap:10px;}

/* RELATED */
#ea-pg-related{background:var(--cream);padding:clamp(56px,6vw,100px) 0;}
.ea-pg-related-header{display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:clamp(32px,3.5vw,52px);}
.ea-pg-related-header h2{font-family:'Syne',sans-serif;font-size:clamp(22px,2.4vw,38px);font-weight:800;color:#1A1A2E;margin:0;}
.ea-pg-related-see-all{font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;color:#8A5E00;text-decoration:none;display:flex;align-items:center;gap:5px;transition:gap .2s;}
.ea-pg-related-see-all:hover{gap:8px;color:#6D4900;}
.ea-pg-related-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:clamp(14px,2vw,24px);}
@media(max-width:767px){.ea-pg-related-grid{grid-template-columns:1fr;}}
@media(max-width:991px) and (min-width:768px){.ea-pg-related-grid{grid-template-columns:repeat(2,1fr);}}
.ea-pg-rel-card{background:#fff;border:1px solid rgba(26,26,46,0.08);border-radius:var(--r-md);overflow:hidden;transition:border-color .25s,transform .25s,box-shadow .25s;}
.ea-pg-rel-card:hover{border-color:rgba(255,186,9,0.30);transform:translateY(-4px);box-shadow:0 16px 48px rgba(0,0,0,0.12);}
.ea-pg-rel-img{aspect-ratio:16/9;overflow:hidden;background:#F0EEE8;}
.ea-pg-rel-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.55s cubic-bezier(0.25,0.46,0.45,0.94);}
.ea-pg-rel-card:hover .ea-pg-rel-img img{transform:scale(1.05);}
.ea-pg-rel-body{padding:clamp(16px,1.5vw,22px);}
.ea-pg-rel-cat{font-family:'Unbounded',sans-serif;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#8A5E00;display:block;margin-bottom:8px;}
.ea-pg-rel-body h4{font-family:'Syne',sans-serif;font-size:clamp(14px,1.1vw,17px);font-weight:700;color:#1A1A2E;margin:0 0 6px;}
.ea-pg-rel-body p{font-family:'DM Sans',sans-serif;font-size:13px;color:rgba(26,26,46,0.60);line-height:1.65;margin:0 0 16px;}
.ea-pg-rel-link{display:inline-flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;color:rgba(26,26,46,0.55);text-decoration:none;transition:color .2s,gap .2s;}
.ea-pg-rel-link:hover{color:var(--amber);gap:9px;}

/* REVIEWS */
#ea-pg-reviews{background:#fff;padding:clamp(56px,6vw,100px) 0;}
.ea-pg-reviews-header{display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:24px;margin-bottom:clamp(32px,3.5vw,52px);}
.ea-pg-reviews-title h2{font-family:'Syne',sans-serif;font-size:clamp(22px,2.4vw,38px);font-weight:800;color:#1A1A2E;margin:0 0 6px;}
.ea-pg-reviews-title p{font-family:'DM Sans',sans-serif;font-size:14px;color:rgba(26,26,46,0.55);margin:0;}
.ea-pg-reviews-summary{text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:4px;}
.ea-pg-score{font-family:'Unbounded',sans-serif;font-size:clamp(32px,3vw,48px);font-weight:700;color:#1A1A2E;line-height:1;}
.ea-pg-stars{display:flex;gap:3px;justify-content:flex-end;}
.ea-pg-stars svg{fill:var(--amber);width:18px;height:18px;}
.ea-pg-review-count{font-family:'DM Sans',sans-serif;font-size:11px;color:rgba(26,26,46,0.45);text-transform:uppercase;letter-spacing:1px;}
.ea-pg-reviews-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:clamp(14px,2vw,24px);}
@media(max-width:767px){.ea-pg-reviews-grid{grid-template-columns:1fr;}}
@media(max-width:991px) and (min-width:768px){.ea-pg-reviews-grid{grid-template-columns:repeat(2,1fr);}}
.ea-pg-review-card{background:#F7F5F0;border:1px solid rgba(26,26,46,0.08);border-radius:var(--r-md);padding:clamp(20px,2vw,28px);}
.ea-pg-review-stars{display:flex;gap:3px;margin-bottom:12px;}
.ea-pg-review-stars svg{fill:var(--amber);width:14px;height:14px;}
.ea-pg-review-card h5{font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#1A1A2E;margin:0 0 8px;}
.ea-pg-review-card blockquote{font-family:'DM Sans',sans-serif;font-size:clamp(13px,0.95vw,15px);color:rgba(26,26,46,0.65);line-height:1.70;margin:0 0 18px;border:none;padding:0;}
.ea-pg-review-meta{display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(26,26,46,0.08);padding-top:14px;}
.ea-pg-review-meta .reviewer{font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;color:rgba(26,26,46,0.80);}
.ea-pg-review-meta .verified{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#8A5E00;}
.ea-pg-review-meta .rev-date{font-family:'DM Sans',sans-serif;font-size:11px;color:rgba(26,26,46,0.40);}
.ea-pg-reviews-cta{text-align:center;margin-top:40px;}

/* FAQ */
#ea-pg-faq{background:var(--amber);padding:clamp(56px,6vw,100px) 0;position:relative;overflow:hidden;}
#ea-pg-faq::before{content:'';position:absolute;inset:0;z-index:0;pointer-events:none;background:radial-gradient(ellipse at 5% 50%,rgba(255,255,255,0.10) 0%,transparent 55%),radial-gradient(ellipse at 95% 20%,rgba(0,0,0,0.06) 0%,transparent 45%);}
#ea-pg-faq .container{position:relative;z-index:1;}
.ea-pg-faq-grid{display:grid;grid-template-columns:1fr 2fr;gap:clamp(36px,5vw,80px);align-items:start;}
@media(max-width:767px){.ea-pg-faq-grid{grid-template-columns:1fr;}}
.ea-pg-faq-left h2{font-family:'Syne',sans-serif;font-size:clamp(24px,2.8vw,44px);font-weight:800;color:var(--tx);margin:0 0 14px;line-height:1.2;}
.ea-pg-faq-left p{font-family:'DM Sans',sans-serif;font-size:clamp(14px,1vw,16px);color:rgba(26,26,46,0.65);line-height:1.7;margin:0 0 28px;}
.ea-pg-acc-item{border-bottom:1px solid rgba(26,26,46,0.14);}
.ea-pg-acc-item:first-child{border-top:1px solid rgba(26,26,46,0.14);}
.ea-pg-acc-trigger{width:100%;background:none;border:none;cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 0;text-align:left;}
.ea-pg-acc-q{font-family:'DM Sans',sans-serif;font-size:clamp(14px,1.1vw,17px);font-weight:700;color:var(--tx);flex:1;}
.ea-pg-acc-icon{width:28px;height:28px;border-radius:50%;background:rgba(26,26,46,0.10);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .2s,transform .3s;}
.ea-pg-acc-icon svg{fill:var(--tx);width:14px;height:14px;transition:transform .3s;}
.ea-pg-acc-item.open .ea-pg-acc-icon{background:var(--tx);}
.ea-pg-acc-item.open .ea-pg-acc-icon svg{fill:var(--amber);transform:rotate(45deg);}
.ea-pg-acc-body{max-height:0;overflow:hidden;transition:max-height .35s cubic-bezier(0.4,0,0.2,1),padding .35s;padding:0;}
.ea-pg-acc-item.open .ea-pg-acc-body{max-height:400px;padding-bottom:20px;}
.ea-pg-acc-answer{font-family:'DM Sans',sans-serif;font-size:clamp(13px,0.95vw,15px);color:rgba(26,26,46,0.72);line-height:1.75;margin:0;}

/* CTA STRIP */
#ea-pg-cta{background:var(--bg-dark1);padding:clamp(52px,5.5vw,90px) 0;position:relative;overflow:hidden;}
#ea-pg-cta::before{content:'';position:absolute;inset:0;z-index:0;pointer-events:none;background:radial-gradient(ellipse at 50% 50%,rgba(255,186,9,0.08) 0%,transparent 60%);}
.ea-pg-cta-inner{position:relative;z-index:1;text-align:center;max-width:760px;margin:0 auto;}
.ea-pg-cta-inner h2{font-family:'Syne',sans-serif;font-size:clamp(24px,2.8vw,44px);font-weight:800;color:#fff;margin:0 0 14px;line-height:1.2;}
.ea-pg-cta-inner p{font-family:'DM Sans',sans-serif;font-size:clamp(14px,1.1vw,17px);color:rgba(255,255,255,0.58);line-height:1.7;margin:0 0 36px;}
.ea-pg-cta-btns{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:14px;}
.ea-pg-cta-note{margin-top:20px;font-family:'DM Sans',sans-serif;font-size:12px;color:rgba(255,255,255,0.30);letter-spacing:0.3px;}

/* STICKY BAR */
.ea-sticky-bar{display:none;position:fixed;bottom:0;left:0;right:0;z-index:9999;background:#0A0A14;box-shadow:0 -2px 16px rgba(0,0,0,0.4);border-top:1px solid rgba(255,186,9,0.22);}
.ea-sticky-btn{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:3px;padding:10px 4px 8px;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;text-decoration:none;text-transform:uppercase;letter-spacing:0.4px;transition:background 0.15s;}
.ea-sticky-call{color:#60a5fa;border-right:1px solid rgba(255,255,255,0.08);}
.ea-sticky-wa{color:#4ade80;border-right:1px solid rgba(255,255,255,0.08);}
.ea-sticky-quote{color:var(--amber);}
@media(max-width:767px){.ea-sticky-bar{display:flex;}body{padding-bottom:62px;}}
</style>

<div id="ea-wb-wrap" class="ea-wb">

<!-- BREADCRUMB -->
<section id="ea-pg-breadcrumb">
  <div class="container">
    <ol class="ea-breadcrumb">
      <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
      <li><span class="sep">›</span></li>
      <li><a href="<?php echo home_url('/backdrops-displays/'); ?>">Backdrops &amp; Displays</a></li>
      <li><span class="sep">›</span></li>
      <li class="active">Wooden Backdrop Dubai</li>
    </ol>
  </div>
</section>

<!-- HERO -->
<section id="ea-pg-hero">
  <div class="container">
    <div class="ea-pg-hero-grid">

      <!-- Gallery Column -->
      <div class="reveal">
        <div class="ea-pg-main-img" id="eaMainImg">
          <img src="<?php echo home_url('/wp-content/uploads/2022/03/Step-Repeat-Backdrop.jpg'); ?>" alt="Wooden Backdrop Dubai — Step Repeat Custom Print" id="eaMainImgEl" loading="eager">
          <button class="ea-pg-zoom-btn" aria-label="Zoom image">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
          </button>
        </div>
        <div class="ea-pg-thumbs">
          <div class="ea-pg-thumb active" data-src="<?php echo home_url('/wp-content/uploads/2022/03/Step-Repeat-Backdrop.jpg'); ?>" data-alt="Wooden Backdrop Dubai">
            <img src="<?php echo home_url('/wp-content/uploads/2022/03/Step-Repeat-Backdrop.jpg'); ?>" alt="Wooden Backdrop thumb 1" loading="lazy">
          </div>
          <div class="ea-pg-thumb" data-src="<?php echo home_url('/wp-content/uploads/2022/03/Step-Repeat-Backdrop-2.jpg'); ?>" data-alt="Wooden Step Repeat Backdrop">
            <img src="<?php echo home_url('/wp-content/uploads/2022/03/Step-Repeat-Backdrop-2.jpg'); ?>" alt="Wooden Backdrop thumb 2" loading="lazy">
          </div>
          <div class="ea-pg-thumb" data-src="<?php echo home_url('/wp-content/uploads/2026/03/event-backdrop-corporate.jpg'); ?>" data-alt="Corporate Event Backdrop">
            <img src="<?php echo home_url('/wp-content/uploads/2026/03/event-backdrop-corporate.jpg'); ?>" alt="Wooden Backdrop thumb 3" loading="lazy">
          </div>
        </div>
      </div>

      <!-- Config Column -->
      <div class="reveal">
        <div class="ea-pg-category-pill">Backdrops &amp; Displays</div>
        <h1 class="ea-pg-title">Wooden Backdrop<br>Dubai</h1>
        <p class="ea-pg-short-desc">Solid timber frame backdrops with premium dye-sub or direct-print fabric panels. Custom sizes for events, exhibitions, brand activations and press walls across the UAE. Delivered and installed.</p>

        <div class="ea-pg-spec-badges">
          <div class="ea-pg-badge">
            <span class="ea-pg-badge-label">Frame</span>
            <span class="ea-pg-badge-value">MDF / Hardwood</span>
          </div>
          <div class="ea-pg-badge">
            <span class="ea-pg-badge-label">Print</span>
            <span class="ea-pg-badge-value">Dye-Sub / Direct</span>
          </div>
          <div class="ea-pg-badge">
            <span class="ea-pg-badge-label">Turnaround</span>
            <span class="ea-pg-badge-value">3–5 Days</span>
          </div>
          <div class="ea-pg-badge">
            <span class="ea-pg-badge-label">Delivery</span>
            <span class="ea-pg-badge-value">UAE-Wide</span>
          </div>
        </div>

        <div class="ea-pg-config">
          <div class="ea-pg-config-title">Configure Your Order</div>

          <div class="ea-pg-option-group">
            <div class="ea-pg-option-label">Frame Type <span id="lbl-frame">Standard MDF</span></div>
            <div class="ea-pg-option-btns" data-group="frame">
              <button class="ea-pg-opt-btn selected" data-label="Standard MDF">Standard MDF</button>
              <button class="ea-pg-opt-btn" data-label="Premium Hardwood">Premium Hardwood</button>
              <button class="ea-pg-opt-btn" data-label="Curved Wooden">Curved Wooden</button>
            </div>
          </div>

          <div class="ea-pg-option-group">
            <div class="ea-pg-option-label">Fabric / Print <span id="lbl-fabric">Dye-Sub Polyester</span></div>
            <div class="ea-pg-option-btns" data-group="fabric">
              <button class="ea-pg-opt-btn selected" data-label="Dye-Sub Polyester">Dye-Sub Polyester</button>
              <button class="ea-pg-opt-btn" data-label="Vinyl Print">Vinyl Print</button>
            </div>
          </div>

          <div class="ea-pg-option-group">
            <div class="ea-pg-option-label">Size <span id="lbl-size">2 × 2 m</span></div>
            <div class="ea-pg-option-btns" data-group="size">
              <button class="ea-pg-opt-btn selected" data-label="2 × 2 m">2 × 2 m</button>
              <button class="ea-pg-opt-btn" data-label="2 × 3 m">2 × 3 m</button>
              <button class="ea-pg-opt-btn" data-label="3 × 4 m">3 × 4 m</button>
              <button class="ea-pg-opt-btn" data-label="Custom Size">Custom Size</button>
            </div>
          </div>

          <div class="ea-pg-qty-row">
            <span class="ea-pg-qty-label">Qty</span>
            <div class="ea-pg-qty-wrap">
              <button class="ea-pg-qty-btn" id="eaQtyMinus" aria-label="Decrease">−</button>
              <input class="ea-pg-qty-num" type="number" id="eaQtyNum" value="1" min="1" max="99" aria-label="Quantity">
              <button class="ea-pg-qty-btn" id="eaQtyPlus" aria-label="Increase">+</button>
            </div>
          </div>
        </div>

        <div class="ea-pg-cta-row">
          <a href="<?php echo home_url('/contact-us/?product=wooden-backdrop-dubai'); ?>" class="btn-amber-solid">
            <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            Get a Quote
          </a>
          <a href="tel:+97143384882" class="btn-outline-amber">
            <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
            Call Us
          </a>
        </div>

        <a href="https://wa.me/971527966265?text=Hi%2C%20I%20need%20a%20quote%20for%20wooden-backdrop-dubai" class="ea-pg-wa-link" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Chat on WhatsApp — quick quote in minutes
        </a>

        <div class="ea-pg-trust">
          <div class="ea-pg-trust-item">
            <div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M12 1l3.09 6.26L22 8.27l-5 4.87 1.18 6.88L12 16.77l-6.18 3.25L7 13.14 2 8.27l6.91-1.01L12 1z"/></svg></div>
            18+ Years Experience
          </div>
          <div class="ea-pg-trust-item">
            <div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div>
            500+ Events Served
          </div>
          <div class="ea-pg-trust-item">
            <div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M5 12l5 5L20 7"/></svg></div>
            Delivery &amp; Install
          </div>
          <div class="ea-pg-trust-item">
            <div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            UAE-Wide Coverage
          </div>
        </div>
      </div>

    </div><!-- /.ea-pg-hero-grid -->
  </div><!-- /.container -->
</section>
<!-- BATCH 2 COMPLETE — FEATURES + SPECS follow -->

<!-- FEATURES -->
<section id="ea-pg-features">
  <div class="container">
    <div class="ea-pg-features-header reveal">
      <div class="sec-label">Why Choose Us</div>
      <h2>Built for Brands, Events &amp; Exhibitions</h2>
      <p>Every wooden backdrop is crafted with care — solid frames, vibrant print, fast delivery across the UAE.</p>
    </div>
    <div class="ea-pg-features-grid">

      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico">
          <svg viewBox="0 0 24 24" width="24" height="24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </div>
        <h4>Solid Wooden Frame</h4>
        <p>Premium MDF or hardwood construction that stands firm throughout your event — no wobble, no compromise.</p>
      </div>

      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico">
          <svg viewBox="0 0 24 24" width="24" height="24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
        </div>
        <h4>Dye-Sub &amp; Direct Print</h4>
        <p>Vivid CMYK colours with no banding. Fabric panels are precision-printed and tensioned for a wrinkle-free finish.</p>
      </div>

      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico">
          <svg viewBox="0 0 24 24" width="24" height="24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
        </div>
        <h4>Any Size, Any Shape</h4>
        <p>Standard 2×2 m to wall-sized 6×3 m and beyond. Curved, arch, and custom profiles available on request.</p>
      </div>

      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico">
          <svg viewBox="0 0 24 24" width="24" height="24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <h4>Brand Activations</h4>
        <p>Red carpet press walls, product launches, corporate events — your logo perfectly positioned every time.</p>
      </div>

      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico">
          <svg viewBox="0 0 24 24" width="24" height="24"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
        </div>
        <h4>Tool-Free Assembly</h4>
        <p>Snap-together frame system assembles in minutes. No tools needed — your team can set up independently.</p>
      </div>

      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico">
          <svg viewBox="0 0 24 24" width="24" height="24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
        <h4>Delivery &amp; Installation</h4>
        <p>We deliver and install across Dubai, Abu Dhabi, Sharjah, and all UAE emirates. Dismantling included.</p>
      </div>

      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico">
          <svg viewBox="0 0 24 24" width="24" height="24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
        </div>
        <h4>Custom Shapes</h4>
        <p>Arch tops, hexagonal panels, and branded silhouettes — we cut and build bespoke frames to match your design.</p>
      </div>

      <div class="ea-pg-feature-card reveal">
        <div class="ea-pg-feature-ico">
          <svg viewBox="0 0 24 24" width="24" height="24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <h4>18 Years of Excellence</h4>
        <p>Since 2006, Efficient Advertising has produced thousands of backdrops for Fortune 500 brands and local events.</p>
      </div>

    </div>
  </div>
</section>

<!-- SPECS -->
<section id="ea-pg-specs">
  <div class="container">
    <div class="ea-pg-specs-inner">
      <div class="ea-pg-specs-header reveal">
        <div class="sec-label">Technical Specifications</div>
        <h2>Full Product Specifications</h2>
        <p>Everything you need to plan your wooden backdrop order — materials, print, use cases, and artwork requirements.</p>
      </div>

      <div class="ea-pg-tabs reveal" role="tablist">
        <button class="ea-pg-tab active" role="tab" data-tab="frame" aria-selected="true">Frame Options</button>
        <button class="ea-pg-tab" role="tab" data-tab="fabric" aria-selected="false">Fabric &amp; Print</button>
        <button class="ea-pg-tab" role="tab" data-tab="uses" aria-selected="false">Use Cases</button>
        <button class="ea-pg-tab" role="tab" data-tab="files" aria-selected="false">File Specs</button>
      </div>

      <div class="ea-pg-tab-panel active reveal" id="tab-frame" role="tabpanel">
        <table class="ea-pg-spec-table">
          <tbody>
            <tr><td>Standard MDF Frame</td><td>18 mm moisture-resistant MDF, smooth finish, sealed edges — ideal for indoor events up to 3 × 3 m</td></tr>
            <tr><td>Premium Hardwood</td><td>Kiln-dried hardwood timber, lacquered or stained finish — best for repeated use and outdoor sheltered areas</td></tr>
            <tr><td>Curved / Arch</td><td>CNC-routed curved top or full arch profile; same materials, additional 2-day lead time</td></tr>
            <tr><td>Max Standard Size</td><td>6 m wide × 3 m tall (custom engineering available for larger)</td></tr>
            <tr><td>Frame Weight</td><td>2 × 2 m ≈ 18 kg | 3 × 4 m ≈ 42 kg (approximate, varies by spec)</td></tr>
            <tr><td>Feet / Base</td><td>Adjustable floor feet included; optional weighted uprights for outdoor use</td></tr>
          </tbody>
        </table>
      </div>

      <div class="ea-pg-tab-panel reveal" id="tab-fabric" role="tabpanel">
        <table class="ea-pg-spec-table">
          <tbody>
            <tr><td>Dye-Sub Polyester</td><td>200 gsm knit polyester; heat-sublimated — brightest colours, no fading indoors, fully recyclable panels</td></tr>
            <tr><td>Vinyl Print</td><td>440 gsm PVC vinyl; solvent or UV inks — higher durability for outdoor exposure or rough handling</td></tr>
            <tr><td>Colour Profile</td><td>sRGB or CMYK; maximum colour gamut on both substrates</td></tr>
            <tr><td>Resolution Output</td><td>360 dpi at final print size — we upscale from 150 dpi artwork with sharpening</td></tr>
            <tr><td>Fabric Finish</td><td>Matte only (dye-sub) | Matte or gloss (vinyl)</td></tr>
            <tr><td>Panel Attachment</td><td>Stretch-fit silicone edge graphic (SEG) channel or Velcro tape on back of frame</td></tr>
          </tbody>
        </table>
      </div>

      <div class="ea-pg-tab-panel reveal" id="tab-uses" role="tabpanel">
        <table class="ea-pg-spec-table">
          <tbody>
            <tr><td>Press &amp; Media Walls</td><td>Step-and-repeat logo layouts for press conferences, award ceremonies, and media events</td></tr>
            <tr><td>Exhibition Stands</td><td>Back-wall displays for trade shows, GITEX, INDEX, and government expos</td></tr>
            <tr><td>Brand Activations</td><td>Immersive branded environments for product launches, pop-ups, and experiential campaigns</td></tr>
            <tr><td>Corporate Events</td><td>Conference backdrops, stage headers, host podium surrounds</td></tr>
            <tr><td>Social &amp; Weddings</td><td>Photo-booth backdrops, flower-wall surrounds, wedding and birthday photo moments</td></tr>
            <tr><td>Retail &amp; F&amp;B</td><td>Window backdrops, self-serve photo areas, seasonal campaign displays</td></tr>
          </tbody>
        </table>
      </div>

      <div class="ea-pg-tab-panel reveal" id="tab-files" role="tabpanel">
        <table class="ea-pg-spec-table">
          <tbody>
            <tr><td>Preferred Format</td><td>PDF (print-ready) or AI / EPS with outlined fonts and embedded links</td></tr>
            <tr><td>Accepted Formats</td><td>PDF, AI, EPS, PSD, TIFF, high-res JPEG (300 dpi minimum at final size)</td></tr>
            <tr><td>Colour Mode</td><td>CMYK preferred; we convert RGB — expect slight shift on very saturated hues</td></tr>
            <tr><td>Bleed</td><td>30 mm on all sides; keep logos and text 40 mm from finished edge</td></tr>
            <tr><td>Resolution</td><td>150 dpi at final print size (300 dpi ideal); vector sources at any resolution</td></tr>
            <tr><td>File Delivery</td><td>WeTransfer, Google Drive, or WhatsApp for files under 50 MB</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- HOW TO ORDER -->
<section id="ea-pg-artwork">
  <div class="container">
    <div class="ea-pg-hto-grid">
      <div class="ea-pg-hto-left reveal">
        <div class="sec-label">Simple Process</div>
        <h2>How to Order Your Wooden Backdrop</h2>
        <p>From artwork to delivered-and-installed — here's exactly what happens after you reach out.</p>
        <div class="ea-pg-steps">
          <div class="ea-pg-step">
            <div class="ea-pg-step-num">01</div>
            <div class="ea-pg-step-body">
              <h4>Send Us Your Brief</h4>
              <p>Share your size, frame type, and event date. WhatsApp or email — whichever you prefer.</p>
            </div>
          </div>
          <div class="ea-pg-step">
            <div class="ea-pg-step-num">02</div>
            <div class="ea-pg-step-body">
              <h4>Receive a Quotation</h4>
              <p>We respond within 2 hours with a detailed quote including delivery and installation costs.</p>
            </div>
          </div>
          <div class="ea-pg-step">
            <div class="ea-pg-step-num">03</div>
            <div class="ea-pg-step-body">
              <h4>Approve Artwork Proof</h4>
              <p>Upload your print file or send your logo — we create a free layout proof within 24 hours for your sign-off.</p>
            </div>
          </div>
          <div class="ea-pg-step">
            <div class="ea-pg-step-num">04</div>
            <div class="ea-pg-step-body">
              <h4>We Build, Deliver &amp; Install</h4>
              <p>Production in 3–5 days. Our team delivers and installs at your venue, then dismantles when done.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="reveal">
        <div class="ea-pg-artwork-card">
          <div class="sec-label">Artwork Upload</div>
          <h3>Send Your Print File</h3>
          <p>Share your artwork via WhatsApp, WeTransfer, or email. Not ready? Send your logo and we'll create a layout for you — no extra charge.</p>
          <div class="ea-pg-file-specs">
            <div class="ea-pg-file-spec">
              <span class="fs-label">Format</span>
              <span class="fs-val">PDF / AI / PSD</span>
            </div>
            <div class="ea-pg-file-spec">
              <span class="fs-label">Resolution</span>
              <span class="fs-val">150 dpi min</span>
            </div>
            <div class="ea-pg-file-spec">
              <span class="fs-label">Colour Mode</span>
              <span class="fs-val">CMYK</span>
            </div>
            <div class="ea-pg-file-spec">
              <span class="fs-label">Bleed</span>
              <span class="fs-val">30 mm</span>
            </div>
          </div>
          <div class="ea-pg-artwork-actions">
            <a href="https://wa.me/971527966265?text=Hi%2C%20I%20want%20to%20send%20artwork%20for%20my%20wooden%20backdrop%20order" class="btn-amber-solid" target="_blank" rel="noopener">
              <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Send via WhatsApp
            </a>
            <a href="<?php echo home_url('/contact-us/?product=wooden-backdrop-dubai'); ?>" class="btn-outline-dark">
              <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
              Email Artwork &amp; Brief
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- RELATED -->
<section id="ea-pg-related">
  <div class="container">
    <div class="ea-pg-related-header reveal">
      <div>
        <div class="sec-label">Related Products</div>
        <h2>More Backdrops &amp; Displays</h2>
      </div>
      <a href="<?php echo home_url('/backdrops-displays/'); ?>" class="ea-pg-related-see-all">
        View All
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
    <div class="ea-pg-related-grid">

      <a href="<?php echo home_url('/product/fabric-backdrop/'); ?>" class="ea-pg-rel-card reveal">
        <div class="ea-pg-rel-img">
          <img src="<?php echo home_url('/wp-content/uploads/2022/03/Step-Repeat-Backdrop-2.jpg'); ?>" alt="Fabric Backdrop Dubai" loading="lazy">
        </div>
        <div class="ea-pg-rel-body">
          <span class="ea-pg-rel-cat">Backdrops &amp; Displays</span>
          <h4>Fabric Backdrop Dubai</h4>
          <p>Lightweight tensioned fabric backdrops with vivid dye-sub print. Pop-up stand or wall-mounted.</p>
          <span class="ea-pg-rel-link">View Product <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>

      <a href="<?php echo home_url('/product/exhibition-stand-dubai/'); ?>" class="ea-pg-rel-card reveal">
        <div class="ea-pg-rel-img">
          <img src="<?php echo home_url('/wp-content/uploads/2026/03/event-backdrop-corporate.jpg'); ?>" alt="Exhibition Stand Dubai" loading="lazy">
        </div>
        <div class="ea-pg-rel-body">
          <span class="ea-pg-rel-cat">Exhibition Stands</span>
          <h4>Exhibition Stand Dubai</h4>
          <p>Custom-built exhibition stands from modular shell scheme to full custom-build for GITEX &amp; INDEX.</p>
          <span class="ea-pg-rel-link">View Product <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>

      <a href="<?php echo home_url('/product/pull-up-banner/'); ?>" class="ea-pg-rel-card reveal">
        <div class="ea-pg-rel-img">
          <img src="<?php echo home_url('/wp-content/uploads/2022/03/Step-Repeat-Backdrop.jpg'); ?>" alt="Pull Up Banner Dubai" loading="lazy">
        </div>
        <div class="ea-pg-rel-body">
          <span class="ea-pg-rel-cat">Banners &amp; Stands</span>
          <h4>Pull Up Banner Dubai</h4>
          <p>Roll-up banner stands with high-quality print. Available in standard, wide, and retractable versions.</p>
          <span class="ea-pg-rel-link">View Product <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>

    </div>
  </div>
</section>

<!-- REVIEWS -->
<section id="ea-pg-reviews">
  <div class="container">
    <div class="ea-pg-reviews-header reveal">
      <div class="ea-pg-reviews-title">
        <div class="sec-label">Customer Reviews</div>
        <h2>What Our Clients Say</h2>
        <p>Trusted by event agencies, government bodies, and brands across the UAE since 2006.</p>
      </div>
      <div class="ea-pg-reviews-summary">
        <div class="ea-pg-score">4.9</div>
        <div class="ea-pg-stars">
          <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <div class="ea-pg-review-count">47 verified reviews</div>
      </div>
    </div>

    <div class="ea-pg-reviews-grid">

      <div class="ea-pg-review-card reveal">
        <div class="ea-pg-review-stars">
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <h5>Exceptional Quality &amp; Speed</h5>
        <blockquote>"We ordered a 4×3 m hardwood backdrop for our product launch. The finish was flawless, the print was sharp, and the team installed everything perfectly on-site. Highly recommend."</blockquote>
        <div class="ea-pg-review-meta">
          <div>
            <div class="reviewer">Layla Al Rashidi</div>
            <div class="verified">✓ Verified Client</div>
          </div>
          <div class="rev-date">March 2025</div>
        </div>
      </div>

      <div class="ea-pg-review-card reveal">
        <div class="ea-pg-review-stars">
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <h5>Go-To Supplier for All Our Events</h5>
        <blockquote>"Used Efficient Advertising for 12 events in 2024 — from press walls to wedding backdrops. Consistent quality, fast turnaround, and the WhatsApp service is brilliant."</blockquote>
        <div class="ea-pg-review-meta">
          <div>
            <div class="reviewer">Tariq Mansoor</div>
            <div class="verified">✓ Verified Client</div>
          </div>
          <div class="rev-date">January 2025</div>
        </div>
      </div>

      <div class="ea-pg-review-card reveal">
        <div class="ea-pg-review-stars">
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l3.09 6.26L22 9.27l-5 4.73L18.18 21 12 17.27 5.82 21 7 14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <h5>Custom Arch Backdrop — Perfect</h5>
        <blockquote>"We needed a curved arch backdrop for our retail pop-up. Efficient built exactly what we designed, delivered to the mall, and installed without any fuss. Will order again."</blockquote>
        <div class="ea-pg-review-meta">
          <div>
            <div class="reviewer">Sarah Johnson</div>
            <div class="verified">✓ Verified Client</div>
          </div>
          <div class="rev-date">November 2024</div>
        </div>
      </div>

    </div>
    <div class="ea-pg-reviews-cta reveal">
      <a href="<?php echo home_url('/contact-us/'); ?>" class="btn-outline-dark">See More Reviews on Google</a>
    </div>
  </div>
</section>
<!-- BATCH 3 COMPLETE — FAQ + CTA + JS follow -->

<!-- FAQ -->
<section id="ea-pg-faq">
  <div class="container">
    <div class="ea-pg-faq-grid">

      <div class="reveal">
        <div class="sec-label" style="background:rgba(26,26,46,0.10);border-color:rgba(26,26,46,0.20);color:#1A1A2E;">FAQ</div>
        <h2>Frequently Asked Questions</h2>
        <p>Common questions about wooden backdrop printing and delivery in Dubai and across the UAE.</p>
        <a href="<?php echo home_url('/contact-us/'); ?>" class="btn-outline-dark" style="margin-top:8px;">More Questions? Ask Us</a>
      </div>

      <div class="reveal">
        <div class="ea-pg-acc-item open">
          <button class="ea-pg-acc-trigger" aria-expanded="true">
            <span class="ea-pg-acc-q">What sizes are available for wooden backdrops?</span>
            <span class="ea-pg-acc-icon"><svg viewBox="0 0 24 24" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
          </button>
          <div class="ea-pg-acc-body">
            <p class="ea-pg-acc-answer">We build wooden backdrops in any size from 1×1 m up to 6×3 m as standard. Larger or custom shapes (arch, hexagonal, curved top) are available with a 2-day additional lead time. Just tell us your required dimensions and we'll quote accordingly.</p>
          </div>
        </div>

        <div class="ea-pg-acc-item">
          <button class="ea-pg-acc-trigger" aria-expanded="false">
            <span class="ea-pg-acc-q">What is the difference between MDF and hardwood frames?</span>
            <span class="ea-pg-acc-icon"><svg viewBox="0 0 24 24" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
          </button>
          <div class="ea-pg-acc-body">
            <p class="ea-pg-acc-answer">Standard MDF frames are lightweight, cost-effective, and ideal for one-time indoor events. Premium hardwood frames are heavier-duty with a lacquered or stained finish — better suited to repeated use, outdoor sheltered areas, and premium-look activations. Hardwood adds approximately 2–3 days to production time.</p>
          </div>
        </div>

        <div class="ea-pg-acc-item">
          <button class="ea-pg-acc-trigger" aria-expanded="false">
            <span class="ea-pg-acc-q">How long does production and delivery take?</span>
            <span class="ea-pg-acc-icon"><svg viewBox="0 0 24 24" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
          </button>
          <div class="ea-pg-acc-body">
            <p class="ea-pg-acc-answer">Standard MDF backdrops are ready in 3–5 business days from artwork approval. Hardwood or custom shapes take 5–7 days. We deliver and install across Dubai, Abu Dhabi, and all UAE emirates. For urgent projects, contact us — we often accommodate rush orders with a 24–48 hour turnaround.</p>
          </div>
        </div>

        <div class="ea-pg-acc-item">
          <button class="ea-pg-acc-trigger" aria-expanded="false">
            <span class="ea-pg-acc-q">Do you handle delivery and installation?</span>
            <span class="ea-pg-acc-icon"><svg viewBox="0 0 24 24" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
          </button>
          <div class="ea-pg-acc-body">
            <p class="ea-pg-acc-answer">Yes. We deliver to your venue and our team handles full installation, ensuring everything is level, stable, and photo-ready. We also offer dismantling and collection after your event. Delivery and install is quoted per project based on location and size.</p>
          </div>
        </div>

        <div class="ea-pg-acc-item">
          <button class="ea-pg-acc-trigger" aria-expanded="false">
            <span class="ea-pg-acc-q">What artwork file do I need to provide?</span>
            <span class="ea-pg-acc-icon"><svg viewBox="0 0 24 24" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
          </button>
          <div class="ea-pg-acc-body">
            <p class="ea-pg-acc-answer">A print-ready PDF or Adobe Illustrator file is preferred, CMYK at 150 dpi minimum (at final size) with 30 mm bleed. If you only have a logo, our designers will create a layout for you at no extra cost — just share your logo files and describe what you want.</p>
          </div>
        </div>

        <div class="ea-pg-acc-item">
          <button class="ea-pg-acc-trigger" aria-expanded="false">
            <span class="ea-pg-acc-q">Can I reuse the backdrop at multiple events?</span>
            <span class="ea-pg-acc-icon"><svg viewBox="0 0 24 24" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
          </button>
          <div class="ea-pg-acc-body">
            <p class="ea-pg-acc-answer">Absolutely. Both MDF and hardwood frames are designed to be assembled and disassembled multiple times. Fabric panels can be removed, washed, and reattached. If your design changes, we can print a new panel that clips straight onto your existing frame — a cost-effective way to refresh your backdrop seasonally.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- CTA STRIP -->
<section id="ea-pg-cta">
  <div class="container">
    <div class="ea-pg-cta-inner reveal">
      <div class="sec-label-dark">Get Started Today</div>
      <h2>Ready to Order Your<br>Wooden Backdrop?</h2>
      <p>Tell us your size, event date, and design — we'll have a quote ready within 2 hours. Delivery and installation included across the UAE.</p>
      <div class="ea-pg-cta-btns">
        <a href="<?php echo home_url('/contact-us/?product=wooden-backdrop-dubai'); ?>" class="btn-amber-solid">
          <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
          Request a Quote
        </a>
        <a href="https://wa.me/971527966265?text=Hi%2C%20I%20need%20a%20quote%20for%20a%20wooden%20backdrop%20in%20Dubai" class="btn-outline-amber" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp Us
        </a>
        <a href="tel:+97143384882" class="btn-outline-white">
          <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
          +971 4 338 4882
        </a>
      </div>
      <p class="ea-pg-cta-note">No minimum order · UAE-wide delivery &amp; installation · Free artwork layout</p>
    </div>
  </div>
</section>

<!-- WHATSAPP FLOAT -->
<a href="https://wa.me/971527966265?text=Hi%2C%20I%20need%20a%20quote%20for%20a%20wooden%20backdrop%20in%20Dubai"
   target="_blank" rel="noopener"
   aria-label="Chat on WhatsApp"
   style="position:fixed;bottom:80px;right:24px;z-index:9998;width:54px;height:54px;border-radius:50%;background:#25D366;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 18px rgba(37,211,102,0.45);transition:transform .2s,box-shadow .2s;"
   onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
  <svg viewBox="0 0 24 24" fill="#fff" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<!-- STICKY MOBILE BAR -->
<div class="ea-sticky-bar" role="navigation" aria-label="Quick actions">
  <a href="tel:+97143384882" class="ea-sticky-btn ea-sticky-call">
    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
    Call
  </a>
  <a href="https://wa.me/971527966265?text=Hi%2C%20wooden%20backdrop%20quote%20please" class="ea-sticky-btn ea-sticky-wa" target="_blank" rel="noopener">
    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    WhatsApp
  </a>
  <a href="<?php echo home_url('/contact-us/?product=wooden-backdrop-dubai'); ?>" class="ea-sticky-btn ea-sticky-quote">
    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
    Quote
  </a>
</div>

</div><!-- /#ea-wb-wrap -->

<script>
(function(){
  /* --- Scroll Reveal --- */
  var revEls = document.querySelectorAll('.reveal');
  if('IntersectionObserver' in window){
    var obs = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target);}
      });
    },{threshold:0.12});
    revEls.forEach(function(el){obs.observe(el);});
  } else {
    revEls.forEach(function(el){el.classList.add('visible');});
  }

  /* --- Thumbnail swapper --- */
  var thumbs = document.querySelectorAll('.ea-pg-thumb');
  var mainImg = document.getElementById('eaMainImgEl');
  if(thumbs.length && mainImg){
    thumbs.forEach(function(t){
      t.addEventListener('click',function(){
        thumbs.forEach(function(x){x.classList.remove('active');});
        t.classList.add('active');
        mainImg.src = t.dataset.src;
        mainImg.alt = t.dataset.alt || '';
      });
    });
  }

  /* --- Option buttons --- */
  var optGroups = document.querySelectorAll('[data-group]');
  optGroups.forEach(function(grp){
    var groupName = grp.dataset.group;
    var lbl = document.getElementById('lbl-'+groupName);
    grp.querySelectorAll('.ea-pg-opt-btn').forEach(function(btn){
      btn.addEventListener('click',function(){
        grp.querySelectorAll('.ea-pg-opt-btn').forEach(function(b){b.classList.remove('selected');});
        btn.classList.add('selected');
        if(lbl) lbl.textContent = btn.dataset.label || btn.textContent;
      });
    });
  });

  /* --- Quantity --- */
  var qtyNum = document.getElementById('eaQtyNum');
  var qtyMinus = document.getElementById('eaQtyMinus');
  var qtyPlus  = document.getElementById('eaQtyPlus');
  if(qtyNum && qtyMinus && qtyPlus){
    qtyMinus.addEventListener('click',function(){
      var v = parseInt(qtyNum.value,10);
      if(v > 1) qtyNum.value = v - 1;
    });
    qtyPlus.addEventListener('click',function(){
      var v = parseInt(qtyNum.value,10);
      if(v < 99) qtyNum.value = v + 1;
    });
  }

  /* --- Spec Tabs --- */
  var tabs       = document.querySelectorAll('.ea-pg-tab');
  var tabPanels  = document.querySelectorAll('.ea-pg-tab-panel');
  tabs.forEach(function(tab){
    tab.addEventListener('click',function(){
      tabs.forEach(function(t){t.classList.remove('active');t.setAttribute('aria-selected','false');});
      tabPanels.forEach(function(p){p.classList.remove('active');});
      tab.classList.add('active');
      tab.setAttribute('aria-selected','true');
      var target = document.getElementById('tab-'+tab.dataset.tab);
      if(target) target.classList.add('active');
    });
  });

  /* --- FAQ Accordion --- */
  var accItems = document.querySelectorAll('.ea-pg-acc-item');
  accItems.forEach(function(item){
    var trigger = item.querySelector('.ea-pg-acc-trigger');
    if(!trigger) return;
    trigger.addEventListener('click',function(){
      var isOpen = item.classList.contains('open');
      accItems.forEach(function(i){
        i.classList.remove('open');
        var t = i.querySelector('.ea-pg-acc-trigger');
        if(t) t.setAttribute('aria-expanded','false');
      });
      if(!isOpen){
        item.classList.add('open');
        trigger.setAttribute('aria-expanded','true');
      }
    });
  });

  /* --- Offset below fixed header --- */
  function eaOffsetHeader() {
    var hdr = document.getElementById('header');
    var wrap = document.getElementById('ea-wb-wrap');
    if (hdr && wrap) {
      wrap.style.marginTop = hdr.offsetHeight + 'px';
    }
  }
  eaOffsetHeader();
  window.addEventListener('resize', eaOffsetHeader);
  // Also run after fonts load which can change header height
  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(eaOffsetHeader);
  }

})();
</script>

</div>
<?php get_footer(); ?>

