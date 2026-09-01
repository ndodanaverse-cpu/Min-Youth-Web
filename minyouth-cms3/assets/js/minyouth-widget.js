/**
 * minyouth-widget.js
 * Self-contained language switcher + AI chatbot widget.
 * Drop one <script> tag before </body> to activate on any page.
 *
 * Language switching: reloads the page with ?lang=XX so the PHP
 * backend can set the cookie and serve translated content.
 *
 * Chatbot: POSTs to /chat.php (auto-detected from script src path).
 */
(function () {
  'use strict';

  /* =========================================================
     1. TRANSLATIONS (client-side UI strings for the widget)
     ========================================================= */
  const T = {
    en: {
      langLabel   : 'Language',
      chatTitle   : 'Ministry Assistant',
      chatSubtitle: 'Ministry of Youth Empowerment',
      welcome     : 'Hello! How can I help you today? I can answer questions about youth programmes, vocational training, and ministry services.',
      placeholder : 'Type your message…',
      send        : 'Send',
      thinking    : 'Typing…',
      error       : 'Sorry, I\'m having trouble connecting. Please try again.',
      open        : 'Chat with us',
      close       : 'Close chat',
      poweredBy   : 'Powered by AI',
      langEn      : 'English',
      langSn      : 'ChiShona',
      langNr      : 'Ndebele',
    },
    sn: {
      langLabel   : 'Mutauro',
      chatTitle   : 'Mubatsiri weHurumende',
      chatSubtitle: 'Mutsindo weMajaya',
      welcome     : 'Mhoro! Ndingakubatsira sei nhasi? Ndinogona kupindura mibvunzo nezve zvirongwa zvemajaya, kudzidziswa kwemabasa, uye zvevhura nehurumende.',
      placeholder : 'Nyora meseji yako…',
      send        : 'Tumira',
      thinking    : 'Achinyora…',
      error       : 'Ndinonzwisa urombo, pane dambudziko rokubatana. Edza zvakare.',
      open        : 'Taura nesu',
      close       : 'Vhara',
      poweredBy   : 'Inoshandiswa ne-AI',
      langEn      : 'English',
      langSn      : 'ChiShona',
      langNr      : 'Ndebele',
    },
    nr: {
      langLabel   : 'Ulimi',
      chatTitle   : 'Umsizi WeNdawo',
      chatSubtitle: 'UMnyango Wentsha',
      welcome     : 'Sawubona! Ngingakusiza ngani namuhla? Ngingaphendula imibuzo mayelana nezinhlelo zentsha, uqeqesho lwemisebenzi, kanye nezinsiza zikaHulumeni.',
      placeholder : 'Bhala umlayezo wakho…',
      send        : 'Thumela',
      thinking    : 'Iyabhala…',
      error       : 'Uxolo, kukhona inkinga yokuxhumana. Zama futhi.',
      open        : 'Khuluma lathi',
      close       : 'Vala',
      poweredBy   : 'Isebenziswa i-AI',
      langEn      : 'English',
      langSn      : 'ChiShona',
      langNr      : 'Ndebele',
    },
  };

  /* =========================================================
     2. HELPERS
     ========================================================= */
  const SUPPORTED = ['en', 'sn', 'nr'];
  const LANGUAGE_NAMES = { en: 'English', sn: 'Shona', nr: 'Ndebele' };

  function getCookie(name) {
    const m = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
    return m ? decodeURIComponent(m[1]) : null;
  }

  function getLang() {
    const c = getCookie('minyouth_lang') || localStorage.getItem('minyouth_lang') || 'en';
    return SUPPORTED.includes(c) ? c : 'en';
  }

  function setLang(code) {
    if (!SUPPORTED.includes(code)) return;
    // Let the PHP backend set the cookie and handle the redirect
    const url = new URL(window.location.href);
    url.searchParams.set('lang', code);
    window.location.href = url.toString();
  }

  function t(key) {
    const lang = getLang();
    return (T[lang] && T[lang][key]) ? T[lang][key] : (T.en[key] || key);
  }

  // Derive base URL from this script's own src attribute so the
  // chat endpoint works whether the site is at / or /minyouth/
  function getBaseUrl() {
    const me = document.currentScript
      || document.querySelector('script[src*="minyouth-widget"]');
    if (!me) return '';
    return me.src.replace(/\/assets\/js\/minyouth-widget\.js.*$/, '');
  }

  /* =========================================================
     3. INJECT STYLES
     ========================================================= */
  function injectStyles() {
    if (document.getElementById('myw-styles')) return;
    const css = `
      /* ---------- Language Switcher ---------- */
      /* ---------- Chatbot Bubble ---------- */
      #myw-bubble {
        position: fixed; bottom: 24px; right: 24px; z-index: 9999;
        width: 56px; height: 56px; border-radius: 50%;
        background: #008000; color: #fff;
        border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(0,128,0,.4);
        display: flex; align-items: center; justify-content: center;
        transition: transform .2s, box-shadow .2s;
        font-family: inherit;
      }
      #myw-bubble:hover { transform: scale(1.08); box-shadow: 0 6px 20px rgba(0,128,0,.5); }
        #myw-bubble .material-symbols-outlined { font-size: 28px; }

      /* ---------- Chatbot Panel ---------- */
      #myw-panel {
        position: fixed; bottom: 90px; right: 24px; z-index: 9999;
        width: 360px; max-width: calc(100vw - 32px);
        height: 520px; max-height: calc(100vh - 120px);
        background: #fff; border-radius: 16px;
        box-shadow: 0 8px 40px rgba(0,0,0,.18);
        display: flex; flex-direction: column; overflow: hidden;
        transform: scale(.85) translateY(20px); opacity: 0;
        pointer-events: none;
        transition: transform .25s cubic-bezier(.34,1.56,.64,1), opacity .2s;
        font-family: inherit;
      }
      #myw-panel.myw-open {
        transform: scale(1) translateY(0); opacity: 1; pointer-events: all;
      }

      /* Header */
      #myw-head {
        background: #008000; color: #fff; padding: 14px 16px;
        display: flex; align-items: center; gap: 10px; flex-shrink: 0;
      }
      #myw-avatar {
        width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
      }
      #myw-head-text { flex: 1; min-width: 0; }
      #myw-head-title { font-size: 14px; font-weight: 700; }
      #myw-head-sub   { font-size: 11px; opacity: .75; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
      #myw-close {
        background: rgba(255,255,255,.15); border: none; color: #fff;
        cursor: pointer; width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: background .15s;
        font-family: inherit;
      }
      #myw-close:hover { background: rgba(255,255,255,.3); }

      /* Language dropdown in the chat panel */
      #myw-lang-tabs { width: 100%; border: 0; border-bottom: 1px solid #d7f0d7; border-radius: 0; background: #f0f7f0; color: #3e4a41; padding: 8px 12px; font: 600 12px inherit; }

      /* Messages */
      #myw-msgs {
        flex: 1; overflow-y: auto; padding: 14px; display: flex;
        flex-direction: column; gap: 10px; scroll-behavior: smooth;
      }
      .myw-msg { display: flex; gap: 8px; max-width: 88%; animation: myw-in .2s ease; }
      .myw-msg.myw-user { align-self: flex-end; flex-direction: row-reverse; }
      .myw-msg.myw-bot  { align-self: flex-start; }
      .myw-bubble-icon {
        width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
        background: #d7f0d7; display: flex; align-items: center; justify-content: center;
        font-size: 13px; margin-top: 2px;
      }
      .myw-msg.myw-user .myw-bubble-icon { background: #e3f2fd; }
      .myw-text {
        padding: 9px 13px; border-radius: 14px; font-size: 13px; line-height: 1.5;
        word-break: break-word;
      }
      .myw-msg.myw-bot  .myw-text { background: #f6f3f2; color: #1c1b1b; border-bottom-left-radius: 4px; }
      .myw-msg.myw-user .myw-text { background: #008000; color: #fff; border-bottom-right-radius: 4px; }
      .myw-msg.myw-error .myw-text { background: #ffdad6; color: #93000a; }
      .myw-typing { display: flex; align-items: center; gap: 4px; padding: 9px 13px; background: #f6f3f2; border-radius: 14px; border-bottom-left-radius: 4px; }
      .myw-dot { width: 7px; height: 7px; background: #6e7a70; border-radius: 50%; animation: myw-bounce .9s ease infinite; }
      .myw-dot:nth-child(2) { animation-delay: .15s; }
      .myw-dot:nth-child(3) { animation-delay: .3s; }

      /* Input bar */
      #myw-bar {
        display: flex; gap: 8px; padding: 10px 12px;
        border-top: 1px solid #eae7e7; background: #fff; flex-shrink: 0;
      }
      #myw-input {
        flex: 1; border: 1px solid #bdcabe; border-radius: 20px;
        padding: 8px 14px; font-size: 13px; font-family: inherit;
        outline: none; resize: none; max-height: 80px; overflow-y: auto;
        transition: border-color .15s;
        line-height: 1.4;
      }
      #myw-input:focus { border-color: #008000; }
      #myw-send {
        width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
        background: #008000; color: #fff; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s, transform .1s; font-family: inherit;
      }
      #myw-send:hover { background: #006600; }
      #myw-send:active { transform: scale(.92); }
      #myw-send:disabled { background: #bdcabe; cursor: default; }
      #myw-powered { text-align: center; font-size: 10px; color: #6e7a70; padding: 3px 0 6px; flex-shrink: 0; }

      @keyframes myw-in { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:none; } }
      @keyframes myw-bounce { 0%,80%,100% { transform:scale(0); } 40% { transform:scale(1); } }

      @media (max-width: 420px) {
        #myw-panel { right: 12px; left: 12px; width: auto; bottom: 80px; }
        #myw-bubble { right: 12px; }
      }
    `;
    const el = document.createElement('style');
    el.id = 'myw-styles';
    el.textContent = css;
    document.head.appendChild(el);
  }

  /* =========================================================
     4. CHATBOT WIDGET
     ========================================================= */
  let chatHistory = [];
  let thinking    = false;
  const baseUrl   = getBaseUrl();

  function buildChatbot() {
    // Bubble toggle button
    const bubble = document.createElement('button');
    bubble.id = 'myw-bubble';
    bubble.setAttribute('aria-label', t('open'));
    bubble.setAttribute('title', t('open'));
      bubble.innerHTML = '<span class="material-symbols-outlined" aria-hidden="true">chat_bubble</span>';
    bubble.addEventListener('click', togglePanel);
    document.body.appendChild(bubble);

    // Panel
    const panel = document.createElement('div');
    panel.id = 'myw-panel';
    panel.setAttribute('aria-live', 'polite');
    panel.innerHTML = `
      <div id="myw-head">
        <div id="myw-avatar">🏛</div>
        <div id="myw-head-text">
          <div id="myw-head-title">${t('chatTitle')}</div>
          <div id="myw-head-sub">${t('chatSubtitle')}</div>
        </div>
        <button id="myw-close" aria-label="${t('close')}" title="${t('close')}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
          </svg>
        </button>
      </div>
      <select id="myw-lang-tabs" aria-label="${t('langLabel')}">
        ${SUPPORTED.map(c => `<option value="${c}" ${getLang()===c?'selected':''}>${LANGUAGE_NAMES[c]}</option>`).join('')}
      </select>
      <div id="myw-msgs" role="log" aria-label="Chat messages"></div>
      <div id="myw-bar">
        <textarea id="myw-input" rows="1" placeholder="${t('placeholder')}"
          aria-label="${t('placeholder')}"></textarea>
        <button id="myw-send" aria-label="${t('send')}" title="${t('send')}">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2z"/>
          </svg>
        </button>
      </div>
      <div id="myw-powered">${t('poweredBy')} • ${t('chatTitle')}</div>
    `;
    document.body.appendChild(panel);

    // Events
    panel.querySelector('#myw-close').addEventListener('click', closePanel);
    panel.querySelector('#myw-lang-tabs').addEventListener('change', event => setLang(event.target.value));

    const input  = panel.querySelector('#myw-input');
    const sendBtn = panel.querySelector('#myw-send');

    input.addEventListener('keydown', e => {
      if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });
    input.addEventListener('input', () => {
      input.style.height = 'auto';
      input.style.height = Math.min(input.scrollHeight, 80) + 'px';
    });
    sendBtn.addEventListener('click', sendMessage);

    // Welcome message
    addBotMessage(t('welcome'));
  }

  let panelOpen = false;
  function togglePanel() {
    panelOpen ? closePanel() : openPanel();
  }
  function openPanel() {
    panelOpen = true;
    document.getElementById('myw-panel').classList.add('myw-open');
    document.getElementById('myw-bubble').setAttribute('aria-label', t('close'));
    setTimeout(() => document.getElementById('myw-input').focus(), 250);
  }
  function closePanel() {
    panelOpen = false;
    document.getElementById('myw-panel').classList.remove('myw-open');
    document.getElementById('myw-bubble').setAttribute('aria-label', t('open'));
  }

  function addBotMessage(text, isError) {
    const msgs = document.getElementById('myw-msgs');
    const div  = document.createElement('div');
    div.className = 'myw-msg myw-bot' + (isError ? ' myw-error' : '');
    div.innerHTML = `<div class="myw-bubble-icon">🏛</div><div class="myw-text">${escHtml(text)}</div>`;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
  }

  function addUserMessage(text) {
    const msgs = document.getElementById('myw-msgs');
    const div  = document.createElement('div');
    div.className = 'myw-msg myw-user';
    div.innerHTML = `<div class="myw-bubble-icon">👤</div><div class="myw-text">${escHtml(text)}</div>`;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
  }

  let typingEl = null;
  function showTyping() {
    const msgs = document.getElementById('myw-msgs');
    typingEl = document.createElement('div');
    typingEl.className = 'myw-msg myw-bot';
    typingEl.innerHTML = `<div class="myw-bubble-icon">🏛</div><div class="myw-typing"><div class="myw-dot"></div><div class="myw-dot"></div><div class="myw-dot"></div></div>`;
    msgs.appendChild(typingEl);
    msgs.scrollTop = msgs.scrollHeight;
  }
  function hideTyping() {
    if (typingEl) { typingEl.remove(); typingEl = null; }
  }

  function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
              .replace(/\n/g,'<br>');
  }

  async function sendMessage() {
    if (thinking) return;
    const input = document.getElementById('myw-input');
    const text  = input.value.trim();
    if (!text) return;

    input.value = '';
    input.style.height = 'auto';
    document.getElementById('myw-send').disabled = true;

    addUserMessage(text);
    chatHistory.push({ role: 'user', content: text });

    thinking = true;
    showTyping();

    try {
      const res = await fetch(baseUrl + '/chat.php', {
        method : 'POST',
        headers: { 'Content-Type': 'application/json' },
        body   : JSON.stringify({ messages: chatHistory, lang: getLang() }),
      });
      const data = await res.json();
      hideTyping();

      if (data.error) {
        addBotMessage(data.error, true);
        chatHistory.pop(); // remove failed user turn
      } else {
        addBotMessage(data.reply);
        chatHistory.push({ role: 'assistant', content: data.reply });
      }
    } catch (err) {
      hideTyping();
      addBotMessage(t('error'), true);
      chatHistory.pop();
    }

    thinking = false;
    document.getElementById('myw-send').disabled = false;
    document.getElementById('myw-input').focus();
  }

  /* =========================================================
     6. BOOTSTRAP
     ========================================================= */
  function init() {
    injectStyles();
    buildChatbot();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
