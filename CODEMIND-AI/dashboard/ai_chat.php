<?php
require_once "../config/auth.php";

$conversation_id = $_SESSION['conversation_id'] ?? 0;
$nama = $_SESSION['nama'] ?? "User";
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CodeMind AI | AI Chat</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/ai_chat.css">
<link rel="stylesheet" href="../assets/css/code_block.css">
<link rel="stylesheet" href="../assets/css/project_tree.css">
<link rel="stylesheet" href="../assets/css/markdown.css">
<link rel="stylesheet" href="../assets/css/explorer.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/github-dark.min.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<input
type="hidden"
id="conversation_id"
value="<?= $conversation_id ?>">

<div class="wrapper">

    <!-- ========================================= -->
    <!-- SIDEBAR -->
    <!-- ========================================= -->

    <aside class="sidebar">

        <div class="logo">

            <div class="logo-icon">
                💻
            </div>

            <div>

                <h3>CodeMind AI</h3>

                <small>Programming Assistant</small>

            </div>

        </div>

        <nav>

            <a href="dashboard.php">

                <i class="fa-solid fa-house"></i>

                <span>Dashboard</span>

            </a>

            <a href="ai_chat.php" class="active">

                <i class="fa-solid fa-robot"></i>

                <span>AI Chat</span>

            </a>

            <a href="history.php">

                <i class="fa-solid fa-clock-rotate-left"></i>

                <span>History</span>

            </a>

            <a href="profile.php">

                <i class="fa-solid fa-user"></i>

                <span>Profile</span>

            </a>

            <a href="settings.php">

                <i class="fa-solid fa-gear"></i>

                <span>Settings</span>

            </a>

        </nav>

        <div class="sidebar-user">

            <div class="avatar">

                <?= strtoupper(substr($nama,0,1)); ?>

            </div>

            <div>

                <div class="user-name">

                    <?= htmlspecialchars($nama) ?>

                </div>

                <div class="user-role">

                    Developer

                </div>

            </div>

        </div>

        <a href="../logout.php" class="logout">

            <i class="fa-solid fa-right-from-bracket"></i>

            Logout

        </a>

    </aside>

    <!-- ========================================= -->
    <!-- MAIN -->
    <!-- ========================================= -->

    <main class="main-content">

        <!-- HEADER -->

        <header class="top-header">

            <div class="header-left">

                <h2>

                    🤖 CodeMind AI

                </h2>

                <span>

                    Intelligent Programming Assistant

                </span>

            </div>

            <div class="header-right">

                <select
                    id="mode"
                    class="form-select mode-select">

                    <option value="chat">

                        💬 AI Chat

                    </option>

                    <option value="website">

                        🌐 Website Generator

                    </option>

                    <option value="generate">

                        ⚡ Generate Code

                    </option>

                    <option value="analyze">

                        🔍 Code Analyzer

                    </option>

                    <option value="convert">

                        🔄 Convert Code

                    </option>

                    <option value="documentation">

                        📚 Documentation

                    </option>

                </select>

            </div>

        </header>

        <!-- WORKSPACE -->

        <section class="workspace">

            <!-- ========================================= -->
            <!-- PROJECT EXPLORER -->
            <!-- ========================================= -->

            <aside class="explorer">

                <div class="explorer-header">

                    <i class="fa-solid fa-folder-tree"></i>

                    <span>Explorer</span>

                </div>

                <div id="fileTree">

                    <div class="empty-state">

                        <i class="fa-solid fa-folder-open"></i>

                        <p>

                            Belum ada project

                        </p>

                        <small>

                            Gunakan Website Generator untuk membuat project baru.

                        </small>

                    </div>

                </div>

            </aside>

            <!-- ========================================= -->
            <!-- AI CHAT -->
            <!-- ========================================= -->

            <section class="chat-panel">
                                <!-- ========================================= -->
                <!-- CHAT HEADER -->
                <!-- ========================================= -->

                <div class="chat-header">

                    <div class="chat-title">

                        <i class="fa-solid fa-comments"></i>

                        <div>

                            <h4>

                                AI Assistant

                            </h4>

                            <small>

                                Chat dengan Gemini AI

                            </small>

                        </div>

                    </div>

                    <div class="chat-action">

                        <button
                            class="btn btn-sm btn-outline-light"
                            onclick="clearChat()">

                            <i class="fa-solid fa-trash"></i>

                            Clear

                        </button>

                    </div>

                </div>

                <!-- ========================================= -->
                <!-- CHAT BOX -->
                <!-- ========================================= -->

                <div
                    id="chatBox"
                    class="chat-box">

                </div>

                <!-- ========================================= -->
                <!-- CHAT INPUT -->
                <!-- ========================================= -->

                <div class="chat-input">

                    <textarea

                        id="prompt"

                        class="form-control"

                        rows="4"

                        placeholder="Tulis prompt... Contoh : Buatkan Landing Page Modern"

                    ></textarea>

                    <div class="input-toolbar">

                        <div class="toolbar-left">

                            <span>

                                Enter = Kirim

                            </span>

                            <span>

                                Shift + Enter = Baris Baru

                            </span>

                        </div>

                        <button

                            id="sendBtn"

                            type="button"

                            class="btn btn-primary">

                            <i class="fa-solid fa-paper-plane"></i>

                            Kirim

                        </button>

                    </div>

                </div>

            </section>

            <!-- ========================================= -->
            <!-- CODE EDITOR -->
            <!-- ========================================= -->

            <aside class="editor-panel">

                <div class="editor-header">

                    <div class="editor-title">

                        <i class="fa-solid fa-code"></i>

                        <span>

                            Code Editor

                        </span>

                    </div>

                    <div class="editor-action">

                        <button

                            class="btn btn-sm btn-success"

                            onclick="copyCurrentCode()">

                            <i class="fa-solid fa-copy"></i>

                            Copy

                        </button>

                    </div>

                </div>

                <!-- ========================================= -->
                <!-- FILE TABS -->
                <!-- ========================================= -->

                <div class="editor-tabs">

                    <div class="tab active">

                        index.html

                    </div>

                    <div class="tab">

                        style.css

                    </div>

                    <div class="tab">

                        script.js

                    </div>

                </div>

                <!-- ========================================= -->
                <!-- CODE VIEWER -->
                <!-- ========================================= -->

                <div id="codeViewer">

                    <pre style="margin:0;">

