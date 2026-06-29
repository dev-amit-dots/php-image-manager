<?php
/**
 * Main Interface
 * A beautiful, premium UI for uploading images.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Image Optimization & Watermarking</title>
    <meta name="description" content="Upload, optimize, and automatically watermark your images with our advanced Core PHP processing system.">
    
    <!-- Modern Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #0f172a; /* Slate 900 */
            --card-bg: rgba(30, 41, 59, 0.7); /* Slate 800 with opacity for glassmorphism */
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #3b82f6; /* Blue 500 */
            --primary-hover: #2563eb;
            --success: #10b981;
            --error: #ef4444;
            --border-color: rgba(255, 255, 255, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 600px;
            position: relative;
        }

        /* Glassmorphism Card */
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6);
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.subtitle {
            text-align: center;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            font-size: 0.95rem;
        }

        /* Drag & Drop Area */
        .upload-area {
            border: 2px dashed rgba(96, 165, 250, 0.4);
            border-radius: 16px;
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(15, 23, 42, 0.4);
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover, .upload-area.dragover {
            border-color: var(--primary);
            background: rgba(59, 130, 246, 0.1);
        }

        .upload-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .upload-area:hover .upload-icon {
            transform: translateY(-5px);
        }

        .upload-text {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .upload-hint {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        input[type="file"] {
            display: none;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            margin-top: 1.5rem;
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0.7;
            pointer-events: none;
        }

        .btn-submit.active {
            opacity: 1;
            pointer-events: auto;
        }

        .btn-submit.active:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(99, 102, 241, 0.8);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Status Messages */
        .status-msg {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 500;
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .status-msg.error {
            display: block;
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .status-msg.success {
            display: block;
            background: rgba(16, 185, 129, 0.1);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        /* Loader */
        .loader {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin: 0 auto;
        }

        /* Result Area */
        .result-preview {
            display: none;
            margin-top: 2rem;
            text-align: center;
            animation: slideUp 0.5s ease;
        }

        .result-preview img {
            max-width: 100%;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .result-preview img:hover {
            transform: scale(1.02);
        }

        .result-links {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        .result-links a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        .result-links a:hover {
            color: #93c5fd;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Background blur circles for premium effect */
        .bg-shape {
            position: absolute;
            filter: blur(100px);
            z-index: -1;
            border-radius: 50%;
        }
        .shape-1 {
            width: 400px;
            height: 400px;
            background: rgba(59, 130, 246, 0.2);
            top: -100px;
            left: -150px;
        }
        .shape-2 {
            width: 300px;
            height: 300px;
            background: rgba(139, 92, 246, 0.2);
            bottom: -50px;
            right: -100px;
        }
    </style>
</head>
<body>

    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="container">
        <main class="card">
            <h1>Upload & Watermark</h1>
            <p class="subtitle">Securely compress, resize, and brand your images.</p>

            <form id="uploadForm" enctype="multipart/form-data">
                <div class="upload-area" id="dropZone">
                    <span class="upload-icon">☁️</span>
                    <p class="upload-text" id="fileNameDisplay">Click to browse or drag file here</p>
                    <p class="upload-hint">Supports JPG, PNG, WebP (Max 5MB)</p>
                    <input type="file" id="fileInput" name="image" accept=".jpg,.jpeg,.png,.webp" required>
                </div>

                <button type="submit" id="submitBtn" class="btn-submit">
                    <span class="btn-text">Process Image</span>
                    <div class="loader" id="btnLoader"></div>
                </button>
            </form>

            <div id="statusMessage" class="status-msg"></div>

            <div class="result-preview" id="resultArea">
                <p style="margin-bottom: 1rem; color: #6ee7b7; font-weight: 600;">Processing Complete!</p>
                <img id="resultImage" src="" alt="Watermarked Result">
                <div class="result-links">
                    <a id="linkOptimized" href="#" target="_blank">View Optimized</a>
                    <span>|</span>
                    <a id="linkWatermark" href="#" target="_blank">View Watermarked</a>
                </div>
            </div>
        </main>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const submitBtn = document.getElementById('submitBtn');
        const uploadForm = document.getElementById('uploadForm');
        const statusMessage = document.getElementById('statusMessage');
        const btnText = document.querySelector('.btn-text');
        const btnLoader = document.getElementById('btnLoader');
        const resultArea = document.getElementById('resultArea');
        const resultImage = document.getElementById('resultImage');
        const linkOptimized = document.getElementById('linkOptimized');
        const linkWatermark = document.getElementById('linkWatermark');

        // Drag & Drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if(files.length) {
                fileInput.files = files;
                handleFileSelect();
            }
        });

        dropZone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', handleFileSelect);

        function handleFileSelect() {
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                fileNameDisplay.textContent = file.name;
                submitBtn.classList.add('active');
                
                // Basic frontend validation
                if (file.size > 5 * 1024 * 1024) {
                    showStatus('File size exceeds 5MB limit.', 'error');
                    submitBtn.classList.remove('active');
                } else {
                    statusMessage.style.display = 'none';
                }
            } else {
                fileNameDisplay.textContent = 'Click to browse or drag file here';
                submitBtn.classList.remove('active');
            }
        }

        function showStatus(msg, type) {
            statusMessage.textContent = msg;
            statusMessage.className = 'status-msg ' + type;
        }

        uploadForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!fileInput.files.length) return;

            // UI Loading state
            btnText.style.display = 'none';
            btnLoader.style.display = 'block';
            submitBtn.style.pointerEvents = 'none';
            statusMessage.style.display = 'none';
            resultArea.style.display = 'none';

            const formData = new FormData();
            formData.append('image', fileInput.files[0]);

            try {
                const response = await fetch('upload_process.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();

                if (data.success) {
                    showStatus('Image optimized and watermarked successfully!', 'success');
                    
                    // Show result
                    resultImage.src = data.watermark + '?t=' + new Date().getTime(); // cache bust
                    linkOptimized.href = data.optimized;
                    linkWatermark.href = data.watermark;
                    resultArea.style.display = 'block';
                    
                    // Reset form
                    uploadForm.reset();
                    fileNameDisplay.textContent = 'Click to browse or drag file here';
                    submitBtn.classList.remove('active');
                } else {
                    showStatus(data.error || 'Upload failed.', 'error');
                }
            } catch (error) {
                showStatus('An unexpected error occurred.', 'error');
            } finally {
                // Restore UI
                btnText.style.display = 'block';
                btnLoader.style.display = 'none';
                submitBtn.style.pointerEvents = 'auto';
            }
        });
    </script>
</body>
</html>