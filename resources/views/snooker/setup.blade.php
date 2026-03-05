@extends('layouts.app')

@section('content')
<div class="setup-container">
    <div class="setup-form">
        <!-- Header -->
        <div class="header">
            <h1>🎱 Snooker Match Setup</h1>
            <p>Create a new match and generate links</p>
        </div>


        <form id="setupForm">
            @csrf

            <!-- Player Selection -->
            <div class="form-section">
                <div class="section-title">Add Players</div>
                <div class="player-selection">
                    <div class="player-selector">
                        <label class="player-label">Player 1</label>
                        <input
                            type="text"
                            name="player_1"
                            class="player-input"
                            placeholder="Player 1"
                        >
                    </div>
                    <div class="player-selector">
                        <label class="player-label">Player 2</label>
                        <input
                            type="text"
                            name="player_2"
                            class="player-input"
                            placeholder="Player 2"
                        >
                    </div>
                </div>
            </div>

            <!-- Table Number -->
            <div class="form-section">
                <div class="section-title">Table Information</div>
                <div>
                    <label class="player-label">Table Number (Optional)</label>
                    <input
                        type="text"
                        id="tableNumber"
                        name="table_number"
                        class="player-input"
                        placeholder="e.g., TABLE 1"
                        value="TABLE 1"
                    >
                </div>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    ✓ Create Match & Generate Links
                </button>
                <button type="reset" class="btn btn-secondary" onclick="resetForm()">
                    ↻ Reset
                </button>
            </div>

            <div id="errorAlert" class="alert alert-danger" style="display: none;"></div>
        </form>

        <!-- Generated Links -->
        <div id="linksSection" class="links-section">
            <div class="section-title">Generated Links</div>

            <div class="links-grid">
                <!-- Remote Control Link -->
                <div class="link-card">
                    <div class="link-title">🎮 Remote Control</div>
                    <div class="link-display" id="remoteLink">
                        #
                    </div>
                    <div class="link-buttons">
                        <button class="link-btn" onclick="copyToClipboard('remoteLink')">Copy</button>
                        <button class="link-btn" onclick="openLink('remoteLink')">Open</button>
                    </div>
                </div>

                <!-- LCD Display Link -->
                <div class="link-card">
                    <div class="link-title">📺 LCD Display</div>
                    <div class="link-display" id="lcdLink">
                        #
                    </div>
                    <div class="link-buttons">
                        <button class="link-btn" onclick="copyToClipboard('lcdLink')">Copy</button>
                        <button class="link-btn" onclick="openLink('lcdLink')">Open</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #1a472a;
        --primary-light: rgba(26, 71, 42, 0.15);
        --accent: #2ecc71;
        --accent-dark: #27ae60;
        --bg-dark: #0f1419;
        --bg-darker: #1a1f26;
        --text-primary: #ffffff;
        --text-secondary: #e0e0e0;
        --text-tertiary: #888888;
        --border-color: rgba(46, 204, 113, 0.3);
        --shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-darker) 100%);
        color: var(--text-primary);
        line-height: 1.6;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .setup-container {
        max-width: 1000px;
        width: 100%;
    }

    .header {
        text-align: center;
        margin-bottom: 50px;
    }

    .header h1 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 10px;
        background: linear-gradient(135deg, var(--accent) 0%, #2ecc71 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .header p {
        font-size: 16px;
        color: var(--text-tertiary);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 600;
    }

    .setup-form {
        background: linear-gradient(135deg, var(--bg-darker) 0%, #1e2633 100%);
        border: 2px solid var(--border-color);
        border-radius: 20px;
        padding: 40px;
        box-shadow: var(--shadow);
    }

    .form-section {
        margin-bottom: 40px;
    }

    .form-section:last-of-type {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::before {
        content: '';
        width: 3px;
        height: 20px;
        background: var(--accent);
        border-radius: 2px;
    }

    .player-selection {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .player-selector {
        display: flex;
        flex-direction: column;
    }

    .player-label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .player-input {
        padding: 15px;
        background: rgba(46, 204, 113, 0.05);
        border: 2px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-primary);
        font-size: 16px;
        transition: all 0.3s;
        font-weight: 600;
    }

    .player-input:focus {
        outline: none;
        border-color: var(--accent);
        background: rgba(46, 204, 113, 0.1);
        box-shadow: 0 0 20px rgba(46, 204, 113, 0.2);
    }

    .match-format {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .format-option {
        position: relative;
    }

    .format-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .format-label {
        display: block;
        padding: 15px;
        background: rgba(46, 204, 113, 0.05);
        border: 2px solid var(--border-color);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        font-weight: 600;
        user-select: none;
    }

    .format-option input[type="radio"]:checked + .format-label {
        background: rgba(46, 204, 113, 0.2);
        border-color: var(--accent);
        box-shadow: 0 0 20px rgba(46, 204, 113, 0.2);
    }

    .format-label:hover {
        border-color: var(--accent);
    }

    .info-box {
        background: rgba(46, 204, 113, 0.05);
        border-left: 4px solid var(--accent);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .info-icon {
        font-size: 24px;
        min-width: 24px;
    }

    .info-text {
        flex: 1;
    }

    .info-title {
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--accent);
    }

    .info-desc {
        font-size: 14px;
        color: var(--text-tertiary);
    }

    .button-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .btn {
        padding: 16px 30px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
        color: var(--bg-dark);
        box-shadow: 0 10px 30px rgba(46, 204, 113, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(46, 204, 113, 0.4);
    }

    .btn-primary:active {
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: rgba(46, 204, 113, 0.1);
        color: var(--accent);
        border: 2px solid var(--accent);
    }

    .btn-secondary:hover {
        background: rgba(46, 204, 113, 0.2);
        transform: translateY(-3px);
    }

    .links-section {
        display: none;
        margin-top: 40px;
        padding-top: 40px;
        border-top: 2px solid var(--border-color);
    }

    .links-section.active {
        display: block;
    }

    .links-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .link-card {
        background: rgba(46, 204, 113, 0.05);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s;
    }

    .link-card:hover {
        border-color: var(--accent);
        background: rgba(46, 204, 113, 0.1);
    }

    .link-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .link-display {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        padding: 12px;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 13px;
        color: var(--accent);
        word-break: break-all;
        margin-bottom: 10px;
    }

    .link-buttons {
        display: flex;
        gap: 10px;
    }

    .link-btn {
        flex: 1;
        padding: 10px;
        background: rgba(46, 204, 113, 0.2);
        border: 1px solid var(--accent);
        color: var(--accent);
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.3s;
        text-transform: uppercase;
    }

    .link-btn:hover {
        background: rgba(46, 204, 113, 0.3);
        transform: translateY(-2px);
    }

    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: rgba(231, 76, 60, 0.15);
        border: 1px solid rgba(231, 76, 60, 0.3);
        color: #ff6b6b;
    }

    @media (max-width: 768px) {
        .header h1 {
            font-size: 36px;
        }

        .setup-form {
            padding: 25px;
        }

        .player-selection {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .match-format {
            grid-template-columns: repeat(2, 1fr);
        }

        .button-group {
            grid-template-columns: 1fr;
        }

        .links-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    const setupForm = document.getElementById('setupForm');

    setupForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(setupForm);
        const errorAlert = document.getElementById('errorAlert');

        try {
            const response = await fetch("{{ route('snooker.create') }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                errorAlert.style.display = 'block';
                errorAlert.textContent = Object.values(data.errors || {}).flat().join(', ') || 'An error occurred';
                return;
            }

            // Update links
            document.getElementById('remoteLink').textContent = data.remote_url;
            document.getElementById('lcdLink').textContent = data.lcd_url;

            // Show links section
            document.getElementById('linksSection').classList.add('active');
            errorAlert.style.display = 'none';

        } catch (error) {
            errorAlert.style.display = 'block';
            errorAlert.textContent = 'An error occurred. Please try again.';
            console.error('Error:', error);
        }
    });

    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        const text = element.textContent;

        navigator.clipboard.writeText(text).then(() => {
            alert('Link copied to clipboard!');
        }).catch(() => {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            alert('Link copied to clipboard!');
        });
    }

    function openLink(elementId) {
        const element = document.getElementById(elementId);
        const link = element.textContent;
        if (link !== '#') {
            window.open(link, '_blank');
        }
    }

    function resetForm() {
        setupForm.reset();
        document.getElementById('linksSection').classList.remove('active');
        document.getElementById('errorAlert').style.display = 'none';
    }
</script>
@endsection