<code
id="codeEditorContent"
class="language-html"></code>

                    </pre>

                </div>
                      <!-- ========================================= -->
                <!-- END CODE VIEWER -->
                <!-- ========================================= -->

            </aside>

        </section>

        <!-- ========================================= -->
        <!-- LIVE PREVIEW -->
        <!-- ========================================= -->

        <section class="preview-panel">

            <div class="preview-header">

                <div class="preview-title">

                    <i class="fa-solid fa-globe"></i>

                    <span>

                        Live Preview

                    </span>

                </div>

                <div class="preview-action">

                    <button
                        class="btn btn-sm btn-outline-light"
                        onclick="document.getElementById('previewFrame').contentWindow.location.reload();">

                        <i class="fa-solid fa-rotate-right"></i>

                        Refresh

                    </button>

                </div>

            </div>

            <div class="preview-body">

                <iframe

                    id="previewFrame"

                    title="Live Preview"

                    loading="lazy">

                </iframe>

            </div>

        </section>

    </main>

</div>

<!-- ========================================= -->
<!-- HIGHLIGHT JS -->
<!-- ========================================= -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js"></script>

<script>

document.addEventListener("DOMContentLoaded",function(){

    if(window.hljs){

        hljs.highlightAll();

    }

});

</script>

<!-- ========================================= -->
<!-- WEBSITE GENERATOR -->
<!-- ========================================= -->

<script src="../assets/js/website_generator.js"></script>

<!-- ========================================= -->
<!-- COPY CODE -->
<!-- ========================================= -->

<script src="../assets/js/copy_code.js"></script>

<!-- ========================================= -->
<!-- SYNTAX HIGHLIGHT -->
<!-- ========================================= -->

<script src="../assets/js/syntax_highlight.js"></script>

<!-- ========================================= -->
<!-- MARKDOWN -->
<!-- ========================================= -->

<script src="../assets/js/markdown.js"></script>

<!-- ========================================= -->
<!-- STREAM GEMINI -->
<!-- ========================================= -->

<script src="../assets/js/stream.js"></script>

<!-- ========================================= -->
<!-- AI CHAT -->
<!-- ========================================= -->

<script src="../assets/js/ai_chat.js"></script>

</body>

</html>          