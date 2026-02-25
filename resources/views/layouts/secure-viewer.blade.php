<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Document Viewer</title>
    <style>
        body {
            background-color: #525659;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none; /* IE 10 and IE 11 */
            user-select: none; /* Standard syntax */
        }

        .viewer-container {
            margin: 20px auto;
            position: relative;
        }

        .paper {
            background-color: white;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            position: relative;
            box-sizing: border-box;
            overflow: hidden; /* Ensure content doesn't spill out */
        }

        .watermark-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' version='1.1' height='100px' width='100px'><text transform='translate(20, 100) rotate(-45)' fill='rgba(0,0,0,0.05)' font-size='20'>CONFIDENTIAL</text></svg>");
            background-repeat: repeat;
        }
        
        /* Additional watermark text centered */
        .watermark-center {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            color: rgba(255, 0, 0, 0.1);
            pointer-events: none;
            z-index: 10000;
            white-space: nowrap;
            font-weight: bold;
            border: 5px solid rgba(255, 0, 0, 0.1);
            padding: 20px;
            border-radius: 20px;
        }

        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            z-index: 10001;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .back-button:hover {
            background-color: #555;
        }

        @media print {
            body {
                display: none !important;
            }
        }
        
        /* Overwrite PDF specific styles for screen */
        @page {
            margin: 0;
        }
        
        /* Ensure tables fit */
        table {
            max-width: 100%;
        }
    </style>
    @stack('styles')
</head>
<body oncontextmenu="return false;">

    <a href="{{ url()->previous() }}" class="back-button">
        &larr; Back to Dashboard
    </a>

    <div class="viewer-container">
        <div class="paper">
            <div class="watermark-overlay"></div>
            <div class="watermark-center">READ ONLY</div>
            @yield('content')
        </div>
    </div>

    <script>
        // Disable keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+P (Print)
            if (e.ctrlKey && (e.key === 'p' || e.key === 'P')) {
                e.preventDefault();
                alert('Printing is disabled for this document.');
                return false;
            }
            // Ctrl+S (Save)
            if (e.ctrlKey && (e.key === 's' || e.key === 'S')) {
                e.preventDefault();
                alert('Saving is disabled for this document.');
                return false;
            }
            // Ctrl+Shift+I (DevTools) - optional but good
            if (e.ctrlKey && e.shiftKey && (e.key === 'i' || e.key === 'I')) {
                e.preventDefault();
                return false;
            }
        });

        // Disable right click context menu
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
</body>
</html>